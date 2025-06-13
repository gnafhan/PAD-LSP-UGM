@extends('home.home-visitor.layouts.layout')

@section('title', 'Data Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="bg-gray-100 min-h-screen py-32 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl mx-auto overflow-hidden">
        <!-- Header Section -->
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Formulir Permohonan Sertifikasi Kompetensi
            </h2>
        </div>

        <!-- Progress Indicator -->
        <div class="px-8 pt-6">
            <div class="flex flex-wrap justify-between items-center mb-8">
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs mt-2 text-gray-600">Data Pribadi</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-blue-200"></div>
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">2</div>
                    <span class="text-xs mt-2 text-blue-800 font-semibold">Data Sertifikasi</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-semibold">3</div>
                    <span class="text-xs mt-2 text-gray-600">Bukti Kelengkapan</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-semibold">4</div>
                    <span class="text-xs mt-2 text-gray-600">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Alert Message Container -->
        <div id="message" class="px-8 mt-4"></div>

        @if(isset($revisionMessage))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-sm text-red-700 font-medium">{{ $revisionMessage }}</p>
                </div>
            </div>
        @endif

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <span class="font-medium">Perhatian:</span> Data yang Anda isi disimpan sebagai draft. Pastikan melengkapi semua field dengan benar.
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Form Content -->
        <div class="p-8">
            <div class="mb-6">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">Data Sertifikasi</h3>
                </div>

                <p class="text-sm text-gray-600 mb-6 pl-11">Tuliskan Judul dan Nomor Skema Sertifikasi, Tujuan Asesmen serta Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi yang Anda ajukan.</p>
            </div>

            <form id="sertifikasiForm" method="POST" action="{{ route('user.apl1.save.data.sertifikasi') }}">
                @csrf

                <!-- Certification Details -->
                <div class="bg-gray-50 p-6 rounded-lg mb-8 border border-gray-100 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="skema_sertifikasi" class="block text-sm font-medium text-gray-700 mb-1">Skema Sertifikasi</label>
                            <select id="skema_sertifikasi" name="skema_sertifikasi" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Pilih Jenis Skema</option>
                                <option value="kkni" {{ ($pengajuan->skema_sertifikasi ?? old('skema_sertifikasi')) == 'kkni' ? 'selected' : '' }}>KKNI</option>
                                <option value="okupasi" {{ ($pengajuan->skema_sertifikasi ?? old('skema_sertifikasi')) == 'okupasi' ? 'selected' : '' }}>Okupasi</option>
                                <option value="klaster" {{ ($pengajuan->skema_sertifikasi ?? old('skema_sertifikasi')) == 'klaster' ? 'selected' : '' }}>Klaster</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="skemaDropdown" class="block text-sm font-medium text-gray-700 mb-1">Judul Skema Sertifikasi</label>
                            <select id="skemaDropdown" name="skemaDropdown" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Pilih Skema</option>
                                @foreach($skemaList as $skema)
                                    <option value="{{ $skema->id_skema }}" {{ ($pengajuan->nama_skema ?? old('skemaDropdown')) == $skema->nama_skema ? 'selected' : '' }}>{{ $skema->nama_skema }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="nomorSkemaInput" class="block text-sm font-medium text-gray-700 mb-1">Nomor Skema Sertifikasi</label>
                            <input type="text" id="nomorSkemaInput" name="nomorSkemaInput" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 bg-gray-100" value="{{ $pengajuan->nomor_skema ?? old('nomorSkemaInput') }}" readonly>
                        </div>

                        <!-- Tambahkan ini setelah div nomor skema sertifikasi dan sebelum tujuan asesmen -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen SKKNI</label>
                            <div id="dokumen-skkni-container" class="mt-2">
                                <div id="dokumen-skkni-placeholder" class="h-48 flex flex-col items-center justify-center bg-gray-50 rounded border border-dashed border-gray-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Pilih skema terlebih dahulu untuk melihat dokumen SKKNI</p>
                                </div>
                                <div id="dokumen-skkni-viewer" class="hidden">
                                    <div class="pdf-container border rounded-lg overflow-hidden h-64">
                                        <object id="dokumen-skkni-object" data="" type="application/pdf" width="100%" height="100%">
                                            <iframe id="dokumen-skkni-iframe" src="" width="100%" height="100%" frameborder="0">
                                                Browser tidak mendukung tampilan PDF. <a id="dokumen-skkni-link" href="" target="_blank">Klik untuk mengunduh</a>
                                            </iframe>
                                        </object>
                                    </div>
                                    <div class="mt-2 flex justify-end">
                                        <a id="dokumen-skkni-fullscreen" href="" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                            Buka di tab baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="tujuan_asesmen" class="block text-sm font-medium text-gray-700 mb-1">Tujuan Asesmen</label>
                            <select id="tujuan_asesmen" name="tujuan_asesmen" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Pilih Tujuan Asesmen</option>
                                <option value="sertifikasi" {{ ($pengajuan->tujuan_asesmen ?? old('tujuan_asesmen')) == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                <option value="pkt" {{ ($pengajuan->tujuan_asesmen ?? old('tujuan_asesmen')) == 'pkt' ? 'selected' : '' }}>Pengakuan Kompetensi Terkini (PKT)</option>
                                <option value="rpl" {{ ($pengajuan->tujuan_asesmen ?? old('tujuan_asesmen')) == 'rpl' ? 'selected' : '' }}>Rekognisi Pembelajaran Lampau (RPL)</option>
                                <option value="lainnya" {{ ($pengajuan->tujuan_asesmen ?? old('tujuan_asesmen')) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Competency Units Table -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Unit Kompetensi</h3>
                    </div>

                    <p class="text-sm text-gray-600 mb-4 pl-11">Unit kompetensi akan otomatis muncul setelah memilih skema sertifikasi.</p>

                    <div class="bg-white overflow-hidden border border-gray-200 rounded-lg shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">No.</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Unit</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Unit</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Standar</th>
                                    </tr>
                                </thead>
                                <tbody id="ukTableBody" class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-sm text-gray-500 text-center">
                                            <div class="flex flex-col items-center justify-center py-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                Pilih skema sertifikasi untuk menampilkan unit kompetensi
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="empty-uk-message" class="hidden mt-3 text-sm text-gray-500 pl-11">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tidak ada unit kompetensi yang tersedia untuk skema ini.
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between">
            <a href="{{ route('user.apl1.pribadi') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            <button type="button" id="btn-selanjutnya" class="px-4 py-2 rounded-md border border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                <span id="button-text">Simpan & Lanjutkan</span>
                <span id="button-loading" class="hidden ml-1">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Load initial data if skema is already selected
        const initialSkema = $('#skemaDropdown').val();
        if (initialSkema) {
            loadUnitKompetensi(initialSkema);
        }

        // Function to load unit kompetensi
        function loadUnitKompetensi(idSkema) {
            // Show loading state in table
            $('#ukTableBody').html(`
                <tr>
                    <td colspan="4" class="px-4 py-4 text-sm text-center">
                        <div class="flex flex-col items-center justify-center py-6">
                            <svg class="animate-spin h-8 w-8 text-blue-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memuat unit kompetensi...</span>
                        </div>
                    </td>
                </tr>
            `);

            // AJAX untuk mendapatkan daftar UK berdasarkan skema
            $.get('/user/apl1/get-daftar-uk', { id_skema: idSkema }, function(response) {
                $('#ukTableBody').empty();
                $('#empty-uk-message').addClass('hidden');

                if (response.ukList && response.ukList.length > 0) {
                    response.ukList.forEach(function(uk, index) {
                        $('#ukTableBody').append(`
                            <tr class="${index % 2 === 0 ? 'bg-white hover:bg-blue-50' : 'bg-gray-50 hover:bg-blue-50'} transition-colors">
                                <td class="px-4 py-3 text-sm text-gray-900 text-center font-medium">${index + 1}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-mono">${uk.kode_uk}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">${uk.nama_uk}</td>
                                <td class="px-4 py-3 text-sm text-gray-900">${uk.jenis_standar}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#ukTableBody').html(`
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-sm text-gray-500 text-center">
                                <div class="flex flex-col items-center justify-center py-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Tidak ada unit kompetensi yang tersedia untuk skema ini
                                </div>
                            </td>
                        </tr>
                    `);
                    $('#empty-uk-message').removeClass('hidden');
                }
            }).fail(function() {
                $('#ukTableBody').html(`
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-sm text-red-500 text-center">
                            <div class="flex flex-col items-center justify-center py-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Terjadi kesalahan saat memuat data unit kompetensi
                            </div>
                        </td>
                    </tr>
                `);
            });
        }

        // Highlight selected form elements
        const formInputs = document.querySelectorAll('select, input');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.add('border-blue-300', 'ring-2', 'ring-blue-100');
            });

            input.addEventListener('blur', function() {
                this.classList.remove('border-blue-300', 'ring-2', 'ring-blue-100');
            });
        });

        // Skema dropdown change handler
        $('#skemaDropdown').change(function() {
            const idSkema = $(this).val();

            if (idSkema) {
                // Get nomor skema
                $.get('/user/apl1/get-nomor-skema', { id_skema: idSkema }, function(response) {
                    $('#nomorSkemaInput').val(response.nomor_skema || '');
                    $('#tujuan_asesmen').val(response.tujuan_asesmen || 'sertifikasi');

                    // Tambahkan kode untuk menampilkan dokumen SKKNI
                    if (response.dokumen_skkni) {
                        const dokumenUrl = "{{ asset('storage/') }}/" + response.dokumen_skkni;
                        const googleViewerUrl = "https://docs.google.com/viewer?url=" + encodeURIComponent(dokumenUrl) + "&embedded=true";

                        $('#dokumen-skkni-object').attr('data', dokumenUrl);
                        $('#dokumen-skkni-iframe').attr('src', googleViewerUrl);
                        $('#dokumen-skkni-link').attr('href', dokumenUrl);
                        $('#dokumen-skkni-fullscreen').attr('href', dokumenUrl);

                        $('#dokumen-skkni-placeholder').addClass('hidden');
                        $('#dokumen-skkni-viewer').removeClass('hidden');
                    } else {
                        // Jika tidak ada dokumen, tampilkan placeholder
                        $('#dokumen-skkni-placeholder').removeClass('hidden')
                            .find('p').text('Dokumen SKKNI tidak tersedia untuk skema ini');
                        $('#dokumen-skkni-viewer').addClass('hidden');
                    }
                });

                // Load unit kompetensi
                loadUnitKompetensi(idSkema);
            } else {
                // Reset fields when no scheme is selected
                $('#nomorSkemaInput').val('');
                $('#tujuan_asesmen').val('');

                // Reset dokumen SKKNI
                $('#dokumen-skkni-placeholder').removeClass('hidden')
                    .find('p').text('Pilih skema terlebih dahulu untuk melihat dokumen SKKNI');
                $('#dokumen-skkni-viewer').addClass('hidden');

                // Reset unit kompetensi
                $('#ukTableBody').html(`
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-sm text-gray-500 text-center">
                            <div class="flex flex-col items-center justify-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Pilih skema sertifikasi untuk menampilkan unit kompetensi
                            </div>
                        </td>
                    </tr>
                `);
                $('#empty-uk-message').addClass('hidden');
            }
        });

        // Form submission handler
        $('#btn-selanjutnya').click(function(event) {
            event.preventDefault();

            // Show loading state
            const buttonText = document.getElementById('button-text');
            const buttonLoading = document.getElementById('button-loading');

            buttonText.textContent = 'Menyimpan...';
            buttonLoading.classList.remove('hidden');
            $('#btn-selanjutnya').prop('disabled', true);

            // Get form values
            const skemaSertifikasi = $('#skema_sertifikasi').val();
            const skemaDropdown = $('#skemaDropdown').val();
            const nomorSkemaInput = $('#nomorSkemaInput').val();
            const tujuanAsesmen = $('#tujuan_asesmen').val();

            // Validate form
            let errorMessage = '';

            if (!skemaSertifikasi) {
                errorMessage = 'Pilih jenis skema sertifikasi';
            } else if (!skemaDropdown) {
                errorMessage = 'Pilih judul skema sertifikasi';
            } else if (!tujuanAsesmen) {
                errorMessage = 'Pilih tujuan asesmen';
            }

            if (errorMessage) {
                // Reset button state
                buttonText.textContent = 'Simpan & Lanjutkan';
                buttonLoading.classList.add('hidden');
                $('#btn-selanjutnya').prop('disabled', false);

                // Show error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Formulir Belum Lengkap',
                    text: errorMessage,
                    confirmButtonColor: '#3B82F6'
                });

                return;
            }

            // Submit form via AJAX
            $.ajax({
                type: 'POST',
                url: "{{ route('user.apl1.save.data.sertifikasi') }}",
                data: {
                    skema_sertifikasi: skemaSertifikasi,
                    skemaDropdown: skemaDropdown,
                    nomorSkemaInput: nomorSkemaInput,
                    tujuan_asesmen: tujuanAsesmen,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Tersimpan!',
                        text: 'Data sertifikasi Anda berhasil disimpan.',
                        confirmButtonColor: '#3B82F6'
                    }).then(() => {
                        window.location.href = "{{ route('user.apl1.bukti') }}";
                    });
                },
                error: function(xhr, status, error) {
                    // Reset button state
                    buttonText.textContent = 'Simpan & Lanjutkan';
                    buttonLoading.classList.add('hidden');
                    $('#btn-selanjutnya').prop('disabled', false);

                    // Handle validation errors
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorHtml = '<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">';
                        errorHtml += '<div class="flex items-center">';
                        errorHtml += '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
                        errorHtml += '<p class="text-sm text-red-700 font-medium">Periksa kembali data yang Anda masukkan:</p>';
                        errorHtml += '</div><ul class="mt-2 text-sm text-red-700 pl-6 list-disc">';

                        Object.keys(errors).forEach(key => {
                            errors[key].forEach(message => {
                                errorHtml += `<li>${message}</li>`;
                            });
                        });

                        errorHtml += '</ul></div>';

                        $('#message').html(errorHtml);

                        // Scroll to error message
                        $('html, body').animate({
                            scrollTop: $('#message').offset().top - 100
                        }, 200);
                    } else {
                        // General error
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data. Silakan coba lagi.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
