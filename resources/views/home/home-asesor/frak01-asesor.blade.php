@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.AK-01 - Asesor')

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
        <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Asesmen Kompetensi 01</p>
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
                        <a href="{{ route('frak01-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.AK.01
                        </a>
                    </div>
                </li>
                <!-- Memanggil data nama asesi -->
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-black">Muhammad Rifai</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameAK01" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir AK.01 Persetujuan Asesmen & Kerahasiaan</p>
        <!-- Search Form -->
        <form id="searchAK01" class="max-w-md mb-4 rounded-xl">
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
            <table id="daftarAK01" class="min-w-full bg-white overflow-hidden">
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
                        <td class="px-4 py-3 text-sm text-gray-700">1</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="showSummary()" class="">
                                <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button onclick="showDocument()" class="">
                                <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-left">Muhammad Rifai</td>
                        <td class="px-4 py-3 text-gray-700 text-left">Sertifikasi Frontend</td>
                        <td class="px-4 py-3 text-gray-700 text-left">SK1234567890</td>
                        <td class="px-4 py-0">
                            <div class="flex px-4 py-3 justify-center items-center">
                                <svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                                <svg class="w-6 h-6 text-logout" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="detailAK01" class="hidden pt-0 p-4 text-black">
            <p id="descDetail" class="font text-sidebar_font">Persetujuan ini untuk menjamin bahwa peserta sertifikasi/asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen</p>

            <!-- Input Formulir APL.02 -->
            <div id="FRAK01" class="p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Sertifikasi Frontend
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        SKM/1602/00023/2/19
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Muhammad Rifai
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            Nafa Popcorn
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Satu Web
                        </p>
                    </div>
                </div>
            </div>

            <!-- Checklist Hasil Pengumpulan -->
            <div class="p-4">
                <label for="pilihKompetensi" class="block mb-2 font-semibold text-sidebar_Font text-sidebar_font">
                    Hasil yang Dikumpulkan
                    <span class="text-logout">*</span>
                </label>
                <div class="w-max-full flex flex-row flex-wrap border border-border_input rounded-md py-4 px-8 space-y-2" required>
                    <div class="flex items-center me-8">
                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-biru border-border_input rounded-sm">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-sidebar_font">Hasil yang Dikumpulkan</label>
                    </div>
                    <div class="flex items-center me-8">
                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-biru border-border_input rounded-sm">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-sidebar_font">Hasil yang Dikumpulkan</label>
                    </div>
                    <div class="flex items-center me-8">
                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-biru border-border_input rounded-sm">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-sidebar_font">Hasil yang Dikumpulkan</label>
                    </div>
                    <div class="flex items-center me-8">
                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-biru border-border_input rounded-sm">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-sidebar_font">Hasil yang Dikumpulkan</label>
                    </div>
                    <div class="flex items-center me-8">
                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-biru border-border_input rounded-sm">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-sidebar_font">Hasil yang Dikumpulkan</label>
                    </div>
                    <div class="flex items-center me-8">
                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-biru border-border_input rounded-sm">
                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-sidebar_font">Hasil yang Dikumpulkan</label>
                    </div>
                </div>
                <div class="my-6">
                    <label for="text" class="block font-medium text-sidebar_font">ASESI</label>
                    <p id="pernyataanAsesi" type="text" class="peer text-sidebar_font block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0" placeholder="Masukkan Pernyataan Asesi" required>
                        Bahwa saya telah mendapatkan penjelasan terkait hak dan prosedur banding asesmen dari asesor.
                    </p>
                </div>
                <div class="my-6">
                    <label for="text" class="block font-medium text-sidebar_font">ASESOR</label>
                    <p id="persetujuanAsesi" type="text" class="peer text-sidebar_font block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0" placeholder="Masukkan Pernyataan Asesi" required>
                        Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.
                    </p>
                </div>
                <div class="my-6">
                    <label for="text" class="block font-medium text-sidebar_font">ASESI</label>
                    <p id="pernyataanAsesor" type="text" class="peer text-sidebar_font block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0" placeholder="Masukkan Pernyataan Asesi" required>
                        Menyatakan tidak akan membukakan hasil pekerjaan yang saya peroleh karena penugasan saya sebagai asesor dalam asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai asesor yang ditugaskan oleh LSP
                    </p>
                </div>
            </div>

            <div class="my-6 px-4 flex flex-row space-y-6 justify-evenly">
                <!-- Upload Tanda Tangan dengan Preview -->
                <div class="mt-6">
                    <label for="file_ttd_asesi" class="block text-sm/6 font-medium text-sidebar_font text-center">Tanda Tangan Asesi (Utamakan PNG)
                    </label>
                    <div class="mt-2">
                        <!-- Upload Area -->
                        <div id="signature-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 cursor-pointer" disabled>
                            <div class="text-center" id="signature-content">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <span class="font-semibold text-abu">Diisi oleh Asesi</span>
                                </div>
                            </div>
                            <!-- Preview Image -->
                            <div id="signature-preview" class="hidden text-center">
                                <img id="signature-image" src="" alt="Preview Tanda Tangan" class="max-h-48 w-auto rounded-lg mx-auto p-0">
                                <div class="mt-2 text-center">
                                    <button type="button" id="remove-signature" class="text-red-500 text-sm hover:text-red-700">
                                        Hapus tanda tangan
                                    </button>
                                </div>
                            </div>

                        </div>
                        <input type="file" name="file_ttd_asesi" id="file_ttd_asesi" class="hidden" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
                <!-- Upload Tanda Tangan dengan Preview -->
                <div class="mt-6">
                    <label for="file_ttd_asesor" class="block text-sm/6 font-medium text-sidebar_font text-center">Tanda Tangan Asesor (Utamakan PNG)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <!-- Upload Area -->
                        <div id="signature-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 cursor-pointer hover:border-biru transition-colors upload-area">
                            <div class="text-center" id="signature-content">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <span class="font-semibold text-biru">Unggah tanda tangan</span>
                                    <span class="pl-1">atau drag and drop</span>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                            </div>
                            <!-- Preview Image -->
                            <div id="signature-preview" class="hidden text-center">
                                <img id="signature-image" src="" alt="Preview Tanda Tangan" class="max-h-48 w-auto rounded-lg mx-auto p-0">
                                <div class="mt-2 text-center">
                                    <button type="button" id="remove-signature" class="text-red-500 text-sm hover:text-red-700">
                                        Hapus tanda tangan
                                    </button>
                                </div>
                            </div>

                        </div>
                        <input type="file" name="file_ttd_asesor" id="file_ttd_asesor" class="hidden" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
            </div>
            <!-- Button Simpan -->
            <div class="flex justify-end pe-4">
                <button id="simpanRekomendasi" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru focus:outline-none mt-6">
                    Saya Menyetujui
                </button>
            </div>
        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
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

