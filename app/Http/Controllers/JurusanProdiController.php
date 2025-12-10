<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class JurusanProdiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prodi::query();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_prodi', 'LIKE', "%{$search}%")
                  ->orWhere('jurusan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_kaprodi', 'LIKE', "%{$search}%");
            });
        }
        
        $prodis = $query->latest()->paginate(10);
        return view('backend.operator.JurusanProdi.index', compact('prodis'));
    }

    public function create()
    {
        return view('backend.operator.JurusanProdi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'nama_kaprodi' => 'required|string|max:255',
        ]);

        Prodi::create($request->all());

        return redirect()->route('operator.jurusanProdi.index')
            ->with('success', 'Jurusan/Prodi berhasil ditambahkan');
    }

    public function edit(Prodi $jurusanProdi)
    {
        return view('backend.operator.JurusanProdi.edit', compact('jurusanProdi'));
    }

    public function update(Request $request, Prodi $jurusanProdi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'nama_kaprodi' => 'required|string|max:255',
        ]);

        $jurusanProdi->update($request->all());

        return redirect()->route('operator.jurusanProdi.index')
            ->with('success', 'Jurusan/Prodi berhasil diperbarui');
    }

    public function destroy(Prodi $jurusanProdi)
    {
        $jurusanProdi->delete();

        return redirect()->route('operator.jurusanProdi.index')
            ->with('success', 'Jurusan/Prodi berhasil dihapus');
    }
}
