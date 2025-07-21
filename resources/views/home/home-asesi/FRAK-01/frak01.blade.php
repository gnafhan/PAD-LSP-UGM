@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                        FR.AK-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 mt-5">
                    <h2 class="text-lg font-semibold mb-4">FR.AK-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI</h2>
                </div>

                <!-- Loading indicator -->
                <div id="loading" class="text-center py-4">
                    <div class="flex items-center justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <p class="ml-2">Loading data...</p>
                    </div>
                </div>

                <!-- Error message -->
                <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <p id="error-text"></p>
                    <button onclick="retryLoad()" class="mt-2 bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                        Coba Lagi
                    </button>
                </div>

                <!-- Main content -->
                <div id="main-content" class="hidden">
                    <!-- Table structure -->
                    <div class="border border-gray-300 rounded-lg p-4 mb-6">
                        <table class="w-full border-collapse border border-gray-300 text-sm">
                            <tr>
                                <td class="border border-gray-300 p-2" colspan="2">
                                    <i>Persetujuan Asesmen ini untuk menjamin bahwa Peserta telah diberi arahan secara rinci tentang perencanaan dan proses asesmen</i>
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Skema Sertifikasi Klaster/Asesmen</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Judul Skema Sertifikasi</td>
                                <td class="border border-gray-300 p-2" id="judul-skema">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nomor Skema Sertifikasi</td>
                                <td class="border border-gray-300 p-2" id="kode-skema">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">TUK</td>
                                <td class="border border-gray-300 p-2" id="nama-tuk">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nama Asesor</td>
                                <td class="border border-gray-300 p-2" id="nama-asesor">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nama Peserta</td>
                                <td class="border border-gray-300 p-2" id="nama-asesi">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Bukti yang dikumpulkan</td>
                                <td class="border border-gray-300 p-2" id="bukti-container">
                                    <div id="hasil-items">
                                        <!-- Dynamic content will be loaded here -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Pelaksanaan Assesmen yang disepakati</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">Hari/Tanggal</td>
                                <td class="border border-gray-300 p-2" id="tanggal-pelaksanaan">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">TUK</td>
                                <td class="border border-gray-300 p-2" id="tuk-pelaksanaan">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Asesi</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2" colspan="2">Bahwa saya sudah mendapatkan penjelasan Hak dan Prosedur Banding oleh Asesor</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Asesor</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2" colspan="2">Saya setuju assesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</td>
                            </tr>
                        </table>
                    </div>

                    <div class="flex justify-between">
                        <div>
                            <div class="flex items-center space-x-2 mt-2">
                                <p class="text-sm font-semibold">Tanda Tangan Asesor</p>
                            </div>
                            <div class="mt-2">
                                <span id="ttd-asesor-container">-</span></p>
                                <p class="text-xs text-gray-600" id="tanggal-ttd-asesor">-</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold">Tanda Tangan Asesi</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 border-gray-300 rounded" onchange="handleAsesiSignature(this)">
                                <label for="approve-pemohon" class="text-sm">Saya selaku asesi menyetujui data ini</label>
                            </div>
                            <div class="mt-2">
                                <span id="ttd-asesi-container">-</span></p>
                                <p class="text-xs text-gray-600" id="tanggal-ttd-asesi">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button id="save-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-200" onclick="saveAk01Asesi()">
                            <span id="save-btn-text">SAVE</span>
                            <div id="save-btn-loading" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Tanda Tangan -->
