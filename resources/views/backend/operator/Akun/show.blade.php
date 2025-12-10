@extends('backend.dashboard.operator')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Detail Akun</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <div class="mb-6">
            <a href="{{ route('operator.akun.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->username }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->email }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ ucfirst($akun->role) }}" readonly>
                </div>
                @if($akun->role === 'kaprodi' && $akun->prodi)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->prodi->nama_prodi }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->prodi->jurusan }}" readonly>
                </div>
                @endif
                @if($akun->role === 'mahasiswa' && $akun->mahasiswa)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->mahasiswa->nim }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->mahasiswa->nama }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->mahasiswa->prodi->nama_prodi }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $akun->mahasiswa->semester }}" readonly>
                </div>
                @if($akun->mahasiswa->ktm)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">KTM (Kartu Tanda Mahasiswa)</label>
                    <div class="flex items-center space-x-3">
                        <a href="{{ Storage::url($akun->mahasiswa->ktm) }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Lihat KTM
                        </a>
                        <span class="text-sm text-gray-500">KTM mahasiswa tersedia</span>
                    </div>
                </div>
                @else
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">KTM (Kartu Tanda Mahasiswa)</label>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">KTM belum diupload</span>
                    </div>
                </div>
                @endif
                @endif
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 @if($akun->status == 'Aktif') text-green-800 @else text-red-800 @endif" value="{{ $akun->status }}" readonly>
                </div>
            </div>
        </div>
    </div>
@endsection 