@extends('backend.dashboard.mahasiswa')
@section('content')
    <div class="min-h-screen py-8 px-4 md:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('mahasiswa.pengajuanPKL.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-3">Pengajuan PKL</h1>
            <div class="w-40 h-1 bg-green-500 mx-auto"></div>
            <p class="text-gray-600 mt-4">Silakan lengkapi formulir di bawah ini untuk mengajukan PKL</p>
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

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('mahasiswa.pengajuanPKL.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Mahasiswa & Perusahaan Selection -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="mahasiswa_id" class="text-base font-semibold text-gray-700">Nama Mahasiswa</label>
                        <select id="mahasiswa_id" name="mahasiswa_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm select2">
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswas as $mahasiswa)
                                <option value="{{ $mahasiswa->id }}" data-nim="{{ $mahasiswa->nim }}"
                                    @if(old('mahasiswa_id') == $mahasiswa->id) selected @endif>
                                    {{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="perusahaan_id" class="text-base font-semibold text-gray-700">Perusahaan PKL</label>
                        <select id="perusahaan_id" name="perusahaan_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm select2">
                            <option value="">Pilih Perusahaan</option>
                            @foreach($perusahaans as $perusahaan)
                                <option value="{{ $perusahaan->id }}"
                                    @if(old('perusahaan_id', isset($selectedLowongan) ? $selectedLowongan->perusahaan_id : null) == $perusahaan->id) selected @endif>
                                    {{ $perusahaan->nama_perusahaan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Tanggal dan Divisi -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="tanggal_pengajuan" class="text-base font-semibold text-gray-700">Tanggal Pengajuan</label>
                        <input type="date" id="tanggal_pengajuan" name="tanggal_pengajuan" required
                            value="{{ date('Y-m-d') }}" readonly
                            class="w-full h-[42px] rounded-lg border-gray-300 bg-gray-50 focus:border-green-500 focus:ring-green-500 shadow-sm">
                        <p class="text-sm text-gray-500">Tanggal pengajuan otomatis hari ini</p>
                    </div>
                    <div class="space-y-2">
                        <label for="divisi_pilihan" class="text-base font-semibold text-gray-700">Divisi Pilihan</label>
                        <select id="divisi_pilihan" name="divisi_pilihan" required
                            class="w-full h-[42px] rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm"
                            @if(!isset($divisis) || $divisis->isEmpty()) disabled @endif>
                            <option value="">Pilih Divisi</option>
                            @if(isset($divisis))
                                @foreach($divisis as $divisi)
                                    <option value="{{ $divisi }}" {{ old('divisi_pilihan', isset($selectedLowongan) ? $selectedLowongan->divisi : '') == $divisi ? 'selected' : '' }}>{{ $divisi }}</option>
                                @endforeach
                            @endif
                        </select>
                        <p class="text-sm text-gray-500">Pilih divisi yang tersedia di perusahaan PKL</p>
                    </div>
                </div>

                <!-- CV Upload -->
                <div class="space-y-2">
                    <label for="cv" class="text-base font-semibold text-gray-700">Upload CV (Curriculum Vitae)</label>
                    <input type="file" id="cv" name="cv" accept=".pdf" required
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm">
                    <p class="text-sm text-gray-500">Format yang diterima: PDF. Maksimal 2MB. CV akan digunakan untuk evaluasi pengajuan PKL.</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Ajukan PKL
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
</script>
@endpush