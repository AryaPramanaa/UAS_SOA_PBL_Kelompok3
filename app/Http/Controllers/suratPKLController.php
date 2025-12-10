<?php

namespace App\Http\Controllers;

use App\Models\SuratPKL;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SuratPKLController extends Controller
{
    public function index()
    {
        $mahasiswa = \App\Models\Mahasiswa::where('email', \Illuminate\Support\Facades\Auth::user()->email)->first();
        $suratPKL = collect();
        if ($mahasiswa) {
            $suratPKL = \App\Models\SuratPKL::with('perusahaan')->where('mahasiswa_id', $mahasiswa->id)->latest()->get();
        }
        return view('backend.mahasiswa.suratPKL.index', compact('suratPKL'));
    }

    public function create()
    {
        $mahasiswa = \App\Models\Mahasiswa::where('email', Auth::user()->email)->first();
        $perusahaans = collect();
        if ($mahasiswa) {
            $pengajuanDiterima = $mahasiswa->pengajuanpkl()->where('status', 'Diterima')->first();
            if ($pengajuanDiterima) {
                $perusahaans = \App\Models\Perusahaan::where('id', $pengajuanDiterima->perusahaan_id)->get();
            }
        }
        return view('backend.mahasiswa.suratPKL.create', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'nomor_surat' => 'required|string',
            'jenis_surat' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:10240' // 10MB max size, PDF only
        ]);

        $file = $request->file('file');
        $filePath = $file->store('surat_pkl', 'public');

        $mahasiswa = \App\Models\Mahasiswa::where('email', \Illuminate\Support\Facades\Auth::user()->email)->first();

        SuratPKL::create([
            'mahasiswa_id' => $mahasiswa ? $mahasiswa->id : null,
            'perusahaan_id' => $request->perusahaan_id,
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_upload' => \Carbon\Carbon::now(),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath
        ]);

        return redirect()->route('mahasiswa.suratPKL.index')
            ->with('success', 'Surat PKL berhasil ditambahkan');
    }

    public function show(SuratPKL $suratPKL)
    {
        // Check if the surat PKL belongs to the authenticated mahasiswa
        $mahasiswa = \App\Models\Mahasiswa::where('email', Auth::user()->email)->first();
        if (!$mahasiswa || $suratPKL->mahasiswa_id !== $mahasiswa->id) {
            return redirect()->route('mahasiswa.suratPKL.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat surat PKL ini.');
        }

        return view('backend.mahasiswa.suratPKL.show', compact('suratPKL'));
    }

    public function edit(SuratPKL $suratPKL)
    {
        // Check if the surat PKL belongs to the authenticated mahasiswa
        $mahasiswa = \App\Models\Mahasiswa::where('email', Auth::user()->email)->first();
        if (!$mahasiswa || $suratPKL->mahasiswa_id !== $mahasiswa->id) {
            return redirect()->route('mahasiswa.suratPKL.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit surat PKL ini.');
        }

        // Get perusahaan based on mahasiswa's accepted pengajuan PKL
        $perusahaans = collect();
        $pengajuanDiterima = $mahasiswa->pengajuanpkl()->where('status', 'Diterima')->first();
        if ($pengajuanDiterima) {
            $perusahaans = Perusahaan::where('id', $pengajuanDiterima->perusahaan_id)->get();
        }

        return view('backend.mahasiswa.suratPKL.edit', compact('suratPKL', 'perusahaans'));
    }

    public function update(Request $request, SuratPKL $suratPKL)
    {
        // Check if the surat PKL belongs to the authenticated mahasiswa
        $mahasiswa = \App\Models\Mahasiswa::where('email', Auth::user()->email)->first();
        if (!$mahasiswa || $suratPKL->mahasiswa_id !== $mahasiswa->id) {
            return redirect()->route('mahasiswa.suratPKL.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit surat PKL ini.');
        }

        // Validate that the perusahaan_id is valid for this mahasiswa
        $pengajuanDiterima = $mahasiswa->pengajuanpkl()->where('status', 'Diterima')->first();
        if (!$pengajuanDiterima || $request->perusahaan_id != $pengajuanDiterima->perusahaan_id) {
            return redirect()->route('mahasiswa.suratPKL.index')
                ->with('error', 'Perusahaan yang dipilih tidak valid untuk akun Anda.');
        }

        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'nomor_surat' => 'required|string',
            'jenis_surat' => 'required|string',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:pdf|max:10240' // 10MB max size, PDF only
        ]);

        $data = [
            'perusahaan_id' => $request->perusahaan_id,
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_upload' => Carbon::now(),
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($suratPKL->file_path) {
                Storage::disk('public')->delete($suratPKL->file_path);
            }
            
            $file = $request->file('file');
            $data['file_path'] = $file->store('surat_pkl', 'public');
        }

        $suratPKL->update($data);

        return redirect()->route('mahasiswa.suratPKL.index')
            ->with('success', 'Surat PKL berhasil diperbarui');
    }

    public function destroy(SuratPKL $suratPKL)
    {
        // Check if the surat PKL belongs to the authenticated mahasiswa
        $mahasiswa = \App\Models\Mahasiswa::where('email', Auth::user()->email)->first();
        if (!$mahasiswa || $suratPKL->mahasiswa_id !== $mahasiswa->id) {
            return redirect()->route('mahasiswa.suratPKL.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus surat PKL ini.');
        }

        if ($suratPKL->file_path) {
            Storage::disk('public')->delete($suratPKL->file_path);
        }
        
        $suratPKL->delete();

        return redirect()->route('mahasiswa.suratPKL.index')
            ->with('success', 'Surat PKL berhasil dihapus');
    }
}
