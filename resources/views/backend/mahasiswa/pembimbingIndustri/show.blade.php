@extends('backend.dashboard.mahasiswa')

@section('title', 'Detail Pembimbing Industri')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Detail Pembimbing Industri</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <div class="mb-6">
            <a href="{{ route('mahasiswa.pembimbingIndustri.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pembimbing Industri</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pembimbing</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->nama_pembimbing }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->jabatan }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kontak</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->kontak }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->email }}" readonly>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas Bimbingan</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->kapasitas_bimbingan ?? '-' }}" readonly>
                </div>
            </div>
            <div class="mt-8 space-y-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->perusahaan->nama_perusahaan ?? '-' }}" readonly>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bidang Usaha</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->perusahaan->bidang_usaha ?? '-' }}" readonly>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->perusahaan->alamat ?? '-' }}" readonly>
            </div>
        </div>
    </div>
@endsection 