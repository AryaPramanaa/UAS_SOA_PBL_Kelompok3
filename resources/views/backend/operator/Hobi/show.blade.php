@extends('backend.dashboard.operator')

@section('content')
<div class="px-6 py-6">
    <h2 class="text-xl font-semibold mb-4">Detail Hobi</h2>

    <div class="bg-white shadow rounded p-4">
        <p><strong>No:</strong> {{ $hobi->no }}</p>
        <p><strong>Nama Mahasiswa:</strong> {{ $hobi->nama_mahasiswa }}</p>
        <p><strong>Hobi:</strong> {{ $hobi->hobi }}</p>

        <div class="mt-4">
            <a href="{{ route('operator.hobi.index') }}" class="btn">Kembali</a>
            <a href="{{ route('operator.hobi.edit', $hobi) }}" class="btn btn-green ml-2">Edit</a>
        </div>
    </div>
</div>
@endsection
