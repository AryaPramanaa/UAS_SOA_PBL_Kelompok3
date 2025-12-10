@extends('backend.dashboard.kaprodi')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Pengajuan PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
            @if(Auth::user()->prodi)
                <p class="text-lg text-gray-600 mt-2">Program Studi: <span class="font-semibold text-green-600">{{ Auth::user()->prodi->nama_prodi }}</span></p>
            @endif
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

        <!-- Search and Filter Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form action="{{ route('kaprodi.pengajuanPKL.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Mahasiswa</label>
                    <input type="text" name="nama" id="nama" value="{{ request('nama') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Masukkan nama mahasiswa">
                </div>

                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">Cari NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ request('nim') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Masukkan NIM">
                </div>

                <div>
                    <label for="perusahaan" class="block text-sm font-medium text-gray-700 mb-2">Cari Perusahaan</label>
                    <input type="text" name="perusahaan" id="perusahaan" value="{{ request('perusahaan') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Masukkan nama perusahaan">
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
                    <a href="{{ route('kaprodi.pengajuanPKL.index') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- tabel --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div>
                    <table class="w-full table-fixed">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NO</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NAMA</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">NIM</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">PROGRAM STUDI</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">PERUSAHAAN PKL</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">TANGGAL PENGAJUAN</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">STATUS</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">DIVISI</th>
                                <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider whitespace-nowrap">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($pengajuans as $pengajuan)
                                <tr class="bg-white hover:bg-gray-50">
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $loop->index + 1 }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $pengajuan->mahasiswa->nama }}">{{ $pengajuan->mahasiswa->nama }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ $pengajuan->mahasiswa->nim }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $pengajuan->mahasiswa->prodi->nama_prodi }}">{{ $pengajuan->mahasiswa->prodi->nama_prodi }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $pengajuan->perusahaan->nama_perusahaan }}">{{ $pengajuan->perusahaan->nama_perusahaan }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-center whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs
                                            @if($pengajuan->status == 'Pending') bg-yellow-100 text-yellow-800
                                            @elseif($pengajuan->status == 'Diterima') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $pengajuan->status }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center max-w-[120px] truncate whitespace-normal" title="{{ $pengajuan->divisi_pilihan }}">{{ $pengajuan->divisi_pilihan }}</td>
                                    <td class="px-2 py-5 text-sm font-semibold text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('kaprodi.pengajuanPKL.show', $pengajuan->id) }}"
                                                class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            @if($pengajuan->status == 'Pending')
                                                <a href="{{ route('kaprodi.pengajuanPKL.edit', $pengajuan->id) }}"
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            @if($pengajuan->status == 'Diterima' && !$pengajuan->mahasiswa->pembimbingAkademik)
                                                <a href="{{ route('pembimbing-akademik.index') }}" class="text-green-600 hover:text-green-900" title="Pasangkan Pembimbing Akademik">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            <button type="button" class="text-red-600 hover:text-red-900" 
                                                onclick="openDeleteModalPengajuan({{ $pengajuan->id }}, '{{ $pengajuan->mahasiswa->nama }}', '{{ $pengajuan->mahasiswa->nim }}', '{{ $pengajuan->perusahaan->nama_perusahaan }}', '{{ $pengajuan->divisi_pilihan }}', '{{ $pengajuan->status }}', '{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-6">
            {{ $pengajuans->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModalPengajuan" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
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
                        Apakah Anda yakin ingin menghapus pengajuan PKL berikut?
                    </p>
                    <div class="bg-gray-50 rounded-lg p-4 text-left">
                        <div class="grid grid-cols-1 gap-2 text-sm">
                            <div><span class="font-medium text-gray-700">Nama Mahasiswa:</span> <span id="deleteNamaMahasiswa" class="text-gray-600"></span></div>
                            <div><span class="font-medium text-gray-700">NIM:</span> <span id="deleteNIM" class="text-gray-600"></span></div>
                            <div><span class="font-medium text-gray-700">Perusahaan:</span> <span id="deletePerusahaan" class="text-gray-600"></span></div>
                            <div><span class="font-medium text-gray-700">Divisi:</span> <span id="deleteDivisi" class="text-gray-600"></span></div>
                            <div><span class="font-medium text-gray-700">Status:</span> <span id="deleteStatus" class="text-gray-600"></span></div>
                            <div><span class="font-medium text-gray-700">Tanggal Pengajuan:</span> <span id="deleteTanggal" class="text-gray-600"></span></div>
                        </div>
                    </div>
                    <p class="text-xs text-red-500 mt-3">
                        <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex items-center justify-center space-x-3 mt-6">
                    <button id="cancelDeletePengajuan" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium transition-colors">Batal</button>
                    <form id="deleteFormPengajuanModal" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 font-medium transition-colors">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModalPengajuan(id, namaMahasiswa, nim, perusahaan, divisi, status, tanggal) {
            document.getElementById('deleteModalPengajuan').classList.remove('hidden');
            document.getElementById('deleteNamaMahasiswa').textContent = namaMahasiswa;
            document.getElementById('deleteNIM').textContent = nim;
            document.getElementById('deletePerusahaan').textContent = perusahaan;
            document.getElementById('deleteDivisi').textContent = divisi;
            document.getElementById('deleteStatus').textContent = status;
            document.getElementById('deleteTanggal').textContent = tanggal;
            document.getElementById('deleteFormPengajuanModal').action = `/kaprodi/pengajuanPKL/${id}`;
        }
        
        document.getElementById('cancelDeletePengajuan').addEventListener('click', function() {
            document.getElementById('deleteModalPengajuan').classList.add('hidden');
        });
        
        document.getElementById('deleteModalPengajuan').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('deleteModalPengajuan').classList.add('hidden');
            }
        });
    </script>
@endsection
