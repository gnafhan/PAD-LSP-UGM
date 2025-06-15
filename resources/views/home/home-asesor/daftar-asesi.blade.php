@extends('home.home-asesor.layouts.layout')

@section('title', 'Daftar Asesi - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <!-- icon gradasi -->
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        </svg>
        <p class="ms-2 text-xl font-bold text-black">Daftar Asesi</p>
    </div>
    <div id="breadcrumbs" class="hidden pb-4 px-6">
        <!-- Breadcrumb -->
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
                        <a href="{{ route('daftar-asesi') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            Daftar Asesi
                        </a>
                    </div>
                </li>
                <!-- Memanggil data nama asesi -->
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span id="breadcrumbAsesiName" class="ms-1 text-sm font-medium text-black">Memuat...</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="errorText">Terjadi kesalahan saat memuat data.</span>
    </div>

    <div id="frameDaftarAsesi" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Daftar Asesi yang Diasesori</p>
        <!-- Search Form -->
        <form id="searchDaftarAsesi" class="max-w-md mb-4 rounded-xl">
            <div class="relative">
            <input type="search" id="search-asesi" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table id="daftarAsesi" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Progress</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Memuat data asesi...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="detailAsesi" class="hidden p-4 text-black">
            <p id="namaAsesi" class="mb-4 text-3xl font-medium text-black">Memuat...</p>
            <p id="skemaAsesi" class="mb-4 text-lg font-medium text-black">Memuat...</p>

            <!-- Search Form -->
            <form  id="searchDetailAsesi" class="max-w-md mb-4 rounded-xl">
                <div class="relative">
                    <input type="search" id="detail-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Nama Peserta" required />
                    <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Tabel Pelaksanaan Asesmen -->
            <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                <table id="pelaksanaanAsesmen" class="min-w-full bg-white overflow-hidden">
                    <thead class="bg-bg_dashboard text-center">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0, 'pelaksanaanAsesmen')">No</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1, 'pelaksanaanAsesmen')">Aksi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2, 'pelaksanaanAsesmen')">Pelaksaan Asesmen</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3, 'pelaksanaanAsesmen')">Tanggal Asesi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4, 'pelaksanaanAsesmen')">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-black text-center">
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Memuat data pelaksanaan asesmen...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Perangkat Asesmen -->
            <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                <table id="perangkatAsesmen" class="min-w-full bg-white overflow-hidden">
                    <thead class="bg-bg_dashboard text-center">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0, 'perangkatAsesmen')">No</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1, 'perangkatAsesmen')">Aksi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2, 'perangkatAsesmen')">Perangkat Asesmen</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3, 'perangkatAsesmen')">Tanggal Asesi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4, 'perangkatAsesmen')">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-black text-center">
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Memuat data perangkat asesmen...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Keputusan Asesmen -->
            <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                <table id="keputusanAsesmen" class="min-w-full bg-white overflow-hidden">
                    <thead class="bg-bg_dashboard text-center">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0, 'keputusanAsesmen')">No</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1, 'keputusanAsesmen')">Aksi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2, 'keputusanAsesmen')">Keputusan</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3, 'keputusanAsesmen')">Tanggal Asesi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4, 'keputusanAsesmen')">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-black text-center">
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Memuat data keputusan asesmen...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex border-border">
                <div class="flex w-3/4 items-center justify-end h-16">
                    <p id="totalSteps" class="font-bold text-lg text-sidebar_font">Total Langkah: 0</p>
                </div>
                <div class="flex items-center justify-center w-1/4 h-16">
                    <p id="totalProgress" class="font-bold text-3xl text-sidebar_font">0%</p>
                </div>
            </div>
        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const apiKey = "{{ env('API_KEY') }}";

    // Get asesor ID dynamically from the authenticated user with proper error handling
    const asesorId = @json(Auth::user()->asesor->id_asesor ?? 'ASESOR202500005');

    // Stop execution if no asesor ID is found
    if (!asesorId) {
        console.error('No asesor ID found for the authenticated user');
        document.querySelector('#daftarAsesi tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">User tidak teridentifikasi, silahkan login kembali</td>
            </tr>
        `;
        return;
    }

    // Construct API URL with the asesor ID
    const apiUrl = "{{ url('/api/v1/asesor/asesis') }}/" + asesorId;

    // Debug output
    console.log('Fetching data for asesor ID:', asesorId);
    console.log('API URL:', apiUrl);

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Make API request
    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'API-KEY': apiKey,
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken || '',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        console.log('API Response:', result);

        if (result.success && result.data) {
            const asesisData = result.data.asesis;
            const jumlahAsesi = result.data.jumlah_asesi;

            // Update the table with asesi data
            const tableBody = document.querySelector('#daftarAsesi tbody');

            if (asesisData && asesisData.length > 0) {
                let tableContent = '';

                asesisData.forEach((asesi, index) => {
                    // Calculate progress percentage for display
                    const progressPercent = asesi.progress_percentage || 0;

                    tableContent += `
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                            <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_asesi || '-'}</td>
                            <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_skema || '-'}</td>
                            <td class="px-4 py-3 text-gray-700 text-left">${asesi.nomor_skema || '-'}</td>
                            <td class="flex px-4 py-3 justify-items-center align-middle">
                                <div class="bg-white rounded-[4px] mx-auto border-2 border-hijau w-16 h-fit relative">
                                    <div class="bg-hijau_muda text-xs font-medium text-hijau text-center p-0.5 leading-none rounded-sm z-10" style="width: ${progressPercent}%">${progressPercent}%</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button onclick="showSummary('${asesi.id_asesi}', '${asesi.nama_asesi}', '${asesi.nama_skema}', ${asesi.progress_percentage}, ${asesi.completed_steps}, ${asesi.total_steps})" class="text-biru hover:text-ungu">
                                    <svg class="w-6 h-6 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                tableBody.innerHTML = tableContent;
            } else {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi yang tersedia</td>
                    </tr>
                `;
            }

            // Implementasi pencarian
            const searchInput = document.getElementById('search-asesi');
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#daftarAsesi tbody tr');

                rows.forEach(row => {
                    const nama = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                    const skema = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                    const kode = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';

                    if (nama.includes(searchValue) || skema.includes(searchValue) || kode.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

        } else {
            console.error('API returned success=false or missing data:', result);
            document.querySelector('#daftarAsesi tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        document.querySelector('#daftarAsesi tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
            </tr>
        `;
    });

    // Implementasi pencarian di detail
    const detailSearchInput = document.getElementById('detail-search');
    if (detailSearchInput) {
        detailSearchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();

            // Search in all three tables
            searchDetailTable('pelaksanaanAsesmen', searchValue);
            searchDetailTable('perangkatAsesmen', searchValue);
            searchDetailTable('keputusanAsesmen', searchValue);
        });
    }
});