<div id="signature-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto">
        <div class="p-6">
            <!-- Header Modal -->
            <div class="flex items-center mb-4">
                <div class="rounded-full bg-yellow-100 p-3 mr-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Tanda Tangan Digital</h3>
            </div>

            <!-- Content Modal -->
            <div class="mb-6">
                <p class="text-gray-700 mb-4">
                    Anda akan menandatangani formulir <strong>FR.AK-01 Permohonan Sertifikasi Kompetensi</strong> secara digital.
                </p>

                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-red-800 mb-1">Perhatian Penting:</h4>
                            <p class="text-sm text-red-700">
                                Setelah menandatangani, Anda <strong>tidak dapat mengubah</strong> atau membatalkan persetujuan ini. Tanda tangan digital memiliki kekuatan hukum yang sama dengan tanda tangan manual.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-gray-600">Saya telah membaca dan memahami isi formulir</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-gray-600">Saya menyetujui pelaksanaan asesmen sesuai ketentuan</p>
                    </div>
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-gray-600">Saya memahami hak dan prosedur banding</p>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="flex justify-end space-x-3">
                <button id="cancel-signature" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    Batal
                </button>
                <button id="confirm-signature" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 flex items-center">
                    <span id="confirm-signature-text">Ya, Tandatangani</span>
                    <div id="confirm-signature-loading" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2"></div>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto">
        <div class="p-6 text-center">
            <!-- Icon Success -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Content -->
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Berhasil Ditandatangani!</h3>
            <p class="text-gray-600 mb-6">
                Formulir FR.AK-01 telah berhasil ditandatangani dan disimpan. Tanda tangan digital Anda telah terekam dalam sistem.
            </p>

            <!-- Button -->
            <button id="close-success-modal" type="button" class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
// API configuration - Menggunakan config helper Laravel untuk dynamic configuration
const apiConfig = {
    url: @json(config('services.api.url')),
    key: @json(config('services.api.key')),
    asesiId: @json(Auth::user()->asesi->id_asesi ?? null),
    asesorId: @json(Auth::user()->asesi->rincianAsesmen->id_asesor ?? null),
    csrfToken: @json(csrf_token())
};

let currentAk01Data = null;
let isProcessing = false;

// Debug logging - only in development
@if(config('app.debug'))
console.log('AK01 Form - API Config:', {
    url: apiConfig.url,
    key: 'Present',
    asesiId: apiConfig.asesiId,
    asesorId: apiConfig.asesorId,
    csrfToken: 'Present'
});
@endif

document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
    initializeModals();
});

function initializeForm() {
    // Validate required data
    if (!apiConfig.url) {
        showError('Konfigurasi API URL tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.key) {
        showError('Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.asesiId) {
        showError('ID Asesi tidak ditemukan. Pastikan Anda sudah login sebagai asesi.');
        return;
    }

    if (!apiConfig.asesorId) {
        showError('ID Asesor tidak ditemukan. Pastikan Anda sudah memiliki asesor yang ditugaskan.');
        return;
    }

    // Load initial data
    loadAk01Data(apiConfig.asesiId);
}

function initializeModals() {
    // Modal event listeners
    const signatureModal = document.getElementById('signature-modal');
    const successModal = document.getElementById('success-modal');
    const cancelBtn = document.getElementById('cancel-signature');
    const confirmBtn = document.getElementById('confirm-signature');
    const closeSuccessBtn = document.getElementById('close-success-modal');

    // Cancel signature
    cancelBtn.addEventListener('click', function() {
        hideSignatureModal();
        // Reset checkbox
        const checkbox = document.getElementById('approve-pemohon');
        checkbox.checked = false;
        checkbox.disabled = false;
        isProcessing = false;
    });

    // Confirm signature
    confirmBtn.addEventListener('click', async function() {
        await processSignature();
    });

    // Close success modal
    closeSuccessBtn.addEventListener('click', function() {
        hideSuccessModal();
    });

    // Close modal when clicking outside
    signatureModal.addEventListener('click', function(e) {
        if (e.target === signatureModal) {
            cancelBtn.click();
        }
    });

    successModal.addEventListener('click', function(e) {
        if (e.target === successModal) {
            closeSuccessBtn.click();
        }
    });

    // Escape key to close modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!signatureModal.classList.contains('hidden')) {
                cancelBtn.click();
            }
            if (!successModal.classList.contains('hidden')) {
                closeSuccessBtn.click();
            }
        }
    });
}

