<?php

namespace App\Http\Controllers;

use App\Models\pengajuanPKL;
use App\Models\Mahasiswa;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class pengajuanPKLController extends Controller
{
    public function index()
    {   
        $mahasiswa = Mahasiswa::where('email',Auth::user()->email)->get();

        $pengajuans = pengajuanPKL::where('mahasiswa_id',$mahasiswa[0]->id)->with(['mahasiswa', 'perusahaan'])->latest()->paginate(10);
        return view('backend.mahasiswa.pengajuanPKL.index', compact('pengajuans'));
    }

    public function create(Request $request)
    {
        $mahasiswas = Mahasiswa::where('email', Auth::user()->email)->get();
        // Ambil perusahaan yang punya lowongan PKL aktif
        $perusahaanIds = \App\Models\LowonganPKL::pluck('perusahaan_id')->unique();
        $perusahaans = Perusahaan::whereIn('id', $perusahaanIds)->where('status_kerjasama', 'Aktif')->get();

        $selectedLowongan = null;
        $divisis = collect();
        if ($request->has('perusahaan_id')) {
            $divisis = \App\Models\LowonganPKL::where('perusahaan_id', $request->perusahaan_id)->pluck('divisi');
        }
        if ($request->has('lowongan_id')) {
            $selectedLowongan = \App\Models\LowonganPKL::with('perusahaan')->find($request->lowongan_id);
            if ($selectedLowongan) {
                // Pastikan divisi dari lowongan terpilih masuk ke $divisis
                if (!$divisis->contains($selectedLowongan->divisi)) {
                    $divisis = $divisis->push($selectedLowongan->divisi);
                }
            }
        }

        return view('backend.mahasiswa.pengajuanPKL.create', compact('mahasiswas', 'perusahaans', 'selectedLowongan', 'divisis'));
    }

    public function store(Request $request)
    {
        try {
            // Check if mahasiswa already has a submission
            $existingSubmission = pengajuanPKL::where('mahasiswa_id', $request->mahasiswa_id)->first();
            if ($existingSubmission) {
                return back()->withErrors(['error' => 'Pengajuan melebihi batas. Setiap mahasiswa hanya diperbolehkan mengajukan 1 kali.'])->withInput();
            }

            $request->validate([
                'mahasiswa_id' => 'required|exists:mahasiswas,id',
                'perusahaan_id' => 'required|exists:perusahaans,id',
                'tanggal_pengajuan' => 'required|date',
                'divisi_pilihan' => 'required|string|max:255',
                'cv' => 'required|file|mimes:pdf|max:2048',
            ]);

            // Handle CV file upload
            $cvPath = null;
            if ($request->hasFile('cv')) {
                $cvFile = $request->file('cv');
                $cvFileName = time() . '_' . $request->mahasiswa_id . '_CV.' . $cvFile->getClientOriginalExtension();
                $cvPath = $cvFile->storeAs('public/cv', $cvFileName);
            }

            $data = [
                'mahasiswa_id' => $request->mahasiswa_id,
                'perusahaan_id' => $request->perusahaan_id,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'divisi_pilihan' => $request->divisi_pilihan,
                'cv' => $cvPath,
                'status' => 'Pending'
            ];

            pengajuanPKL::create($data);

            // Kurangi kuota lowongan PKL jika ada
            $lowongan = \App\Models\LowonganPKL::find($request->perusahaan_id);
            if ($lowongan && !is_null($lowongan->kuota) && $lowongan->kuota > 0) {
                $lowongan->kuota = $lowongan->kuota - 1;
                $lowongan->save();
            }

            return redirect()->route('mahasiswa.pengajuanPKL.index')
                ->with('success', 'Pengajuan PKL berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $pengajuan = pengajuanPKL::with(['mahasiswa.pembimbingAkademik', 'perusahaan'])->findOrFail($id);
        $pembimbingIndustriTerpilih = $pengajuan->mahasiswa->pembimbingIndustri()->wherePivot('pengajuan_pkl_id', $pengajuan->id)->get();
        $pembimbingIndustriTersedia = [];
        if ($pengajuan->status === 'Diterima') {
            $pembimbingIndustriTersedia = \App\Models\PembimbingIndustri::where('perusahaan_id', $pengajuan->perusahaan_id)->get();
        }
        return view('backend.mahasiswa.pengajuanPKL.show', compact('pengajuan', 'pembimbingIndustriTerpilih', 'pembimbingIndustriTersedia'));
    }

    public function edit($id)
    {
        $pengajuan = pengajuanPKL::findOrFail($id);
        // Check if pengajuan can be edited
        if ($pengajuan->status !== 'Pending') {
            return redirect()->route('mahasiswa.pengajuanPKL.index')
                ->with('error', 'Pengajuan tidak dapat diedit karena status sudah ' . $pengajuan->status);
        }
        $mahasiswas = Mahasiswa::all();
        // Ambil perusahaan yang punya lowongan PKL aktif
        $perusahaanIds = \App\Models\LowonganPKL::pluck('perusahaan_id')->unique();
        $perusahaans = Perusahaan::whereIn('id', $perusahaanIds)->where('status_kerjasama', 'Aktif')->get();
        $divisis = \App\Models\LowonganPKL::where('perusahaan_id', $pengajuan->perusahaan_id)->pluck('divisi');
        return view('backend.mahasiswa.pengajuanPKL.edit', compact('pengajuan', 'mahasiswas', 'perusahaans', 'divisis'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = pengajuanPKL::findOrFail($id);

        // Check if pengajuan can be edited
        if ($pengajuan->status !== 'Pending') {
            return redirect()->route('mahasiswa.pengajuanPKL.index')
                ->with('error', 'Pengajuan tidak dapat diedit karena status sudah ' . $pengajuan->status);
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tanggal_pengajuan' => 'required|date',
            'divisi_pilihan' => 'required|string|max:255',
            'cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $data = [
            'mahasiswa_id' => $request->mahasiswa_id,
            'perusahaan_id' => $request->perusahaan_id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'divisi_pilihan' => $request->divisi_pilihan,
        ];

        // Handle CV file upload if provided
        if ($request->hasFile('cv')) {
            // Delete old CV file if exists
            if ($pengajuan->cv && Storage::exists($pengajuan->cv)) {
                Storage::delete($pengajuan->cv);
            }
            
            $cvFile = $request->file('cv');
            $cvFileName = time() . '_' . $request->mahasiswa_id . '_CV.' . $cvFile->getClientOriginalExtension();
            $cvPath = $cvFile->storeAs('public/cv', $cvFileName);
            $data['cv'] = $cvPath;
        }

        $pengajuan->update($data);

        return redirect()->route('mahasiswa.pengajuanPKL.index')
            ->with('success', 'Pengajuan PKL berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = pengajuanPKL::findOrFail($id);
        $pengajuan->delete();
        
        return redirect()->route('mahasiswa.pengajuanPKL.index')
            ->with('success', 'Pengajuan PKL berhasil dihapus.');
    }
} 