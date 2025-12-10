@extends('backend.dashboard.pimpinan')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Rekap Mahasiswa PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Mahasiswa</label>
                    <input type="text" name="nama" id="nama" value="{{ request('nama') }}" placeholder="Nama Mahasiswa" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">Cari NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ request('nim') }}" placeholder="NIM" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <div>
                    <label for="perusahaan" class="block text-sm font-medium text-gray-700 mb-2">Cari Perusahaan</label>
                    <input type="text" name="perusahaan" id="perusahaan" value="{{ request('perusahaan') }}" placeholder="Perusahaan" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('pimpinan.rekapMahasiswaPKL.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div>
                <table class="w-full table-fixed">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NO</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NAMA MAHASISWA</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NIM</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">PRODI</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengajuans as $index => $pengajuan)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $pengajuan->mahasiswa->nama ?? '-' }}">{{ $pengajuan->mahasiswa->nama ?? '-' }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $pengajuan->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $pengajuan->mahasiswa->prodi->nama_prodi ?? '-' }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-center whitespace-nowrap">
                                    <a href="{{ route('pimpinan.rekapMahasiswaPKL.show', $pengajuan->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:text-blue-800 transition-colors duration-200" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-2 py-4 text-center text-gray-500">
                                    Tidak ada data mahasiswa PKL
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tablet Table -->
        <div class="hidden md:block lg:hidden bg-white rounded-xl shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-12">NO</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">NAMA MAHASISWA</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">NIM</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">PROGRAM STUDI</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">PERUSAHAAN</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-20">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengajuans as $index => $pengajuan)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $pengajuan->mahasiswa->nama ?? '-' }}">
                                    {{ $pengajuan->mahasiswa->nama ?? '-' }}
                                </td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center">{{ $pengajuan->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $pengajuan->mahasiswa->prodi->nama_prodi ?? '-' }}">
                                    {{ $pengajuan->mahasiswa->prodi->nama_prodi ?? '-' }}
                                </td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $pengajuan->perusahaan->nama_perusahaan ?? '-' }}">
                                    {{ $pengajuan->perusahaan->nama_perusahaan ?? '-' }}
                                </td>
                                <td class="px-2 py-5 text-sm text-center">
                                    <a href="{{ route('pimpinan.rekapMahasiswaPKL.show', $pengajuan->id) }}" 
                                       class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada data mahasiswa PKL
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            @forelse($pengajuans as $index => $pengajuan)
                <div class="bg-white rounded-lg shadow-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900 truncate">{{ $pengajuan->mahasiswa->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-600">NIM: {{ $pengajuan->mahasiswa->nim ?? '-' }}</div>
                            <div class="text-sm text-gray-600">Prodi: {{ $pengajuan->mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                            <div class="text-sm text-gray-600 truncate">Perusahaan: {{ $pengajuan->perusahaan->nama_perusahaan ?? '-' }}</div>
                            <div class="text-sm text-gray-600 truncate">Alamat: {{ $pengajuan->perusahaan->alamat ?? '-' }}</div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('pimpinan.rekapMahasiswaPKL.show', $pengajuan->id) }}" 
                               class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-8 text-center text-gray-500">
                    Tidak ada data mahasiswa PKL
                </div>
            @endforelse
        </div>
    </div>
@endsection