async function loadAk01Data(idAsesi) {
    try {
        showLoading(true);
        hideError();

        @if(config('app.debug'))
        console.log('Loading AK01 data for asesi:', idAsesi);
        @endif

        // Construct the API URL dynamically
        const apiUrl = `${apiConfig.url}/asesmen/ak01/${idAsesi}`;

        @if(config('app.debug'))
        console.log('GET API URL:', apiUrl);
        @endif

        // Prepare headers
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'API-KEY': apiConfig.key,
            'X-CSRF-TOKEN': apiConfig.csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };

        @if(config('app.debug'))
        console.log('Request headers prepared');
        @endif

        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: headers
        });

        @if(config('app.debug'))
        console.log('GET Response status:', response.status);
        @endif

        if (!response.ok) {
            const errorText = await response.text();
            @if(config('app.debug'))
            console.error('GET Error response body:', errorText);
            @endif

            let errorData;
            try {
                errorData = JSON.parse(errorText);
            } catch (e) {
                errorData = { message: errorText };
            }

            throw new Error(`HTTP ${response.status}: ${errorData.message || errorText}`);
        }

        const data = await response.json();
        @if(config('app.debug'))
        console.log('GET Response data received');
        @endif

        if (data.status === 'success') {
            currentAk01Data = data.data;
            displayAk01Data(data.data);
            showMainContent();
        } else {
            throw new Error(data.message || 'Gagal memuat data');
        }
    } catch (error) {
        @if(config('app.debug'))
        console.error('Error loading AK01 data:', error);
        @endif
        showError('Gagal memuat data: ' + error.message);
    } finally {
        showLoading(false);
    }
}

function displayAk01Data(data) {
    const { general_info, ak01, record_exists } = data;

    // Display general information
    updateElementText('judul-skema', general_info.judul_skema);
    updateElementText('kode-skema', general_info.kode_skema);
    updateElementText('nama-tuk', general_info.nama_tuk);
    updateElementText('nama-asesor', general_info.nama_asesor);
    updateElementText('nama-asesi', general_info.nama_asesi);
    updateElementText('tanggal-pelaksanaan', general_info.pelaksanaan_asesmen_disepakati_mulai);
    updateElementText('tuk-pelaksanaan', general_info.nama_tuk);

    if (record_exists && ak01) {
        // Display hasil yang akan dikumpulkan
        displayHasilItems(ak01.hasil_yang_akan_dikumpulkan || []);

        // Display signature information
        displaySignatureInfo(ak01);
    } else {
        // Show empty state for hasil items
        document.getElementById('hasil-items').innerHTML = '<p class="text-gray-500 italic">Belum ada data hasil yang akan dikumpulkan</p>';

        // Initialize empty signature info
        displaySignatureInfo({
            tanda_tangan_asesi: null,
            waktu_tanda_tangan_asesi: null,
            tanda_tangan_asesor: null,
            waktu_tanda_tangan_asesor: null
        });
    }
}

function displayHasilItems(hasilItems) {
    const container = document.getElementById('hasil-items');

    if (!Array.isArray(hasilItems) || hasilItems.length === 0) {
        container.innerHTML = '<p class="text-gray-500 italic">Belum ada data hasil yang akan dikumpulkan</p>';
        return;
    }

    let html = '';
    hasilItems.forEach((item, index) => {
        const id = `hasil-item-${index}`;
        html += `
            <div class="flex items-start mb-2">
                <input type="checkbox" id="${id}" class="h-4 w-4 text-blue-600 border-gray-300 rounded mt-1" checked disabled>
                <label for="${id}" class="ml-2 text-sm leading-relaxed">${escapeHtml(item)}</label>
            </div>
        `;
    });

    container.innerHTML = html;
}

