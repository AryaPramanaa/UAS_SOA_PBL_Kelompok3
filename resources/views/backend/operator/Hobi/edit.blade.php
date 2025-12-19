@extends('backend.dashboard.operator')

@section('content')
<div class="px-6 py-8">
    <div class="relative mb-6">
        <a href="{{ route('operator.hobi.index') }}" class="absolute left-0 top-0 inline-flex items-center px-4 py-2 bg-gray-700 text-white rounded-lg shadow">&larr; Kembali</a>
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Hobi</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">
            <form action="{{ route('operator.hobi.update', $hobi) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa</label>
                <select name="mahasiswa_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
                    <option value="">Pilih Mahasiswa</option>
                    @foreach($mahasiswas as $m)
                        <option value="{{ $m->id }}" {{ old('mahasiswa_id', $hobi->mahasiswa_id) == $m->id ? 'selected' : '' }}>{{ $m->nama }} - {{ $m->nim }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Hobi</label>
            <input type="text" name="hobi" value="{{ old('hobi', $hobi->hobi) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('operator.hobi.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white">Batal</a>
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg ml-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15 4.293 10.879a1 1 0 011.414-1.414L8.414 12.172l7.879-7.879a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span class="ml-2">Simpan Perubahan</span>
            </button>
        </div>
            </form>
        </div>
</div>
@endsection
