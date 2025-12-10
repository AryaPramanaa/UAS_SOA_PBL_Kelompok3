<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MahasiswaProfilController extends Controller
{
    public function edit()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        $prodis = Prodi::all();
        return view('backend.mahasiswa.profil.edit', compact('mahasiswa', 'prodis'));
    }

    public function update(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'nim' => 'required|string|max:50|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'status_aktif' => 'nullable|in:Aktif,Non-Aktif',
            'alamat' => 'required|string',
            'semester' => 'required|integer|min:1|max:14',
            'ktm' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'prodi_id' => 'required|exists:prodis,id',
        ]);
        try {
            $changes = [];
            
            // Update username di tabel users
            $user = Auth::user();
            if ($user->username !== $validated['username']) {
                $user->username = $validated['username'];
                $user->save();
                $changes[] = 'username';
            }
            
            // Handle KTM file upload if provided
            if ($request->hasFile('ktm')) {
                Log::info('KTM upload detected for mahasiswa: ' . $mahasiswa->nim);
                Log::info('Old KTM path: ' . $mahasiswa->ktm);
                
                // Delete old KTM file if exists
                if ($mahasiswa->ktm && Storage::exists($mahasiswa->ktm)) {
                    Storage::delete($mahasiswa->ktm);
                    Log::info('Old KTM file deleted: ' . $mahasiswa->ktm);
                }
                
                $ktmFile = $request->file('ktm');
                $ktmFileName = time() . '_' . $request->nim . '_KTM.' . $ktmFile->getClientOriginalExtension();
                $ktmPath = $ktmFile->storeAs('public/ktm', $ktmFileName);
                $validated['ktm'] = $ktmPath;
                $changes[] = 'KTM';
                
                Log::info('New KTM uploaded: ' . $ktmPath);
                Log::info('New KTM file size: ' . $ktmFile->getSize());
            } else {
                Log::info('No KTM file uploaded');
            }
            
            // Check if other profile data changed
            $originalData = $mahasiswa->toArray();
            $mahasiswa->update($validated);
            $newData = $mahasiswa->fresh()->toArray();
            
            // Check for changes in profile data (excluding KTM which is handled above)
            $profileFields = ['nim', 'nama', 'no_hp', 'status_aktif', 'alamat', 'semester', 'prodi_id'];
            foreach ($profileFields as $field) {
                if (isset($originalData[$field]) && isset($newData[$field]) && $originalData[$field] != $newData[$field]) {
                    $changes[] = 'data profil';
                    break; // Only add once if any profile data changed
                }
            }
            
            Log::info('Mahasiswa profile updated. New KTM path: ' . $mahasiswa->fresh()->ktm);
            
            // Generate success message based on changes
            if (empty($changes)) {
                $message = 'Tidak ada perubahan data.';
            } else {
                $message = 'Berhasil mengubah: ' . implode(', ', $changes) . '.';
            }
            
            return redirect()->route('mahasiswa.profil.edit')->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error updating mahasiswa profile: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
