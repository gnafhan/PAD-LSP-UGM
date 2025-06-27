@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Asesmen Mandiri - Lembaga Sertifikasi Profesi UGM')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <!-- Kontainer Utama -->
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="hidden text-center py-8">
                    <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-blue-500 transition ease-in-out duration-150">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memuat data asesmen mandiri...
                    </div>
                </div>

                <!-- Error Message -->
                <div id="errorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span id="errorText">Terjadi kesalahan saat memuat data.</span>
                </div>

                <!-- Success Message -->
                <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span id="successText">Data berhasil disimpan.</span>
                </div>

                <!-- Main Content -->
                <div id="mainContent" class="hidden">
                    <!-- Tombol Aksi -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-4 py-2 rounded-md text-sm md:text-base flex-shrink-0 flex items-center transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </button>
                        <div class="bg-green-500 text-white px-4 py-2 rounded-md text-sm md:text-base flex-shrink-0 font-medium">
                            FR.APL.02 ASESMEN MANDIRI
                        </div>
                    </div>

                    <!-- Judul Halaman -->
                    <h2 class="text-xl font-bold mb-6 text-gray-800">FR-APL-02 ASESMEN MANDIRI</h2>

                    <!-- Info Section -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Panduan:</strong> Pastikan Anda telah mempelajari seluruh unit kompetensi sebelum melakukan asesmen mandiri.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Struktur Tabel Informasi -->
                    <div class="border border-gray-300 rounded-lg p-6 mb-6 bg-white shadow-sm">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Asesmen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-600">Judul Skema Sertifikasi</label>
                                    <p id="judulSkema" class="text-gray-800 font-medium">Memuat...</p>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-600">Nomor Skema Sertifikasi</label>
                                    @php
                                    $asesi = App\Models\Asesi::where('id_user', auth()->user()->id_user)->first();
                                    @endphp
                                    <p id="nomorSkema" class="text-gray-800">{{ $asesi->skema->nomor_skema ?? 'Memuat...' }}</p>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-600">TUK</label>
                                    <p id="namaTuk" class="text-gray-800">Memuat...</p>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-600">Nama Asesor</label>
                                    @php
                                    $rincianAsesmen = App\Models\RincianAsesmen::where('id_asesi', $asesi->id_asesi ?? null)->first();
                                    $asesor = $rincianAsesmen->asesor ?? null;
                                    @endphp
                                    <p id="namaAsesor" class="text-gray-800">{{ $asesor->nama_asesor ?? 'Memuat...' }}</p>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-600">Nama Peserta</label>
                                    <p id="namaAsesi" class="text-gray-800">{{ $asesi->nama_asesi ?? 'Memuat...' }}</p>
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-sm font-medium text-gray-600">Tanggal</label>
                                    <p id="tanggalHariIni" class="text-gray-800">{{ now()->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instruksi untuk Peserta -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Instruksi untuk Peserta</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700 mb-3">Peserta diminta untuk:</p>
                            <ul class="list-disc ml-5 space-y-2 text-sm text-gray-700">
                                <li>Mempelajari Kriteria Unjuk Kerja (KUK), Batasan Variabel, Panduan Penilaian, dan Aspek Kritis seluruh Unit Kompetensi yang diminta untuk di Ases.</li>
                                <li>Melaksanakan Penilaian Mandiri secara obyektif atas sejumlah pertanyaan yang diajukan.</li>
                                <li>Mengisi bukti-bukti kompetensi yang relevan atas sejumlah pertanyaan yang dinyatakan Kompeten (bila ada).</li>
                                <li>Menandatangani form Asesmen Mandiri.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bukti Kompetensi -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Bukti Kompetensi</h3>
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <button id="tambahBukti" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors mb-4">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Bukti
                            </button>
                            <div class="overflow-x-auto">
                                <table id="tabelBukti" class="w-full border border-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="border border-gray-300 p-3 text-left font-semibold text-gray-700">Bukti Portfolio yang relevan</th>
                                            <th class="border border-gray-300 p-3 text-left font-semibold text-gray-700">Keterangan</th>
                                            <th class="border border-gray-300 p-3 text-center font-semibold text-gray-700 w-24">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dynamic content -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Kompetensi -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Unit Kompetensi</h3>
                        <div id="unitKompetensiContainer">
                            <!-- Will be populated dynamically -->
                        </div>
                    </div>

                    <!-- Tanda Tangan Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Tanda Tangan</h3>
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Tanda Tangan Asesor (Read-only) -->
                                <div class="flex flex-col items-center">
                                    <h4 class="font-medium text-gray-700 mb-2">Tanda Tangan Asesor</h4>
                                    <p id="tanggalTtdAsesor" class="text-sm text-gray-600 mb-3">-</p>

                                    <!-- Container untuk tanda tangan asesor -->
                                    <div id="tandaTanganAsesorContainer" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <p id="tandaTanganAsesorPlaceholder" class="text-gray-400 text-center px-4 text-sm">Menunggu tanda tangan dari asesor</p>
                                        <img id="tandaTanganAsesor" src="" alt="Tanda Tangan Asesor" class="w-full h-full object-contain hidden rounded">
                                    </div>

                                    <p class="font-medium text-gray-700 mt-3">Asesor</p>
                                    <p id="namaAsesorTtd" class="text-sm text-gray-600">{{ $asesor->nama_asesor ?? '-' }}</p>
                                </div>

                                <!-- Tanda Tangan Asesi -->
                                <div class="flex flex-col items-center">
                                    <h4 class="font-medium text-gray-700 mb-2">Tanda Tangan Asesi</h4>
                                    <p id="tanggalTtdAsesi" class="text-sm text-gray-600 mb-3">-</p>

                                    <!-- Container untuk tanda tangan asesi -->
                                    <div id="tandaTanganAsesiContainer" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <p id="tandaTanganAsesiPlaceholder" class="text-gray-400 text-center px-4 text-sm">Tanda tangan akan ditampilkan setelah menyetujui formulir</p>
                                        <img id="tandaTanganAsesi" src="" alt="Tanda Tangan Asesi" class="w-full h-full object-contain hidden rounded">
                                    </div>

                                    <!-- Checkbox untuk persetujuan -->
                                    <div class="mt-3 flex items-center">
                                        <input id="is_asesi_signing" name="is_asesi_signing" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="is_asesi_signing" class="ms-2 text-sm font-medium text-gray-700">Saya setuju menandatangani formulir ini</label>
                                    </div>

                                    <p class="font-medium text-gray-700 mt-3">Asesi</p>
                                    <p id="namaAsesiTtd" class="text-sm text-gray-600">{{ $asesi->nama_asesi ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="flex justify-end space-x-4">
                        <button id="btnSetujui" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed disabled:hover:bg-gray-400" disabled>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Saya Setuju
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk Upload Area -->
<style>
#tandaTanganAsesi, #tandaTanganAsesor {
    max-width: 100%;
    max-height: 100%;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    background: white;
    padding: 4px;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Style untuk checkbox yang disabled */
input[type="checkbox"]:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Style untuk form yang dikunci */
.form-locked {
    pointer-events: none;
    opacity: 0.8;
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesiId: @json($asesi->id_asesi ?? null),
        asesorId: @json($rincianAsesmen->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    // Global variables
    let currentApl02Data = null;
    let isFormLocked = false;

    // Function to show error message
    function showError(message) {
        @if(config('app.debug'))
        console.error('Error:', message);
        @endif
        document.getElementById('errorText').textContent = message;
        document.getElementById('errorMessage').classList.remove('hidden');
        hideOtherMessages('error');
    }

    // Function to show success message
    function showSuccess(message) {
        @if(config('app.debug'))
        console.log('Success:', message);
        @endif
        document.getElementById('successText').textContent = message;
        document.getElementById('successMessage').classList.remove('hidden');
        hideOtherMessages('success');
    }

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        showError('Konfigurasi API URL tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.key) {
        showError('Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.asesiId) {
        showError('ID Asesi tidak ditemukan. Silakan login kembali.');
        return;
    }

    if (!apiConfig.asesorId) {
        showError('ID Asesor tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    // Build API URLs dynamically
    const apl02ApiUrl = `${apiConfig.url}/asesmen/apl02/asesi/${apiConfig.asesiId}`;
    const saveApiUrl = `${apiConfig.url}/asesmen/apl02/asesi/sign`;

    // API Headers for JSON requests
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API_KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // Debug info - only in development
    @if(config('app.debug'))
    console.log('Debug Info:', {
        asesiId: apiConfig.asesiId,
        asesorId: apiConfig.asesorId,
        csrfToken: apiConfig.csrfToken ? 'Present' : 'Missing',
        apiKey: apiConfig.key ? 'Present' : 'Missing',
        apiUrl: apiConfig.url
    });
    @endif

    // DOM elements
    const elements = {
        signingCheckbox: document.getElementById('is_asesi_signing'),
        submitButton: document.getElementById('btnSetujui'),
        tandaTanganAsesiPlaceholder: document.getElementById('tandaTanganAsesiPlaceholder'),
        tandaTanganAsesi: document.getElementById('tandaTanganAsesi'),
        tandaTanganAsesorPlaceholder: document.getElementById('tandaTanganAsesorPlaceholder'),
        tandaTanganAsesor: document.getElementById('tandaTanganAsesor'),
        tanggalTtdAsesi: document.getElementById('tanggalTtdAsesi'),
        tanggalTtdAsesor: document.getElementById('tanggalTtdAsesor'),
        namaAsesiTtd: document.getElementById('namaAsesiTtd'),
        namaAsesorTtd: document.getElementById('namaAsesorTtd')
    };

    // Utility functions
    function showLoading(show = true) {
        const loadingDiv = document.getElementById('loadingIndicator');
        const mainContent = document.getElementById('mainContent');

        if (show) {
            loadingDiv.classList.remove('hidden');
            mainContent.classList.add('hidden');
        } else {
            loadingDiv.classList.add('hidden');
            mainContent.classList.remove('hidden');
        }
    }

    function hideOtherMessages(except) {
        const messages = ['errorMessage', 'successMessage'];
        messages.forEach(msgId => {
            if (msgId !== except + 'Message') {
                document.getElementById(msgId).classList.add('hidden');
            }
        });
    }

    function formatDateFromWIB(dateString) {
        if (!dateString) return '-';

        try {
            // Parse WIB format date string (e.g., "17-06-2025 02:17:01 WIB")
            const datePart = dateString.split(' ')[0]; // Get "17-06-2025"
            const [day, month, year] = datePart.split('-');

            // Create date object
            const date = new Date(year, month - 1, day);

            if (isNaN(date.getTime())) return dateString; // Return original if invalid

            return date.toLocaleDateString('id-ID');
        } catch (e) {
            @if(config('app.debug'))
            console.error('Error formatting date:', e);
            @endif
            return dateString; // Return original on error
        }
    }

    // Function to build proper image URL
    function buildImageUrl(imagePath) {
        if (!imagePath || imagePath === 'null' || imagePath === null) {
            return null;
        }

        const baseUrl = "{{ url('') }}";

        // If already a full URL, return as is
        if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
            return imagePath;
        }

        // If starts with /storage/, use as is with base URL
        if (imagePath.startsWith('/storage/')) {
            return baseUrl + imagePath;
        }

        // If starts with storage/ (without leading slash), add base URL with /
        if (imagePath.startsWith('storage/')) {
            return baseUrl + '/' + imagePath;
        }

        // For any other path, assume it needs /storage/ prefix
        return baseUrl + '/storage/' + imagePath.replace(/^\//, '');
    }

    // Handle signatures display
    function handleSignatures(detailApl02) {
        if (!detailApl02) return;

        // Handle Asesor Signature
        if (detailApl02.ttd_asesor && detailApl02.ttd_asesor !== 'null') {
            const asesorImageUrl = buildImageUrl(detailApl02.ttd_asesor);

            if (asesorImageUrl) {
                @if(config('app.debug'))
                console.log('Displaying asesor signature:', asesorImageUrl);
                @endif
                elements.tandaTanganAsesorPlaceholder.classList.add('hidden');
                elements.tandaTanganAsesor.src = asesorImageUrl;
                elements.tandaTanganAsesor.classList.remove('hidden');

                // Set timestamp if available
                if (detailApl02.waktu_tanda_tangan_asesor) {
                    elements.tanggalTtdAsesor.textContent = formatDateFromWIB(detailApl02.waktu_tanda_tangan_asesor);
                }
            }
        } else {
            // No asesor signature - show placeholder
            elements.tandaTanganAsesorPlaceholder.classList.remove('hidden');
            elements.tandaTanganAsesor.classList.add('hidden');
        }

        // Handle Asesi Signature
        if (detailApl02.ttd_asesi && detailApl02.ttd_asesi !== 'null') {
            const asesiImageUrl = buildImageUrl(detailApl02.ttd_asesi);

            if (asesiImageUrl) {
                @if(config('app.debug'))
                console.log('Displaying asesi signature:', asesiImageUrl);
                @endif
                elements.tandaTanganAsesiPlaceholder.classList.add('hidden');
                elements.tandaTanganAsesi.src = asesiImageUrl;
                elements.tandaTanganAsesi.classList.remove('hidden');

                // Set timestamp if available
                if (detailApl02.waktu_tanda_tangan_asesi) {
                    elements.tanggalTtdAsesi.textContent = formatDateFromWIB(detailApl02.waktu_tanda_tangan_asesi);
                }

                // Lock form
                isFormLocked = true;
                elements.signingCheckbox.checked = true;
                elements.signingCheckbox.disabled = true;

                // Update button text and disable
                elements.submitButton.textContent = 'Sudah Disetujui';
                elements.submitButton.disabled = true;
                elements.submitButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                elements.submitButton.classList.add('bg-green-500');

                @if(config('app.debug'))
                console.log('Form locked - Asesi signature found');
                @endif
            }
        } else {
            // No asesi signature - show placeholder and enable form
            elements.tandaTanganAsesiPlaceholder.classList.remove('hidden');
            elements.tandaTanganAsesi.classList.add('hidden');
            elements.signingCheckbox.checked = false;
            elements.signingCheckbox.disabled = false;
            isFormLocked = false;

            @if(config('app.debug'))
            console.log('Form unlocked - No asesi signature found');
            @endif
        }
    }

    // Load APL02 data
    function loadAPL02Data() {
        showLoading(true);

        @if(config('app.debug'))
        console.log('Loading APL02 data from:', apl02ApiUrl);
        @endif

        fetch(apl02ApiUrl, {
            method: 'GET',
            headers: apiHeaders
        })
        .then(response => {
            @if(config('app.debug'))
            console.log('APL02 Load Response Status:', response.status);
            @endif
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            @if(config('app.debug'))
            console.log('APL02 Load Result:', result);
            @endif

            if (result.status === 'success' && result.data) {
                currentApl02Data = result.data;
                populateFormData(result.data);
            } else if (result.status === 'info') {
                showError(result.message || 'Formulir APL02 belum dibuat oleh asesor');
            } else {
                showError('Gagal memuat data APL02: ' + (result.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            @if(config('app.debug'))
            console.error('Error loading APL02 data:', error);
            @endif
            showError('Error memuat data APL02: ' + error.message);
        })
        .finally(() => {
            showLoading(false);
        });
    }

    // Populate form with data
    function populateFormData(data) {
        const generalInfo = data.general_info;
        const detailSkema = data.detail_skema;
        const detailApl02 = data.detail_apl02;

        // Populate general information
        document.getElementById('judulSkema').textContent = generalInfo.nama_skema || 'Tidak tersedia';
        document.getElementById('namaTuk').textContent = generalInfo.nama_tuk || 'Tidak tersedia';
        document.getElementById('namaAsesi').textContent = generalInfo.nama_asesi || 'Tidak tersedia';

        // Update signature names
        elements.namaAsesiTtd.textContent = generalInfo.nama_asesi || 'Tidak tersedia';

        // Populate unit kompetensi
        populateUnitKompetensi(detailSkema);

        // Handle signatures
        handleSignatures(detailApl02);

        // Update button state
        updateButtonState();
    }

    // Populate unit kompetensi tables
    function populateUnitKompetensi(detailSkema) {
        const container = document.getElementById('unitKompetensiContainer');
        let unitHtml = '';

        detailSkema.forEach((unit, unitIndex) => {
            unitHtml += `
                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 shadow-sm">
                    <div class="mb-3">
                        <h4 class="font-semibold text-gray-800">Kode Unit: ${unit.kode_uk}</h4>
                        <p class="text-gray-600">${unit.nama_uk}</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="border border-gray-300 p-2 text-left text-gray-700 w-3/4">Elemen Kompetensi</th>
                                    <th class="border border-gray-300 p-2 text-center text-gray-700 w-1/4">Status Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            unit.elemen_uk.forEach((elemen, elemenIndex) => {
                const statusText = elemen.kompeten === true ? 'Kompeten' :
                                 elemen.kompeten === false ? 'Tidak Kompeten' :
                                 'Belum Dinilai';
                const statusClass = elemen.kompeten === true ? 'text-green-600 font-semibold bg-green-50 px-2 py-1 rounded' :
                                   elemen.kompeten === false ? 'text-red-600 font-semibold bg-red-50 px-2 py-1 rounded' :
                                   'text-gray-500 bg-gray-50 px-2 py-1 rounded';

                unitHtml += `
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-3">
                            <div class="flex">
                                <span class="mr-2 text-gray-600">${elemenIndex + 1}.</span>
                                <span class="text-gray-800">${elemen.nama_elemen}</span>
                            </div>
                        </td>
                        <td class="border border-gray-300 p-3 text-center">
                            <span class="inline-block text-xs ${statusClass}">
                                ${statusText}
                            </span>
                        </td>
                    </tr>
                `;
            });

            unitHtml += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        });

        container.innerHTML = unitHtml;
    }

    // Update button state based on conditions
    function updateButtonState() {
        if (!currentApl02Data || !currentApl02Data.detail_apl02) {
            elements.submitButton.disabled = true;
            elements.submitButton.textContent = 'APL02 Belum Dibuat';
            return;
        }

        const detailApl02 = currentApl02Data.detail_apl02;

        // Check if asesi already signed
        if (detailApl02.waktu_tanda_tangan_asesi) {
            elements.submitButton.disabled = true;
            elements.submitButton.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Sudah Disetujui
            `;
            elements.submitButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            elements.submitButton.classList.add('bg-green-500');
            return;
        }

        // Check if asesor has signed
        if (!detailApl02.waktu_tanda_tangan_asesor) {
            elements.submitButton.disabled = true;
            elements.submitButton.textContent = 'Menunggu Tanda Tangan Asesor';
            return;
        }

        // Enable button if asesor has signed and asesi hasn't
        elements.submitButton.disabled = false;
        elements.submitButton.innerHTML = `
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Saya Setuju
        `;
    }

    // Handle approval
    function handleApproval() {
        if (isFormLocked) return;

        // Check if checkbox is checked
        if (!elements.signingCheckbox.checked) {
            showError('Silakan setujui untuk menandatangani formulir');
            return;
        }

        @if(config('app.debug'))
        console.log('Preparing to submit approval');
        @endif

        // Prepare request data
        const requestData = {
            id_asesi: apiConfig.asesiId,
            id_asesor: apiConfig.asesorId,
            is_signing: true
        };

        @if(config('app.debug'))
        console.log('Request Data:', requestData);
        console.log('Submitting to:', saveApiUrl);
        @endif

        showLoading(true);

        fetch(saveApiUrl, {
            method: 'POST',
            headers: apiHeaders,
            body: JSON.stringify(requestData)
        })
        .then(response => {
            @if(config('app.debug'))
            console.log('Approval Response Status:', response.status);
            @endif

            return response.clone().text().then(text => {
                @if(config('app.debug'))
                console.log('Raw response:', text);
                @endif

                if (!response.ok) {
                    try {
                        const errorData = JSON.parse(text);
                        @if(config('app.debug'))
                        console.log('Error response data:', errorData);
                        @endif
                        throw new Error(`HTTP ${response.status}: ${errorData.message || errorData.error || 'Validation failed'}`);
                    } catch (parseError) {
                        throw new Error(`HTTP ${response.status}: ${text || 'Unknown error'}`);
                    }
                }

                return JSON.parse(text);
            });
        })
        .then(result => {
            @if(config('app.debug'))
            console.log('Approval Result:', result);
            @endif
            showLoading(false);

            if (result.status === 'success') {
                showSuccess(result.message || 'APL02 berhasil disetujui dan ditandatangani');

                // Reload data to get updated signatures
                setTimeout(() => {
                    loadAPL02Data();
                }, 1000);

            } else {
                showError('Gagal menyetujui APL02: ' + (result.message || result.error || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            showLoading(false);
            @if(config('app.debug'))
            console.error('Error approving APL02:', error);
            @endif
            showError('Error menyetujui APL02: ' + error.message);
        });
    }

    // Event listeners
    elements.submitButton.addEventListener('click', function() {
        if (!this.disabled && !isFormLocked) {
            handleApproval();
        }
    });

    // Bukti portfolio functionality
    document.getElementById('tambahBukti').addEventListener('click', function() {
        const tbody = document.querySelector('#tabelBukti tbody');
        const row = document.createElement('tr');

        row.innerHTML = `
            <td class="border border-gray-300 p-3">
                <input type="file" name="bukti_portofolio[]" class="w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </td>
            <td class="border border-gray-300 p-3">
                <input type="text" name="keterangan[]" placeholder="Masukkan keterangan" class="w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </td>
            <td class="border border-gray-300 p-3 text-center">
                <button type="button" class="hapusBukti bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors">
                    Hapus
                </button>
            </td>
        `;

        tbody.appendChild(row);

        // Add event listener for delete button
        row.querySelector('.hapusBukti').addEventListener('click', function() {
            row.remove();
        });
    });

    // Silent error handlers for production
    window.addEventListener('error', function(e) {
        // Silent error handling - log only in development
        @if(config('app.debug'))
        console.error('Uncaught error:', e.error);
        @endif
    });

    window.addEventListener('unhandledrejection', function(e) {
        // Silent error handling - log only in development
        @if(config('app.debug'))
        console.error('Unhandled promise rejection:', e.reason);
        @endif
    });

    // Initialize page
    loadAPL02Data();

    // Debug functions (only available in development)
    @if(config('app.debug'))
    window.debugAPL02 = function() {
        console.log('=== APL02 Debug Info ===');
        console.log('API Config:', {
            url: apiConfig.url,
            key: 'Present',
            asesiId: apiConfig.asesiId,
            asesorId: apiConfig.asesorId,
            csrfToken: 'Present'
        });
        console.log('Current APL02 Data:', currentApl02Data);
        console.log('Form Locked:', isFormLocked);
        console.log('Elements:', elements);
        console.log('=== End Debug Info ===');
    };

    window.refreshAPL02Data = function() {
        console.log('Manually refreshing APL02 data...');
        loadAPL02Data();
    };
    @endif
});
</script>
@endsection
