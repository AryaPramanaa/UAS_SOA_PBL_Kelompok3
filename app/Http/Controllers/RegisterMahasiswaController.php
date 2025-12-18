<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterMahasiswaController extends Controller
{
    public function showRegistrationForm()
    {
        $prodis = Prodi::all();
        return view('auth.register_mahasiswa', compact('prodis'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'nama' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'semester' => 'required|integer',
            'ktm' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        // Use DB transaction and try/catch for safety
        \Illuminate\Support\Facades\DB::beginTransaction();
        $ktmPath = null;
        try {
            // Handle KTM file upload
            if ($request->hasFile('ktm')) {
                $ktmFile = $request->file('ktm');
                $ktmFileName = time() . '_' . $request->nim . '_KTM.' . $ktmFile->getClientOriginalExtension();
                $ktmPath = $ktmFile->storeAs('public/ktm', $ktmFileName);
            }

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa',
                'status' => 'Non Aktif',
            ]);

            Mahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'status_aktif' => 'Aktif',
                'alamat' => $request->alamat,
                'semester' => $request->semester,
                'ktm' => $ktmPath,
                'prodi_id' => $request->prodi_id,
                'user_id' => $user->id,
            ]);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda akan diaktifkan oleh operator.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();

            // Remove uploaded file if something went wrong
            if ($ktmPath && \Illuminate\Support\Facades\Storage::exists($ktmPath)) {
                \Illuminate\Support\Facades\Storage::delete($ktmPath);
            }

            // Log the exception
            \Illuminate\Support\Facades\Log::error('Registration error: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi atau hubungi admin.']);
        }
    }
} 