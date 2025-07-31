@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.AK-02 - Asesor')

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
                        <a href="{{ route('frak02-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.AK.02
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
        <span>Memuat data AK02...</span>
    </div>

    <!-- Error Message -->
    <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="errorText">Terjadi kesalahan saat memuat data.</span>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
        <span id="successText">Data berhasil disimpan.</span>
    </div>

    <div id="frameAK02" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir AK.02 Rekaman Asesmen Kompetensi</p>
        <!-- Search Form -->
        <form id="searchAK02" class="max-w-md mb-4 rounded-xl">
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
            <table id="daftarAK02" class="min-w-full bg-white overflow-hidden">
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
        <div id="detailAK02" class="hidden pt-0 p-4 text-black">
            <p id="descDetail" class="font text-sidebar_font">Persetujuan ini untuk menjamin bahwa peserta sertifikasi/asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen</p>

            <!-- Input Formulir AK02 -->
            <form id="ak02Form">
                <div id="FRAK02" class="p-4 space-y-6">
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                                Judul Sertifikasi
                            </span>
                            <p id="judulSertifikasi" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nomor Sertifikasi
                            </span>
                            <p id="nomorSertifikasi" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                    </div>
                    <div class="max-w-full space-y-1">
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nama Peserta Sertifikasi
                            </span>
                            <p id="namaPeserta" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
                                Memuat...
                            </p>
                        </div>
                        <div class="flex">
                            <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                                Nama Asesor
                            </span>
                            <p id="namaAsesor" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none">
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

                <!-- Checklist Hasil Pengumpulan -->
                <div class="p-4">
                    <h1 class="block mb-2 font-semibold text-sidebar_Font text-sidebar_font">
                        Kelompok Pekerjaan Kegiatan Rekreasi
                    </h1>
                    <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                        <table id="pelaksanaanAsesmen" class="min-w-full bg-white overflow-hidden">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Menangani Situasi Konfik</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Menangani Situasi Konfik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-black text-center items-center" id="hasilKelompokPekerjaan">
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">Mengidentifikasi situasi konflik ?</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

</div>
<div class="p-4">
                    <h1 class="justify-center text-center block mb-2 font-semibold text-sidebar_Font text-sidebar_font">
                        Instruksi Kerja
                    </h1>
                        <textarea id="inputInstruksiKerja" rows="4" class="block p-2.5 w-full text-sm text-sidebar_font rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Masukkan Instruksi Kerja">
                            Tulis disini:
Skenario
Narasikan tugas yang harus dikerjakan oleh Asesi.
A. Studi Kasus
Anda sebagai seorang Pemandu Museum/Edukator mendapat tugas untuk melakukan pemanduan di museum dengan peserta 10 orang pengunjung, dengan latar belakang yang berbeda. Bagaimana strategi anda sebagai Pemandu Museum dalam mengelola kunjungan, terkait dengan pemanduan museum!
B. Instruksi Kerja dan demonstrasikan unjuk kerja di bawah ini :
1. Grooming / Penampilan kerja dari edukator.
2. Salam pembuka (Greeting dalam Bahasa Inggris).
3. Briefing / panduan awal pengunjung (Informasikan Prosedur Protokol kesehatan dan pembagian tugas antar edukator).
a. Informasikan waktu kunjungan di museum dan peraturan selama kunjungan.
b. Informasikan kepada pungunjung aksesibilitas dari setiap museum diatas, baik dalam hal sarana prasarananya, etika di museum tersebut. (baik etika secara umum maupun etika secara lokal di museum tersebut).
4. Siapkan perangkat pemanduan/sarana dan prasarana.
5. Memberi informasi yang atraktif dan edutainment.
6. Closing pemanduan.
                        </textarea>
                    
</div>
<div class="p-4">

                    <h1 class="block mb-2 font-semibold text-sidebar_Font text-sidebar_font">
                        Ketentuan Kompetensi
                    </h1>
                    <p class="block mb-2 text-sidebar_Font text-sidebar_font">
                        Beri tanda centang (V) di kolom yang sesuai untuk mencerminkan bukti yang diperoleh untuk menentukan Kompetensi asesi untuk setiap Unit Kompetensi
                    </p>
                    <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                        <table id="pelaksanaanAsesmen" class="min-w-full bg-white overflow-hidden">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Unit Kompetensi</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Observasi Demonstrasi</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Porfolio</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Pernyataan Pihak Ketiga Pertanyaan Wawancara</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Pertanyaan Lisan</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Pertanyaan Tertulis</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Proyek Kerja</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none w-16">Lainnya</th>
                                </tr>
                            </thead>
                            <tbody id="hasilKetentuanKompetensi" class="divide-y divide-gray-200 text-black text-center items-center">
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">Mengidentifikasi situasi konflik?</td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                    <td class="px-4 py-3 justify-center"><input type="checkbox"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


