@extends('backend.dashboard.mahasiswa')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Edit Pengajuan PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
        </div>

        <div class="mb-6">
            <a href="{{ route('mahasiswa.pengajuanPKL.show', $pengajuan->id) }}"
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
            <form action="{{ route('mahasiswa.pengajuanPKL.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Mahasiswa</label>
                        <select name="mahasiswa_id" id="mahasiswa_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswas as $mahasiswa)
                                <option value="{{ $mahasiswa->id }}" {{ $pengajuan->mahasiswa_id == $mahasiswa->id ? 'selected' : '' }}>
                                    {{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="perusahaan_id" class="block text-sm font-medium text-gray-700 mb-2">Perusahaan PKL</label>
                        <select name="perusahaan_id" id="perusahaan_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih Perusahaan</option>
                            @foreach($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}" {{ $pengajuan->perusahaan_id == $perusahaan->id ? 'selected' : '' }}>
                                    {{ $perusahaan->nama_perusahaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan</label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" value="{{ date('Y-m-d') }}" readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <p class="mt-1 text-sm text-gray-500">Tanggal pengajuan otomatis hari ini</p>
                    </div>

                    <div>
                        <label for="divisi_pilihan" class="block text-sm font-medium text-gray-700 mb-2">Divisi Pilihan</label>
                        <select name="divisi_pilihan" id="divisi_pilihan" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                            @if(!isset($divisis) || $divisis->isEmpty()) disabled @endif>
                            <option value="">Pilih Divisi</option>
                            @if(isset($divisis))
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi }}" {{ old('divisi_pilihan', $pengajuan->divisi_pilihan) == $divisi ? 'selected' : '' }}>{{ $divisi }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('divisi_pilihan')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- CV Upload -->
                <div class="mt-6">
                    <label for="cv" class="block text-sm font-medium text-gray-700 mb-2">CV (Curriculum Vitae)</label>
                    
                    @if($pengajuan->cv)
                        <div class="mb-3 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-2">CV saat ini:</p>
                            <div class="flex items-center space-x-3">
                                <a href="{{ Storage::url($pengajuan->cv) }}" target="_blank" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lihat CV
                                </a>
                                <button type="button" onclick="toggleCVPreview()" 
                                        class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    Preview CV
                                </button>
                            </div>
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
                    @endif
                    
                    <input type="file" name="cv" id="cv" accept=".pdf"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="mt-1 text-xs text-gray-500">Format yang diterima: PDF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah CV.</p>
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

@push('styles')
<style>
    .select2-container--default .select2-selection--single {
        height: 42px;
        border-color: #D1D5DB;
        border-radius: 0.5rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px;
        padding-left: 1rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border-color: #D1D5DB;
        border-radius: 0.375rem;
    }
    .select2-dropdown {
        border-color: #D1D5DB;
        border-radius: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2 for mahasiswa dropdown
        $('#mahasiswa_id').select2({
            placeholder: "Cari nama atau NIM mahasiswa",
            allowClear: true,
            matcher: function(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') {
                    return data;
                }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') {
                    return null;
                }

                // Search in both name and NIM
                var searchStr = data.text.toLowerCase();
                if (searchStr.indexOf(params.term.toLowerCase()) > -1) {
                    return data;
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });

        // Initialize Select2 for perusahaan dropdown
        $('#perusahaan_id').select2({
            placeholder: "Cari Perusahaan",
            allowClear: true
        });

        $('#perusahaan_id').on('change', function() {
            var perusahaanId = $(this).val();
            if (perusahaanId) {
                $.ajax({
                    url: '/api/perusahaan/' + perusahaanId + '/divisi',
                    type: 'GET',
                    success: function(data) {
                        var divisiSelect = $('#divisi_pilihan');
                        divisiSelect.empty();
                        divisiSelect.append('<option value="">Pilih Divisi</option>');
                        if (data.length > 0) {
                            $.each(data, function(i, divisi) {
                                divisiSelect.append('<option value="' + divisi + '">' + divisi + '</option>');
                            });
                            divisiSelect.prop('disabled', false);
                        } else {
                            divisiSelect.prop('disabled', true);
                        }
                    }
                });
            } else {
                $('#divisi_pilihan').empty().append('<option value="">Pilih Divisi</option>').prop('disabled', true);
            }
        });
    });

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
@endpush 