<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanMahasiswa;
use App\Models\pengajuanPKL;
use App\Models\Perusahaan;
use App\Models\PembimbingIndustri;
use App\Models\PembimbingAkademik;
use Illuminate\Support\Facades\Auth;

class laporanMahasiswaController extends Controller
{
    // Tampilkan daftar laporan mahasiswa untuk perusahaan yang login
    public function index()
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $laporans = LaporanMahasiswa::whereHas('pengajuanPKL', function($q) use ($perusahaan) {
            $q->where('perusahaan_id', $perusahaan->id)->where('status', 'Diterima');
        })->with(['pengajuanPKL.mahasiswa'])->latest()->paginate(10);
        return view('backend.perusahaan.laporanMahasiswa.index', compact('laporans'));
    }

    // Form create laporan untuk mahasiswa magang di perusahaan
    public function create()
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $pengajuans = pengajuanPKL::where('perusahaan_id', $perusahaan->id)
            ->where('status', 'Diterima')
            ->with('mahasiswa')
            ->get();
        $pembimbingIndustris = PembimbingIndustri::where('perusahaan_id', $perusahaan->id)->get();
        $pembimbingAkademiks = PembimbingAkademik::all();
        $today = now()->toDateString();
        // Mapping pengajuan PKL ke pembimbing industri dan akademik
        $pengajuanMap = [];
        foreach ($pengajuans as $pengajuan) {
            $mahasiswa = $pengajuan->mahasiswa;
            $pembimbingIndustri = $mahasiswa->pembimbingIndustri()->where('perusahaan_id', $perusahaan->id)->first();
            $pembimbingAkademik = $mahasiswa->pembimbingAkademik()->first();
            $pengajuanMap[$pengajuan->id] = [
                'pembimbingIndustri_id' => $pembimbingIndustri ? $pembimbingIndustri->id : null,
                'pembimbingIndustri_nama' => $pembimbingIndustri ? $pembimbingIndustri->nama_pembimbing : null,
                'pembimbingAkademik_id' => $pembimbingAkademik ? $pembimbingAkademik->id : null,
                'pembimbingAkademik_nama' => $pembimbingAkademik ? $pembimbingAkademik->nama : null,
            ];
        }
        return view('backend.perusahaan.laporanMahasiswa.create', compact('pengajuans', 'pembimbingIndustris', 'pembimbingAkademiks', 'today', 'pengajuanMap'));
    }

    // Simpan laporan baru
    public function store(Request $request)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $request->validate([
            'pengajuanPKL_id' => 'required|exists:pengajuanPKLs,id',
            'pembimbingIndustri_id' => 'required|exists:pembimbingIndustris,id',
            'pembimbingAkademik_id' => 'required|exists:pembimbing_akademik,id',
            'tanggal_laporan' => 'nullable|date',
            'isi_laporan' => 'required|string',
        ]);
        $pengajuan = pengajuanPKL::where('id', $request->pengajuanPKL_id)
            ->where('perusahaan_id', $perusahaan->id)
            ->where('status', 'Diterima')
            ->firstOrFail();
        $data = $request->all();
        if (empty($data['tanggal_laporan'])) {
            $data['tanggal_laporan'] = now()->toDateString();
        }
        LaporanMahasiswa::create($data);
        return redirect()->route('perusahaan.laporanMahasiswa.index')->with('success', 'Laporan berhasil dibuat');
    }

    // Tampilkan detail laporan
    public function show($id)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $laporan = LaporanMahasiswa::where('id', $id)
            ->whereHas('pengajuanPKL', function($q) use ($perusahaan) {
                $q->where('perusahaan_id', $perusahaan->id);
            })
            ->with(['pengajuanPKL.mahasiswa', 'pembimbingIndustri', 'pembimbingAkademik'])
            ->firstOrFail();
        return view('backend.perusahaan.laporanMahasiswa.show', compact('laporan'));
    }

    // Form edit laporan
    public function edit($id)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $laporan = LaporanMahasiswa::where('id', $id)
            ->whereHas('pengajuanPKL', function($q) use ($perusahaan) {
                $q->where('perusahaan_id', $perusahaan->id);
            })
            ->firstOrFail();
        $pengajuans = pengajuanPKL::where('perusahaan_id', $perusahaan->id)
            ->where('status', 'Diterima')
            ->with('mahasiswa')
            ->get();
        $pembimbingIndustris = PembimbingIndustri::where('perusahaan_id', $perusahaan->id)->get();
        $pembimbingAkademiks = PembimbingAkademik::all();
        return view('backend.perusahaan.laporanMahasiswa.edit', compact('laporan', 'pengajuans', 'pembimbingIndustris', 'pembimbingAkademiks'));
    }

    // Update laporan
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $request->validate([
            'pengajuanPKL_id' => 'required|exists:pengajuanPKLs,id',
            'pembimbingIndustri_id' => 'required|exists:pembimbingIndustris,id',
            'pembimbingAkademik_id' => 'required|exists:pembimbing_akademik,id',
            'tanggal_laporan' => 'required|date',
            'isi_laporan' => 'required|string',
        ]);
        $laporan = LaporanMahasiswa::where('id', $id)
            ->whereHas('pengajuanPKL', function($q) use ($perusahaan) {
                $q->where('perusahaan_id', $perusahaan->id);
            })
            ->firstOrFail();
        $laporan->update($request->all());
        return redirect()->route('perusahaan.laporanMahasiswa.index')->with('success', 'Laporan berhasil diupdate');
    }

    // Hapus laporan
    public function destroy($id)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->firstOrFail();
        $laporan = LaporanMahasiswa::where('id', $id)
            ->whereHas('pengajuanPKL', function($q) use ($perusahaan) {
                $q->where('perusahaan_id', $perusahaan->id);
            })
            ->firstOrFail();
        $laporan->delete();
        return redirect()->route('perusahaan.laporanMahasiswa.index')->with('success', 'Laporan berhasil dihapus');
    }
}
