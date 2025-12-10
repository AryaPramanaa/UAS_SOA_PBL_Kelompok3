<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengajuanPKL;
use Illuminate\Support\Facades\Auth;

class RekapMahasiswaPKLKaprodiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        
        // Ambil prodi yang terkait dengan user kaprodi
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        $query = pengajuanPKL::with(['mahasiswa.prodi', 'perusahaan'])
            ->where('status', 'diterima') // asumsikan status 'diterima' menandakan sedang PKL
            ->whereHas('mahasiswa.prodi', function($q) use ($prodi) {
                $q->where('nama_prodi', $prodi->nama_prodi);
            });

        if ($request->filled('nama')) {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }
        if ($request->filled('nim')) {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->nim . '%');
            });
        }
        if ($request->filled('perusahaan')) {
            $query->whereHas('perusahaan', function($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
            });
        }

        $pengajuans = $query->latest()->get();
        return view('backend.kaprodi.RekapMahasiswaPKL.index', compact('pengajuans'));
    }

    public function show($id)
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        $prodi = $user->prodi;
        
        if (!$prodi) {
            return redirect()->back()->with('error', 'Data prodi tidak ditemukan untuk akun ini.');
        }
        
        $pengajuan = \App\Models\pengajuanPKL::with(['mahasiswa.prodi', 'perusahaan'])
            ->whereHas('mahasiswa.prodi', function($q) use ($prodi) {
                $q->where('nama_prodi', $prodi->nama_prodi);
            })
            ->findOrFail($id);
            
        return view('backend.kaprodi.RekapMahasiswaPKL.show', compact('pengajuan'));
    }
} 