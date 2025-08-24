@extends('home.home-asesor.layouts.layout')

@section('title', 'Tugas Peserta - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Notification -->
    <div id="successModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 items-center justify-center">
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
                <p class="text-sm text-gray-500">Tugas berhasil disimpan.</p>
            </div>
            <div class="mt-4 flex justify-end">
                <button id="closeModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    OK
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
        <p class="ms-2 text-xl font-bold text-black">Tugas Peserta</p>
    </div>
    {{-- Breadcrumb --}}
    <div id="breadcrumbs" class="@if(request()->get('id_asesi')) pb-4 px-6 @else hidden @endif">
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
                        <a href="{{ route('tugas-peserta') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            Tugas Peserta
                        </a>
                    </div>
                </li>
                @if(request()->get('id_asesi') && $detailRincian)
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-black">
                            {{ $detailRincian->asesi->nama_asesi ?? 'Nama Asesi Tidak Tersedia' }}
                        </span>
                    </div>
                </li>
                @endif
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameTugasPeserta" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Tugas Peserta Sertifikasi</p>
        <!-- Search Form -->
        <form id="searchTugasPeserta" class="max-w-md mb-4 rounded-xl @if(request()->get('id_asesi')) hidden @endif">
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
        <div class="overflow-x-auto shadow-sm rounded-lg @if(request()->get('id_asesi')) hidden @endif">
            <table id="daftarTugasPeserta" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Aksi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Tugas Dikumpulkan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(6)">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                @forelse($daftarAsesi ?? [
                    (object) [
                        'asesi' => (object) [
                            'id_asesi' => 1,
                            'nama_asesi' => 'Muhammad Rifai', 
                            'skema' => (object) [
                                'nama_skema' => 'Junior Web Developer',
                                'nomor_skema' => 'J.620100.001.02'
                            ]
                        ]
                    ],
                    (object) [
                        'asesi' => (object) [
                            'id_asesi' => 2,
                            'nama_asesi' => 'Ahmad Fauzi',
                            'skema' => (object) [
                                'nama_skema' => 'Network Administrator', 
                                'nomor_skema' => 'J.611100.009.01'
                            ]
                        ]
                    ]
                ] as $i => $rincian)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $i+1 }}</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="window.location.href='{{ route('tugas-peserta') }}?id_asesi={{ $rincian->asesi->id_asesi ?? 1 }}'" class="">
                                <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button onclick="showDocument('{{ $rincian->asesi->id_asesi ?? 1 }}')" class="">
                                <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->nama_asesi ?? 'Nama tidak tersedia' }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->skema->nama_skema ?? 'Skema tidak tersedia' }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $rincian->asesi->skema->nomor_skema ?? 'Kode tidak tersedia' }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $rincian->task_count ?? 0 }} Tugas
                            </span>
                        </td>
                        <td class="px-4 py-0">
                            <div class="flex px-4 py-3 justify-center items-center" id="status-{{ $rincian->asesi->id_asesi ?? 1 }}">
                                @if($rincian->task_count == 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2L3 7v11c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V7l-7-5z"/>
                                        </svg>
                                        Belum Ada Tugas
                                    </span>
                                @elseif(!$rincian->all_reviewed)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-600">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
                                        </svg>
                                        Menunggu Review
                                    </span>
                                @elseif($rincian->has_rejected)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                        </svg>
                                        Perlu Perbaikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                        </svg>
                                        Selesai Review
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div id="detailTugasPeserta" class="@if(request()->get('id_asesi')) p-4 text-black @else hidden @endif">
            <!-- Input Tugas Peserta -->
            <div id="FormTugasPeserta" class="pt-0 p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            @if($detailRincian) {{ $detailRincian->asesi->skema->nama_skema ?? 'Nama Skema tidak tersedia' }} @else Nama Skema tidak tersedia @endif
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            @if($detailRincian) {{ $detailRincian->asesi->skema->nomor_skema ?? 'Kode Skema tidak tersedia' }} @else Kode Skema tidak tersedia @endif
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            @if($detailRincian) {{ $detailRincian->asesi->nama_asesi ?? 'Nama Asesi tidak tersedia' }} @else Nama Asesi tidak tersedia @endif
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            @if($detailRincian) {{ $detailRincian->asesor->nama_asesor ?? 'Nama Asesor tidak tersedia' }} @else Nama Asesor tidak tersedia @endif
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            @if($detailRincian) {{ $detailRincian->event->tuk->nama_tuk ?? 'TUK tidak tersedia' }} @else TUK tidak tersedia @endif
                        </p>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tugas yang Dikumpulkan Peserta -->
            @if(isset($tugasData['submitted_tasks']) && $tugasData['submitted_tasks']->count() > 0)
            <div id="DaftarTugasDikumpulkan" class="mb-8 bg-white rounded-lg shadow-sm border">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tugas yang Dikumpulkan ({{ $tugasData['submitted_tasks']->count() }})
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($tugasData['submitted_tasks'] as $task)
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $task->judul_tugas }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            @if($task->jenis_evidence == '1') bg-green-100 text-green-800 
                                            @elseif($task->jenis_evidence == '2') bg-blue-100 text-blue-800 
                                            @else bg-purple-100 text-purple-800 @endif">
                                            @if($task->jenis_evidence == '1') 
                                                📝 Teks Jawaban
                                            @elseif($task->jenis_evidence == '2') 
                                                🔗 Link Eksternal
                                            @else 
                                                📎 File Upload
                                            @endif
                                        </span>
                                        <span class="ml-2 text-gray-500">
                                            Dikumpulkan: {{ $task->waktu_submit->format('d/m/Y H:i') }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($task->status == 'submitted') bg-yellow-100 text-yellow-800
                                        @elseif($task->status == 'reviewed') bg-blue-100 text-blue-800
                                        @elseif($task->status == 'approved') bg-green-100 text-green-800
                                        @elseif($task->status == 'rejected') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                    @if($task->nilai)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            Nilai: {{ $task->nilai }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Konten Tugas -->
                            <div class="mt-3">
                                @if($task->jenis_evidence == '1')
                                    <div class="bg-white p-3 rounded border">
                                        <p class="text-sm text-gray-700">{{ Str::limit(strip_tags($task->teks_jawaban), 200) }}</p>
                                        @if(strlen(strip_tags($task->teks_jawaban)) > 200)
                                            <button class="text-blue-600 text-xs mt-1 hover:underline" 
                                                onclick="toggleText(this, '{{ addslashes(strip_tags($task->teks_jawaban)) }}')">
                                                Lihat selengkapnya
                                            </button>
                                        @endif
                                    </div>
                                @elseif($task->jenis_evidence == '2')
                                    <div class="bg-white p-3 rounded border">
                                        <a href="{{ $task->link_eksternal }}" target="_blank" 
                                           class="text-blue-600 hover:underline text-sm break-all">
                                            {{ $task->link_eksternal }}
                                        </a>
                                    </div>
                                @else
                                    <div class="bg-white p-3 rounded border">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                </svg>
                                                <span class="text-sm text-gray-700">{{ $task->file_name }}</span>
                                                <span class="text-xs text-gray-500 ml-2">({{ number_format($task->file_size / 1024, 1) }} KB)</span>
                                            </div>
                                            <a href="{{ route('tugas-peserta.download', $task->id) }}" 
                                               class="text-blue-600 hover:underline text-sm font-medium">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Catatan Asesor -->
                            @if($task->catatan_asesor)
                                <div class="mt-3 bg-yellow-50 p-3 rounded border border-yellow-200">
                                    <h5 class="text-sm font-medium text-yellow-800 mb-1">Catatan Asesor:</h5>
                                    <p class="text-sm text-yellow-700">{{ $task->catatan_asesor }}</p>
                                </div>
                            @endif

                            <!-- Form Update Status -->
                            <div class="mt-4 border-t pt-3">
                                <form method="POST" action="{{ route('tugas-peserta.status', $task->id) }}" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="text-sm border border-gray-300 rounded px-2 py-1">
                                        <option value="reviewed" @if($task->status == 'reviewed') selected @endif>Reviewed</option>
                                        <option value="approved" @if($task->status == 'approved') selected @endif>Approved</option>
                                        <option value="rejected" @if($task->status == 'rejected') selected @endif>Rejected</option>
                                    </select>
                                    <input type="number" name="nilai" placeholder="Nilai (0-100)" 
                                           value="{{ $task->nilai }}" min="0" max="100" step="0.01"
                                           class="text-sm border border-gray-300 rounded px-2 py-1 w-24">
                                    <input type="text" name="catatan_asesor" placeholder="Catatan..." 
                                           value="{{ $task->catatan_asesor }}"
                                           class="text-sm border border-gray-300 rounded px-2 py-1 flex-1">
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Button Simpan --}}
            {{-- <form id="formTugasPeserta" method="POST" action="{{ route('tugas-peserta.store') }}">
                @csrf
                <input type="hidden" name="id_asesi" value="{{ request()->get('id_asesi') ?? '' }}">
                <input type="hidden" name="id_asesor" value="1">
                <input type="hidden" name="id_skema" value="1">
                <input type="hidden" name="id_event" value="1">
                <input type="hidden" name="id_rincian_asesmen" value="1">
                <input type="hidden" id="dataTugasInput" name="data_tugas">
                <div class="flex justify-end pe-4">
                    <button id="simpanTugasPeserta" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6">
                        Simpan Tugas
                    </button>
                </div>
            </form> --}}
        </div>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<script>
