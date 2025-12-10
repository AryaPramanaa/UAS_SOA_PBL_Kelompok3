<?php

namespace App\Http\Controllers;

use App\Models\PembimbingAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaPembimbingAkademikController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = \Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Akses tidak valid.');
        }
        $pembimbingAkademik = $mahasiswa->pembimbingAkademik()->with('prodi', 'mahasiswas')->get();
        return view('backend.mahasiswa.pembimbingAkademik.index', compact('pembimbingAkademik'));
    }

    public function show($id)
    {
        $mahasiswa = \Auth::user()->mahasiswa;
        if (!$mahasiswa) {
            return redirect()->route('dashboard')->with('error', 'Akses tidak valid.');
        }
        $pembimbingAkademik = \App\Models\PembimbingAkademik::with(['prodi', 'mahasiswas'])->findOrFail($id);
        // Cek apakah mahasiswa login memang dibimbing oleh pembimbing akademik ini
        if (!$pembimbingAkademik->mahasiswas->contains($mahasiswa->id)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke pembimbing akademik ini.');
        }
        return view('backend.mahasiswa.pembimbingAkademik.show', compact('pembimbingAkademik'));
    }
} 