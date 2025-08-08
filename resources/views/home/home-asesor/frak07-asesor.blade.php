@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.AK-07 - Asesor')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

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
        <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Asesmen Kompetensi 07</p>
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
                        <a href="{{ route('frak07-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.AK.07
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

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span>Memuat data AK07...</span>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="errorText">Terjadi kesalahan saat memuat data.</span>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="successText">Data berhasil disimpan.</span>
    </div>
    <div id="frameAK07" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir AK.07 Penyesuaian yang Wajar dan Beralasan</p>
        <!-- Search Form -->
        <form id="searchAK07" class="max-w-md mb-4 rounded-xl">
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
            <table id="daftarAK07" class="min-w-full bg-white overflow-hidden">
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
        <div id="detailAK07" class="hidden pt-0 p-4 text-black">
            <p id="descDetail" class="font text-sidebar_font">Persetujuan ini untuk menjamin bahwa peserta sertifikasi/asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen</p>

            <!-- Input Formulir APL.02 -->
            <div id="FRAK07" class="pt-0 p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Memuat...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Memuat...
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Memuat...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            Memuat...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Memuat...
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Tanggal
                        </span>
                        <p id="tanggaltuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Memuat...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Panduan Asesor -->
            <div class="p-8 space-y-4">
                <div class="flex justify-center text-center uppercase">
                    <p class="text-sidebar_font font-bold">panduan bagi asesor</p>
                </div>
                <div class="flex">
                    <ul class="space-y-1 text-sidebar_font list-disc list-outside">
                        <li>Formulir ini digunakan pada saat pelaksanaan pra asesmen ada asesi yang mempunyai keterbatasan sesuai karakteristik yang dimilikinya sehinga diperlukan penyesuaian yang wajar dan beralasan dan atau ada penyesuaian rencana asesemen, jika tidak sesuai dengan acuan pembanding, potensi asesi dan konteks asesi.</li>
                        <li>Formulir ini terdiri dari dua bagian yaitu bagian A, jika asesi mempunyai keterbatasan sesuai karakteristik yang dimilikinya dan agian B: penyesuaian rencana asesmen, jika tidak sesuai dengan acuan pembanding, potensi asesi dan konteks asesi.</li>
                        <li>Coretalah pada tanda * yang tidak sesuai.</li>
                        <li>Berilah tanda √ Ya atau Tidak pada tanda ** sesuai pilihan.</li>
                        <li>Berilah tanda √ pada kotak ‘☐‘ pada kolom potensi asesi</li>
                        <li>Berilah tanda √ Ya atau Tidak pada tanda ** sesuai pilihan dan jika jawaban Ya selanjutanya pada kolom keterangan berilah tanda √ di kotak ‘☐‘ yang tersedia dan pilihannya boleh lebih dari satu pilihan disesuiakan kebutuhan.</li>
                        <li>Formulir ini juga digunakan untuk bagian B, jika rekaman rencana asesmen tervalidasi tidak sesuai dengan acuan pembanding, potensi asesi dan konteks asesi.</li>
                        <li>Berilah tanda √ Ya atau Tidak pada tanda** sesuai pilihan dan jika jawaban Ya selanjutanya pada kolom keterangan dengan***tuliskan penyesuaian yang diperlukan.</li>
                    </ul>
                </div>
            </div>

            <!-- Checklist Potensi Asesi -->
            <div id="clPotensi" class="flex flex-col md:flex-row p-4 md:p-8 border border-border_input rounded-md gap-4 md:gap-0">
                <div class="md:basis-1/4 flex items-center">
                    <p>Potensi Asesi</p>
                </div>
                <div id="hasil_yang_akan_dikumpulkan" class="md:basis-3/4 flex flex-col space-y-2">
                        <div class="text-gray-500">Memuat opsi hasil yang akan dikumpulkan...</div>
                </div>
            </div>

            <!-- Tabel 1 AK07 -->
            <div class="p-4">
                <p id="judulTabelAK07" class="text-sidebar_font font-semibold pb-2">Bagian A. Penyesuaian sesuai karekteristik asesi</p>

                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table class="min-w-full text-sm text-gray-700 border border-gray-300">
    <thead class="bg-gray-100 text-gray-900">
      <tr>
        <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center align-middle w-8">No</th>
        <th rowspan="2" class="border border-gray-300 px-2 py-2 align-middle w-1/3">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi (karakteristik asesi)</th>
        <th colspan="2" class="border border-gray-300 px-2 py-2 text-center">Penyesuaian</th>
        <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center align-middle">Keterangan</th>
      </tr>
      <tr>
        <th class="border border-gray-300 px-2 py-2 text-center w-10">Ya</th>
        <th class="border border-gray-300 px-2 py-2 text-center w-10">Tidak</th>
      </tr>
    </thead>
    <tbody id="bagiana_yang_akan_dikumpulkan">
      <tr>
      <td colspan="5" class="text-gray-500">Memuat opsi bagian A yang akan dikumpulkan...</td>
  </tr>

    </tbody>
  </table>
                </div>
            </div>

            <!-- Tabel 2 APL02 -->
            <div class="p-4">
                <p id="judulTabelAPL02" class="text-sidebar_font font-semibold pb-2">Bagian B. Penyesuaian sesuai karekteristik asesi</p>

                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table class="min-w-full text-sm text-gray-700">
    <thead class="bg-gray-100 text-gray-900">
      <tr>
        <th class="border border-gray-300 px-4 py-2 text-center w-10">No</th>
        <th class="border border-gray-300 px-4 py-2 text-left">Rekaman Rencana Asesme</th>
        <th class="border border-gray-300 px-4 py-2 text-center w-16">Ya</th>
        <th class="border border-gray-300 px-4 py-2 text-center w-16">Tidak</th>
        <th class="border border-gray-300 px-4 py-2 text-left w-1/4">Rekaman Rencana Asesme</th>
      </tr>
    </thead>
    <tbody id="bagianb_yang_akan_dikumpulkan">
      <tr>
      <td colspan="5" class="text-gray-500">Memuat opsi bagian B yang akan dikumpulkan...</td>
  </tr>

    </tbody>
  </table>

                </div>


            </div>
            <div class="p-8 space-y-4">
    <div class="flex justify-center text-center">
        <p class="text-sidebar_font font-bold">Hasil</p>
    </div>
    <div class="flex">
        <ul class="space-y-1 text-sidebar_font list-disc list-outside">
            <li>A. Hasil Penyesuaian Sesuai Karakteristik Asesi
                <ol class="list-decimal list-inside pl-4">
                    <li>Acuan Pembanding Asesmen: ( tuliskan nama acuan pembanding)</li>
                    <li>Metode Asesmen: ( tuliskan nama metode asesmen)</li>
                    <li>Instrumen Asesmen: ( tuliskan nama formulir instrumen asesmen)</li>
                </ol>
            </li>
            <li>B. Hasil Penyesuaian Rencana Asesmen Sesuai Acuan Pembanding, Potensi Asesi dan Konteks Asesi
                <ol class="list-decimal list-inside pl-4">
                    <li>Acuan Pembanding Asesmen: ( tuliskan nama acuan pembanding)</li>
                    <li>Metode Asesmen: ( tuliskan nama metode asesmen)</li>
                    <li>Instrumen Asesmen: ( tuliskan nama formulir instrumen asesmen)</li>
                </ol>
            </li>
        </ul>
    </div>
