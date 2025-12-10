@extends('backend.dashboard.perusahaan')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Edit Lowongan PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
        <div class="mb-6">
            <a href="{{ route('perusahaan.lowonganPKL.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="bg-white rounded-xl shadow-lg p-6">
            <form action="{{ route('perusahaan.lowonganPKL.update', $lowonganPKL->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Divisi -->
                    <div>
                        <label for="divisi" class="block text-sm font-medium text-gray-700 mb-2">Divisi <span class="text-red-500">*</span></label>
                        <input type="text" name="divisi" id="divisi" value="{{ old('divisi', $lowonganPKL->divisi) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('divisi') border-red-500 @enderror">
                        @error('divisi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <!-- Kuota -->
                    <div>
                        <label for="kuota" class="block text-sm font-medium text-gray-700 mb-2">Kuota <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota" id="kuota" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('kuota') border-red-500 @enderror" value="{{ old('kuota', $lowonganPKL->kuota) }}" placeholder="Masukkan kuota peserta" required>
                        @error('kuota')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $lowonganPKL->deskripsi) }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <!-- Syarat -->
                    <div class="md:col-span-2">
                        <label for="syarat" class="block text-sm font-medium text-gray-700 mb-2">Syarat <span class="text-red-500">*</span></label>
                        <textarea name="syarat" id="syarat" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('syarat') border-red-500 @enderror">{{ old('syarat', $lowonganPKL->syarat) }}</textarea>
                        @error('syarat')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
