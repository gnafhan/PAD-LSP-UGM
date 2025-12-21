@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.IA.01 - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Custom Modal for Success Notification -->
    <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
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
                    <svg class="h-8 w-8 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Simpan Form Terlebih Dahulu</h3>
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
                    Simpan Form
                </button>
            </div>
        </div>
    </div>
    
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <stop offset="100%" stop-color="#8B5CF6" /> </linearGradient>
            </defs>
            <path
                d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
            />
        </svg>
        <p class="ms-2 text-xl font-bold text-black">IA.01</p>
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
                        <a href="{{ route('fria01-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.IA.01
                        </a>
                    </div>
                </li>
                @if($detailRincian && $detailRincian->asesi)
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

    <div id="frameIA01" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">

        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir IA.01 Observasi Aktifitas di Tempat Kerja atau Tempat Kerja Simulasi</p>
        
        {{-- Search Form --}}
        <form id="searchIA01" class="max-w-md mb-4 rounded-xl @if($detailRincian) hidden @endif">
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
            <table id="daftarIA01" class="min-w-full bg-white overflow-hidden">
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
                @foreach($daftarAsesi as $i => $rincian)
                    @if($rincian->asesi)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $i+1 }}</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="window.location.href='{{ route('fria01-asesor') }}?id_asesi={{ $rincian->asesi->id_asesi }}'" class="">
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
                                    $progress = $rincian->asesi->progresAsesmen->ia01['completed'] ?? false;
                                @endphp
                                @if($progress)
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
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Detail Section --}}
        <div id="detailIA01" class="@if($detailRincian) p-4 text-black @else hidden @endif">

            {{-- Input Formulir IA.01 --}}
            <div id="FRIA01" class="pt-0 p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->asesi->skema->nama_skema ?? '-' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->asesi->skema->nomor_skema ?? '-' }}
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $detailRincian->asesi->nama_asesi ?? '-' }}
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
                        {{ $detailRincian->event->tuk->nama_tuk ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Panduan Bagi Asesor --}}
            <div id="panduanAsesor" class="mb-6 p-4 mt-10">
                <h3 class="text-lg font-semibold text-black mb-4 text-center">PANDUAN BAGI ASESOR</h3>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Lengkapi nama unit kompetensi, elemen, dan kriteria untuk kerja sesuai kolom dalam tabel.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Isilah standar industri atau tempat kerja</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Beri tanda centang ( √ ) pada kolom "YA" jika Anda yakin asesi dapat melaksanakan/mendemonstrasikan tugas sesuai KUK, atau centang ( √ ) pada kolom "Tidak" bila sebaliknya.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Penilaian Lanjut diisi bila hasil belum dapat disimpulkan, untuk itu gunakan metode lain sehingga keputusan dapat dibuat.</span>
                    </li>
                    <li class="flex items-start">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                        <span>Isilah kolom KUK sesuai dengan Unit Kompetensi/ SKKNI</span>
                    </li>
                </ul>
            </div>

            {{-- Kelompok Pekerjaan Kegiatan Rekreasi --}}
            {{-- <div class="p-4">
                <p class="mb-4 text-lg font-semibold text-black">Kelompok Pekerjaan Kegiatan Rekreasi</p>
                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Menangani Situasi Konflik</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Menangani Situasi Konflik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black text-center items-center">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="px-4 py-3 text-gray-700 text-left">Mengidentifikasi situasi konflik ?</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="px-4 py-3 text-gray-700 text-left">Mengidentifikasi situasi konflik ?</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="px-4 py-3 text-gray-700 text-left">Mengidentifikasi situasi konflik ?</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}

            {{-- Checklist Kompeten --}}
            <div id="clKompeten" class="p-4">
                <form class="max-w-full mx-auto">
                    <label for="pilihKompetensi" class="block mb-2 font-semibold text-sidebar_Font text-sidebar_font">Checklist Kompetensi</label>
                    @php
                        $dominantKompetensi = '';
                        $kompeten = 0;
                        $tidakKompeten = 0;
                        
                        if ($formData && isset($formData->data_tambahan['unit_kompetensi'])) {
                            foreach ($formData->data_tambahan['unit_kompetensi'] as $unitData) {
                                foreach ($unitData['elemen'] as $elemenData) {
                                    if ($elemenData['kompetensi'] === 'kompeten') {
                                        $kompeten++;
                                    } elseif ($elemenData['kompetensi'] === 'tidak_kompeten') {
                                        $tidakKompeten++;
                                    }
                                }
                            }
                            
                            if ($kompeten > $tidakKompeten) {
                                $dominantKompetensi = 'kompeten';
                            } elseif ($tidakKompeten > $kompeten) {
                                $dominantKompetensi = 'tidak_kompeten';
                            }
                        }
                    @endphp
                    <select id="pilihKompetensi" class="border border-border_input text-sidebar_font text-sm rounded-lg focus:ring-biru focus:border-biru block w-full p-2 {{ $dominantKompetensi === 'kompeten' ? 'text-green-600' : ($dominantKompetensi === 'tidak_kompeten' ? 'text-red-600' : '') }}">
                        <option {{ $dominantKompetensi === '' ? 'selected' : '' }}>Pilih Kompetensi</option>
                        <option value="kompeten" {{ $dominantKompetensi === 'kompeten' ? 'selected' : '' }}>Kompeten</option>
                        <option value="tidak_kompeten" {{ $dominantKompetensi === 'tidak_kompeten' ? 'selected' : '' }}>Tidak Kompeten</option>
                    </select>
                </form>
            </div>



            {{-- Tabel Unit Kompetensi --}}
            @php
                $unitKompetensiList = $detailRincian->asesi->skema->unit_kompetensi ?? collect();
            @endphp
            @foreach($unitKompetensiList as $idx => $unit)
            <div class="p-4" data-unit-kode="{{ $unit->kode_uk }}" data-unit-nama="{{ $unit->nama_uk }}">
                <p class=" text-black font-semibold pb-4 text-2xl">Unit Kompetensi No {{ $idx+1 }}</p>
                <p class="text-sidebar_font font-semibold pb-2">Kode Unit : {{ $unit->kode_uk }}</p>
                <p class="text-sidebar_font font-semibold pb-2">Judul : {{ $unit->nama_uk }}</p>
                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Elemen</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Benchmark (SOP / Spesifikasi Produk Industri)</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Kompetensi</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Penilaian Lanjut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black text-center items-center">
                            @forelse($unit->elemen_uk as $i => $elemen)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $i+1 }}</td>
                                <td class="px-4 py-3 text-gray-700 text-left">{{ $elemen->nama_elemen }}</td>
                                <td class="px-4 py-3 text-gray-700 text-left">SOP Menerapkan Prosedur</td>
                                <td class="flex px-4 py-3 justify-center">
                                    <form class="w-40">
                                        @php
                                            $selectedValue = '';
                                            if ($formData && isset($formData->data_tambahan['unit_kompetensi'])) {
                                                foreach ($formData->data_tambahan['unit_kompetensi'] as $ukData) {
                                                    if ($ukData['kode_uk'] === $unit->kode_uk) {
                                                        foreach ($ukData['elemen'] as $elemenData) {
                                                            if ($elemenData['nama_elemen'] === $elemen->nama_elemen) {
                                                                $selectedValue = $elemenData['kompetensi'];
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <select name="kompetensi_{{ $unit->kode_uk }}_{{ $elemen->id_elemen }}" onchange="ubahWarnaSelect()" class="border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru block w-full px-2 py-1 bg-white text-black {{ $selectedValue === 'kompeten' ? 'text-green-600' : ($selectedValue === 'tidak_kompeten' ? 'text-red-600' : 'text-black') }}">
                                            <option value="" {{ $selectedValue === '' ? 'selected' : '' }}>Pilih</option>
                                            <option value="kompeten" {{ $selectedValue === 'kompeten' ? 'selected' : '' }}>Kompeten</option>
                                            <option value="tidak_kompeten" {{ $selectedValue === 'tidak_kompeten' ? 'selected' : '' }}>Tidak Kompeten</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left">
                                    @php
                                        $catatanValue = '';
                                        if ($formData && isset($formData->data_tambahan['unit_kompetensi'])) {
                                            foreach ($formData->data_tambahan['unit_kompetensi'] as $ukData) {
                                                if ($ukData['kode_uk'] === $unit->kode_uk) {
                                                    foreach ($ukData['elemen'] as $elemenData) {
                                                        if ($elemenData['nama_elemen'] === $elemen->nama_elemen) {
                                                            $catatanValue = $elemenData['catatan'];
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <textarea name="catatan_{{ $unit->kode_uk }}_{{ $elemen->id_elemen }}" placeholder="Lainnya..." class="border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru block w-full px-2 py-1 bg-white text-black">{{ $catatanValue }}</textarea>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-gray-400 italic py-4">Tidak ada elemen kompetensi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            

            <div class="my-6 px-4 space-y-6">
                {{-- Hasil --}}
                <div class="p-4">
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
                                            if ($formData && isset($formData->data_tambahan['hasil'])) {
                                                foreach ($formData->data_tambahan['hasil'] as $hasil) {
                                                    if ($hasil['name'] === 'kinerja_asesi') {
                                                        $kinerjaValue = $hasil['value'];
                                                        $umpanBalik = $hasil['umpan_balik'];
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
                                    // Get latest valid signature from TandaTanganAsesor
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
                                    <button id="btnSignAsesor" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm font-medium hover:bg-biru_soft focus:outline-none" data-fria01-id="{{ $formData->id_fria01 ?? '' }}">
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
                <form id="formFria01" method="POST" action="{{ route('fria01.store') }}">
                    @csrf
                    <input type="hidden" name="id_asesi" value="{{ $detailRincian->asesi->id_asesi ?? '' }}">
                    <input type="hidden" name="id_asesor" value="{{ $detailRincian->asesor->id_asesor ?? '' }}">
                    <input type="hidden" name="id_skema" value="{{ $detailRincian->asesi->skema->id_skema ?? '' }}">
                    <input type="hidden" name="id_event" value="{{ $detailRincian->event->id_event ?? '' }}">
                    <input type="hidden" name="id_rincian_asesmen" value="{{ $detailRincian->id_rincian_asesmen ?? '' }}">
                    <input type="hidden" id="dataTambahanInput" name="data_tambahan">
                    <div class="flex justify-end pe-4">
                        <button id="simpanKompeten" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6" @if($formData && $formData->isAsesorSigned()) disabled @endif>
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

    </div>
</div>

<script>
document.getElementById('formFria01').addEventListener('submit', function(e) {
    let dataTambahan = {
        hasil: [],
        ttd_asesor: "{{ $formData && isset($formData->data_tambahan['ttd_asesor']) ? $formData->data_tambahan['ttd_asesor'] : ($ttd_asesor ?? '') }}",
        nama_asesor: "{{ $formData && isset($formData->data_tambahan['nama_asesor']) ? $formData->data_tambahan['nama_asesor'] : ($nama_asesor ?? '') }}",
        tanggal_ttd: "{{ $formData && isset($formData->data_tambahan['tanggal_ttd']) ? $formData->data_tambahan['tanggal_ttd'] : ($tanggal_ttd ?? '') }}",
        unit_kompetensi: []
    };

    // Kumpulkan data unit_kompetensi dan elemennya
    document.querySelectorAll('[data-unit-kode]').forEach(function(unitDiv) {
        let unitObj = {
            kode_uk: unitDiv.getAttribute('data-unit-kode'),
            nama_uk: unitDiv.getAttribute('data-unit-nama'),
            elemen: []
        };
        unitDiv.querySelectorAll('tbody tr').forEach(function(row) {
            let nama_elemen = row.querySelector('td:nth-child(2)')?.innerText?.trim() || '';
            let kompetensi = row.querySelector('select[name^="kompetensi_"]')?.value || '';
            let catatan = row.querySelector('textarea[name^="catatan_"]')?.value || '';
            if (nama_elemen) { 
                unitObj.elemen.push({
                    nama_elemen: nama_elemen,
                    kompetensi: kompetensi,
                    catatan: catatan
                });
            }
        });
        dataTambahan.unit_kompetensi.push(unitObj);
    });

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
});

function formatTanggalIndo(dateStr) {
    const date = new Date(dateStr);
    const day = date.getDate().toString().padStart(2, '0');
    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();
    return `${day} ${month} ${year}`; // Output: 30 Juli 2025
}

document.addEventListener('DOMContentLoaded', function() {
    // Disable form jika sudah ditandatangani
    function disableFormIfSigned() {
        const isSigned = {{ $formData && $formData->isAsesorSigned() ? 'true' : 'false' }};
        if (isSigned) {
            // Disable semua input dan select
            document.querySelectorAll('select[name^="kompetensi_"]').forEach(select => {
                select.disabled = true;
            });
            document.querySelectorAll('textarea[name^="catatan_"]').forEach(textarea => {
                textarea.disabled = true;
            });
            document.querySelectorAll('input[name="kinerja_asesi"]').forEach(radio => {
                radio.disabled = true;
            });
            document.querySelectorAll('textarea[name="umpan_balik_kinerja_asesi"]').forEach(textarea => {
                textarea.disabled = true;
            });
            document.getElementById('pilihKompetensi').disabled = true;
            
            // Update button state
            const simpanBtn = document.getElementById('simpanKompeten');
            if (simpanBtn) {
                simpanBtn.disabled = true;
                simpanBtn.textContent = 'Sudah Ditandatangani';
                simpanBtn.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru_soft');
                simpanBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            }
        }
    }
    
    // Validasi form sebelum bisa ditandatangani
    function validateForm() {
        let isValid = true;
        let emptyFields = [];
        
        // Check kompetensi selects
        document.querySelectorAll('select[name^="kompetensi_"]').forEach(select => {
            if (!select.value) {
                isValid = false;
                emptyFields.push('Kompetensi');
            }
        });
        
        // Check kinerja asesi
        const kinerjaRadios = document.querySelectorAll('input[name="kinerja_asesi"]');
        const kinerjaSelected = Array.from(kinerjaRadios).some(radio => radio.checked);
        if (!kinerjaSelected) {
            isValid = false;
            emptyFields.push('Kinerja Asesi');
        }
        
        return { isValid, emptyFields };
    }
    
    // Initialize form state
    disableFormIfSigned();
    
    const ttdImages = document.querySelectorAll('img[alt*="Tanda Tangan"]');

    ttdImages.forEach(function(img) {
        img.addEventListener('error', function() {
            const placeholder = document.createElement('div');
            placeholder.className = 'border-2 border-dashed border-gray-300 rounded-lg p-8 w-full h-full flex items-center justify-center bg-gray-50';
            placeholder.innerHTML = '<span class="text-gray-400 text-sm">Gambar tidak ditemukan</span>';
            
            this.parentNode.replaceChild(placeholder, this);
        });
    });

    function ubahWarnaSelect() {
        const selects = document.querySelectorAll('select[name^="kompetensi_"]'); 
        selects.forEach(select => {
            select.classList.remove('text-green-600', 'text-red-600', 'text-black'); 
            if (select.value === 'kompeten') {
                select.classList.add('text-green-600');
            } else if (select.value === 'tidak_kompeten') {
                select.classList.add('text-red-600');
            } else {
                select.classList.add('text-black'); 
            }
        });
    }

    ubahWarnaSelect();

    const selectKompetensiElements = document.querySelectorAll('select[name^="kompetensi_"]');
    selectKompetensiElements.forEach(select => {
        select.addEventListener('change', ubahWarnaSelect);
    });

    const pilihKompetensiSelect = document.getElementById('pilihKompetensi');
    
    if (pilihKompetensiSelect) {
        if (pilihKompetensiSelect.value === 'kompeten') {
            pilihKompetensiSelect.classList.add('text-green-600');
        } else if (pilihKompetensiSelect.value === 'tidak_kompeten') {
            pilihKompetensiSelect.classList.add('text-red-600');
        }
        
        pilihKompetensiSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            
            // Update select color
            this.classList.remove('text-green-600', 'text-red-600');
            if (selectedValue === 'kompeten') {
                this.classList.add('text-green-600');
            } else if (selectedValue === 'tidak_kompeten') {
                this.classList.add('text-red-600');
            }
            
            // Update all kompetensi selects
            const kompetensiSelects = document.querySelectorAll('select[name^="kompetensi_"]');
            
            kompetensiSelects.forEach(select => {
                select.value = selectedValue;
                const event = new Event('change');
                select.dispatchEvent(event);
            });
            ubahWarnaSelect(); 
        });
    }

    // Signature button logic (separate from checklist logic)
    const btnSignAsesor = document.getElementById('btnSignAsesor');
    if (btnSignAsesor) {
        btnSignAsesor.addEventListener('click', async function() {
            // Validasi form sebelum tanda tangan
            const validation = validateForm();
            if (!validation.isValid) {
                alert('Form belum lengkap. Silakan isi: ' + validation.emptyFields.join(', '));
                return;
            }
            
            const fria01Id = btnSignAsesor.getAttribute('data-fria01-id');
            
            // Jika form belum disimpan (fria01Id kosong), tampilkan modal warning
            if (!fria01Id || fria01Id === '') {
                const saveFirstModal = document.getElementById('saveFirstModal');
                saveFirstModal.classList.remove('hidden');
                return;
            }
            
            btnSignAsesor.disabled = true;
            btnSignAsesor.textContent = 'Menyimpan...';
            try {
                const response = await fetch(`/api/v1/asesmen/fria01/${fria01Id}/sign-asesor`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'API-KEY': '{{ config('services.api.key') }}',
                    },
                    body: JSON.stringify({ id_asesor: @json(Auth::user()->asesor->id_asesor ?? null) })
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
                    
                    // Disable form setelah ditandatangani
                    disableFormIfSigned();
                    
                    const successModal = document.getElementById('successModal');
                    successModal.classList.remove('hidden');
                    setTimeout(() => {
                        successModal.classList.add('hidden');
                    }, 3000);
                } else {
                    btnSignAsesor.disabled = false;
                    btnSignAsesor.textContent = 'Tandatangani';
                    alert(data.message || 'Gagal menandatangani.');
                }
            } catch (err) {
                btnSignAsesor.disabled = false;
                btnSignAsesor.textContent = 'Tandatangani';
                alert('Terjadi kesalahan: ' + err.message);
            }
        });
    }
    
    // Event listener for custom modal close button
    const closeModal = document.getElementById('closeModal');
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            const successModal = document.getElementById('successModal');
            successModal.classList.add('hidden');
        });
    }

    // Close modal if clicked outside
    const successModal = document.getElementById('successModal');
    if (successModal) {
        successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    }

    // Modal for Save First Warning
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
            saveFirstModal.classList.add('hidden');
            
            // Kumpulkan data seperti form submit yang asli
            let dataTambahan = {
                hasil: [],
                ttd_asesor: "{{ $formData && isset($formData->data_tambahan['ttd_asesor']) ? $formData->data_tambahan['ttd_asesor'] : ($ttd_asesor ?? '') }}",
                nama_asesor: "{{ $formData && isset($formData->data_tambahan['nama_asesor']) ? $formData->data_tambahan['nama_asesor'] : ($nama_asesor ?? '') }}",
                tanggal_ttd: "{{ $formData && isset($formData->data_tambahan['tanggal_ttd']) ? $formData->data_tambahan['tanggal_ttd'] : ($tanggal_ttd ?? '') }}",
                unit_kompetensi: []
            };

            // Kumpulkan data unit_kompetensi dan elemennya
            document.querySelectorAll('[data-unit-kode]').forEach(function(unitDiv) {
                let unitObj = {
                    kode_uk: unitDiv.getAttribute('data-unit-kode'),
                    nama_uk: unitDiv.getAttribute('data-unit-nama'),
                    elemen: []
                };
                unitDiv.querySelectorAll('tbody tr').forEach(function(row) {
                    let nama_elemen = row.querySelector('td:nth-child(2)')?.innerText?.trim() || '';
                    let kompetensi = row.querySelector('select[name^="kompetensi_"]')?.value || '';
                    let catatan = row.querySelector('textarea[name^="catatan_"]')?.value || '';
                    if (nama_elemen) { 
                        unitObj.elemen.push({
                            nama_elemen: nama_elemen,
                            kompetensi: kompetensi,
                            catatan: catatan
                        });
                    }
                });
                dataTambahan.unit_kompetensi.push(unitObj);
            });

            let kinerjaAsesiRadio = document.querySelector('input[name="kinerja_asesi"]:checked');
            let umpanBalikKinerjaAsesiTextarea = document.querySelector('textarea[name="umpan_balik_kinerja_asesi"]');

            if (kinerjaAsesiRadio) {
                dataTambahan.hasil.push({
                    name: 'kinerja_asesi',
                    value: kinerjaAsesiRadio.value,
                    umpan_balik: umpanBalikKinerjaAsesiTextarea ? umpanBalikKinerjaAsesiTextarea.value : ''
                });
            }

            // Set data tambahan ke input hidden
            document.getElementById('dataTambahanInput').value = JSON.stringify(dataTambahan);
            
            // Submit form
            document.getElementById('formFria01').submit();
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

function sortTable(n) {
    let table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("daftarIA01"); 
    switching = true;
    dir = "asc"; 
    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch= true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;       
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function showDocument(id_asesi) {
    window.open('/asesor/fria01/pdf/' + id_asesi, "_blank");
}
</script>

@endsection