</div>

<!-- Signature section -->
                    <div class="my-6 px-4 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Tanda Tangan Asesi (Read-only) -->
                        <div>
                            <label class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">Tanda Tangan Asesi</label>
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

                        </div>

                        <!-- Tanda Tangan Asesor (Checkbox based) -->
                        <div>
                            <label for="is_asesor_signing" class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">
                                Tanda Tangan Asesor
                                <span class="text-red-500">*</span>
                            </label>
                            <div id="asesor-signature-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 hover:bg-blue-50 cursor-pointer min-h-[200px]">
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
                                    <img id="asesor-signature-image" src="" alt="Tanda Tangan Asesor" class="max-h-48 w-auto mx-auto rounded-lg p-2 border border-gray-200 bg-white shadow-sm">
                                    <p class="text-xs text-center mt-2 text-gray-500">Tanda tangan asesor dari biodata</p>
                                    <p id="tanggalTandaTanganAsesor" class="text-xs text-center text-gray-500">Tanggal: -</p>
                                </div>
                            </div>

                            <!-- Checkbox untuk persetujuan tanda tangan -->
                            <div class="mt-4 flex items-center justify-center">
                                <input id="is_asesor_signing" name="is_asesor_signing" type="checkbox" value="true"
                                       class="w-4 h-4 text-biru bg-gray-100 border-gray-300 rounded focus:ring-biru focus:ring-2">
                                <label for="is_asesor_signing" class="ms-2 text-sm font-medium text-sidebar_font">
                                    Data yang saya masukkan sudah benar dan saya menyetujui formulir AK07 ini
                                </label>
                            </div>
                        </div>

                    </div>
            <!-- Button Simpan -->
                <div class="flex justify-end pe-4">
                    <button id="simpanAK07" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru focus:outline-none mt-6">
                        Saya Menyetujui
                    </button>
                </div>


        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>
