@extends('backend.dashboard.perusahaan')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Pembimbing Industri</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
        <div class="mb-6">
            <a href="{{ route('perusahaan.pembimbingIndustri.create') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Pembimbing Industri
            </a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div>
                <table class="w-full min-w-max table-auto border-collapse">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap w-12">NO</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap w-1/4">NAMA PEMBIMBING</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap w-1/4">JABATAN</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap w-1/4">KAPASITAS BIMBINGAN</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap w-32">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pembimbing as $index => $item)
                            <tr class="bg-white hover:bg-gray-50 text-center">
                                <td class="px-4 py-5 text-sm font-semibold text-gray-500 whitespace-nowrap">{{ $index + 1 }}</td>
                                <td class="px-4 py-5 text-sm font-semibold text-gray-500 whitespace-nowrap">{{ $item->nama_pembimbing }}</td>
                                <td class="px-4 py-5 text-sm font-semibold text-gray-500 whitespace-nowrap">{{ $item->jabatan }}</td>
                                <td class="px-4 py-5 text-sm font-semibold text-gray-500 whitespace-nowrap">{{ $item->kapasitas_bimbingan ?? '-' }}</td>
                                <td class="px-4 py-5 text-sm font-semibold text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('perusahaan.pembimbingIndustri.show', $item->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('perusahaan.pembimbingIndustri.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form id="deleteFormPembimbingIndustri{{ $item->id }}" action="{{ route('perusahaan.pembimbingIndustri.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900" onclick="openDeleteModalPembimbingIndustri({{ $item->id }}, '{{ $item->nama_pembimbing }}', '-', '{{ $item->jabatan }}')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-400 text-base ">Tidak ada data pembimbing industri</td>
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
            document.getElementById('deleteFormPembimbingIndustriModal').action = `/perusahaan/pembimbingIndustri/${id}`;
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
@endsection
