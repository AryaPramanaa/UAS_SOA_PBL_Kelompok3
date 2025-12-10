<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerusahaanProfilController extends Controller
{
    // Hapus method create dan store
    // Pada method edit, jika data perusahaan tidak ditemukan, tampilkan pesan error saja
    public function edit()
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->first();
        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Data perusahaan tidak ditemukan. Silakan hubungi operator.');
        }
        return view('backend.perusahaan.profil.edit', compact('perusahaan'));
    }

    public function update(Request $request)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->first();
        
        if (!$perusahaan) {
            return redirect()->back()->with('error', 'Data perusahaan tidak ditemukan.');
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'nama_perusahaan' => 'required|string|max:255|unique:perusahaans,nama_perusahaan,' . $perusahaan->id,
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'status_kerjasama' => 'required|in:Aktif,Tidak Aktif',
        ]);

        try {
            // Update username di tabel users
            $user = Auth::user();
            if ($user->username !== $validated['username']) {
                $user->username = $validated['username'];
                $user->save();
            }
            $perusahaan->update($validated);
            return redirect()->route('perusahaan.profil.edit')->with('success', 'Profil perusahaan & username berhasil diperbarui.');
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

        return redirect()->route('perusahaan.profil.edit')->with('success', 'Password berhasil diperbarui.');
    }
}
