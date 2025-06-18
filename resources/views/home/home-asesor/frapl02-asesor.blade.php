@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.APL.02 - Asesor')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mb-4 ms-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" />
                    <stop offset="100%" stop-color="#8B5CF6" />
                </linearGradient>
            </defs>
            <path
                d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
            />
        </svg>
        <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Ajukan Permohonan Langsung 02</p>
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
                        <a href="{{ route('frapl02-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.APL.02
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span id="breadcrumbNamaAsesi" class="ms-1 text-sm font-medium text-black">Loading...</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span>Memuat data APL02...</span>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="errorText">Terjadi kesalahan saat memuat data.</span>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="successText">Data berhasil disimpan.</span>
    </div>
    <div id="frameAPL02" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir APL.02 Asesmen Mandiri</p>

        <!-- Search Form -->
        <form id="searchAPL02" class="max-w-md mb-4 rounded-xl">
            <div class="relative">
            <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Nama Peserta" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto shadow-md rounded-lg">
            <table id="daftarAPL02" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Aksi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Tanggal Input</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(6)">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Memuat data asesi...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="detailAPL02" class="hidden pt-0 p-4 text-black">
            <!-- Loading indicator -->
            <div id="loadingIndicator" class="hidden text-center py-8">
                <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-blue-500 transition ease-in-out duration-150">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memuat data APL02...
                </div>
            </div>

            <!-- Alert messages -->
            <div id="alertMessages" class="mb-4 hidden"></div>

            <!-- Input Formulir APL.02 -->
            <div id="FRAPL02" class="pt-0 p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                            Loading...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                            Loading...
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                            Loading...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                            Loading...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                            Loading...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Metode Uji -->
            <div id="metodeUji" class="p-4">
                <label for="inputMetodeUji" class="block mb-2 font-medium text-sidebar_font">Metode Uji
                    <span class="text-red-500">*</span>
                </label>
                <div class="mt-2">
                    <select id="inputMetodeUji" name="metodeUji" autocomplete="metodeUji" class="w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                        <option value="" disabled selected>Pilih Metode Uji</option>
                        <option value="Observasi dan Wawancara">Observasi dan Wawancara</option>
                        <option value="Portofolio">Portofolio</option>
                    </select>
                </div>
            </div>

            <!-- Dynamic Kompetensi Tables -->
            <div id="dynamicKompetensiTables" class="p-4">
                <!-- Tables will be generated dynamically -->
            </div>

            <!-- Hasil Kompetensi -->
            <div class="p-4 mb-6">
                <label for="inputHasilAPL02" class="block mb-2 font-medium text-sidebar_font">Hasil Kompetensi</label>
                <input type="text" id="inputHasilAPL02" class="block p-2.5 w-full text-sm text-sidebar_font rounded-lg border border-border_input focus:ring-biru focus:border-biru bg-gray-100" value="(Otomatis berdasarkan penilaian)" readonly>
            </div>

            <!-- Rekomendasi -->
            <div class="p-4 mb-6">
                <label for="rekomendasi" class="block mb-2 font-medium text-sidebar_font">Rekomendasi
                    <span class="text-red-500">*</span>
                </label>
                <textarea id="rekomendasi" rows="4" class="block p-2.5 w-full text-sm text-sidebar_font rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Masukkan Rekomendasi Anda"></textarea>
            </div>

            <!-- Tanda Tangan Section -->
            <div id="tandaTanganSection" class="p-4 mb-6">
                <label class="block mb-2 font-medium text-sidebar_font">Tanda Tangan</label>
                <div class="flex flex-row justify-evenly gap-6">
                    <!-- Tanda Tangan Asesi (Read-only) -->
                    <div class="flex flex-col items-center justify-center w-1/2">
                        <p id="tanggalTtdAsesi" class="font-medium text-sidebar_font mb-2">-</p>

                        <!-- Signature display for asesi -->
                        <div id="asesiSignatureDisplay" class="w-60 h-40 border border-border_input rounded-lg flex items-center justify-center bg-gray-50">
                            <img id="tandaTanganAsesi" src="" alt="Tanda Tangan Asesi" class="max-w-full max-h-full rounded hidden">
                            <span id="noTtdAsesi" class="text-gray-400 text-center px-4">Menunggu tanda tangan dari asesi</span>
                        </div>

                        <p class="font-medium text-sidebar_font mt-2">Asesi</p>
                        <p id="namaAsesiTtd" class="font-normal text-sidebar_font">-</p>
                    </div>

                    <!-- Tanda Tangan Asesor -->
                    <div class="flex flex-col items-center justify-center w-1/2">
                        <p id="tanggalTtdAsesor" class="font-medium text-sidebar_font mb-2">-</p>

                        <!-- Existing signature display -->
                        <div id="asesorExistingSignature" class="w-60 h-40 border border-border_input rounded-lg items-center justify-center bg-gray-50 hidden">
                            <img id="tandaTanganAsesorExisting" src="" alt="Tanda Tangan Asesor" class="max-w-full max-h-full rounded">
                        </div>

                        <!-- Upload area for asesor signature -->
                        <div id="asesor-signature-upload-area" class="w-60 h-40 flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input cursor-pointer hover:border-biru transition-colors upload-area bg-white">
                            <div class="text-center" id="asesor-signature-content">
                                <svg class="mx-auto h-8 w-8 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                </svg>
                                <div class="mt-2 flex text-xs leading-5 text-gray-600 justify-center">
                                    <span class="font-semibold text-biru">Upload tanda tangan</span>
                                </div>
                                <p class="text-xs leading-4 text-gray-500">PNG, JPG, JPEG maks 2MB</p>
                            </div>
                            <!-- Preview Image -->
                            <div id="asesor-signature-preview" class="hidden text-center">
                                <img id="asesor-signature-image" src="" alt="Preview Tanda Tangan Asesor" class="max-h-36 w-auto rounded mx-auto">
                                <div class="mt-2 text-center">
                                    <button type="button" id="remove-asesor-signature" class="text-red-500 text-xs hover:text-red-700">
                                        Hapus tanda tangan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Button to use existing signature or clear existing -->
                        <div id="asesorSignatureButtons" class="mt-2 text-center hidden">
                            <button type="button" id="hapus-ttd-existing" class="text-red-500 text-xs hover:text-red-700 mr-4">
                                Hapus & Upload Baru
                            </button>
                        </div>

                        <input type="file" id="file_tanda_tangan_asesor" class="hidden" accept="image/png,image/jpeg,image/jpg">

                        <p class="font-medium text-sidebar_font mt-2">Asesor</p>
                        <p id="namaAsesorTtd" class="font-normal text-sidebar_font">-</p>
                    </div>
                </div>
            </div>

            <!-- Button Actions -->
            <div class="flex justify-end space-x-4 pe-4">
                <button id="simpanDraft" type="button" class="inline-flex justify-center rounded-md bg-gray-500 text-white px-6 py-2 text-sm/6 font-medium hover:bg-gray-600 focus:outline-none">
                    Simpan Draft
                </button>
                <button id="simpanDanTandaTangan" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none">
                    Simpan dan Tandatangani
                </button>
            </div>

            <!-- Back button -->
            <div class="flex justify-start mt-6">
                <button id="kembaliKeList" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-biru bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </button>
            </div>
        </div>
    </div>
    <!-- Notification Modal -->
    <div id="notificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="notificationIcon" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Icon will be inserted dynamically -->
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="notificationTitle">Notification</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="notificationMessage">Message goes here</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="notificationCloseBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="confirmationTitle">Konfirmasi</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="confirmationMessage">Apakah Anda yakin?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmYesBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-biru to-ungu text-base font-medium text-white hover:bg-biru_soft focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Ya
                    </button>
                    <button type="button" id="confirmNoBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[80%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<!-- CSS untuk Upload Area -->
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

