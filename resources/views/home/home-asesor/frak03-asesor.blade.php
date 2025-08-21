    @extends('home.home-asesor.layouts.layout')

    @section('title', 'FR.AK-03 - Asesor')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('content')
    <div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
        <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
                <defs>
                    <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                        <stop offset="0%" stop-color="#3B82F6" /> <stop offset="100%" stop-color="#8B5CF6" /> </linearGradient>
                </defs>
                <path
                    d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
                />
            </svg>
            <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Umpan Balik dan Catatan Asesmen</p>
        </div>
        
        <div id="bgGradient"
            class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
        </div>

        <div id="loadingIndicator" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
            <span>Memuat data...</span>
        </div>

        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
            <span id="errorText">Terjadi kesalahan saat memuat data.</span>
        </div>

        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
            <span id="successText">Data berhasil dimuat.</span>
        </div>

        <div id="frameAK03" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
            <p id="titlePage" class="mb-4 text-lg font-medium text-black">Data Asesi untuk FR.AK.03 Umpan Balik dan Catatan Asesmen</p>
            <form id="searchAK03" class="max-w-md mb-4 rounded-xl">
                <div class="relative">
                    <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi atau Nama Asesi" required />
                    <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </form>
            <div class="overflow-x-auto shadow-sm rounded-lg">
                <table id="daftarAK03" class="min-w-full bg-white overflow-hidden">
                    <thead class="bg-bg_dashboard text-center">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Aksi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Nama Peserta</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">Skema Sertifikasi</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Kode Skema</th>
                            <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-black text-center">
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Memuat data asesi...</td>
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
        // =================================================================================
        // KONFIGURASI DAN INISIALISASI
        // =================================================================================
        const apiConfig = {
            url: @json(config('services.api.url')),
            key: @json(config('services.api.key')),
            asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
            csrfToken: @json(csrf_token()),
            // [MODIFIED] Define a route name in your web.php for the detail page
            detailRoute: '{{ route("frak03-asesor.detail", ["id" => ":id"]) }}'
        };

        const headers = {
            'Content-Type': 'application/json',
            'API-KEY': apiConfig.key,
            'Accept': 'application/json',
            'X-CSRF-TOKEN': apiConfig.csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };

        if (!apiConfig.url || !apiConfig.key || !apiConfig.asesorId) {
            showMessage('Konfigurasi API tidak lengkap. Silakan hubungi administrator.', 'error');
            document.querySelector('#daftarAK03 tbody').innerHTML = `<tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak valid</td></tr>`;
            return;
        }

        function renderAsesiTable(asesisData) {
            const tableBody = document.querySelector('#daftarAK03 tbody');
            if (!asesisData || asesisData.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi yang ditemukan.</td></tr>`;
                return;
            }

            let tableContent = '';
            asesisData.forEach((asesi, index) => {
                const statusIcon = asesi.ak03_completed ?
                    `<svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/></svg>` :
                    `<svg class="w-6 h-6 text-logout" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/></svg>`;

                const detailUrl = apiConfig.detailRoute.replace(':id', asesi.id_asesi);
                
                // [MODIFIKASI] Buat URL khusus untuk print dengan parameter ?print=1
                const printUrl = `${detailUrl}?print=1`;

                tableContent += `
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="${detailUrl}" title="Lihat Detail">
                                    <svg class="w-6 h-6 text-biru hover:text-ungu" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                
                                <a href="${printUrl}" target="_blank" title="Cetak Formulir">
                                    <svg class="w-6 h-6 text-ungu hover:text-biru" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_asesi}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_skema}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${asesi.nomor_skema}</td>
                        <td class="flex px-4 py-3 justify-center items-center">${statusIcon}</td>
                    </tr>
                `;
            });
            tableBody.innerHTML = tableContent;
        }

        function showMessage(message, type = 'info', duration = 5000) {
            const elements = {
                success: document.getElementById('successMessage'),
                error: document.getElementById('errorMessage'),
                loading: document.getElementById('loadingIndicator')
            };
            Object.values(elements).forEach(el => el.classList.add('hidden'));

            const activeElement = elements[type];
            if (activeElement) {
                activeElement.querySelector('span').textContent = message;
                activeElement.classList.remove('hidden');
                if (duration > 0) {
                    setTimeout(() => activeElement.classList.add('hidden'), duration);
                }
            }
        }
        
        // =================================================================================
        // FUNGSI MEMUAT DATA (FETCH API)
        // =================================================================================
        async function loadAsesiData() {
            showMessage('Memuat data asesi...', 'loading', 0);
            const asesisApiUrl = `${apiConfig.url}/asesor/asesis/${apiConfig.asesorId}`;
            try {
                const response = await fetch(asesisApiUrl, { method: 'GET', headers: headers });
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const result = await response.json();
                if (result.success && result.data) {
                    let asesisData = result.data.asesis;
                    const progressPromises = asesisData.map(asesi => fetchProgress(asesi.id_asesi));
                    const progresses = await Promise.all(progressPromises);
                    
                    asesisData.forEach((asesi, index) => {
                        asesi.ak03_completed = progresses[index]?.progress_asesmen?.umpan_balik?.completed || false;
                    });

                    renderAsesiTable(asesisData);
                    showMessage('Data asesi berhasil dimuat.', 'success');
                } else {
                    throw new Error(result.message || 'Gagal mengambil data asesi.');
                }
            } catch (error) {
                showMessage(`Error memuat data asesi: ${error.message}`, 'error');
                document.querySelector('#daftarAK03 tbody').innerHTML = `<tr><td colspan="6" class="px-4 py-3 text-center text-red-500">${error.message}</td></tr>`;
            }
        }
        
        async function fetchProgress(asesiId) {
            const progressApiUrl = `${apiConfig.url}/asesor/progressAsesi/${asesiId}`;
            try {
                const response = await fetch(progressApiUrl, { method: 'GET', headers: headers });
                if (!response.ok) return null;
                const result = await response.json();
                return result.success ? result.data : null;
            } catch (error) {
                return null;
            }
        }

        // =================================================================================
        // FUNGSI RENDER TABEL
        // =================================================================================
        // =================================================================================
        // EVENT LISTENERS & EKSEKUSI AWAL
        // =================================================================================
        document.getElementById('searchAK03').addEventListener('submit', function(e) {
            e.preventDefault();
        });

        document.getElementById('default-search').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            document.querySelectorAll('#daftarAK03 tbody tr').forEach(row => {
                const nama = row.cells[2]?.textContent.toLowerCase() || '';
                const skema = row.cells[3]?.textContent.toLowerCase() || '';
                row.style.display = (nama.includes(searchValue) || skema.includes(searchValue)) ? '' : 'none';
            });
        });
        
        window.sortTable = function(columnIndex) {
            const table = document.getElementById('daftarAK03');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            if (rows.length <= 1) return;

            const sortDirection = table.dataset.sortDir === 'asc' ? 'desc' : 'asc';
            table.dataset.sortCol = columnIndex;
            table.dataset.sortDir = sortDirection;

            rows.sort((a, b) => {
                const aText = a.cells[columnIndex].textContent.trim();
                const bText = b.cells[columnIndex].textContent.trim();
                const aVal = isNaN(aText) || aText === '' ? aText : parseFloat(aText);
                const bVal = isNaN(bText) || bText === '' ? bText : parseFloat(bText);

                if (aVal < bVal) return sortDirection === 'asc' ? -1 : 1;
                if (aVal > bVal) return sortDirection === 'asc' ? 1 : -1;
                return 0;
            });

            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        };

        // Panggil fungsi untuk memuat data saat halaman pertama kali dibuka
        loadAsesiData();
    });
    </script>
    @endsection