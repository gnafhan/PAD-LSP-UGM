@extends('home.home-asesor.layouts.layout')

@section('title', 'Kompetensi - Asesor')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mb-4 ms-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" fill="none" class="w-8 h-8">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                    <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
                </linearGradient>
                <clipPath id="clip0">
                    <rect width="14" height="14" fill="white" transform="translate(0.214844 0.5)" />
                </clipPath>
            </defs>
            <g clip-path="url(#clip0)">
                <path d="M11.0079 3.41699H11.709C12.4096 3.41699 12.7596 3.41699 12.9428 3.63691C13.1254 3.85741 13.0495 4.18758 12.8973 4.84849L12.6698 5.84016C12.3262 7.32999 11.072 8.43833 9.54954 8.66699M3.42454 3.41699H2.72337C2.02279 3.41699 1.6722 3.41699 1.48962 3.63691C1.30704 3.85741 1.38287 4.18758 1.53512 4.84849L1.76262 5.84016C2.1062 7.32999 3.36037 8.43833 4.88287 8.66699M7.2162 10.417C6.2397 10.417 5.39037 11.1549 4.9517 12.2434C4.7417 12.7637 5.0427 13.3337 5.4417 13.3337H8.99012C9.3897 13.3337 9.69012 12.7637 9.4807 12.2434C9.04204 11.1549 8.1927 10.417 7.2162 10.417Z"
                stroke="url(#icon-gradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                <path d="M7.21719 10.417C8.97885 10.417 10.4634 7.69749 10.9097 3.99449C11.0328 2.97133 11.0946 2.45916 10.7679 2.06308C10.4413 1.66699 9.91335 1.66699 8.8581 1.66699H5.57627C4.52044 1.66699 3.9931 1.66699 3.66644 2.06308C3.33977 2.45916 3.40219 2.97133 3.52469 3.99508C3.97094 7.69749 5.45552 10.417 7.21719 10.417Z"
                stroke="url(#icon-gradient)" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
            </g>
        </svg>

        <span class="ms-2 text-xl font-bold text-black">Kompetensi Teknis Asesor</span>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>

    <div id="frameKompetensiAsesor" class="relative z-10 p-8 border border-border bg-white rounded-2xl">
        <!-- Loading State Indicator -->
        <div id="loadingState" class="w-full flex flex-col items-center justify-center py-8 mb-6">
            <div class="flex items-center space-x-3 mb-4">
                <svg class="animate-spin h-8 w-8 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-medium text-gray-700">Memuat data kompetensi teknis...</span>
            </div>
            <div class="text-sm text-gray-500 text-center max-w-md">
                Sistem sedang mengambil informasi kompetensi teknis asesor dari server. Mohon tunggu sebentar.
            </div>
        </div>

        <!-- Content Section (initially hidden) -->
        <div id="contentState" class="hidden">
            <p class="mb-4 text-lg font-medium text-black">Kompetensi Teknis Asesor</p>
            <div class="grid grid-cols-7 divide-x-2 divide-dashed gap-6 justify-center px-4 mb-4 bg-white border border-border rounded-md">
                <div class="flex col-span-3 items-center p-3 gap-2 rounded-full bg-white">
                    <img id="profilePicture" src="{{ asset('images/ronaldo.png') }}" alt="Profile Picture" class="w-40 h-40 object-cover rounded-full">
                    <div class="flex-col gap-2 pe-2">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                            </svg>
                            <p id="asesorName" class="font-medium text-black">Nama Asesor</p>
                        </div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                            </svg>
                            <p id="nomorMET" class="font-medium text-font_abu">No. MET Asesor</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                            </svg>
                            <p class="font-medium text-font_abu">Jumlah Skema: </p>
                            <span id="jumlahSkema" class="font-medium text-font_abu">0</span>
                        </div>
                    </div>
                </div>
                <div class="flex col-span-2 items-center justify-center my-6 bg-white">
                    <div class="px-2 font-medium text-black justify-items-center items-center">
                        <a id="sertifikatLink" href="#" target="_blank" class="flex flex-col items-center hover:text-biru transition-colors">
                            <svg class="w-16 h-16 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z" clip-rule="evenodd"/>
                            </svg>
                            <p class="font-normal text-center">Lihat Sertifikat BNSP Kompeten</p>
                        </a>
                    </div>
                </div>
                <div class="flex col-span-2 items-center justify-center my-6 bg-white">
                    <div class="px-2 font-medium text-black justify-items-center items-center">
                        <div id="statusAsesor" class="bg-hijau_muda text-font_hijau p-2 rounded-md">
                            <p class="font-bold">Status</p>
                        </div>

                        <p class="font-normal text-center text-font_desc">Hingga</p>
                        <p id="masaBerlaku" class="font-semibold text-md text-center text-font_desc">-</p>
                    </div>
                </div>
            </div>

            <p class="mb-4 text-lg font-medium text-black">Daftar Kompetensi Teknis Asesor</p>
            <div class="overflow-x-auto shadow-md rounded-lg">
                <table id="kompetensi-table" class="min-w-full bg-white overflow-hidden">
                    <thead class="bg-bg_dashboard text-center">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Lembaga Sertifikasi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Sertifikasi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">File Sertifikat</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Masa Berlaku</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Status</th>
                        </tr>
                    </thead>
                    <tbody id="kompetensi-tbody" class="divide-y divide-gray-200 text-black text-center">
                        <!-- Konten tabel akan diisi oleh JavaScript -->
                    </tbody>
                </table>
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
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<style>
.fade-in {
    animation: fadeIn 0.5s ease-in-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Pulse animation for loading indicator */
.pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
        const apiConfig = {
            url: @json(config('services.api.url')),
            key: @json(config('services.api.key')),
            asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
            csrfToken: @json(csrf_token())
        };

        // Function to manage UI states
        function showLoadingState() {
            document.getElementById('loadingState').classList.remove('hidden');
            document.getElementById('contentState').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');
        }

        function showContentState() {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('contentState').classList.remove('hidden');
            document.getElementById('contentState').classList.add('fade-in');
            document.getElementById('errorState').classList.add('hidden');
        }

        function showErrorState(title, message) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('contentState').classList.add('hidden');
            document.getElementById('errorState').classList.remove('hidden');
            document.getElementById('errorState').classList.add('fade-in');

            document.getElementById('errorTitle').textContent = title || 'Gagal memuat data';
            document.getElementById('errorMessage').textContent = message || 'Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.';
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

        // Build API URL dynamically
        const apiUrl = `${apiConfig.url}/asesor/kompetensi_teknis/${apiConfig.asesorId}`;

        // Headers configuration
        const headers = {
            'Content-Type': 'application/json',
            'API-KEY': apiConfig.key,
            'Accept': 'application/json',
            'X-CSRF-TOKEN': apiConfig.csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };

        // Function untuk menangani foto profil
        function setupProfilePicture(asesorData) {
            const profilePictureElement = document.getElementById('profilePicture');
            const defaultImage = '{{ asset('images/default-profile.png') }}';
            const imageContainer = profilePictureElement.parentElement;

            // Reset kelas dan konten sebelumnya
            imageContainer.classList.remove('relative');
            const existingOverlay = imageContainer.querySelector('.profile-overlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            // Cek apakah URL foto valid
            if (asesorData.file_url_foto_asesor &&
                asesorData.file_url_foto_asesor !== '/storage/data_asesor' &&
                asesorData.file_url_foto_asesor !== '/storage/data_asesor/') {

                profilePictureElement.src = asesorData.file_url_foto_asesor;

                // Tambahkan error handler jika gambar gagal dimuat
                profilePictureElement.onerror = function() {
                    showNoPhotoOverlay(profilePictureElement, imageContainer);
                };
            } else {
                showNoPhotoOverlay(profilePictureElement, imageContainer);
            }
        }

        // Function untuk menampilkan overlay "Tidak ada foto"
        function showNoPhotoOverlay(imgElement, container) {
            // Gunakan gambar default
            imgElement.src = '{{ asset('images/default-profile.png') }}';

            // Tambahkan overlay dengan teks
            container.classList.add('relative');
            const overlay = document.createElement('div');
            overlay.className = 'profile-overlay absolute inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 rounded-full';
            overlay.innerHTML = '<span class="text-white text-center font-medium px-2">Tidak ada foto</span>';
            container.appendChild(overlay);
        }

        // Make API request
        fetch(apiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.success && result.data) {
                const asesorData = result.data.asesor;
                const kompetensiData = result.data.kompetensi_teknis;

                // Update asesor information
                document.getElementById('profilePicture').src = asesorData.file_url_foto_asesor || '{{ asset('images/ronaldo.png') }}';
                document.getElementById('asesorName').textContent = asesorData.nama_asesor || 'Nama tidak tersedia';
                document.getElementById('nomorMET').textContent = asesorData.no_met || 'Nomor tidak tersedia';
                document.getElementById('jumlahSkema').textContent = asesorData.jumlah_skema || '0';
                document.getElementById('masaBerlaku').textContent = asesorData.masa_berlaku || 'Tidak tersedia';

                // Update status with color
                const statusElement = document.getElementById('statusAsesor');
                const status = asesorData.status_asesor || '';
                statusElement.querySelector('p').textContent = status.toUpperCase();

                if (status.toLowerCase() === 'aktif') {
                    statusElement.className = 'bg-hijau_muda text-font_hijau p-2 rounded-md';
                } else if (status.toLowerCase() === 'nonaktif') {
                    statusElement.className = 'bg-red-100 text-red-700 p-2 rounded-md';
                } else {
                    statusElement.className = 'bg-gray-100 text-gray-700 p-2 rounded-md';
                }

                // Set sertifikat link if available
                const sertifikatLink = document.getElementById('sertifikatLink');
                if (asesorData.file_url_sertifikat_bnsp) {
                    sertifikatLink.href = asesorData.file_url_sertifikat_bnsp;
                } else {
                    sertifikatLink.href = "#";
                    sertifikatLink.classList.add('cursor-not-allowed', 'opacity-50');
                    sertifikatLink.querySelector('p').textContent = 'Sertifikat tidak tersedia';
                }

                // Update kompetensi table
                const tableBody = document.getElementById('kompetensi-tbody');

                if (kompetensiData && kompetensiData.length > 0) {
                    let tableContent = '';

                    kompetensiData.forEach((item, index) => {
                        tableContent += `
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                                <td class="px-4 py-3">${item.lembaga_sertifikasi || '-'}</td>
                                <td class="px-4 py-3">${item.skema_kompetensi || '-'}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center items-center h-full">
                                        ${item.file_url ? `
                                            <a href="${item.file_url}" target="_blank" class="text-biru hover:text-blue-700">
                                                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                        ` : `
                                            <svg class="w-6 h-6 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd" />
                                            </svg>
                                        `}
                                    </div>
                                </td>
                                <td class="px-4 py-3">${item.masa_berlaku || '-'}</td>
                                <td class="px-4 py-3">
                                    <span class="${getStatusColor(item.masa_berlaku)}">
                                        ${isExpired(item.masa_berlaku) ? 'Expired' : 'Aktif'}
                                    </span>
                                </td>
                            </tr>
                        `;
                    });

                    tableBody.innerHTML = tableContent;
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data kompetensi teknis yang tersedia</td>
                        </tr>
                    `;
                }

                // Setup profile picture
                setupProfilePicture(asesorData);

                // Show content after data is loaded
                showContentState();
            } else {
                showErrorState('Data Tidak Tersedia', result.message || 'Format respons tidak sesuai');
            }
        })
        .catch(error => {
            showErrorState('Terjadi Kesalahan', 'Error: ' + (error.message || 'Unknown error'));
        });

        // Helper function to check if a date is expired
        function isExpired(dateString) {
            if (!dateString) return false;

            try {
                // Parse date in format dd-mm-yyyy
                const parts = dateString.split('-');
                if (parts.length !== 3) return false;

                const day = parseInt(parts[0], 10);
                const month = parseInt(parts[1], 10) - 1; // JS months are 0-indexed
                const year = parseInt(parts[2], 10);

                const expiryDate = new Date(year, month, day);
                const today = new Date();

                return expiryDate < today;
            } catch (e) {
                return false;
            }
        }

        // Helper function to get status color based on expiry
        function getStatusColor(dateString) {
            return isExpired(dateString) ? 'text-red-600' : 'text-green-600';
        }
    });
</script>
@endsection
