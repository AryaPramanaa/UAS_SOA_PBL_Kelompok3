<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerusahaanApiController extends Controller
{
    // Import perusahaan from JSON file
    public function importFromJson()
    {
        $jsonPath = public_path('perusahaans.json');
        if (!file_exists($jsonPath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File JSON tidak ditemukan.'
            ], 404);
        }
        $json = file_get_contents($jsonPath);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format JSON tidak valid.'
            ], 400);
        }
        $inserted = 0;
        foreach ($data as $item) {
            if (!isset($item['nama_perusahaan'])) continue;
            // Cek jika sudah ada berdasarkan nama_perusahaan
            $exists = Perusahaan::where('nama_perusahaan', $item['nama_perusahaan'])->exists();
            if ($exists) continue;
            // Cari user dengan username == nama_perusahaan
            $user = \App\Models\User::where('username', $item['nama_perusahaan'])->first();
            $user_id = $user ? $user->id : null;
            Perusahaan::create([
                'nama_perusahaan' => $item['nama_perusahaan'],
                'alamat' => $item['alamat'] ?? '',
                'kontak' => $item['kontak'] ?? '',
                'bidang_usaha' => $item['bidang_usaha'] ?? '',
                'status_kerjasama' => $item['status_kerjasama'] ?? '',
                'user_id' => $user_id,
            ]);
            $inserted++;
        }
        return response()->json([
            'status' => 'success',
            'message' => "Berhasil mengimpor $inserted perusahaan",
            'data' => $data  
        ]);

    }

    public function returnPerusahaan(){
        $perusahaan = Perusahaan::all()->latest()->get();
        return response()->json([
            'status' => 'success',
            'data' => $perusahaan
        ]);
    }

    // Endpoint untuk menampilkan data perusahaan dari file JSON
    public function getFromJson()
    {
        $jsonPath = public_path('perusahaans.json');
        if (!file_exists($jsonPath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File JSON tidak ditemukan.'
            ], 404);
        }
        $json = file_get_contents($jsonPath);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format JSON tidak valid.'
            ], 400);
        }
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    // Tambahan: Search perusahaan by nama (untuk autocomplete/search)
    public function search(Request $request)
    {
        $query = $request->input('q');
        $perusahaans = Perusahaan::where('nama_perusahaan', 'like', "%$query%")
            ->orderBy('nama_perusahaan')
            ->limit(10)
            ->get(['id', 'nama_perusahaan']);
        return response()->json($perusahaans);
    }
} 