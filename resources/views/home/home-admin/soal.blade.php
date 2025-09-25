@extends('home.home-admin.layouts.layout')

@section('title', 'Manajemen Soal Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('styles')
{{-- CDN untuk DataTables.js CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
<style>
    /* Style tooltip tetap sama */
    .tooltip { position: relative; display: inline-block; cursor: help; }
    .tooltip .tooltip-text { visibility: hidden; position: absolute; z-index: 10; bottom: 125%; left: 50%; transform: translateX(-50%); width: 300px; background-color: #1f2937; color: #fff; text-align: left; padding: 0.75rem; border-radius: 0.375rem; opacity: 0; transition: opacity 0.3s; font-size: 0.875rem; pointer-events: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    .tooltip:hover .tooltip-text { visibility: visible; opacity: 1; }

    /* Kustomisasi DataTables agar lebih rapi */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5em 0.8em;
    }
    .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info {
        padding: 1rem 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Page Header --}}
        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-7 text-gray-900">Manajemen Soal Sertifikasi</h2>
                <p class="mt-1 text-sm text-gray-500">Klik pada nama skema untuk membuka/menutup daftar soal.</p>
            </div>
            <a href="{{ route('admin.soal.create') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Tambah Soal Baru
            </a>
        </div>

        {{-- Filter dan Search (ini akan memfilter semua data sebelum ditampilkan) --}}
        <div class="mb-8 bg-white p-4 rounded-lg shadow-md">
            {{-- Form tidak berubah --}}
            <form method="GET" action="{{ route('admin.soal.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="col-span-full w-full">
                    <label for="skema" class="block text-sm font-medium text-gray-700 mb-1">
                        Filter Skema
                    </label>
                    <select name="skema" id="skema" 
                            onchange="this.form.submit()" 
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 
                                focus:outline-none focus:ring-blue-500 focus:border-blue-500 
                                sm:text-sm rounded-md">
                        <option value="">Semua Skema</option>
                        @foreach ($skema as $s)
                            <option value="{{ $s->id_skema }}" {{ request('skema') == $s->id_skema ? 'selected' : '' }}>
                                {{ $s->nama_skema }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="col-span-full w-full">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Global</label>
                    <div class="flex rounded-md shadow-sm">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Filter pertanyaan di semua skema..." class="focus:ring-blue-500 focus:border-blue-500 block w-full rounded-l-md sm:text-sm border-gray-300 px-4 py-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 text-sm font-medium rounded-r-md text-gray-700 bg-gray-50 hover:bg-gray-100">
                            Cari
                        </button>
                    </div>
                </div> --}}
            </form>
        </div>

        @php
            // Logika grouping tetap sama
            $groupedSoal = $soal->groupBy(function($item) {
                return $item->skema->nama_skema ?? 'Tanpa Skema';
            });
        @endphp

        <div class="space-y-6">
            @forelse ($groupedSoal as $namaSkema => $soalDalamSkema)
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300">
                    
                    <div @click="open = !open" class="px-6 py-4 bg-gray-100 border-b cursor-pointer hover:bg-gray-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $namaSkema }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Total: {{ count($soalDalamSkema) }} soal</p>
                        </div>
                        <svg class="w-6 h-6 text-gray-600 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <div x-show="open" x-transition class="overflow-x-auto">
                        <div class="p-4">
                            <table class="datatable min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="w-16 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pertanyaan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jawaban Benar</th>
                                        <th class="w-48 px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($soalDalamSkema as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-lg">
                                            <div class="tooltip">
                                                {{ Str::limit($item->pertanyaan, 80) }}
                                                <span class="tooltip-text">{{ $item->pertanyaan }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-green-700">{{ strtoupper($item->jawaban_benar) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end items-center space-x-2">
                                                <a href="{{ route('admin.soal.show', $item->kode_soal) }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">Detail</a>
                                                <a href="{{ route('admin.soal.edit', $item->kode_soal) }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium">Edit</a>
                                                <form action="{{ route('admin.soal.destroy', $item->kode_soal) }}" method="POST" onsubmit="return confirm('Yakin hapus soal ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-10 text-center text-gray-500">
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada soal ditemukan</h3>
                </div>
            @endforelse
        </div>

        {{-- Pagination global dari Laravel sudah tidak diperlukan lagi --}}
        
    </div>
</div>
@endsection

@push('scripts')
{{-- CDN untuk jQuery (dependency DataTables) --}}
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
{{-- CDN untuk DataTables.js --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
{{-- CDN untuk Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Inisialisasi semua tabel dengan class 'datatable'
    $(document).ready(function() {
        $('.datatable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Terjemahan Bahasa Indonesia
            },
            "pageLength": 5, // Tampilkan 5 data per halaman
            "lengthMenu": [5, 10, 25, 50], // Opsi jumlah data per halaman
            "searching": true, // Aktifkan pencarian di dalam tabel
            "info": true, // Tampilkan info halaman (contoh: Menampilkan 1 dari 5 dari 20 entri)
            "paging": true // Aktifkan paginasi
        });
    });
</script>
@endpush