<!-- Modal Konfirmasi -->
<div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4" id="confirmationTitle">Konfirmasi Persetujuan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="confirmationMessage">
                    Apakah Anda yakin ingin menyetujui dan menandatangani formulir FR.AK-01 ini?
                    <br><br>
                    <strong class="text-red-600">Perhatian:</strong> Data yang sudah disetujui dan ditandatangani tidak dapat diubah lagi.
                    <br><br>
                    Pastikan semua informasi sudah benar sebelum melanjutkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmYesBtn" class="px-4 py-2 bg-gradient-to-r from-biru to-ungu text-white text-base font-medium rounded-md w-20 mr-2 hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Ya
                </button>
                <button id="confirmNoBtn" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-20 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
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
    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    let currentAsesiId = null;
    let asesorSignatureUrl = null;
    let recordExists = false;

    // Function to show error message
    function showError(message) {
        showMessage(message, 'error');
    }

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        showError('Konfigurasi API URL tidak ditemukan. Silakan hubungi administrator.');
        document.querySelector('#daftarAK07 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak ditemukan</td>
            </tr>
        `;
        return;
    }

    if (!apiConfig.key) {
        showError('Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        document.querySelector('#daftarAK07 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak ditemukan</td>
            </tr>
        `;
        return;
    }

    if (!apiConfig.asesorId) {
        showError('ID Asesor tidak ditemukan. Silakan login kembali.');
        document.querySelector('#daftarAK07 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">User tidak teridentifikasi, silahkan login kembali</td>
            </tr>
        `;
        return;
    }

    // Build API URLs dynamically
    const asesisApiUrl = `${apiConfig.url}/asesor/asesis/${apiConfig.asesorId}`;
    const biodataApiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;

    // Headers untuk API request
    const headers = {
        'Content-Type': 'application/json',
        'API_KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    // Modal functions
    function showConfirmationModal(title, message, onConfirm, onCancel = null) {
        const modal = document.getElementById('confirmationModal');
        const titleElement = document.getElementById('confirmationTitle');
        const messageElement = document.getElementById('confirmationMessage');
        const yesBtn = document.getElementById('confirmYesBtn');
        const noBtn = document.getElementById('confirmNoBtn');

        titleElement.textContent = title;
        messageElement.innerHTML = message;

        // Remove existing event listeners
        const newYesBtn = yesBtn.cloneNode(true);
        const newNoBtn = noBtn.cloneNode(true);
        yesBtn.parentNode.replaceChild(newYesBtn, yesBtn);
        noBtn.parentNode.replaceChild(newNoBtn, noBtn);

        // Add new event listeners
        newYesBtn.addEventListener('click', function() {
            hideConfirmationModal();
            if (onConfirm) onConfirm();
        });

        newNoBtn.addEventListener('click', function() {
            hideConfirmationModal();
            if (onCancel) onCancel();
        });

        modal.classList.remove('hidden');
    }

    function hideConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    // Message helper functions
    function showMessage(message, type = 'info', duration = 5000) {
        const messageElements = {
            'success': document.getElementById('successMessage'),
            'error': document.getElementById('errorMessage'),
            'loading': document.getElementById('loadingIndicator')
        };

        // Hide all messages first
        Object.values(messageElements).forEach(el => el?.classList.add('hidden'));

        const messageElement = messageElements[type];
        if (messageElement) {
            const textElement = messageElement.querySelector('span');
            if (textElement) textElement.textContent = message;
            messageElement.classList.remove('hidden');

            if (duration > 0) {
                setTimeout(() => {
                    messageElement.classList.add('hidden');
                }, duration);
            }
        }
    }

    // Load asesor signature from biodata
    function loadAsesorSignature() {
        fetch(biodataApiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data?.file_url_tanda_tangan) {
                asesorSignatureUrl = "{{ url('') }}" + result.data.file_url_tanda_tangan;
            }
        })
        .catch(error => {
            // Silent fail for signature loading
        });
    }

    // Load progress for each asesi
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
                                asesi.ak07_completed = progressResult.data.progress_asesmen?.ak07?.completed || false;
                                asesi.ak07_completed_at = progressResult.data.progress_asesmen?.ak07?.completed_at || null;
                                asesi.progress_percentage = progressResult.data.progress_summary?.progress_percentage || 0;
                                asesi.completed_steps = progressResult.data.progress_summary?.completed_steps || 0;
                                asesi.total_steps = progressResult.data.progress_summary?.total_steps || 0;
                            } else {
                                asesi.ak07_completed = false;
                                asesi.ak07_completed_at = null;
                                asesi.progress_percentage = 0;
                                asesi.completed_steps = 0;
                                asesi.total_steps = 0;
                            }
                        } else {
                            asesi.ak07_completed = false;
                            asesi.ak07_completed_at = null;
                            asesi.progress_percentage = 0;
                            asesi.completed_steps = 0;
                            asesi.total_steps = 0;
                        }
                    } catch (error) {
                        asesi.ak07_completed = false;
                        asesi.ak07_completed_at = null;
                        asesi.progress_percentage = 0;
                        asesi.completed_steps = 0;
                        asesi.total_steps = 0;
                    }
                    return asesi;
                })
            );

            return asesisWithProgress;
        } catch (error) {
            showMessage(`Error memuat progress asesi: ${error.message}`, 'error');
            return asesisData;
        }
    }

    // Load data asesi
    async function loadAsesiData() {
        try {
            showMessage('Memuat data asesi...', 'loading', 0);

            const response = await fetch(asesisApiUrl, {
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

                const tableBody = document.querySelector('#daftarAK07 tbody');

                if (asesisData && asesisData.length > 0) {
                    let tableContent = '';

                    asesisData.forEach((asesi, index) => {
                        // Use the ak07 completion status from progress API
                        const hasProgress = asesi.ak07_completed === true;
                        const progressPercent = asesi.progress_percentage || 0;
                        const completedSteps = asesi.completed_steps || 0;
                        const totalSteps = asesi.total_steps || 0;

                        // Select appropriate icon based on ak07 completion
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
                    const rows = document.querySelectorAll('#daftarAK07 tbody tr');

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
                document.querySelector('#daftarAK07 tbody').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
                showMessage(`Gagal memuat data: ${result.message || 'Terjadi kesalahan'}`, 'error');
            }
        } catch (error) {
            document.querySelector('#daftarAK07 tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
            showMessage(`Error memuat data: ${error.message}`, 'error');
        }
    }

    // Load AK07 data for specific asesi
    function loadAK07Data(asesiId) {
        if (!asesiId) return;

        showMessage('Memuat data AK07...', 'loading', 0);

        const ak07ApiUrl = `${apiConfig.url}/asesmen/ak07/${asesiId}`;

        fetch(ak07ApiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
                // console.log(response);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
                // console.log(result);
            showMessage('', 'loading'); // Hide loading

            if (result.status === 'success' && result.data) {
                const data = result.data;
                recordExists = data.record_exists || false;

                // Populate general info
                if (data.general_info) {
                    console.log(data.general_info);
                    document.getElementById('judulSertifikasi').textContent = data.general_info.judul_skema || 'N/A';
                    document.getElementById('nomorSertifikasi').textContent = data.general_info.kode_skema || 'N/A';
                    document.getElementById('namaPeserta').textContent = data.general_info.nama_asesi || 'N/A';
                    document.getElementById('namaAsesor').textContent = data.general_info.nama_asesor || 'N/A';
                    document.getElementById('tuk').textContent = data.general_info.nama_tuk || 'N/A';
                    document.getElementById('tanggaltuk').textContent = data.general_info.pelaksanaan_asesmen_disepakati_mulai || 'N/A';
                    document.getElementById('breadcrumbAsesiName').textContent = data.general_info.nama_asesi || 'Detail AK07';
                }

                // Populate hasil yang akan dikumpulkan
                // console.log(data.ak07);
                populateHasilCheckboxes(data.ak07?.hasil_yang_akan_dikumpulkan || [],data.potensi_asesi);
                populateBagianA(data.ak07?.bagian_a || [],data.seeder_a);
                populateBagianB(data.ak07?.bagian_b || [],data.seeder_b);

                // Show existing signatures if available
                if (recordExists && data.ak07) {
                    // Show asesor signature if available and disable form
                    if (data.ak07.tanda_tangan_asesor && data.ak07.tanda_tangan_asesor !== "null") {
                        const asesorImage = document.getElementById('asesor-signature-image');
                        const asesorContent = document.getElementById('asesor-signature-content');
                        const asesorPreview = document.getElementById('asesor-signature-preview');
                        const tanggalAsesor = document.getElementById('tanggalTandaTanganAsesor');
                        const signingCheckbox = document.getElementById('is_asesor_signing');
                        const submitButton = document.getElementById('simpanAK07');

                        if (asesorImage && asesorContent && asesorPreview) {
                            asesorImage.src = data.ak07.tanda_tangan_asesor;
                            asesorContent.classList.add('hidden');
                            asesorPreview.classList.remove('hidden');

                            if (tanggalAsesor && data.ak07.waktu_tanda_tangan_asesor) {
                                tanggalAsesor.textContent = `Tanggal: ${data.ak07.waktu_tanda_tangan_asesor}`;
                            }
                        }

                        // Disable form elements
                        if (signingCheckbox) {
                            signingCheckbox.checked = true;
                            signingCheckbox.disabled = true;
                        }

                        // Disable all checkboxes
                        const checkboxes = document.querySelectorAll('input[name="hasil_yang_akan_dikumpulkan[]"]');
                        checkboxes.forEach(checkbox => {
                            checkbox.disabled = true;
                        });

                        // Update submit button
                        if (submitButton) {
                            submitButton.textContent = 'Sudah Disetujui';
                            submitButton.disabled = true;
                            submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru');
                            submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                        }
                    } else {
                        // Show asesor signature preview if available from biodata
                        if (asesorSignatureUrl) {
                            const asesorImage = document.getElementById('asesor-signature-image');
                            const asesorContent = document.getElementById('asesor-signature-content');
                            const asesorPreview = document.getElementById('asesor-signature-preview');

                            if (asesorImage && asesorContent && asesorPreview) {
                                asesorImage.src = asesorSignatureUrl;
                                asesorContent.classList.add('hidden');
                                asesorPreview.classList.remove('hidden');
                            }
                        }
                    }
                } else {
                    // Show asesor signature preview if available from biodata
                    if (asesorSignatureUrl) {
                        const asesorImage = document.getElementById('asesor-signature-image');
                        const asesorContent = document.getElementById('asesor-signature-content');
                        const asesorPreview = document.getElementById('asesor-signature-preview');

                        if (asesorImage && asesorContent && asesorPreview) {
                            asesorImage.src = asesorSignatureUrl;
                            asesorContent.classList.add('hidden');
                            asesorPreview.classList.remove('hidden');
                        }
                    }
                }

                showMessage('Data AK07 berhasil dimuat', 'success', 3000);
            } else {
                showMessage('Gagal memuat data AK07: ' + (result.message || 'Terjadi kesalahan'), 'error');
            }
        })
        .catch(error => {
            showMessage('Error memuat data AK07: ' + error.message, 'error');
        });
    }

    function populateHasilCheckboxes(selectedResults = [], seeder) {
      const container = document.getElementById('hasil_yang_akan_dikumpulkan');

      let checkboxContent = '';
      // Iterasi melalui data dari 'seeder' yang telah disediakan
      seeder.forEach((item, index) => {
          // Menggunakan 'deskripsi' dari setiap item seeder sebagai opsi
          const option = item.deskripsi;
          // Memeriksa apakah opsi ini sudah terpilih di 'selectedResults'
          const isChecked = Array.isArray(selectedResults) && selectedResults.includes(option) ? 'checked' : '';

          checkboxContent += `
            <div class="flex items-center pb-2">
                <input id="hasil_checkbox_${index}" name="hasil_yang_akan_dikumpulkan[]" type="checkbox" value="${option}" class="w-4 h-4 text-biru border-border_input rounded-sm" ${isChecked}>
                <label for="hasil_checkbox_${index}" class="ms-2 text-sm font-medium text-sidebar_font">${option}</label>
            </div>
          `;
      });

      container.innerHTML = checkboxContent;
    }

    function populateBagianA(selectedResults = [], seeder) {
      // console.log(seeder);
      const container = document.getElementById('bagiana_yang_akan_dikumpulkan');

      // Menggunakan data dari seeder menggantikan data dummy
      const items = seeder.map(item => {
          // Parse opsi_penyesuaian dari string JSON menjadi array
          let keteranganArray = [];
          try {
              keteranganArray = JSON.parse(item.opsi_penyesuaian);
          } catch (error) {
              console.error('Error parsing opsi_penyesuaian:', error);
              keteranganArray = [];
          }

          return {
              item: item.deskripsi,
              keterangan: keteranganArray
          };
      });

      let checkboxContent = ``;
      items.forEach((option, index) => {
          const isChecked1 = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option.item && obj.penyesuaian === 1) ? 'checked' : '';
          const isChecked0 = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option.item && obj.penyesuaian === 0) ? 'checked' : '';
          const isDisabled = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option.item) ? 'disabled' : '';
          const rowspan = option.keterangan.length > 1 ? option.keterangan.length : 1;

          checkboxContent += `
                              <tr>
                          <td rowspan="${rowspan}" class="border border-gray-300 text-center align-top px-2 py-2">${index + 1}</td>
                          <td rowspan="${rowspan}" class="border border-gray-300 align-top px-2 py-2">${option.item}</td>
                          <td rowspan="${rowspan}" class="border border-gray-300 text-center align-middle">
                            <input type="radio" class="bagian_a_yang_akan_dikumpulkan mx-auto" name="${option.item}" value=1 ${isChecked1} ${isDisabled}>
                          </td>
                          <td rowspan="${rowspan}" class="border border-gray-300 text-center align-middle">
                            <input type="radio" class="bagian_a_yang_akan_dikumpulkan mx-auto" name="${option.item}" value=0 ${isChecked0} ${isDisabled}>
                          </td>
                          `;

          option.keterangan.forEach((ket, index2) => {
              if (index2 != 0) {
                  checkboxContent += `<tr>`;
              }
              checkboxContent += `
                  <td class="border border-gray-300 px-2 py-2">
                    <input type="radio" class="bagian_a_yang_akan_dikumpulkan mx-auto" name="" value=0>
                    ${ket}
                  </td>
                </tr>
                  `;
          });

          if (option.keterangan.length < 1) {
              checkboxContent += `
                </tr>`;
          }
      });

      container.innerHTML = checkboxContent;
    }

    function populateBagianB(selectedResults = [], seeder) {
      const container = document.getElementById('bagianb_yang_akan_dikumpulkan');

      let checkboxContent = '';
      seeder.forEach((item, index) => {
          const option = item.rekaman_rencana_asesmen;
          const isChecked1 = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option && obj.penyesuaian === 1) ? 'checked' : '';
          const isChecked0 = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option && obj.penyesuaian === 0) ? 'checked' : '';
          const isDisabled = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option) ? 'disabled' : '';
          const lainnya = Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option) ? selectedResults.find(obj => obj.item === option).lainnya : '';

          checkboxContent += `
        <tr class="border-t border-gray-200">
            <td class="border border-gray-300 text-center align-top px-4 py-4">${index + 1}</td>
            <td class="border border-gray-300 px-4 py-4 align-top">
                ${option}
            </td>
            <td class="border border-gray-300 text-center align-middle">
                <input type="radio" class="bagian_b_yang_akan_dikumpulkan mx-auto" name="${option}" value=1 ${isChecked1} ${isDisabled}>
            </td>
            <td class="border border-gray-300 text-center align-middle">
                <input type="radio" class="bagian_b_yang_akan_dikumpulkan mx-auto" name="${option}" value=0 ${isChecked0} ${isDisabled}>
            </td>
            <td class="border border-gray-300 px-2 py-2 align-top">
                <textarea name="${option}" placeholder="Lainnya.." class="w-full border border-gray-300 rounded px-2 py-1 resize-none" ${isDisabled}>${lainnya}</textarea>
            </td>
        </tr>
    `;
      });

      container.innerHTML = checkboxContent;
    }

    // Function to save AK07 data
    function saveAK07Data() {
        if (!currentAsesiId) {
            showMessage('ID Asesi tidak ditemukan', 'error');
            return;
        }

        if (!asesorSignatureUrl) {
            showMessage('Anda belum memiliki tanda tangan di biodata. Silakan upload tanda tangan di halaman biodata terlebih dahulu.', 'error');
            return;
        }

        // Check if checkbox is checked
        const signingCheckbox = document.getElementById('is_asesor_signing');
        if (!signingCheckbox.checked) {
            showMessage('Silakan setujui untuk menandatangani formulir', 'error');
            return;
        }

        // Collect selected hasil
        const selectedHasil = [];
        const checkboxes = document.querySelectorAll('input[name="hasil_yang_akan_dikumpulkan[]"]:checked');
        checkboxes.forEach(checkbox => {
            selectedHasil.push(checkbox.value);
        });

        if (selectedHasil.length === 0) {
            showMessage('Pilih minimal satu hasil yang akan dikumpulkan', 'error');
            return;
        }

        // Collect selected bagiana
        const selectedBagianA = [];
        const radioa = document.querySelectorAll('input.bagian_a_yang_akan_dikumpulkan:checked');
        // console.log(radioa);
        radioa.forEach(radioa => {
            radioadata = {item: radioa.name, penyesuaian: radioa.value};
            selectedBagianA.push(radioadata);
        });

        // Collect selected bagianb
        const selectedBagianB = [];
        const radiob = document.querySelectorAll('input.bagian_b_yang_akan_dikumpulkan:checked');
        // console.log(radiob);
        radiob.forEach(radiob => {
            radiobdata = {item: radiob.name, penyesuaian: radiob.value, lainnya: document.querySelector('textarea[name="'+radiob.name+'"]').value};
            selectedBagianB.push(radiobdata);
        });

        if (selectedHasil.length === 0) {
            showMessage('Pilih minimal satu hasil yang akan dikumpulkan', 'error');
            return;
        }

        showMessage('Menyimpan data AK07...', 'loading', 0);

        // console.log(selectedHasil);
        // console.log(selectedBagianA);
        // console.log(selectedBagianB);

        // Prepare data for API
        const requestData = {
            id_asesi: currentAsesiId,
            id_asesor: apiConfig.asesorId,
            hasil_yang_akan_dikumpulkan: selectedHasil,
            bagian_a: selectedBagianA,
            bagian_b: selectedBagianB,
            is_signing: true
        };

        // console.log(JSON.stringify(requestData));

        // Submit to API
        const saveApiUrl = `${apiConfig.url}/asesmen/ak07/asesor/save`;

        fetch(saveApiUrl, {
            method: 'POST',
            headers: {
                ...headers,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            // console.log(response);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            // console.log(result);
            showMessage('', 'loading'); // Hide loading

            if (result.status === 'success') {
                showMessage('Data AK07 berhasil disimpan dan ditandatangani!', 'success');

                // Reload AK07 data to show updated information
                setTimeout(() => {
                    loadAK07Data(currentAsesiId);
                    // Also reload the asesi list to update the progress status
                    loadAsesiData();
                }, 1000);
            } else {
                showMessage('Gagal menyimpan data AK07: ' + (result.message || 'Terjadi kesalahan'), 'error');
            }
        })
        .catch(error => {
            showMessage('Error menyimpan data AK07: ' + error.message, 'error');
        });
    }

    // Button click handler with confirmation modal
    document.getElementById('simpanAK07')?.addEventListener('click', function(e) {
        e.preventDefault();

        showConfirmationModal(
            'Konfirmasi Persetujuan',
            `Apakah Anda yakin ingin menyetujui dan menandatangani formulir FR.AK-01 ini?
            <br><br>
            <strong class="text-red-600">Perhatian:</strong> Data yang sudah disetujui dan ditandatangani tidak dapat diubah lagi.
            <br><br>
            Pastikan semua informasi sudah benar sebelum melanjutkan.`,
            function() {
                // User confirmed, proceed with saving
                saveAK07Data();
            },
            function() {
                // User cancelled
            }
        );
    });

    // Load initial data
    loadAsesiData();
    loadAsesorSignature();

    // Global function for showing document
    window.showSummary = function(asesiId, asesiName, skemaName, progressPercent, completedSteps, totalSteps, ak07Completed = false) {
        currentAsesiId = asesiId;

        // Hide main elements and show detail
        document.getElementById('searchAK07').classList.add('hidden');
        document.getElementById('daftarAK07').classList.add('hidden');
        document.getElementById('breadcrumbs').classList.remove('hidden');
        document.getElementById('detailAK07').classList.remove('hidden');

        // Load AK07 data for this asesi
        loadAK07Data(asesiId);

        // Scroll to detail
        document.getElementById('detailAK07').scrollIntoView({ behavior: 'smooth' });
    };

    // Global function alias for showDocument (if needed)
    window.showDocument = window.showSummary;
});

// Table sorting function
function sortTable(columnIndex) {
    const table = document.getElementById('daftarAK07');
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
// function showSummary() {
//    // Sembunyikan elemen pencarian utama
//     document.getElementById('searchAK07').classList.add('hidden');

//     // Sembunyikan elemen daftar asesi
//     document.getElementById('daftarAK07').classList.add('hidden');

//     // Tampilkan bagian breadcrumbs
//     document.getElementById('breadcrumbs').classList.remove('hidden');

//     // Tampilkan bagian detail asesi
//     document.getElementById('detailAK07').classList.remove('hidden');

//     // Optional: scroll ke bagian detail
//     document.getElementById('detailAK07').scrollIntoView({ behavior: 'smooth' });
// }
</script>

@endsection
