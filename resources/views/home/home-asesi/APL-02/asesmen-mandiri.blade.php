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

                                    <!-- Existing signature display for asesor -->
                                    <div id="asesorExistingSignature" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hidden">
                                        <img id="tandaTanganAsesorExisting" src="" alt="Tanda Tangan Asesor" class="max-w-full max-h-full rounded object-contain">
                                    </div>

                                    <!-- Default state for asesor signature -->
                                    <div id="asesorSignatureDisplay" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <span id="noTtdAsesor" class="text-gray-400 text-center px-4 text-sm">Menunggu tanda tangan dari asesor</span>
                                    </div>

                                    <p class="font-medium text-gray-700 mt-3">Asesor</p>
                                    <p id="namaAsesorTtd" class="text-sm text-gray-600">{{ $asesor->nama_asesor ?? '-' }}</p>
                                </div>

                                <!-- Tanda Tangan Asesi -->
                                <div class="flex flex-col items-center">
                                    <h4 class="font-medium text-gray-700 mb-2">Tanda Tangan Asesi</h4>
                                    <p id="tanggalTtdAsesi" class="text-sm text-gray-600 mb-3">-</p>

                                    <!-- Display tanda tangan from APL01 (if exists and APL02 not signed yet) -->
                                    <div id="asesiApl01Signature" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hidden">
                                        <img id="tandaTanganAsesiApl01" src="" alt="Tanda Tangan Asesi dari APL01" class="max-w-full max-h-full rounded object-contain">
                                    </div>

                                    <!-- Existing signature display for asesi (from APL02) -->
                                    <div id="asesiExistingSignature" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hidden">
                                        <img id="tandaTanganAsesiExisting" src="" alt="Tanda Tangan Asesi" class="max-w-full max-h-full rounded object-contain">
                                    </div>

                                    <!-- Default state when no signature -->
                                    <div id="asesiSignatureDisplay" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <span id="noTtdAsesi" class="text-gray-400 text-center px-4 text-sm">Menggunakan tanda tangan dari APL01</span>
                                    </div>

                                    <p class="font-medium text-gray-700 mt-3">Asesi</p>
                                    <p id="namaAsesiTtd" class="text-sm text-gray-600">{{ $asesi->nama_asesi ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Note about signature -->
                            <div class="mt-6 text-center">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-sm text-blue-800">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        Tanda tangan Anda dari APL01 akan digunakan untuk menyelesaikan asesmen mandiri ini
                                    </p>
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

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-2">Konfirmasi Persetujuan</h3>
            <div class="mt-2 px-4 py-3">
                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin menyetujui hasil asesmen mandiri ini?
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-yellow-800">
                        <strong>Perhatian:</strong> Tindakan ini akan menandatangani dokumen menggunakan tanda tangan dari APL01 dan tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            <div class="flex justify-center space-x-3">
                <button id="confirmYes" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Ya, Saya Setuju
                </button>
                <button id="confirmNo" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk Upload Area -->
<style>
#asesiApl01Signature img,
#asesiExistingSignature img,
#asesorExistingSignature img {
    max-width: 100%;
    height: auto;
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
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiKey = "{{ env('API_KEY') }}";
    const asesiId = @json($asesi->id_asesi ?? null);
    const asesorId = @json($rincianAsesmen->asesor->id_asesor ?? null);

    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // API Headers for JSON requests
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiKey,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken || '',
        'X-Requested-With': 'XMLHttpRequest'
    };

    let currentApl02Data = null;
    let asesiApl01SignatureUrl = null;

    // Check if required IDs exist
    if (!asesiId || !asesorId) {
        showError('Data asesi atau asesor tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    console.log('Debug Info:', {
        asesiId: asesiId,
        asesorId: asesorId,
        csrfToken: csrfToken ? 'Present' : 'Missing',
        apiKey: apiKey ? 'Present' : 'Missing'
    });

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

    function showError(message) {
        console.error('Error:', message);
        document.getElementById('errorText').textContent = message;
        document.getElementById('errorMessage').classList.remove('hidden');
        hideOtherMessages('error');
    }

    function showSuccess(message) {
        console.log('Success:', message);
        document.getElementById('successText').textContent = message;
        document.getElementById('successMessage').classList.remove('hidden');
        hideOtherMessages('success');
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
            console.error('Error formatting date:', e);
            return dateString; // Return original on error
        }
    }

    // Load APL01 signature data
    function loadApl01SignatureData() {
        const apiUrl = `{{ url('/api/v1/asesmen/apl01') }}/${asesiId}`;
        console.log('Loading APL01 signature from:', apiUrl);

        return fetch(apiUrl, {
            method: 'GET',
            headers: apiHeaders
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('APL01 Signature Result:', result);

            if (result.status === 'success' && result.data && result.data.detail_apl01) {
                const apl01Data = result.data.detail_apl01;

                if (apl01Data.ttd_asesi) {
                    asesiApl01SignatureUrl = apl01Data.ttd_asesi;
                    console.log('Found APL01 signature:', asesiApl01SignatureUrl);

                    // Show APL01 signature in asesi section
                    const apl01Img = document.getElementById('tandaTanganAsesiApl01');
                    const asesiDisplay = document.getElementById('asesiSignatureDisplay');
                    const apl01Signature = document.getElementById('asesiApl01Signature');

                    if (apl01Img && asesiDisplay && apl01Signature) {
                        apl01Img.src = asesiApl01SignatureUrl;
                        asesiDisplay.classList.add('hidden');
                        apl01Signature.classList.remove('hidden');
                    }

                    return true; // Has signature
                } else {
                    console.log('No APL01 signature found');
                    return false; // No signature
                }
            } else {
                console.log('APL01 data not found or incomplete');
                return false;
            }
        })
        .catch(error => {
            console.error('Error loading APL01 signature:', error);
            return false;
        });
    }

    // Load APL02 data
    function loadAPL02Data() {
        showLoading(true);

        const apiUrl = `{{ url('/api/v1/asesmen/apl02/asesi') }}/${asesiId}`;
        console.log('Loading APL02 data from:', apiUrl);

        fetch(apiUrl, {
            method: 'GET',
            headers: apiHeaders
        })
        .then(response => {
            console.log('APL02 Load Response Status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('APL02 Load Result:', result);

            if (result.status === 'success' && result.data) {
                currentApl02Data = result.data;
                return populateFormData(result.data);
            } else if (result.status === 'info') {
                showError(result.message || 'Formulir APL02 belum dibuat oleh asesor');
                return Promise.resolve();
            } else {
                showError('Gagal memuat data APL02: ' + (result.message || 'Terjadi kesalahan'));
                return Promise.resolve();
            }
        })
        .catch(error => {
            console.error('Error loading APL02 data:', error);
            showError('Error memuat data APL02: ' + error.message);
            return Promise.resolve();
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

        // Populate unit kompetensi
        populateUnitKompetensi(detailSkema);

        // Update signature section
        updateSignatureSection(detailApl02, generalInfo);

        // Load APL01 signature if APL02 asesi hasn't signed yet
        if (!detailApl02 || !detailApl02.waktu_tanda_tangan_asesi) {
            return loadApl01SignatureData().then(() => {
                updateButtonState();
            });
        } else {
            updateButtonState();
            return Promise.resolve();
        }
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

    // Update signature section
    function updateSignatureSection(detailApl02, generalInfo) {
        // Update names
        document.getElementById('namaAsesiTtd').textContent = generalInfo.nama_asesi || 'Tidak tersedia';

        if (detailApl02) {
            // Update asesor signature
            if (detailApl02.waktu_tanda_tangan_asesor) {
                document.getElementById('tanggalTtdAsesor').textContent = formatDateFromWIB(detailApl02.waktu_tanda_tangan_asesor);

                if (detailApl02.ttd_asesor) {
                    const asesorImg = document.getElementById('tandaTanganAsesorExisting');
                    const asesorDisplay = document.getElementById('asesorSignatureDisplay');
                    const asesorExisting = document.getElementById('asesorExistingSignature');

                    asesorImg.src = detailApl02.ttd_asesor;
                    asesorDisplay.classList.add('hidden');
                    asesorExisting.classList.remove('hidden');
                }
            }

            // Update asesi signature if already signed in APL02
            if (detailApl02.waktu_tanda_tangan_asesi) {
                document.getElementById('tanggalTtdAsesi').textContent = formatDateFromWIB(detailApl02.waktu_tanda_tangan_asesi);

                if (detailApl02.ttd_asesi) {
                    const asesiImg = document.getElementById('tandaTanganAsesiExisting');
                    const asesiDisplay = document.getElementById('asesiSignatureDisplay');
                    const apl01Signature = document.getElementById('asesiApl01Signature');
                    const asesiExisting = document.getElementById('asesiExistingSignature');

                    asesiImg.src = detailApl02.ttd_asesi;
                    asesiDisplay.classList.add('hidden');
                    apl01Signature.classList.add('hidden');
                    asesiExisting.classList.remove('hidden');
                }
            }
        }
    }

    // Update button state based on conditions
    function updateButtonState() {
        const btnSetujui = document.getElementById('btnSetujui');

        if (!currentApl02Data || !currentApl02Data.detail_apl02) {
            btnSetujui.disabled = true;
            btnSetujui.textContent = 'APL02 Belum Dibuat';
            return;
        }

        const detailApl02 = currentApl02Data.detail_apl02;

        // Check if asesi already signed
        if (detailApl02.waktu_tanda_tangan_asesi) {
            btnSetujui.disabled = true;
            btnSetujui.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Sudah Disetujui
            `;
            btnSetujui.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            btnSetujui.classList.add('bg-green-500');
            return;
        }

        // Check if asesor has signed
        if (!detailApl02.waktu_tanda_tangan_asesor) {
            btnSetujui.disabled = true;
            btnSetujui.textContent = 'Menunggu Tanda Tangan Asesor';
            return;
        }

        // Check if asesi has signature from APL01
        if (asesiApl01SignatureUrl) {
            btnSetujui.disabled = false;
            btnSetujui.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Saya Setuju
            `;
        } else {
            btnSetujui.disabled = true;
            btnSetujui.textContent = 'Tanda Tangan APL01 Tidak Ditemukan';
        }
    }

    // Handle approval
    function handleApproval() {
        if (!asesiApl01SignatureUrl) {
            showError('Tanda tangan dari APL01 tidak ditemukan. Silakan lengkapi APL01 terlebih dahulu.');
            return;
        }

        console.log('Preparing to submit approval using APL01 signature');

        // Prepare request data (JSON only, no file upload needed)
        const requestData = {
            id_asesi: asesiId,
            id_asesor: asesorId,
            is_signing: true
        };

        console.log('Request Data:', requestData);

        const apiUrl = `{{ url('/api/v1/asesmen/apl02/asesi/sign') }}`;
        console.log('Submitting to:', apiUrl);

        showLoading(true);

        fetch(apiUrl, {
            method: 'POST',
            headers: apiHeaders,
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('Approval Response Status:', response.status);

            // Clone response to read both text and json
            return response.clone().text().then(text => {
                console.log('Raw response:', text);

                if (!response.ok) {
                    // Try to parse as JSON for error details
                    try {
                        const errorData = JSON.parse(text);
                        console.log('Error response data:', errorData);
                        throw new Error(`HTTP ${response.status}: ${errorData.message || errorData.error || 'Validation failed'}`);
                    } catch (parseError) {
                        throw new Error(`HTTP ${response.status}: ${text || 'Unknown error'}`);
                    }
                }

                return JSON.parse(text);
            });
        })
        .then(result => {
            console.log('Approval Result:', result);
            showLoading(false);

            if (result.status === 'success') {
                showSuccess(result.message || 'APL02 berhasil disetujui dan ditandatangani menggunakan tanda tangan dari APL01');

                // Update signature display
                document.getElementById('tanggalTtdAsesi').textContent = new Date().toLocaleDateString('id-ID');

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
            console.error('Error approving APL02:', error);
            showError('Error menyetujui APL02: ' + error.message);
        });
    }

    // Modal functionality
    function showConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function hideConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    // Event listeners
    document.getElementById('btnSetujui').addEventListener('click', function() {
        if (!this.disabled) {
            showConfirmModal();
        }
    });

    document.getElementById('confirmYes').addEventListener('click', function() {
        hideConfirmModal();
        handleApproval();
    });

    document.getElementById('confirmNo').addEventListener('click', function() {
        hideConfirmModal();
    });

    // Close modal when clicking outside
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideConfirmModal();
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

    // Initialize page
    loadAPL02Data();
});
</script>
@endsection
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

                                    <!-- Existing signature display for asesor -->
                                    <div id="asesorExistingSignature" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hidden">
                                        <img id="tandaTanganAsesorExisting" src="" alt="Tanda Tangan Asesor" class="max-w-full max-h-full rounded object-contain">
                                    </div>

                                    <!-- Default state for asesor signature -->
                                    <div id="asesorSignatureDisplay" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <span id="noTtdAsesor" class="text-gray-400 text-center px-4 text-sm">Menunggu tanda tangan dari asesor</span>
                                    </div>

                                    <p class="font-medium text-gray-700 mt-3">Asesor</p>
                                    <p id="namaAsesorTtd" class="text-sm text-gray-600">{{ $asesor->nama_asesor ?? '-' }}</p>
                                </div>

                                <!-- Tanda Tangan Asesi -->
                                <div class="flex flex-col items-center">
                                    <h4 class="font-medium text-gray-700 mb-2">Tanda Tangan Asesi</h4>
                                    <p id="tanggalTtdAsesi" class="text-sm text-gray-600 mb-3">-</p>

                                    <!-- Existing signature from previous forms (stored signature) -->
                                    <div id="asesiStoredSignature" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hidden">
                                        <img id="tandaTanganAsesiStored" src="" alt="Tanda Tangan Asesi Tersimpan" class="max-w-full max-h-full rounded object-contain">
                                    </div>

                                    <!-- Existing signature display for asesi (from APL02) -->
                                    <div id="asesiExistingSignature" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 hidden">
                                        <img id="tandaTanganAsesiExisting" src="" alt="Tanda Tangan Asesi" class="max-w-full max-h-full rounded object-contain">
                                    </div>

                                    <!-- Default state when no signature -->
                                    <div id="asesiSignatureDisplay" class="w-60 h-40 border border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <span id="noTtdAsesi" class="text-gray-400 text-center px-4 text-sm">Menggunakan tanda tangan tersimpan</span>
                                    </div>

                                    <p class="font-medium text-gray-700 mt-3">Asesi</p>
                                    <p id="namaAsesiTtd" class="text-sm text-gray-600">{{ $asesi->nama_asesi ?? '-' }}</p>
                                </div>
                            </div>

                            <!-- Note about signature -->
                            <div class="mt-6 text-center">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-sm text-blue-800">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        Tanda tangan Anda yang tersimpan akan digunakan untuk menyelesaikan asesmen mandiri ini
                                    </p>
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

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-lg bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-2">Konfirmasi Persetujuan</h3>
            <div class="mt-2 px-4 py-3">
                <p class="text-sm text-gray-600 mb-4">
                    Apakah Anda yakin ingin menyetujui hasil asesmen mandiri ini?
                </p>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-yellow-800">
                        <strong>Perhatian:</strong> Tindakan ini akan menandatangani dokumen menggunakan tanda tangan tersimpan dan tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
            <div class="flex justify-center space-x-3">
                <button id="confirmYes" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Ya, Saya Setuju
                </button>
                <button id="confirmNo" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 text-sm font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk styling -->
<style>
#asesiStoredSignature img,
#asesiExistingSignature img,
#asesorExistingSignature img {
    max-width: 100%;
    height: auto;
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
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiKey = "{{ env('API_KEY') }}";
    const asesiId = @json($asesi->id_asesi ?? null);
    const asesorId = @json($rincianAsesmen->asesor->id_asesor ?? null);
    const userId = @json(auth()->user()->id_user);

    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // API Headers for JSON requests
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiKey,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken || '',
        'X-Requested-With': 'XMLHttpRequest'
    };

    let currentApl02Data = null;
    let asesiStoredSignatureUrl = null;

    // Check if required IDs exist
    if (!asesiId || !asesorId || !userId) {
        showError('Data asesi, asesor, atau user tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    console.log('Debug Info:', {
        asesiId: asesiId,
        asesorId: asesorId,
        userId: userId,
        csrfToken: csrfToken ? 'Present' : 'Missing',
        apiKey: apiKey ? 'Present' : 'Missing'
    });

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

    function showError(message) {
        console.error('Error:', message);
        document.getElementById('errorText').textContent = message;
        document.getElementById('errorMessage').classList.remove('hidden');
        hideOtherMessages('error');
    }

    function showSuccess(message) {
        console.log('Success:', message);
        document.getElementById('successText').textContent = message;
        document.getElementById('successMessage').classList.remove('hidden');
        hideOtherMessages('success');
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
            console.error('Error formatting date:', e);
            return dateString; // Return original on error
        }
    }

    // Load stored signature data for asesi
    function loadStoredSignatureData() {
        // Generate the signature path based on user ID
        const signaturePath = `{{ asset('storage/signatures') }}/${userId}.png`;
        console.log('Checking stored signature at:', signaturePath);

        // Check if signature file exists by trying to load it
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = function() {
                asesiStoredSignatureUrl = signaturePath;
                console.log('Found stored signature:', asesiStoredSignatureUrl);

                // Show stored signature in asesi section
                const storedImg = document.getElementById('tandaTanganAsesiStored');
                const asesiDisplay = document.getElementById('asesiSignatureDisplay');
                const storedSignature = document.getElementById('asesiStoredSignature');

                if (storedImg && asesiDisplay && storedSignature) {
                    storedImg.src = asesiStoredSignatureUrl;
                    asesiDisplay.classList.add('hidden');
                    storedSignature.classList.remove('hidden');
                }

                resolve(true); // Has signature
            };
            img.onerror = function() {
                console.log('No stored signature found for user:', userId);

                // Update display message
                const noTtdSpan = document.getElementById('noTtdAsesi');
                if (noTtdSpan) {
                    noTtdSpan.textContent = 'Tidak ada tanda tangan tersimpan';
                    noTtdSpan.classList.add('text-red-400');
                }

                resolve(false); // No signature
            };
            img.src = signaturePath;
        });
    }

    // Load APL02 data
    function loadAPL02Data() {
        showLoading(true);

        const apiUrl = `{{ url('/api/v1/asesmen/apl02/asesi') }}/${asesiId}`;
        console.log('Loading APL02 data from:', apiUrl);

        fetch(apiUrl, {
            method: 'GET',
            headers: apiHeaders
        })
        .then(response => {
            console.log('APL02 Load Response Status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('APL02 Load Result:', result);

            if (result.status === 'success' && result.data) {
                currentApl02Data = result.data;
                return populateFormData(result.data);
            } else if (result.status === 'info') {
                showError(result.message || 'Formulir APL02 belum dibuat oleh asesor');
                return Promise.resolve();
            } else {
                showError('Gagal memuat data APL02: ' + (result.message || 'Terjadi kesalahan'));
                return Promise.resolve();
            }
        })
        .catch(error => {
            console.error('Error loading APL02 data:', error);
            showError('Error memuat data APL02: ' + error.message);
            return Promise.resolve();
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

        // Populate unit kompetensi
        populateUnitKompetensi(detailSkema);

        // Update signature section
        updateSignatureSection(detailApl02, generalInfo);

        // Load stored signature if APL02 asesi hasn't signed yet
        if (!detailApl02 || !detailApl02.waktu_tanda_tangan_asesi) {
            return loadStoredSignatureData().then(() => {
                updateButtonState();
            });
        } else {
            updateButtonState();
            return Promise.resolve();
        }
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

    // Update signature section
    function updateSignatureSection(detailApl02, generalInfo) {
        // Update names
        document.getElementById('namaAsesiTtd').textContent = generalInfo.nama_asesi || 'Tidak tersedia';

        if (detailApl02) {
            // Update asesor signature
            if (detailApl02.waktu_tanda_tangan_asesor) {
                document.getElementById('tanggalTtdAsesor').textContent = formatDateFromWIB(detailApl02.waktu_tanda_tangan_asesor);

                if (detailApl02.ttd_asesor) {
                    const asesorImg = document.getElementById('tandaTanganAsesorExisting');
                    const asesorDisplay = document.getElementById('asesorSignatureDisplay');
                    const asesorExisting = document.getElementById('asesorExistingSignature');

                    asesorImg.src = detailApl02.ttd_asesor;
                    asesorDisplay.classList.add('hidden');
                    asesorExisting.classList.remove('hidden');
                }
            }

            // Update asesi signature if already signed in APL02
            if (detailApl02.waktu_tanda_tangan_asesi) {
                document.getElementById('tanggalTtdAsesi').textContent = formatDateFromWIB(detailApl02.waktu_tanda_tangan_asesi);

                if (detailApl02.ttd_asesi) {
                    const asesiImg = document.getElementById('tandaTanganAsesiExisting');
                    const asesiDisplay = document.getElementById('asesiSignatureDisplay');
                    const storedSignature = document.getElementById('asesiStoredSignature');
                    const asesiExisting = document.getElementById('asesiExistingSignature');

                    asesiImg.src = detailApl02.ttd_asesi;
                    asesiDisplay.classList.add('hidden');
                    storedSignature.classList.add('hidden');
                    asesiExisting.classList.remove('hidden');
                }
            }
        }
    }

    // Update button state based on conditions
    function updateButtonState() {
        const btnSetujui = document.getElementById('btnSetujui');

        if (!currentApl02Data || !currentApl02Data.detail_apl02) {
            btnSetujui.disabled = true;
            btnSetujui.textContent = 'APL02 Belum Dibuat';
            return;
        }

        const detailApl02 = currentApl02Data.detail_apl02;

        // Check if asesi already signed
        if (detailApl02.waktu_tanda_tangan_asesi) {
            btnSetujui.disabled = true;
            btnSetujui.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Sudah Disetujui
            `;
            btnSetujui.classList.remove('bg-blue-500', 'hover:bg-blue-600');
            btnSetujui.classList.add('bg-green-500');
            return;
        }

        // Check if asesor has signed
        if (!detailApl02.waktu_tanda_tangan_asesor) {
            btnSetujui.disabled = true;
            btnSetujui.textContent = 'Menunggu Tanda Tangan Asesor';
            return;
        }

        // Check if asesi has stored signature
        if (asesiStoredSignatureUrl) {
            btnSetujui.disabled = false;
            btnSetujui.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Saya Setuju
            `;
        } else {
            btnSetujui.disabled = true;
            btnSetujui.textContent = 'Tanda Tangan Tidak Ditemukan';
        }
    }

    // Handle approval
    function handleApproval() {
        if (!asesiStoredSignatureUrl) {
            showError('Tanda tangan tersimpan tidak ditemukan. Silakan lengkapi profil Anda terlebih dahulu.');
            return;
        }

        console.log('Preparing to submit approval using stored signature');

        // Prepare request data (JSON only, no file upload needed)
        const requestData = {
            id_asesi: asesiId,
            id_asesor: asesorId,
            is_signing: true
        };

        console.log('Request Data:', requestData);

        const apiUrl = `{{ url('/api/v1/asesmen/apl02/asesi/sign') }}`;
        console.log('Submitting to:', apiUrl);

        showLoading(true);

        fetch(apiUrl, {
            method: 'POST',
            headers: apiHeaders,
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('Approval Response Status:', response.status);

            // Clone response to read both text and json
            return response.clone().text().then(text => {
                console.log('Raw response:', text);

                if (!response.ok) {
                    // Try to parse as JSON for error details
                    try {
                        const errorData = JSON.parse(text);
                        console.log('Error response data:', errorData);
                        throw new Error(`HTTP ${response.status}: ${errorData.message || errorData.error || 'Validation failed'}`);
                    } catch (parseError) {
                        throw new Error(`HTTP ${response.status}: ${text || 'Unknown error'}`);
                    }
                }

                return JSON.parse(text);
            });
        })
        .then(result => {
            console.log('Approval Result:', result);
            showLoading(false);

            if (result.status === 'success') {
                showSuccess(result.message || 'APL02 berhasil disetujui dan ditandatangani menggunakan tanda tangan tersimpan');

                // Update signature display
                document.getElementById('tanggalTtdAsesi').textContent = new Date().toLocaleDateString('id-ID');

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
            console.error('Error approving APL02:', error);
            showError('Error menyetujui APL02: ' + error.message);
        });
    }

    // Modal functionality
    function showConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function hideConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    // Event listeners
    document.getElementById('btnSetujui').addEventListener('click', function() {
        if (!this.disabled) {
            showConfirmModal();
        }
    });

    document.getElementById('confirmYes').addEventListener('click', function() {
        hideConfirmModal();
        handleApproval();
    });

    document.getElementById('confirmNo').addEventListener('click', function() {
        hideConfirmModal();
    });

    // Close modal when clicking outside
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideConfirmModal();
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

    // Initialize page
    loadAPL02Data();
});
</script>
@endsection
