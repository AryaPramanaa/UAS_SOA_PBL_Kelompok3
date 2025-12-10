@extends('backend.dashboard.perusahaan')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Detail Pembimbing Industri</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
        <div class="mb-6">
            <a href="{{ route('perusahaan.pembimbingIndustri.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="space-y-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pembimbing</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembimbing</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->nama_pembimbing }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->jabatan }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kontak</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->kontak }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->email }}" readonly>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Perusahaan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingIndustri->perusahaan->nama_perusahaan ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Kelola Mahasiswa Bimbingan</h3>
            
            <!-- Search Box -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa berdasarkan nama, NIM, atau email..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <form action="{{ route('perusahaan.pembimbingIndustri.assignMahasiswa', $pembimbingIndustri->id) }}" method="POST">
                @csrf
                <div id="mahasiswaList" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 max-h-96 overflow-y-auto">
                    @foreach($allMahasiswa as $mahasiswa)
                        @if(!$pembimbingIndustri->mahasiswas->contains($mahasiswa->id))
                        <div class="mahasiswa-item flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <input type="checkbox" name="mahasiswa_ids[]" value="{{ $mahasiswa->id }}" id="mahasiswa_{{ $mahasiswa->id }}"
                                class="mr-3">
                            <label for="mahasiswa_{{ $mahasiswa->id }}" class="text-gray-700 cursor-pointer flex-1">
                                <div class="font-medium">{{ $mahasiswa->nama }}</div>
                                <div class="text-sm text-gray-500">NIM: {{ $mahasiswa->nim }}</div>
                                <div class="text-sm text-gray-500">{{ $mahasiswa->email }}</div>
                            </label>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600">
                        <span id="selectedCount">0</span> mahasiswa dipilih
                    </div>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Mahasiswa
                    </button>
                </div>
            </form>
        </div>
        <!-- Tabel Mahasiswa yang Sudah Dibimbing -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Mahasiswa yang Dibimbing</h3>
            @if($pembimbingIndustri->mahasiswas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pembimbingIndustri->mahasiswas as $i => $mahasiswa)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $i+1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->nim }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $mahasiswa->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('perusahaan.pembimbingIndustri.removeMahasiswa', [$pembimbingIndustri->id, $mahasiswa->id]) }}" method="POST" onsubmit="return confirm('Batalkan bimbingan untuk mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 font-medium">
                                                Batalkan Bimbingan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-gray-500">Belum ada mahasiswa yang dibimbing.</div>
            @endif
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchMahasiswa').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const mahasiswaItems = document.querySelectorAll('.mahasiswa-item');
            let visibleCount = 0;

            mahasiswaItems.forEach(item => {
                const nama = item.querySelector('label').textContent.toLowerCase();
                const nim = item.querySelector('.text-sm').textContent.toLowerCase();
                const email = item.querySelectorAll('.text-sm')[1].textContent.toLowerCase();
                
                if (nama.includes(searchTerm) || nim.includes(searchTerm) || email.includes(searchTerm)) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Update selected count
            updateSelectedCount();
        });

        // Update selected count
        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('input[name="mahasiswa_ids[]"]:checked');
            document.getElementById('selectedCount').textContent = checkedBoxes.length;
        }

        // Listen for checkbox changes
        document.querySelectorAll('input[name="mahasiswa_ids[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });

        // Initialize count
        updateSelectedCount();
    </script>
@endsection
