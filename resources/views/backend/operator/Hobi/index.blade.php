@extends('backend.dashboard.operator')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Data Hobi</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <div class="mb-6">
            <a href="{{ route('operator.hobi.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 font-medium">
                + Tambah Hobi
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
            <form method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none" placeholder="Cari nama atau hobi">
                </div>

                <div class="md:ml-2 md:flex md:items-end">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 font-medium">Cari</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div>
                <table class="w-full table-fixed">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">NO</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">NAMA MAHASISWA</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">HOBI</th>
                            <th class="px-2 py-4 text-center text-xs font-bold text-gray-900 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($hobis as $hobi)
                            <tr class="bg-white hover:bg-gray-50">
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center">{{ $hobi->no }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center">{{ $hobi->mahasiswa?->nama ?? $hobi->nama_mahasiswa }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center">{{ $hobi->hobi }}</td>
                                <td class="px-2 py-5 text-sm font-semibold text-gray-500 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('operator.hobi.show', $hobi->id) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('operator.hobi.edit', $hobi->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form id="deleteFormHobi" action="" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-900" onclick="openDeleteModalHobi({{ $hobi->id }}, '{{ addslashes($hobi->mahasiswa?->nama ?? $hobi->nama_mahasiswa) }}')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $hobis->links() }}
        </div>

    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModalHobi" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Penghapusan</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">Apakah Anda yakin ingin menghapus hobi berikut?</p>
                    <div class="bg-gray-50 rounded-lg p-4 text-left">
                        <div class="grid grid-cols-1 gap-2 text-sm">
                            <div><span class="font-medium text-gray-700">Nama Mahasiswa:</span> <span id="deleteNamaHobi" class="text-gray-600"></span></div>
                        </div>
                    </div>
                    <p class="text-xs text-red-500 mt-3"><strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="flex items-center justify-center space-x-3 mt-6">
                    <button id="cancelDeleteHobi" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                    <form id="deleteFormHobiModal" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModalHobi(id, name) {
            document.getElementById('deleteModalHobi').classList.remove('hidden');
            document.getElementById('deleteNamaHobi').textContent = name;
            document.getElementById('deleteFormHobiModal').action = `/operator/hobi/${id}`;
        }
        document.getElementById('cancelDeleteHobi').addEventListener('click', function() {
            document.getElementById('deleteModalHobi').classList.add('hidden');
        });
        document.getElementById('deleteModalHobi').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('deleteModalHobi').classList.add('hidden');
            }
        });
    </script>
@endsection
