<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class akunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search by username or email
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return view('backend.operator.Akun.index', compact('users'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::all();
        $prodis = Prodi::whereNull('user_id')->get();
        return view('backend.operator.Akun.create', compact('perusahaans', 'prodis'));
    }

    public function store(Request $request)
    {
        // Hilangkan prodi_id dari $request jika bukan kaprodi
        if ($request->role !== 'kaprodi') {
            $request->request->remove('prodi_id');
        }
        if ($request->role !== 'perusahaan') {
            $request->request->remove('id_perusahaan');
        }
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:mahasiswa,perusahaan,kaprodi,pimpinan,operator',
            'status' => 'required|string|in:Aktif,Non-Aktif',
            'id_perusahaan' => 'required_if:role,perusahaan|exists:perusahaans,id',
            'prodi_id' => 'required_if:role,kaprodi|exists:prodis,id',
            'nim' => 'required_if:role,mahasiswa|exists:mahasiswas,nim',
        ]);
        
        // Validasi hanya satu akun per perusahaan
        if ($request->role === 'perusahaan' && $request->id_perusahaan) {
            $exists = \App\Models\User::where('role', 'perusahaan')->where('id_perusahaan', $request->id_perusahaan)->exists();
            $perusahaan = \App\Models\Perusahaan::find($request->id_perusahaan);
            if ($exists || ($perusahaan && $perusahaan->user_id)) {
                return back()->withErrors(['id_perusahaan' => 'Akun untuk perusahaan ini sudah ada!'])->withInput();
            }
        }
        // Validasi hanya satu akun kaprodi per prodi
        if ($request->role === 'kaprodi' && $request->prodi_id) {
            $exists = \App\Models\User::where('role', 'kaprodi')->where('prodi_id', $request->prodi_id)->exists();
            $prodi = \App\Models\Prodi::find($request->prodi_id);
            if ($exists || ($prodi && $prodi->user_id)) {
                return back()->withErrors(['prodi_id' => 'Akun kaprodi untuk prodi ini sudah ada!'])->withInput();
            }
        }
        // Validasi hanya satu akun mahasiswa per NIM
        if ($request->role === 'mahasiswa' && $request->nim) {
            $exists = \App\Models\User::where('role', 'mahasiswa')->where('nim', $request->nim)->exists();
            $mahasiswa = \App\Models\Mahasiswa::where('nim', $request->nim)->first();
            if ($exists || ($mahasiswa && $mahasiswa->user_id)) {
                return back()->withErrors(['nim' => 'Akun untuk NIM ini sudah ada!'])->withInput();
            }
        }

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ];
        if ($request->role === 'perusahaan') {
            $data['id_perusahaan'] = $request->id_perusahaan;
        }

        $user = User::create($data);

        // Jika role perusahaan, hubungkan user_id ke perusahaan
        if ($request->role === 'perusahaan' && $request->id_perusahaan) {
            $perusahaan = Perusahaan::find($request->id_perusahaan);
            if ($perusahaan) {
                $perusahaan->user_id = $user->id;
                $perusahaan->save();
            }
        }

        // Log account creation
        Log::info('Akun dibuat', [
            'actor_id' => Auth::id(),
            'actor_username' => Auth::user()?->username,
            'created_user_id' => $user->id,
            'created_username' => $user->username,
            'role' => $user->role,
        ]);

        // Jika role kaprodi, hubungkan ke prodi
        if ($request->role === 'kaprodi' && $request->prodi_id) {
            $prodi = Prodi::find($request->prodi_id);
            $prodi->user_id = $user->id;
            $prodi->save();
        }

        return redirect()->route('operator.akun.index')
            ->with('success', 'Akun berhasil ditambahkan');
    }

    public function edit(User $akun)
    {
        return view('backend.operator.Akun.edit', compact('akun'));
    }

    public function show(User $akun)
    {
        // Load relationships based on role
        if ($akun->role === 'mahasiswa') {
            $akun->load('mahasiswa.prodi');
        } elseif ($akun->role === 'kaprodi') {
            $akun->load('prodi');
        } elseif ($akun->role === 'perusahaan') {
            $akun->load('perusahaan');
        }
        
        return view('backend.operator.Akun.show', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $akun->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $akun->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:mahasiswa,perusahaan,kaprodi,pimpinan,operator',
            'status' => 'required|string|in:Aktif,Non-Aktif',
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $akun->update($data);

        // Log account update
        Log::info('Akun diperbarui', [
            'actor_id' => Auth::id(),
            'actor_username' => Auth::user()?->username,
            'updated_user_id' => $akun->id,
            'updated_username' => $akun->username,
            'changes' => $data,
        ]);

        return redirect()->route('operator.akun.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    public function destroy(User $akun)
    {
        $deletedUser = $akun->toArray();
        $akun->delete();

        // Log account deletion
        Log::info('Akun dihapus', [
            'actor_id' => Auth::id(),
            'actor_username' => Auth::user()?->username,
            'deleted_user' => $deletedUser,
        ]);

        return redirect()->route('operator.akun.index')
            ->with('success', 'Akun berhasil dihapus');
    }

    public function activate($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->status = 'Aktif';
        $user->save();

        // Log activation
        Log::info('Akun diaktifkan', [
            'actor_id' => Auth::id(),
            'actor_username' => Auth::user()?->username,
            'activated_user_id' => $user->id,
            'activated_username' => $user->username,
        ]);

        return back()->with('success', 'Akun berhasil diaktifkan.');
    }
}
