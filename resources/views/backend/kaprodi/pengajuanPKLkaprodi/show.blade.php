@extends('backend.dashboard.kaprodi')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Detail Pengajuan PKL</h1>
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
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mahasiswa</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->nama }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->nim }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->mahasiswa->prodi->nama_prodi }}" readonly>
                </div>
                @if($pengajuan->mahasiswa->ktm)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KTM (Kartu Tanda Mahasiswa)</label>
                    <div class="flex items-center space-x-3">
                        <a href="{{ Storage::url($pengajuan->mahasiswa->ktm) }}" target="_blank" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Lihat KTM
                        </a>
                    </div>
                </div>
                @endif
                @if($pengajuan->cv)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CV (Curriculum Vitae)</label>
                    <div class="flex items-center space-x-3 mb-3">
                        <a href="{{ Storage::url($pengajuan->cv) }}" target="_blank" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Lihat CV
                        </a>
                        <button onclick="toggleCVPreview()" 
                                class="inline-flex items-center px-3 py-2 border border-blue-300 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            Preview CV
                        </button>
                    </div>
                    
                    <!-- PDF Preview Modal -->
                    <div id="cvPreviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                        <div class="relative top-4 mx-auto p-5 border w-11/12 h-5/6 shadow-lg rounded-xl bg-white">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Preview CV</h3>
                                <button onclick="toggleCVPreview()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="h-full">
                                <iframe src="{{ Storage::url($pengajuan->cv) }}#toolbar=0" 
                                        class="w-full h-full border-0 rounded-lg"
                                        frameborder="0">
                                    <p>Browser Anda tidak mendukung preview PDF. 
                                        <a href="{{ Storage::url($pengajuan->cv) }}" target="_blank" class="text-blue-600 hover:text-blue-800">Klik di sini untuk membuka CV</a>
                                    </p>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->perusahaan->nama_perusahaan }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Perusahaan</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" rows="2" readonly>{{ $pengajuan->perusahaan->alamat }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Divisi</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ $pengajuan->divisi_pilihan }}" readonly>
                </div>
            </div>
            <!-- Detail Pengajuan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" value="{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 @if($pengajuan->status == 'Pending') text-yellow-800 @elseif($pengajuan->status == 'Diterima') text-green-800 @else text-red-800 @endif" value="{{ $pengajuan->status }}" readonly>
                </div>
                @if($pengajuan->status == 'Ditolak')
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100" rows="3" readonly>{{ $pengajuan->alasan_penolakan }}</textarea>
                </div>
                @endif
            </div>
            @if($pengajuan->status == 'Diterima')
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pembimbing Akademik</label>
                    @if($pengajuan->mahasiswa->pembimbingAkademik && $pengajuan->mahasiswa->pembimbingAkademik->count())
                        <ul class="list-disc pl-5">
                            @foreach($pengajuan->mahasiswa->pembimbingAkademik as $pembimbing)
                                <li class="text-sm text-gray-900">{{ $pembimbing->nama }} (NIP: {{ $pembimbing->nip ?? '-' }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Belum ada pembimbing akademik yang dipasangkan.</p>
                    @endif
                </div>
            @endif
            <!-- Tombol kembali sudah di atas, tidak perlu tombol di bawah -->
        </div>
    </div>
@endsection

<script>
    function toggleCVPreview() {
        const modal = document.getElementById('cvPreviewModal');
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('cvPreviewModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    toggleCVPreview();
                }
            });
        }
    });
</script> 