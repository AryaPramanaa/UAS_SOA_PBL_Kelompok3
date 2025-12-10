@extends('backend.dashboard.operator')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Tambah Surat PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <div class="mb-6">
            <a href="{{ route('operator.suratPKL.index') }}"
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
            <form action="{{ route('operator.suratPKL.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="perusahaan_search" class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                        <input type="text" id="perusahaan_search" name="perusahaan_search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ketik nama perusahaan" autocomplete="off" value="" />
                        <input type="hidden" name="perusahaan_id" id="perusahaan_id" value="{{ old('perusahaan_id') }}" />
                        <div id="perusahaan-suggestions" class="absolute z-10 bg-white border border-gray-300 rounded-md shadow-lg mt-1 w-full hidden"></div>
                    </div>

                    <div>
                        <label for="nomor_surat" class="block text-sm font-medium text-gray-700 mb-2">Nomor Surat</label>
                        <input type="text" name="nomor_surat" id="nomor_surat" value="{{ old('nomor_surat') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan nomor surat">
                    </div>

                    <div>
                        <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">Jenis Surat</label>
                        <input type="text" name="jenis_surat" id="jenis_surat" value="{{ old('jenis_surat') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan jenis surat">
                    </div>

                    <div id="mahasiswa-list-container" class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa Diterima di Perusahaan Ini</label>
                        <ul id="mahasiswa-list" class="list-disc pl-5 text-gray-700"></ul>
                    </div>

                    <div class="md:col-span-2">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File Surat PKL (PDF)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                        <span>Upload file</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".pdf" max="10485760">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF sampai 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan deskripsi surat PKL">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Validasi file sebelum upload
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10MB');
                    this.value = '';
                    return;
                }
                
                // Validasi tipe file
                if (file.type !== 'application/pdf') {
                    alert('File harus berformat PDF');
                    this.value = '';
                    return;
                }
            }
        });

        // Autocomplete perusahaan
        (function() {
            const perusahaanInput = document.getElementById('perusahaan_search');
            const perusahaanIdInput = document.getElementById('perusahaan_id');
            const suggestionsBox = document.getElementById('perusahaan-suggestions');
            let timeout = null;

            perusahaanInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value.trim();
                perusahaanIdInput.value = '';
                if (query.length < 2) {
                    suggestionsBox.innerHTML = '';
                    suggestionsBox.classList.add('hidden');
                    return;
                }
                timeout = setTimeout(() => {
                    fetch(`/api/perusahaan/search?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.length === 0) {
                                suggestionsBox.innerHTML = '<div class="px-3 py-2 text-gray-500">Tidak ditemukan</div>';
                                suggestionsBox.classList.remove('hidden');
                                return;
                            }
                            suggestionsBox.innerHTML = data.map(item => `<div class='px-3 py-2 hover:bg-green-100 cursor-pointer' data-id='${item.id}' data-nama='${item.nama_perusahaan.replace(/'/g, "&#39;")}' >${item.nama_perusahaan}</div>`).join('');
                            suggestionsBox.classList.remove('hidden');
                        });
                }, 250);
            });

            suggestionsBox.addEventListener('mousedown', function(e) {
                if (e.target && e.target.dataset.id) {
                    perusahaanInput.value = e.target.dataset.nama;
                    perusahaanIdInput.value = e.target.dataset.id;
                    suggestionsBox.innerHTML = '';
                    suggestionsBox.classList.add('hidden');
                    // Trigger fetch mahasiswa
                    fetchMahasiswaByPerusahaan(e.target.dataset.id);
                }
            });

            document.addEventListener('click', function(e) {
                if (!perusahaanInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.classList.add('hidden');
                }
            });

            // Jika reload dan ada value, fetch mahasiswa
            if (perusahaanIdInput.value) {
                fetchMahasiswaByPerusahaan(perusahaanIdInput.value);
            }

            // Ganti event pada perusahaanInput agar fetch mahasiswa hanya saat pilih dari suggestion
            perusahaanInput.addEventListener('blur', function() {
                setTimeout(() => suggestionsBox.classList.add('hidden'), 200);
            });

            // Fungsi fetch mahasiswa
            function fetchMahasiswaByPerusahaan(perusahaanId) {
                var mahasiswaList = document.getElementById('mahasiswa-list');
                mahasiswaList.innerHTML = '';
                if (perusahaanId) {
                    fetch('/operator/surat-pkl/mahasiswa-by-perusahaan/' + perusahaanId)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(function(mhs) {
                                    mahasiswaList.innerHTML += `<li>${mhs.nama} (${mhs.nim})</li>`;
                                });
                            } else {
                                mahasiswaList.innerHTML = '<li class="text-red-500">Tidak ada mahasiswa diterima di perusahaan ini</li>';
                            }
                        });
                } else {
                    mahasiswaList.innerHTML = '';
                }
            }
        })();
    </script>
    @endpush
@endsection 