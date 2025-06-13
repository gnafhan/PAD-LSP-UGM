@extends('home.home-asesor.layouts.layout')

@section('title', 'Ketidakberpihakan - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                    <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
                </linearGradient>
            </defs>
            <path d="M11.5898 8.37492H8.96484V7.0178C8.9771 6.42005 9.15243 5.83702 9.47191 5.33167C9.79338 4.79167 9.90956 4.15394 9.79916 3.53527C9.68877 2.91659 9.35918 2.3584 8.87078 1.96292C8.51821 1.6755 8.09697 1.48468 7.64839 1.40919C7.19982 1.3337 6.73932 1.37613 6.3121 1.53232C5.88487 1.68851 5.50559 1.95309 5.21148 2.3001C4.91737 2.64711 4.71852 3.06462 4.63447 3.51167C4.51348 4.1399 4.6301 4.79068 4.96172 5.3378C5.27571 5.82638 5.44972 6.39171 5.46484 6.9723V8.37492H2.83984C2.60778 8.37492 2.38522 8.46711 2.22113 8.6312C2.05703 8.7953 1.96484 9.01786 1.96484 9.24992V10.9999C1.96519 11.2319 2.05749 11.4542 2.22151 11.6183C2.38553 11.7823 2.60789 11.8746 2.83984 11.8749V12.7499C2.84019 12.9819 2.93249 13.2042 3.09651 13.3683C3.26053 13.5323 3.48289 13.6246 3.71484 13.6249H10.7148C10.9468 13.6246 11.1692 13.5323 11.3332 13.3683C11.4972 13.2042 11.5895 12.9819 11.5898 12.7499V11.8749C11.8218 11.8746 12.0442 11.7823 12.2082 11.6183C12.3722 11.4542 12.4645 11.2319 12.4648 10.9999V9.24992C12.4648 9.01786 12.3727 8.7953 12.2086 8.6312C12.0445 8.46711 11.8219 8.37492 11.5898 8.37492ZM5.49547 3.66917C5.54233 3.41783 5.64369 3.17981 5.79242 2.97185C5.94116 2.76389 6.13366 2.59105 6.35637 2.46548C6.57909 2.33992 6.82661 2.26468 7.08153 2.24506C7.33645 2.22544 7.59257 2.26191 7.83188 2.35192C8.07118 2.44192 8.28786 2.58327 8.46667 2.76601C8.64548 2.94876 8.78207 3.16847 8.86684 3.40968C8.95161 3.65089 8.9825 3.90774 8.95733 4.16217C8.93216 4.41661 8.85154 4.66243 8.72116 4.88236C8.39635 5.41265 8.19078 6.00725 8.11872 6.62492H6.31359C6.24475 6.00781 6.03909 5.41384 5.71159 4.8863C5.49155 4.52126 5.41456 4.08765 5.49547 3.66917ZM8.08984 7.49992V8.37492H6.33984V7.49992H8.08984ZM10.7148 12.7499H3.71484V11.8749H10.7148V12.7499ZM2.83984 10.9999V9.24992H11.5898V10.9999H2.83984Z" />
        </svg>
        <p class="ms-2 text-xl font-bold text-black">Ketidakberpihakan</p>
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
                        <a href="{{ route('ketidakberpihakan-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            Ketidakberpihakan
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
    <div id="frameKetidakberpihakan" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Pernyataan Ketidakberpihakan</p>
        <!-- Search Form -->
        <form id="searchKetidakberpihakan" class="max-w-md mb-4 rounded-xl">
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
            <table id="daftarKetidakberpihakan" class="min-w-full bg-white overflow-hidden">
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
        <div id="detailKetidakberpihakan" class="hidden pt-0 p-4 text-black">
            <p id="judulDetail" class="text-lg font-semibold text-sidebar_font">
                    KETIDAKBERPIHAKAN DAN BENTURAN KEPENTINGAN ASESOR
            </p>

            <div id="Ketidakberpihakan" class="p-4 space-y-6">
                {{-- <p id="judulDetail" class="text-lg font-semibold text-sidebar_font">
                    KETIDAKBERPIHAKAN DAN BENTURAN KEPENTINGAN ASESOR
                </p> --}}
                <div class="max-w-full space-y-1">
                    <p class="text-sidebar_font font-normal text-base pb-4">Saya yang bertanda tangan di bawah ini:</p>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            Muhammad Rifai
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Alamat
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            RT.05 RW.028 Karangrejo Tirtomartani Kalasan, Sleman Yogyakarta
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Jabatan
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            Asesor
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor REG
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            MET.000.009362 2015
                        </p>
                    </div>
                    <div class="text-sidebar_font font-normal text-base pt-6">
                        <p class="pb-2">Menyatakan,</p>
                        <ul class="list-decimal text-sidebar_font font-normal text-base ps-6">
                            <li>Menjamin ketidakberpihakan dengan pemohon sertifikat, peserta sertifikasi dan pemegang sertifikasi</li>
                            <li>Menjaga ketidakberpihakan dan tidak akan memberi tekanan komersial, keuangan atau tekanan lainnya yang mengkompromikan ketidakberpihakan</li>
                            <li>Menjamin tidak terjadi konflik kepentingan dan menjamin objektifitas dalam kegiatan sertifikasi.</li>
                        </ul>
                        <p class="pt-2">Demikian surat pernyataan ini saya buat dalam keadaan sadar dan tidak ada tekanan dari pihak manapun.</p>
                    </div>
                </div>
            </div>


            <!-- Tandatangan -->
            <div class="my-6 px-4 space-y-6">
                <div class="flex flex-row justify-end">
                    <!-- Tanda Tangan Asesor -->
                    <div class="flex flex-col items-center justify-center">
                        <p class="font-medium text-sidebar_font">16 Mei 2025</p>
                        <img id="tandaTanganAsesor" src="{{ asset('images/contoh ttd.png') }}" alt="Tanda Tangan Asesi" class="w-60 h-40 border-b border-border_input">
                        <p class="font-medium text-sidebar_font">Asesor</p>
                        <p class="font-normal text-sidebar_font">Nafa Popcorn</p>
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
    document.getElementById('searchKetidakberpihakan').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarKetidakberpihakan').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailKetidakberpihakan').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailKetidakberpihakanl').scrollIntoView({ behavior: 'smooth' });
}
</script>

@endsection
