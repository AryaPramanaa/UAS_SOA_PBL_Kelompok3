<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengajuanPKL;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;

class RekapMahasiswaPKLPerusahaanController extends Controller
{
    public function index(Request $request)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $query = pengajuanPKL::with(['mahasiswa.prodi', 'perusahaan'])
            ->where('status', 'Diterima')
            ->where('perusahaan_id', $perusahaan->id);

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

        $pengajuans = $query->latest()->paginate(10);
        return view('backend.perusahaan.RekapMahasiswaPKL.index', compact('pengajuans'));
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $pengajuan = pengajuanPKL::with(['mahasiswa.prodi', 'perusahaan'])
            ->where('perusahaan_id', $perusahaan->id)
            ->where('status', 'Diterima')
            ->findOrFail($id);
        return view('backend.perusahaan.RekapMahasiswaPKL.show', compact('pengajuan'));
    }
} 