</div>
<div class="p-4">

                <label for="inputRekomendasiHasil" class="block mb-2 font-medium text-sidebar_font">
Rekomendasi Hasil Asesmen
                </label>
<div class="mt-2">
                    <select id="inputRekomendasiHasil" name="metodeUji" autocomplete="metodeUji" class="w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                        <option value="1">Kompeten</option>
                        <option value="0">Belum Kompeten</option>
                    </select>
                </div>
                </div>

                <div class="p-4">
                    <h1 class="block mb-2 font-semibold text-sidebar_Font text-sidebar_font">
                        Tindak Lanjut Yang Dibutuhkan (Masukkan pekerjaan tambahan dan asesmen yang diperlukan untuk mencapai kompetensi)
                    </h1>
                        <textarea id="inputTindakLanjut" rows="4" class="block p-2.5 w-full text-sm text-sidebar_font rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Masukkan Instruksi Kerja">
                            Tulis disini:
---- Tidak Ada
                        </textarea>
                    
</div>

<div class="p-4">
                    <h1 class="block mb-2 font-semibold text-sidebar_Font text-sidebar_font">
                        Komentar/Observasi oleh Asesor
                    </h1>
                        <textarea id="inputKomentarObservasi" rows="4" class="block p-2.5 w-full text-sm text-sidebar_font rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Masukkan Instruksi Kerja">
                            Tulis disini:
