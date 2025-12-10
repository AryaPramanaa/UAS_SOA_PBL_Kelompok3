<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProdiProfilController extends Controller
{
    public function edit()
    {
        $prodi = Prodi::where('user_id', Auth::id())->first();

        // Jika belum ada, cari berdasarkan nama_kaprodi, lalu update user_id
        if (!$prodi) {
            $prodi = Prodi::where('nama_kaprodi', Auth::user()->username)->first();
            if ($prodi) {
                $prodi->user_id = Auth::id();
                $prodi->save();
            }
        }

        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan.');
        }
        return view('backend.kaprodi.profil.edit', compact('prodi'));
    }

    public function update(Request $request)
    {
        $prodi = Prodi::where('user_id', Auth::id())->first();

        // Jika belum ada, cari berdasarkan nama_kaprodi, lalu update user_id
        if (!$prodi) {
            $prodi = Prodi::where('nama_kaprodi', Auth::user()->username)->first();
            if ($prodi) {
                $prodi->user_id = Auth::id();
                $prodi->save();
            }
        }

        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan.');
        }
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'nama_prodi' => 'required|string|max:255|unique:prodis,nama_prodi,' . $prodi->id,
            'nama_kaprodi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
        ]);
        $validated['user_id'] = Auth::id();
        try {
            // Update username di tabel users
            $user = Auth::user();
            if ($user->username !== $validated['username']) {
                $user->username = $validated['username'];
                $user->save();
            }
            $prodi->update($validated);
            return redirect()->route('kaprodi.profil.edit')->with('success', 'Profil prodi & username berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'new_password_confirmation.required' => 'Konfirmasi password baru wajib diisi.',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('kaprodi.profil.edit')->with('success', 'Password berhasil diperbarui.');
    }
}
