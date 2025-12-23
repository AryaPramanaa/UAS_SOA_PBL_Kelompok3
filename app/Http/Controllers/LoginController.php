<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $user = Auth::user();

                // Cek status mahasiswa
                if ($user->role === 'mahasiswa' && $user->status !== 'Aktif') {
                    Auth::logout();
                    return back()->withErrors([
                        'Akun Anda belum aktif. Silakan hubungi operator.'
                    ]);
                }

                // Regenerate session
                $request->session()->regenerate();
                // Buat token sementara untuk dicatat di log
                $token = $user->createToken('login-token')->plainTextToken;

                // Catat login di log beserta token 
                Log::info('Login sukses untuk user ' . $user->username, [
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'token' => $token,
                ]);

                return redirect()->intended('/dashboard/' . $user->username);
            }

            return back()->withErrors([
                'username' => 'Username atau password salah',
            ]);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat login. Silakan coba lagi.'
            ]);
        }
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
        $user = Auth::user();
        $revoked = 0;

        if ($user) {
            try {
                // Revoke all personal access tokens for the user
                $revoked = $user->tokens()->delete();
            } catch (\Exception $e) {
                Log::warning('Gagal merevokasi token saat logout untuk user ' . $user->username, ['exception' => $e]);
            }

            Log::info('Logout untuk user ' . $user->username, [
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'revoked_tokens' => $revoked,
            ]);
        } else {
            Log::info('Logout dipanggil tanpa user yang terautentikasi.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
