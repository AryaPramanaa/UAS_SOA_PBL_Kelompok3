@extends('backend.dashboard.operator')

@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Tambah Akun</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <div class="mb-6">
            <a href="{{ route('operator.akun.index') }}"
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
            <form action="{{ route('operator.akun.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" id="username" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('username') border-red-500 @enderror">
                    @error('username')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" id="role" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('role') border-red-500 @enderror">
                        <option value="">Pilih Role</option>
                        <option value="perusahaan">Perusahaan</option>
                        <option value="kaprodi">Kaprodi</option>
                        <option value="pimpinan">Pimpinan</option>
                        <option value="operator">Operator</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="perusahaan-select-wrapper" style="display:none;">
                    <label for="perusahaan_search" class="block text-sm font-medium text-gray-700 mb-2">Pilih Perusahaan</label>
                    <input type="text" id="perusahaan_search" name="perusahaan_search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Ketik nama perusahaan" autocomplete="off" value="" />
                    <input type="hidden" name="id_perusahaan" id="id_perusahaan" value="{{ old('id_perusahaan') }}" />
                    <div id="perusahaan-suggestions" class="absolute z-10 bg-white border border-gray-300 rounded-md shadow-lg mt-1 w-full hidden"></div>
                    @error('id_perusahaan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="prodi-select-wrapper" style="display:none;">
                    <label for="prodi_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Prodi</label>
                    <select name="prodi_id" id="prodi_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('prodi_id') border-red-500 @enderror">
                        <option value="">Pilih Prodi</option>
                        @if(isset($prodis))
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama_prodi }} ({{ $prodi->nama_kaprodi }})</option>
                            @endforeach
                        @endif
                    </select>
                    @error('prodi_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const perusahaanSelectWrapper = document.getElementById('perusahaan-select-wrapper');
            const prodiSelectWrapper = document.getElementById('prodi-select-wrapper');
            function toggleSelects() {
                if (roleSelect.value === 'perusahaan') {
                    perusahaanSelectWrapper.style.display = '';
                } else {
                    perusahaanSelectWrapper.style.display = 'none';
                }
                if (roleSelect.value === 'kaprodi') {
                    prodiSelectWrapper.style.display = '';
                    document.getElementById('prodi_id').setAttribute('required', 'required');
                } else {
                    prodiSelectWrapper.style.display = 'none';
                    document.getElementById('prodi_id').removeAttribute('required');
                }
            }
            roleSelect.addEventListener('change', toggleSelects);
            toggleSelects();
        });

        // Autocomplete perusahaan pada tambah akun operator
        (function() {
            const perusahaanInput = document.getElementById('perusahaan_search');
            const perusahaanIdInput = document.getElementById('id_perusahaan');
            const suggestionsBox = document.getElementById('perusahaan-suggestions');
            if (!perusahaanInput) return;
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
                }
            });

            document.addEventListener('click', function(e) {
                if (!perusahaanInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.classList.add('hidden');
                }
            });

            perusahaanInput.addEventListener('blur', function() {
                setTimeout(() => suggestionsBox.classList.add('hidden'), 200);
            });
        })();
    </script>
@endsection
