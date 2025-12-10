<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class daftarPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Perusahaan::where('status_kerjasama', 'Aktif');

        // Filter pencarian
        if ($request->has('search') && $request->search !== '') {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama_perusahaan) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(alamat) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(bidang_usaha) LIKE ?', ['%' . $search . '%']);
            });
        }
        if ($request->has('bidang_usaha') && $request->bidang_usaha !== '') {
            $bidang = strtolower($request->bidang_usaha);
            $query->whereRaw('LOWER(bidang_usaha) LIKE ?', ['%' . $bidang . '%']);
        }

        $perusahaan = $query->latest()->paginate(10);

        return view('backend.mahasiswa.daftarPerusahaanPKL.index', ['perusahaan' => $perusahaan]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.mahasiswa.daftarPerusahaanPKL.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_perusahaan' => 'required|string|max:255|unique:perusahaans,nama_perusahaan',
                'alamat' => 'required|string',
                'kontak' => 'required|string',
                'bidang_usaha' => 'required|string',
            ], [
                'nama_perusahaan.unique' => 'Nama perusahaan sudah ada dalam database',
                'nama_perusahaan.required' => 'Nama perusahaan harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'kontak.required' => 'Kontak harus diisi',
                'bidang_usaha.required' => 'Bidang usaha harus diisi',
            ]);

            // Set default status to Tidak Aktif for student submissions
            $validated['status_kerjasama'] = 'Tidak Aktif';
            
            $perusahaan = Perusahaan::create($validated);

            return redirect()
                ->route('mahasiswa.daftarPerusahaanPKL.index')
                ->with('success', 'Perusahaan yang anda tambahkan sedang di validasi, mohon untuk menunggu');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validasi gagal: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error creating perusahaan: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan perusahaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('backend.mahasiswa.daftarPerusahaanPKL.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {    
        $perusahaan = Perusahaan::findOrFail($id);
        return view('backend.mahasiswa.daftarPerusahaanPKL.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'bidang_usaha' => 'required|string',
            'status_kerjasama' => 'required|string',
        ]);

        try {
            // Ensure status_kerjasama remains unchanged
            $validated['status_kerjasama'] = $perusahaan->status_kerjasama;
            
            $perusahaan->update($validated);

            return redirect()
                ->route('mahasiswa.daftarPerusahaanPKL.index')
                ->with('success', 'Perusahaan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui perusahaan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $perusahaan = Perusahaan::findOrFail($id);
            $perusahaan->delete();

            return redirect()
                ->route('mahasiswa.daftarPerusahaanPKL.index')
                ->with('success', 'Perusahaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus perusahaan: ' . $e->getMessage());
        }
    }
}
