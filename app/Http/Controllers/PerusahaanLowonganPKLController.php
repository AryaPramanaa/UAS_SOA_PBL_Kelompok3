<?php

namespace App\Http\Controllers;

use App\Models\LowonganPKL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerusahaanLowonganPKLController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $perusahaan = \App\Models\Perusahaan::where('user_id', $user->id)->first();
        
        if (!$perusahaan) {
            $lowonganPKLs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        } else {
            $query = LowonganPKL::with('perusahaan')->where('perusahaan_id', $perusahaan->id);

            // Search functionality
            if ($request->has('search') && $request->search !== '') {
                $search = strtolower($request->search);
                $query->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(divisi) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(deskripsi) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(syarat) LIKE ?', ['%' . $search . '%']);
                });
            }

            $lowonganPKLs = $query->latest()->paginate(10);
        }

        if ($request->ajax()) {
            return response()->json($lowonganPKLs);
        }
        return view('backend.perusahaan.lowonganPKLperusahaan.index', compact('lowonganPKLs'));
    }

    public function show(LowonganPKL $lowonganPKL)
    {
        // Ensure the lowongan belongs to the authenticated perusahaan
        if ($lowonganPKL->perusahaan_id !== Auth::user()->perusahaan->id) {
            abort(403);
        }

        $lowonganPKL->load('perusahaan');
        return view('backend.perusahaan.lowonganPKLperusahaan.show', compact('lowonganPKL'));
    }

    public function create()
    {
        return view('backend.perusahaan.lowonganPKLperusahaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'divisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'syarat' => 'required|string',
            'kuota' => 'nullable|integer|min:1',
        ]);

        $user = Auth::user();
        $perusahaan = \App\Models\Perusahaan::where('user_id', $user->id)->first();
        if (!$perusahaan) {
            return redirect()->back()->withErrors(['Perusahaan tidak ditemukan untuk user ini.']);
        }

        $lowonganPKL = new LowonganPKL($request->all());
        $lowonganPKL->perusahaan_id = $perusahaan->id;
        $lowonganPKL->save();

        return redirect()->route('perusahaan.lowonganPKL.index')
            ->with('success', 'Lowongan PKL berhasil ditambahkan');
    }

    public function edit(LowonganPKL $lowonganPKL)
    {
        // Ensure the lowongan belongs to the authenticated perusahaan
        if ($lowonganPKL->perusahaan_id !== Auth::user()->perusahaan->id) {
            abort(403);
        }

        return view('backend.perusahaan.lowonganPKLperusahaan.edit', compact('lowonganPKL'));
    }

    public function update(Request $request, LowonganPKL $lowonganPKL)
    {
        // Ensure the lowongan belongs to the authenticated perusahaan
        if ($lowonganPKL->perusahaan_id !== Auth::user()->perusahaan->id) {
            abort(403);
        }

        $request->validate([
            'divisi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'syarat' => 'required|string',
            'kuota' => 'nullable|integer|min:1',
        ]);

        $lowonganPKL->update($request->all());

        return redirect()->route('perusahaan.lowonganPKL.index')
            ->with('success', 'Lowongan PKL berhasil diperbarui');
    }

    public function destroy(LowonganPKL $lowonganPKL)
    {
        // Ensure the lowongan belongs to the authenticated perusahaan
        // if ($lowonganPKL->perusahaan_id !== Auth::user()->perusahaan->id) {
        //     abort(403);
        // }

        $lowonganPKL->delete();

        return redirect()->route('perusahaan.lowonganPKL.index')
            ->with('success', 'Lowongan PKL berhasil dihapus');
    }
}
