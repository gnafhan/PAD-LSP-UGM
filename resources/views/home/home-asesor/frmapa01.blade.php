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
                        <a href="{{ route('frmapa01-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            MAPA.01
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
        <div id="detailMAPA01" class="hidden pt-0 p-4 text-black">
            <div id="FRMAPA01" class="p-4 space-y-6">
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
            <div class="px-4 pb-16">
                <p class="block mb-4 text-xl font-bold text-sidebar_font">
                    1. Pendekatan Asesmen
                </p>
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
                                            <input type="radio" name="asesi" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Hasil pelatihan dan/atau pendidikan, dimana kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="asesi" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Pengalaman kerja di bidang terkait dengan kompetensi</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="asesi" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
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
                                            <input type="radio" name="tujuan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Sertifikasi</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="tujuan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Sertifikasi Ulang</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="tujuan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Pengakuan Kompetensi Terkini (PKT)</span>
                                        </label>
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="tujuan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Rekognisi Pembelajaran Lampau (RPL)</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>

                            <!-- 3. Konteks Asesmen -->
                            <tr class="align-middle border-b border-gray-200 grid-rows-10 grid-cols-4">
                                <td class="px-4 py-2 font-semibold">3</td>
                                <td class="px-4 py-2 font-semibold">Konteks Asesmen</td>
                                <td id="clMAPA01no3" class="px-4 py-2 font-normal">
                                    <div id="clMAPA01Konteks1" class="grid grid-cols-2 items-center text-sidebar_font py-2 border-b border-border">
                                        <!-- Kolom 1 (Teks Lingkungan) -->
                                        <p class="self-center">Lingkungan</p>

                                        <!-- Kolom 2 (Radio Buttons) -->
                                        <div class="flex flex-col gap-y-1">
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="konteks" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Tempat Kerja Nyata</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="konteks" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Tempat Kerja Simulasi</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="clMAPA01Konteks2" class="grid grid-cols-2 items-center text-sidebar_font py-2 border-b border-border">
                                        <!-- Kolom 1 (Teks Lingkungan) -->
                                        <p class="self-center">Peluang untuk mengumpulkan bukti dalam sejumlah situasi</p>

                                        <!-- Kolom 2 (Radio Buttons) -->
                                        <div class="flex flex-col gap-y-1">
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="peluang" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Tersedia</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="peluang" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Terbatas</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="clMAPA01Konteks3" class="grid grid-cols-2 items-center text-sidebar_font py-2 border-b border-border">
                                        <!-- Kolom 1 (Teks Lingkungan) -->
                                        <p class="self-center">Hubungan antara standar kompetensi</p>

                                        <!-- Kolom 2 (Radio Buttons) -->
                                        <div class="flex flex-col gap-y-1">
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="hubungan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Bukti untuk mendukung asesmen / RPL </span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="hubungan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Aktivitas kerja di tempat kerja kandidat</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="hubungan" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Kegiatan pembelajaran</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div id="clMAPA01Konteks4" class="grid grid-cols-2 items-center text-sidebar_font py-2">
                                        <!-- Kolom 1 (Teks Lingkungan) -->
                                        <p class="self-center">Siapa yang melakukan asesmen / RPL</p>

                                        <!-- Kolom 2 (Radio Buttons) -->
                                        <div class="flex flex-col gap-y-1">
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="siapa" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Lembaga Sertifikasi</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="siapa" class="w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                                <span>Organisasi pelatihan</span>
                                            </label>
                                            <label class="flex items-center space-x-2">
                                                <input type="radio" name="siapa" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
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
                                            <input type="radio" name="orang" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Manajer sertifikasi LSP</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="orang" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Master Assessor / Master Trainer / Asesor Utama Kompetensi</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="orang" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Manajer pelatihan Lembaga Training terakreditasi / Lembaga Training terdaftar</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="orang" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
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
                                            <input type="radio" name="tolakukur" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Standar Kompetensi Kerja Nasional Indonesia (SKKNI)</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="tolakukur" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Standar Khusus</span>
                                        </label>
                                        <label class="flex items-start space-x-2">
                                            <input type="radio" name="tolakukur" class="mt-1 w-4 h-4 text-biru border-gray-300 focus:ring-biru">
                                            <span>Standar Internasional</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Button Simpan -->
                <div class="flex justify-end pe-4">
                    <button id="simpanSetujui" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru focus:outline-none mt-6">
                        Simpan dan Setujui
                    </button>
                </div>

                <p class="block mt-8 mb-4 text-xl font-bold text-sidebar_font">
                    2. Rencana Asesmen
                </p>
                <div class="w-full border border-border rounded-md p-2 bg-white text-sm text-sidebar_font">
                    <table id="rencanaMAPA01" class="min-w-full bg-white overflow-hidden border border-border rounded-lg text-sm text-gray-600">
                        <thead class="bg-bg_dashboard text-center">
                            <!-- Header Baris Pertama -->
                            <tr>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">No</th>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">Elemen</th>
                                <th rowspan="2" class="px-4 py-3 font-semibold border-b border-gray-200">Bukti-bukti(Kinerja, produk, Portfolio, dan / atau hafalan) diidentifikasi berdasarkan Elemen dan pendekatan asesmen</th>
                                <th colspan="3" class="px-4 py-3 font-semibold border-b border-gray-200">Jenis Bukti</th>
                                <th colspan="4" class="px-4 py-3 font-semibold border-b border-gray-200">Metode dan Perangkat Asesmen</th>
                            </tr>
                            <!-- Header Baris Kedua -->
                            <tr>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">L</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">TL</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">T</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">Observasi Langsung</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">Kegiatan Terstruktur</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">Tanya Jawab</th>
                                <th class="px-4 py-3 font-semibold border-b border-gray-200">Verifikasi Portofolio</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-center">
                            <tr class="text-black">
                                <td class="px-4 py-3">1</td>
                                <td class="px-4 py-3 text-left">
                                    <p>Ceklis Observasi Untuk Aktivitas di Tempat Kerja atau Tempat Kerja Simulasi</p>
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <p>Hasil Observasi Memproses dokumen kantor</p>
                                </td>
                                @for ($i = 0; $i < 3; $i++)
                                    <td class="px-4 py-3">
                                        <input id="disc-awal-{{ $i }}" type="radio" value="{{ $i }}" name="disc_awal"
                                            class="w-4 h-4 text-biru bg-gray-100 border-border focus:ring-biru">
                                    </td>
                                @endfor
                                @for ($i = 0; $i < 4; $i++)
                                    <td class="px-4 py-3">
                                        <input id="disc-lanjutan-{{ $i }}" type="radio" value="{{ $i }}" name="disc_lanjutan"
                                            class="w-4 h-4 text-biru bg-gray-100 border-border focus:ring-biru">
                                    </td>
                                @endfor
                                
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p class="block mt-8 mb-4 text-xl font-bold text-sidebar_font">
                    3. Modifikasi dan Kontekstualisasi :
                </p>
                <form class="text-sidebar_font">
                    <div class="mb-6">
                        <label for="batasFisik" class="block mb-2 text-sm font-medium">3.1 Karakteristik kandidat (Keterbatasan fisik/Keterbatasan mental)</label>
                        <input type="text" id="batasFisik" class="bg-white border border-border_input text-gray-900 text-sm rounded-lg focus:ring-biru focus:border-biru block w-full p-2.5 placeholder-placeholder_input" placeholder="Tulis 'Tidak Ada' bila tidak terdapat keterbatadan fisik/mental" required />
                    </div>
                    <div class="mb-6">
                        <label for="batasFisik" class="block mb-2 text-sm font-medium">3.2 Kebutuhan kontekstualisasi:</label>
                        <input type="text" id="batasFisik" class="bg-white border border-border_input text-gray-900 text-sm rounded-lg focus:ring-biru focus:border-biru block w-full p-2.5 placeholder-placeholder_input" placeholder="Tulis 'Tidak Ada' bila tidak ada kebutuhan kontekstualisasi" required />
                    </div>
                    <div class="mb-6">
                        <label for="batasFisik" class="block mb-2 text-sm font-medium">3.3 Saran yang diberikan oleh paket pelatihan atau pengembang pelatihan</label>
                        <input type="text" id="batasFisik" class="bg-white border border-border_input text-gray-900 text-sm rounded-lg focus:ring-biru focus:border-biru block w-full p-2.5 placeholder-placeholder_input" placeholder="Tulis 'Tidak Ada' bila tidak ada saran" required />
                    </div>
                    <div class="mb-6">
                        <label for="batasFisik" class="block mb-2 text-sm font-medium">3.4 Peluang untuk kegiatan asesmen terintegrasi dan mencatat setiap perubahan yang diperlukan untuk alat asesmen</label>
                        <input type="text" id="batasFisik" class="bg-white border border-border_input text-gray-900 text-sm rounded-lg focus:ring-biru focus:border-biru block w-full p-2.5 placeholder-placeholder_input" placeholder="Tulis 'Tidak Ada' bila tidak ada keterangan" required />
                    </div>
                </form>

                <p class="block mt-8 mb-4 text-xl font-bold text-sidebar_font">
                    4. Hasil
                </p>
                <div id="hasilMAPA01" class="space-y-4">
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                                Hari / tanggal asesmen
                            </span>
                            <p id="tanggalAsesmen" type="text" class="peer text-sidebar_font py-1 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            Rabu. 5 Maret 2025
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Jam
                            </span>
                            <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-1 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            19:30
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Tempat Asesmen
                            </span>
                            <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-1 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            TILC
                            </p>
                        </div>
                    </div>
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font font-semibold -mt-px -ms-px w-1/3">
                                Orang yang relevan untuk di Konfirmasi
                            </span>
                        </div>
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Manajer Sertifikasi LSP
                            </span>
                            <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                                Nafa Popcorn
                            </p>
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

<script>
function showSummary() {

    // Sembunyikan elemen pencarian utama
    document.getElementById('searchMAPA01').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarMAPA01').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailMAPA01').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailMAPA01').scrollIntoView({ behavior: 'smooth' });
}
</script>

@endsection
