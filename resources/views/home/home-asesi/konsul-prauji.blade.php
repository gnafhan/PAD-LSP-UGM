@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Konsultasi Prauji Asesi - Lembaga Sertifikasi Profesi UGM')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-6xl mx-auto p-6">
            <!-- Header -->
            <div class="flex items-center gap-4 mb-6">
                <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-3 py-2 rounded text-sm flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
                <div class="bg-green-500 text-white px-4 py-2 rounded text-sm font-medium">
                    Konsultasi Pra Uji
                </div>
            </div>

            <!-- Loading, Error, and Success Messages -->
            <div id="messageContainer" class="mb-4">
                <div id="loadingMessage" class="hidden p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 me-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="loadingText">Memuat data...</span>
                    </div>
                </div>

                <div id="errorMessage" class="hidden p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span id="errorText">Terjadi kesalahan.</span>
                    </div>
                </div>

                <div id="successMessage" class="hidden p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span id="successText">Data berhasil disimpan.</span>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div id="main-content" class="hidden">
                <!-- Input Formulir Konsultasi Pra Uji -->
                <form id="formKonsulPrauji">
                    <div id="KonsulPrauji" class="p-4 space-y-6">
                        <p id="judulDetail" class="text-lg font-semibold text-gray-700">FORMULIR KONSULTASI PRA UJI</p>
                        <div class="max-w-full space-y-1">
                            <div class="flex">
                                <span class="py-1 inline-flex items-center min-w-fit text-gray-700 -ms-px w-1/3">
                                    Skema Sertifikasi
                                </span>
                                <p id="judulSertifikasi" class="peer text-gray-700 py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-gray-300 focus:border-t-transparent focus:border-x-transparent focus:border-blue-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                    Memuat...
                                </p>
                            </div>
                            <div class="flex">
                                <span class="py-1 pb-2 inline-flex items-center min-w-fit text-gray-700 -mt-px -ms-px w-1/3">
                                    Nomor Skema
                                </span>
                                <p id="nomorSertifikasi" class="peer text-gray-700 py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-gray-300 focus:border-t-transparent focus:border-x-transparent focus:border-blue-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                    Memuat...
                                </p>
                            </div>
                            <div class="flex">
                                <span class="py-1 pb-2 inline-flex items-center min-w-fit text-gray-700 -mt-px -ms-px w-1/3">
                                    Tanggal Asesmen
                                </span>
                                <p id="tanggalAsesmen" class="peer text-gray-700 py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-gray-300 focus:border-t-transparent focus:border-x-transparent focus:border-blue-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                    Memuat...
                                </p>
                            </div>
                        </div>
                        <div class="max-w-full space-y-1">
                            <div class="flex">
                                <span class="py-1 inline-flex items-center min-w-fit text-gray-700 -mt-px -ms-px w-1/3">
                                    Nama Asesor
                                </span>
                                <p id="namaAsesor" class="peer font-semibold text-gray-700 py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-gray-300 focus:border-t-transparent focus:border-x-transparent focus:border-blue-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                    Memuat...
                                </p>
                            </div>
                            <div class="flex">
                                <span class="py-1 inline-flex items-center min-w-fit text-gray-700 -mt-px -ms-px w-1/3">
                                    TUK
                                </span>
                                <p id="tuk" class="peer text-gray-700 py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-gray-300 focus:border-t-transparent focus:border-x-transparent focus:border-blue-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                    Memuat...
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Unit Kompetensi -->
                    <div class="p-4">
                        <p id="judulTabelKonsul" class="text-gray-700 font-semibold pb-2">Unit Kompetensi</p>
                        <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                            <table id="unitKompetensiTable" class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-gray-50 text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Kode Unit</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Judul Unit</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black text-center items-center">
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                                            <div class="flex justify-center items-center space-x-2">
                                                <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span>Memuat unit kompetensi...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Surat Pernyataan Asesi -->
                    <div class="p-4">
                        <h3 class="text-center font-bold mt-4 mb-4 text-gray-700">SURAT PERNYATAAN ASESI DALAM MENGIKUTI PROSES ASESMEN</h3>

                        <!-- Tabel Checklist untuk Asesi -->
                        <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                            <table id="checklistTable" class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-gray-50 text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider" style="width: 10%">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider" style="width: 70%">Pernyataan</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider" style="width: 20%">Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody id="checklistTableBody" class="divide-y divide-gray-200 text-black">
                                    <!-- Checklist items will be dynamically populated -->
                                    <tr>
                                        <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                                            <div class="flex justify-center items-center space-x-2">
                                                <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <span>Memuat pernyataan...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tanda Tangan Section -->
                    <div class="my-6 px-4 space-y-6">
                        <div class="flex flex-row justify-between">
                            <!-- Tanda Tangan Asesor -->
                            <div class="flex flex-col items-center justify-center">
                                <!-- Tampilkan tanggal otomatis -->
                                <p id="tanggalTandaTanganAsesor" class="font-medium text-gray-700"></p>

                                <!-- Container untuk tanda tangan asesor -->
                                <div id="tandaTanganAsesorContainer" class="w-60 h-40 border-b border-gray-300 flex items-center justify-center">
                                    <p id="tandaTanganAsesorPlaceholder" class="text-gray-400 text-center">Menunggu persetujuan asesor</p>
                                    <img id="tandaTanganAsesor" src="" alt="Tanda Tangan Asesor" class="w-full h-full object-contain hidden">
                                </div>

                                <p class="font-medium text-gray-700 mt-2">Asesor</p>
                                <p id="namaAsesorTTD" class="font-normal text-gray-700">Memuat nama asesor...</p>
                            </div>

                            <!-- Tanda Tangan Asesi -->
                            <div class="flex flex-col items-center justify-center">
                                <!-- Tampilkan tanggal otomatis -->
                                <p id="tanggalTandaTanganAsesi" class="font-medium text-gray-700"></p>

                                <!-- Container untuk tanda tangan asesi -->
                                <div id="tandaTanganAsesiContainer" class="w-60 h-40 border-b border-gray-300 flex items-center justify-center">
                                    <p id="tandaTanganAsesiPlaceholder" class="text-gray-400 text-center">Tanda tangan akan ditampilkan setelah menyimpan formulir</p>
                                    <img id="tandaTanganAsesi" src="" alt="Tanda Tangan Asesi" class="w-full h-full object-contain hidden">
                                </div>

                                <!-- Checkbox untuk tanda tangan asesi -->
                                <div class="mt-3 flex items-center">
                                    <input id="is_asesi_signing" name="is_asesi_signing" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="is_asesi_signing" class="ms-2 text-sm font-medium text-gray-700">Saya setuju menandatangani formulir ini</label>
                                </div>

                                <p class="font-medium text-gray-700 mt-2">Asesi</p>
                                <p id="namaAsesiTTD" class="font-normal text-gray-700">Memuat nama asesi...</p>
                            </div>
                        </div>

                        <!-- Button Simpan -->
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('asesi.index') }}" class="inline-flex justify-center rounded-md bg-gray-200 text-gray-700 px-6 py-2 text-sm/6 font-medium hover:bg-gray-300 focus:outline-none mt-6 me-3">
                                Kembali
                            </a>
                            <button id="btnSimpan" type="submit" class="inline-flex justify-center items-center rounded-md bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 text-sm/6 font-medium hover:from-blue-600 hover:to-purple-700 focus:outline-none mt-6">
                                Saya Menyetujui
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk styling tambahan -->
<style>
.radio-option {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    padding: 2px 0;
}

