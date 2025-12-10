<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\PembimbingIndustri;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pembimbingIndustriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::where('email', Auth::user()->email)->first();
        $pembimbing = collect();
        if ($mahasiswa) {
            $pembimbing = $mahasiswa->pembimbingIndustri();
            // Search functionality
            if ($request->has('search') && $request->search !== '') {
                $search = strtolower($request->search);
                $pembimbing = $pembimbing->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(nama_pembimbing) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(jabatan) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(kontak) LIKE ?', ['%' . $search . '%'])
                      ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
                });
            }
            $pembimbing = $pembimbing->with('perusahaan')->latest()->paginate(10);
        }
        if ($request->ajax()) {
            return response()->json($pembimbing);
        }
        return view('backend.mahasiswa.pembimbingIndustri.index', compact('pembimbing'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pembimbingIndustri = PembimbingIndustri::with('perusahaan')->findOrFail($id);
        return view('backend.mahasiswa.pembimbingIndustri.show', compact('pembimbingIndustri'));
    }
}
