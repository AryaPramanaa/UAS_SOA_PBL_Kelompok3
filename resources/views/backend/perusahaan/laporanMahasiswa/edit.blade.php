@extends('backend.dashboard.perusahaan')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Edit Laporan Mahasiswa Magang</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
        <div class="mb-6">
            <a href="{{ route('perusahaan.laporanMahasiswa.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
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
            <form action="{{ route('perusahaan.laporanMahasiswa.update', $laporan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pengajuanPKL_id" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa Magang</label>
                        <select name="pengajuanPKL_id" id="pengajuanPKL_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($pengajuans as $pengajuan)
                                <option value="{{ $pengajuan->id }}" {{ (old('pengajuanPKL_id', $laporan->pengajuanPKL_id) == $pengajuan->id) ? 'selected' : '' }}>
                                    {{ $pengajuan->mahasiswa->nama }} ({{ $pengajuan->mahasiswa->nim }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="pembimbingIndustri_id" class="block text-sm font-medium text-gray-700 mb-2">Pembimbing Industri</label>
                        <select name="pembimbingIndustri_id" id="pembimbingIndustri_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Pembimbing Industri</option>
                            @foreach($pembimbingIndustris as $pembimbing)
                                <option value="{{ $pembimbing->id }}" {{ (old('pembimbingIndustri_id', $laporan->pembimbingIndustri_id) == $pembimbing->id) ? 'selected' : '' }}>
                                    {{ $pembimbing->nama_pembimbing }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="pembimbingAkademik_id" class="block text-sm font-medium text-gray-700 mb-2">Pembimbing Akademik</label>
                        <select name="pembimbingAkademik_id" id="pembimbingAkademik_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Pembimbing Akademik</option>
                            @foreach($pembimbingAkademiks as $pembimbing)
                                <option value="{{ $pembimbing->id }}" {{ (old('pembimbingAkademik_id', $laporan->pembimbingAkademik_id) == $pembimbing->id) ? 'selected' : '' }}>
                                    {{ $pembimbing->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_laporan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Laporan</label>
                        <input type="date" name="tanggal_laporan" id="tanggal_laporan" value="{{ old('tanggal_laporan', $laporan->tanggal_laporan) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="isi_laporan" class="block text-sm font-medium text-gray-700 mb-2">Isi Laporan</label>
                        <textarea name="isi_laporan" id="isi_laporan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan isi laporan">{{ old('isi_laporan', $laporan->isi_laporan) }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 