#signature-preview img {
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
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Fix untuk flex layout pada upload area */
.upload-area {
    min-height: 200px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const apiKey = "{{ env('API_KEY') }}";

    // Get asesor ID dynamically from the authenticated user with proper error handling
    const asesorId = @json(Auth::user()->asesor->id_asesor ?? null);

    // Stop execution if no asesor ID is found
    if (!asesorId) {
        console.error('No asesor ID found for the authenticated user');
        document.querySelector('#daftarAK01 tbody').innerHTML = `
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
            const tableBody = document.querySelector('#daftarAK01 tbody');

            if (asesisData && asesisData.length > 0) {
                let tableContent = '';

                asesisData.forEach((asesi, index) => {
                // Calculate progress percentage for display
                const progressPercent = asesi.progress_percentage || 0;

                // Determine if there's any progress (completed steps > 0)
                const hasProgress = asesi.completed_steps > 0;

                // Select appropriate icon based on progress
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
                            <button onclick="showSummary('${asesi.id_asesi}', '${asesi.nama_asesi}', '${asesi.nama_skema}', ${asesi.progress_percentage}, ${asesi.completed_steps}, ${asesi.total_steps})" class="">
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
                        <td class="flex px-4 py-3 justify-center items-center">
                            ${statusIcon}

                        </td>
                    </tr>
                `;
            });

                tableBody.innerHTML = tableContent;
            } else {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                    </tr>
                `;
            }

            // Implementasi pencarian
            const searchInput = document.getElementById('searchAK01');
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#daftarAK01 tbody tr');

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
            document.querySelector('#daftarAK01 tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        document.querySelector('#daftarAK01 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
            </tr>
        `;
    });
});
// Image Upload dengan Preview Function
    function setupImageUpload(config) {
        const {
            inputId,
            uploadAreaId,
            contentId,
            previewId,
            imageId,
            removeButtonId
        } = config;

        const input = document.getElementById(inputId);
        const uploadArea = document.getElementById(uploadAreaId);
        const content = document.getElementById(contentId);
        const preview = document.getElementById(previewId);
        const image = document.getElementById(imageId);
        const removeButton = document.getElementById(removeButtonId);

        if (!input || !uploadArea || !content || !preview || !image) {
            console.error('Upload elements not found for:', inputId);
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
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');

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
                showMessage('File harus berformat PNG, JPG, atau JPEG', 'error');
                return;
            }

            // Validate file size (10MB)
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                showMessage('Ukuran file maksimal 10MB', 'error');
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

                console.log('Preview berhasil ditampilkan untuk:', inputId);
            };
            reader.onerror = function() {
                showMessage('Gagal membaca file', 'error');
            };
            reader.readAsDataURL(file);
        }

        function clearPreview() {
            image.src = '';
            content.classList.remove('hidden');
            preview.classList.add('hidden');
            input.value = '';
            console.log('Preview dihapus untuk:', inputId);
        }

        // Public methods
        return {
            setPreviewFromUrl: function(url) {
                if (url) {
                    // Test if image loads successfully
                    const testImg = new Image();
                    testImg.onload = function() {
                        image.src = url;
                        content.classList.add('hidden');
                        preview.classList.remove('hidden');
                        console.log('Preview set dari URL:', url);
                    };
                    testImg.onerror = function() {
                        console.warn('Gagal memuat gambar dari URL:', url);
                    };
                    testImg.src = url;
                }
            },
            clearPreview: clearPreview,
            hasFile: function() {
                return input.files && input.files.length > 0;
            }
        };
    }

    // Setup upload untuk tanda tangan
    const signatureUpload = setupImageUpload({
        inputId: 'file_tanda_tangan',
        uploadAreaId: 'signature-upload-area',
        contentId: 'signature-content',
        previewId: 'signature-preview',
        imageId: 'signature-image',
        removeButtonId: 'remove-signature'
    });

    // Handle file uploads
    const signatureUploadInput = document.getElementById('file_tanda_tangan');
    if (signatureUploadInput && signatureUploadInput.files.length > 0) {
        formData.append('tanda_tangan', signatureUploadInput.files[0]);
    }

function showSummary() {

    // Sembunyikan elemen pencarian utama
    document.getElementById('searchAK01').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarAK01').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailAK01').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailAK01').scrollIntoView({ behavior: 'smooth' });
}
</script>

@endsection