// Data untuk Tugas Peserta
let tugasPesertaData = {};

function showSummary() {
    // Sembunyikan elemen pencarian utama
    document.getElementById('searchTugasPeserta').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarTugasPeserta').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailTugasPeserta').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailTugasPeserta').scrollIntoView({ behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function() {
    // Check if id_asesi parameter exists and show detail
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('id_asesi')) {
        showSummary();
    }
    
    // Check for success message from session
    @if(session('success'))
        showSuccessModal();
    @endif

    // Update form before submit
    document.getElementById('formTugasPeserta')?.addEventListener('submit', function(e) {
        const judulTugas = document.getElementById('judul_tugas')?.value?.trim();
        const deskripsiTugas = document.getElementById('deskripsi_tugas')?.value?.trim();
        const batasWaktu = document.getElementById('batas_waktu')?.value;
        const catatanTambahan = document.getElementById('catatan_tambahan')?.value?.trim();

        // Validasi input
        const errors = [];
        if (!judulTugas) errors.push('Judul Tugas');
        if (!deskripsiTugas) errors.push('Deskripsi Tugas');
        if (!batasWaktu) errors.push('Batas Waktu Pengumpulan');
        
        if (errors.length > 0) {
            e.preventDefault(); 
            alert('Field berikut harus diisi: ' + errors.join(', '));
            return false;
        }

        let dataTugas = {
            judul_tugas: judulTugas,
            deskripsi_tugas: deskripsiTugas,
            batas_waktu: batasWaktu,
            catatan_tambahan: catatanTambahan
        };

        const dataTugasInput = document.getElementById('dataTugasInput');
        if (dataTugasInput) {
            dataTugasInput.value = JSON.stringify(dataTugas);
        }
    });

    const closeModal = document.getElementById('closeModal');
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            const successModal = document.getElementById('successModal');
            successModal.classList.add('hidden');
            successModal.classList.remove('flex');
        });
    }

    const successModal = document.getElementById('successModal');
    if (successModal) {
        successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    }
});

