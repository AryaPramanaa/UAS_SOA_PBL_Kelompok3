<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanMahasiswa;

class PimpinanLaporanMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = LaporanMahasiswa::with([
            'pengajuanPKL.mahasiswa',
            'pengajuanPKL.perusahaan',
            'pembimbingAkademik',
            'pembimbingIndustri',
        ]);

        if ($request->filled('nama')) {
            $query->whereHas('pengajuanPKL.mahasiswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }
        if ($request->filled('nim')) {
            $query->whereHas('pengajuanPKL.mahasiswa', function($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->nim . '%');
            });
        }
        if ($request->filled('perusahaan')) {
            $query->whereHas('pengajuanPKL.perusahaan', function($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
            });
        }
        if ($request->filled('pembimbing_akademik')) {
            $query->whereHas('pembimbingAkademik', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->pembimbing_akademik . '%');
            });
        }

        $laporans = $query->latest()->get();
        return view('backend.pimpinan.LaporanMahasiswa.index', compact('laporans'));
    }

    public function show($id)
    {
        $laporan = \App\Models\LaporanMahasiswa::with([
            'pengajuanPKL.mahasiswa',
            'pengajuanPKL.perusahaan',
            'pembimbingAkademik',
            'pembimbingIndustri',
        ])->findOrFail($id);
        return view('backend.pimpinan.LaporanMahasiswa.show', compact('laporan'));
    }
} 