<?php

namespace App\Http\Controllers;

use App\Models\Hobi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OperatorHobiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function ensureOperator()
    {
        if (! Auth::user() || Auth::user()->role !== 'operator') {
            abort(403, 'Unauthorized');
        }
    }

    public function index(Request $request)
    {
        $this->ensureOperator();

        $query = Hobi::with('mahasiswa');

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('mahasiswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhere('hobi', 'like', "%{$search}%");
        }

        $hobis = $query->orderBy('no')->paginate(15);

        return view('backend.operator.Hobi.index', compact('hobis'));
    }

    public function create()
    {
        $this->ensureOperator();
        $mahasiswas = \App\Models\Mahasiswa::orderBy('nama')->get();
        return view('backend.operator.Hobi.create', compact('mahasiswas'));
    }

    public function store(Request $request)
    {
        $this->ensureOperator();

        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'hobi' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Try to create with retry on unique constraint (race-safe small retry loop)
            $attempts = 0;
            $hobi = null;
            while ($attempts < 5) {
                // compute next no based on current active count
                $nextNo = Hobi::whereNull('deleted_at')->count();
                $validated['no'] = $nextNo + 1;

                $mahasiswa = \App\Models\Mahasiswa::find($validated['mahasiswa_id']);
                $validated['nama_mahasiswa'] = $mahasiswa->nama;

                try {
                    $hobi = Hobi::create($validated);
                    break; // success
                } catch (\Illuminate\Database\QueryException $qe) {
                    // duplicate entry for 'no' - increment and retry
                    if (str_contains($qe->getMessage(), 'Duplicate entry') || $qe->getCode() == '23000') {
                        $attempts++;
                        // small backoff (optional)
                        usleep(100000);
                        continue;
                    }

                    throw $qe; // rethrow other DB errors
                }
            }

            if (! $hobi) {
                throw new \Exception('Unable to create hobi after multiple attempts due to unique constraint');
            }

            DB::commit();

            Log::info('Hobi dibuat', [
                'actor_id' => Auth::id(),
                'actor_username' => Auth::user()?->username,
                'hobi_id' => $hobi->id,
                'no' => $hobi->no,
                'mahasiswa_id' => $hobi->mahasiswa_id,
            ]);

            return redirect()->route('operator.hobi.index')->with('success', 'Hobi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal membuat hobi: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. Silakan coba lagi.']);
        }
    }

    public function show(Hobi $hobi)
    {
        $this->ensureOperator();
        return view('backend.operator.Hobi.show', compact('hobi'));
    }

    public function edit(Hobi $hobi)
    {
        $this->ensureOperator();
        $mahasiswas = \App\Models\Mahasiswa::orderBy('nama')->get();
        return view('backend.operator.Hobi.edit', compact('hobi', 'mahasiswas'));
    }

    public function update(Request $request, Hobi $hobi)
    {
        $this->ensureOperator();

        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'hobi' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $mahasiswa = \App\Models\Mahasiswa::find($validated['mahasiswa_id']);
            $validated['nama_mahasiswa'] = $mahasiswa->nama;

            $hobi->update($validated);

            DB::commit();

            Log::info('Hobi diperbarui', [
                'actor_id' => Auth::id(),
                'actor_username' => Auth::user()?->username,
                'hobi_id' => $hobi->id,
            ]);

            return redirect()->route('operator.hobi.index')->with('success', 'Hobi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui hobi: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui data. Silakan coba lagi.']);
        }
    }

    public function destroy(Hobi $hobi)
    {
        $this->ensureOperator();

        try {
            DB::beginTransaction();

            $deleted = $hobi->toArray();
            $hobi->delete();

            // resequence remaining 'no' values to be contiguous starting from 1
            $remaining = Hobi::whereNull('deleted_at')->orderBy('no')->get();
            $cur = 1;
            foreach ($remaining as $r) {
                if ($r->no != $cur) {
                    $r->no = $cur;
                    $r->save();
                }
                $cur++;
            }

            DB::commit();

            Log::info('Hobi dihapus', [
                'actor_id' => Auth::id(),
                'actor_username' => Auth::user()?->username,
                'deleted' => $deleted,
                'resequence_total' => $remaining->count(),
            ]);

            return redirect()->route('operator.hobi.index')->with('success', 'Hobi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus hobi: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withErrors(['error' => 'Gagal menghapus data.']);
        }
    }
}
