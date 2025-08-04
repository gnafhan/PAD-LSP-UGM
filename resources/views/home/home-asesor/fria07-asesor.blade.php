@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.IA.07 - Asesor')

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
        <p class="ms-2 text-xl font-bold text-black">IA.01</p>
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
                        <a href="{{ route('fria07-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.IA.07
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
    <div id="frameIA07" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir IA.02 Tugas Praktik dan Demonstrasi</p>
        <!-- Search Form -->
        <form id="searchIA07" class="max-w-md mb-4 rounded-xl">
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
            <table id="daftarIA07" class="min-w-full bg-white overflow-hidden">
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
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="detailIA07" class="hidden p-4 text-black">

            <!-- Input Formulir APL.02 -->
            <div id="FRIA07" class="pt-0 p-4 space-y-6">
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

            {{-- Tabel Kode Unit --}}
            <div class="p-4">
                <p id="judulTabelIA07" class="text-sidebar_font font-semibold pb-2">No 1.  Kode Unit : R.93KPW00.011.2</p>

                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table id="pelaksanaanAsesmen" class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider w-12">Kirim Jawaban</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider text-left">Judul Unit Kompetensi</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider w-32">Kode Unit Kompetensi</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider w-36">Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black text-center">
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <button onclick="showModal()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                        Kirim
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left text-sm">Mengimplementasikan Dasar-dasar Kepemanduan Museum</td>
                                <td class="px-4 py-3 text-gray-700 text-sm">BUD.PM02.001.01</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        Sudah Diisi
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <button onclick="showModal()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                        Kirim
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left text-sm">Mengimplementasikan Dasar-dasar Kepemanduan Museum</td>
                                <td class="px-4 py-3 text-gray-700 text-sm">BUD.PM02.001.01</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        Sudah Diisi
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <button onclick="showModal()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                        Kirim
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left text-sm">Mengimplementasikan Dasar-dasar Kepemanduan Museum</td>
                                <td class="px-4 py-3 text-gray-700 text-sm">BUD.PM02.001.01</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        Sudah Diisi
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <button onclick="showModal()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                        Kirim
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left text-sm">Mengimplementasikan Dasar-dasar Kepemanduan Museum</td>
                                <td class="px-4 py-3 text-gray-700 text-sm">BUD.PM02.001.01</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
                                        Sudah Diisi
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center">
                                    <button onclick="showModal()" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                        </svg>
                                        Kirim
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left text-sm">Mengimplementasikan Dasar-dasar Kepemanduan Museum</td>
                                <td class="px-4 py-3 text-gray-700 text-sm">BUD.PM02.001.01</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-lg">
                                        Belum Diisi
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            

        </div>
    </div>

    {{-- Modal Kirim --}}
    <div id="modal-container" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-start py-4 overflow-y-auto">
        <div class="relative bg-white w-full max-w-lg max-h-[calc(100vh-2rem)] overflow-hidden rounded-lg shadow-xl mx-4 my-auto">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Unit Kompetensi</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center" onclick="closeModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(100vh-10rem)] space-y-4">
                <div class="mb-5">
                    <label for="keterangan" class="block mb-2 text-sm font-medium text-gray-900">Apa yang anda lakukan dalam menerapkan prinsip dasar Edutainment?</label>
                    <div class="block p-2.5 w-full text-sm text-gray-700 bg-gray-50 rounded-lg border border-gray-200 min-h-[100px] max-h-[150px] overflow-y-auto">
                        Saya mengidentifikasi kebutuhan pengunjung melalui beberapa cara: 1) Melakukan observasi terhadap perilaku dan respons pengunjung saat berkeliling museum, 2) Mengajukan pertanyaan sederhana untuk mengetahui latar belakang dan minat mereka, 3) Memperhatikan kelompok usia dan demografi pengunjung untuk menyesuaikan gaya komunikasi, 4) Memberikan kuesioner singkat atau feedback form untuk mendapatkan masukan langsung dari pengunjung tentang pengalaman mereka.
                        Saya mengidentifikasi kebutuhan pengunjung melalui beberapa cara: 1) Melakukan observasi terhadap perilaku dan respons pengunjung saat berkeliling museum, 2) Mengajukan pertanyaan sederhana untuk mengetahui latar belakang dan minat mereka, 3) Memperhatikan kelompok usia dan demografi pengunjung untuk menyesuaikan gaya komunikasi, 4) Memberikan kuesioner singkat atau feedback form untuk mendapatkan masukan langsung dari pengunjung tentang pengalaman mereka.
                        Saya mengidentifikasi kebutuhan pengunjung melalui beberapa cara: 1) Melakukan observasi terhadap perilaku dan respons pengunjung saat berkeliling museum, 2) Mengajukan pertanyaan sederhana untuk mengetahui latar belakang dan minat mereka, 3) Memperhatikan kelompok usia dan demografi pengunjung untuk menyesuaikan gaya komunikasi, 4) Memberikan kuesioner singkat atau feedback form untuk mendapatkan masukan langsung dari pengunjung tentang pengalaman mereka.
                    
                    </div>
                    <p class="text-xs text-gray-500 mt-1">*Jawaban dari asesi (tidak dapat diedit)</p>
                </div>
                <div class="mb-5">
                    <label for="kompetensi" class="block mb-2 text-sm font-medium text-gray-900">Penilaian Kompetensi</label>
                    <select id="kompetensi" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Pilih Penilaian --</option>
                        <option value="kompeten">Kompeten</option>
                        <option value="belum_kompeten">Belum Kompeten</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="keterangan2" class="block mb-2 text-sm font-medium text-gray-900">Bagaimana cara anda mengidentifikasi kebutuhan dan karakteristik pengunjung museum?</label>
                    <div class="block p-2.5 w-full text-sm text-gray-700 bg-gray-50 rounded-lg border border-gray-200 min-h-[100px] max-h-[150px] overflow-y-auto">
                        Saya mengidentifikasi kebutuhan pengunjung melalui beberapa cara: 1) Melakukan observasi terhadap perilaku dan respons pengunjung saat berkeliling museum, 2) Mengajukan pertanyaan sederhana untuk mengetahui latar belakang dan minat mereka, 3) Memperhatikan kelompok usia dan demografi pengunjung untuk menyesuaikan gaya komunikasi, 4) Memberikan kuesioner singkat atau feedback form untuk mendapatkan masukan langsung dari pengunjung tentang pengalaman mereka.
                    </div>
                    <p class="text-xs text-gray-500 mt-1">*Jawaban dari asesi (tidak dapat diedit)</p>
                </div>
                <div class="mb-5">
                    <label for="kompetensi2" class="block mb-2 text-sm font-medium text-gray-900">Penilaian Kompetensi</label>
                    <select id="kompetensi2" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Pilih Penilaian --</option>
                        <option value="kompeten">Kompeten</option>
                        <option value="belum_kompeten">Belum Kompeten</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end p-6 border-t border-gray-200 space-x-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">Tutup</button>
                <button type="button" class="px-4 py-2 text-white bg-gradient-to-br from-biru to-ungu rounded-lg hover:from-ungu hover:to-biru transition-colors">Simpan</button>
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
    document.getElementById('searchIA07').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarIA07').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailIA07').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailIA07').scrollIntoView({ behavior: 'smooth' });
}
function showModal() {
    document.getElementById('modal-container').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal-container').classList.add('hidden');
}
</script>

@endsection