.radio-option input[type="radio"] {
    width: 1rem;
    height: 1rem;
    margin-right: 0.5rem;
    cursor: pointer;
}

.radio-option label {
    cursor: pointer;
    user-select: none;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #3B82F6;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

#tandaTanganAsesi, #tandaTanganAsesor {
    max-width: 100%;
    max-height: 100%;
}

/* Pastikan radio button bisa diklik jika tidak disabled */
input[type="radio"]:not(:disabled) {
    cursor: pointer;
    opacity: 1;
    pointer-events: auto;
}

/* Style untuk radio button yang disabled */
input[type="radio"]:disabled {
    cursor: not-allowed;
    opacity: 0.5;
    pointer-events: none;
}

/* Style untuk label yang disabled */
label.disabled {
    cursor: not-allowed;
    opacity: 0.5;
    color: #9CA3AF;
}

/* Style untuk row yang dikunci */
tr.locked {
    background-color: #F9FAFB;
}

/* Style untuk form yang dikunci */
.form-locked {
    pointer-events: none;
    opacity: 0.8;
}

/* Style untuk checkbox yang disabled */
input[type="checkbox"]:disabled {
    cursor: not-allowed;
    opacity: 0.5;
}

/* Style untuk text yang disabled */
.text-disabled {
    color: #9CA3AF;
    opacity: 0.7;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Configuration
    const config = {
        apiKey: "{{ env('API_KEY') }}",
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        baseUrl: "{{ url('/api/v1') }}",
        storageUrl: "{{ url('') }}", // Base URL for storage files
        headers: {}
    };

    // Set up headers
    config.headers = {
        'Content-Type': 'application/json',
        'API-KEY': config.apiKey,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': config.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // State management
    const state = {
        asesiId: '{{ Auth::user()->asesi->id_asesi ?? "" }}',
        asesorId: '{{ Auth::user()->asesi->rincianAsesmen->id_asesor ?? "" }}',
        isSubmitting: false,
        checklist: {
            point_1: { jawaban_asesi: null },
            point_2: { jawaban_asesi: null },
            point_3: { jawaban_asesi: null },
            point_4: { jawaban_asesi: null },
            point_5: { jawaban_asesi: null },
            point_6: { jawaban_asesi: null },
            point_7: { jawaban_asesi: null },
            point_8: { jawaban_asesi: null },
            point_9: { jawaban_asesi: null }
        },
        consultationData: null,
        isFormLocked: false
    };

    // DOM elements
    const elements = {
        consultationForm: document.getElementById('formKonsulPrauji'),
        submitButton: document.getElementById('btnSimpan'),
        checklistTableBody: document.getElementById('checklistTableBody'),
        unitKompetensiTable: document.getElementById('unitKompetensiTable').querySelector('tbody'),
        signingCheckbox: document.getElementById('is_asesi_signing'),
        tandaTanganAsesiPlaceholder: document.getElementById('tandaTanganAsesiPlaceholder'),
        tandaTanganAsesi: document.getElementById('tandaTanganAsesi'),
        tandaTanganAsesorPlaceholder: document.getElementById('tandaTanganAsesorPlaceholder'),
        tandaTanganAsesor: document.getElementById('tandaTanganAsesor'),
        // Form fields
        namaAsesor: document.getElementById('namaAsesor'),
        namaAsesorTTD: document.getElementById('namaAsesorTTD'),
        namaAsesiTTD: document.getElementById('namaAsesiTTD'),
        judulSertifikasi: document.getElementById('judulSertifikasi'),
        nomorSertifikasi: document.getElementById('nomorSertifikasi'),
        tanggalAsesmen: document.getElementById('tanggalAsesmen'),
        tuk: document.getElementById('tuk'),
        tanggalTandaTanganAsesi: document.getElementById('tanggalTandaTanganAsesi'),
        tanggalTandaTanganAsesor: document.getElementById('tanggalTandaTanganAsesor')
    };

    // Stop execution if no asesi ID is found
    if (!state.asesiId) {
        console.error('No asesi ID found for the authenticated user');
        showMessage('error', 'User tidak teridentifikasi, silahkan login kembali');
        return;
    }

    if (!state.asesorId) {
        console.error('No asesor ID found for the authenticated user');
        showMessage('error', 'Asesor tidak teridentifikasi untuk asesi ini');
        return;
    }

    // Utility function to show messages
    function showMessage(type, message, duration = 5000) {
        // Hide all messages first
        document.getElementById('loadingMessage').classList.add('hidden');
        document.getElementById('errorMessage').classList.add('hidden');
        document.getElementById('successMessage').classList.add('hidden');

        // Show appropriate message
        const messageElement = document.getElementById(`${type}Message`);
        const textElement = document.getElementById(`${type}Text`);

        if (messageElement && textElement) {
            textElement.textContent = message;
            messageElement.classList.remove('hidden');

            // Auto-hide after duration (if specified)
            if (duration > 0) {
                setTimeout(() => {
                    messageElement.classList.add('hidden');
                }, duration);
            }
        }
    }

    // Format date to Indonesian format
    function formatDate(dateString) {
        if (!dateString) return '';

        // If the date is already in DD-MM-YYYY format
        if (dateString.includes('-') && dateString.split('-').length === 3) {
            const [day, month, year] = dateString.split('-');
            if (day.length === 2 && month.length === 2 && year.length === 4) {
                const months = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                    'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                return `${day} ${months[parseInt(month) - 1]} ${year}`;
            }
        }

        // Otherwise, parse as ISO date
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString; // Return original if invalid

        const day = date.getDate().toString().padStart(2, '0');
        const month = date.getMonth();
        const year = date.getFullYear();

        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
            'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return `${day} ${months[month]} ${year}`;
    }

    // Set today's date
    function setTodayDate() {
        const today = new Date();
        const formattedDate = formatDate(today.toISOString().split('T')[0]);
        elements.tanggalTandaTanganAsesi.textContent = formattedDate;
        elements.tanggalTandaTanganAsesor.textContent = formattedDate;
    }

    // Function to build proper image URL
    function buildImageUrl(imagePath) {
        if (!imagePath || imagePath === 'null' || imagePath === null) {
            return null;
        }

        // If already a full URL, return as is
        if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
            return imagePath;
        }

        // If starts with /storage/, use as is with base URL
        if (imagePath.startsWith('/storage/')) {
            return config.storageUrl + imagePath;
        }

        // If starts with storage/ (without leading slash), add base URL with /
        if (imagePath.startsWith('storage/')) {
            return config.storageUrl + '/' + imagePath;
        }

        // For any other path, assume it needs /storage/ prefix
        return config.storageUrl + '/storage/' + imagePath.replace(/^\//, '');
    }

    // Load consultation data for asesi
    async function loadConsultationData() {
        try {
            showMessage('loading', 'Memuat data konsultasi pra uji...', 0);

            const response = await fetch(`${config.baseUrl}/asesmen/konsultasi-prauji/${state.asesiId}`, {
                method: 'GET',
                headers: config.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success' && result.data) {
                state.consultationData = result.data;
                state.checklist = result.data.konsultasi_pra_uji.jawaban_checklist || state.checklist;
                renderConsultationForm(result.data);
                showMessage('success', 'Data konsultasi pra uji berhasil dimuat', 3000);
            } else {
                console.error('API returned success=false or missing data:', result);
                showMessage('error', `Gagal memuat data konsultasi pra uji: ${result.message || 'Terjadi kesalahan'}`);
            }
        } catch (error) {
            console.error('Error loading consultation data:', error);
            showMessage('error', `Error memuat data konsultasi pra uji: ${error.message}`);
        }
    }

    // Render consultation form with data
    function renderConsultationForm(data) {
        if (!data) return;

        const generalInfo = data.general_info;
        const konsultasiPraUji = data.konsultasi_pra_uji;

        // Set form values
        if (generalInfo) {
            elements.judulSertifikasi.textContent = generalInfo.skema?.nama_skema || 'N/A';
            elements.nomorSertifikasi.textContent = generalInfo.skema?.nomor_skema || 'N/A';
            elements.namaAsesor.textContent = generalInfo.nama_asesor || 'N/A';
            elements.namaAsesorTTD.textContent = generalInfo.nama_asesor || 'N/A';
            elements.namaAsesiTTD.textContent = generalInfo.nama_asesi || 'N/A';
            elements.tuk.textContent = konsultasiPraUji.tempat_uji || 'N/A';

            // Format and set tanggal asesmen
            elements.tanggalAsesmen.textContent = formatDate(konsultasiPraUji.tanggal_asesmen_disepakati) || 'N/A';
        }

        // Render unit kompetensi table
        if (generalInfo && generalInfo.unit_kompetensi) {
            renderUnitKompetensiTable(generalInfo.unit_kompetensi);
        }

        // Set tanggal tanda tangan
        setTodayDate();

        // PENTING: Set state.isFormLocked SEBELUM render checklist
        state.isFormLocked = konsultasiPraUji.tanda_tangan_asesi ? true : false;

        console.log('Form lock status:', state.isFormLocked); // Debug log
        console.log('TTD Asesi value:', konsultasiPraUji.tanda_tangan_asesi); // Debug log
        console.log('TTD Asesor value:', konsultasiPraUji.tanda_tangan_asesor); // Debug log

        // Render checklist table SETELAH state.isFormLocked diset
        renderChecklistTable();

        // Handle signatures - UPDATED WITH DYNAMIC URL BUILDING
        handleSignatures(konsultasiPraUji);

        // Show main content
        document.getElementById('main-content').classList.remove('hidden');
    }

    // NEW: Enhanced signature handling function
    function handleSignatures(konsultasiPraUji) {
        // Handle Asesi Signature
        if (konsultasiPraUji.tanda_tangan_asesi && konsultasiPraUji.tanda_tangan_asesi !== 'null') {
            const asesiImageUrl = buildImageUrl(konsultasiPraUji.tanda_tangan_asesi);

            if (asesiImageUrl) {
                console.log('Displaying asesi signature:', asesiImageUrl);
                elements.tandaTanganAsesiPlaceholder.classList.add('hidden');
                elements.tandaTanganAsesi.src = asesiImageUrl;
                elements.tandaTanganAsesi.classList.remove('hidden');

                // Set timestamp if available
                if (konsultasiPraUji.waktu_tanda_tangan_asesi) {
                    elements.tanggalTandaTanganAsesi.textContent = konsultasiPraUji.waktu_tanda_tangan_asesi;
                }

                // Lock form
                elements.signingCheckbox.checked = true;
                elements.signingCheckbox.disabled = true;

                // Update button text and disable
                elements.submitButton.textContent = 'Sudah Disetujui';
                elements.submitButton.disabled = true;
                elements.submitButton.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-purple-600', 'hover:from-blue-600', 'hover:to-purple-700');
                elements.submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');

                // Add visual indicator that form is locked
                elements.consultationForm.classList.add('form-locked');

                console.log('Form locked - Asesi signature found');
            }
        } else {
            // No asesi signature - show placeholder and enable form
            elements.tandaTanganAsesiPlaceholder.classList.remove('hidden');
            elements.tandaTanganAsesi.classList.add('hidden');
            elements.signingCheckbox.checked = false;
            elements.signingCheckbox.disabled = false;

            // Reset button
            elements.submitButton.textContent = 'Saya Menyetujui';
            elements.submitButton.disabled = false;
            elements.submitButton.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-purple-600', 'hover:from-blue-600', 'hover:to-purple-700');
            elements.submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed');

            // Remove locked form indicator
            elements.consultationForm.classList.remove('form-locked');

            console.log('Form unlocked - No asesi signature found');
        }

        // Handle Asesor Signature - UPDATED WITH DYNAMIC URL BUILDING
        if (konsultasiPraUji.tanda_tangan_asesor && konsultasiPraUji.tanda_tangan_asesor !== 'null') {
            const asesorImageUrl = buildImageUrl(konsultasiPraUji.tanda_tangan_asesor);

            if (asesorImageUrl) {
                console.log('Displaying asesor signature:', asesorImageUrl);
                elements.tandaTanganAsesorPlaceholder.classList.add('hidden');
                elements.tandaTanganAsesor.src = asesorImageUrl;
                elements.tandaTanganAsesor.classList.remove('hidden');

                // Set timestamp if available
                if (konsultasiPraUji.waktu_tanda_tangan_asesor) {
                    elements.tanggalTandaTanganAsesor.textContent = konsultasiPraUji.waktu_tanda_tangan_asesor;
                }

                console.log('Asesor signature displayed successfully');
            }
        } else {
            // No asesor signature - show placeholder
            elements.tandaTanganAsesorPlaceholder.classList.remove('hidden');
            elements.tandaTanganAsesor.classList.add('hidden');

            // Reset timestamp
            elements.tanggalTandaTanganAsesor.textContent = '';

            console.log('No asesor signature found - showing placeholder');
        }
    }

    // Render unit kompetensi table
    function renderUnitKompetensiTable(unitKompetensiList) {
        if (!unitKompetensiList || unitKompetensiList.length === 0) {
            elements.unitKompetensiTable.innerHTML = `
                <tr>
                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">Tidak ada data unit kompetensi</td>
                </tr>
            `;
            return;
        }

        let tableContent = '';
        unitKompetensiList.forEach((uk, index) => {
            tableContent += `
                <tr>
                    <td class="px-4 py-3 text-sm text-black">${index + 1}</td>
                    <td class="px-4 py-3 text-black text-left">${uk.kode_uk || 'N/A'}</td>
                    <td class="px-4 py-3 text-black text-left">${uk.nama_uk || 'N/A'}</td>
                </tr>
            `;
        });

        elements.unitKompetensiTable.innerHTML = tableContent;
    }

    // Render checklist table
    function renderChecklistTable() {
        const checklistItems = [
            {
                id: 'point_1',
                text: 'Bahwa asesor telah menyampaikan Pembukaan : Salam, menyampaikan tujuan pertemuan hari ini.<ul class="list-disc pl-5"><li>Memperkenalkan diri</li><li>Menanyakan nama dan asal peserta</li><li>Percakapan sederhana (Informal)</li><li>Menjelaskan maksud dilaksanakannya konsultasi pra asesmen</li></ul>'
            },
            {
                id: 'point_2',
                text: 'Bahwa asesor telah menyampaikan proses asesmen dilaksanakan berdasarkan bukti atau evidence.'
            },
            {
                id: 'point_3',
                text: 'Bahwa asesor telah menyampaikan kualifikasi Asesor, SKM (Skema Sertifikasi) yang akan diassesmenkan, Lembaga Sertifikasi Profesi Okupasi Pemandu Museum, Kementerian Pendidikan dan Kebudayaan.'
            },
            {
                id: 'point_4',
                text: 'Bahwa asesor telah menyampaikan unit Kompetensi yang akan diujikan seperti tertera pada halaman depan.'
            },
            {
                id: 'point_5',
                text: 'Bahwa asesor telah menyampaikan aturan bukti (valid, asli, terkini, dan memadai) yang perlu dikumpulkan oleh peserta.'
            },
            {
                id: 'point_6',
                text: 'Bahwa asesor telah menyampaikan proses asesmen mencakup : <ul class="list-disc pl-5"><li>Mengumpulkan bukti (portofolio dan asesmen dari bank soal, simulasi/demonstrasi/praktek), bila memerlukan klarifikasi, asesor melakukan wawancara dan observasi langsung.</li></ul>'
            },
            {
                id: 'point_7',
                text: 'Bahwa asesor telah menyampaikan sumber daya asesmen yang akan digunakan termasuk : Pertanyaan lisan, tes tertulis, simulasi tugas, dan praktek.'
            },
            {
                id: 'point_8',
                text: 'Bahwa asesor telah menyampaikan formulir yang digunakan adalah : <ul class="list-disc pl-5"><li>APL-01 : Formulir Permohonan Sertifikasi Kompetensi</li><li>APL-02 : Formulir Asesmen Mandiri</li><li>FR.AK-01 : Formulir Persetujuan Asesmen dan Kerahasiaan</li><li>FR.MAPA-01 : Merencanakan Aktifitas & Proses Asesmen</li><li>FR.MAPA-02 : Formulir Peta Instrumen Asesmen Hasil Pendekatan Asesmen & Perencanaan Asesmen</li><li>FR.IA-01 : Formulir Ceklis Observasi (langsung/tidak langsung)</li><li>FR.IA-04 : Pertanyaan Untuk Mendukung Observasi</li><li>FR.IA-05 : Formulir Pertanyaan Tertulis</li><li>FR.IA-07 : Formulir Penilaian Praktek Simulasi</li><li>FR.AK-02 : Formulir Banding Asesmen</li><li>FR.AK-03 : Formulir Umpan Balik dari Asesi</li><li>FR.AK-04 : Keputusan & Umpan Balik Asesmen</li></ul>'
            },
            {
                id: 'point_9',
                text: 'Bahwa asesor telah menyampaikan perencanaan Asesmen dan Kegiatan Pengembangan.'
            }
        ];

        let tableContent = '';
        checklistItems.forEach((item, index) => {
            const jawaban = state.checklist[item.id]?.jawaban_asesi || null;

            // Disable radio buttons if form is locked (already signed by asesi)
            const isDisabled = state.isFormLocked ? 'disabled' : '';
            const radioClass = state.isFormLocked ? 'cursor-not-allowed opacity-50' : 'cursor-pointer';
            const labelClass = state.isFormLocked ? 'text-gray-500 cursor-not-allowed' : 'text-gray-700 cursor-pointer';
            const rowClass = state.isFormLocked ? 'bg-gray-50' : '';

            tableContent += `
                <tr class="${rowClass}">
                    <td class="px-4 py-3 text-sm text-black text-center">${index + 1}</td>
                    <td class="px-4 py-3 text-black text-left ${state.isFormLocked ? 'text-gray-600' : ''}">${item.text}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center">
                            <div class="w-full">
                                <div class="radio-option">
                                    <input type="radio"
                                        id="${item.id}_ya"
                                        name="${item.id}"
                                        value="Ya"
                                        ${jawaban === 'Ya' ? 'checked' : ''}
                                        ${isDisabled}
                                        class="${radioClass}">
                                    <label for="${item.id}_ya"
                                        class="text-sm ${labelClass}">
                                        Ya
                                    </label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio"
                                        id="${item.id}_tidak"
                                        name="${item.id}"
                                        value="Tidak"
                                        ${jawaban === 'Tidak' ? 'checked' : ''}
                                        ${isDisabled}
                                        class="${radioClass}">
                                    <label for="${item.id}_tidak"
                                        class="text-sm ${labelClass}">
                                        Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });

        elements.checklistTableBody.innerHTML = tableContent;

        // Add event listeners to radio buttons only if form is not locked
        if (!state.isFormLocked) {
            setTimeout(() => {
                const radioButtons = document.querySelectorAll('input[type="radio"]');
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function() {
                        console.log(`Radio changed: ${this.name} = ${this.value}`);
                    });
                });
            }, 100);
        }
    }

    // Handle form submission
    async function submitForm(event) {
        event.preventDefault();

        if (state.isSubmitting || state.isFormLocked) return;

        // Check if checkbox is checked
        if (!elements.signingCheckbox.checked) {
            showMessage('error', 'Silakan setujui untuk menandatangani formulir');
            return;
        }

        // Collect form data
        const formData = {
            id_asesi: state.asesiId,
            id_asesor: state.asesorId,
            jawaban_checklist: {},
            is_asesi_signing: elements.signingCheckbox.checked
        };

        // Get all the checklist answers (9 points)
        for (let i = 1; i <= 9; i++) {
            const pointId = `point_${i}`;
            const selectedRadio = document.querySelector(`input[name="${pointId}"]:checked`);

            if (selectedRadio) {
                formData.jawaban_checklist[pointId] = {
                    jawaban_asesi: selectedRadio.value
                };
            } else {
                showMessage('error', `Silakan pilih jawaban untuk pernyataan ${i}`);
                return;
            }
        }

        // Disable the form during submission
        state.isSubmitting = true;
        elements.submitButton.disabled = true;
        elements.submitButton.innerHTML = `
            <span class="loading-spinner mr-2"></span>
            <span>Menyimpan...</span>
        `;

        showMessage('loading', 'Menyimpan data konsultasi pra uji...', 0);

        try {
            const response = await fetch(`${config.baseUrl}/asesmen/konsultasi-prauji/asesi/save`, {
                method: 'POST',
                headers: config.headers,
                body: JSON.stringify(formData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success') {
                showMessage('success', 'Data konsultasi pra uji berhasil disimpan');

                // Reload the consultation data to show the updated values
                setTimeout(() => {
                    loadConsultationData();
                }, 1000);
            } else {
                console.error('API returned success=false:', result);
                showMessage('error', `Gagal menyimpan data: ${result.message || 'Terjadi kesalahan'}`);
            }
        } catch (error) {
            console.error('Error saving consultation data:', error);
            showMessage('error', `Error menyimpan data: ${error.message}`);
        } finally {
            // Re-enable the form
            state.isSubmitting = false;
            if (!state.isFormLocked) {
                elements.submitButton.disabled = false;
                elements.submitButton.innerHTML = 'Saya Menyetujui';
            }
        }
    }

    // Setup event listeners
    function setupEventListeners() {
        // Form submission
        if (elements.consultationForm) {
            elements.consultationForm.addEventListener('submit', submitForm);
        }
    }

    // Initialize
    function init() {
        // Load initial data
        loadConsultationData();

        // Setup event listeners
        setupEventListeners();
    }

    // Start the application
    init();
});
</script>

@endsection
