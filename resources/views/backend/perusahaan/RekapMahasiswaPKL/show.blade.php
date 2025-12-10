@extends('backend.dashboard.perusahaan')

@section('content')
<div class="min-h-screen py-8 px-4 md:px-8">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-3">Detail Rekap Mahasiswa PKL</h1>
        <div class="w-40 h-1 bg-green-500 mx-auto"></div>
    </div>
    <div class="mb-6">
        <a href="{{ route('perusahaan.rekapMahasiswaPKL.index') }}"
            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Daftar
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->nama ?? '-' }}" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->nim ?? '-' }}" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prodi</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->prodi->nama_prodi ?? '-' }}" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->prodi->jurusan ?? '-' }}" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No HP Mahasiswa</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->no_hp ?? '-' }}" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Mahasiswa</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->email ?? '-' }}" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Mahasiswa</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" rows="2" readonly>{{ $pengajuan->mahasiswa->alamat ?? '-' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->semester ?? '-' }}" readonly>
            </div>
        </div>
    </div>
</div>
@endsection 