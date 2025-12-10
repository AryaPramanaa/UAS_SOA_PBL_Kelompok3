<?php

namespace App\Http\Controllers;

use App\Models\pengajuanPKL;
use Illuminate\Http\Request;

class OperatorPengajuanPKLController extends Controller
{
    public function index(Request $request)
    {
        $query = pengajuanPKL::with(['mahasiswa', 'perusahaan']);

        // Filter by name
        if ($request->has('nama') && $request->nama != '') {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter by NIM
        if ($request->has('nim') && $request->nim != '') {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->nim . '%');
            });
        }

        // Filter by company
        if ($request->has('perusahaan') && $request->perusahaan != '') {
            $query->whereHas('perusahaan', function($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->perusahaan . '%');
            });
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();

        return view('backend.operator.pengajuanPKL.index', compact('pengajuans'));
    }

    public function show(pengajuanPKL $pengajuanPKL)
    {
        $pengajuan = $pengajuanPKL->load(['mahasiswa.pembimbingAkademik', 'perusahaan']);
        return view('backend.operator.pengajuanPKL.show', compact('pengajuan'));
    }

    public function edit(pengajuanPKL $pengajuanPKL)
    {
        $pengajuan = $pengajuanPKL->load(['mahasiswa', 'perusahaan']);
        return view('backend.operator.pengajuanPKL.edit', compact('pengajuan'));
    }

    public function update(Request $request, pengajuanPKL $pengajuanPKL)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak',
            'alasan_penolakan' => 'required_if:status,Ditolak'
        ]);

        $pengajuanPKL->update($validated);

        return redirect()->route('operator.pengajuanPKL.index')
            ->with('success', 'Status pengajuan PKL berhasil diperbarui');
    }
}
