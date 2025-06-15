@extends('home.home-asesor.layouts.layout')

@section('title', 'Kompetensi - Asesor')

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
        <p class="mb-4 text-lg font-medium text-black">Kompetensi Teknis Asesor</p>
        <div class="grid grid-cols-7 divide-x-2 divide-dashed gap-6 justify-center px-4 mb-4 bg-white border border-border rounded-md">
            <div class="flex col-span-3 items-center p-3 gap-2 rounded-full bg-white">
                <img id="profilePicture" src="{{ asset('images/ronaldo.png') }}" alt="Profile Picture" class="w-40 h-40 rounded-full">
                <div class="flex-col gap-2 pe-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                        </svg>
                        <p id="asesorName" class="font-medium text-black">Memuat data...</p>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </svg>
                        <p id="nomorMET" class="font-medium text-font_abu">Memuat data...</p>
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
                        <p class="font-bold">Memuat...</p>
                    </div>

                    <p class="font-normal text-center text-font_desc">Hingga</p>
                    <p id="masaBerlaku" class="font-semibold text-md text-center text-font_desc">Memuat...</p>
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
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Memuat data kompetensi...</td>
                    </tr>
                </tbody>
            </table>
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
            document.getElementById('asesorName').textContent = 'User tidak teridentifikasi';
            return;
        }

        // Construct API URL with the asesor ID
        const apiUrl = "{{ url('/api/v1/asesor/kompetensi_teknis') }}/" + asesorId;

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
                'API_KEY': apiKey,
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
                const asesorData = result.data.asesor;
                const kompetensiData = result.data.kompetensi_teknis;

                // Update asesor information
                document.getElementById('asesorName').textContent = asesorData.nama_asesor || 'Nama tidak tersedia';
                document.getElementById('nomorMET').textContent = asesorData.no_sertifikat || 'Nomor tidak tersedia';
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
                if (asesorData.file_sertifikat) {
                    sertifikatLink.href = "{{ asset('storage/sertifikat') }}/" + asesorData.file_sertifikat;
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
                                <td class="px-4 py-3">${item.nama_sertifikasi || '-'}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center items-center h-full">
                                        ${item.file_sertifikat ? `
                                            <a href="{{ asset('storage/kompetensi') }}/${item.file_sertifikat}" target="_blank" class="text-biru hover:text-blue-700">
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
                                    <span class="${item.status && item.status.toLowerCase() === 'aktif' ? 'text-green-600' : 'text-red-600'}">
                                        ${item.status || '-'}
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
            } else {
                console.error('API returned success=false or missing data:', result);
                document.getElementById('asesorName').textContent = 'Tidak dapat memuat data';
                document.getElementById('nomorMET').textContent = result.message || 'Format respons tidak sesuai';

                document.getElementById('kompetensi-tbody').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            document.getElementById('asesorName').textContent = 'Error: ' + (error.message || 'Unknown error');

            document.getElementById('kompetensi-tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
        });
    });

    // Table sorting function
    function sortTable(columnIndex) {
        const table = document.getElementById('kompetensi-table');
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
