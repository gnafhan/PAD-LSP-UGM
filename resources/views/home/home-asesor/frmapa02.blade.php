@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.MAPA-02 - Asesor')

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
        <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Merencanakan Aktivitas dan Proses Asesmen 02</p>
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
                        <a href="{{ route('frmapa02-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.MAPA.02
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

    <div id="frameMAPA02" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir MAPA.02 Peta Instrumen Asesmen Hasil Pendekatan Asesmen & Perencanaan Asesmen</p>

        <!-- Search Form -->
        <form id="searchMAPA02" class="max-w-md mb-4 rounded-xl">
            <div class="relative">
                <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto shadow-sm rounded-lg">
            <table id="daftarMAPA02" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Aksi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Memuat data asesi...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="detailMAPA02" class="hidden pt-0 p-4 text-black">
            <!-- Loading content -->
            <div id="loadingContainer" class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-biru"></div>
            </div>

            <!-- Main content container -->
            <div id="mainContent" class="hidden">
                <!-- Input Formulir MAPA.02 -->
                <div id="FRMAPA02" class="pt-0 p-4 space-y-6">
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                                Judul Sertifikasi
                            </span>
                            <p id="judulSertifikasi" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nomor Sertifikasi
                            </span>
                            <p id="nomorSertifikasi" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                    </div>
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nama Peserta Sertifikasi
                            </span>
                            <p id="namaPeserta" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nama Asesor
                            </span>
                            <p id="namaAsesor" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                TUK
                            </span>
                            <p id="tuk" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input">
                                Loading...
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Checklist MAPA 2 -->
                <div class="p-4">
                    <p class="block mb-2 text-xl font-bold text-sidebar_font">
                        1. Pendekatan Asesmen
                    </p>
                    <form id="mapa02Form">
                        <div class="w-max-full flex flex-row flex-wrap border border-border_input rounded-md p-2 space-y-2">
                            <table class="min-w-full bg-white overflow-hidden border border-gray-200 rounded-lg text-sm text-gray-600">
                                <thead class="bg-bg_dashboard text-center">
                                    <!-- Header Baris Pertama -->
                                    <tr>
                                        <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">No</th>
                                        <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">MUK</th>
                                        <th colspan="5" class="px-4 py-3 font-semibold border-b border-gray-200">Potensi Asesi</th>
                                    </tr>
                                    <!-- Header Baris Kedua -->
                                    <tr>
                                        <th class="px-4 py-3 font-semibold border-b border-gray-200">1</th>
                                        <th class="px-4 py-3 font-semibold border-b border-gray-200">2</th>
                                        <th class="px-4 py-3 font-semibold border-b border-gray-200">3</th>
                                        <th class="px-4 py-3 font-semibold border-b border-gray-200">4</th>
                                        <th class="px-4 py-3 font-semibold border-b border-gray-200">5</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-center text-sm text-gray-700">
                                    <!-- MUK 1: Ceklis Observasi -->
                                    <tr class="text-black">
                                        <td class="px-4 py-3">1</td>
                                        <td class="px-4 py-3 text-left">
                                            <p>Ceklis Observasi Untuk Aktivitas di Tempat Kerja atau Tempat Kerja Simulasi</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_observasi_1" type="radio" value="1" name="muk_ceklis_observasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_observasi_2" type="radio" value="2" name="muk_ceklis_observasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_observasi_3" type="radio" value="3" name="muk_ceklis_observasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_observasi_4" type="radio" value="4" name="muk_ceklis_observasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_observasi_5" type="radio" value="5" name="muk_ceklis_observasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <!-- MUK 2: Tugas Praktik Demonstrasi -->
                                    <tr class="text-black">
                                        <td class="px-4 py-3">2</td>
                                        <td class="px-4 py-3 text-left">
                                            <p>Tugas Praktik Demonstrasi</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_tugas_praktik_demonstrasi_1" type="radio" value="1" name="muk_tugas_praktik_demonstrasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_tugas_praktik_demonstrasi_2" type="radio" value="2" name="muk_tugas_praktik_demonstrasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_tugas_praktik_demonstrasi_3" type="radio" value="3" name="muk_tugas_praktik_demonstrasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_tugas_praktik_demonstrasi_4" type="radio" value="4" name="muk_tugas_praktik_demonstrasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_tugas_praktik_demonstrasi_5" type="radio" value="5" name="muk_tugas_praktik_demonstrasi" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <!-- MUK 3: Pertanyaan Tertulis - Esai -->
                                    <tr class="text-black">
                                        <td class="px-4 py-3">3</td>
                                        <td class="px-4 py-3 text-left">
                                            <p>Pertanyaan Tertulis - Esai</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_tertulis_esai_1" type="radio" value="1" name="muk_pertanyaan_tertulis_esai" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_tertulis_esai_2" type="radio" value="2" name="muk_pertanyaan_tertulis_esai" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_tertulis_esai_3" type="radio" value="3" name="muk_pertanyaan_tertulis_esai" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_tertulis_esai_4" type="radio" value="4" name="muk_pertanyaan_tertulis_esai" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_tertulis_esai_5" type="radio" value="5" name="muk_pertanyaan_tertulis_esai" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <!-- MUK 4: Pertanyaan Lisan -->
                                    <tr class="text-black">
                                        <td class="px-4 py-3">4</td>
                                        <td class="px-4 py-3 text-left">
                                            <p>Pertanyaan Lisan</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_lisan_1" type="radio" value="1" name="muk_pertanyaan_lisan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_lisan_2" type="radio" value="2" name="muk_pertanyaan_lisan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_lisan_3" type="radio" value="3" name="muk_pertanyaan_lisan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_lisan_4" type="radio" value="4" name="muk_pertanyaan_lisan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_pertanyaan_lisan_5" type="radio" value="5" name="muk_pertanyaan_lisan" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <!-- MUK 5: Ceklis Verifikasi Portfolio -->
                                    <tr class="text-black">
                                        <td class="px-4 py-3">5</td>
                                        <td class="px-4 py-3 text-left">
                                            <p>Ceklis Verifikasi Portfolio</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_verifikasi_portfolio_1" type="radio" value="1" name="muk_ceklis_verifikasi_portfolio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_verifikasi_portfolio_2" type="radio" value="2" name="muk_ceklis_verifikasi_portfolio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_verifikasi_portfolio_3" type="radio" value="3" name="muk_ceklis_verifikasi_portfolio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_verifikasi_portfolio_4" type="radio" value="4" name="muk_ceklis_verifikasi_portfolio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_verifikasi_portfolio_5" type="radio" value="5" name="muk_ceklis_verifikasi_portfolio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                    <!-- MUK 6: Ceklis Meninjau Materi Uji -->
                                    <tr class="text-black">
                                        <td class="px-4 py-3">6</td>
                                        <td class="px-4 py-3 text-left">
                                            <p>Ceklis Meninjau Materi Uji Kompetensi</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_meninjau_materi_uji_1" type="radio" value="1" name="muk_ceklis_meninjau_materi_uji" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_meninjau_materi_uji_2" type="radio" value="2" name="muk_ceklis_meninjau_materi_uji" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_meninjau_materi_uji_3" type="radio" value="3" name="muk_ceklis_meninjau_materi_uji" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_meninjau_materi_uji_4" type="radio" value="4" name="muk_ceklis_meninjau_materi_uji" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-3">
                                            <input id="muk_ceklis_meninjau_materi_uji_5" type="radio" value="5" name="muk_ceklis_meninjau_materi_uji" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-sidebar_font">
                            <p class="mt-4 text-lg font-semibold">Catatan:</p>
                            <p class="text-sidebar_font text-base">*  : diisi berdasarkan hasil penentuan pendekatan asesmen dan perencanaan asesmen</p>
                            <p class="text-sidebar_font text-base">** : Keterangan:
                                <ol class="ps-5 mt-2 space-y-1 list-decimal list-inside text-sidebar_font text-base">
                                    <li>Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi.</li>
                                    <li>Hasil pelatihan dan / atau pendidikan, dimana kurikulum berbasis kompetensi.</li>
                                    <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi.</li>
                                    <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya berbasis kompetensi.</li>
                                    <li>Pelatihan / belajar mandiri atau otodidak.</li>
                                </ol>
                            </p>
                        </div>

                        <!-- Button Simpan -->
                        <div class="flex justify-end pe-4">
                            <button id="simpanRekomendasi" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6">
                                Simpan dan Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
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
                <p class="text-sm text-gray-500">
                    Formulir MAPA.02 berhasil disimpan dan disetujui.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeSuccessModal" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    OK
                </button>
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
                <p id="errorMessage" class="text-sm text-gray-500">
                    Terjadi kesalahan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="closeErrorModal" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    OK
                </button>
            </div>
        </div>
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
    let currentAsesiId = null;
    let currentAsesiData = null;
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
        document.querySelector('#daftarMAPA02 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">${message}</td>
            </tr>
        `;
    }

    // Function to show loading state
    function showLoading() {
        document.getElementById('loadingContainer').classList.remove('hidden');
        document.getElementById('mainContent').classList.add('hidden');
    }

    // Function to show main content
    function showMainContent() {
        document.getElementById('loadingContainer').classList.add('hidden');
        document.getElementById('mainContent').classList.remove('hidden');
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

    function loadAsesiList() {
        fetch(asesisApiUrl, {
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
                // Load progress for each asesi and then populate table
                loadAsesiProgress(result.data.asesis);
            } else {
                showTableError(result.message || 'Gagal memuat data asesi');
            }
        })
        .catch(error => {
            showTableError(`Error memuat data: ${error.message}`);
        });
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
                                asesi.mapa02_completed = progressResult.data.progress_asesmen?.mapa02?.completed || false;
                                asesi.mapa02_completed_at = progressResult.data.progress_asesmen?.mapa02?.completed_at || null;
                            } else {
                                asesi.mapa02_completed = false;
                                asesi.mapa02_completed_at = null;
                            }
                        } else {
                            asesi.mapa02_completed = false;
                            asesi.mapa02_completed_at = null;
                        }
                    } catch (error) {
                        asesi.mapa02_completed = false;
                        asesi.mapa02_completed_at = null;
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
        const tableBody = document.querySelector('#daftarMAPA02 tbody');

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
            // Use the MAPA02 completion status from progress API
            const hasProgress = asesi.mapa02_completed === true;

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
    }

    function setupSearch() {
        const searchInput = document.getElementById('default-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchValue = this.value.toLowerCase();
                const rows = document.querySelectorAll('#daftarMAPA02 tbody tr');

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

    // Global functions for button clicks
    window.showSummary = function(id_asesi, nama_asesi, nama_skema, progress_percentage, completed_steps, total_steps, mapa02_completed = false) {
        currentAsesiId = id_asesi;

        // Hide search and table
        document.getElementById('searchMAPA02').classList.add('hidden');
        document.getElementById('daftarMAPA02').classList.add('hidden');

        // Show breadcrumbs and detail
        document.getElementById('breadcrumbs').classList.remove('hidden');
        document.getElementById('detailMAPA02').classList.remove('hidden');

        // Update breadcrumb
        const breadcrumbAsesi = document.getElementById('breadcrumbAsesiName');
        if (breadcrumbAsesi) {
            breadcrumbAsesi.textContent = nama_asesi;
        }

        // Load MAPA02 data
        loadMapa02Data(id_asesi);

        // Scroll to detail
        document.getElementById('detailMAPA02').scrollIntoView({ behavior: 'smooth' });
    };

    function loadMapa02Data(id_asesi) {
        const mapa02ApiUrl = `${apiConfig.url}/asesmen/mapa02/${id_asesi}`;

        showLoading();

        fetch(mapa02ApiUrl, {
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
                populateMapa02Form(result.data);
            } else {
                showError(result.message || 'Gagal memuat data MAPA.02');
            }
        })
        .catch(error => {
            showError(`Error memuat data: ${error.message}`);
        });
    }

    function populateMapa02Form(data) {
        // Populate general info
        document.getElementById('judulSertifikasi').textContent = data.general_info.judul_skema;
        document.getElementById('nomorSertifikasi').textContent = data.general_info.kode_skema;
        document.getElementById('namaPeserta').textContent = data.general_info.nama_asesi;
        document.getElementById('namaAsesor').textContent = data.general_info.nama_asesor;
        document.getElementById('tuk').textContent = data.general_info.nama_tuk;

        // If record exists, populate the form fields
        if (recordExists && data.mapa02) {
            const mapa02Data = data.mapa02;

            // Set radio button values
            setRadioValue('muk_ceklis_observasi', mapa02Data.muk_ceklis_observasi);
            setRadioValue('muk_tugas_praktik_demonstrasi', mapa02Data.muk_tugas_praktik_demonstrasi);
            setRadioValue('muk_pertanyaan_tertulis_esai', mapa02Data.muk_pertanyaan_tertulis_esai);
            setRadioValue('muk_pertanyaan_lisan', mapa02Data.muk_pertanyaan_lisan);
            setRadioValue('muk_ceklis_verifikasi_portfolio', mapa02Data.muk_ceklis_verifikasi_portfolio);
            setRadioValue('muk_ceklis_meninjau_materi_uji', mapa02Data.muk_ceklis_meninjau_materi_uji);

            // Disable form if already completed
            if (mapa02Data.waktu_tanda_tangan_asesor) {
                disableFormElements();

                const submitButton = document.getElementById('simpanRekomendasi');
                if (submitButton) {
                    submitButton.textContent = 'Sudah Disetujui';
                    submitButton.disabled = true;
                    submitButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru_soft');
                    submitButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                }
            }
        }

        // Setup form submission if not already completed
        if (!recordExists || !data.mapa02?.waktu_tanda_tangan_asesor) {
            setupFormSubmission();
        }

        // Show main content
        showMainContent();
    }

    function setRadioValue(name, value) {
        const radio = document.querySelector(`input[name="${name}"][value="${value}"]`);
        if (radio) {
            radio.checked = true;
        }
    }

    function disableFormElements() {
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.disabled = true;
        });
    }

    function setupFormSubmission() {
        const form = document.getElementById('mapa02Form');
        if (form) {
            // Remove existing event listeners
            form.replaceWith(form.cloneNode(true));

            // Add new event listener
            document.getElementById('mapa02Form').addEventListener('submit', handleFormSubmit);
        }
    }

    function handleFormSubmit(e) {
        e.preventDefault();

        if (!currentAsesiId) {
            showError('ID Asesi tidak ditemukan');
            return;
        }

        // Collect form data
        const formData = collectFormData();

        if (!validateFormData(formData)) {
            showError('Harap pilih nilai untuk semua MUK');
            return;
        }

        // Show loading state
        const submitButton = document.getElementById('simpanRekomendasi');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Menyimpan...';
        submitButton.disabled = true;

        // Prepare data for API
        const requestData = {
            id_asesi: currentAsesiId,
            id_asesor: apiConfig.asesorId,
            muk_ceklis_observasi: parseInt(formData.muk_ceklis_observasi),
            muk_tugas_praktik_demonstrasi: parseInt(formData.muk_tugas_praktik_demonstrasi),
            muk_pertanyaan_tertulis_esai: parseInt(formData.muk_pertanyaan_tertulis_esai),
            muk_pertanyaan_lisan: parseInt(formData.muk_pertanyaan_lisan),
            muk_ceklis_verifikasi_portfolio: parseInt(formData.muk_ceklis_verifikasi_portfolio),
            muk_ceklis_meninjau_materi_uji: parseInt(formData.muk_ceklis_meninjau_materi_uji),
            is_signing: true
        };

        // Submit to API
        const saveApiUrl = `${apiConfig.url}/asesmen/mapa02/save`;

        fetch(saveApiUrl, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(requestData)
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

                // Reload MAPA02 data to show updated information
                setTimeout(() => {
                    loadMapa02Data(currentAsesiId);
                    // Also reload the asesi list to update the progress status
                    loadAsesiList();
                }, 1000);
            } else {
                throw new Error(result.message || 'Gagal menyimpan data');
            }
        })
        .catch(error => {
            showError(`Error menyimpan data: ${error.message}`);
        })
        .finally(() => {
            // Restore button state
            if (submitButton) {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        });
    }

    function collectFormData() {
        const formData = {};

        // Collect radio button values
        const radioNames = [
            'muk_ceklis_observasi',
            'muk_tugas_praktik_demonstrasi',
            'muk_pertanyaan_tertulis_esai',
            'muk_pertanyaan_lisan',
            'muk_ceklis_verifikasi_portfolio',
            'muk_ceklis_meninjau_materi_uji'
        ];

        radioNames.forEach(name => {
            const checkedRadio = document.querySelector(`input[name="${name}"]:checked`);
            if (checkedRadio) {
                formData[name] = checkedRadio.value;
            }
        });

        return formData;
    }

    function validateFormData(formData) {
        const requiredFields = [
            'muk_ceklis_observasi',
            'muk_tugas_praktik_demonstrasi',
            'muk_pertanyaan_tertulis_esai',
            'muk_pertanyaan_lisan',
            'muk_ceklis_verifikasi_portfolio',
            'muk_ceklis_meninjau_materi_uji'
        ];

        return requiredFields.every(field => formData[field] !== undefined);
    }

    // Add window alias for backward compatibility
    window.showDocument = window.showSummary;
});
</script>
@endsection
