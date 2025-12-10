<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');
        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $remember)) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->role === 'mahasiswa' && $user->status !== 'Aktif') {
                \Illuminate\Support\Facades\Auth::logout();
                return back()->withErrors(['Akun Anda belum aktif. Silakan hubungi operator.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/' . $user->username);
        }
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }

    public function redirect($username)
    {
        if (!Auth::check()) {
            return redirect('/entry');
        }

        $user = Auth::user();
        
        if ($user->username !== $username) {
            return redirect('/entry');
        }

        switch ($user->role) {
            case 'perusahaan':
                return redirect()->route('perusahaan.lowonganPKL.index');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.lowonganPKL.index');
            case 'operator':
                return redirect()->route('operator.lowonganPKL.index');
            case 'kaprodi':
                return redirect()->route('kaprodi.pengajuanPKL.index');
            case 'pimpinan':
                return redirect()->route('pimpinan.rekapMahasiswaPKL.index');
            default:
                return redirect('/');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
