@extends('backend.dashboard.mahasiswa')
@section('title', 'Lowongan PKL')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Lowongan PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <form action="{{ route('mahasiswa.lowonganPKL.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="perusahaan" class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                    <select name="perusahaan" id="perusahaan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Semua Perusahaan</option>
                        @foreach($perusahaans as $perusahaan)
                            <option value="{{ $perusahaan->id }}" {{ request('perusahaan') == $perusahaan->id ? 'selected' : '' }}>
                                {{ $perusahaan->nama_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="divisi" class="block text-sm font-medium text-gray-700 mb-2">Divisi</label>
                    <input type="text" name="divisi" id="divisi" value="{{ request('divisi') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Cari berdasarkan divisi">
                </div>

                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('mahasiswa.lowonganPKL.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div>
                <table class="w-full table-fixed">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">No</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">Perusahaan</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">Divisi</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">Syarat</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">Kuota</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($lowonganPKLs as $lowongan)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $lowongan->perusahaan->nama_perusahaan }}">{{ $lowongan->perusahaan->nama_perusahaan }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $lowongan->divisi }}">{{ $lowongan->divisi }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $lowongan->deskripsi }}">{{ $lowongan->deskripsi }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $lowongan->syarat }}">{{ $lowongan->syarat }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $lowongan->kuota ?? '-' }}</td>
                                <td class="px-2 py-5 text-sm text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('mahasiswa.lowonganPKL.show', $lowongan->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-2 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada data lowongan PKL
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $lowonganPKLs->links() }}
        </div>
    </div>
@endsection
