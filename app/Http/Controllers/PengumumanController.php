<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::paginate(10);
        return view('backend.operator.Pengumuman.index', compact('pengumumans'));
    }

    public function create()
    {
        return view('backend.operator.Pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_buka' => 'nullable|date',
            'tanggal_tutup' => 'nullable|date|after:tanggal_buka',
            'tahun_akademik' => 'required',
            'deskripsi' => 'nullable',
        ]);

        Pengumuman::create($request->only(['tanggal_buka', 'tanggal_tutup', 'tahun_akademik', 'deskripsi']));

        return redirect()->route('operator.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan');
    }

    public function show(Pengumuman $pengumuman)
    {
        return view('backend.operator.Pengumuman.show', compact('pengumuman'));
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('backend.operator.Pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $request->validate([
            'tanggal_buka' => 'nullable|date',
            'tanggal_tutup' => 'nullable|date|after:tanggal_buka',
            'tahun_akademik' => 'required',
            'deskripsi' => 'nullable',
        ]);

        $pengumuman->update($request->only(['tanggal_buka', 'tanggal_tutup', 'tahun_akademik', 'deskripsi']));

        return redirect()->route('operator.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()->route('operator.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}
