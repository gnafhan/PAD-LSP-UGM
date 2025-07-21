@extends('home.home-asesor.layouts.layout')

@section('title', 'Home - Asesor')

@section('content')
<div id="backFrame" class="lg:pt-[88px] lg:pb-80 lg:px-16 md:bg-bg_dashboard lg:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mb-4 ms-4">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
        </svg>
        <span class="ms-2 text-xl font-bold text-black">Home Asesor</span>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameHomeAsesor" class="relative z-10 p-8 border border-border bg-white rounded-2xl">
        <!-- Loading State Indicator -->
        <div id="loadingState" class="w-full flex flex-col items-center justify-center py-8">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="animate-spin h-8 w-8 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-medium text-gray-700">Memuat data asesor...</span>
            </div>
            <div class="text-sm text-gray-500 text-center max-w-md">
                Sistem sedang mengambil informasi profil dan statistik asesor dari server. Mohon tunggu sebentar.
            </div>
        </div>

        <!-- Content (hidden until loaded) -->
        <div id="contentState" class="hidden">
            <p class="pb-3 text-lg font-medium text-black">Profile</p>
            <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center py-6 px-4 lg:px-8 mb-4 bg-bg_dashboard border border-border rounded-2xl gap-6 xl:gap-8">
                <!-- Profile Section -->
                <div class="flex w-full xl:w-fit items-center p-3 gap-3 lg:gap-4 rounded-full border border-border bg-white shadow-sm">
                    <div class="relative flex-shrink-0">
                        <img id="profilePicture"
                            src="{{ asset('images/default-profile.png') }}"
                            alt="Profile Picture"
                            class="w-10 h-10 lg:w-14 lg:h-14 xl:w-20 xl:h-20 2xl:w-24 2xl:h-24 object-cover rounded-full border-2 border-gray-100">
                        <div id="profileOverlay"
                            class="absolute inset-0 hidden items-center justify-center bg-gray-800 bg-opacity-70 rounded-full">
                            <span class="text-white text-center font-medium text-xs lg:text-sm px-2">Tidak ada foto</span>
                        </div>
                    </div>
                    <div class="font-medium text-black min-w-0 flex-1 xl:w-64 2xl:w-80">
                        <p id="asesorName" class="text-lg lg:text-xl xl:text-2xl font-semibold truncate">Nama Asesor</p>
                        <div id="asesorEmail" class="text-sm lg:text-base font-light text-font_desc truncate mt-1">Email Asesor</div>
                    </div>
                </div>

                <!-- Statistics Section -->
                <div class="flex flex-wrap lg:flex-nowrap gap-3 lg:gap-4 xl:gap-6 w-full xl:w-auto justify-center xl:justify-end">
                    <!-- Kompetensi Teknis Card -->
                    <div class="flex w-20 lg:w-24 xl:w-24 2xl:w-32 items-center justify-center p-3 lg:p-4 rounded-2xl border border-border bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-center">
                            <p id="jumlahKompetensiTeknis" class="text-2xl lg:text-3xl xl:text-4xl font-bold text-gray-800 mb-1">0</p>
                            <p class="text-xs lg:text-sm font-medium text-gray-600 leading-tight">Kompetensi<br>Teknis</p>
                        </div>
                    </div>

                    <!-- Asesi Card -->
                    <div class="flex w-20 lg:w-24 xl:w-24 2xl:w-32 items-center justify-center p-3 lg:p-4 rounded-2xl border border-border bg-gradient-to-br from-white to-purple-50 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-center">
                            <p id="jumlahAsesi" class="text-2xl lg:text-3xl xl:text-4xl font-bold text-purple-700 mb-1">0</p>
                            <p class="text-xs lg:text-sm font-medium text-purple-600">Asesi</p>
                        </div>
                    </div>

                    <!-- Event Card -->
                    <div class="flex w-20 lg:w-24 xl:w-24 2xl:w-32 items-center justify-center p-3 lg:p-4 rounded-2xl border border-border bg-gradient-to-br from-white to-blue-50 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-center">
                            <p id="jumlahEvent" class="text-2xl lg:text-3xl xl:text-4xl font-bold text-blue-700 mb-1">0</p>
                            <p class="text-xs lg:text-sm font-medium text-blue-600">Event</p>
                        </div>
                    </div>

                    <!-- Skema Card -->
                    <div class="flex w-20 lg:w-24 xl:w-24 2xl:w-32 items-center justify-center p-3 lg:p-4 rounded-2xl border border-border bg-gradient-to-br from-white to-indigo-50 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="text-center">
                            <p id="jumlahSkema" class="text-2xl lg:text-3xl xl:text-4xl font-bold text-indigo-700 mb-1">0</p>
                            <p class="text-xs lg:text-sm font-medium text-indigo-600">Skema</p>
                        </div>
                    </div>
                </div>
            </div>
            <p class="pt-4 pb-3 text-lg font-medium text-black">Informasi</p>
            <div class="flex w-80 gap-3 p-4 items-center rounded-2xl bg-white border border-border">
                <svg class="w-16 h-16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="url(#icon-gradient)">
                  <defs>
                    <linearGradient id="icon-gradient" x1="0" y1="0" x2="1" y2="0">
                      <stop offset="0%" stop-color="#3B82F6" />
                      <stop offset="100%" stop-color="#8B5CF6" />
                    </linearGradient>
                  </defs>
                  <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd" />
                </svg>

                <div class="font-medium">
                  <p class="text-2xl text-black">Pedoman</p>
                  <div class="text-sm font-light text-font_desc">Tata cara dan flow sertifikasi</div>
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="hidden w-full py-8">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800" id="errorTitle">Gagal memuat data</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p id="errorMessage">Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.</p>
                        </div>
                        <div class="mt-4">
                            <button type="button" onclick="location.reload()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Coba Lagi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[80%] rounded-full bg-biru opacity-10 blur-[80px]">
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

    // Function to show loading state
    function showLoadingState() {
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('contentState').classList.add('hidden');
        document.getElementById('errorState').classList.add('hidden');
    }

    // Function to show content state
    function showContentState() {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('contentState').classList.remove('hidden');
        document.getElementById('errorState').classList.add('hidden');
    }

    // Function to show error state
    function showErrorState(title, message) {
        document.getElementById('loadingState').classList.add('hidden');
        document.getElementById('contentState').classList.add('hidden');
        document.getElementById('errorState').classList.remove('hidden');

        document.getElementById('errorTitle').textContent = title || 'Gagal memuat data';
        document.getElementById('errorMessage').textContent = message || 'Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.';
    }

    // Function to setup profile picture
    function setupProfilePicture(biodataAsesor) {
        const profilePictureElement = document.getElementById('profilePicture');
        const profileOverlay = document.getElementById('profileOverlay');

        // Reset overlay first
        profileOverlay.classList.add('hidden');
        profileOverlay.classList.remove('flex');

        // Check if foto_asesor_url exists and is valid
        if (biodataAsesor.foto_asesor_url &&
            biodataAsesor.foto_asesor_url !== '/storage/data_asesor' &&
            biodataAsesor.foto_asesor_url !== '/storage/data_asesor/') {

            // Set the photo URL with full domain
            const fullPhotoUrl = "{{ url('') }}" + biodataAsesor.foto_asesor_url;
            profilePictureElement.src = fullPhotoUrl;

            // Add error handler if image fails to load
            profilePictureElement.onerror = function() {
                showNoPhotoOverlay();
            };

            // Add load handler to confirm image loaded successfully
            profilePictureElement.onload = function() {
                // Silent success for security
            };
        } else {
            showNoPhotoOverlay();
        }

        function showNoPhotoOverlay() {
            // Use default image
            profilePictureElement.src = '{{ asset("images/default-profile.png") }}';

            // Show overlay with "No photo" text
            profileOverlay.classList.remove('hidden');
            profileOverlay.classList.add('flex');
        }
    }

    // Show loading state initially
    showLoadingState();

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        showErrorState('Konfigurasi Tidak Ditemukan', 'Konfigurasi API URL tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.key) {
        showErrorState('Konfigurasi Tidak Ditemukan', 'Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        return;
    }

    if (!apiConfig.asesorId) {
        showErrorState('User Tidak Teridentifikasi', 'ID Asesor tidak ditemukan. Silakan login kembali.');
        return;
    }

    // Build API URLs dynamically
    const dashboardApiUrl = `${apiConfig.url}/asesor/dashboard/${apiConfig.asesorId}`;
    const biodataApiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;

    // API Headers configuration
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // Load dashboard data and biodata in parallel
    async function loadAsesorData() {
        try {
            // Fetch both APIs in parallel
            const [dashboardResponse, biodataResponse] = await Promise.all([
                fetch(dashboardApiUrl, {
                    method: 'GET',
                    headers: apiHeaders
                }),
                fetch(biodataApiUrl, {
                    method: 'GET',
                    headers: apiHeaders
                })
            ]);

            // Check if both responses are OK
            if (!dashboardResponse.ok) {
                throw new Error(`Dashboard API error! status: ${dashboardResponse.status}`);
            }

            if (!biodataResponse.ok) {
                throw new Error(`Biodata API error! status: ${biodataResponse.status}`);
            }

            // Parse both responses
            const [dashboardResult, biodataResult] = await Promise.all([
                dashboardResponse.json(),
                biodataResponse.json()
            ]);

            // Check if both APIs returned success
            if (!dashboardResult.success || !dashboardResult.data) {
                throw new Error('Dashboard API returned error: ' + (dashboardResult.message || 'Unknown error'));
            }

            if (!biodataResult.success || !biodataResult.data) {
                throw new Error('Biodata API returned error: ' + (biodataResult.message || 'Unknown error'));
            }

            // Update dashboard information
            const dashboardData = dashboardResult.data;
            document.getElementById('asesorName').textContent = dashboardData.nama_asesor || 'Nama tidak tersedia';
            document.getElementById('asesorEmail').textContent = dashboardData.email_asesor || 'Email tidak tersedia';

            // Update statistics counters
            document.getElementById('jumlahKompetensiTeknis').textContent = dashboardData.jumlah_kompetensi_teknis || '0';
            document.getElementById('jumlahAsesi').textContent = dashboardData.jumlah_asesi || '0';
            document.getElementById('jumlahEvent').textContent = dashboardData.jumlah_event || '0';
            document.getElementById('jumlahSkema').textContent = dashboardData.jumlah_skema || '0';

            // Setup profile picture from biodata
            const biodataAsesor = biodataResult.data;
            setupProfilePicture(biodataAsesor);

            // Show content after all data is loaded
            showContentState();

        } catch (error) {
            showErrorState('Terjadi Kesalahan', 'Error: ' + (error.message || 'Unknown error'));
        }
    }

    // Start loading data
    loadAsesorData();
});
</script>
@endsection
