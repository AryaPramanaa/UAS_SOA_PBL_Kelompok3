<?php

namespace App\Http\Controllers;

use App\Models\LowonganPKL;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class OperatorLowonganPKlController extends Controller
{
    public function index(Request $request)
    {
        $query = LowonganPKL::with('perusahaan');
        $perusahaans = Perusahaan::all();

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereHas('perusahaan', function($q) use ($search) {
                    $q->whereRaw('LOWER(nama_perusahaan) LIKE ?', ['%' . $search . '%']);
                })
                ->orWhereRaw('LOWER(divisi) LIKE ?', ['%' . $search . '%'])
                ->orWhereRaw('LOWER(deskripsi) LIKE ?', ['%' . $search . '%'])
                ->orWhereRaw('LOWER(syarat) LIKE ?', ['%' . $search . '%']);
            });
        }

        $lowonganPKLs = $query->latest()->paginate(10);
        
        if ($request->ajax()) {
            return response()->json($lowonganPKLs);
        }
        return view('backend.operator.LowonganPKLoperator.index', compact('lowonganPKLs', 'perusahaans'));
    }

    public function show(LowonganPKL $lowonganPKL)
    {
        $lowonganPKL->load('perusahaan');
        return view('backend.operator.LowonganPKLoperator.show', compact('lowonganPKL'));
    }

    public function create()
    {
        $perusahaans = Perusahaan::all();
        return view('backend.operator.LowonganPKLoperator.create', compact('perusahaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'divisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'syarat' => 'required|string',
            'kuota' => 'nullable|integer|min:1',
        ]);

        LowonganPKL::create($request->all());

        return redirect()->route('operator.lowonganPKL.index')
            ->with('success', 'Lowongan PKL berhasil ditambahkan');
    }

    public function edit(LowonganPKL $lowonganPKL)
    {
        $perusahaans = Perusahaan::all();
        return view('backend.operator.LowonganPKLoperator.edit', compact('lowonganPKL', 'perusahaans'));
    }

    public function update(Request $request, LowonganPKL $lowonganPKL)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'divisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'syarat' => 'required|string',
            'kuota' => 'nullable|integer|min:1',
        ]);

        $lowonganPKL->update($request->all());

        return redirect()->route('operator.lowonganPKL.index')
            ->with('success', 'Lowongan PKL berhasil diperbarui');
    }

    public function destroy(LowonganPKL $lowonganPKL)
    {
        $lowonganPKL->delete();

        return redirect()->route('operator.lowonganPKL.index')
            ->with('success', 'Lowongan PKL berhasil dihapus');
    }
}
