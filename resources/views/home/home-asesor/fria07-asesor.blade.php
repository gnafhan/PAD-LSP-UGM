@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.IA.07 - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Notification -->
    <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Berhasil!</h3>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Formulir berhasil ditandatangani.</p>
            </div>
            <div class="mt-4 flex justify-end">
                <button id="closeModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- Modal for Save First Warning -->
    <div id="saveFirstModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Peringatan</h3>
                </div>
            </div>
            <div class="mt-2">
                <p class="text-sm text-gray-500">Formulir harus disimpan terlebih dahulu sebelum dapat ditandatangani.</p>
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button id="cancelSaveModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Batal
                </button>
                <button id="saveFormBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan
                </button>
            </div>
        </div>
    </div>
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
        <p class="ms-2 text-xl font-bold text-black">IA.07</p>
    </div>
    {{-- Breadcrumb --}}
    <div id="breadcrumbs" class="@if($detailRincian) pb-4 px-6 @else hidden @endif">
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
                @if($detailRincian)
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-black">{{ $detailRincian->asesi->nama_asesi ?? '-' }}</span>
                    </div>
                </li>
                @endif
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameIA07" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir IA.07 Pertanyaan Lisan</p>
        <!-- Search Form -->
        <form id="searchIA07" class="max-w-md mb-4 rounded-xl @if($detailRincian) hidden @endif">
            <div class="relative">
            <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
        {{-- List Asesi --}}
        <div class="overflow-x-auto shadow-sm rounded-lg @if($detailRincian) hidden @endif">
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
                @forelse($daftarAsesi as $i => $rincian)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $i+1 }}</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="window.location.href='{{ route('fria07-asesor') }}?id_asesi={{ $rincian->asesi->id_asesi }}'" class="">
                                <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button onclick="showDocument('{{ $rincian->asesi->id_asesi }}')" class="">
                                <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->nama_asesi ?? 'Nama tidak tersedia' }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->skema->nama_skema ?? 'Skema tidak tersedia' }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->skema->nomor_skema ?? 'Kode tidak tersedia' }}</td>
                        <td class="px-4 py-0">
                            <div class="flex px-4 py-3 justify-center items-center" id="progress-{{ $rincian->asesi->id_asesi }}">
                                @if(isset($rincian->fria07_data) && $rincian->fria07_data && $rincian->fria07_data->isAsesorSigned())
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
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div id="detailIA07" class="@if($detailRincian) p-4 text-black @else hidden @endif">

            <!-- Input Formulir IA.07 -->
            <div id="FRIA07" class="pt-0 p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->asesi->skema->nama_skema ?? 'Nama Skema tidak tersedia' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->asesi->skema->kode_skema ?? 'Kode Skema tidak tersedia' }}
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->asesi->nama_asesi ?? 'Nama Asesi tidak tersedia' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            {{ $detailRincian->asesor->nama_asesor ?? 'Nama Asesor tidak tersedia' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->event->tuk->nama_tuk ?? 'TUK tidak tersedia' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tabel Kode Unit --}}
            <div class="p-4">
                @if($detailRincian && $detailRincian->asesi && $detailRincian->asesi->skema && $detailRincian->asesi->skema->unitKompetensiLoaded)
                    @foreach($detailRincian->asesi->skema->unitKompetensiLoaded as $index => $uk)
                        <p id="judulTabelIA07" class="text-sidebar_font font-semibold pb-2">No {{ $index + 1 }}.  Kode Unit : {{ $uk->kode_uk }}</p>

                        <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                            <table id="pelaksanaanAsesmen_{{ $index }}" class="w-full bg-white overflow-hidden table-fixed">

                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider w-1/6">Kirim Jawaban</th>
                                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider text-left w-3/6">Judul Unit Kompetensi</th>
                                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider w-1/6">Kode Unit Kompetensi</th>
                                        <th class="px-4 py-3 text-xs font-semibold text-gray-600 tracking-wider w-1/6">Kompetensi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black text-center">
                                    @forelse($uk->elemen_uk as $elemen)
                                        <tr class="hover:bg-gray-50" id="row_{{ $uk->id_uk }}_{{ $elemen->id_elemen_uk }}">
                                            <td class="px-4 py-3 text-center w-24">
                                                <button onclick="showModal('{{ $uk->id_uk }}', '{{ $elemen->id_elemen_uk }}')" class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                                    </svg>
                                                    Kirim
                                                </button>
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 text-left text-sm break-words">{{ $elemen->nama_elemen }}</td>
                                            <td class="px-4 py-3 text-gray-700 text-sm w-32">{{ $uk->kode_uk }}</td>
                                            <td class="px-4 py-3 text-center w-32">
                                                @php
                                                    $statusPenilaian = 'Belum Diisi';
                                                    $statusClass = 'text-red-800 bg-red-100';
                                                    
                                                    if ($formData && isset($formData->data_tambahan['unit_kompetensi'])) {
                                                        foreach ($formData->data_tambahan['unit_kompetensi'] as $ukData) {
                                                            if ($ukData['id_uk'] == $uk->id_uk || $ukData['kode_uk'] == $uk->kode_uk) {
                                                                if (isset($ukData['elemen_kompetensi'])) {
                                                                    foreach ($ukData['elemen_kompetensi'] as $elemenData) {
                                                                        if ($elemenData['id_elemen'] == $elemen->id_elemen_uk) {
                                                                            if (isset($elemenData['penilaian'])) {
                                                                                if ($elemenData['penilaian'] === 'kompeten') {
                                                                                    $statusPenilaian = 'Kompeten';
                                                                                    $statusClass = 'text-green-800 bg-green-100';
                                                                                } elseif ($elemenData['penilaian'] === 'belum_kompeten') {
                                                                                    $statusPenilaian = 'Belum Kompeten';
                                                                                    $statusClass = 'text-red-800 bg-red-100';
                                                                                }
                                                                            }
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium {{ $statusClass }} rounded-lg whitespace-nowrap">
                                                    {{ $statusPenilaian }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada elemen kompetensi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @else
                    <p class="text-sidebar_font font-semibold pb-2">Pilih asesi untuk melihat unit kompetensi</p>
                @endif
            </div>

            <div class="my-6 px-4 space-y-6">
                {{-- Hasil --}}
                <div class>
                    <h3 class=" text-black font-semibold pb-4 text-xl">Hasil</h3>
                    <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                        <table class="min-w-full bg-white overflow-hidden">
                            <thead class="bg-bg_dashboard text-center">
                                <tr>
                                    <th class="px-6 py-3 text-sm font-semibold text-gray-600 tracking-wider">Kinerja</th>
                                    <th class="px-6 py-3 text-sm font-semibold text-gray-600 tracking-wider">Kompeten</th>
                                    <th class="px-6 py-3 text-sm font-semibold text-gray-600 tracking-wider">Tidak Kompeten</th>
                                    <th class="px-6 py-3 text-sm font-semibold text-gray-600 tracking-wider">Umpan Balik</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-black">
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-700 text-left">Kinerja Asesi adalah</td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $kinerjaValue = '';
                                            $umpanBalik = '';
                                            
                                            if ($formData && 
                                                isset($formData->data_tambahan['hasil']) && 
                                                is_array($formData->data_tambahan['hasil']) &&
                                                !empty($formData->data_tambahan['hasil'])) {
                                                
                                                foreach ($formData->data_tambahan['hasil'] as $hasil) {
                                                    // Check if $hasil is an array and has the required keys
                                                    if (is_array($hasil) && 
                                                        array_key_exists('name', $hasil) && 
                                                        $hasil['name'] === 'kinerja_asesi') {
                                                        $kinerjaValue = $hasil['value'] ?? '';
                                                        $umpanBalik = $hasil['umpan_balik'] ?? '';
                                                        break;
                                                    }
                                                    // Handle old data format where hasil might be stored differently
                                                    elseif (is_array($hasil) && 
                                                             array_key_exists('value', $hasil) && 
                                                             !array_key_exists('name', $hasil)) {
                                                        // This might be old format, assume it's kinerja_asesi if it's the first item
                                                        $kinerjaValue = $hasil['value'] ?? '';
                                                        $umpanBalik = $hasil['umpan_balik'] ?? '';
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <input type="radio" name="kinerja_asesi" value="kompeten" {{ $kinerjaValue === 'kompeten' ? 'checked' : '' }} class="w-4 h-4 text-biru bg-gray-100 border-gray-300 focus:ring-biru focus:ring-2">
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="radio" name="kinerja_asesi" value="tidak_kompeten" {{ $kinerjaValue === 'tidak_kompeten' ? 'checked' : '' }} class="w-4 h-4 text-biru bg-gray-100 border-gray-300 focus:ring-biru focus:ring-2">
                                    </td>
                                    <td class="px-6 py-4">
                                        <textarea name="umpan_balik_kinerja_asesi" placeholder="Lainnya..." class="w-full border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru px-3 py-2 bg-white text-black resize-none" rows="3">{{ $umpanBalik }}</textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
                {{-- Tanda tangan --}}
                <div class="p-4 mb-6">
                    <h3 class="text-black font-semibold pb-4 text-xl">Tandatangan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kolom Asesi --}}
                        <div class="text-center space-y-4">
                            @php
                                $nama_asesi = $detailRincian->asesi->nama_asesi ?? 'Nama Asesi'; 
                            @endphp
                            <p class="text-sm text-gray-600 mb-2">{{ $tanggal_ttd ?? "-" }}</p>
                            <div class="h-32 flex items-center justify-center bg-white">
                                @if(isset($ttd_asesi) && $ttd_asesi)
                                    {{-- Gambar tanda tangan asesi --}}
                                    <img src="{{ asset('storage/ttd/' . $ttd_asesi) }}" 
                                        alt="Tanda Tangan Asesi" 
                                        class="max-h-24 max-w-full object-contain">
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 w-full h-full flex items-center justify-center bg-gray-50">
                                        <span class="text-gray-400 text-sm">Belum ada tanda tangan</span>
                                    </div>
                                @endif
                            </div>
                            <div class="border-t border-gray-400 pt-2">
                                <p class="text-sm font-medium text-gray-700">Asesi</p>
                                <p class="text-sm text-gray-600">{{ $nama_asesi }}</p>
                            </div>
                        </div>

                        {{-- Kolom Asesor --}}
                        <div class="text-center space-y-4">
                            @php
                                $isAsesorSigned = $formData && $formData->isAsesorSigned();
                                $currentAsesorId = Auth::user()->asesor->id_asesor ?? null;
                                $assignedAsesorId = $detailRincian->asesor->id_asesor ?? null;
                                $ttd_asesor = null;
                                $waktu_ttd_asesor = $formData->waktu_tanda_tangan_asesor ?? null;
                                if ($isAsesorSigned) {
                                    $ttdModel = \App\Models\TandaTanganAsesor::where('id_asesor', $assignedAsesorId)
                                        ->where(function($q){ $q->whereNull('valid_until')->orWhere('valid_until', '>=', now()); })
                                        ->orderByDesc('created_at')->first();
                                    $ttd_asesor = $ttdModel ? $ttdModel->file_tanda_tangan : null;
                                }
                            @endphp
                            <p class="text-sm text-gray-600 mb-2">
                                @if($waktu_ttd_asesor)
                                    {{ \Carbon\Carbon::parse($waktu_ttd_asesor)->format('d F Y') }}
                                @else
                                    Belum ditandatangani
                                @endif
                            </p>
                            <div class="h-32 flex items-center justify-center bg-white">
                                @if($isAsesorSigned && $ttd_asesor)
                                    <img id="imgTtdAsesor" src="{{ asset('storage/tanda_tangan/' . $ttd_asesor) }}" alt="Tanda Tangan Asesor" class="max-h-24 max-w-full object-contain">
                                @elseif($isAsesorSigned)
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 w-full h-full flex items-center justify-center bg-gray-50">
                                        <span class="text-gray-400 text-sm">Tanda tangan tidak ditemukan</span>
                                    </div>
                                @elseif($currentAsesorId && $assignedAsesorId && $currentAsesorId == $assignedAsesorId)
                                    <button id="btnSignAsesor" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm font-medium hover:bg-biru_soft focus:outline-none" data-fria07-id="{{ $formData->id_fria07 ?? '' }}">
                                        Tandatangani
                                    </button>
                                    <div id="signAsesorStatus" class="mt-2 text-sm text-gray-500"></div>
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 w-full h-full flex items-center justify-center bg-gray-50">
                                        <span class="text-gray-400 text-sm">Belum ada tanda tangan</span>
                                    </div>
                                @endif
                            </div>
                            <div class="border-t border-gray-400 pt-2">
                                <p class="text-sm font-medium text-gray-700">Asesor</p>
                                <p class="text-sm text-gray-600">{{ $detailRincian->asesor->nama_asesor ?? 'Nama Asesor' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Button Simpan --}}
                <form id="formFria07" method="POST" action="{{ route('fria07.store') }}">
                    @csrf
                    <input type="hidden" name="id_asesi" value="{{ $detailRincian->asesi->id_asesi ?? '' }}">
                    <input type="hidden" name="id_asesor" value="{{ $detailRincian->asesor->id_asesor ?? '' }}">
                    <input type="hidden" name="id_skema" value="{{ $detailRincian->asesi->skema->id_skema ?? '' }}">
                    <input type="hidden" name="id_event" value="{{ $detailRincian->event->id_event ?? '' }}">
                    <input type="hidden" name="id_rincian_asesmen" value="{{ $detailRincian->id_rincian_asesmen ?? '' }}">
                    <input type="hidden" id="dataTambahanInput" name="data_tambahan">
                    <div class="flex justify-end pe-4">
                        <button id="simpanFria07" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6" @if($formData && $formData->isAsesorSigned()) disabled @endif>
                            @if($formData && $formData->isAsesorSigned())
                                Sudah Ditandatangani
                            @else
                                Simpan dan Setujui
                            @endif
                        </button>
                    </div>
                </form>
            </div>
    </div>

    {{-- Modal Kirim --}}
    <div id="modal-container" class="fixed inset-0 z-50 bg-black bg-opacity-50 justify-center items-start py-4 overflow-y-auto" style="display: none;">
        <div class="relative bg-white w-full max-w-lg max-h-[calc(100vh-2rem)] overflow-hidden rounded-lg shadow-xl mx-4 my-auto">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Unit Kompetensi</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center" onclick="closeModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <div id="modal-content" class="p-6 overflow-y-auto max-h-[calc(100vh-10rem)] space-y-4">
            </div>
            <div class="flex justify-end p-6 border-t border-gray-200 space-x-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">Tutup</button>
                <button type="button" onclick="saveModalData()" class="px-4 py-2 text-white bg-gradient-to-br from-biru to-ungu rounded-lg hover:from-ungu hover:to-biru transition-colors">Simpan</button>
            </div>
        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<script>
// Data untuk FRIA07
const fria07Data = @json($formData && $formData->data_tambahan ? $formData->data_tambahan : []);
let currentUkId = null;
let currentElemenId = null;

// Initialize fria07Data structure if empty
if (!fria07Data.unit_kompetensi) {
    fria07Data.unit_kompetensi = [];
}
if (!fria07Data.hasil) {
    fria07Data.hasil = [];
}

console.log('Initial fria07Data:', fria07Data);

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

function showModal(ukId, elemenId) {
    currentUkId = ukId;
    currentElemenId = elemenId;
    
    console.log('Opening modal for UK:', ukId, 'Element:', elemenId);
    
    // Find data for this UK and elemen
    const ukData = findUkData(ukId);
    const elemenData = findElemenData(ukData, elemenId);
    
    console.log('Found UK data:', ukData);
    console.log('Found element data:', elemenData);
    
    if (ukData && elemenData) {
        loadModalContent(ukData, elemenData);
    } else {
        loadEmptyModalContent();
    }
    
    document.getElementById('modal-container').style.display = 'flex';
}

function findUkData(ukId) {
    if (!fria07Data.unit_kompetensi) {
        console.log('No unit_kompetensi data found');
        return null;
    }
    
    console.log('Searching for UK ID:', ukId, 'in data:', fria07Data.unit_kompetensi);
    
    return fria07Data.unit_kompetensi.find(uk => {
        const match = uk.id_uk == ukId || 
               uk.kode_uk == ukId || 
               uk.id_uk?.toString() === ukId?.toString() ||
               uk.kode_uk?.toString() === ukId?.toString();
        
        console.log('Checking UK:', uk, 'Match result:', match);
        return match;
    });
}

function findElemenData(ukData, elemenId) {
    if (!ukData || !ukData.elemen_kompetensi) {
        console.log('No elemen_kompetensi data found in ukData:', ukData);
        return null;
    }
    
    console.log('Searching for element ID:', elemenId, 'in elemen data:', ukData.elemen_kompetensi);
    
    return ukData.elemen_kompetensi.find(el => {
        const match = el.id_elemen == elemenId || 
               el.id_elemen === elemenId ||
               el.id_elemen?.toString() === elemenId?.toString();
        
        console.log('Checking element:', el, 'Match result:', match);
        return match;
    });
}

function loadModalContent(ukData, elemenData) {
    const modalContent = document.getElementById('modal-content');
    
    // Handle existing data - only use new format
    let pertanyaanJawabanList = [];
    
    if (elemenData.pertanyaan_jawaban && Array.isArray(elemenData.pertanyaan_jawaban)) {
        // New format with multiple questions
        pertanyaanJawabanList = elemenData.pertanyaan_jawaban;
    } else if (elemenData.pertanyaan_lisan || elemenData.jawaban_asesi) {
        // Legacy format with single question - convert to new format
        pertanyaanJawabanList = [{
            pertanyaan: elemenData.pertanyaan_lisan || '',
            jawaban: elemenData.jawaban_asesi || ''
        }];
    }
    
    // If no data, create one empty set
    if (pertanyaanJawabanList.length === 0) {
        pertanyaanJawabanList = [{ pertanyaan: '', jawaban: '' }];
    }
    
    const penilaian = elemenData.penilaian || '';
    
    let contentHTML = '<div id="pertanyaan-jawaban-container">';
    
    pertanyaanJawabanList.forEach((item, index) => {
        contentHTML += createPertanyaanJawabanHTML(index + 1, item.pertanyaan, item.jawaban);
    });
    
    contentHTML += `
        </div>
        <div class="mb-5 flex justify-center">
            <button type="button" onclick="addNewPertanyaanJawaban()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Tambah Pertanyaan & Jawaban
            </button>
        </div>
        <div class="mb-5">
            <label for="modal-penilaian" class="block mb-2 text-sm font-medium text-gray-900">Penilaian Kompetensi <span class="text-red-500">*</span></label>
            <select id="modal-penilaian" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">-- Pilih Penilaian --</option>
                <option value="kompeten" ${penilaian === 'kompeten' ? 'selected' : ''}>Kompeten</option>
                <option value="belum_kompeten" ${penilaian === 'belum_kompeten' ? 'selected' : ''}>Belum Kompeten</option>
            </select>
        </div>
    `;
    
    modalContent.innerHTML = contentHTML;
}

function loadEmptyModalContent() {
    const modalContent = document.getElementById('modal-content');
    
    let contentHTML = '<div id="pertanyaan-jawaban-container">';
    contentHTML += createPertanyaanJawabanHTML(1, '', '');
    contentHTML += `
        </div>
        <div class="mb-5 flex justify-center">
            <button type="button" onclick="addNewPertanyaanJawaban()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 hover:border-blue-300 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Tambah Pertanyaan & Jawaban
            </button>
        </div>
        <div class="mb-5">
            <label for="modal-penilaian" class="block mb-2 text-sm font-medium text-gray-900">Penilaian Kompetensi <span class="text-red-500">*</span></label>
            <select id="modal-penilaian" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">-- Pilih Penilaian --</option>
                <option value="kompeten">Kompeten</option>
                <option value="belum_kompeten">Belum Kompeten</option>
            </select>
        </div>
    `;
    
    modalContent.innerHTML = contentHTML;
}

// Helper function to create HTML for one pertanyaan-jawaban pair
function createPertanyaanJawabanHTML(number, pertanyaan = '', jawaban = '') {
    const showDeleteButton = number > 1;
    
    return `
        <div class="pertanyaan-jawaban-group mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50" data-number="${number}">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-semibold text-gray-800">Set ${number}</h4>
                ${showDeleteButton ? `
                    <button type="button" onclick="removePertanyaanJawaban(${number})" class="text-red-600 hover:text-red-800 p-1 rounded hover:bg-red-100 transition-colors" title="Hapus Set ${number}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                ` : ''}
            </div>
            
            <div class="space-y-4">
                <div>
                    <label for="modal-pertanyaan-${number}" class="block mb-2 text-sm font-medium text-gray-900">
                        Pertanyaan Lisan ${number} <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="modal-pertanyaan-${number}" 
                        class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 min-h-[100px] resize-none focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Masukkan pertanyaan lisan untuk asesi..."
                    >${pertanyaan}</textarea>
                </div>
                
                <div>
                    <label for="modal-jawaban-${number}" class="block mb-2 text-sm font-medium text-gray-900">
                        Jawaban Asesi ${number} <span class="text-gray-400">(Opsional)</span>
                    </label>
                    <textarea 
                        id="modal-jawaban-${number}" 
                        class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 min-h-[100px] resize-none focus:ring-blue-500 focus:border-blue-500" 
                        placeholder="Masukkan jawaban dari asesi..."
                    >${jawaban}</textarea>
                </div>
            </div>
        </div>
    `;
}

// Function to add new pertanyaan-jawaban pair
function addNewPertanyaanJawaban() {
    const container = document.getElementById('pertanyaan-jawaban-container');
    const existingGroups = container.querySelectorAll('.pertanyaan-jawaban-group');
    const newNumber = existingGroups.length + 1;
    
    const newHTML = createPertanyaanJawabanHTML(newNumber);
    container.insertAdjacentHTML('beforeend', newHTML);
    
    // Update numbering for all groups
    updatePertanyaanNumbers();
    
    // Scroll to the new group
    const newGroup = container.querySelector(`[data-number="${newNumber}"]`);
    if (newGroup) {
        newGroup.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// Function to remove a pertanyaan-jawaban pair
function removePertanyaanJawaban(number) {
    const group = document.querySelector(`[data-number="${number}"]`);
    if (group) {
        // Add fade out animation
        group.style.transition = 'opacity 0.3s ease';
        group.style.opacity = '0';
        
        setTimeout(() => {
            group.remove();
            updatePertanyaanNumbers();
        }, 300);
    }
}

// Function to update numbering after add/remove operations
function updatePertanyaanNumbers() {
    const container = document.getElementById('pertanyaan-jawaban-container');
    const groups = container.querySelectorAll('.pertanyaan-jawaban-group');
    
    groups.forEach((group, index) => {
        const newNumber = index + 1;
        const oldNumber = group.getAttribute('data-number');
        
        // Update data-number attribute
        group.setAttribute('data-number', newNumber);
        
        // Update heading
        const heading = group.querySelector('h4');
        if (heading) {
            heading.textContent = `Set ${newNumber}`;
        }
        
        // Update labels
        const pertanyaanLabel = group.querySelector(`label[for="modal-pertanyaan-${oldNumber}"]`);
        const jawabanLabel = group.querySelector(`label[for="modal-jawaban-${oldNumber}"]`);
        if (pertanyaanLabel) {
            pertanyaanLabel.textContent = `Pertanyaan Lisan ${newNumber} `;
            pertanyaanLabel.innerHTML += '<span class="text-red-500">*</span>';
            pertanyaanLabel.setAttribute('for', `modal-pertanyaan-${newNumber}`);
        }
        if (jawabanLabel) {
            jawabanLabel.innerHTML = `Jawaban Asesi ${newNumber} <span class="text-gray-400">(Opsional)</span>`;
            jawabanLabel.setAttribute('for', `modal-jawaban-${newNumber}`);
        }
        
        // Update textarea IDs
        const pertanyaanTextarea = group.querySelector(`#modal-pertanyaan-${oldNumber}`);
        const jawabanTextarea = group.querySelector(`#modal-jawaban-${oldNumber}`);
        if (pertanyaanTextarea) {
            pertanyaanTextarea.id = `modal-pertanyaan-${newNumber}`;
        }
        if (jawabanTextarea) {
            jawabanTextarea.id = `modal-jawaban-${newNumber}`;
        }
        
        // Update delete button
        const deleteButton = group.querySelector('button[onclick^="removePertanyaanJawaban"]');
        if (deleteButton) {
            if (newNumber === 1) {
                deleteButton.style.display = 'none';
            } else {
                deleteButton.style.display = 'block';
                deleteButton.setAttribute('onclick', `removePertanyaanJawaban(${newNumber})`);
                deleteButton.setAttribute('title', `Hapus Set ${newNumber}`);
            }
        }
    });
}

function saveModalData() {
    const container = document.getElementById('pertanyaan-jawaban-container');
    const groups = container.querySelectorAll('.pertanyaan-jawaban-group');
    const penilaian = document.getElementById('modal-penilaian')?.value;
    
    let pertanyaanList = [];
    let jawabanList = [];
    let isValid = true;
    
    // Clear any previous error messages
    container.querySelectorAll('.error-message').forEach(error => error.remove());
    
    // Collect data from all question-answer pairs
    groups.forEach((group, index) => {
        const pertanyaanTextarea = group.querySelector(`#modal-pertanyaan-${index + 1}`);
        const jawabanTextarea = group.querySelector(`#modal-jawaban-${index + 1}`);
        
        const pertanyaan = pertanyaanTextarea ? pertanyaanTextarea.value.trim() : '';
        const jawaban = jawabanTextarea ? jawabanTextarea.value.trim() : '';
        
        // Validate that pertanyaan is not empty
        if (!pertanyaan) {
            isValid = false;
            if (pertanyaanTextarea) {
                pertanyaanTextarea.classList.add('border-red-500');
                const errorMsg = document.createElement('p');
                errorMsg.className = 'error-message text-red-500 text-xs mt-1';
                errorMsg.textContent = 'Pertanyaan tidak boleh kosong';
                pertanyaanTextarea.parentNode.appendChild(errorMsg);
            }
        } else {
            if (pertanyaanTextarea) {
                pertanyaanTextarea.classList.remove('border-red-500');
            }
        }
        
        pertanyaanList.push(pertanyaan);
        jawabanList.push(jawaban);
    });
    
    console.log('Saving modal data:', { pertanyaanList, jawabanList, penilaian });
    
    // Validasi input
    const errors = [];
    if (!penilaian) errors.push('Penilaian Kompetensi');
    if (!isValid) errors.push('Pertanyaan yang wajib diisi');
    
    if (errors.length > 0) {
        alert('Harap lengkapi field berikut: ' + errors.join(', '));
        return;
    }
    
    // Pass all question-answer pairs to updateFria07Data
    updateFria07Data(currentUkId, currentElemenId, penilaian, '', '', pertanyaanList, jawabanList);
    
    console.log('Updated fria07Data:', fria07Data);
    
    // Update status in table
    updateTableStatus(currentElemenId, penilaian);
    
    closeModal();
    
    alert('Data berhasil disimpan!');
}

function updateFria07Data(ukId, elemenId, penilaian, pertanyaan = '', jawaban = '', pertanyaanList = [], jawabanList = []) {
    if (!fria07Data.unit_kompetensi) {
        fria07Data.unit_kompetensi = [];
    }
    
    let ukData = findUkData(ukId);
    if (!ukData) {
        const ukName = getUkNameFromPage(ukId);
        
        ukData = {
            id_uk: ukId,
            kode_uk: ukId,
            nama_uk: ukName,
            elemen_kompetensi: []
        };
        fria07Data.unit_kompetensi.push(ukData);
    }
    
    // Create pertanyaan_jawaban array from the lists
    let pertanyaanJawabanArray = [];
    if (pertanyaanList.length > 0 && jawabanList.length > 0) {
        for (let i = 0; i < pertanyaanList.length; i++) {
            pertanyaanJawabanArray.push({
                pertanyaan: pertanyaanList[i] || '',
                jawaban: jawabanList[i] || ''
            });
        }
    }
    
    console.log('pertanyaanJawabanArray yang akan disimpan:', pertanyaanJawabanArray);
    
    let elemenData = findElemenData(ukData, elemenId);
    if (elemenData) {
        elemenData.penilaian = penilaian;
        // Only store new format - remove redundancy
        elemenData.pertanyaan_jawaban = pertanyaanJawabanArray;
        // Remove old format fields to eliminate redundancy
        delete elemenData.pertanyaan_lisan;
        delete elemenData.jawaban_asesi;
    } else {
        const elemenName = getElemenNameFromPage(elemenId);
        
        ukData.elemen_kompetensi.push({
            id_elemen: elemenId,
            nama_elemen: elemenName,
            pertanyaan_jawaban: pertanyaanJawabanArray, // Only new format
            penilaian: penilaian
        });
    }
    
    console.log('Data elemen setelah update:', elemenData || ukData.elemen_kompetensi[ukData.elemen_kompetensi.length - 1]);
    console.log('Full fria07Data after update:', JSON.stringify(fria07Data, null, 2));
}

// Helper function to get UK name from the page
function getUkNameFromPage(ukId) {
    const ukElement = document.querySelector(`[data-uk-id="${ukId}"]`);
    if (ukElement) {
        const ukName = ukElement.getAttribute('data-uk-name');
        if (ukName) return ukName;
    }
    
    const tables = document.querySelectorAll('[id^="pelaksanaanAsesmen_"]');
    for (let table of tables) {
        const ukHeader = table.closest('.mb-4')?.querySelector('p[id="judulTabelIA07"]');
        if (ukHeader && ukHeader.textContent.includes(ukId)) {
            return `Unit Kompetensi ${ukId}`;
        }
    }
    
    return `Unit Kompetensi ${ukId}`;
}

// Helper function to get elemen name from the page
function getElemenNameFromPage(elemenId) {
    const row = document.getElementById(`row_${currentUkId}_${elemenId}`);
    if (row) {
        const elemenNameCell = row.querySelector('td:nth-child(2)');
        if (elemenNameCell) {
            return elemenNameCell.textContent.trim();
        }
    }
    
    return `Elemen ${elemenId}`;
}

function updateTableStatus(elemenId, penilaian) {
    console.log('Updating table status for:', elemenId, 'with penilaian:', penilaian);
    
    const targetRow = document.getElementById(`row_${currentUkId}_${elemenId}`);
    
    if (targetRow) {
        const statusCell = targetRow.querySelector('td:last-child span');
        if (statusCell) {
            if (penilaian === 'kompeten') {
                statusCell.className = 'inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-lg whitespace-nowrap';
                statusCell.textContent = 'Kompeten';
            } else if (penilaian === 'belum_kompeten') {
                statusCell.className = 'inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-lg whitespace-nowrap';
                statusCell.textContent = 'Belum Kompeten';
            }
            console.log('Table status updated successfully');
        } else {
            console.error('Status cell not found in row:', targetRow);
        }
    } else {
        console.error('Target row not found for:', `row_${currentUkId}_${elemenId}`);
    }
}

function closeModal() {
    document.getElementById('modal-container').style.display = 'none';
    currentUkId = null;
    currentElemenId = null;
}

// Initialize table status
function initializeTableStatus() {
    if (!fria07Data.unit_kompetensi) return;
    
    fria07Data.unit_kompetensi.forEach(uk => {
        if (uk.elemen_kompetensi) {
            uk.elemen_kompetensi.forEach(elemen => {
                if (elemen.penilaian) {
                    updateTableStatusInit(uk.id_uk || uk.kode_uk, elemen.id_elemen, elemen.penilaian);
                }
            });
        }
    });
}

function updateTableStatusInit(ukId, elemenId, penilaian) {
    let targetRow = document.getElementById(`row_${ukId}_${elemenId}`);
    if (!targetRow) {
        const allRows = document.querySelectorAll('[id^="row_"]');
        allRows.forEach(row => {
            const rowId = row.id;
            if (rowId.includes(`_${elemenId}`)) {
                targetRow = row;
            }
        });
    }
    
    if (targetRow) {
        const statusCell = targetRow.querySelector('td:last-child span');
        if (statusCell) {
            if (penilaian === 'kompeten') {
                statusCell.className = 'inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-lg whitespace-nowrap';
                statusCell.textContent = 'Kompeten';
            } else if (penilaian === 'belum_kompeten') {
                statusCell.className = 'inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-lg whitespace-nowrap';
                statusCell.textContent = 'Belum Kompeten';
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initializeTableStatus();
});

// Update form before submit
document.getElementById('formFria07')?.addEventListener('submit', function(e) {
    const validation = validateFormForSubmission();
    if (!validation.isValid) {
        e.preventDefault(); 
        alert('Form belum lengkap. Silakan lengkapi: ' + validation.emptyFields.join(', '));
        return false;
    }
    
    let dataTambahan = {
        unit_kompetensi: fria07Data.unit_kompetensi || [],
        hasil: []
    };

    console.log('Data yang akan disimpan ke database:', dataTambahan);
    console.log('fria07Data.unit_kompetensi:', fria07Data.unit_kompetensi);

    // Collect hasil data
    let kinerjaAsesiRadio = document.querySelector('input[name="kinerja_asesi"]:checked');
    let umpanBalikKinerjaAsesiTextarea = document.querySelector('textarea[name="umpan_balik_kinerja_asesi"]');

    if (kinerjaAsesiRadio) {
        dataTambahan.hasil.push({
            name: 'kinerja_asesi',
            value: kinerjaAsesiRadio.value,
            umpan_balik: umpanBalikKinerjaAsesiTextarea ? umpanBalikKinerjaAsesiTextarea.value : ''
        });
    }

    const dataTambahanInput = document.getElementById('dataTambahanInput');
    if (dataTambahanInput) {
        dataTambahanInput.value = JSON.stringify(dataTambahan);
    }
});

function validateFormForSubmission() {
    let isValid = true;
    let emptyFields = [];
    
    const kinerjaRadios = document.querySelectorAll('input[name="kinerja_asesi"]');
    const kinerjaSelected = Array.from(kinerjaRadios).some(radio => radio.checked);
    if (!kinerjaSelected) {
        isValid = false;
        emptyFields.push('Kinerja Asesi harus dipilih');
    }
    
    const allRows = document.querySelectorAll('[id^="row_"]');
    let unassessedCount = 0;
    
    allRows.forEach(row => {
        const statusSpan = row.querySelector('td:last-child span');
        if (statusSpan && statusSpan.textContent.trim() === 'Belum Diisi') {
            unassessedCount++;
        }
    });
    
    if (unassessedCount > 0) {
        isValid = false;
        emptyFields.push(`${unassessedCount} elemen kompetensi belum dinilai`);
    }
    
    return { isValid, emptyFields };
}

document.addEventListener('DOMContentLoaded', function() {
    initializeTableStatus();
    
    function formatTanggalIndo(dateStr) {
        const date = new Date(dateStr);
        const day = date.getDate().toString().padStart(2, '0');
        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        const month = monthNames[date.getMonth()];
        const year = date.getFullYear();
        return `${day} ${month} ${year}`;
    }
    
    function disableFormIfSigned() {
        const isSigned = {{ $formData && $formData->isAsesorSigned() ? 'true' : 'false' }};
        if (isSigned) {
            document.querySelectorAll('input[name="kinerja_asesi"]').forEach(radio => {
                radio.disabled = true;
            });
            document.querySelectorAll('textarea[name="umpan_balik_kinerja_asesi"]').forEach(textarea => {
                textarea.disabled = true;
            });
            
            document.querySelectorAll('button[onclick^="showModal"]').forEach(button => {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
            });
            
            // Update button state
            const simpanBtn = document.getElementById('simpanFria07');
            if (simpanBtn) {
                simpanBtn.disabled = true;
                simpanBtn.textContent = 'Form Sudah Ditandatangani';
                simpanBtn.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru_soft');
                simpanBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            }
        }
    }
    
    function validateForm() {
        let isValid = true;
        let emptyFields = [];
        
        const kinerjaRadios = document.querySelectorAll('input[name="kinerja_asesi"]');
        const kinerjaSelected = Array.from(kinerjaRadios).some(radio => radio.checked);
        if (!kinerjaSelected) {
            isValid = false;
            emptyFields.push('Kinerja Asesi');
        }
        
        const allRows = document.querySelectorAll('[id^="row_"]');
        let unassessedElements = [];
        
        allRows.forEach(row => {
            const statusSpan = row.querySelector('td:last-child span');
            if (statusSpan && statusSpan.textContent.trim() === 'Belum Diisi') {
                const elemenNameCell = row.querySelector('td:nth-child(2)');
                const elemenName = elemenNameCell ? elemenNameCell.textContent.trim() : 'Elemen tidak diketahui';
                unassessedElements.push(elemenName);
            }
        });
        
        if (unassessedElements.length > 0) {
            isValid = false;
            emptyFields.push(`Penilaian untuk: ${unassessedElements.slice(0, 3).join(', ')}${unassessedElements.length > 3 ? ` dan ${unassessedElements.length - 3} lainnya` : ''}`);
        }
        
        return { isValid, emptyFields };
    }
    
    disableFormIfSigned();
    
    const btnSignAsesor = document.getElementById('btnSignAsesor');
    if (btnSignAsesor) {
        btnSignAsesor.addEventListener('click', async function() {
            const validation = validateForm();
            if (!validation.isValid) {
                alert('Form belum lengkap. Silakan isi: ' + validation.emptyFields.join(', '));
                return;
            }
            
            const fria07Id = btnSignAsesor.getAttribute('data-fria07-id');
            
            if (!fria07Id || fria07Id === '') {
                const saveFirstModal = document.getElementById('saveFirstModal');
                saveFirstModal.classList.remove('hidden');
                return;
            }
            
            btnSignAsesor.disabled = true;
            btnSignAsesor.textContent = 'Menyimpan...';
            
            try {
                const response = await fetch('/asesor/fria07/sign', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        fria07_id: fria07Id,
                        signature_type: 'asesor'
                    })
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    // Update image and date
                    if (data.data && data.data.ttd_asesor) {
                        let img = document.getElementById('imgTtdAsesor');
                        if (!img) {
                            img = document.createElement('img');
                            img.id = 'imgTtdAsesor';
                            img.className = 'max-h-24 max-w-full object-contain';
                            btnSignAsesor.parentNode.insertBefore(img, btnSignAsesor);
                        }
                        img.src = '/storage/tanda_tangan/' + data.data.ttd_asesor;
                        img.alt = 'Tanda Tangan Asesor';
                    }
                    
                    // Update date
                    const dateElem = btnSignAsesor.closest('.space-y-4').querySelector('p.text-sm.text-gray-600.mb-2');
                    if (dateElem && data.data && data.data.waktu_tanda_tangan_asesor) {
                        dateElem.textContent = formatTanggalIndo(data.data.waktu_tanda_tangan_asesor);
                    }
                    
                    btnSignAsesor.remove();
                    
                    // Update progress di list asesi
                    updateProgressStatus();
                    
                    // Disable form setelah ditandatangani
                    disableFormIfSigned();
                    
                    const successModal = document.getElementById('successModal');
                    successModal.classList.remove('hidden');
                    
                    setTimeout(() => {
                        successModal.classList.add('hidden');
                    }, 3000);
                } else {
                    throw new Error(data.message || 'Gagal menandatangani formulir');
                }
            } catch (err) {
                alert('Error: ' + err.message);
                btnSignAsesor.disabled = false;
                btnSignAsesor.textContent = 'Tandatangani';
            }
        });
    }
    
    const closeModal = document.getElementById('closeModal');
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            const successModal = document.getElementById('successModal');
            successModal.classList.add('hidden');
        });
    }

    const successModal = document.getElementById('successModal');
    if (successModal) {
        successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    }

    const saveFirstModal = document.getElementById('saveFirstModal');
    const cancelSaveModalBtn = document.getElementById('cancelSaveModal');
    const saveFormBtn = document.getElementById('saveFormBtn');

    if (cancelSaveModalBtn) {
        cancelSaveModalBtn.addEventListener('click', function() {
            saveFirstModal.classList.add('hidden');
        });
    }

    if (saveFormBtn) {
        saveFormBtn.addEventListener('click', function() {
            const validation = validateFormForSubmission();
            if (!validation.isValid) {
                alert('Form belum lengkap. Silakan lengkapi: ' + validation.emptyFields.join(', '));
                return;
            }
            
            saveFirstModal.classList.add('hidden');
            
            let dataTambahan = {
                unit_kompetensi: fria07Data.unit_kompetensi || [],
                hasil: []
            };

            let kinerjaAsesiRadio = document.querySelector('input[name="kinerja_asesi"]:checked');
            let umpanBalikKinerjaAsesiTextarea = document.querySelector('textarea[name="umpan_balik_kinerja_asesi"]');

            if (kinerjaAsesiRadio) {
                dataTambahan.hasil.push({
                    name: 'kinerja_asesi',
                    value: kinerjaAsesiRadio.value,
                    umpan_balik: umpanBalikKinerjaAsesiTextarea ? umpanBalikKinerjaAsesiTextarea.value : ''
                });
            }

            document.getElementById('dataTambahanInput').value = JSON.stringify(dataTambahan);
            
            document.getElementById('formFria07').submit();
        });
    }

    if (saveFirstModal) {
        saveFirstModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    }
});

function updateProgressStatus() {
    // Ambil ID asesi yang sedang dipilih dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const idAsesi = urlParams.get('id_asesi');
    
    if (idAsesi) {
        const progressElement = document.getElementById('progress-' + idAsesi);
        if (progressElement) {
            // Update progress dengan status signed (hanya icon)
            progressElement.innerHTML = `
                <svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>
            `;
        }
    }
}

function showDocument(id_asesi) {
    window.open('/asesor/fria07/pdf/' + id_asesi, "_blank");
}
</script>

@endsection
