<?php

namespace App\Http\Controllers;

use App\Models\SuratPKL;
use App\Models\Perusahaan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OperatorSuratPKLController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\SuratPKL::with(['perusahaan', 'mahasiswa']);
        // Filter
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
        $suratPKL = $query->latest()->get();
        return view('backend.operator.suratPKL.index', compact('suratPKL'));
    }

    public function create()
    {
        $perusahaans = \App\Models\Perusahaan::where('status_kerjasama', 'aktif')->get();
        $mahasiswas = \App\Models\Mahasiswa::all();
        return view('backend.operator.suratPKL.create', compact('perusahaans', 'mahasiswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'nomor_surat' => 'required|string',
            'jenis_surat' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:10240'
        ]);

        $mahasiswas = \App\Models\Mahasiswa::whereHas('pengajuanpkl', function($q) use ($request) {
            $q->where('perusahaan_id', $request->perusahaan_id)->where('status', 'Diterima');
        })->get();

        if ($mahasiswas->isEmpty()) {
            return back()->with('error', 'Tidak ada mahasiswa diterima di perusahaan ini. Surat tidak dikirim.');
        }

        $file = $request->file('file');
        $filePath = $file->store('surat_pkl', 'public');

        foreach ($mahasiswas as $mahasiswa) {
            \App\Models\SuratPKL::create([
                'mahasiswa_id' => $mahasiswa->id,
                'perusahaan_id' => $request->perusahaan_id,
                'nomor_surat' => $request->nomor_surat,
                'jenis_surat' => $request->jenis_surat,
                'tanggal_upload' => \Carbon\Carbon::now(),
                'deskripsi' => $request->deskripsi,
                'file_path' => $filePath
            ]);
        }

        return redirect()->route('operator.suratPKL.index')
            ->with('success', 'Surat PKL berhasil dikirim ke seluruh mahasiswa yang diterima di perusahaan ini.');
    }

    public function show(SuratPKL $suratPKL)
    {
        return view('backend.operator.suratPKL.show', compact('suratPKL'));
    }

    public function edit(SuratPKL $suratPKL)
    {
        $perusahaans = Perusahaan::where('status_kerjasama', 'aktif')->get();
        return view('backend.operator.suratPKL.edit', compact('suratPKL', 'perusahaans'));
    }

    public function update(Request $request, SuratPKL $suratPKL)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'nomor_surat' => 'required|string',
            'jenis_surat' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240'
        ]);

        $data = [
            'perusahaan_id' => $request->perusahaan_id,
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_upload' => Carbon::now(),
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file')) {
            if ($suratPKL->file_path) {
                Storage::disk('public')->delete($suratPKL->file_path);
            }
            
            $file = $request->file('file');
            $data['file_path'] = $file->store('surat_pkl', 'public');
        }

        $suratPKL->update($data);

        return redirect()->route('operator.suratPKL.index')
            ->with('success', 'Surat PKL berhasil diperbarui');
    }

    public function destroy(SuratPKL $suratPKL)
    {
        if ($suratPKL->file_path) {
            Storage::disk('public')->delete($suratPKL->file_path);
        }
        
        $suratPKL->delete();

        return redirect()->route('operator.suratPKL.index')
            ->with('success', 'Surat PKL berhasil dihapus');
    }

    public function mahasiswaByPerusahaan($perusahaan_id)
    {
        $mahasiswas = \App\Models\Mahasiswa::whereHas('pengajuanpkl', function($q) use ($perusahaan_id) {
            $q->where('perusahaan_id', $perusahaan_id)->where('status', 'Diterima');
        })->with('user')->get(['id', 'nama', 'nim', 'user_id']);
        return response()->json($mahasiswas);
    }
} 