<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuratPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SuratPKLController extends Controller
{
    public function index()
    {
        $suratPKL = SuratPKL::with('perusahaan')->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $suratPKL
        ]);
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

        $file = $request->file('file');
        $filePath = $file->store('surat_pkl', 'public');

        $suratPKL = SuratPKL::create([
            'perusahaan_id' => $request->perusahaan_id,
            'nomor_surat' => $request->nomor_surat,
            'jenis_surat' => $request->jenis_surat,
            'tanggal_upload' => Carbon::now(),
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Surat PKL berhasil ditambahkan',
            'data' => $suratPKL
        ], 201);
    }

    public function show(SuratPKL $suratPKL)
    {
        return response()->json([
            'status' => 'success',
            'data' => $suratPKL->load('perusahaan')
        ]);
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

        return response()->json([
            'status' => 'success',
            'message' => 'Surat PKL berhasil diperbarui',
            'data' => $suratPKL
        ]);
    }

    public function destroy(SuratPKL $suratPKL)
    {
        if ($suratPKL->file_path) {
            Storage::disk('public')->delete($suratPKL->file_path);
        }
        
        $suratPKL->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Surat PKL berhasil dihapus'
        ]);
    }
} 