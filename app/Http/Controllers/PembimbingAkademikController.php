<?php

namespace App\Http\Controllers;

use App\Models\PembimbingAkademik;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingAkademikController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Filter pembimbing akademik berdasarkan prodi kaprodi
        $pembimbingAkademik = PembimbingAkademik::with('prodi')
            ->whereHas('prodi', function($q) use ($prodi) {
                $q->where('nama_prodi', $prodi->nama_prodi);
            })
            ->get();
            
        return view('backend.kaprodi.pembimbingAkademik.index', compact('pembimbingAkademik'));
    }

    public function create()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Hanya tampilkan prodi yang sesuai dengan kaprodi
        $prodis = Prodi::where('nama_prodi', $prodi->nama_prodi)->get();
        return view('backend.kaprodi.pembimbingAkademik.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:pembimbing_akademik',
            'prodi_id' => 'required|exists:prodis,id',
            'kapasitas_bimbingan' => 'required|integer|min:1',
            'kontak' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        
        // Validasi bahwa prodi_id sesuai dengan prodi kaprodi
        $selectedProdi = Prodi::find($request->prodi_id);
        if ($selectedProdi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda hanya dapat menambahkan pembimbing akademik untuk prodi Anda sendiri.');
        }

        PembimbingAkademik::create($request->all());

        return redirect()->route('pembimbing-akademik.index')
            ->with('success', 'Pembimbing Akademik berhasil ditambahkan');
    }

    public function show(PembimbingAkademik $pembimbingAkademik)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        $pembimbingAkademik->load(['prodi', 'mahasiswas.pengajuanpkl.perusahaan']);
        
        // Ambil mahasiswa yang sesuai dengan prodi kaprodi
        $availableStudents = \App\Models\Mahasiswa::where('prodi_id', $prodi->id)
            ->whereHas('pengajuanpkl', function($query) {
                $query->whereRaw('LOWER(status) = ?', ['diterima']);
            })
            ->get();
        
        return view('backend.kaprodi.pembimbingAkademik.show', compact('pembimbingAkademik', 'availableStudents'));
    }

    public function edit(PembimbingAkademik $pembimbingAkademik)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        // Hanya tampilkan prodi yang sesuai dengan kaprodi
        $prodis = Prodi::where('nama_prodi', $prodi->nama_prodi)->get();
        return view('backend.kaprodi.pembimbingAkademik.edit', compact('pembimbingAkademik', 'prodis'));
    }

    public function update(Request $request, PembimbingAkademik $pembimbingAkademik)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:pembimbing_akademik,nip,' . $pembimbingAkademik->id,
            'prodi_id' => 'required|exists:prodis,id',
            'kapasitas_bimbingan' => 'required|integer|min:1',
            'kontak' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        
        // Validasi bahwa prodi_id sesuai dengan prodi kaprodi
        $selectedProdi = Prodi::find($request->prodi_id);
        if ($selectedProdi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda hanya dapat mengedit pembimbing akademik untuk prodi Anda sendiri.');
        }

        $pembimbingAkademik->update($request->all());

        return redirect()->route('pembimbing-akademik.index')
            ->with('success', 'Pembimbing Akademik berhasil diperbarui');
    }

    public function destroy(PembimbingAkademik $pembimbingAkademik)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        $pembimbingAkademik->delete();

        return redirect()->route('pembimbing-akademik.index')
            ->with('success', 'Pembimbing Akademik berhasil dihapus');
    }

    public function assignMahasiswa(Request $request, PembimbingAkademik $pembimbingAkademik)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        $request->validate([
            'mahasiswa_ids' => 'required|array',
            'mahasiswa_ids.*' => 'exists:mahasiswas,id'
        ]);

        // Check if adding these students would exceed capacity
        $currentCount = $pembimbingAkademik->mahasiswas()->count();
        $newCount = count($request->mahasiswa_ids);
        
        if ($currentCount + $newCount > $pembimbingAkademik->kapasitas_bimbingan) {
            return back()->with('error', 'Kapasitas bimbingan akan terlampaui');
        }

        $pembimbingAkademik->mahasiswas()->attach($request->mahasiswa_ids);

        return back()->with('success', 'Mahasiswa berhasil ditambahkan ke pembimbing akademik');
    }

    public function removeMahasiswa(PembimbingAkademik $pembimbingAkademik, Mahasiswa $mahasiswa)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        $pembimbingAkademik->mahasiswas()->detach($mahasiswa->id);

        return back()->with('success', 'Mahasiswa berhasil dihapus dari pembimbing akademik');
    }

    public function assignSingleMahasiswa(Request $request, PembimbingAkademik $pembimbingAkademik, \App\Models\Mahasiswa $mahasiswa)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        // Validasi bahwa pembimbing akademik sesuai dengan prodi kaprodi
        if ($pembimbingAkademik->prodi->nama_prodi !== $prodi->nama_prodi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        
        // Cek kapasitas bimbingan
        $currentCount = $pembimbingAkademik->mahasiswas()->count();
        if ($currentCount >= $pembimbingAkademik->kapasitas_bimbingan) {
            return back()->with('error', 'Kapasitas bimbingan sudah penuh');
        }
        // Cek apakah sudah pernah di-assign
        if ($pembimbingAkademik->mahasiswas()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
            return back()->with('error', 'Mahasiswa sudah dipasangkan ke pembimbing ini');
        }
        $pembimbingAkademik->mahasiswas()->attach($mahasiswa->id);
        return back()->with('success', 'Mahasiswa berhasil dipasangkan ke pembimbing akademik');
    }
} 