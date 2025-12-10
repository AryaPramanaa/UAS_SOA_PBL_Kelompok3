<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pengajuanPKL;
use App\Models\Mahasiswa;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengajuanPKLApiController extends Controller
{
    public function index()
    {
        try {
            $pengajuans = pengajuanPKL::with(['mahasiswa', 'perusahaan'])->latest()->paginate(10);
            
            return response()->json([
                'status' => 'success',
                'data' => $pengajuans
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'mahasiswa_id' => 'required|exists:mahasiswas,id',
                'perusahaan_id' => 'required|exists:perusahaans,id',
                'tanggal_pengajuan' => 'required|date',
                'divisi_pilihan' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Check if mahasiswa already has a submission
            $existingSubmission = pengajuanPKL::where('mahasiswa_id', $request->mahasiswa_id)->first();
            if ($existingSubmission) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengajuan melebihi batas. Setiap mahasiswa hanya diperbolehkan mengajukan 1 kali.'
                ], 400);
            }

            $data = [
                'mahasiswa_id' => $request->mahasiswa_id,
                'perusahaan_id' => $request->perusahaan_id,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'divisi_pilihan' => $request->divisi_pilihan,
                'status' => 'Pending'
            ];

            $pengajuan = pengajuanPKL::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan PKL berhasil dibuat',
                'data' => $pengajuan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $pengajuan = pengajuanPKL::with(['mahasiswa', 'perusahaan'])->findOrFail($id);
            
            return response()->json([
                'status' => 'success',
                'data' => $pengajuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pengajuan = pengajuanPKL::findOrFail($id);

            if ($pengajuan->status !== 'Pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pengajuan tidak dapat diedit karena status sudah ' . $pengajuan->status
                ], 400);
            }

            $validator = Validator::make($request->all(), [
                'mahasiswa_id' => 'required|exists:mahasiswas,id',
                'perusahaan_id' => 'required|exists:perusahaans,id',
                'tanggal_pengajuan' => 'required|date',
                'divisi_pilihan' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = [
                'mahasiswa_id' => $request->mahasiswa_id,
                'perusahaan_id' => $request->perusahaan_id,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'divisi_pilihan' => $request->divisi_pilihan,
            ];

            $pengajuan->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan PKL berhasil diperbarui',
                'data' => $pengajuan
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pengajuan = pengajuanPKL::findOrFail($id);
            $pengajuan->delete();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Pengajuan PKL berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
} 