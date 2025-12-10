<?php

namespace App\Http\Controllers;

use App\Models\PembimbingIndustri;
use App\Models\Perusahaan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class perusahaanPembimbingIndustriController extends Controller
{
    // Display a listing of the resource.
    public function index(Request $request)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->first();
        $query = PembimbingIndustri::with('perusahaan')->where('perusahaan_id', $perusahaan->id);

        if ($request->has('search') && $request->search !== '') {
            $search = strtolower($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama_pembimbing) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(jabatan) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(kontak) LIKE ?', ['%' . $search . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
            });
        }

        $pembimbing = $query->latest()->paginate(10);
        return view('backend.perusahaan.pembimbingIndustri.index', compact('pembimbing'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->first();
        return view('backend.perusahaan.pembimbingIndustri.create', compact('perusahaan'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $perusahaan = Perusahaan::where('user_id', Auth::id())->first();
        $validated = $request->validate([
            'nama_pembimbing' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kapasitas_bimbingan' => 'required|integer|min:1',
        ]);
        $validated['perusahaan_id'] = $perusahaan->id;
        try {
            PembimbingIndustri::create($validated);
            return redirect()->route('perusahaan.pembimbingIndustri.index')->with('success', 'Pembimbing industri berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Display the specified resource.
    public function show($id)
    {
        $pembimbingIndustri = PembimbingIndustri::with(['perusahaan', 'mahasiswas'])->findOrFail($id);
        $perusahaan_id = $pembimbingIndustri->perusahaan_id;
        $allMahasiswa = \App\Models\Mahasiswa::whereHas('pengajuanpkl', function($q) use ($perusahaan_id) {
            $q->where('perusahaan_id', $perusahaan_id)
              ->whereRaw('LOWER(status) = ?', ['diterima']);
        })->get();
        return view('backend.perusahaan.pembimbingIndustri.show', compact('pembimbingIndustri', 'allMahasiswa'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $pembimbingIndustri = PembimbingIndustri::findOrFail($id);
        $perusahaan = Perusahaan::where('user_id', Auth::id())->first();
        return view('backend.perusahaan.pembimbingIndustri.edit', compact('pembimbingIndustri', 'perusahaan'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $pembimbing = PembimbingIndustri::findOrFail($id);
        $validated = $request->validate([
            'nama_pembimbing' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'kapasitas_bimbingan' => 'required|integer|min:1',
        ]);
        try {
            $pembimbing->update($validated);
            return redirect()->route('perusahaan.pembimbingIndustri.index')->with('success', 'Pembimbing industri berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        try {
            $pembimbing = PembimbingIndustri::findOrFail($id);
            $pembimbing->delete();
            return redirect()->route('perusahaan.pembimbingIndustri.index')->with('success', 'Pembimbing industri berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Associate mahasiswa with pembimbing industri
    public function assignMahasiswa(Request $request, $id)
    {
        $pembimbing = PembimbingIndustri::findOrFail($id);
        $validated = $request->validate([
            'mahasiswa_ids' => 'nullable|array',
            'mahasiswa_ids.*' => 'exists:mahasiswas,id',
        ]);
        $pembimbing->mahasiswas()->sync($validated['mahasiswa_ids'] ?? []);
        if (empty($validated['mahasiswa_ids'])) {
            $message = 'Bimbingan mahasiswa telah dibatalkan.';
        } else {
            $message = 'Mahasiswa berhasil dikaitkan.';
        }
        return redirect()->route('perusahaan.pembimbingIndustri.show', $id)->with('success', $message);
    }

    // Remove a mahasiswa from pembimbing industri
    public function removeMahasiswa($pembimbingIndustriId, $mahasiswaId)
    {
        $pembimbing = PembimbingIndustri::findOrFail($pembimbingIndustriId);
        $pembimbing->mahasiswas()->detach($mahasiswaId);
        return redirect()->route('perusahaan.pembimbingIndustri.show', $pembimbingIndustriId)
            ->with('success', 'Bimbingan mahasiswa berhasil dibatalkan.');
    }
}