// Function to search in a specific detail table
function searchDetailTable(tableId, searchValue) {
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);

    rows.forEach(row => {
        if (row.cells.length <= 1) return; // Skip placeholder rows

        const name = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
        const date = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';

        if (name.includes(searchValue) || date.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Function to show asesi details and fetch progress data
function showSummary(asesiId, asesiName, skemaName, progressPercentage, completedSteps, totalSteps) {
    // Show loading indicator
    document.getElementById('loadingIndicator').classList.remove('hidden');

    // Sembunyikan elemen judul halaman
    document.getElementById('titlePage').classList.add('hidden');

    // Sembunyikan elemen pencarian utama
    document.getElementById('searchDaftarAsesi').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarAsesi').parentElement.classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Update breadcrumb with asesi name
    document.getElementById('breadcrumbAsesiName').textContent = asesiName || 'Detail Asesi';

    // Update detail section with asesi name and skema
    document.getElementById('namaAsesi').textContent = asesiName || 'Nama Asesi';
    document.getElementById('skemaAsesi').textContent = skemaName || 'Skema Sertifikasi';

    // Update progress information
    document.getElementById('totalSteps').textContent = `Total Langkah: ${totalSteps || 0}`;
    document.getElementById('totalProgress').textContent = `${progressPercentage || 0}%`;

    // Fetch detailed progress data for this asesi
    fetchAsesiProgressData(asesiId);
}

// Function to fetch asesi progress data
function fetchAsesiProgressData(asesiId) {
    if (!asesiId) {
        showError('ID Asesi tidak valid');
        return;
    }

    const apiKey = "{{ env('API_KEY') }}";
    const apiUrl = `{{ url('/api/v1/asesor/progressAsesi') }}/${asesiId}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(apiUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'API-KEY': apiKey,
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken || '',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        console.log('Progress API Response:', result);

        // Hide loading indicator
        document.getElementById('loadingIndicator').classList.add('hidden');

        if (result.success && result.data) {
            // Populate the tables with the progress data
            populateProgressTables(result.data);

            // Show the detail asesi section
            document.getElementById('detailAsesi').classList.remove('hidden');

            // Scroll to the detail section
            document.getElementById('detailAsesi').scrollIntoView({ behavior: 'smooth' });
        } else {
            showError('Gagal memuat data progress: ' + (result.message || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error fetching progress data:', error);

        // Hide loading indicator
        document.getElementById('loadingIndicator').classList.add('hidden');

        // Show error message
        showError('Error memuat data progress: ' + error.message);

        // Still show the detail section with basic info
        document.getElementById('detailAsesi').classList.remove('hidden');
    });
}

// Function to populate progress tables
function populateProgressTables(progressData) {
    // Populate Pelaksanaan Asesmen table
    if (progressData.pelaksanaan && progressData.pelaksanaan.length > 0) {
        populateTable('pelaksanaanAsesmen', progressData.pelaksanaan);
    } else {
        document.querySelector('#pelaksanaanAsesmen tbody').innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data pelaksanaan asesmen</td>
            </tr>
        `;
    }

    // Populate Perangkat Asesmen table
    if (progressData.perangkat && progressData.perangkat.length > 0) {
        populateTable('perangkatAsesmen', progressData.perangkat);
    } else {
        document.querySelector('#perangkatAsesmen tbody').innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data perangkat asesmen</td>
            </tr>
        `;
    }

    // Populate Keputusan Asesmen table
    if (progressData.keputusan && progressData.keputusan.length > 0) {
        populateTable('keputusanAsesmen', progressData.keputusan);
    } else {
        document.querySelector('#keputusanAsesmen tbody').innerHTML = `
            <tr>
                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data keputusan asesmen</td>
            </tr>
        `;
    }

    // Update overall progress if available
    if (progressData.overall) {
        document.getElementById('totalSteps').textContent = `Total Langkah: ${progressData.overall.total_steps || 0}`;
        document.getElementById('totalProgress').textContent = `${progressData.overall.progress_percentage || 0}%`;
    }
}

// Function to populate a specific table with data
function populateTable(tableId, items) {
    const tableBody = document.querySelector(`#${tableId} tbody`);
    let tableContent = '';

    items.forEach((item, index) => {
        // Format date if available
        const formattedDate = item.tanggal ? formatDate(item.tanggal) : '-';

        // Calculate progress percentage
        const progressPercent = item.progress_percentage || 0;

        // Determine detail URL based on item type and item_id
        const detailUrl = getDetailUrl(tableId, item.id);

        tableContent += `
            <tr>
                <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                <td class="px-4 py-3 text-center">
                    <a href="${detailUrl}" class="text-biru hover:text-ungu">
                        <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v3H8a1 1 0 1 0 0 2h3v3a1 1 0 1 0 2 0v-3h3a1 1 0 1 0 0-2h-3V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </td>
                <td class="px-4 py-3 text-gray-700 text-left">${item.nama || '-'}</td>
                <td class="px-4 py-3 text-gray-700 text-center">${formattedDate}</td>
                <td class="flex px-4 py-3 justify-items-center align-middle">
                    <div class="bg-white rounded-[4px] mx-auto border-2 border-hijau w-16 h-fit relative">
                        <div class="bg-hijau_muda text-xs font-medium text-hijau text-center p-0.5 leading-none rounded-sm z-10" style="width: ${progressPercent}%">${progressPercent}%</div>
                    </div>
                </td>
            </tr>
        `;
    });

    tableBody.innerHTML = tableContent;
}

// Function to get detail URL based on table and item ID
function getDetailUrl(tableId, itemId) {
    if (!itemId) return '#';

    // Determine which route to use based on the table ID
    switch(tableId) {
        case 'pelaksanaanAsesmen':
            return `{{ url('/asesor/pelaksanaan-asesmen') }}/${itemId}`;
        case 'perangkatAsesmen':
            return `{{ url('/asesor/perangkat-asesmen') }}/${itemId}`;
        case 'keputusanAsesmen':
            return `{{ url('/asesor/keputusan-asesmen') }}/${itemId}`;
        default:
            return '#';
    }
}

// Format date function (e.g., "2025-06-15" to "15 Juni 2025")
function formatDate(dateString) {
    if (!dateString) return '-';

    try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString; // Return original if invalid

        // Indonesian month names
        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    } catch (e) {
        console.error('Error formatting date:', e);
        return dateString; // Return original on error
    }
}

// Function to show error message
function showError(message) {
    document.getElementById('errorMessage').classList.remove('hidden');
    document.getElementById('errorText').textContent = message;

    // Hide loading indicator if it's visible
    document.getElementById('loadingIndicator').classList.add('hidden');
}

// Table sorting function for all tables
function sortTable(columnIndex, tableId = null) {
    // Determine which table to sort
    const table = tableId ? document.getElementById(tableId) :
                 document.getElementById('detailAsesi').classList.contains('hidden') ?
                 document.getElementById('daftarAsesi') :
                 document.activeElement.closest('table');

    if (!table) return;

    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    // Skip sorting if there's only one row or error message row
    if (rows.length <= 1 || rows[0].cells.length === 1) return;

    let sortDirection = table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
    let lastSortedColumn = parseInt(table.getAttribute('data-sort-col') || '0');

    // Reset direction if clicking on a different column
    if (lastSortedColumn !== columnIndex) {
        sortDirection = 'asc';
    }

    // Store current sort state
    table.setAttribute('data-sort-dir', sortDirection);
    table.setAttribute('data-sort-col', columnIndex);

    // Sort the rows
    rows.sort((a, b) => {
        if (!a.cells[columnIndex] || !b.cells[columnIndex]) return 0;

        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();

        // Handle numeric sorting for the index column
        if (columnIndex === 0) {
            return sortDirection === 'asc'
                ? parseInt(aValue) - parseInt(bValue)
                : parseInt(bValue) - parseInt(aValue);
        }

        // Default string comparison
        return sortDirection === 'asc'
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
    });

    // Re-append rows in the sorted order
    rows.forEach(row => tbody.appendChild(row));

    // Update header visuals to indicate sort direction
    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        // Remove any existing indicators
        header.textContent = header.textContent.replace(' ↑', '').replace(' ↓', '');

        if (index === columnIndex) {
            header.textContent += sortDirection === 'asc' ? ' ↑' : ' ↓';
        }
    });
}
</script>

@endsection