---- Tidak Ada
                        </textarea>
                    
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
                                    Data yang saya masukkan sudah benar dan saya menyetujui formulir AK02 ini
                                </label>
                            </div>
                        </div>
                    </div>

                <!-- Button Simpan -->
                <div class="flex justify-end pe-4">
                    <button id="simpanAK02" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru focus:outline-none mt-6">
                        Saya Menyetujui
                    </button>
                </div>
            </form>
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
                    Apakah Anda yakin ingin menyetujui dan menandatangani formulir FR.AK-02 ini?
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
        document.querySelector('#daftarAK02 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak ditemukan</td>
            </tr>
        `;
        return;
    }

    if (!apiConfig.key) {
        showError('Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        document.querySelector('#daftarAK02 tbody').innerHTML = `
            <tr>
                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak ditemukan</td>
            </tr>
        `;
        return;
    }

    if (!apiConfig.asesorId) {
        showError('ID Asesor tidak ditemukan. Silakan login kembali.');
        document.querySelector('#daftarAK02 tbody').innerHTML = `
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
                                asesi.ak02_completed = progressResult.data.progress_asesmen?.ak02?.completed || false;
                                asesi.ak02_completed_at = progressResult.data.progress_asesmen?.ak02?.completed_at || null;
                                asesi.progress_percentage = progressResult.data.progress_summary?.progress_percentage || 0;
                                asesi.completed_steps = progressResult.data.progress_summary?.completed_steps || 0;
                                asesi.total_steps = progressResult.data.progress_summary?.total_steps || 0;
                            } else {
                                asesi.ak02_completed = false;
                                asesi.ak02_completed_at = null;
                                asesi.progress_percentage = 0;
                                asesi.completed_steps = 0;
                                asesi.total_steps = 0;
                            }
                        } else {
                            asesi.ak02_completed = false;
                            asesi.ak02_completed_at = null;
                            asesi.progress_percentage = 0;
                            asesi.completed_steps = 0;
                            asesi.total_steps = 0;
                        }
                    } catch (error) {
                        asesi.ak02_completed = false;
                        asesi.ak02_completed_at = null;
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

                const tableBody = document.querySelector('#daftarAK02 tbody');

                if (asesisData && asesisData.length > 0) {
                    let tableContent = '';

                    asesisData.forEach((asesi, index) => {
                        // Use the ak02 completion status from progress API
                        const hasProgress = asesi.ak02_completed === true;
                        const progressPercent = asesi.progress_percentage || 0;
                        const completedSteps = asesi.completed_steps || 0;
                        const totalSteps = asesi.total_steps || 0;

                        // Select appropriate icon based on ak02 completion
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
                    const rows = document.querySelectorAll('#daftarAK02 tbody tr');

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
                document.querySelector('#daftarAK02 tbody').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
                showMessage(`Gagal memuat data: ${result.message || 'Terjadi kesalahan'}`, 'error');
            }
        } catch (error) {
            document.querySelector('#daftarAK02 tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
            showMessage(`Error memuat data: ${error.message}`, 'error');
        }
    }

    // Load AK02 data for specific asesi
    function loadAK02Data(asesiId) {
        if (!asesiId) return;

        showMessage('Memuat data AK02...', 'loading', 0);

        const ak02ApiUrl = `${apiConfig.url}/asesmen/ak02/${asesiId}`;

        fetch(ak02ApiUrl, {
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
            showMessage('', 'loading'); // Hide loading

            if (result.status === 'success' && result.data) {
                const data = result.data;
                // if (data.ak02) {
                //     data.ak02.instruksi_kerja= "asd ad asd ";
                //     data.ak02.ketentuan_kompetensi= [
                //         {
                //             item: "Menangani Situasi Konflik",
                //             bukti: 0
                //         },
                //         {
                //             item: "Menangani Situasi Konflik0",
                //             bukti: 0
                //         },
                //         {
                //             item: "Menangani Situasi Konflik1",
                //             bukti: 0
                //         },
                //         {
                //             item: "Menangani Situasi Konflik2",
                //             bukti: 3
                //         },
                //         {
                //             item: "Menangani Situasi Konflik2",
                //             bukti: 4
                //         }
                //     ];
                //     data.ak02.rekomendasi_hasil=1;
                //     data.ak02.tindak_lanjut="tidak ada";
                //     data.ak02.komentar_observasi="bagus";
                // }
                console.log(data);
                recordExists = data.record_exists || false;
                // Populate general info
                if (data.general_info) {
                    document.getElementById('judulSertifikasi').textContent = data.general_info.judul_skema || 'N/A';
                    document.getElementById('nomorSertifikasi').textContent = data.general_info.kode_skema || 'N/A';
                    document.getElementById('namaPeserta').textContent = data.general_info.nama_asesi || 'N/A';
                    document.getElementById('namaAsesor').textContent = data.general_info.nama_asesor || 'N/A';
                    document.getElementById('tuk').textContent = data.general_info.nama_tuk || 'N/A';
                    document.getElementById('breadcrumbAsesiName').textContent = data.general_info.nama_asesi || 'Detail AK02';
                }

                // Populate hasil yang akan dikumpulkan
                // populateHasilCheckboxes(data.ak02?.hasil_yang_akan_dikumpulkan || []);
                populateKelompokPekerjaan();
                populateKetentuanKompetensi(data.ak02?.ketentuan_kompetensi || []);
                document.getElementById('inputRekomendasiHasil').value = data.ak02?.rekomendasi_hasil || 0;
                document.getElementById('inputTindakLanjut').value = data.ak02?.tindak_lanjut || "Tulis disini:";
                document.getElementById('inputInstruksiKerja').value = data.ak02?.instruksi_kerja || "Tulis disini:";
                document.getElementById('inputKomentarObservasi').value = data.ak02?.komentar_observasi || "Tulis disini:";


                // Show existing signatures if available
                if (recordExists && data.ak02) {
                    console.log('asndjax');
                    // Show asesor signature if available and disable form
                    if (data.ak02.tanda_tangan_asesor && data.ak02.tanda_tangan_asesor !== "null") {
                    console.log('wooah');
                        const asesorImage = document.getElementById('asesor-signature-image');
                        const asesorContent = document.getElementById('asesor-signature-content');
                        const asesorPreview = document.getElementById('asesor-signature-preview');
                        const tanggalAsesor = document.getElementById('tanggalTandaTanganAsesor');
                        const signingCheckbox = document.getElementById('is_asesor_signing');
                        const submitButton = document.getElementById('simpanAK02');

                        if (asesorImage && asesorContent && asesorPreview) {
                            asesorImage.src = data.ak02.tanda_tangan_asesor;
                            asesorContent.classList.add('hidden');
                            asesorPreview.classList.remove('hidden');

                            if (tanggalAsesor && data.ak02.waktu_tanda_tangan_asesor) {
                                tanggalAsesor.textContent = `Tanggal: ${data.ak02.waktu_tanda_tangan_asesor}`;
                            }
                        }

                        // Disable form elements
                        if (signingCheckbox) {
                            signingCheckbox.checked = true;
                            signingCheckbox.disabled = true;
                        }

                        // Disable all checkboxes
                        const checkboxes = document.querySelectorAll('input.inputKetentuanKompetensi');
                        checkboxes.forEach(checkbox => {
                            checkbox.disabled = true;
                        });

                        document.getElementById('inputRekomendasiHasil').disabled = true;
                        document.getElementById('inputTindakLanjut').disabled = true;
                        document.getElementById('inputInstruksiKerja').disabled = true;
                        document.getElementById('inputKomentarObservasi').disabled = true;

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

                showMessage('Data AK02 berhasil dimuat', 'success', 3000);
            } else {
                showMessage('Gagal memuat data AK02: ' + (result.message || 'Terjadi kesalahan'), 'error');
            }
        })
        .catch(error => {
            showMessage('Error memuat data AK02: ' + error.message, 'error');
        });
    }

    // Populate hasil checkboxes
    // function populateHasilCheckboxes(selectedResults = []) {
    //     // const container = document.getElementById('hasil_yang_akan_dikumpulkan');

    //     const defaultOptions = [
    //         'Hasil Observasi Langsung',
    //         'Hasil Tes Tertulis',
    //         'Hasil Tes Lisan',
    //         'Hasil Portofolio',
    //         'Hasil Tes Praktik',
    //         'Hasil Wawancara'
    //     ];

    //     let checkboxContent = '';
    //     defaultOptions.forEach((option, index) => {
    //         const isChecked = Array.isArray(selectedResults) && selectedResults.includes(option) ? 'checked' : '';

    //         checkboxContent += `
    //             <div class="flex items-center">
    //                 <input id="hasil_checkbox_${index}" name="hasil_yang_akan_dikumpulkan[]" type="checkbox" value="${option}" class="w-4 h-4 text-biru border-border_input rounded-sm" ${isChecked}>
    //                 <label for="hasil_checkbox_${index}" class="ms-2 text-sm font-medium text-sidebar_font">${option}</label>
    //             </div>
    //         `;
    //     });

    //     // container.innerHTML = checkboxContent;
    // }

    function populateKelompokPekerjaan() {
        const container = document.getElementById('hasilKelompokPekerjaan');

        // data skema di sini
        const defaultOptions = [
            {
                nomor: "R.93KPW00.011.2",
                deskripsi: "Mengidentifikasi situasi konflik ?"
            },
            {
                nomor: "R.93KPW00.011.3",
                deskripsi: "Mengikuti Prosedur Kesehatan, Keselamatan dan Keamanan di Tempat Kerja"
            },
            {
                nomor: "R.93KPW00.011.4",
                deskripsi: "Melakukan Pekerjaan Dalam Lingkungan Sosial yang Berbeda"
            },
            {
                nomor: "R.93KPW00.011.5",
                deskripsi: "Melakukan Komunikasi Melalui Telepon"
            },
            {
                nomor: "R.93KPW00.011.6",
                deskripsi: "Melakukan Prosedur Administrasi"
            },
            {
                nomor: "R.93KPW00.011.7",
                deskripsi: "Mencari Data di Komputer"
            },
            {
                nomor: "R.93KPW00.011.8",
                deskripsi: "Mengembangkan dan Memutakhirkan Pengetahuan Pariwisata"
            },
            {
                nomor: "R.93KPW00.011.9",
                deskripsi: "Mengimplementasikan Dasar-dasar Kepemanduan Museum"
            },
            {
                nomor: "R.93KPW00.011.0",
                deskripsi: "Mengembangkan Pengetahuan Tentang Koleksi dan Tata Pameran Museum"
            },
            {
                nomor: "R.93KPW00.011.1",
                deskripsi: "Menyajikan Informasi tentang Koleksi dan Tata Pameran Museum"
            },
            {
                nomor: "R.93KPW00.012.2",
                deskripsi: "Melakukan Kegiatan Interpretatif"
            },
            {
                nomor: "R.93KPW00.013.2",
                deskripsi: "Memandu Rombongan Pengunjung"
            }
        ];

        let checkboxContent = '';
        defaultOptions.forEach((option, index) => {
            // const isChecked = Array.isArray(selectedResults) && selectedResults.includes(option) ? 'checked' : '';

            checkboxContent += `
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">${index+1}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${option.nomor}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${option.deskripsi}</td>
                    </tr>
            `;
        });

        container.innerHTML = checkboxContent;
    }
    function populateKetentuanKompetensi(selectedResults = []) {
        const container = document.getElementById('hasilKetentuanKompetensi');

        // data skema di sini
        const defaultOptions = [
            "Menangani Situasi Konflik",
            "Menangani Situasi Konflik0",
            "Menangani Situasi Konflik1",
            "Menangani Situasi Konflik2",
            "Menangani Situasi Konflik3",
            "Menangani Situasi Konflik4",
            "Menangani Situasi Konflik5",
            "Menangani Situasi Konflik6",
            "Menangani Situasi Konflik7",
        ];

        let checkboxContent = '';
        defaultOptions.forEach((option, index) => {
            const isChecked = (val) => {
                return Array.isArray(selectedResults) && selectedResults.some(obj => obj.item === option && obj.bukti === val)
                    ? 'checked'
                    : '';
            };
            // const isChecked = Array.isArray(selectedResults) && sselectedResults.some(obj => obj.item === option.item && obj.bukti === 1) ? 'checked' : '';

            checkboxContent += `
                    <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">${index+1}</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">${option}</td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=0 ${isChecked(0)}></td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=1 ${isChecked(1)}></td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=2 ${isChecked(2)}></td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=3 ${isChecked(3)}></td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=4 ${isChecked(4)}></td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=5 ${isChecked(5)}></td>
                                    <td class="px-4 py-3 justify-center"><input class="inputKetentuanKompetensi" type="checkbox" name="${option}" value=6 ${isChecked(6)}></td>
                                </tr>
            `;
        });

        container.innerHTML = checkboxContent;
    }

    // Function to save AK02 data
    function saveAK02Data() {
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
        const checkboxes = document.querySelectorAll('input.inputKetentuanKompetensi:checked');
        checkboxes.forEach(checkbox => {
            selectedHasil.push({
                item: checkbox.name,
                bukti: checkbox.value
            });
        });

        // if (selectedHasil.length === 0) {
        //     showMessage('Pilih minimal satu hasil yang akan dikumpulkan', 'error');
        //     return;
        // }

        const selectedInstruksiKerja = document.getElementById("inputInstruksiKerja").value;
        const selectedRekomendasiHasil = document.getElementById("inputRekomendasiHasil").value;
        const selectedTindakLanjut = document.getElementById("inputTindakLanjut").value;
        const selectedKomentarObservasi = document.getElementById("inputKomentarObservasi").value;

        showMessage('Menyimpan data AK02...', 'loading', 0);

        // Prepare data for API
        const requestData = {
            id_asesi: currentAsesiId,
            id_asesor: apiConfig.asesorId,
            ketentuan_kompetensi: selectedHasil,
            instruksi_kerja: selectedInstruksiKerja,
            rekomendasi_hasil: selectedRekomendasiHasil,
            tindak_lanjut: selectedTindakLanjut,
            komentar_observasi: selectedKomentarObservasi,
            is_signing: true
        };
        console.log(JSON.stringify(requestData));
        // Submit to API
        const saveApiUrl = `${apiConfig.url}/asesmen/ak02/asesor/save`;

        fetch(saveApiUrl, {
            method: 'POST',
            headers: {
                ...headers,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            showMessage('', 'loading'); // Hide loading

            if (result.status === 'success') {
                showMessage('Data AK02 berhasil disimpan dan ditandatangani!', 'success');

                // Reload AK02 data to show updated information
                setTimeout(() => {
                    loadAK02Data(currentAsesiId);
                    // Also reload the asesi list to update the progress status
                    loadAsesiData();
                }, 1000);
            } else {
                showMessage('Gagal menyimpan data AK02: ' + (result.message || 'Terjadi kesalahan'), 'error');
            }
        })
        .catch(error => {
            showMessage('Error menyimpan data AK02: ' + error.message, 'error');
        });
    }

    // Button click handler with confirmation modal
    document.getElementById('simpanAK02')?.addEventListener('click', function(e) {
        e.preventDefault();

        showConfirmationModal(
            'Konfirmasi Persetujuan',
            `Apakah Anda yakin ingin menyetujui dan menandatangani formulir FR.AK-02 ini?
            <br><br>
            <strong class="text-red-600">Perhatian:</strong> Data yang sudah disetujui dan ditandatangani tidak dapat diubah lagi.
            <br><br>
            Pastikan semua informasi sudah benar sebelum melanjutkan.`,
            function() {
                // User confirmed, proceed with saving
                saveAK02Data();
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
    window.showSummary = function(asesiId, asesiName, skemaName, progressPercent, completedSteps, totalSteps, ak02Completed = false) {
        currentAsesiId = asesiId;

        // Hide main elements and show detail
        document.getElementById('searchAK02').classList.add('hidden');
        document.getElementById('daftarAK02').classList.add('hidden');
        document.getElementById('breadcrumbs').classList.remove('hidden');
        document.getElementById('detailAK02').classList.remove('hidden');

        // Load AK02 data for this asesi
        loadAK02Data(asesiId);

        // Scroll to detail
        document.getElementById('detailAK02').scrollIntoView({ behavior: 'smooth' });
    };

    // Global function alias for showDocument (if needed)
    window.showDocument = window.showSummary;
});

// Table sorting function
function sortTable(columnIndex) {
    const table = document.getElementById('daftarAK02');
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
