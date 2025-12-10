@extends('backend.dashboard.kaprodi')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Detail Pembimbing Akademik</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
        <div class="mb-6">
            <a href="{{ route('pembimbing-akademik.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>
        
        <!-- Informasi Pembimbing -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pembimbing</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->nama }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->nip }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kontak</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->kontak }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->email }}" readonly>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Program Studi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->prodi->jurusan }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->prodi->nama_prodi }}" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Bimbingan</label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pembimbingAkademik->kapasitas_bimbingan }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kelola Mahasiswa Bimbingan -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Kelola Mahasiswa Bimbingan</h3>
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="mb-6">
                <div class="relative">
                    <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa berdasarkan nama, NIM, email, atau perusahaan..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <form action="{{ route('pembimbing-akademik.assign-mahasiswa', $pembimbingAkademik) }}" method="POST">
                @csrf
                <div id="mahasiswaList" class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4 max-h-96 overflow-y-auto">
                    @foreach($availableStudents as $mahasiswa)
                        @php
                            $pengajuanDiterima = $mahasiswa->pengajuanpkl->firstWhere('status', 'Diterima');
                        @endphp
                        @if(!$pembimbingAkademik->mahasiswas->contains($mahasiswa->id))
                        <div class="mahasiswa-item flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <input type="checkbox" name="mahasiswa_ids[]" value="{{ $mahasiswa->id }}" id="mahasiswa_{{ $mahasiswa->id }}"
                                class="mr-3">
                            <label for="mahasiswa_{{ $mahasiswa->id }}" class="text-gray-700 cursor-pointer flex-1">
                                <div class="font-medium">{{ $mahasiswa->nama }}</div>
                                <div class="text-sm text-gray-500">NIM: {{ $mahasiswa->nim }}</div>
                                <div class="text-sm text-gray-500">{{ $mahasiswa->email }}</div>
                                <div class="text-sm text-gray-500">Perusahaan: {{ $pengajuanDiterima && $pengajuanDiterima->perusahaan ? $pengajuanDiterima->perusahaan->nama_perusahaan : '-' }}</div>
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

        <!-- Daftar Mahasiswa yang Dibimbing -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Mahasiswa yang Dibimbing</h3>
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="searchTabelMahasiswa" placeholder="Cari mahasiswa berdasarkan nama, NIM, email, atau perusahaan..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            @if($pembimbingAkademik->mahasiswas->count() > 0)
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIM</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan PKL</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tabelMahasiswaBimbingan">
                            @foreach($pembimbingAkademik->mahasiswas as $i => $mahasiswa)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $i+1 }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap col-nama">
                                        <div class="text-sm font-medium text-gray-900">{{ $mahasiswa->nama }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap col-nim">
                                        <div class="text-sm text-gray-900">{{ $mahasiswa->nim }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap col-email">
                                        <div class="text-sm text-gray-900">{{ $mahasiswa->email }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap col-perusahaan">
                                        @php
                                            $pengajuanDiterima = $mahasiswa->pengajuanpkl->firstWhere('status', 'Diterima');
                                        @endphp
                                        <div class="text-sm text-gray-900">{{ $pengajuanDiterima && $pengajuanDiterima->perusahaan ? $pengajuanDiterima->perusahaan->nama_perusahaan : '-' }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('pembimbing-akademik.remove-mahasiswa', [$pembimbingAkademik, $mahasiswa]) }}" method="POST" onsubmit="return confirm('Batalkan bimbingan untuk mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 text-xs">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 18L18 6M6 6l12 12" clip-rule="evenodd" />
                                                </svg>
                                                Batalkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-4" id="mobileMahasiswaBimbingan">
                    @foreach($pembimbingAkademik->mahasiswas as $i => $mahasiswa)
                        @php
                            $pengajuanDiterima = $mahasiswa->pengajuanpkl->firstWhere('status', 'Diterima');
                        @endphp
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mobile-mahasiswa-item">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900 col-nama">{{ $mahasiswa->nama }}</div>
                                    <div class="text-sm text-gray-600 col-nim">NIM: {{ $mahasiswa->nim }}</div>
                                    <div class="text-sm text-gray-600 col-email">{{ $mahasiswa->email }}</div>
                                    <div class="text-sm text-gray-600 col-perusahaan">
                                        Perusahaan: {{ $pengajuanDiterima && $pengajuanDiterima->perusahaan ? $pengajuanDiterima->perusahaan->nama_perusahaan : '-' }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <form action="{{ route('pembimbing-akademik.remove-mahasiswa', [$pembimbingAkademik, $mahasiswa]) }}" method="POST" onsubmit="return confirm('Batalkan bimbingan untuk mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 text-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M6 18L18 6M6 6l12 12" clip-rule="evenodd" />
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-gray-500 text-center py-8">Belum ada mahasiswa yang dibimbing.</div>
            @endif
        </div>

        <script>
            // Search functionality for mahasiswa list
            document.getElementById('searchMahasiswa').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const mahasiswaItems = document.querySelectorAll('.mahasiswa-item');
                mahasiswaItems.forEach(item => {
                    const nama = item.querySelector('label .font-medium').textContent.toLowerCase();
                    const nim = item.querySelectorAll('.text-sm')[0].textContent.toLowerCase();
                    const email = item.querySelectorAll('.text-sm')[1].textContent.toLowerCase();
                    const perusahaan = item.querySelectorAll('.text-sm')[2].textContent.toLowerCase();
                    if (nama.includes(searchTerm) || nim.includes(searchTerm) || email.includes(searchTerm) || perusahaan.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
                updateSelectedCount();
            });

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('input[name="mahasiswa_ids[]"]:checked');
                document.getElementById('selectedCount').textContent = checkedBoxes.length;
            }

            document.querySelectorAll('input[name="mahasiswa_ids[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });
            updateSelectedCount();

            // Search functionality for table and mobile cards
            document.getElementById('searchTabelMahasiswa').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                // Search in desktop table
                const rows = document.querySelectorAll('#tabelMahasiswaBimbingan tr');
                rows.forEach(row => {
                    const nama = row.querySelector('.col-nama').textContent.toLowerCase();
                    const nim = row.querySelector('.col-nim').textContent.toLowerCase();
                    const email = row.querySelector('.col-email').textContent.toLowerCase();
                    const perusahaan = row.querySelector('.col-perusahaan').textContent.toLowerCase();
                    if (nama.includes(searchTerm) || nim.includes(searchTerm) || email.includes(searchTerm) || perusahaan.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Search in mobile cards
                const mobileItems = document.querySelectorAll('.mobile-mahasiswa-item');
                mobileItems.forEach(item => {
                    const nama = item.querySelector('.col-nama').textContent.toLowerCase();
                    const nim = item.querySelector('.col-nim').textContent.toLowerCase();
                    const email = item.querySelector('.col-email').textContent.toLowerCase();
                    const perusahaan = item.querySelector('.col-perusahaan').textContent.toLowerCase();
                    if (nama.includes(searchTerm) || nim.includes(searchTerm) || email.includes(searchTerm) || perusahaan.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        </script>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#mahasiswa_ids').select2({
            placeholder: 'Pilih mahasiswa',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush 