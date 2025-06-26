@extends('home.home-asesor.layouts.layout')

@section('title', 'Konsultasi Pra Uji - Asesor')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z" />
        </svg>
        <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Konsultasi Pra Uji</p>
    </div>

    <!-- Loading, Error, and Success Messages -->
    <div id="messageContainer" class="mb-4">
        <div id="loadingMessage" class="hidden p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50" role="alert">
            <div class="flex items-center">
                <svg class="w-4 h-4 me-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="loadingText">Memuat data...</span>
            </div>
        </div>

        <div id="errorMessage" class="hidden p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
            <div class="flex items-center">
                <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span id="errorText">Terjadi kesalahan.</span>
            </div>
        </div>

        <div id="successMessage" class="hidden p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
            <div class="flex items-center">
                <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span id="successText">Data berhasil disimpan.</span>
            </div>
        </div>
    </div>

    <div id="breadcrumbs" class="hidden pb-4 px-6">
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('home-asesor') }}" class="inline-flex items-center text-sm font-medium text-black hover:text-sidebar_font">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <a href="{{ route('konsul-prauji-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            Konsultasi Pra Uji
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span id="breadcrumbAsesiName" class="ms-1 text-sm font-medium text-black">Detail Konsultasi</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>

    <div id="frameKonsul" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Konsultasi Pra Uji</p>

        <!-- Search Form -->
        <form id="searchKonsul" class="max-w-md mb-4 rounded-xl">
            <div class="relative">
                <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi atau Nama Peserta" />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto shadow-md rounded-lg">
            <table id="daftarKonsul" class="min-w-full bg-white overflow-hidden">
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
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                            <div class="flex justify-center items-center space-x-2">
                                <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memuat data asesi...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="detailKonsul" class="hidden pt-0 p-4 text-black">
            <!-- Input Formulir Konsultasi Pra Uji -->
            <form id="formKonsulPrauji">
                <div id="KonsulPrauji" class="p-4 space-y-6">
                    <p id="judulDetail" class="text-lg font-semibold text-sidebar_font">FORMULIR KONSULTASI PRA UJI</p>
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                                Skema Sertifikasi
                            </span>
                            <p id="judulSertifikasi" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nomor Skema
                            </span>
                            <p id="nomorSertifikasi" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Tanggal Asesmen
                            </span>
                            <p id="tanggalAsesmen" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                    </div>
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nama Asesor
                            </span>
                            <p id="namaAsesor" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                TUK
                            </span>
                            <p id="tuk" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tabel Unit Kompetensi -->
                <div class="p-4">
                    <p id="judulTabelKonsul" class="text-sidebar_font font-semibold pb-2">Unit Kompetensi</p>
                    <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                        <table id="unitKompetensiTable" class="min-w-full bg-white overflow-hidden">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Kode Unit</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Judul Unit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-black text-center items-center">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                                        <div class="flex justify-center items-center space-x-2">
                                            <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Memuat unit kompetensi...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Checklist Konsultasi Pra Uji -->
                <div class="p-4">
                    <p id="judulTabelKonsulPrauji" class="text-sidebar_font font-semibold pb-2">
                        Asesor agar menginformasikan hal-hal dibawah ini:
                    </p>

                    <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                        <table id="checklistTable" class="min-w-full bg-white overflow-hidden">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider" style="width: 10%">No</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider" style="width: 70%">Situasi</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider" style="width: 20%">Jawaban</th>
                                </tr>
                            </thead>
                            <tbody id="checklistTableBody" class="divide-y divide-gray-200 text-black">
                                <!-- Checklist items will be dynamically populated -->
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">
                                        <div class="flex justify-center items-center space-x-2">
                                            <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Memuat checklist...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tanda Tangan Section -->
                <div class="my-6 px-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Tanda Tangan Asesi (Read-only) -->
                        <div class="flex flex-col items-center justify-center">
                            <label class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">Tanda Tangan Asesi</label>

                            <!-- Container untuk tanda tangan asesi -->
                            <div class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 bg-gray-50 cursor-default min-h-[200px]">
                                <div class="text-center" id="asesi-signature-content">
                                    <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                    </svg>
                                    <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                        <span class="font-semibold text-abu">Diisi oleh Asesi</span>
                                    </div>
                                    <p class="text-xs leading-5 text-gray-500">Tanda tangan dilakukan oleh asesi untuk melengkapi formulir</p>
                                </div>
                                <!-- Preview Image Asesi -->
                                <div id="asesi-signature-preview" class="hidden">
                                    <img id="asesi-signature-image" src="" alt="Tanda Tangan Asesi" class="max-h-48 w-auto mx-auto rounded-lg p-2 border border-gray-200 bg-white shadow-sm">
                                    <p class="text-xs text-center mt-2 text-gray-500">Tanda tangan asesi</p>
                                    <p id="tanggalTandaTanganAsesi" class="text-xs text-center text-gray-500">Tanggal: -</p>
                                </div>
                            </div>

                            <p class="font-medium text-sidebar_font mt-2">Asesi</p>
                            <p id="namaAsesiTTD" class="font-normal text-sidebar_font">Memuat nama asesi...</p>
                        </div>

                        <!-- Tanda Tangan Asesor dengan Checkbox untuk Persetujuan -->
                        <div class="flex flex-col items-center justify-center">
                            <label for="is_asesor_signing" class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">
                                Tanda Tangan Asesor
                                <span class="text-red-500">*</span>
                            </label>

                            <!-- Tampilkan tanggal otomatis -->
                            <p id="tanggalTandaTangan" class="font-medium text-sidebar_font mb-2"></p>

                            <!-- Container untuk tanda tangan asesor -->
                            <div id="tandaTanganContainer" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 hover:bg-blue-50 cursor-pointer min-h-[200px]">
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
                                    <img id="tandaTanganAsesor" src="" alt="Tanda Tangan Asesor" class="max-h-48 w-auto mx-auto rounded-lg p-2 border border-gray-200 bg-white shadow-sm">
                                    <p class="text-xs text-center mt-2 text-gray-500">Tanda tangan asesor dari biodata</p>
                                    <p id="tanggalTandaTanganAsesor" class="text-xs text-center text-gray-500">Tanggal: -</p>
                                </div>
                            </div>

                            <!-- Enhanced Checkbox untuk tanda tangan dengan status indicator -->
                            <div class="mt-3 flex items-center relative">
                                <input id="is_asesor_signing" name="is_asesor_signing" type="checkbox" value="true" class="w-4 h-4 text-biru bg-gray-100 border-gray-300 rounded focus:ring-biru transition-all duration-200">
                                <label for="is_asesor_signing" class="ms-2 text-sm font-medium text-sidebar_font transition-all duration-200">
                                    <span id="checkboxLabel">Saya setuju menandatangani formulir ini</span>
                                </label>

                                <!-- Status Badge -->
                                <div id="statusBadge" class="ml-3 hidden">
                                    <span id="statusText" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Sudah Ditandatangani
                                    </span>
                                </div>
                            </div>

                            <p class="font-medium text-sidebar_font mt-2">Asesor</p>
                            <p id="namaAsesorTTD" class="font-normal text-sidebar_font">Memuat nama asesor...</p>
                        </div>
                    </div>

                    <!-- Enhanced Button Section with Status -->
                    <div class="flex justify-end pe-4">
                        <button id="btnKembali" type="button" class="inline-flex justify-center rounded-md bg-gray-200 text-gray-700 px-6 py-2 text-sm/6 font-medium hover:bg-gray-300 focus:outline-none mt-6 me-3 transition-all duration-200">
                            Kembali
                        </button>

                        <!-- Enhanced Submit Button with Status -->
                        <div class="relative">
                            <button id="btnSimpan" type="submit" class="inline-flex justify-center items-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru focus:outline-none mt-6 transition-all duration-200">
                                <span id="buttonText">Saya Menyetujui</span>
                                <span id="buttonIcon" class="ml-2 hidden">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>

                            <!-- Lock indicator -->
                            <div id="lockIndicator" class="absolute -top-2 -right-2 hidden">
                                <div class="bg-green-500 text-white rounded-full p-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Status Information -->
                    <div id="formStatusInfo" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-green-800">Formulir Telah Diselesaikan</h4>
                                <p class="text-xs text-green-700 mt-1">
                                    Formulir konsultasi pra uji telah ditandatangani dan disimpan. Data tidak dapat diubah kembali.
                                </p>
                                <p id="completionDate" class="text-xs text-green-600 mt-1 font-medium">
                                    <!-- Completion date will be inserted here -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Konfirmasi Tanda Tangan -->
    <div id="signatureModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
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
                        Anda akan menandatangani formulir <strong>Konsultasi Pra Uji</strong> secara digital.
                    </p>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-red-800 mb-1">Perhatian Penting:</h4>
                                <p class="text-sm text-red-700">
                                    Setelah menandatangani, Anda <strong>tidak dapat mengubah</strong> atau membatalkan persetujuan ini. Pastikan semua checklist sudah diisi dengan benar.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-600">Saya telah melakukan konsultasi pra uji dengan asesi</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-600">Semua poin checklist telah saya sampaikan kepada asesi</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-600">Data yang saya masukkan sudah benar dan lengkap</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-end space-x-3">
                    <button id="cancelSignature" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        Batal
                    </button>
                    <button id="confirmSignature" type="button" class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-biru to-ungu border border-transparent rounded-md hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 flex items-center">
                        <span id="confirmSignatureText">Ya, Tandatangani</span>
                        <div id="confirmSignatureLoading" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2"></div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Sukses -->
    <div id="successSignatureModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
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
                    Formulir Konsultasi Pra Uji telah berhasil ditandatangani dan disimpan. Tanda tangan digital Anda telah terekam dalam sistem.
                </p>

                <!-- Button -->
                <button id="closeSuccessSignatureModal" type="button" class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="bgGradient2"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>


<style>
.upload-area:hover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
}

.upload-area.dragover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
    transform: scale(1.02);
}

#tandaTanganAsesor,
#asesi-signature-image {
    max-width: 100%;
    max-height: 100%;
}

#asesor-signature-preview img,
#asesi-signature-preview img {
    width: 100%;
    max-width: 100%;
    height: auto;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    padding: 8px;
    background: white;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #3B82F6;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Enhanced styling untuk checkbox dan radio buttons */
.radio-option {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    transition: all 0.2s ease;
}

.radio-option input[type="radio"] {
    width: 1rem;
    height: 1rem;
    margin-right: 0.5rem;
    transition: all 0.2s ease;
}

.radio-option input[type="radio"]:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.radio-option label {
    transition: all 0.2s ease;
}

.radio-option input[type="radio"]:disabled + label {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Enhanced checkbox styling */
#is_asesor_signing {
    transition: all 0.2s ease;
}

#is_asesor_signing:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

#is_asesor_signing:disabled + label {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Button state styling */
.btn-completed {
    background: linear-gradient(135deg, #10B981, #059669) !important;
    cursor: not-allowed !important;
    position: relative;
}

.btn-completed:hover {
    background: linear-gradient(135deg, #10B981, #059669) !important;
}

.btn-loading {
    cursor: not-allowed !important;
    opacity: 0.8;
}

/* Status badge styling */
.status-completed {
    background-color: #10B981;
    color: white;
}

.status-pending {
    background-color: #F59E0B;
    color: white;
}

/* Form lock overlay */
.form-locked {
    position: relative;
}

.form-locked::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.02);
    pointer-events: none;
    z-index: 1;
}

/* Fix untuk flex layout pada upload area */
.upload-area {
    min-height: 200px;
}

/* Animasi transisi untuk detail */
.fade-enter {
    opacity: 0;
    transform: translateY(-10px);
}

.fade-enter-active {
    opacity: 1;
    transform: translateY(0);
    transition: opacity 300ms, transform 300ms;
}

.fade-exit {
    opacity: 1;
    transform: translateY(0);
}

.fade-exit-active {
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 300ms, transform 300ms;
}

/* Enhanced disabled state for table rows */
.checklist-disabled {
    background-color: #f9fafb;
    opacity: 0.8;
}

.checklist-disabled td {
    color: #6b7280;
}