function displaySignatureInfo(ak01) {
    // Asesi signature
    const asesiSigned = ak01.tanda_tangan_asesi && ak01.tanda_tangan_asesi !== 'null';
    const asesiCheckbox = document.getElementById('approve-pemohon');
    const saveBtn = document.getElementById('save-btn');

    if (asesiSigned) {
        // Show signature image
        const imageUrl = buildImageUrl(ak01.tanda_tangan_asesi);
        document.getElementById('ttd-asesi-container').innerHTML =
            `<img src="${imageUrl}" alt="Tanda Tangan Asesi" class="h-20 inline border border-gray-300 rounded">`;

        // Lock checkbox and button
        asesiCheckbox.checked = true;
        asesiCheckbox.disabled = true;

        // Update button state
        saveBtn.textContent = 'SUDAH DITANDATANGANI';
        saveBtn.disabled = true;
        saveBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
        saveBtn.classList.add('bg-gray-400', 'cursor-not-allowed');

        @if(config('app.debug'))
        console.log('Form locked - Asesi has already signed');
        @endif
    } else {
        // Reset signature display
        document.getElementById('ttd-asesi-container').innerHTML = '<span class="text-gray-500 italic">Belum ditandatangani</span>';

        // Enable checkbox and button
        asesiCheckbox.checked = false;
        asesiCheckbox.disabled = false;

        // Reset button state
        document.getElementById('save-btn-text').textContent = 'SAVE';
        saveBtn.disabled = false;
        saveBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
        saveBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');

        @if(config('app.debug'))
        console.log('Form available - Asesi can sign');
        @endif
    }

    // Display asesi signature timestamp
    updateElementText('tanggal-ttd-asesi', ak01.waktu_tanda_tangan_asesi || '-');

    // Asesor signature
    if (ak01.tanda_tangan_asesor && ak01.tanda_tangan_asesor !== 'null') {
        const imageUrl = buildImageUrl(ak01.tanda_tangan_asesor);
        document.getElementById('ttd-asesor-container').innerHTML =
            `<img src="${imageUrl}" alt="Tanda Tangan Asesor" class="h-20 inline border border-gray-300 rounded">`;
    } else {
        document.getElementById('ttd-asesor-container').innerHTML = '<span class="text-gray-500 italic">Belum ditandatangani</span>';
    }

    // Display asesor signature timestamp
    updateElementText('tanggal-ttd-asesor', ak01.waktu_tanda_tangan_asesor || '-');
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

async function handleAsesiSignature(checkbox) {
    if (isProcessing) {
        checkbox.checked = !checkbox.checked;
        return;
    }

    if (checkbox.checked) {
        // Show signature confirmation modal
        showSignatureModal();
    }
}

async function processSignature() {
    if (isProcessing) {
        return;
    }

    try {
        isProcessing = true;

        // Update confirm button state
        const confirmBtn = document.getElementById('confirm-signature');
        const confirmBtnText = document.getElementById('confirm-signature-text');
        const confirmBtnLoading = document.getElementById('confirm-signature-loading');

        confirmBtn.disabled = true;
        confirmBtnText.textContent = 'Menandatangani...';
        confirmBtnLoading.classList.remove('hidden');

        // Process the signature
        await saveAk01Asesi(true);

        // Hide signature modal and show success modal
        hideSignatureModal();
        showSuccessModal();

    } catch (error) {
        @if(config('app.debug'))
        console.error('Error processing signature:', error);
        @endif

        // Reset checkbox if error
        const checkbox = document.getElementById('approve-pemohon');
        checkbox.checked = false;
        checkbox.disabled = false;

        // Hide modal and show error
        hideSignatureModal();
        showError('Gagal memproses tanda tangan: ' + error.message);
    } finally {
        // Reset confirm button state
        const confirmBtn = document.getElementById('confirm-signature');
        const confirmBtnText = document.getElementById('confirm-signature-text');
        const confirmBtnLoading = document.getElementById('confirm-signature-loading');

        confirmBtn.disabled = false;
        confirmBtnText.textContent = 'Ya, Tandatangani';
        confirmBtnLoading.classList.add('hidden');

        isProcessing = false;
    }
}

async function saveAk01Asesi(isSigning = false) {
    if (isProcessing && !isSigning) {
        return;
    }

    try {
        isProcessing = true;

        // Update button state if not from modal
        if (!isSigning) {
            const saveBtn = document.getElementById('save-btn');
            const saveBtnText = document.getElementById('save-btn-text');
            const saveBtnLoading = document.getElementById('save-btn-loading');

            saveBtn.disabled = true;
            saveBtnText.textContent = 'Menyimpan...';
            saveBtnLoading.classList.remove('hidden');
        }

        // Prepare request data
        const requestData = {
            id_asesi: apiConfig.asesiId,
            id_asesor: apiConfig.asesorId,
            is_signing: isSigning
        };

        @if(config('app.debug'))
        console.log('POST Request data prepared');
        @endif

        // Construct the API URL dynamically
        const saveUrl = `${apiConfig.url}/asesmen/ak01/asesi/save`;

        @if(config('app.debug'))
        console.log('POST API URL:', saveUrl);
        @endif

        // Prepare headers
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'API-KEY': apiConfig.key,
            'X-CSRF-TOKEN': apiConfig.csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };

        @if(config('app.debug'))
        console.log('POST Request headers prepared');
        @endif

        const response = await fetch(saveUrl, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(requestData)
        });

        @if(config('app.debug'))
        console.log('POST Response status:', response.status);
        @endif

        if (!response.ok) {
            const errorText = await response.text();
            @if(config('app.debug'))
            console.error('POST Error response body:', errorText);
            @endif

            let errorData;
            try {
                errorData = JSON.parse(errorText);
            } catch (e) {
                errorData = { message: errorText };
            }

            throw new Error(`HTTP ${response.status}: ${errorData.message || errorText}`);
        }

        const data = await response.json();
        @if(config('app.debug'))
        console.log('POST Response data received');
        @endif

        if (data.status === 'success') {
            @if(config('app.debug'))
            if (isSigning) {
                console.log('Form signed successfully');
            } else {
                console.log('Form saved successfully');
            }
            @endif

            // Reload data to reflect changes
            setTimeout(async () => {
                await loadAk01Data(apiConfig.asesiId);
            }, 1000);
        } else {
            throw new Error(data.message || 'Gagal menyimpan data');
        }
    } catch (error) {
        @if(config('app.debug'))
        console.error('Error saving AK01 data:', error);
        @endif

        if (!isSigning) {
            showError('Gagal menyimpan data: ' + error.message);

            // Reset button state
            const saveBtn = document.getElementById('save-btn');
            const saveBtnText = document.getElementById('save-btn-text');
            const saveBtnLoading = document.getElementById('save-btn-loading');

            saveBtnText.textContent = 'SAVE';
            saveBtn.disabled = false;
            saveBtnLoading.classList.add('hidden');
            saveBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
            saveBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        }

        throw error; // Re-throw for modal handling
    }
}