#asesor-signature-preview img {
    max-width: 100%;
    height: auto;
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    background: white;
    padding: 4px;
}

#asesiSignatureDisplay img,
#asesorExistingSignature img {
    box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const apiKey = "{{ env('API_KEY') }}";
    const asesorId = @json(Auth::user()->asesor->id_asesor ?? null);

    // Global variables
    let currentAsesiId = null;
    let currentApl02Data = null;
    let kompetensiData = [];
    let asesorSignatureUpload = null;
    let asesiProgressData = {}; // Store progress data for each asesi

    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // API Headers
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiKey,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken || '',
        'X-Requested-With': 'XMLHttpRequest'
    };

    // Check if asesor ID exists
    if (!asesorId) {
        console.error('No asesor ID found for the authenticated user');
        document.querySelector('#daftarAPL02 tbody').innerHTML = `
            <tr>
                <td colspan="7" class="px-4 py-3 text-center text-gray-500">User tidak teridentifikasi, silahkan login kembali</td>
            </tr>
        `;
        return;
    }
    // Load data asesi
    async function loadAsesiData() {
        try {
            showMessage('Memuat data asesi...', 'loading', 0);

            const apiUrl = "{{ url('/api/v1/asesor/asesis') }}/" + asesorId;

            const response = await fetch(apiUrl, {
                method: 'GET',
                headers: headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success && result.data) {
                let asesisData = result.data.asesis;

                // Load progress for each asesi
                asesisData = await loadAsesiProgress(asesisData);

                const tableBody = document.querySelector('#daftarAPL02 tbody');

                if (asesisData && asesisData.length > 0) {
                    let tableContent = '';

                    asesisData.forEach((asesi, index) => {
                        // Use the ak01 completion status from progress API
                        const hasProgress = asesi.ak01_completed === true;
                        const progressPercent = asesi.progress_percentage || 0;
                        const completedSteps = asesi.completed_steps || 0;
                        const totalSteps = asesi.total_steps || 0;

                        // Select appropriate icon based on ak01 completion
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
                                        <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                                clip-rule="evenodd" />
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
                    showMessage('Data asesi berhasil dimuat', 'success', 3000);
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                        </tr>
                    `;
                    showMessage('Tidak ada data asesi', 'error');
                }

                // Implementasi pencarian
                const searchInput = document.getElementById('default-search');
                searchInput?.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#daftarAPL02 tbody tr');

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

            } else {
                console.error('API returned success=false or missing data:', result);
                document.querySelector('#daftarAPL02 tbody').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
                showMessage(`Gagal memuat data: ${result.message || 'Terjadi kesalahan'}`, 'error');
            }
        } catch (error) {
            console.error('Error details:', error);
            document.querySelector('#daftarAPL02 tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
            showMessage(`Error memuat data: ${error.message}`, 'error');
        }
    }

    // Function to get progress icon HTML
    function getProgressIcon(isCompleted) {
        if (isCompleted) {
            return `<svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                    </svg>`;
        } else {
            return `<svg class="w-6 h-6 text-logout" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                    </svg>`;
        }
    }

    // Function to fetch progress data for a specific asesi
    function fetchAsesiProgress(asesiId) {
        return fetch(`{{ url('/api/v1/asesor/progressAsesi') }}/${asesiId}`, {
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
            if (result.success && result.data) {
                return result.data.progress_asesmen;
            }
            return null;
        })
        .catch(error => {
            console.error('Error fetching progress for asesi:', asesiId, error);
            return null;
        });
    }

    // Setup signature upload untuk asesor
    function setupAsesorSignatureUpload() {
        const config = {
            inputId: 'file_tanda_tangan_asesor',
            uploadAreaId: 'asesor-signature-upload-area',
            contentId: 'asesor-signature-content',
            previewId: 'asesor-signature-preview',
            imageId: 'asesor-signature-image',
            removeButtonId: 'remove-asesor-signature'
        };

        const input = document.getElementById(config.inputId);
        const uploadArea = document.getElementById(config.uploadAreaId);
        const content = document.getElementById(config.contentId);
        const preview = document.getElementById(config.previewId);
        const image = document.getElementById(config.imageId);
        const removeButton = document.getElementById(config.removeButtonId);

        if (!input || !uploadArea || !content || !preview || !image) {
            console.error('Asesor signature upload elements not found');
            return null;
        }

        // Click handler untuk upload area
        uploadArea.addEventListener('click', function(e) {
            if (e.target !== removeButton && !removeButton?.contains(e.target)) {
                input.click();
            }
        });

        // Drag and drop handlers
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover', 'border-biru', 'bg-blue-50');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover', 'border-biru', 'bg-blue-50');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover', 'border-biru', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelection(files[0]);
            }
        });

        // File input change handler
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFileSelection(file);
            }
        });

        // Remove button handler
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.stopPropagation();
                clearPreview();
            });
        }

        function handleFileSelection(file) {
            // Validate file type
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                showAlert('File harus berformat PNG, JPG, atau JPEG', 'error');
                return;
            }

            // Validate file size (2MB)
            const maxSize = 2 * 1024 * 1024;
            if (file.size > maxSize) {
                showAlert('Ukuran file maksimal 2MB', 'error');
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                content.classList.add('hidden');
                preview.classList.remove('hidden');

                // Update input files
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;

                console.log('Asesor signature preview set');
            };
            reader.onerror = function() {
                showAlert('Gagal membaca file tanda tangan', 'error');
            };
            reader.readAsDataURL(file);
        }

        function clearPreview() {
            image.src = '';
            content.classList.remove('hidden');
            preview.classList.add('hidden');
            input.value = '';
            console.log('Asesor signature preview cleared');
        }

        return {
            clearPreview: clearPreview,
            hasFile: function() {
                return input.files && input.files.length > 0;
            },
            getFile: function() {
                return input.files && input.files.length > 0 ? input.files[0] : null;
            }
        };
    }

    // Initialize asesor signature upload
    asesorSignatureUpload = setupAsesorSignatureUpload();

    // Handle existing signature deletion
    document.getElementById('hapus-ttd-existing')?.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus tanda tangan yang tersimpan dan mengunggah yang baru?')) {
            // Hide existing signature display
            document.getElementById('asesorExistingSignature').classList.add('hidden');
            document.getElementById('asesorSignatureButtons').classList.add('hidden');

            // Show upload area
            document.getElementById('asesor-signature-upload-area').classList.remove('hidden');
        }
    });

    // Utility functions
    function showAlert(message, type = 'info') {
        const alertDiv = document.getElementById('alertMessages');
        const alertClass = {
            'success': 'bg-green-100 border-green-400 text-green-700',
            'error': 'bg-red-100 border-red-400 text-red-700',
            'warning': 'bg-yellow-100 border-yellow-400 text-yellow-700',
            'info': 'bg-blue-100 border-blue-400 text-blue-700'
        };

        alertDiv.innerHTML = `
            <div class="border px-4 py-3 rounded relative ${alertClass[type] || alertClass.info}" role="alert">
                <span class="block sm:inline">${message}</span>
            </div>
        `;
        alertDiv.classList.remove('hidden');

        // Auto hide after 5 seconds
        setTimeout(() => {
            alertDiv.classList.add('hidden');
        }, 5000);
    }

    function showLoading(show = true) {
        const loadingDiv = document.getElementById('loadingIndicator');
        if (show) {
            loadingDiv.classList.remove('hidden');
        } else {
            loadingDiv.classList.add('hidden');
        }
    }

    // Load Asesi List with Progress Data
    function loadAsesiList() {
        const apiUrl = "{{ url('/api/v1/asesor/asesis') }}/" + asesorId;

        fetch(apiUrl, {
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
            if (result.success && result.data) {
                const asesisData = result.data.asesis;
                const tableBody = document.querySelector('#daftarAPL02 tbody');

                if (asesisData && asesisData.length > 0) {
                    // Create promises for fetching progress data for each asesi
                    const progressPromises = asesisData.map(asesi =>
                        fetchAsesiProgress(asesi.id_asesi)
                            .then(progressData => {
                                asesiProgressData[asesi.id_asesi] = progressData;
                                return { asesi, progressData };
                            })
                    );

                    // Wait for all progress data to be fetched
                    Promise.all(progressPromises).then(results => {
                        let tableContent = '';

                        results.forEach(({ asesi, progressData }, index) => {
                            // Check APL02 progress status
                            const apl02Completed = progressData?.apl02?.completed || false;
                            const apl02Date = progressData?.apl02?.completed_at || '';

                            const progressIcon = getProgressIcon(apl02Completed);

                            // Format date for display
                            const formattedDate = apl02Date ?
                                new Date(apl02Date.split(' ')[0].split('-').reverse().join('-')).toLocaleDateString('id-ID') :
                                '-';

                            tableContent += `
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                                    <td class="px-4 py-3 text-center">
                                        <button onclick="loadAPL02Detail('${asesi.id_asesi}')" class="mr-2">
                                            <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button onclick="showDocument('${asesi.id_asesi}', '${asesi.nama_asesi}', '${asesi.nama_skema}', ${asesi.progress_percentage}, ${asesi.completed_steps}, ${asesi.total_steps})" class="">
                                            <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_asesi}</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_skema}</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">${asesi.nomor_skema}</td>
                                    <td class="px-4 py-3 text-gray-700">${formattedDate}</td>
                                    <td class="flex px-4 py-3 justify-center items-center">
                                        ${progressIcon}
                                    </td>
                                </tr>
                            `;
                        });

                        tableBody.innerHTML = tableContent;
                    });
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                        </tr>
                    `;
                }

                // Setup search functionality
                const searchInput = document.getElementById('default-search');
                searchInput.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#daftarAPL02 tbody tr');

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

            } else {
                console.error('API returned success=false or missing data:', result);
                document.querySelector('#daftarAPL02 tbody').innerHTML = `
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error details:', error);
            document.querySelector('#daftarAPL02 tbody').innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
        });
    }

    // Load APL02 Detail
    window.loadAPL02Detail = function(idAsesi) {
        currentAsesiId = idAsesi;
        showLoading(true);

        // Show detail section and hide list
        document.getElementById('searchAPL02').classList.add('hidden');
        document.getElementById('daftarAPL02').classList.add('hidden');
        document.getElementById('breadcrumbs').classList.remove('hidden');
        document.getElementById('detailAPL02').classList.remove('hidden');

        const apiUrl = `{{ url('/api/v1/asesmen/apl02/asesor') }}/${idAsesi}`;

        fetch(apiUrl, {
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
            showLoading(false);

            if (result.status === 'success' && result.data) {
                currentApl02Data = result.data;
                populateAPL02Form(result.data);
            } else {
                showAlert('Gagal memuat data APL02: ' + (result.message || 'Terjadi kesalahan'), 'error');
            }
        })
        .catch(error => {
            showLoading(false);
            console.error('Error loading APL02 detail:', error);
            showAlert('Error memuat data APL02: ' + error.message, 'error');
        });
    };

    // Populate APL02 Form
    function populateAPL02Form(data) {
        const generalInfo = data.general_info;
        const detailSkema = data.detail_skema;
        const detailApl02 = data.detail_apl02;

        // Update breadcrumb
        document.getElementById('breadcrumbNamaAsesi').textContent = generalInfo.nama_asesi;

        // Populate general info
        document.getElementById('judulSertifikasi').textContent = generalInfo.nama_skema;
        document.getElementById('nomorSertifikasi').textContent = generalInfo.nomor_skema;
        document.getElementById('namaPeserta').textContent = generalInfo.nama_asesi;
        document.getElementById('namaAsesor').textContent = generalInfo.nama_asesor;
        document.getElementById('tuk').textContent = generalInfo.nama_tuk;

        // Store kompetensi data globally
        kompetensiData = detailSkema;

        // Generate dynamic tables
        generateKompetensiTables(detailSkema);

        // Populate existing data if record exists
        if (data.record_exists && detailApl02) {
            document.getElementById('inputMetodeUji').value = detailApl02.metode_uji || '';
            document.getElementById('rekomendasi').value = detailApl02.rekomendasi || '';

            // Update signature section
            updateSignatureSection(detailApl02, generalInfo);
        }

        // Update hasil kompetensi automatically
        updateHasilKompetensi();
    }

    // Generate Kompetensi Tables
    function generateKompetensiTables(detailSkema) {
        const container = document.getElementById('dynamicKompetensiTables');
        let tablesHtml = '';

        detailSkema.forEach((unit, unitIndex) => {
            tablesHtml += `
                <div class="mb-6">
                    <p class="text-sidebar_font font-semibold pb-2">No ${unitIndex + 1}. Kode Unit: ${unit.kode_uk}</p>
                    <p class="text-sidebar_font font-medium pb-2">${unit.nama_uk}</p>

                    <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                        <table class="min-w-full bg-white overflow-hidden">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Elemen Kompetensi</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-black text-center">
            `;

            unit.elemen_uk.forEach((elemen, elemenIndex) => {
                const selectId = `kompeten_${unitIndex}_${elemenIndex}`;
                const selectedValue = elemen.kompeten !== null ? (elemen.kompeten ? 'kompeten' : 'tidak_kompeten') : '';

                tablesHtml += `
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">${elemenIndex + 1}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${elemen.nama_elemen}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center">
                                <select id="${selectId}"
                                        data-unit-index="${unitIndex}"
                                        data-elemen-index="${elemenIndex}"
                                        class="kompetensi-select border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru w-40 px-2 py-1 bg-white text-black"
                                        onchange="updateSelectColor(this); updateHasilKompetensi();">
                                    <option value="">Pilih</option>
                                    <option value="kompeten" ${selectedValue === 'kompeten' ? 'selected' : ''}>Kompeten</option>
                                    <option value="tidak_kompeten" ${selectedValue === 'tidak_kompeten' ? 'selected' : ''}>Tidak Kompeten</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                `;
            });

            tablesHtml += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        });

        container.innerHTML = tablesHtml;

        // Update select colors for existing values
        document.querySelectorAll('.kompetensi-select').forEach(select => {
            updateSelectColor(select);
        });
    }

    // Update Select Color
    window.updateSelectColor = function(selectElement) {
        const value = selectElement.value;

        // Reset classes
        selectElement.classList.remove('bg-blue-200', 'text-blue-800', 'bg-red-200', 'text-red-800');

        if (value === 'kompeten') {
            selectElement.classList.add('bg-blue-200', 'text-blue-800');
        } else if (value === 'tidak_kompeten') {
            selectElement.classList.add('bg-red-200', 'text-red-800');
        }
    };

    // Update Hasil Kompetensi automatically
    window.updateHasilKompetensi = function() {
        let totalElemen = 0;
        let kompetenCount = 0;
        let tidakKompetenCount = 0;
        let belumDinilaiCount = 0;

        // Count all elements and their status
        document.querySelectorAll('.kompetensi-select').forEach(select => {
            totalElemen++;
            const value = select.value;
            if (value === 'kompeten') {
                kompetenCount++;
            } else if (value === 'tidak_kompeten') {
                tidakKompetenCount++;
            } else {
                belumDinilaiCount++;
            }
        });

        let hasilText = '';
        if (belumDinilaiCount > 0) {
            hasilText = `${belumDinilaiCount} elemen belum dinilai`;
        } else if (tidakKompetenCount > 0) {
            hasilText = `Tidak Kompeten (${tidakKompetenCount} dari ${totalElemen} elemen tidak kompeten)`;
        } else if (kompetenCount === totalElemen) {
            hasilText = `Lanjutkan Asesmen (Kompeten ${kompetenCount} dari ${totalElemen} elemen kompeten)`;
        } else {
            hasilText = `Dalam proses penilaian`;
        }

        document.getElementById('inputHasilAPL02').value = hasilText;
    };

    // Update Signature Section
    function updateSignatureSection(detailApl02, generalInfo) {
        // Update names
        document.getElementById('namaAsesiTtd').textContent = generalInfo.nama_asesi;
        document.getElementById('namaAsesorTtd').textContent = generalInfo.nama_asesor;
        document.getElementById('tanggalTtdAsesor').textContent = generalInfo.waktu_tanda_tangan_asesor;

        // Update asesor signature
        if (detailApl02.waktu_tanda_tangan_asesor) {
            document.getElementById('tanggalTtdAsesor').textContent = new Date(detailApl02.waktu_tanda_tangan_asesor);
            if (detailApl02.ttd_asesor) {
                // Show existing signature
                document.getElementById('tandaTanganAsesorExisting').src = detailApl02.ttd_asesor;
                document.getElementById('asesorExistingSignature').classList.remove('hidden');
                document.getElementById('asesorSignatureButtons').classList.remove('hidden');
                document.getElementById('asesor-signature-upload-area').classList.add('hidden');
            }
        } else {
            // Show upload area
            document.getElementById('asesorExistingSignature').classList.add('hidden');
            document.getElementById('asesorSignatureButtons').classList.add('hidden');
            document.getElementById('asesor-signature-upload-area').classList.remove('hidden');
        }

        // Update asesi signature
        if (detailApl02.waktu_tanda_tangan_asesi) {
            document.getElementById('tanggalTtdAsesi').textContent = new Date(detailApl02.waktu_tanda_tangan_asesi).toLocaleDateString('id-ID');
            if (detailApl02.ttd_asesi) {
                document.getElementById('tandaTanganAsesi').src = detailApl02.ttd_asesi;
                document.getElementById('tandaTanganAsesi').classList.remove('hidden');
                document.getElementById('noTtdAsesi').textContent = 'Sudah ditandatangani';
                document.getElementById('noTtdAsesi').classList.add('text-green-600');
            }
        } else {
            document.getElementById('noTtdAsesi').textContent = 'Menunggu tanda tangan dari asesi';
            document.getElementById('noTtdAsesi').classList.remove('text-green-600');
        }
    }

    // Collect Kompetensi Data
    function collectKompetensiData() {
        const detailKompetensi = [];

        kompetensiData.forEach((unit, unitIndex) => {
            const unitData = {
                id_uk: unit.id_uk,
                kode_uk: unit.kode_uk,
                nama_uk: unit.nama_uk,
                elemen_uk: []
            };

            unit.elemen_uk.forEach((elemen, elemenIndex) => {
                const selectId = `kompeten_${unitIndex}_${elemenIndex}`;
                const selectElement = document.getElementById(selectId);
                const kompeten = selectElement.value === 'kompeten' ? true :
                                selectElement.value === 'tidak_kompeten' ? false : null;

                unitData.elemen_uk.push({
                    nama_elemen: elemen.nama_elemen,
                    kompeten: kompeten
                });
            });

            detailKompetensi.push(unitData);
        });

        return detailKompetensi;
    }

    // Save APL02
    function saveAPL02(isSigning = false) {
        const metodeUji = document.getElementById('inputMetodeUji').value.trim();
        const rekomendasi = document.getElementById('rekomendasi').value.trim();

        if (!metodeUji) {
            showAlert('Metode uji harus diisi', 'error');
            return;
        }

        if (!rekomendasi) {
            showAlert('Rekomendasi harus diisi', 'error');
            return;
        }

        const detailKompetensi = collectKompetensiData();

        // Check if all kompetensi are assessed when signing
        if (isSigning) {
            let hasUnassessed = false;
            detailKompetensi.forEach(unit => {
                unit.elemen_uk.forEach(elemen => {
                    if (elemen.kompeten === null) {
                        hasUnassessed = true;
                    }
                });
            });

            if (hasUnassessed) {
                showAlert('Semua elemen kompetensi harus dinilai sebelum menandatangani', 'error');
                return;
            }

            // Check if asesor has signature (either uploaded now or existing)
            const hasUploadedSignature = asesorSignatureUpload && asesorSignatureUpload.hasFile();
            const hasExistingSignature = !document.getElementById('asesorExistingSignature').classList.contains('hidden');

            if (!hasUploadedSignature && !hasExistingSignature) {
                showAlert('Anda harus mengunggah tanda tangan atau memiliki tanda tangan tersimpan untuk menandatangani', 'error');
                return;
            }
        }

        // Prepare data for API - Use the correct endpoint format
        const postData = {
            id_asesi: currentAsesiId,
            id_asesor: asesorId,
            rekomendasi: rekomendasi,
            metode_uji: metodeUji,
            detail_kompetensi: detailKompetensi,
            is_signing: isSigning
        };

        const apiUrl = `{{ url('/api/v1/asesmen/apl02/asesor/save') }}`;

        showLoading(true);

        fetch(apiUrl, {
            method: 'POST',
            headers: apiHeaders,
            body: JSON.stringify(postData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            showLoading(false);

            if (result.status === 'success') {
                showAlert(result.message || 'Data APL02 berhasil disimpan', 'success');

                if (isSigning) {
                    // Update signature display
                    document.getElementById('tanggalTtdAsesor').textContent = new Date().toLocaleDateString('id-ID');

                    // Clear upload preview and show existing signature
                    if (asesorSignatureUpload) {
                        asesorSignatureUpload.clearPreview();
                    }
                }

                // Reload the detail to get updated data
                setTimeout(() => {
                    loadAPL02Detail(currentAsesiId);
                }, 1000);

            } else {
                showAlert('Gagal menyimpan data: ' + (result.message || 'Terjadi kesalahan'), 'error');
            }
        })
        .catch(error => {
            showLoading(false);
            console.error('Error saving APL02:', error);
            showAlert('Error menyimpan data: ' + error.message, 'error');
        });
    }

    // Event Listeners
    document.getElementById('simpanDraft').addEventListener('click', function() {
        saveAPL02(false);
    });

    document.getElementById('simpanDanTandaTangan').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menyimpan dan menandatangani APL02 ini?')) {
            saveAPL02(true);
        }
    });

    document.getElementById('kembaliKeList').addEventListener('click', function() {
        // Hide detail section and show list
        document.getElementById('searchAPL02').classList.remove('hidden');
        document.getElementById('daftarAPL02').classList.remove('hidden');
        document.getElementById('breadcrumbs').classList.add('hidden');
        document.getElementById('detailAPL02').classList.add('hidden');

        // Clear current data
        currentAsesiId = null;
        currentApl02Data = null;
        kompetensiData = [];

        // Clear alerts
        document.getElementById('alertMessages').classList.add('hidden');
    });

    // Initialize page
    loadAsesiList();
});

// Table sorting function
function sortTable(columnIndex) {
    const table = document.getElementById('daftarAPL02');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    if (rows.length <= 1 || rows[0].cells.length === 1) return;

    let sortDirection = table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
    let lastSortedColumn = parseInt(table.getAttribute('data-sort-col') || '0');

    if (lastSortedColumn !== columnIndex) {
        sortDirection = 'asc';
    }

    table.setAttribute('data-sort-dir', sortDirection);
    table.setAttribute('data-sort-col', columnIndex);

    rows.sort((a, b) => {
        if (!a.cells[columnIndex] || !b.cells[columnIndex]) return 0;

        const aValue = a.cells[columnIndex].textContent.trim();
        const bValue = b.cells[columnIndex].textContent.trim();

        if (columnIndex === 0) {
            return sortDirection === 'asc'
                ? parseInt(aValue) - parseInt(bValue)
                : parseInt(bValue) - parseInt(aValue);
        }

        return sortDirection === 'asc'
            ? aValue.localeCompare(bValue)
            : bValue.localeCompare(aValue);
    });

    rows.forEach(row => tbody.appendChild(row));

    const headers = table.querySelectorAll('th');
    headers.forEach((header, index) => {
        header.textContent = header.textContent.replace(' ↑', '').replace(' ↓', '');
        if (index === columnIndex) {
            header.textContent += sortDirection === 'asc' ? ' ↑' : ' ↓';
        }
    });
}
</script>

@endsection