/* Pulse animation for loading states */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Configuration
    const config = {
        apiKey: "{{ env('API_KEY') }}",
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
        baseUrl: "{{ url('/api/v1') }}",
        headers: {}
    };

    // Set up headers
    config.headers = {
        'Content-Type': 'application/json',
        'API-KEY': config.apiKey,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': config.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // State management
    const state = {
        currentAsesiId: null,
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        asesiData: [],
        searchTerm: '',
        isSubmitting: false,
        checklist: {
            point_1: { jawaban_asesor: null },
            point_2: { jawaban_asesor: null },
            point_3: { jawaban_asesor: null },
            point_4: { jawaban_asesor: null },
            point_5: { jawaban_asesor: null },
            point_6: { jawaban_asesor: null },
            point_7: { jawaban_asesor: null },
            point_8: { jawaban_asesor: null },
            point_9: { jawaban_asesor: null }
        },
        consultationData: null,
        asesorSignatureUrl: null,
        isFormCompleted: false,
        isFormLocked: false,
        isAsesorSigned: false,
        formInitialized: false,
        recordExists: false
    };

    // DOM elements
    const elements = {
        breadcrumbs: document.getElementById('breadcrumbs'),
        searchForm: document.getElementById('searchKonsul'),
        asesiTable: document.getElementById('daftarKonsul'),
        detailView: document.getElementById('detailKonsul'),
        consultationForm: document.getElementById('formKonsulPrauji'),
        backButton: document.getElementById('btnKembali'),
        submitButton: document.getElementById('btnSimpan'),
        checklistTableBody: document.getElementById('checklistTableBody'),
        unitKompetensiTable: document.getElementById('unitKompetensiTable').querySelector('tbody'),
        breadcrumbAsesiName: document.getElementById('breadcrumbAsesiName'),
        signingCheckbox: document.getElementById('is_asesor_signing'),
        tandaTanganAsesor: document.getElementById('tandaTanganAsesor'),

        // Signature elements for Asesi
        asesiSignatureContent: document.getElementById('asesi-signature-content'),
        asesiSignaturePreview: document.getElementById('asesi-signature-preview'),
        asesiSignatureImage: document.getElementById('asesi-signature-image'),
        tanggalTandaTanganAsesi: document.getElementById('tanggalTandaTanganAsesi'),
        namaAsesiTTD: document.getElementById('namaAsesiTTD'),

        // Signature elements for Asesor
        asesorSignatureContent: document.getElementById('asesor-signature-content'),
        asesorSignaturePreview: document.getElementById('asesor-signature-preview'),
        tanggalTandaTanganAsesor: document.getElementById('tanggalTandaTanganAsesor'),

        // Form fields
        namaAsesor: document.getElementById('namaAsesor'),
        namaAsesorTTD: document.getElementById('namaAsesorTTD'),
        namaPeserta: document.getElementById('namaPeserta'),
        judulSertifikasi: document.getElementById('judulSertifikasi'),
        nomorSertifikasi: document.getElementById('nomorSertifikasi'),
        tanggalAsesmen: document.getElementById('tanggalAsesmen'),
        tuk: document.getElementById('tuk'),
        tanggalTandaTangan: document.getElementById('tanggalTandaTangan'),

        // Modal elements
        signatureModal: document.getElementById('signatureModal'),
        successSignatureModal: document.getElementById('successSignatureModal'),
        cancelSignature: document.getElementById('cancelSignature'),
        confirmSignature: document.getElementById('confirmSignature'),
        confirmSignatureText: document.getElementById('confirmSignatureText'),
        confirmSignatureLoading: document.getElementById('confirmSignatureLoading'),
        closeSuccessSignatureModal: document.getElementById('closeSuccessSignatureModal')
    };

    // Stop execution if no asesor ID is found
    if (!state.asesorId) {
        showMessage('error', 'User tidak teridentifikasi, silahkan login kembali');
        document.querySelector('#daftarKonsul tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">User tidak teridentifikasi, silahkan login kembali</td>
            </tr>
        `;
        return;
    }

    // Load asesor signature from biodata
    async function loadAsesorSignature() {
        try {
            const biodataApiUrl = `${config.baseUrl}/asesor/biodata/${state.asesorId}`;

            const response = await fetch(biodataApiUrl, {
                method: 'GET',
                headers: config.headers
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success && result.data?.file_url_tanda_tangan) {
                    state.asesorSignatureUrl = "{{ url('') }}" + result.data.file_url_tanda_tangan;
                }
            }
        } catch (error) {
            // Error handled silently in production
        }
    }

    // Utility function to show messages
    function showMessage(type, message, duration = 5000) {
        // Hide all messages first
        document.getElementById('loadingMessage').classList.add('hidden');
        document.getElementById('errorMessage').classList.add('hidden');
        document.getElementById('successMessage').classList.add('hidden');

        // Show appropriate message
        const messageElement = document.getElementById(`${type}Message`);
        const textElement = document.getElementById(`${type}Text`);

        if (messageElement && textElement) {
            textElement.textContent = message;
            messageElement.classList.remove('hidden');

            // Auto-hide after duration (if specified)
            if (duration > 0) {
                setTimeout(() => {
                    messageElement.classList.add('hidden');
                }, duration);
            }
        }
    }

    // Format date to Indonesian format
    function formatDate(dateString) {
        if (!dateString) return '';

        // If the date is already in DD-MM-YYYY format with time
        if (dateString.includes('-') && dateString.includes(' ')) {
            const [datePart, timePart] = dateString.split(' ');
            const [day, month, year] = datePart.split('-');
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            return `${day} ${months[parseInt(month) - 1]} ${year}`;
        }

        // If the date is already in DD-MM-YYYY format
        if (dateString.includes('-') && dateString.split('-').length === 3) {
            const [day, month, year] = dateString.split('-');
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            return `${day} ${months[parseInt(month) - 1]} ${year}`;
        }

        // Otherwise, parse as ISO date
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString; // Return original if invalid

        const day = date.getDate();
        const month = date.getMonth();
        const year = date.getFullYear();

        const months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
            'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return `${day} ${months[month]} ${year}`;
    }

    // Set today's date
    function setTodayDate() {
        const today = new Date();
        elements.tanggalTandaTangan.textContent = formatDate(today.toISOString().split('T')[0]);
    }

    // Apply form lock with comprehensive visual feedback
    function applyFormLock(shouldLock, reason = '') {
        state.isFormLocked = shouldLock;

        // Get UI elements
        const buttonText = document.getElementById('buttonText');
        const buttonIcon = document.getElementById('buttonIcon');
        const lockIndicator = document.getElementById('lockIndicator');
        const statusBadge = document.getElementById('statusBadge');
        const statusText = document.getElementById('statusText');
        const checkboxLabel = document.getElementById('checkboxLabel');
        const formStatusInfo = document.getElementById('formStatusInfo');
        const completionDate = document.getElementById('completionDate');

        // Lock/unlock all radio buttons with visual feedback
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        const checklistRows = document.querySelectorAll('#checklistTableBody tr');

        radioButtons.forEach(radio => {
            radio.disabled = shouldLock;
        });

        // Apply visual feedback to checklist rows
        checklistRows.forEach(row => {
            if (shouldLock) {
                row.classList.add('checklist-disabled');
            } else {
                row.classList.remove('checklist-disabled');
            }
        });

        // Handle button and checkbox based on state
        if (shouldLock && state.isAsesorSigned && state.recordExists) {
            // FORM IS COMPLETED AND SIGNED - ENHANCED UI
            if (buttonText) buttonText.textContent = 'Sudah Disetujui';
            if (buttonIcon) buttonIcon.classList.remove('hidden');

            elements.submitButton.disabled = true;
            elements.submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
            elements.submitButton.classList.add('btn-completed');

            // Show lock indicator
            if (lockIndicator) lockIndicator.classList.remove('hidden');

            // FORCE CHECKBOX TO CHECKED AND DISABLED WITH ENHANCED STYLING
            elements.signingCheckbox.checked = true;
            elements.signingCheckbox.disabled = true;
            elements.signingCheckbox.parentElement.style.opacity = '0.8';

            // Update checkbox label and show status badge
            if (checkboxLabel) checkboxLabel.textContent = 'Formulir telah ditandatangani';
            if (statusBadge) statusBadge.classList.remove('hidden');
            if (statusText) statusText.classList.add('status-completed');

            // Show form status info
            if (formStatusInfo) formStatusInfo.classList.remove('hidden');

            // Set completion date if available
            if (completionDate) {
                const completionDateStr = state.consultationData?.konsultasi_pra_uji?.waktu_tanda_tangan_asesor ||
                                        state.consultationData?.konsultasi_pra_uji?.waktu_ttd_asesor;
                if (completionDateStr) {
                    completionDate.textContent = `Diselesaikan pada: ${formatDate(completionDateStr)}`;
                } else {
                    completionDate.textContent = `Diselesaikan pada: ${formatDate(new Date().toISOString().split('T')[0])}`;
                }
            }

        } else if (!shouldLock) {
            // FORM IS UNLOCKED - RESET TO DEFAULT STATE
            if (buttonText) buttonText.textContent = 'Saya Menyetujui';
            if (buttonIcon) buttonIcon.classList.add('hidden');

            elements.submitButton.disabled = false;
            elements.submitButton.classList.add('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
            elements.submitButton.classList.remove('btn-completed');

            // Hide lock indicator
            if (lockIndicator) lockIndicator.classList.add('hidden');

            // RESET CHECKBOX WITH DEFAULT STYLING
            elements.signingCheckbox.checked = false;
            elements.signingCheckbox.disabled = false;
            elements.signingCheckbox.parentElement.style.opacity = '1';

            // Reset checkbox label and hide status badge
            if (checkboxLabel) checkboxLabel.textContent = 'Saya setuju menandatangani formulir ini';
            if (statusBadge) statusBadge.classList.add('hidden');
            if (statusText) statusText.classList.remove('status-completed', 'status-pending');

            // Hide form status info
            if (formStatusInfo) formStatusInfo.classList.add('hidden');
        }

        // Force re-render checklist if it exists
        if (state.formInitialized) {
            setTimeout(() => {
                renderChecklistTable();
            }, 100);
        }
    }

    // Modal functions
    function showSignatureModal() {
        elements.signatureModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Force center positioning
        setTimeout(() => {
            elements.signatureModal.style.display = 'flex';
            elements.signatureModal.style.alignItems = 'center';
            elements.signatureModal.style.justifyContent = 'center';
        }, 10);
    }

    function hideSignatureModal() {
        elements.signatureModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        elements.signatureModal.style.display = '';
    }

    function showSuccessSignatureModal() {
        elements.successSignatureModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Force center positioning
        setTimeout(() => {
            elements.successSignatureModal.style.display = 'flex';
            elements.successSignatureModal.style.alignItems = 'center';
            elements.successSignatureModal.style.justifyContent = 'center';
        }, 10);
    }

    function hideSuccessSignatureModal() {
        elements.successSignatureModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        elements.successSignatureModal.style.display = '';
    }

    // Load asesi data from API
    async function loadAsesiData() {
        try {
            showMessage('loading', 'Memuat data asesi...', 0);

            const response = await fetch(`${config.baseUrl}/asesor/asesis/${state.asesorId}`, {
                method: 'GET',
                headers: config.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success && result.data) {
                state.asesiData = result.data.asesis || [];
                // Load progress for each asesi
                await loadAsesiProgress(state.asesiData);
                renderAsesiTable();
                showMessage('success', 'Data asesi berhasil dimuat', 3000);
            } else {
                document.querySelector('#daftarKonsul tbody').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
                showMessage('error', `Gagal memuat data: ${result.message || 'Terjadi kesalahan'}`);
            }
        } catch (error) {
            document.querySelector('#daftarKonsul tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
            showMessage('error', `Error memuat data: ${error.message}`);
        }
    }

    // Load progress for each asesi
    async function loadAsesiProgress(asesisData) {
        try {
            // Load progress for each asesi
            const asesisWithProgress = await Promise.all(
                asesisData.map(async (asesi) => {
                    try {
                        const progressResponse = await fetch(`${config.baseUrl}/asesor/progressAsesi/${asesi.id_asesi}`, {
                            method: 'GET',
                            headers: config.headers
                        });

                        if (progressResponse.ok) {
                            const progressResult = await progressResponse.json();
                            if (progressResult.success && progressResult.data) {
                                asesi.progress_data = progressResult.data;
                                asesi.konsultasi_pra_uji_completed = progressResult.data.progress_asesmen?.konsultasi_pra_uji?.completed || false;
                                asesi.konsultasi_pra_uji_completed_at = progressResult.data.progress_asesmen?.konsultasi_pra_uji?.completed_at || null;
                                asesi.progress_percentage = progressResult.data.progress_summary?.progress_percentage || 0;
                                asesi.completed_steps = progressResult.data.progress_summary?.completed_steps || 0;
                                asesi.total_steps = progressResult.data.progress_summary?.total_steps || 0;
                            } else {
                                asesi.konsultasi_pra_uji_completed = false;
                                asesi.konsultasi_pra_uji_completed_at = null;
                                asesi.progress_percentage = 0;
                                asesi.completed_steps = 0;
                                asesi.total_steps = 0;
                            }
                        } else {
                            asesi.konsultasi_pra_uji_completed = false;
                            asesi.konsultasi_pra_uji_completed_at = null;
                            asesi.progress_percentage = 0;
                            asesi.completed_steps = 0;
                            asesi.total_steps = 0;
                        }
                    } catch (error) {
                        asesi.konsultasi_pra_uji_completed = false;
                        asesi.konsultasi_pra_uji_completed_at = null;
                        asesi.progress_percentage = 0;
                        asesi.completed_steps = 0;
                        asesi.total_steps = 0;
                    }
                    return asesi;
                })
            );

            // Update state with progress data
            state.asesiData = asesisWithProgress;
        } catch (error) {
            showMessage('error', `Error memuat progress asesi: ${error.message}`);
        }
    }

    // Render asesi table with search and filter
    function renderAsesiTable() {
        const tableBody = document.querySelector('#daftarKonsul tbody');
        if (!tableBody) return;

        if (state.asesiData.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                </tr>
            `;
            return;
        }

        // Filter data based on search term
        const filteredData = state.asesiData.filter(asesi => {
            if (!state.searchTerm) return true;

            const searchTerm = state.searchTerm.toLowerCase();
            return (
                (asesi.nama_asesi || '').toLowerCase().includes(searchTerm) ||
                (asesi.nama_skema || '').toLowerCase().includes(searchTerm) ||
                (asesi.nomor_skema || '').toLowerCase().includes(searchTerm)
            );
        });

        if (filteredData.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data yang sesuai dengan pencarian</td>
                </tr>
            `;
            return;
        }

        let tableContent = '';
        filteredData.forEach((asesi, index) => {
            // Use the konsultasi_pra_uji completion status from progress API
            const hasProgress = asesi.konsultasi_pra_uji_completed === true;
            const progressPercent = asesi.progress_percentage || 0;
            const completedSteps = asesi.completed_steps || 0;
            const totalSteps = asesi.total_steps || 0;

            // Select appropriate icon based on konsultasi_pra_uji completion
            const statusIcon = hasProgress
                ? `<svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>`
                : `<svg class="w-6 h-6 text-logout" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                </svg>`;

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
                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_asesi || 'N/A'}</td>
                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_skema || 'N/A'}</td>
                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nomor_skema || 'N/A'}</td>
                    <td class="flex px-4 py-3 justify-center items-center">
                        ${statusIcon}
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = tableContent;
    }

    // Load consultation data with proper field name handling
    async function loadConsultationData(asesiId) {
        try {
            showMessage('loading', 'Memuat data konsultasi pra uji...', 0);

            const response = await fetch(`${config.baseUrl}/asesmen/konsultasi-prauji/${asesiId}`, {
                method: 'GET',
                headers: config.headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success' && result.data) {
                state.consultationData = result.data;
                state.checklist = result.data.konsultasi_pra_uji.jawaban_checklist || state.checklist;

                // Get record existence info
                state.recordExists = result.data.record_exists || false;

                // Determine signature status from API - FIXED FIELD NAMES
                const konsultasiPraUji = result.data.konsultasi_pra_uji;

                // Check both possible field names for backward compatibility
                const asesorSignature = konsultasiPraUji.ttd_asesor || konsultasiPraUji.tanda_tangan_asesor;
                const asesorWaktu = konsultasiPraUji.waktu_ttd_asesor || konsultasiPraUji.waktu_tanda_tangan_asesor;

                // Check if asesor has signed - ENHANCED VALIDATION
                const hasAsesorTtd = !!(asesorSignature && asesorSignature !== "null");
                const hasAsesorWaktu = !!(asesorWaktu && asesorWaktu !== "null");
                const isAsesorSigning = konsultasiPraUji.is_asesor_signing === true || konsultasiPraUji.is_asesor_signing === 1;
                const isFullySigned = hasAsesorTtd && hasAsesorWaktu && state.recordExists;

                // UPDATE STATE BASED ON API DATA
                state.isAsesorSigned = isFullySigned;
                state.isFormCompleted = isFullySigned;

                // Render form with proper state
                renderConsultationForm(result.data);
                showMessage('success', 'Data konsultasi pra uji berhasil dimuat', 3000);

            } else {
                showMessage('error', `Gagal memuat data konsultasi pra uji: ${result.message || 'Terjadi kesalahan'}`);
            }
        } catch (error) {
            showMessage('error', `Error memuat data konsultasi pra uji: ${error.message}`);
        }
    }

    // Render consultation form with state-driven approach
    function renderConsultationForm(data) {
        if (!data) return;

        const generalInfo = data.general_info;
        const konsultasiPraUji = data.konsultasi_pra_uji;

        // Set form values
        if (generalInfo) {
            elements.judulSertifikasi.textContent = generalInfo.skema?.nama_skema || 'N/A';
            elements.nomorSertifikasi.textContent = generalInfo.skema?.nomor_skema || 'N/A';
            elements.namaAsesor.textContent = generalInfo.nama_asesor || 'N/A';
            elements.namaAsesorTTD.textContent = generalInfo.nama_asesor || 'N/A';
            elements.namaAsesiTTD.textContent = generalInfo.nama_asesi || 'N/A';
            elements.tuk.textContent = konsultasiPraUji.tempat_uji || 'N/A';

            // Format and set tanggal asesmen
            elements.tanggalAsesmen.textContent = formatDate(konsultasiPraUji.tanggal_asesmen_disepakati) || 'N/A';
        }

        // Render unit kompetensi table
        if (generalInfo && generalInfo.unit_kompetensi) {
            renderUnitKompetensiTable(generalInfo.unit_kompetensi);
        }

        // Set today's date
        setTodayDate();

        // Handle signatures and set form state
        handleSignatures(konsultasiPraUji);

        // Render checklist AFTER handling signatures (so state is correct)
        renderChecklistTable();

        // Mark form as initialized
        state.formInitialized = true;
    }

    // Handle signatures with proper field name handling
    function handleSignatures(konsultasiPraUji) {
        // Handle Asesi Signature - check both possible field names
        const asesiSignature = konsultasiPraUji.ttd_asesi || konsultasiPraUji.tanda_tangan_asesi;
        const asesiWaktu = konsultasiPraUji.waktu_ttd_asesi || konsultasiPraUji.waktu_tanda_tangan_asesi;

        if (asesiSignature) {
            const signatureUrl = asesiSignature.startsWith('http')
                ? asesiSignature
                : `{{ url('') }}${asesiSignature}`;

            elements.asesiSignatureImage.src = signatureUrl;
            elements.asesiSignatureContent.classList.add('hidden');
            elements.asesiSignaturePreview.classList.remove('hidden');

            if (asesiWaktu) {
                elements.tanggalTandaTanganAsesi.textContent = `Tanggal: ${formatDate(asesiWaktu)}`;
            }
        } else {
            // Show placeholder for asesi signature
            elements.asesiSignatureContent.classList.remove('hidden');
            elements.asesiSignaturePreview.classList.add('hidden');
        }

        // Handle Asesor Signature with detailed checks - FIXED FIELD NAMES
        const asesorSignature = konsultasiPraUji.ttd_asesor || konsultasiPraUji.tanda_tangan_asesor;
        const asesorWaktu = konsultasiPraUji.waktu_ttd_asesor || konsultasiPraUji.waktu_tanda_tangan_asesor;

        const hasAsesorTtd = !!(asesorSignature && asesorSignature !== "null");
        const hasAsesorWaktu = !!(asesorWaktu && asesorWaktu !== "null");
        const isAsesorSigning = konsultasiPraUji.is_asesor_signing === true || konsultasiPraUji.is_asesor_signing === 1;
        const hasAsesorSignature = hasAsesorTtd && hasAsesorWaktu && state.recordExists;

        if (hasAsesorSignature) {
            // Show existing asesor signature
            const signatureUrl = asesorSignature.startsWith('http')
                ? asesorSignature
                : `{{ url('') }}${asesorSignature}`;

            elements.tandaTanganAsesor.src = signatureUrl;
            elements.asesorSignatureContent.classList.add('hidden');
            elements.asesorSignaturePreview.classList.remove('hidden');
            elements.tandaTanganAsesor.style.opacity = '1';

            // Set timestamp
            elements.tanggalTandaTanganAsesor.textContent = `Tanggal: ${formatDate(asesorWaktu)}`;

            // Update state and apply lock
            state.isAsesorSigned = true;
            state.isFormCompleted = true;
            applyFormLock(true, 'Asesor has signed');

        } else {
            // Show preview from biodata if available
            if (state.asesorSignatureUrl) {
                elements.tandaTanganAsesor.src = state.asesorSignatureUrl;
                elements.asesorSignatureContent.classList.add('hidden');
                elements.asesorSignaturePreview.classList.remove('hidden');
                elements.tandaTanganAsesor.style.opacity = '0.5';
                elements.tanggalTandaTanganAsesor.textContent = 'Tanggal: -';
            } else {
                elements.asesorSignatureContent.classList.remove('hidden');
                elements.asesorSignaturePreview.classList.add('hidden');
            }

            // Update state and remove lock
            state.isAsesorSigned = false;
            state.isFormCompleted = false;
            applyFormLock(false, 'Asesor has not signed');
        }
    }

    // Render unit kompetensi table
    function renderUnitKompetensiTable(unitKompetensiList) {
        if (!unitKompetensiList || unitKompetensiList.length === 0) {
            elements.unitKompetensiTable.innerHTML = `
                <tr>
                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">Tidak ada data unit kompetensi</td>
                </tr>
            `;
            return;
        }

        let tableContent = '';
        unitKompetensiList.forEach((uk, index) => {
            tableContent += `
                <tr>
                    <td class="px-4 py-3 text-sm text-black">${index + 1}</td>
                    <td class="px-4 py-3 text-black text-left">${uk.kode_uk || 'N/A'}</td>
                    <td class="px-4 py-3 text-black text-left">${uk.nama_uk || 'N/A'}</td>
                </tr>
            `;
        });

        elements.unitKompetensiTable.innerHTML = tableContent;
    }

    // Render checklist with visual state indicators
    function renderChecklistTable() {
        const checklistItems = [
            {
                id: 'point_1',
                text: 'Pembukaan : Salam, menyampaikan tujuan pertemuan hari ini.<ul class="list-disc pl-5"><li>Memperkenalkan diri</li><li>Menanyakan nama dan asal peserta</li><li>Percakapan sederhana (Informal)</li><li>Menjelaskan maksud dilaksanakannya konsultasi pra asesmen</li></ul>'
            },
            {
                id: 'point_2',
                text: 'Proses asesmen dilaksanakan berdasarkan bukti atau evidence.'
            },
            {
                id: 'point_3',
                text: 'Kualifikasi Asesor, SKM (Skema Sertifikasi) yang akan diassesmenkan, Lembaga Sertifikasi Profesi Okupasi Pemandu Museum, Kementerian Pendidikan dan Kebudayaan.'
            },
            {
                id: 'point_4',
                text: 'Unit Kompetensi yang akan diujikan seperti tertera pada halaman depan.'
            },
            {
                id: 'point_5',
                text: 'Aturan bukti (valid, asli, terkini, dan memadai) yang perlu dikumpulkan oleh peserta.'
            },
            {
                id: 'point_6',
                text: 'Proses asesmen mencakup : <ul class="list-disc pl-5"><li>Mengumpulkan bukti (portofolio dan asesmen dari bank soal, simulasi/demonstrasi/praktek), bila memerlukan klarifikasi, asesor melakukan wawancara dan observasi langsung.</li></ul>'
            },
            {
                id: 'point_7',
                text: 'Sumber daya asesmen yang akan digunakan termasuk : Pertanyaan lisan, tes tertulis, simulasi tugas, dan praktek.'
            },
            {
                id: 'point_8',
                text: 'Formulir yang digunakan adalah : <ul class="list-disc pl-5"><li>APL-01 : Formulir Permohonan Sertifikasi Kompetensi</li><li>APL-02 : Formulir Asesmen Mandiri</li><li>FR.AK-01 : Formulir Persetujuan Asesmen dan Kerahasiaan</li><li>FR.MAPA-01 : Merencanakan Aktifitas & Proses Asesmen</li><li>FR.MAPA-02 : Formulir Peta Instrumen Asesmen Hasil Pendekatan Asesmen & Perencanaan Asesmen</li><li>FR.IA-01 : Formulir Ceklis Observasi (langsung/tidak langsung)</li><li>FR.IA-04 : Pertanyaan Untuk Mendukung Observasi</li><li>FR.IA-05 : Formulir Pertanyaan Tertulis</li><li>FR.IA-07 : Formulir Penilaian Praktek Simulasi</li><li>FR.AK-02 : Formulir Banding Asesmen</li><li>FR.AK-03 : Formulir Umpan Balik dari Asesi</li><li>FR.AK-04 : Keputusan & Umpan Balik Asesmen</li></ul>'
            },
            {
                id: 'point_9',
                text: 'Perencanaan Asesmen dan Kegiatan Pengembangan.'
            }
        ];

        let tableContent = '';
        checklistItems.forEach((item, index) => {
            const jawaban = state.checklist[item.id]?.jawaban_asesor || null;

            // Determine disabled status and visual styling
            const isDisabled = state.isFormLocked || state.isAsesorSigned;
            const rowClass = isDisabled ? 'checklist-disabled' : '';
            const disabledAttr = isDisabled ? 'disabled' : '';

            // Add visual indicator for completed items
            const completionIndicator = jawaban && isDisabled
                ? `<span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    ${jawaban}
                   </span>`
                : '';

            tableContent += `
                <tr class="${rowClass}">
                    <td class="px-4 py-3 text-sm text-black text-center font-medium">${index + 1}</td>
                    <td class="px-4 py-3 text-black text-left">
                        ${item.text}
                        ${completionIndicator}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center">
                            <div class="w-full">
                                <div class="radio-option">
                                    <input type="radio" id="${item.id}_ya" name="${item.id}" value="Ya" ${jawaban === 'Ya' ? 'checked' : ''} ${disabledAttr} class="transition-all duration-200">
                                    <label for="${item.id}_ya" class="text-sm text-sidebar_font transition-all duration-200">Ya</label>
                                    ${jawaban === 'Ya' && isDisabled ? '<span class="ml-2 text-green-600">✓</span>' : ''}
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="${item.id}_tidak" name="${item.id}" value="Tidak" ${jawaban === 'Tidak' ? 'checked' : ''} ${disabledAttr} class="transition-all duration-200">
                                    <label for="${item.id}_tidak" class="text-sm text-sidebar_font transition-all duration-200">Tidak</label>
                                    ${jawaban === 'Tidak' && isDisabled ? '<span class="ml-2 text-red-600">✗</span>' : ''}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });

        elements.checklistTableBody.innerHTML = tableContent;
    }

    // Handle checkbox with strict validation
    function handleSigningCheckbox(checkbox) {
        // FORCE CHECKBOX STATE BASED ON SIGNATURE STATUS
        if (state.isAsesorSigned || state.isFormLocked) {
            checkbox.checked = true;
            checkbox.disabled = true;
            return;
        }

        if (state.isSubmitting) {
            checkbox.checked = !checkbox.checked;
            return;
        }

        if (checkbox.checked) {
            showSignatureModal();
        }
    }

    // Setup event listeners
    function setupEventListeners() {
        // Search functionality
        const searchInput = document.getElementById('default-search');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                state.searchTerm = this.value.trim().toLowerCase();
                renderAsesiTable();
            });
        }

        // Form submission with strict validation
        if (elements.consultationForm) {
            elements.consultationForm.addEventListener('submit', function(event) {
                event.preventDefault();

                if (state.isAsesorSigned || state.isFormLocked) {
                    showMessage('error', 'Formulir sudah ditandatangani dan tidak dapat diubah');
                    return;
                }

                if (!elements.signingCheckbox.checked) {
                    showMessage('error', 'Silakan setujui untuk menandatangani formulir');
                    return;
                }

                showSignatureModal();
            });
        }

        // Back button
        if (elements.backButton) {
            elements.backButton.addEventListener('click', function() {
                // Reset state when going back
                state.currentAsesiId = null;
                state.isFormCompleted = false;
                state.isFormLocked = false;
                state.isAsesorSigned = false;
                state.formInitialized = false;
                state.recordExists = false;

                // Hide detail view
                elements.detailView.classList.add('hidden');
                elements.breadcrumbs.classList.add('hidden');

                // Show list view
                elements.searchForm.classList.remove('hidden');
                elements.asesiTable.classList.remove('hidden');
            });
        }

        // Signing checkbox with strict control
        if (elements.signingCheckbox) {
            elements.signingCheckbox.addEventListener('change', function() {
                handleSigningCheckbox(this);
            });

            // Also handle click events to prevent bypassing change event
            elements.signingCheckbox.addEventListener('click', function(e) {
                if (state.isAsesorSigned || state.isFormLocked) {
                    e.preventDefault();
                    this.checked = true;
                }
            });
        }

        // Modal event listeners
        if (elements.cancelSignature) {
            elements.cancelSignature.addEventListener('click', function() {
                hideSignatureModal();

                if (!state.isAsesorSigned && !state.isFormLocked) {
                    elements.signingCheckbox.checked = false;
                    elements.signingCheckbox.disabled = false;

                    if (elements.submitButton.textContent !== 'Sudah Disetujui') {
                        elements.submitButton.disabled = false;
                        elements.submitButton.innerHTML = 'Saya Menyetujui';
                    }
                }

                state.isSubmitting = false;
            });
        }

        if (elements.confirmSignature) {
            elements.confirmSignature.addEventListener('click', async function() {
                await processSignature();
            });
        }

        if (elements.closeSuccessSignatureModal) {
            elements.closeSuccessSignatureModal.addEventListener('click', function() {
                hideSuccessSignatureModal();
            });
        }

        // Close modal when clicking outside
        if (elements.signatureModal) {
            elements.signatureModal.addEventListener('click', function(e) {
                if (e.target === elements.signatureModal) {
                    elements.cancelSignature.click();
                }
            });
        }

        if (elements.successSignatureModal) {
            elements.successSignatureModal.addEventListener('click', function(e) {
                if (e.target === elements.successSignatureModal) {
                    elements.closeSuccessSignatureModal.click();
                }
            });
        }

        // Escape key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!elements.signatureModal.classList.contains('hidden')) {
                    elements.cancelSignature.click();
                }
                if (!elements.successSignatureModal.classList.contains('hidden')) {
                    elements.closeSuccessSignatureModal.click();
                }
            }
        });
    }

    // Process signature with better loading states
    async function processSignature() {
        if (state.isSubmitting || state.isAsesorSigned || state.isFormLocked) {
            return;
        }

        try {
            state.isSubmitting = true;

            // Update confirm button state
            elements.confirmSignature.disabled = true;
            elements.confirmSignatureText.textContent = 'Menandatangani...';
            elements.confirmSignatureLoading.classList.remove('hidden');

            // Update submit button with loading state
            const buttonText = document.getElementById('buttonText');
            elements.submitButton.disabled = true;
            elements.submitButton.classList.add('btn-loading');
            if (buttonText) {
                buttonText.innerHTML = `
                    <span class="loading-spinner mr-2"></span>
                    <span>Menyimpan...</span>
                `;
            }

            // Process the signature by submitting the form
            await submitFormData();

        } catch (error) {
            // Reset states only if not completed
            if (!state.isAsesorSigned && !state.isFormLocked) {
                elements.signingCheckbox.checked = false;
                elements.signingCheckbox.disabled = false;

                // Reset submit button
                elements.submitButton.disabled = false;
                elements.submitButton.classList.remove('btn-loading');
                const buttonText = document.getElementById('buttonText');
                if (buttonText) buttonText.textContent = 'Saya Menyetujui';
            }

            // Hide modal and show error
            hideSignatureModal();
            showMessage('error', 'Gagal memproses tanda tangan: ' + error.message);
        } finally {
            // Reset confirm button state
            elements.confirmSignature.disabled = false;
            elements.confirmSignatureText.textContent = 'Ya, Tandatangani';
            elements.confirmSignatureLoading.classList.add('hidden');

            state.isSubmitting = false;
        }
    }

    // Submit form data with permanent locking
    async function submitFormData() {
        if (!state.currentAsesiId) {
            throw new Error('ID Asesi tidak ditemukan');
        }

        // Check if asesor has signature
        if (!state.asesorSignatureUrl) {
            throw new Error('Anda belum memiliki tanda tangan di biodata. Silakan upload tanda tangan di halaman biodata terlebih dahulu.');
        }

        // Collect form data
        const formData = {
            id_asesi: state.currentAsesiId,
            id_asesor: state.asesorId,
            jawaban_checklist: {},
            is_asesor_signing: elements.signingCheckbox.checked
        };

        // Get all the checklist answers
        for (let i = 1; i <= 9; i++) {
            const pointId = `point_${i}`;
            const selectedRadio = document.querySelector(`input[name="${pointId}"]:checked`);

            if (selectedRadio) {
                formData.jawaban_checklist[pointId] = {
                    jawaban_asesor: selectedRadio.value
                };
            } else {
                throw new Error(`Silakan pilih jawaban untuk poin ${i}`);
            }
        }

        showMessage('loading', 'Menyimpan data konsultasi pra uji...', 0);

        const response = await fetch(`${config.baseUrl}/asesmen/konsultasi-prauji/asesor/save`, {
            method: 'POST',
            headers: config.headers,
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            // IMMEDIATELY UPDATE STATE TO PREVENT ANY FURTHER CHANGES
            state.isAsesorSigned = true;
            state.isFormCompleted = true;
            state.recordExists = true; // Mark as record exists after successful save

            // APPLY PERMANENT LOCK
            applyFormLock(true, 'Form submitted successfully');

            showMessage('success', 'Data konsultasi pra uji berhasil disimpan');

            // Hide signature modal and show success modal
            hideSignatureModal();
            showSuccessSignatureModal();

            // Update signature display
            if (state.asesorSignatureUrl) {
                elements.tandaTanganAsesor.src = state.asesorSignatureUrl;
                elements.tandaTanganAsesor.style.opacity = '1';
                elements.asesorSignatureContent.classList.add('hidden');
                elements.asesorSignaturePreview.classList.remove('hidden');

                // Update date
                const today = new Date();
                elements.tanggalTandaTanganAsesor.textContent = `Tanggal: ${formatDate(today.toISOString().split('T')[0])}`;
            }

            // Reload the consultation data after delay
            setTimeout(() => {
                loadConsultationData(state.currentAsesiId);
                loadAsesiData();
            }, 1500);

        } else {
            throw new Error(result.message || 'Terjadi kesalahan');
        }
    }

    // Initialize
    function init() {
        // Load initial data
        loadAsesiData();
        loadAsesorSignature();

        // Setup event listeners
        setupEventListeners();
    }

    // Start the application
    init();

    // Enhanced showSummary function
    window.showSummary = function(asesiId, asesiName, skemaName, progressPercent, completedSteps, totalSteps, konsultasiPraUjiCompleted = false) {
        // Set current asesi ID
        state.currentAsesiId = asesiId;

        // Update breadcrumb
        elements.breadcrumbAsesiName.textContent = asesiName || 'Detail Konsultasi';

        // Hide list view
        elements.searchForm.classList.add('hidden');
        elements.asesiTable.classList.add('hidden');

        // Show detail view
        elements.breadcrumbs.classList.remove('hidden');
        elements.detailView.classList.remove('hidden');

        // Load consultation data - this will set the proper form state from API
        loadConsultationData(asesiId);

        // Scroll to detail
        elements.detailView.scrollIntoView({ behavior: 'smooth' });
    };

    // Alias for compatibility
    window.showDocument = window.showSummary;
});

// Table sorting function (global for onclick handler)
function sortTable(columnIndex) {
    const table = document.getElementById('daftarKonsul');
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
