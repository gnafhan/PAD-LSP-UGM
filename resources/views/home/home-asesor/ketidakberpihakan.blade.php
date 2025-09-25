@extends('home.home-asesor.layouts.layout')

@section('title', 'Ketidakberpihakan - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                    <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
                </linearGradient>
            </defs>
            <path d="M11.5898 8.37492H8.96484V7.0178C8.9771 6.42005 9.15243 5.83702 9.47191 5.33167C9.79338 4.79167 9.90956 4.15394 9.79916 3.53527C9.68877 2.91659 9.35918 2.3584 8.87078 1.96292C8.51821 1.6755 8.09697 1.48468 7.64839 1.40919C7.19982 1.3337 6.73932 1.37613 6.3121 1.53232C5.88487 1.68851 5.50559 1.95309 5.21148 2.3001C4.91737 2.64711 4.71852 3.06462 4.63447 3.51167C4.51348 4.1399 4.6301 4.79068 4.96172 5.3378C5.27571 5.82638 5.44972 6.39171 5.46484 6.9723V8.37492H2.83984C2.60778 8.37492 2.38522 8.46711 2.22113 8.6312C2.05703 8.7953 1.96484 9.01786 1.96484 9.24992V10.9999C1.96519 11.2319 2.05749 11.4542 2.22151 11.6183C2.38553 11.7823 2.60789 11.8746 2.83984 11.8749V12.7499C2.84019 12.9819 2.93249 13.2042 3.09651 13.3683C3.26053 13.5323 3.48289 13.6246 3.71484 13.6249H10.7148C10.9468 13.6246 11.1692 13.5323 11.3332 13.3683C11.4972 13.2042 11.5895 12.9819 11.5898 12.7499V11.8749C11.8218 11.8746 12.0442 11.7823 12.2082 11.6183C12.3722 11.4542 12.4645 11.2319 12.4648 10.9999V9.24992C12.4648 9.01786 12.3727 8.7953 12.2086 8.6312C12.0445 8.46711 11.8219 8.37492 11.5898 8.37492ZM5.49547 3.66917C5.54233 3.41783 5.64369 3.17981 5.79242 2.97185C5.94116 2.76389 6.13366 2.59105 6.35637 2.46548C6.57909 2.33992 6.82661 2.26468 7.08153 2.24506C7.33645 2.22544 7.59257 2.26191 7.83188 2.35192C8.07118 2.44192 8.28786 2.58327 8.46667 2.76601C8.64548 2.94876 8.78207 3.16847 8.86684 3.40968C8.95161 3.65089 8.9825 3.90774 8.95733 4.16217C8.93216 4.41661 8.85154 4.66243 8.72116 4.88236C8.39635 5.41265 8.19078 6.00725 8.11872 6.62492H6.31359C6.24475 6.00781 6.03909 5.41384 5.71159 4.8863C5.49155 4.52126 5.41456 4.08765 5.49547 3.66917ZM8.08984 7.49992V8.37492H6.33984V7.49992H8.08984ZM10.7148 12.7499H3.71484V11.8749H10.7148V12.7499ZM2.83984 10.9999V9.24992H11.5898V10.9999H2.83984Z" />
        </svg>
        <p class="ms-2 text-xl font-bold text-black">Ketidakberpihakan</p>
    </div>

    <div id="breadcrumbs" class="hidden pb-4 px-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('home-asesor') }}" class="inline-flex items-center text-sm font-medium text-black hover:text-sidebar_font">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <a href="{{ route('ketidakberpihakan-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            Ketidakberpihakan
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span id="breadcrumbAsesiName" class="ms-1 text-sm font-medium text-black">-</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>

    <div id="frameKetidakberpihakan" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Pernyataan Ketidakberpihakan</p>

        <!-- Search Form -->
        <form id="searchKetidakberpihakan" class="max-w-md mb-4 rounded-xl">
            <div class="relative">
                <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto shadow-md rounded-lg">
            <table id="daftarKetidakberpihakan" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Aksi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Memuat data asesi...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="detailKetidakberpihakan" class="hidden pt-0 p-4 text-black">
            <!-- Loading content -->
            <div id="loadingContainer" class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-biru"></div>
            </div>

            <!-- Main content container -->
            <div id="mainContent" class="hidden">
                <p id="judulDetail" class="text-lg font-semibold text-sidebar_font">
                    KETIDAKBERPIHAKAN DAN BENTURAN KEPENTINGAN ASESOR
                </p>

                <div id="Ketidakberpihakan" class="p-4 space-y-6">
                    <div class="max-w-full space-y-1">
                        <p class="text-sidebar_font font-normal text-base pb-4">Saya yang bertanda tangan di bawah ini:</p>
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nama
                            </span>
                            <p id="namaAsesor" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Alamat
                            </span>
                            <p id="alamatAsesor" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Jabatan
                            </span>
                            <p id="jabatan" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nomor REG
                            </span>
                            <p id="nomorReg" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="text-sidebar_font font-normal text-base pt-6">
                            <p class="pb-2">Menyatakan,</p>
                            <ul class="list-decimal text-sidebar_font font-normal text-base ps-6">
                                <li>Menjamin ketidakberpihakan dengan pemohon sertifikat, peserta sertifikasi dan pemegang sertifikasi</li>
                                <li>Menjaga ketidakberpihakan dan tidak akan memberi tekanan komersial, keuangan atau tekanan lainnya yang mengkompromikan ketidakberpihakan</li>
                                <li>Menjamin tidak terjadi konflik kepentingan dan menjamin objektifitas dalam kegiatan sertifikasi.</li>
                            </ul>
                            <p class="pt-2">Demikian surat pernyataan ini saya buat dalam keadaan sadar dan tidak ada tekanan dari pihak manapun.</p>
                        </div>
                    </div>
                </div>

                <!-- Signature section -->
                <div class="my-6 px-4 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Tanda Tangan Asesi (Read-only) -->
                    <div>
                        <label class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">Tanda Tangan Asesi</label>
                        <div class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 bg-gray-50 cursor-default min-h-[200px]">
                            <div class="text-center" id="asesi-signature-content">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <span class="font-semibold text-abu">Diisi oleh Asesi</span>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">Tidak diperlukan untuk formulir ini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tanda Tangan Asesor -->
                    <div>
                        <label for="is_asesor_signing" class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">
                            Tanda Tangan Asesor
                            <span class="text-red-500">*</span>
                        </label>
                        <div id="asesor-signature-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 hover:bg-blue-50 cursor-pointer min-h-[200px]">
                            <div class="text-center" id="asesor-signature-content">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <span class="font-semibold text-biru">Tanda Tangan dari Biodata</span>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">Akan menggunakan tanda tangan dari biodata</p>
                            </div>
                            <!-- Preview Image Asesor -->
                            <div id="asesor-signature-preview" class="hidden">
                                <img id="asesor-signature-image" src="" alt="Tanda Tangan Asesor" class="max-h-48 w-auto mx-auto rounded-lg p-2 border border-gray-200 bg-white shadow-sm">
                                <p class="text-xs text-center mt-2 text-gray-500">Tanda tangan asesor dari biodata</p>
                                <p id="tanggalTandaTanganAsesor" class="text-xs text-center text-gray-500">Tanggal: -</p>
                            </div>
                        </div>

                        <!-- Checkbox untuk persetujuan tanda tangan -->
                        <div class="mt-4 flex items-center justify-center">
                            <input id="is_asesor_signing" name="is_asesor_signing" type="checkbox" value="true"
                                   class="w-4 h-4 text-biru bg-gray-100 border-gray-300 rounded focus:ring-biru focus:ring-2">
                            <label for="is_asesor_signing" class="ms-2 text-sm font-medium text-sidebar_font">
                                Saya setuju menandatangani formulir ini
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Button Simpan -->
                <form id="ketidakberpihakanForm">
                    <div class="flex justify-end pe-4">
                        <button id="simpanRekomendasi" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6">
                            Simpan dan Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Berhasil!</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Formulir Ketidakberpihakan berhasil ditandatangani.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeSuccessModal" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Error!</h3>
            <div class="mt-2 px-7 py-3">
                <p id="errorMessage" class="text-sm text-gray-500">
                    Terjadi kesalahan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeErrorModal" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    // Global variables
    let currentAsesiId = null;
    let currentAsesiData = null;
    let asesorSignatureUrl = null;
    let recordExists = false;

    // Function to show error message
    function showError(message) {
        document.getElementById('errorMessage').textContent = message;
        document.getElementById('errorModal').classList.remove('hidden');
    }

    // Function to show success message
    function showSuccess() {
        document.getElementById('successModal').classList.remove('hidden');
    }

    // Function to show table error
    function showTableError(message) {
        document.querySelector('#daftarKetidakberpihakan tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">${message}</td>
            </tr>
        `;
    }

    // Function to show loading state
    function showLoading() {
        document.getElementById('loadingContainer').classList.remove('hidden');
        document.getElementById('mainContent').classList.add('hidden');
    }

    // Function to show main content
    function showMainContent() {
        document.getElementById('loadingContainer').classList.add('hidden');
        document.getElementById('mainContent').classList.remove('hidden');
    }

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        showTableError('Konfigurasi API URL tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.key) {
        showTableError('Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.asesorId) {
        showTableError('ID Asesor tidak ditemukan. Silakan login kembali.');
        return;
    }

    // Build API URLs dynamically
    const asesisApiUrl = `${apiConfig.url}/asesor/asesis/${apiConfig.asesorId}`;
    const biodataApiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;

    // Headers configuration
    const headers = {
        'Content-Type': 'application/json',
        'API-KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // Initialize
    init();

    function init() {
        // Load asesi list
        loadAsesiList();

        // Setup search functionality
        setupSearch();

        // Setup modal event listeners
        setupModals();
    }

    function loadAsesiList() {
        fetch(asesisApiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            console.log('Asesi List Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('Asesi List API Response:', result);

            if (result.success && result.data) {
                // Load progress for each asesi and then populate table
                loadAsesiProgress(result.data.asesis);
            } else {
                showTableError(result.message || 'Gagal memuat data asesi');
            }
        })
        .catch(error => {
            console.error('Error loading asesi list:', error);
            showTableError(`Error memuat data: ${error.message}`);
        });
    }

    async function loadAsesiProgress(asesisData) {
        try {
            // Load progress for each asesi
            const asesisWithProgress = await Promise.all(
                asesisData.map(async (asesi) => {
                    try {
                        const progressApiUrl = `${apiConfig.url}/asesor/progressAsesi/${asesi.id_asesi}`;
                        const progressResponse = await fetch(progressApiUrl, {
                            method: 'GET',
                            headers: headers
                        });

                        if (progressResponse.ok) {
                            const progressResult = await progressResponse.json();
                            if (progressResult.success && progressResult.data) {
                                asesi.progress_data = progressResult.data;
                                asesi.ketidakberpihakan_completed = progressResult.data.progress_asesmen?.pernyataan_ketidak_berpihakan?.completed || false;
                                asesi.ketidakberpihakan_completed_at = progressResult.data.progress_asesmen?.pernyataan_ketidak_berpihakan?.completed_at || null;
                            } else {
                                asesi.ketidakberpihakan_completed = false;
                                asesi.ketidakberpihakan_completed_at = null;
                            }
                        } else {
                            console.warn(`Failed to load progress for asesi ${asesi.id_asesi}`);
                            asesi.ketidakberpihakan_completed = false;
                            asesi.ketidakberpihakan_completed_at = null;
                        }
                    } catch (error) {
                        console.error(`Error loading progress for asesi ${asesi.id_asesi}:`, error);
                        asesi.ketidakberpihakan_completed = false;
                        asesi.ketidakberpihakan_completed_at = null;
                    }
                    return asesi;
                })
            );

            populateAsesiTable(asesisWithProgress);
        } catch (error) {
            console.error('Error loading asesi progress:', error);
            showTableError(`Error memuat progress asesi: ${error.message}`);
        }
    }

    function populateAsesiTable(asesisData) {
        const tableBody = document.querySelector('#daftarKetidakberpihakan tbody');

        if (!asesisData || asesisData.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                </tr>
            `;
            return;
        }

        let tableContent = '';
        asesisData.forEach((asesi, index) => {
            // Use the ketidakberpihakan completion status from progress API
            const hasProgress = asesi.ketidakberpihakan_completed === true;

            const statusIcon = hasProgress
                ? `<svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>`
                : `<svg class="w-6 h-6 text-logout" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                </svg>`;

            // Calculate overall progress
            const progressPercent = asesi.progress_data?.progress_summary?.progress_percentage || 0;
            const completedSteps = asesi.progress_data?.progress_summary?.completed_steps || 0;
            const totalSteps = asesi.progress_data?.progress_summary?.total_steps || 0;

            tableContent += `
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                    <td class="px-4 py-3 text-center">
                        <button onclick="showSummary('${asesi.id_asesi}', '${asesi.nama_asesi}', '${asesi.nama_skema}', ${progressPercent}, ${completedSteps}, ${totalSteps})" class="mr-2">
                            <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button onclick="showDocument('${asesi.id_asesi}', '${asesi.nama_asesi}', '${asesi.nama_skema}', ${progressPercent}, ${completedSteps}, ${totalSteps}, ${hasProgress})" class="">
                            <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </td>
                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_asesi}</td>
                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_skema}</td>
                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nomor_skema}</td>
                    <td class="flex px-4 py-3 justify-center items-center">
                        ${statusIcon}
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = tableContent;
    }

    function setupSearch() {
        const searchInput = document.getElementById('default-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#daftarKetidakberpihakan tbody tr');

                rows.forEach(row => {
                    const nama = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                    const skema = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
                    const kode = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

                    if (nama.includes(searchValue) || skema.includes(searchValue) || kode.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    }

    function setupModals() {
        // Success modal
        document.getElementById('closeSuccessModal').addEventListener('click', function() {
            document.getElementById('successModal').classList.add('hidden');
        });

        // Error modal
        document.getElementById('closeErrorModal').addEventListener('click', function() {
            document.getElementById('errorModal').classList.add('hidden');
        });
    }

    // Global functions for button clicks
    window.showSummary = function(id_asesi, nama_asesi, nama_skema, progress_percentage, completed_steps, total_steps, ketidakberpihakan_completed = false) {
        currentAsesiId = id_asesi;

        // Hide search and table
        document.getElementById('searchKetidakberpihakan').classList.add('hidden');
        document.getElementById('daftarKetidakberpihakan').classList.add('hidden');

        // Show breadcrumbs and detail
        document.getElementById('breadcrumbs').classList.remove('hidden');
        document.getElementById('detailKetidakberpihakan').classList.remove('hidden');

        // Update breadcrumb
        const breadcrumbAsesi = document.getElementById('breadcrumbAsesiName');
        if (breadcrumbAsesi) {
            breadcrumbAsesi.textContent = nama_asesi;
        }

        // Load Ketidakberpihakan data
        loadKetidakberpihakanData(id_asesi);

        // Scroll to detail
        document.getElementById('detailKetidakberpihakan').scrollIntoView({ behavior: 'smooth' });
    };

    function loadKetidakberpihakanData(id_asesi) {
        const ketidakberpihakanApiUrl = `${apiConfig.url}/asesmen/ketidakberpihakan/${id_asesi}`;

        showLoading();

        fetch(ketidakberpihakanApiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            console.log('Ketidakberpihakan Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('Ketidakberpihakan API Response:', result);

            if (result.status === 'success' && result.data) {
                currentAsesiData = result.data;
                recordExists = result.data.record_exists;
                populateKetidakberpihakanForm(result.data);

                // Load asesor signature from biodata
                loadAsesorSignature();
            } else {
                showError(result.message || 'Gagal memuat data Ketidakberpihakan');
            }
        })
        .catch(error => {
            console.error('Error loading Ketidakberpihakan data:', error);
            showError(`Error memuat data: ${error.message}`);
        });
    }

    function populateKetidakberpihakanForm(data) {
        // Populate general info
        document.getElementById('namaAsesor').textContent = data.general_info.nama_asesor;
        document.getElementById('alamatAsesor').textContent = data.general_info.alamat;
        document.getElementById('jabatan').textContent = data.general_info.jabatan;
        document.getElementById('nomorReg').textContent = data.general_info.kode_registrasi ?? 'Tidak ada nomor registrasi';

        // If record exists and has signature, show it
        if (recordExists && data.ketidakberpihakan) {
            const signatureData = data.ketidakberpihakan;

            if (signatureData.tanda_tangan_asesor) {
                // Show existing signature
                const asesorImage = document.getElementById('asesor-signature-image');
                const asesorContent = document.getElementById('asesor-signature-content');
                const asesorPreview = document.getElementById('asesor-signature-preview');
                const tanggalElement = document.getElementById('tanggalTandaTanganAsesor');

                if (asesorImage && asesorContent && asesorPreview && tanggalElement) {
                    asesorImage.src = signatureData.tanda_tangan_asesor;
                    asesorContent.classList.add('hidden');
                    asesorPreview.classList.remove('hidden');

                    // Format and display signature date
                    const signatureDate = new Date(signatureData.waktu_tanda_tangan_asesor);
                    tanggalElement.textContent = `Tanggal: ${signatureDate.toLocaleDateString('id-ID')}`;
                }

                // Disable form elements since already signed
                const checkbox = document.getElementById('is_asesor_signing');
                const submitButton = document.getElementById('simpanRekomendasi');

                if (checkbox) {
                    checkbox.checked = true;
                    checkbox.disabled = true;
                }

                if (submitButton) {
                    submitButton.textContent = 'Sudah Ditandatangani';
                    submitButton.disabled = true;
                    submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru_soft');
                    submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                }
            }
        }

        // Setup form submission
        setupFormSubmission();

        // Show main content
        showMainContent();
    }

    function loadAsesorSignature() {
        fetch(biodataApiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data?.file_url_tanda_tangan) {
                asesorSignatureUrl = result.data.file_url_tanda_tangan;

                // Only show preview if not already signed
                if (!recordExists) {
                    const asesorImage = document.getElementById('asesor-signature-image');
                    const asesorContent = document.getElementById('asesor-signature-content');
                    const asesorPreview = document.getElementById('asesor-signature-preview');

                    if (asesorImage && asesorContent && asesorPreview) {
                        asesorImage.src = asesorSignatureUrl;
                        asesorContent.classList.add('hidden');
                        asesorPreview.classList.remove('hidden');
                    }
                }
            } else {
                console.warn('Asesor belum memiliki tanda tangan di biodata');
            }
        })
        .catch(error => {
            console.error('Error loading asesor signature:', error);
        });
    }

    function setupFormSubmission() {
        const form = document.getElementById('ketidakberpihakanForm');
        if (form) {
            // Remove existing event listeners
            form.replaceWith(form.cloneNode(true));

            // Add new event listener
            document.getElementById('ketidakberpihakanForm').addEventListener('submit', handleFormSubmit);
        }
    }

    function handleFormSubmit(e) {
        e.preventDefault();

        if (!currentAsesiId) {
            showError('ID Asesi tidak ditemukan');
            return;
        }

        if (!asesorSignatureUrl) {
            showError('Anda belum memiliki tanda tangan di biodata. Silakan upload tanda tangan di halaman biodata terlebih dahulu.');
            return;
        }

        const checkbox = document.getElementById('is_asesor_signing');
        if (!checkbox || !checkbox.checked) {
            showError('Anda harus menyetujui untuk menandatangani formulir ini');
            return;
        }

        // Show loading state
        const submitButton = document.getElementById('simpanRekomendasi');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Menyimpan...';
        submitButton.disabled = true;

        // Prepare data for API
        const requestData = {
            id_asesi: currentAsesiId,
            id_asesor: apiConfig.asesorId
        };

        // Submit to API
        const saveApiUrl = `${apiConfig.url}/asesmen/ketidakberpihakan/sign`;

        fetch(saveApiUrl, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('Save Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('Save API Response:', result);

            if (result.status === 'success') {
                showSuccess();

                // Reload Ketidakberpihakan data to show updated information
                setTimeout(() => {
                    loadKetidakberpihakanData(currentAsesiId);
                    // Also reload the asesi list to update the progress status
                    loadAsesiList();
                }, 1000);
            } else {
                throw new Error(result.message || 'Gagal menyimpan data');
            }
        })
        .catch(error => {
            console.error('Error saving Ketidakberpihakan data:', error);
            showError(`Error menyimpan data: ${error.message}`);
        })
        .finally(() => {
            // Restore button state
            if (submitButton) {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }

    // Add window alias for backward compatibility
    window.showDocument = function(id_asesi, nama_asesi, nama_skema, progress_percentage, completed_steps, total_steps, ketidakberpihakan_completed = false) {
        window.open('/asesor/ketidakberpihakan/pdf/' + id_asesi, "_blank");
    };
    ///ketidakberpihakan/pdf/{id_asesi}
});
</script>
@endsection
