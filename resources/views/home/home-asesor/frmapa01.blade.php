@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.MAPA-01 - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <!-- Biru -->
                    <stop offset="100%" stop-color="#8B5CF6" /> <!-- Ungu -->
                </linearGradient>
            </defs>
            <path
                d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
            />
        </svg>
        <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Merencanakan Aktivitas dan Proses Asesmen 01</p>
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
                        <a href="{{ route('frmapa01-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            MAPA.01
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

    <div id="frameMAPA01" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir MAPA.01 Merencanakan Aktifitas & Proses Asesmen</p>

        <!-- Search Form -->
        <form id="searchMAPA01" class="max-w-md mb-4 rounded-xl">
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
            <table id="daftarMAPA01" class="min-w-full bg-white overflow-hidden">
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

        <div id="detailMAPA01" class="hidden pt-0 p-4 text-black">
            <div id="FRMAPA01" class="p-4 space-y-6">
                <!-- Loading content -->
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-biru"></div>
                </div>
            </div>

            <!-- Form MAPA01 -->
            <div id="mapa01FormContainer" class="hidden px-4 pb-16">
                <p class="block mb-4 text-xl font-bold text-sidebar_font">
                    1. Pendekatan Asesmen
                </p>
                <form id="mapa01Form">
                    <div class="w-full border border-border rounded-md p-2 bg-white text-sm text-sidebar_font">
                        <table id="pendekatanAsesMAPA01" class="min-w-full bg-white overflow-hidden border border-gray-200 rounded-lg text-sm text-gray-600">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-2 text-center">No</th>
                                    <th class="px-4 py-2 text-center w-1/4">Pendekatan Asesmen</th>
                                    <th class="px-4 py-2 text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 1. Asesi -->
                                <tr class="align-middle border-b border-gray-200 col-span-4">
                                    <td class="px-4 py-2 font-semibold">1</td>
                                    <td class="px-4 py-2 font-semibold">Asesi</td>
                                    <td class="px-4 py-2 col-span-2">
                                        <div id="clMAPA01no1" class="space-y-2">
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pendekatan_asesmen_asesi" value="Hasil pelatihan dan/atau pendidikan, dimana kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Hasil pelatihan dan/atau pendidikan, dimana kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pendekatan_asesmen_asesi" value="Pekerja Berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Pekerja Berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pendekatan_asesmen_asesi" value="Pelatihan non formal/mandiri" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Pelatihan non formal/mandiri</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 2. Tujuan Asesmen -->
                                <tr class="align-middle border-b border-gray-200 col-span-4">
                                    <td class="px-4 py-2 font-semibold">2</td>
                                    <td class="px-4 py-2 font-semibold">Tujuan Asesmen</td>
                                    <td class="px-4 py-2 col-span-2">
                                        <div id="clMAPA01no2" class="space-y-2">
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="tujuan_asesmen" value="Sertifikasi" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Sertifikasi</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="tujuan_asesmen" value="Sertifikasi Ulang" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Sertifikasi Ulang</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="tujuan_asesmen" value="Pengakuan Kompetensi Terkini (PKT)" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Pengakuan Kompetensi Terkini (PKT)</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="tujuan_asesmen" value="Rekognisi Pembelajaran Lampau (RPL)" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Rekognisi Pembelajaran Lampau (RPL)</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 3. Konteks Asesmen -->
                                <tr class="align-middle border-b border-gray-200">
                                    <td class="px-4 py-2 font-semibold">3</td>
                                    <td class="px-4 py-2 font-semibold">Konteks Asesmen</td>
                                    <td id="clMAPA01no3" class="px-4 py-2 font-normal">
                                        <div id="clMAPA01Konteks1" class="grid grid-cols-2 items-center text-sidebar_font py-2 border-b border-border">
                                            <p class="self-center">Lingkungan</p>
                                            <div class="flex flex-col gap-y-1">
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="lingkungan" value="Tempat kerja nyata" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Tempat Kerja Nyata</span>
                                                </label>
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="lingkungan" value="Tempat kerja simulasi" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Tempat Kerja Simulasi</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="clMAPA01Konteks2" class="grid grid-cols-2 items-center text-sidebar_font py-2 border-b border-border">
                                            <p class="self-center">Peluang untuk mengumpulkan bukti dalam sejumlah situasi</p>
                                            <div class="flex flex-col gap-y-1">
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="peluang_untuk_mengumpulkan_bukti" value="Tersedia" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Tersedia</span>
                                                </label>
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="peluang_untuk_mengumpulkan_bukti" value="Terbatas" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Terbatas</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="clMAPA01Konteks3" class="grid grid-cols-2 items-center text-sidebar_font py-2 border-b border-border">
                                            <p class="self-center">Hubungan antara standar kompetensi</p>
                                            <div class="flex flex-col gap-y-1">
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="hubungan_antara_standar_kompetensi" value="Bukti untuk mendukung asesmen / RPL" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Bukti untuk mendukung asesmen / RPL</span>
                                                </label>
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="hubungan_antara_standar_kompetensi" value="Aktivitas kerja di tempat kerja kandidat" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Aktivitas kerja di tempat kerja kandidat</span>
                                                </label>
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="hubungan_antara_standar_kompetensi" value="Kegiatan pembelajaran" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Kegiatan pembelajaran</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div id="clMAPA01Konteks4" class="grid grid-cols-2 items-center text-sidebar_font py-2">
                                            <p class="self-center">Siapa yang melakukan asesmen / RPL</p>
                                            <div class="flex flex-col gap-y-1">
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="pelaksana_asesmen" value="Oleh Lembaga Sertifikasi" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Lembaga Sertifikasi</span>
                                                </label>
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="pelaksana_asesmen" value="Organisasi pelatihan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Organisasi pelatihan</span>
                                                </label>
                                                <label class="flex items-center space-x-2">
                                                    <input type="radio" name="pelaksana_asesmen" value="Asesor perusahaan" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                    <span>Asesor perusahaan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 4. Orang untuk konfirmasi -->
                                <tr class="align-middle border-b border-gray-200 col-span-4">
                                    <td class="px-4 py-2 font-semibold">4</td>
                                    <td class="px-4 py-2 font-semibold">Orang yang relevan untuk di Konfirmasi</td>
                                    <td class="px-4 py-2 col-span-2">
                                        <div id="clMAPA01no4" class="space-y-2">
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Manajer sertifikasi LSP" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Manajer sertifikasi LSP</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Master Assessor / Master Trainer / Asesor Utama Kompetensi" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Master Assessor / Master Trainer / Asesor Utama Kompetensi</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Manajer pelatihan Lembaga Training terakreditasi / Lembaga Training terdaftar" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Manajer pelatihan Lembaga Training terakreditasi / Lembaga Training terdaftar</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Lainnya : Manajemen sertifikasi LSP" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Lainnya : Manajemen sertifikasi LSP</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 5. Tolak Ukur Asesmen -->
                                <tr class="align-middle col-span-4">
                                    <td class="px-4 py-2 font-semibold">5</td>
                                    <td class="px-4 py-2 font-semibold">Tolak Ukur Asesmen</td>
                                    <td class="px-4 py-2 col-span-2">
                                        <div id="clMAPA01no5" class="space-y-2">
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="tolak_ukur_asesmen" value="Standar Kompetensi Kerja Nasional Indonesia (SKKNI)" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Standar Kompetensi Kerja Nasional Indonesia (SKKNI)</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="tolak_ukur_asesmen" value="Standar Khusus" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Standar Khusus</span>
                                            </label>
                                            <label class="flex items-start space-x-2">
                                                <input type="radio" name="tolak_ukur_asesmen" value="Standar Internasional" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Standar Internasional</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Button Simpan -->
                    <div class="flex flex-col items-end text-right ml-auto w-auto">
                        <button id="simpanSetujui" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru focus:outline-none mt-6">
                            Simpan dan Setujui
                        </button>
                    </div>
                </form>

                <p class="block mt-8 mb-4 text-xl font-bold text-sidebar_font">
                    2. Rencana Asesmen
                </p>
                <div class="w-full border border-border rounded-md p-2 bg-white text-sm text-sidebar_font">
                    <table id="rencanaMAPA01" class="min-w-full bg-white overflow-hidden border border-border rounded-lg text-sm text-gray-600">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">Unit Kompetensi</th>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">Elemen</th>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">Bukti-bukti</th>
                                <th colspan="3" class="px-4 py-3 font-semibold border-b border-gray-200">Jenis Bukti</th>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">Metode Asesmen</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">L</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">TL</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">T</th>
                            </tr>
                        </thead>
                        <tbody id="rencanaAsesmenTableBody" class="divide-y divide-gray-200 text-center">
                            <tr>
                                <td colspan="7" class="px-4 py-3 text-center text-gray-500">Memuat data rencana asesmen...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
                    <p class="text-sm text-gray-500">Formulir MAPA01 berhasil ditandatangani.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeSuccessModal" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">OK</button>
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
                    <p id="errorMessage" class="text-sm text-gray-500">Terjadi kesalahan.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="closeErrorModal" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">OK</button>
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
    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    // Global variables
    let currentAsesiData = null;
    let currentAsesiId = null;
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
        document.querySelector('#daftarMAPA01 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">${message}</td>
            </tr>
        `;
    }

    // Function to show loading state
    function showLoading() {
        const loadingHTML = `
            <div class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-biru"></div>
            </div>
        `;
        document.getElementById('FRMAPA01').innerHTML = loadingHTML;
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

    async function loadAsesiList() {
        try {
            const response = await fetch(asesisApiUrl, {
                method: 'GET',
                headers: headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success && result.data) {
                // Load progress for each asesi and then populate table
                loadAsesiProgress(result.data.asesis);
            } else {
                showTableError(result.message || 'Gagal memuat data asesi');
            }
        } catch (error) {
            showTableError(`Error memuat data: ${error.message}`);
        }
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
                                asesi.mapa01_completed = progressResult.data.progress_asesmen?.mapa01?.completed || false;
                                asesi.mapa01_completed_at = progressResult.data.progress_asesmen?.mapa01?.completed_at || null;
                            } else {
                                asesi.mapa01_completed = false;
                                asesi.mapa01_completed_at = null;
                            }
                        } else {
                            asesi.mapa01_completed = false;
                            asesi.mapa01_completed_at = null;
                        }
                    } catch (error) {
                        asesi.mapa01_completed = false;
                        asesi.mapa01_completed_at = null;
                    }
                    return asesi;
                })
            );

            populateAsesiTable(asesisWithProgress);
        } catch (error) {
            showTableError(`Error memuat progress asesi: ${error.message}`);
        }
    }

    function populateAsesiTable(asesisData) {
        const tableBody = document.querySelector('#daftarMAPA01 tbody');

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
            // Use the MAPA01 completion status from progress API
            const hasProgress = asesi.mapa01_completed === true;

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
                        <button onclick="showDocument('${asesi.id_asesi}')" class="">
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
                const rows = document.querySelectorAll('#daftarMAPA01 tbody tr');

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
        document.getElementById('closeSuccessModal')?.addEventListener('click', function() {
            document.getElementById('successModal')?.classList.add('hidden');
        });

        // Error modal
        document.getElementById('closeErrorModal')?.addEventListener('click', function() {
            document.getElementById('errorModal')?.classList.add('hidden');
        });
    }

    window.showSummary = function(id_asesi, nama_asesi, nama_skema, progress_percentage, completed_steps, total_steps, mapa01_completed = false) {
        currentAsesiId = id_asesi;

        // Hide search and table
        document.getElementById('searchMAPA01').classList.add('hidden');
        document.getElementById('daftarMAPA01').classList.add('hidden');

        // Show breadcrumbs and detail
        document.getElementById('breadcrumbs').classList.remove('hidden');
        document.getElementById('detailMAPA01').classList.remove('hidden');

        // Update breadcrumb
        const breadcrumbAsesi = document.getElementById('breadcrumbAsesiName');
        if (breadcrumbAsesi) {
            breadcrumbAsesi.textContent = nama_asesi;
        }

        // Load MAPA01 data
        loadMapa01Data(id_asesi);

        // Scroll to detail
        document.getElementById('detailMAPA01').scrollIntoView({ behavior: 'smooth' });
    };

    function loadMapa01Data(id_asesi) {
        const mapa01ApiUrl = `${apiConfig.url}/asesmen/mapa01/${id_asesi}`;

        showLoading();

        fetch(mapa01ApiUrl, {
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
            if (result.status === 'success' && result.data) {
                currentAsesiData = result.data;
                recordExists = result.data.record_exists;
                populateMapa01Form(result.data);
            } else {
                showError(result.message || 'Gagal memuat data MAPA01');
            }
        })
        .catch(error => {
            showError(`Error memuat data: ${error.message}`);
        });
    }

    function populateMapa01Form(data) {
        // Update general info
        const generalInfoHTML = `
            <div class="p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                            ${data.general_info.judul_skema}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                            ${data.general_info.kode_skema}
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                            ${data.general_info.nama_asesi}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                            ${data.general_info.nama_asesor}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                            ${data.general_info.nama_tuk}
                        </p>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('FRMAPA01').innerHTML = generalInfoHTML;

        // Show form container
        document.getElementById('mapa01FormContainer').classList.remove('hidden');

        // Populate existing data and handle button state
        if (recordExists && data.mapa01) {
            populateRadioButtons(data.mapa01);

            // Check if already signed (has tanda_tangan_asesor)
            const isSigned = data.mapa01.tanda_tangan_asesor && data.mapa01.tanda_tangan_asesor.trim() !== '';

            if (isSigned) {
                disableAllFormFields();
            }
        } else if (!recordExists && data.default_config) {
            // Requirements: 4.3 - Pre-populate with scheme-specific defaults
            populateRadioButtons(data.default_config);
            console.log('Populated form with scheme-specific defaults:', data.default_config);
        }

        // Set button state based on record existence and signature status
        setButtonState(data);

        // Populate rencana asesmen table
        populateRencanaAsesmenTable(data.rencana_asesmen);

        // Setup form submission only if not signed
        const isSigned = recordExists && data.mapa01?.tanda_tangan_asesor && data.mapa01.tanda_tangan_asesor.trim() !== '';
        if (!isSigned) {
            setupFormSubmission();
        }
    }

    function populateRadioButtons(mapa01Data) {
        const radioGroups = [
            'pendekatan_asesmen_asesi',
            'tujuan_asesmen',
            'lingkungan',
            'peluang_untuk_mengumpulkan_bukti',
            'hubungan_antara_standar_kompetensi',
            'pelaksana_asesmen',
            'pihak_yang_relevan_untuk_dikonfirmasi',
            'tolak_ukur_asesmen'
        ];

        radioGroups.forEach(groupName => {
            if (mapa01Data[groupName]) {
                const radio = document.querySelector(`input[name="${groupName}"][value="${mapa01Data[groupName]}"]`);
                if (radio) {
                    radio.checked = true;
                }
            }
        });
    }

    // Function to disable all form fields
    function disableAllFormFields() {
        const radioButtons = document.querySelectorAll('#mapa01Form input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.disabled = true;
        });
    }

    // Function to set button state based on data
    function setButtonState(data) {
        const submitButton = document.getElementById('simpanSetujui');
        if (!submitButton) return;

        // Check if record exists and is signed (has tanda_tangan_asesor)
        const isSigned = recordExists && data.mapa01?.tanda_tangan_asesor && data.mapa01.tanda_tangan_asesor.trim() !== '';

        if (isSigned) {
            // Show signature info if available
            if (data.mapa01.waktu_tanda_tangan_asesor) {
                const signatureInfo = document.createElement('p');
                signatureInfo.className = 'mt-2 text-xs text-gray-500 text-center';
                signatureInfo.innerHTML = `<i>Ditandatangani pada: ${data.mapa01.waktu_tanda_tangan_asesor}</i>`;
                submitButton.parentNode.appendChild(signatureInfo);
            }

            // Data already exists and is signed - disable button with gray color
            submitButton.textContent = 'Sudah Ditandatangani';
            submitButton.disabled = true;
            submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
            submitButton.classList.add('bg-gray-400', 'cursor-not-allowed', 'text-gray-600');

            // Add a lock icon to the button
            submitButton.innerHTML = `
                <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                Sudah Ditandatangani
            `;
        } else {
            // Data doesn't exist or not signed - enable button with original colors
            submitButton.textContent = 'Simpan dan Setujui';
            submitButton.disabled = false;
            submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed', 'text-gray-600');
            submitButton.classList.add('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');

            // Remove any existing signature info
            const existingSignatureInfo = submitButton.parentNode.querySelector('.text-xs.text-gray-500');
            if (existingSignatureInfo) {
                existingSignatureInfo.remove();
            }
        }
    }

    function populateRencanaAsesmenTable(rencanaData) {
        const tableBody = document.getElementById('rencanaAsesmenTableBody');

        if (!rencanaData || rencanaData.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data rencana asesmen</td>
                </tr>
            `;
            return;
        }

        let tableContent = '';
        rencanaData.forEach(uk => {
            uk.rencana.forEach((rencana, index) => {
                const isFirstRow = index === 0;
                const rowSpan = isFirstRow ? uk.rencana.length : 0;

                tableContent += `
                    <tr class="text-black">
                        ${isFirstRow ? `<td rowspan="${rowSpan}" class="px-4 py-3 text-left align-top border-r border-gray-200">
                            <div class="font-semibold">${uk.kode_uk}</div>
                            <div class="text-sm text-gray-600">${uk.nama_uk}</div>
                        </td>` : ''}
                        <td class="px-4 py-3 text-left">${rencana.elemen}</td>
                        <td class="px-4 py-3 text-left">${rencana.bukti_bukti}</td>
                        <td class="px-4 py-3">
                            ${rencana.jenis_bukti === 'L' ? '✓' : ''}
                        </td>
                        <td class="px-4 py-3">
                            ${rencana.jenis_bukti === 'TL' ? '✓' : ''}
                        </td>
                        <td class="px-4 py-3">
                            ${rencana.jenis_bukti === 'T' ? '✓' : ''}
                        </td>
                        <td class="px-4 py-3 text-left">${rencana.metode_label}</td>
                    </tr>
                `;
            });
        });

        tableBody.innerHTML = tableContent;
    }

    function setupFormSubmission() {
        const submitButton = document.getElementById('simpanSetujui');
        if (submitButton && !submitButton.disabled) {
            // Remove existing event listeners
            submitButton.replaceWith(submitButton.cloneNode(true));

            // Add new event listener
            document.getElementById('simpanSetujui').addEventListener('click', handleFormSubmit);
        }
    }

    function collectFormData() {
        const formData = {
            id_asesi: currentAsesiId,
            id_asesor: apiConfig.asesorId,
            is_signing: true
        };

        const radioGroups = [
            'pendekatan_asesmen_asesi',
            'tujuan_asesmen',
            'lingkungan',
            'peluang_untuk_mengumpulkan_bukti',
            'hubungan_antara_standar_kompetensi',
            'pelaksana_asesmen',
            'pihak_yang_relevan_untuk_dikonfirmasi',
            'tolak_ukur_asesmen'
        ];

        radioGroups.forEach(groupName => {
            const checkedRadio = document.querySelector(`input[name="${groupName}"]:checked`);
            if (checkedRadio) {
                formData[groupName] = checkedRadio.value;
            }
        });

        return formData;
    }

    function handleFormSubmit() {
        const formData = collectFormData();

        // Validate required fields
        const requiredFields = [
            'pendekatan_asesmen_asesi',
            'tujuan_asesmen',
            'lingkungan',
            'peluang_untuk_mengumpulkan_bukti',
            'hubungan_antara_standar_kompetensi',
            'pelaksana_asesmen',
            'pihak_yang_relevan_untuk_dikonfirmasi',
            'tolak_ukur_asesmen'
        ];

        const missingFields = requiredFields.filter(field => !formData[field]);

        if (missingFields.length > 0) {
            showError('Harap lengkapi semua field yang diperlukan sebelum menyimpan.');
            return;
        }

        // Show loading state
        const submitButton = document.getElementById('simpanSetujui');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Menyimpan...';
        submitButton.disabled = true;
        submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
        submitButton.classList.add('bg-gray-400');

        // Submit data
        saveMapa01Data(formData, submitButton, originalText);
    }

    function saveMapa01Data(formData, submitButton, originalText) {
        const saveApiUrl = `${apiConfig.url}/asesmen/mapa01/save`;

        fetch(saveApiUrl, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            if (result.status === 'success') {
                showSuccess();

                // Update button to disabled state permanently
                submitButton.textContent = 'Sudah Ditandatangani';
                submitButton.disabled = true;
                submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
                submitButton.classList.add('bg-gray-400', 'cursor-not-allowed', 'text-gray-600');

                // Add lock icon
                submitButton.innerHTML = `
                    <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 616 0z" clip-rule="evenodd"></path>
                    </svg>
                    Sudah Ditandatangani
                `;

                // Disable all form fields
                disableAllFormFields();

                // Update global state
                recordExists = true;
                if (currentAsesiData && currentAsesiData.mapa01) {
                    currentAsesiData.mapa01.tanda_tangan_asesor = result.data?.tanda_tangan_asesor || 'signed';
                    currentAsesiData.mapa01.waktu_tanda_tangan_asesor = result.data?.waktu_tanda_tangan_asesor || new Date().toLocaleString('id-ID');
                }

                // Reload data to show updated signature and reload asesi list
                setTimeout(() => {
                    loadMapa01Data(currentAsesiId);
                    loadAsesiList();
                }, 1000);
            } else {
                throw new Error(result.message || 'Gagal menyimpan data');
            }
        })
        .catch(error => {
            showError(`Error menyimpan data: ${error.message}`);

            // Restore button state on error
            submitButton.textContent = originalText;
            submitButton.disabled = false;
            submitButton.classList.remove('bg-gray-400', 'cursor-not-allowed', 'text-gray-600');
            submitButton.classList.add('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
        });
    }

    // Add window alias for backward compatibility
    // window.showDocument = window.showSummary;
});
function showDocument(id_asesi) {
    window.open('/asesor/frmapa01/pdf/' + id_asesi, "_blank");
}

// Table sorting function (global for onclick handler)
function sortTable(columnIndex) {
    const table = document.getElementById('daftarMAPA01');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    // Skip if there are less than 2 rows or the rows don't have enough cells
    if (rows.length < 2 || rows[0].querySelectorAll('td').length <= columnIndex) {
        return;
    }

    // Determine the current sort direction
    const th = table.querySelector(`th:nth-child(${columnIndex + 1})`);
    const currentDirection = th.classList.contains('sorted-asc') ? 'desc' : 'asc';

    // Remove sorted classes from all headers
    table.querySelectorAll('th').forEach(header => {
        header.classList.remove('sorted-asc', 'sorted-desc');
    });

    // Add the appropriate class to the current header
    th.classList.add(`sorted-${currentDirection}`);

    // Sort the rows
    rows.sort((a, b) => {
        const aValue = a.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';
        const bValue = b.querySelectorAll('td')[columnIndex]?.textContent.trim() || '';

        // Compare values based on direction
        if (currentDirection === 'asc') {
            return aValue.localeCompare(bValue, undefined, { numeric: true });
        } else {
            return bValue.localeCompare(aValue, undefined, { numeric: true });
        }
    });

    // Re-append the sorted rows to the tbody
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
}
</script>
@endsection
