@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.IA.01 - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
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
                <p class="text-sidebar_font font-semibold pb-4 text-2xl">Unit Kompetensi No {{ $idx+1 }}</p>
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
                    <h3 class="text-sidebar_font font-semibold pb-4 text-xl">Hasil</h3>
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
                    <h3 class="text-sidebar_font font-semibold pb-4 text-xl">Tandatangan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kolom Asesi --}}
                        <div class="text-center space-y-4">
                            @php
                                $tanggal_ttd = $tanggal_ttd ?? date('d F Y'); 
                                $nama_asesi = $detailRincian->asesi->nama_asesi ?? 'Nama Asesi'; 
                            @endphp
                            <p class="text-sm text-gray-600 mb-2">{{ $tanggal_ttd }}</p>
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
                                $nama_asesor = $formData && isset($formData->data_tambahan['nama_asesor']) ? 
                                    $formData->data_tambahan['nama_asesor'] : 
                                    ($detailRincian->asesor->nama_asesor ?? 'Nama Asesor');
                                
                                $tanggal_ttd = $formData && isset($formData->data_tambahan['tanggal_ttd']) ? 
                                    $formData->data_tambahan['tanggal_ttd'] : 
                                    ($tanggal_ttd ?? date('d F Y'));
                                
                                $ttd_asesor = $formData && isset($formData->data_tambahan['ttd_asesor']) ? 
                                    $formData->data_tambahan['ttd_asesor'] : 
                                    ($ttd_asesor ?? '');
                            @endphp
                            <p class="text-sm text-gray-600 mb-2">{{ $tanggal_ttd }}</p>
                            <div class="h-32 flex items-center justify-center bg-white">
                                @if(isset($ttd_asesor) && $ttd_asesor)
                                    {{-- Gambar tanda tangan asesor --}}
                                    <img src="{{ asset('storage/ttd/' . $ttd_asesor) }}" 
                                        alt="Tanda Tangan Asesor" 
                                        class="max-h-24 max-w-full object-contain">
                                @else
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 w-full h-full flex items-center justify-center bg-gray-50">
                                        <span class="text-gray-400 text-sm">Belum ada tanda tangan</span>
                                    </div>
                                @endif
                            </div>
                            <div class="border-t border-gray-400 pt-2">
                                <p class="text-sm font-medium text-gray-700">Asesor</p>
                                <p class="text-sm text-gray-600">{{ $nama_asesor }}</p>
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
                        <button id="simpanKompeten" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6">
                            Simpan dan Setujui
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

document.addEventListener('DOMContentLoaded', function() {
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
            document.querySelectorAll('select[name^="kompetensi_"]').forEach(select => {
                select.value = selectedValue;
                const event = new Event('change');
                select.dispatchEvent(event);
            });
            ubahWarnaSelect(); 
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