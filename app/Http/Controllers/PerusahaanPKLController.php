<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PerusahaanPKLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Perusahaan::query();

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama_perusahaan) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(kontak) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(alamat) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(bidang_usaha) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Filter by status
        if ($request->has('status_kerjasama') && $request->status_kerjasama !== '') {
            $query->where('status_kerjasama', $request->status_kerjasama);
        }

        $perusahaan = $query->latest()->paginate(10);
        
        if ($request->ajax()) {
            return response()->json($perusahaan);
        }

        return view('backend.operator.perusahaanPKL.index', compact('perusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.operator.perusahaanPKL.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string',
            'bidang_usaha' => 'required|string',
            'status_kerjasama' => 'required|string',
        ]);

        try {
            Perusahaan::create($validated);

            return redirect()
                ->route('operator.perusahaanPKL.index')
                ->with('success', 'Perusahaan berhasil ditambahkan');
        } catch (\Exception $e) {
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
        return view('backend.operator.perusahaanPKL.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {    
        $perusahaan = Perusahaan::findOrFail($id);
        return view('backend.operator.perusahaanPKL.edit', compact('perusahaan'));
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
            $perusahaan->update($validated);

            return redirect()
                ->route('operator.perusahaanPKL.index')
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
                ->route('operator.perusahaanPKL.index')
                ->with('success', 'Perusahaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus perusahaan: ' . $e->getMessage());
        }
    }
} 