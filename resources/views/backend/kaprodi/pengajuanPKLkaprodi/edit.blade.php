@extends('backend.dashboard.kaprodi')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Edit Status Pengajuan PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>
        <div class="mb-6">
            <a href="{{ route('kaprodi.pengajuanPKL.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
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
        <div class="mx-auto">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <form action="{{ route('kaprodi.pengajuanPKL.update', $pengajuan->id) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <!-- Student Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Mahasiswa</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->nama }}" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">NIM</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->nim }}" readonly>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-600 mb-1">Program Studi</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->prodi->nama_prodi }}" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- Company Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Perusahaan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Perusahaan</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->perusahaan->nama_perusahaan }}" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Divisi</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->divisi_pilihan }}" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- Status Update -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Update Status</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                                <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('status') border-red-500 @enderror">
                                    <option value="Pending" {{ $pengajuan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Diterima" {{ $pengajuan->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>
                            <div id="alasanPenolakan" class="@if($pengajuan->status != 'Ditolak') hidden @endif">
                                <label for="alasan_penolakan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                                <textarea name="alasan_penolakan" id="alasan_penolakan" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('alasan_penolakan') border-red-500 @enderror">{{ old('alasan_penolakan', $pengajuan->alasan_penolakan) }}</textarea>
                                @error('alasan_penolakan')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                    <!-- Action Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.getElementById('status').addEventListener('change', function() {
            const alasanPenolakan = document.getElementById('alasanPenolakan');
            if (this.value === 'Ditolak') {
                alasanPenolakan.classList.remove('hidden');
            } else {
                alasanPenolakan.classList.add('hidden');
            }
        });
    </script>
    @endpush
@endsection
