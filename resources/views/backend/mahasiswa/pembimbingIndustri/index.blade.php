@extends('backend.dashboard.mahasiswa')

@section('title', 'Daftar Pembimbing Industri')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Daftar Pembimbing Industri</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form action="{{ route('mahasiswa.pembimbingIndustri.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Pembimbing</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Masukkan nama pembimbing">
                </div>
                <div></div>
                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    <a href="{{ route('mahasiswa.pembimbingIndustri.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div>
                <table class="w-full table-fixed">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NO</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NAMA PEMBIMBING</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">JABATAN</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">PERUSAHAAN</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">KONTAK</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">EMAIL</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pembimbing as $index => $item)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $item->nama_pembimbing }}">{{ $item->nama_pembimbing }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $item->jabatan }}">{{ $item->jabatan }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $item->perusahaan->nama_perusahaan }}">{{ $item->perusahaan->nama_perusahaan }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $item->kontak }}">{{ $item->kontak }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $item->email }}">{{ $item->email }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="{{ route('mahasiswa.pembimbingIndustri.show', $item->id) }}" class="text-blue-600 hover:text-blue-900">
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
                                <td colspan="7" class="px-2 py-4 text-center text-gray-500">
                                    Tidak ada data pembimbing industri
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pembimbing->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $pembimbing->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

<!-- Delete Confirmation Modal -->
<div id="deleteModalPembimbingIndustri" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Penghapusan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 mb-4">
                    Apakah Anda yakin ingin menghapus pembimbing industri berikut?
                </p>
                <div class="bg-gray-50 rounded-lg p-4 text-left">
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        <div><span class="font-medium text-gray-700">Nama Pembimbing:</span> <span id="deleteNamaPembimbingIndustri" class="text-gray-600"></span></div>
                        <div><span class="font-medium text-gray-700">Perusahaan:</span> <span id="deletePerusahaanPembimbingIndustri" class="text-gray-600"></span></div>
                        <div><span class="font-medium text-gray-700">Jabatan:</span> <span id="deleteJabatanPembimbingIndustri" class="text-gray-600"></span></div>
                    </div>
                </div>
                <p class="text-xs text-red-500 mt-3">
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex items-center justify-center space-x-3 mt-6">
                <button id="cancelDeletePembimbingIndustri" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium transition-colors">Batal</button>
                <form id="deleteFormPembimbingIndustriModal" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 font-medium transition-colors">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openDeleteModalPembimbingIndustri(id, nama, perusahaan, jabatan) {
        document.getElementById('deleteModalPembimbingIndustri').classList.remove('hidden');
        document.getElementById('deleteNamaPembimbingIndustri').textContent = nama;
        document.getElementById('deletePerusahaanPembimbingIndustri').textContent = perusahaan;
        document.getElementById('deleteJabatanPembimbingIndustri').textContent = jabatan;
        document.getElementById('deleteFormPembimbingIndustriModal').action = `/mahasiswa/pembimbingIndustri/${id}`;
    }
    document.getElementById('cancelDeletePembimbingIndustri').addEventListener('click', function() {
        document.getElementById('deleteModalPembimbingIndustri').classList.add('hidden');
    });
    document.getElementById('deleteModalPembimbingIndustri').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('deleteModalPembimbingIndustri').classList.add('hidden');
        }
    });
</script>