// Modal control functions
function showSignatureModal() {
    const modal = document.getElementById('signature-modal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Force center positioning
    setTimeout(() => {
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
    }, 10);
}

function hideSignatureModal() {
    const modal = document.getElementById('signature-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    modal.style.display = '';
}

function showSuccessModal() {
    const modal = document.getElementById('success-modal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Force center positioning
    setTimeout(() => {
        modal.style.display = 'flex';
        modal.style.alignItems = 'center';
        modal.style.justifyContent = 'center';
    }, 10);
}

function hideSuccessModal() {
    const modal = document.getElementById('success-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    modal.style.display = '';
}

// Utility functions
function updateElementText(elementId, text) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = text || '-';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showError(message) {
    document.getElementById('error-text').textContent = message;
    document.getElementById('error-message').classList.remove('hidden');
}

function hideError() {
    document.getElementById('error-message').classList.add('hidden');
}

function showLoading(show) {
    const loadingEl = document.getElementById('loading');
    if (show) {
        loadingEl.classList.remove('hidden');
        loadingEl.style.display = 'block';
    } else {
        loadingEl.classList.add('hidden');
        loadingEl.style.display = 'none';
    }
}

function showMainContent() {
    document.getElementById('main-content').classList.remove('hidden');
}

function retryLoad() {
    hideError();
    loadAk01Data(apiConfig.asesiId);
}

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

// Debug functions (only available in development)
@if(config('app.debug'))
window.debugAK01 = function() {
    console.log('=== AK01 Debug Info ===');
    console.log('API Config:', {
        url: apiConfig.url,
        key: 'Present',
        asesiId: apiConfig.asesiId,
        asesorId: apiConfig.asesorId,
        csrfToken: 'Present'
    });
    console.log('Current AK01 Data:', currentAk01Data);
    console.log('Is Processing:', isProcessing);
    console.log('=== End Debug Info ===');
};

window.refreshAK01Data = function() {
    console.log('Manually refreshing AK01 data...');
    loadAk01Data(apiConfig.asesiId);
};
@endif
</script>
@endsection
