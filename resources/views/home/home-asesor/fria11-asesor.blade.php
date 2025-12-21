@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.IA.11 - Asesor')

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
        <p class="ms-2 text-xl font-bold text-black">IA.11</p>
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
                        <a href="{{ route('fria11-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.IA.11
                        </a>
                    </div>
                </li>
                <!-- Memanggil data nama asesi -->
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-black" id="breadcrumbAsesiName">Nama Asesi</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    
    <div id="frameIA11" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir IA.11 Ceklis Meninjau Instrumen Asesmen</p>
        
        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- Search Form --}}
        <form id="searchIA11" class="max-w-md mb-4 rounded-xl @if($detailRincian) hidden @endif">
            <div class="relative">
                <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
        
        {{-- Table Daftar Asesi --}}
        <div class="overflow-x-auto shadow-sm rounded-lg @if($detailRincian) hidden @endif">
            <table id="daftarIA11" class="min-w-full bg-white overflow-hidden">
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
                @if($daftarAsesi->count() > 0)
                    @foreach($daftarAsesi as $i => $rincian)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $i+1 }}</td>
                            <td class="px-4 py-3 text-center">
                                <button onclick="window.location.href='{{ route('fria11-asesor') }}?id_asesi={{ $rincian->id_asesi }}'" class="">
                                    <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button onclick="showDocument('{{ $rincian->asesi->id_asesi }}')" class="ml-2" title="Print/Download PDF">
                                    <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </td>
                            <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->nama_asesi ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->skema->nama_skema ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->skema->nomor_skema ?? '-' }}</td>
                            <td class="px-4 py-0">
                                <div class="flex px-4 py-3 justify-center items-center">
                                    @php
                                        $progress = $rincian->asesi->progresAsesmen->ia11 ?? 'not_started';
                                    @endphp
                                    @if($progress == 'completed')
                                        <svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                                        </svg>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg font-medium">Tidak ada data asesi</p>
                                <p class="text-sm">Belum ada asesi yang terdaftar untuk Anda</p>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        
        {{-- Detail Section --}}
        <div id="detailIA11" class="@if($detailRincian) p-4 text-black @else hidden @endif">

            {{-- Input Formulir IA.11 --}}
            <div id="FRIA11" class="pt-0 p-4 space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-sidebar_font">FR.IA.11. Ceklis Meninjau Instrumen Asesmen</h2>
                    <div></div> <!-- Spacer for flexbox alignment -->
                </div>

                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ optional(optional($detailRincian)->asesi)->skema->nama_skema ?? '-' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ optional(optional($detailRincian)->asesi)->skema->nomor_skema ?? '-' }}
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ optional($detailRincian)->asesi->nama_asesi ?? '-' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            {{ $detailRincian->asesor->nama_asesor ?? '-' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->event->tuk->nama_tuk ?? 'LSP Politeknik Negeri Malang' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Panduan Bagi Asesor seperti FRIA01 --}}
            <div class="mb-6 p-4 bg-white rounded-lg border border-gray-200">
                <h3 class="text-lg font-semibold text-black mb-4 text-center">PANDUAN BAGI ASESOR</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Baca dengan seksama setiap instrumen asesmen yang akan digunakan dalam proses asesmen.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Pastikan instrumen asesmen sesuai dengan standar kompetensi yang akan dinilai.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Beri tanda centang ( √ ) pada kolom "Ya" jika instrumen asesmen sudah sesuai, atau "Tidak" jika belum sesuai.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Berikan komentar atau saran perbaikan pada kolom komentar untuk setiap pertanyaan.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Pastikan semua pertanyaan telah dijawab sebelum menandatangani formulir.</span>
                    </li>
                </ul>
            </div>

                {{-- Form Checklist --}}
                <form action="{{ route('fria11.store') }}" method="post" id="simpanIA11">
                    @csrf
                    <input type="hidden" name="id_asesi" value="{{ optional($detailRincian)->id_asesi ?? '' }}">
                    <input type="hidden" name="id_asesor" value="{{ optional($detailRincian)->id_asesor ?? '' }}">
                    <input type="hidden" name="id_skema" value="{{ optional($detailRincian)->asesi->id_skema ?? '' }}">
                    
                    {{-- Tabel Checklist --}}
                    <div class="overflow-x-auto shadow-md rounded-lg mb-6">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider w-2/5">Kegiatan Asesmen</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider w-1/5">Ya/Tidak</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider w-2/5">Komentar</th>
                                </tr>
                            </thead>
                            <tbody id="checklistTableBody" class="divide-y divide-gray-200">
                                {{-- Dynamic content will be inserted here --}}
                            </tbody>
                        </table>
                    </div>

                    {{-- Komentar Keseluruhan --}}
                    <div class="mb-6">
                        <label for="komentar_all" class="block text-sm font-medium text-sidebar_font mb-2">
                            Komentar
                        </label>
                        <textarea id="komentar_all" name="komentar_all" rows="4" 
                                  class="block w-full px-3 py-2 text-sm border border-border_input rounded-lg focus:ring-biru focus:border-biru" 
                                  placeholder="Masukkan komentar keseluruhan tentang instrumen asesmen...">{{ $formData->komentar_all ?? '' }}</textarea>
                    </div>
                    
            {{-- Bagian Tandatangan - Hanya Asesor --}}
            <div class="mt-8 p-6 border-border_input rounded-lg bg-white">
                <h3 class="text-lg font-semibold text-sidebar_font mb-6 text-center">Tandatangan Asesor</h3>
                
                <div class="max-w-md mx-auto">
                    <!-- Kolom Asesor -->
                    <div class="text-center">
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Tanggal:</p>
                            <p id="tanggalTandaTanganAsesorDate" class="text-sm font-medium">
                                @if($formData && $isAsesorSigned)
                                    {{ $formData->updated_at->format('d/m/Y H:i') }} WIB
                                @else
                                    {{ now()->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        
                        <label for="is_asesor_signing" class="block text-sm/6 font-medium text-sidebar_font text-center mb-2">
                            Tanda Tangan Asesor
                            <span class="text-red-500">*</span>
                        </label>
                        <div id="asesor-signature-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed px-6 py-10 min-h-[200px] @if($formData && $isAsesorSigned) border-green-500 bg-green-50 cursor-default @else border-border_input hover:bg-blue-50 cursor-pointer @endif">
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
                                @if($formData && $isAsesorSigned)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mt-2">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Sudah Ditandatangani
                                </span>
                                @else
                                <p class="text-xs text-center mt-2 text-gray-500">Tanda tangan asesor dari biodata</p>
                                @endif
                                <p id="tanggalTandaTanganAsesor" class="text-xs text-center text-gray-500">Tanggal: -</p>
                            </div>
                        </div>

                        <!-- Checkbox untuk persetujuan tanda tangan -->
                        <div class="mt-4 flex items-center justify-center">
                            <!-- Hidden field to ensure is_asesor_signing is always sent -->
                            <input type="hidden" name="is_asesor_signing" value="0">
                            <input id="is_asesor_signing" name="is_asesor_signing" type="checkbox" value="1"
                                   class="w-4 h-4 text-biru bg-gray-100 border-gray-300 rounded focus:ring-biru focus:ring-2"
                                   @if($formData && $isAsesorSigned) checked disabled @endif>
                            <label for="is_asesor_signing" class="ms-2 text-sm font-medium text-sidebar_font">
                                Data yang saya masukkan sudah benar dan saya menyetujui formulir IA.11 ini
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button Simpan -->
            <div class="flex justify-end pe-4">
                <button id="btnSimpanIA11" type="submit" 
                        class="inline-flex justify-center rounded-md px-6 py-2 text-sm/6 font-medium focus:outline-none mt-6 @if($formData && $isAsesorSigned) bg-gray-400 text-gray-200 cursor-not-allowed @else bg-gradient-to-r from-biru to-ungu text-white hover:bg-biru @endif"
                        @if($formData && $isAsesorSigned) disabled @endif>
                    {{ $formData && $isAsesorSigned ? 'Sudah Ditandatangani' : 'Simpan & Tandatangan' }}
                </button>
            </div>
        </form>
    </div>

    {{-- Background Gradient seperti FRIA02 --}}
    {{-- <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div> --}}
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('FRIA11 Document loaded');
    
    // Global window functions for notifications (sama seperti FRIA02)
    window.showNotificationModal = function(title, message, type = 'info') {
        // Create notification modal if not exists
        let modal = document.getElementById('notificationModal');
        if (!modal) {
            const modalHTML = `
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
            `;
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            modal = document.getElementById('notificationModal');
        }

        const titleElement = document.getElementById('notificationTitle');
        const messageElement = document.getElementById('notificationMessage');
        const iconElement = document.getElementById('notificationIcon');

        titleElement.textContent = title;
        messageElement.textContent = message;

        // Set icon based on type
        let iconHtml = '';
        let iconBgClass = '';

        switch(type) {
            case 'success':
                iconBgClass = 'bg-green-100';
                iconHtml = `<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>`;
                break;
            case 'error':
                iconBgClass = 'bg-red-100';
                iconHtml = `<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>`;
                break;
            case 'warning':
                iconBgClass = 'bg-yellow-100';
                iconHtml = `<svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>`;
                break;
            default:
                iconBgClass = 'bg-blue-100';
                iconHtml = `<svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
        }

        iconElement.className = `mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10 ${iconBgClass}`;
        iconElement.innerHTML = iconHtml;

        modal.classList.remove('hidden');
    };

    function hideNotificationModal() {
        const modal = document.getElementById('notificationModal');
        if (modal) modal.classList.add('hidden');
    }

    // Setup modal close handlers
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'notificationCloseBtn') {
            hideNotificationModal();
        }
    });
    
    // Standard FRIA11 questions
    const standardQuestions = [
        "Apakah instrumen asesmen telah disusun sesuai dengan kisi-kisi asesmen?",
        "Apakah setiap unit kompetensi memiliki instrumen asesmen yang lengkap?",
        "Apakah instrumen asesmen telah mempertimbangkan konteks dalam melakukan asesmen?",
        "Apakah instrumen asesmen sudah sesuai dengan prinsip asesmen (valid, reliable, flexible, fair)?",
        "Apakah instrumen asesmen yang telah disusun berorientasi pada pencapaian kompetensi?",
        "Apakah instrumen asesmen sudah mencakup seluruh aspek asesmen (observasi, demonstrasi, lisan, tertulis, portofolio)?",
        "Apakah instrumen asesmen yang disusun telah sesuai dengan standar kompetensi yang diases?",
        "Apakah instrumen asesmen dapat mengases seluruh elemen kompetensi dan kriteria unjuk kerja?"
    ];

    function initializeChecklistTable() {
        const tbody = document.getElementById('checklistTableBody');
        if (!tbody) {
            console.error('Checklist table body not found');
            return;
        }

        // Clear existing content
        tbody.innerHTML = '';

        // Add each standard question
        standardQuestions.forEach((question, index) => {
            const questionNumber = index + 1;
            const row = createQuestionRow(questionNumber, question);
            tbody.appendChild(row);
        });
    }

    function createQuestionRow(number, question) {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50';
        
        // Get existing data if available with better error handling
        const existingData = @json($formData ?? null);
        console.log('Existing data for debugging:', existingData); // Debug log
        
        // Safely get saved values with multiple fallbacks
        let savedChoice = '';
        let savedComment = '';
        
        if (existingData && typeof existingData === 'object') {
            savedChoice = existingData[`pertanyaan_${number}`] || '';
            savedComment = existingData[`komentar_${number}`] || '';
        }
        
        // Ensure savedComment is never undefined
        if (savedComment === undefined || savedComment === null) {
            savedComment = '';
        }

        tr.innerHTML = `
            <td class="px-4 py-3 text-gray-800 align-top">
                <div class="flex">
                    <span class="text-gray-600 font-medium mr-3">${number}.</span>
                    <span>${question}</span>
                </div>
            </td>
            <td class="px-4 py-3 text-center align-top">
                <select name="pertanyaan_${number}" 
                        onchange="ubahWarnaSelect(this)"
                        class="border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru block w-full px-2 py-1 ${savedChoice === 'Ya' ? 'text-green-600' : (savedChoice === 'Tidak' ? 'text-red-600' : 'text-black')}">
                    <option value="" ${savedChoice === '' ? 'selected' : ''}>Pilih</option>
                    <option value="Ya" ${savedChoice === 'Ya' ? 'selected' : ''}>Ya</option>
                    <option value="Tidak" ${savedChoice === 'Tidak' ? 'selected' : ''}>Tidak</option>
                </select>
            </td>
            <td class="px-4 py-3 align-top">
                <textarea name="komentar_${number}" rows="3" 
                          class="w-full px-3 py-2 text-sm border border-border_input rounded-lg focus:ring-biru focus:border-biru resize-none"
                          placeholder="Masukkan komentar untuk pertanyaan ${number}">${savedComment === undefined || savedComment === null ? '' : savedComment}</textarea>
            </td>
        `;

        return tr;
    }

    // Function to change select color based on value (untuk review instrumen asesmen)
    function ubahWarnaSelect(selectElement) {
        if (!selectElement) return;
        
        const value = selectElement.value;
        
        // Remove existing color classes
        selectElement.classList.remove('text-green-600', 'text-red-600', 'text-black');
        
        // Add appropriate color class
        if (value === 'Ya') {
            selectElement.classList.add('text-green-600');
        } else if (value === 'Tidak') {
            selectElement.classList.add('text-red-600');
        } else {
            selectElement.classList.add('text-black');
        }
    }

    // Initialize select colors for existing values
    function initializeSelectColors() {
        const selects = document.querySelectorAll('select[name^="pertanyaan_"]');
        selects.forEach(select => {
            ubahWarnaSelect(select);
        });
    }

    // Handle signature loading seperti biodata
    function loadAsesorSignature() {
        console.log('Loading asesor signature...');
        
        // Build API configuration similar to biodata
        const apiConfig = {
            url: @json(config('services.api.url')),
            key: @json(config('services.api.key')),
            asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
            csrfToken: @json(csrf_token())
        };

        // Validasi konfigurasi API seperti biodata
        if (!apiConfig.url) {
            console.log('Konfigurasi API URL tidak ditemukan');
            window.showNotificationModal('Error', 'Konfigurasi API URL tidak ditemukan', 'error');
            return;
        }

        if (!apiConfig.key) {
            console.log('Konfigurasi API Key tidak ditemukan');
            window.showNotificationModal('Error', 'Konfigurasi API Key tidak ditemukan', 'error');
            return;
        }

        if (!apiConfig.asesorId) {
            console.log('Asesor ID tidak ditemukan');
            window.showNotificationModal('Error', 'Asesor ID tidak ditemukan', 'error');
            return;
        }

        const biodataApiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;
        const apiHeaders = {
            'accept': 'application/json',
            'X-API-KEY': apiConfig.key,
            'X-CSRF-TOKEN': apiConfig.csrfToken
        };

        console.log('Biodata API URL:', biodataApiUrl);

        // Check if asesor already signed
        const isAsesorSigned = {{ $formData && $isAsesorSigned ? 'true' : 'false' }};
        console.log('Asesor already signed:', isAsesorSigned);
        
        if (isAsesorSigned) {
            // Show existing signature if already signed
            const checkbox = document.getElementById('is_asesor_signing');
            const uploadArea = document.getElementById('asesor-signature-upload-area');
            
            if (checkbox) {
                checkbox.disabled = true;
                console.log('Checkbox disabled - asesor already signed');
            }
            
            // Add signed styling
            if (uploadArea) {
                uploadArea.classList.add('signature-signed');
            }
        }
        
        // Load asesor signature from biodata (for both signed and unsigned)
        fetch(biodataApiUrl, {
            method: 'GET',
            headers: apiHeaders
        })
        .then(response => {
            console.log('Biodata response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('Biodata result:', result);
            
            if (result.success && result.data?.file_url_tanda_tangan) {
                // Gunakan URL langsung seperti di biodata, tanpa menambahkan base URL
                const asesorSignatureUrl = result.data.file_url_tanda_tangan;
                console.log('Asesor signature URL:', asesorSignatureUrl);
                
                // Store signature URL globally for form submission
                window.asesorSignatureUrl = asesorSignatureUrl;
                
                const img = document.getElementById('asesor-signature-image');
                const content = document.getElementById('asesor-signature-content');
                const preview = document.getElementById('asesor-signature-preview');
                
                if (img && content && preview) {
                    img.src = asesorSignatureUrl;
                    content.classList.add('hidden');
                    preview.classList.remove('hidden');
                    console.log('Asesor signature preview displayed');
                    
                    // Update signature timestamp for signed form
                    if (isAsesorSigned) {
                        const signatureTimestamp = document.getElementById('tanggalTandaTanganAsesor');
                        if (signatureTimestamp) {
                            signatureTimestamp.textContent = 'Tanggal: {{ $formData && $formData->updated_at ? $formData->updated_at->format("d/m/Y H:i") . " WIB" : now()->format("d/m/Y") }}';
                        }
                    }
                    
                    
                } else {
                    console.log('Missing signature display elements');
                    window.asesorSignatureUrl = null;
                }
            } else {
                console.log('No signature found in biodata. Response:', result);
                window.asesorSignatureUrl = null;
                
                // Show warning if no signature found
                if (!isAsesorSigned) {
                    window.showNotificationModal(
                        'Tanda Tangan Tidak Ditemukan', 
                        'Belum ada tanda tangan di biodata. Silakan upload tanda tangan di menu biodata terlebih dahulu.',
                        'warning'
                    );
                }
            }
        })
        .catch(error => {
            console.error('Error loading asesor signature:', error);
            window.asesorSignatureUrl = null;
            
            // Show error notification
            window.showNotificationModal(
                'Error Memuat Tanda Tangan', 
                'Gagal memuat tanda tangan dari biodata. Silakan coba lagi atau periksa koneksi internet.',
                'error'
            );
        });
    }

    // Handle form submission seperti FRIA02
    const form = document.getElementById('simpanIA11');
    if (form) {
        console.log('Form found, adding event listener');
        
        form.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');
            console.log('Event object:', e);
            
            const checkbox = document.getElementById('is_asesor_signing');
            console.log('Checkbox element:', checkbox);
            console.log('Checkbox checked:', checkbox ? checkbox.checked : 'null');
            console.log('Is asesor already signed:', {{ $formData && $isAsesorSigned ? 'true' : 'false' }});
            
            // Only validate if not already signed
            if (!{{ $formData && $isAsesorSigned ? 'true' : 'false' }}) {
                // Check if signature is available
                if (!window.asesorSignatureUrl) {
                    console.log('No signature URL available');
                    e.preventDefault();
                    window.showNotificationModal(
                        'Tanda Tangan Tidak Tersedia', 
                        'Anda belum memiliki tanda tangan di biodata atau file tanda tangan tidak dapat diakses. Silakan periksa biodata Anda dan pastikan tanda tangan sudah ter-upload dengan benar.',
                        'error'
                    );
                    return false;
                }
                
                // Check if checkbox is checked
                if (checkbox && !checkbox.checked) {
                    console.log('Checkbox validation failed - preventing form submission');
                    e.preventDefault();
                    window.showNotificationModal(
                        'Persetujuan Diperlukan', 
                        'Harap centang persetujuan untuk menyelesaikan proses peninjauan instrumen asesmen.',
                        'warning'
                    );
                    return false;
                }
                
                // Show loading notification
                window.showNotificationModal(
                    'Menyimpan Data', 
                    'Sedang menyimpan formulir IA.11 dan menandatangani...',
                    'info'
                );
            }

            console.log('Form validation passed, allowing submission');

            // Update timestamp when signing
            if (checkbox && checkbox.checked && !{{ $formData && $isAsesorSigned ? 'true' : 'false' }}) {
                const now = new Date();
                const timestamp = now.toLocaleString('id-ID', {
                    day: '2-digit',
                    month: '2-digit', 
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                const timestampElement = document.getElementById('tanggalTandaTanganAsesorDate');
                if (timestampElement) {
                    timestampElement.textContent = `${timestamp} WIB`;
                }
                
                // Also update the signature preview timestamp
                const signatureTimestamp = document.getElementById('tanggalTandaTanganAsesor');
                if (signatureTimestamp) {
                    signatureTimestamp.textContent = `Tanggal: ${timestamp} WIB`;
                }
            }
        });
    } else {
        console.error('Form with ID simpanIA11 not found!');
    }

    // Search functionality for list view
    const searchInput = document.getElementById('default-search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#daftarIA11 tbody tr');

            rows.forEach(row => {
                const nama = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                const skema = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';

                if (nama.includes(searchValue) || skema.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Helper function untuk validasi signature (sama seperti FRIA02)
    window.validateAsesorSignature = function() {
        if (!window.asesorSignatureUrl) {
            window.showNotificationModal(
                'Tanda Tangan Tidak Tersedia', 
                'Anda belum memiliki tanda tangan di biodata atau file tanda tangan tidak dapat diakses. Silakan periksa biodata Anda dan pastikan tanda tangan sudah ter-upload dengan benar.',
                'error'
            );
            return false;
        }
        return true;
    };

    // Helper function untuk show success message
    window.showSignatureSuccess = function() {
        window.showNotificationModal(
            'Formulir Berhasil Disimpan', 
            'Formulir IA.11 berhasil disimpan dan ditandatangani.',
            'success'
        );
    };

    // Initialize everything for form view
    @if($detailRincian)
        console.log('Detail rincian found, initializing form components...');
        console.log('Detail rincian data:', @json($detailRincian ?? null));
        
        initializeChecklistTable();
        setTimeout(() => {
            initializeSelectColors();
            
            // Additional debugging for submit button
            const submitButton = document.getElementById('simpanIA11');
            if (submitButton) {
                console.log('Submit button found:', submitButton);
                console.log('Button disabled status:', submitButton.disabled);
                console.log('Button type:', submitButton.type);
                
                submitButton.addEventListener('click', function(e) {
                    console.log('Submit button clicked!');
                    console.log('Click event object:', e);
                    console.log('Button disabled:', this.disabled);
                });
            } else {
                console.error('Submit button with ID simpanIA11 not found!');
            }
        }, 100);
        
        // Load signature immediately
        console.log('Starting to load asesor signature...');
        loadAsesorSignature();
        
        // Check for success message from session (seperti FRIA02)
        @if(session('success'))
            setTimeout(() => {
                window.showNotificationModal(
                    'Formulir Berhasil Disimpan', 
                    '{{ session('success') }}',
                    'success'
                );
                // Auto close after 5 seconds
                setTimeout(() => {
                    const modal = document.getElementById('notificationModal');
                    if (modal) modal.classList.add('hidden');
                }, 5000);
            }, 1000);
        @endif
        
        // Check for error message from session
        @if($errors->any())
            setTimeout(() => {
                window.showNotificationModal(
                    'Error', 
                    '{{ $errors->first() }}',
                    'error'
                );
            }, 1000);
        @endif
    @else
        console.log('No detail rincian available');
    @endif
});
</script>

<!-- CSS untuk Upload Area seperti FRIA02 -->
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

/* Styling untuk tanda tangan yang sudah signed */
.signature-signed {
    border: 2px solid #10b981;
    background-color: #f0fdf4;
}

.signature-signed .text-gray-300 {
    color: #10b981 !important;
}
</style>

@endsection
