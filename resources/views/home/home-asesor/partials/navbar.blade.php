<!-- Navbar Starts -->
<nav class="fixed top-0 z-40 w-full bg-white shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
              <span class="sr-only">Open sidebar</span>
              <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                 <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
              </svg>
           </button>
        </div>
        <div class="flex items-center ms-3">
            <!-- Loading State -->
            <div id="navbarLoadingState" class="flex justify-end items-center gap-4">
                <div class="font-medium text-right">
                    <div class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <div class="text-blue-500 text-sm">Memuat profil...</div>
                    </div>
                </div>
                <!-- Loading Profile Icon -->
                <div class="relative">
                    <div class="w-12 h-12 rounded-full bg-gray-200 animate-pulse flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content State (hidden initially) -->
            <div id="navbarContentState" class="hidden">
                <div id="avatarButton" class="flex justify-end items-center gap-4 cursor-pointer">
                    <div class="font-medium text-right">
                        <div id="nama_asesor" class="text-blue-500 text-xl">Nama Asesor</div>
                        <div id="email_asesor" class="text-sm font-extralight text-blue-500">Email Asesor</div>
                    </div>
                    <!-- Profile Picture Container -->
                    <div class="relative">
                        <!-- Default SVG Icon (hidden when photo loads) -->
                        <svg id="defaultProfileIcon" class="w-12 h-12 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                        </svg>
                        <!-- Profile Photo (initially hidden) -->
                        <img id="profilePhoto" src="" alt="Profile Photo" class="hidden w-12 h-12 rounded-full object-cover border-2 border-blue-200">
                    </div>
                </div>
            </div>

            <!-- Error State (hidden initially) -->
            <div id="navbarErrorState" class="hidden">
                <div class="flex justify-end items-center gap-4">
                    <div class="font-medium text-right">
                        <div class="text-red-500 text-sm">Gagal memuat</div>
                        <div class="text-xs text-red-400">Coba refresh halaman</div>
                    </div>
                    <!-- Error Profile Icon -->
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    // Cache keys
    const CACHE_KEYS = {
        DASHBOARD: `asesor_dashboard_${apiConfig.asesorId}`,
        BIODATA: `asesor_biodata_${apiConfig.asesorId}`,
        CACHE_TIMESTAMP: `asesor_cache_timestamp_${apiConfig.asesorId}`
    };

    // Cache expiration time (30 minutes)
    const CACHE_EXPIRATION = 30 * 60 * 1000; // 30 minutes in milliseconds

    // Navbar state elements
    const navbarLoadingState = document.getElementById('navbarLoadingState');
    const navbarContentState = document.getElementById('navbarContentState');
    const navbarErrorState = document.getElementById('navbarErrorState');

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        @if(config('app.debug'))
        console.error('Konfigurasi API URL tidak ditemukan');
        @endif
        showNavbarError();
        return;
    }

    if (!apiConfig.key) {
        @if(config('app.debug'))
        console.error('Konfigurasi API Key tidak ditemukan');
        @endif
        showNavbarError();
        return;
    }

    if (!apiConfig.asesorId) {
        @if(config('app.debug'))
        console.error('Asesor ID tidak ditemukan');
        @endif
        showNavbarError();
        return;
    }

    // Build API URLs dynamically
    const dashboardApiUrl = `${apiConfig.url}/asesor/dashboard/${apiConfig.asesorId}`;
    const biodataApiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;

    // Headers configuration
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // Debug info - only in development
    @if(config('app.debug'))
    console.log('Navbar API Configuration:', {
        asesorId: apiConfig.asesorId,
        dashboardUrl: dashboardApiUrl,
        biodataUrl: biodataApiUrl,
        apiKey: apiConfig.key ? 'Present' : 'Missing',
        csrfToken: apiConfig.csrfToken ? 'Present' : 'Missing'
    });
    @endif

    // Cache management functions
    function isCacheValid() {
        const timestamp = localStorage.getItem(CACHE_KEYS.CACHE_TIMESTAMP);
        if (!timestamp) return false;

        const now = Date.now();
        const cacheTime = parseInt(timestamp);
        return (now - cacheTime) < CACHE_EXPIRATION;
    }

    function setCacheData(dashboardData, biodataData) {
        try {
            localStorage.setItem(CACHE_KEYS.DASHBOARD, JSON.stringify(dashboardData));
            localStorage.setItem(CACHE_KEYS.BIODATA, JSON.stringify(biodataData));
            localStorage.setItem(CACHE_KEYS.CACHE_TIMESTAMP, Date.now().toString());

            @if(config('app.debug'))
            console.log('Data cached successfully');
            @endif
        } catch (error) {
            @if(config('app.debug'))
            console.error('Error caching data:', error);
            @endif
        }
    }

    function getCachedData() {
        try {
            const dashboardData = localStorage.getItem(CACHE_KEYS.DASHBOARD);
            const biodataData = localStorage.getItem(CACHE_KEYS.BIODATA);

            if (dashboardData && biodataData) {
                return {
                    dashboard: JSON.parse(dashboardData),
                    biodata: JSON.parse(biodataData)
                };
            }
            return null;
        } catch (error) {
            @if(config('app.debug'))
            console.error('Error reading cached data:', error);
            @endif
            return null;
        }
    }

    function clearCache() {
        localStorage.removeItem(CACHE_KEYS.DASHBOARD);
        localStorage.removeItem(CACHE_KEYS.BIODATA);
        localStorage.removeItem(CACHE_KEYS.CACHE_TIMESTAMP);

        @if(config('app.debug'))
        console.log('Cache cleared');
        @endif
    }

    // Navbar state management functions
    function showNavbarLoading() {
        navbarLoadingState?.classList.remove('hidden');
        navbarContentState?.classList.add('hidden');
        navbarErrorState?.classList.add('hidden');
    }

    function showNavbarContent() {
        navbarLoadingState?.classList.add('hidden');
        navbarContentState?.classList.remove('hidden');
        navbarErrorState?.classList.add('hidden');
    }

    function showNavbarError() {
        navbarLoadingState?.classList.add('hidden');
        navbarContentState?.classList.add('hidden');
        navbarErrorState?.classList.remove('hidden');
    }

    // Function to update navbar with data
    function updateNavbarContent(dashboardData, biodataData) {
        // Update profile information
        const namaAsesorElement = document.getElementById('nama_asesor');
        const emailAsesorElement = document.getElementById('email_asesor');

        if (namaAsesorElement) {
            namaAsesorElement.textContent = dashboardData.nama_asesor || 'Nama tidak tersedia';
        }

        if (emailAsesorElement) {
            emailAsesorElement.textContent = dashboardData.email_asesor || 'Email tidak tersedia';
        }

        // Setup profile photo
        setupProfilePhoto(biodataData);

        // Show content
        showNavbarContent();
    }

    // Function to setup profile photo with secure error handling
    function setupProfilePhoto(biodataAsesor) {
        const profilePhotoElement = document.getElementById('profilePhoto');
        const defaultIconElement = document.getElementById('defaultProfileIcon');

        if (!profilePhotoElement || !defaultIconElement) {
            return;
        }

        // Check if foto_asesor_url exists and is valid
        if (biodataAsesor?.foto_asesor_url &&
            biodataAsesor.foto_asesor_url !== '/storage/data_asesor' &&
            biodataAsesor.foto_asesor_url !== '/storage/data_asesor/') {

            @if(config('app.debug'))
            console.log('URL foto ditemukan:', biodataAsesor.foto_asesor_url);
            @endif

            const fullPhotoUrl = "{{ url('') }}" + biodataAsesor.foto_asesor_url;
            profilePhotoElement.src = fullPhotoUrl;

            profilePhotoElement.onload = function() {
                @if(config('app.debug'))
                console.log('Foto berhasil dimuat');
                @endif
                defaultIconElement.classList.add('hidden');
                profilePhotoElement.classList.remove('hidden');
            };

            profilePhotoElement.onerror = function() {
                @if(config('app.debug'))
                console.log('Gagal memuat foto, menggunakan icon default');
                @endif
                profilePhotoElement.classList.add('hidden');
                defaultIconElement.classList.remove('hidden');
            };
        } else {
            @if(config('app.debug'))
            console.log('URL foto tidak tersedia atau tidak valid');
            @endif
            profilePhotoElement.classList.add('hidden');
            defaultIconElement.classList.remove('hidden');
        }
    }

    // Check if we have valid cached data first
    function loadAsesorDataFromCacheOrAPI() {
        // Check cache first
        if (isCacheValid()) {
            const cachedData = getCachedData();
            if (cachedData) {
                @if(config('app.debug'))
                console.log('Loading data from cache');
                @endif
                updateNavbarContent(cachedData.dashboard, cachedData.biodata);
                return;
            }
        }

        // If no valid cache, load from API
        @if(config('app.debug'))
        console.log('Loading data from API');
        @endif
        showNavbarLoading();
        loadAsesorDataFromAPI();
    }

    // Load data from API with secure error handling
    async function loadAsesorDataFromAPI() {
        try {
            @if(config('app.debug'))
            console.log('Fetching data for asesor ID:', apiConfig.asesorId);
            @endif

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

            if (!dashboardResponse.ok) {
                throw new Error(`Dashboard API error! status: ${dashboardResponse.status}`);
            }

            if (!biodataResponse.ok) {
                throw new Error(`Biodata API error! status: ${biodataResponse.status}`);
            }

            const [dashboardResult, biodataResult] = await Promise.all([
                dashboardResponse.json(),
                biodataResponse.json()
            ]);

            if (!dashboardResult.success || !dashboardResult.data) {
                throw new Error('Dashboard API returned error: ' + (dashboardResult.message || 'Unknown error'));
            }

            if (!biodataResult.success || !biodataResult.data) {
                throw new Error('Biodata API returned error: ' + (biodataResult.message || 'Unknown error'));
            }

            const dashboardData = dashboardResult.data;
            const biodataData = biodataResult.data;

            // Cache the data
            setCacheData(dashboardData, biodataData);

            // Update navbar
            updateNavbarContent(dashboardData, biodataData);

            @if(config('app.debug'))
            console.log('Navbar data loaded successfully');
            @endif

        } catch (error) {
            @if(config('app.debug'))
            console.error('Error loading asesor data:', error);
            @endif

            showNavbarError();

            // Update error display elements safely
            const namaAsesorElement = document.getElementById('nama_asesor');
            const emailAsesorElement = document.getElementById('email_asesor');

            if (namaAsesorElement) {
                namaAsesorElement.textContent = 'Error memuat data';
            }

            if (emailAsesorElement) {
                emailAsesorElement.textContent = 'Silakan refresh halaman';
            }
        }
    }

    // Global error handlers for production safety
    window.addEventListener('error', function(e) {
        @if(config('app.debug'))
        console.error('Uncaught navbar error:', e.error);
        @endif
    });

    window.addEventListener('unhandledrejection', function(e) {
        @if(config('app.debug'))
        console.error('Unhandled navbar promise rejection:', e.reason);
        @endif
    });

    // Start loading data (cache first, then API if needed)
    loadAsesorDataFromCacheOrAPI();

    // Global function to refresh cache (can be called from other pages)
    window.refreshAsesorCache = function() {
        @if(config('app.debug'))
        console.log('Refreshing asesor cache...');
        @endif
        clearCache();
        showNavbarLoading();
        loadAsesorDataFromAPI();
    };

    // Global function to get cached biodata (can be used by other pages)
    window.getCachedAsesorBiodata = function() {
        if (isCacheValid()) {
            const cachedData = getCachedData();
            return cachedData ? cachedData.biodata : null;
        }
        return null;
    };

    // Debug functions (only available in development)
    @if(config('app.debug'))
    window.debugNavbarAsesor = function() {
        console.log('=== Navbar Asesor Debug Info ===');
        console.log('API Config:', {
            url: apiConfig.url,
            key: 'Present',
            asesorId: apiConfig.asesorId,
            csrfToken: 'Present'
        });
        console.log('Cache Status:', {
            isValid: isCacheValid(),
            keys: CACHE_KEYS,
            expiration: CACHE_EXPIRATION
        });
        console.log('Cached Data:', getCachedData());
        console.log('=== End Debug Info ===');
    };

    window.clearAsesorCache = function() {
        console.log('Manually clearing asesor cache...');
        clearCache();
        loadAsesorDataFromAPI();
    };
    @endif
});
</script>
