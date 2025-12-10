@extends('backend.dashboard.mahasiswa')

@section('content')
    @if(session('refresh'))
        <script>
            // Force refresh halaman untuk memastikan data terbaru
            window.location.reload(true);
        </script>
    @endif
    
    <div class="min-h-screen py-8 px-4 md:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Edit Profil Mahasiswa</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-8 border-green-400 text-green-700 p-6 mb-6 font-sans font-semibold text-xl" role="alert">
                <p>Profil berhasil diubah.</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg p-6">
            <form action="{{ route('mahasiswa.profil.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div class="md:col-span-2">
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('username') border-red-500 @enderror"
                               value="{{ old('username', Auth::user()->username) }}" required>
                        @error('username')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- NIM -->
                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                            NIM <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nim" id="nim"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('nim') border-red-500 @enderror"
                               value="{{ old('nim', $mahasiswa->nim) }}" required>
                        @error('nim')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('nama') border-red-500 @enderror"
                               value="{{ old('nama', $mahasiswa->nama) }}" required>
                        @error('nama')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP -->
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                            No HP <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_hp" id="no_hp"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('no_hp') border-red-500 @enderror"
                               value="{{ old('no_hp', $mahasiswa->no_hp) }}" required>
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('alamat') border-red-500 @enderror"
                                  required>{{ old('alamat', $mahasiswa->alamat) }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">
                            Semester <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="semester" id="semester" min="1" max="14"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('semester') border-red-500 @enderror"
                               value="{{ old('semester', $mahasiswa->semester) }}" required>
                        @error('semester')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prodi/Jurusan -->
                    <div>
                        <label for="prodi_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Prodi/Jurusan <span class="text-red-500">*</span>
                        </label>
                        <select name="prodi_id" id="prodi_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('prodi_id') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Prodi/Jurusan</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id', $mahasiswa->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }} - {{ $prodi->jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- KTM Upload -->
                    <div class="md:col-span-2">
                        <label for="ktm" class="block text-sm font-medium text-gray-700 mb-2">
                            KTM (Kartu Tanda Mahasiswa)
                        </label>
                        
                        @if($mahasiswa->ktm)
                            <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">KTM saat ini:</p>
                                <a href="{{ Storage::url($mahasiswa->ktm) }}?v={{ time() }}" target="_blank" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lihat KTM
                                </a>
                            </div>
                        @endif
                        
                        <input type="file" name="ktm" id="ktm" accept="image/*,.pdf"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('ktm') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Format yang diterima: JPG, PNG, PDF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah KTM.</p>
                        @error('ktm')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
