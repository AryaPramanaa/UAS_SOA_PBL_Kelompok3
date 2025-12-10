@extends('backend.dashboard.pimpinan')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Laporan Mahasiswa Magang</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <div>
                    <label for="pembimbing_akademik" class="block text-sm font-medium text-gray-700 mb-2">Cari Pembimbing Akademik</label>
                    <input type="text" name="pembimbing_akademik" id="pembimbing_akademik" value="{{ request('pembimbing_akademik') }}" placeholder="Pembimbing Akademik" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" />
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('pimpinan.laporanMahasiswa.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="hidden xl:block bg-white rounded-xl shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-12">NO</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-40">NAMA MAHASISWA</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-32">NIM</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-48">PERUSAHAAN</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-40">PEMBIMBING AKADEMIK</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-40">PEMBIMBING INDUSTRI</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">ALAMAT</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-36">TANGGAL PENGAJUAN</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-20">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($laporans as $index => $laporan)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words">{{ $laporan->pengajuanPKL->mahasiswa->nama ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center">{{ $laporan->pengajuanPKL->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words">{{ $laporan->pengajuanPKL->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words">{{ $laporan->pembimbingAkademik->nama ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words">{{ $laporan->pembimbingIndustri->nama_pembimbing ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words max-w-xs" title="{{ $laporan->pengajuanPKL->mahasiswa->alamat ?? '-' }}">
                                    {{ $laporan->pengajuanPKL->mahasiswa->alamat ?? '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center">{{ \Carbon\Carbon::parse($laporan->pengajuanPKL->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                <td class="px-6 py-5 text-sm text-center">
                                    <a href="{{ route('pimpinan.laporanMahasiswa.show', $laporan->id) }}" 
                                       class="inline-block px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada data laporan mahasiswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tablet Table -->
        <div class="hidden lg:block xl:hidden bg-white rounded-xl shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-12">NO</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">NAMA MAHASISWA</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">NIM</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">PERUSAHAAN</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">PEMBIMBING AKADEMIK</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">PEMBIMBING INDUSTRI</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider w-20">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($laporans as $index => $laporan)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center">{{ $index + 1 }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $laporan->pengajuanPKL->mahasiswa->nama ?? '-' }}">
                                    {{ $laporan->pengajuanPKL->mahasiswa->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center">{{ $laporan->pengajuanPKL->mahasiswa->nim ?? '-' }}</td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $laporan->pengajuanPKL->perusahaan->nama_perusahaan ?? '-' }}">
                                    {{ $laporan->pengajuanPKL->perusahaan->nama_perusahaan ?? '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $laporan->pembimbingAkademik->nama ?? '-' }}">
                                    {{ $laporan->pembimbingAkademik->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm font-semibold text-gray-500 text-center break-words" title="{{ $laporan->pembimbingIndustri->nama_pembimbing ?? '-' }}">
                                    {{ $laporan->pembimbingIndustri->nama_pembimbing ?? '-' }}
                                </td>
                                <td class="px-6 py-5 text-sm text-center">
                                    <a href="{{ route('pimpinan.laporanMahasiswa.show', $laporan->id) }}" 
                                       class="inline-block px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    Tidak ada data laporan mahasiswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-4">
            @forelse($laporans as $index => $laporan)
                <div class="bg-white rounded-lg shadow-lg p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-gray-900 truncate">{{ $laporan->pengajuanPKL->mahasiswa->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-600">NIM: {{ $laporan->pengajuanPKL->mahasiswa->nim ?? '-' }}</div>
                            <div class="text-sm text-gray-600 truncate">Perusahaan: {{ $laporan->pengajuanPKL->perusahaan->nama_perusahaan ?? '-' }}</div>
                            <div class="text-sm text-gray-600 truncate">Pembimbing Akademik: {{ $laporan->pembimbingAkademik->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-600 truncate">Pembimbing Industri: {{ $laporan->pembimbingIndustri->nama_pembimbing ?? '-' }}</div>
                            <div class="text-sm text-gray-600 truncate">Alamat: {{ $laporan->pengajuanPKL->mahasiswa->alamat ?? '-' }}</div>
                            <div class="text-sm text-gray-600">Tanggal: {{ \Carbon\Carbon::parse($laporan->pengajuanPKL->tanggal_pengajuan)->format('d/m/Y') }}</div>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ route('pimpinan.laporanMahasiswa.show', $laporan->id) }}" 
                               class="inline-block px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-lg p-8 text-center text-gray-500">
                    Tidak ada data laporan mahasiswa
                </div>
            @endforelse
        </div>
    </div>
@endsection 