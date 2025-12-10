<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengajuanPKL;

class RekapMahasiswaPKLPimpinanController extends Controller
{
    public function index(Request $request)
    {
        $query = pengajuanPKL::with(['mahasiswa.prodi', 'perusahaan'])
            ->where('status', 'Diterima'); // Status 'Diterima' menandakan sedang PKL

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
        return view('backend.pimpinan.RekapMahasiswaPKL.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $pengajuan = pengajuanPKL::with(['mahasiswa.prodi', 'perusahaan'])->findOrFail($id);
        return view('backend.pimpinan.RekapMahasiswaPKL.show', compact('pengajuan'));
    }
} 