function showSuccessModal() {
    const successModal = document.getElementById('successModal');
    if (successModal) {
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');
    }
}

function showDocument(id_asesi) {
    window.open('/asesor/tugas-peserta/pdf/' + id_asesi, "_blank");
}

// Table sorting function
function sortTable(columnIndex) {
    const table = document.getElementById('daftarTugasPeserta');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    // Skip if there are less than 2 rows or the rows don't have enough cells
    if (rows.length < 2 || rows[0].querySelectorAll('td').length <= columnIndex) {
        return;
    }

    // Determine the current sort direction
    const isAscending = !table.getAttribute('data-sort-dir') || table.getAttribute('data-sort-dir') === 'desc';
    
    // Sort the rows
    rows.sort((a, b) => {
        const aText = a.querySelectorAll('td')[columnIndex].textContent.trim();
        const bText = b.querySelectorAll('td')[columnIndex].textContent.trim();
        
        // Handle numeric columns (No column)
        if (columnIndex === 0) {
            return isAscending ? 
                parseInt(aText) - parseInt(bText) : 
                parseInt(bText) - parseInt(aText);
        }
        
        // Handle text columns
        return isAscending ? 
            aText.localeCompare(bText) : 
            bText.localeCompare(aText);
    });

    // Clear tbody and append sorted rows
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));

    // Update sort direction
    table.setAttribute('data-sort-dir', isAscending ? 'asc' : 'desc');
}

// Function to toggle full text display
function toggleText(button, fullText) {
    const container = button.parentElement;
    const isExpanded = container.getAttribute('data-expanded') === 'true';
    
    if (isExpanded) {
        // Show truncated text
        const truncated = fullText.length > 200 ? fullText.substring(0, 200) + '...' : fullText;
        container.querySelector('p').textContent = truncated;
        button.textContent = 'Lihat selengkapnya';
        container.setAttribute('data-expanded', 'false');
    } else {
        // Show full text
        container.querySelector('p').textContent = fullText;
        button.textContent = 'Lihat lebih sedikit';
        container.setAttribute('data-expanded', 'true');
    }
}
</script>

@endsection
