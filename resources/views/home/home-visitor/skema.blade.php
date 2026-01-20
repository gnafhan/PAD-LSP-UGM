@extends('home.layouts.layout')

@section('title', 'Skema Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24 pb-12">
    <!-- Hero Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="font-bricolage text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 tracking-tight mb-4">
                    Skema Sertifikasi
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Temukan skema sertifikasi yang sesuai dengan kompetensi dan keahlian Anda
                </p>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-2xl mx-auto">
            <form method="GET" action="{{ route('skema') }}" class="relative">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        name="search"
                        value="{{ $searchQuery }}"
                        placeholder="Cari skema sertifikasi..." 
                        class="block w-full pl-12 pr-4 py-4 text-base text-gray-900 bg-white border border-gray-300 rounded-2xl shadow-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all duration-200"
                        aria-label="Cari skema sertifikasi"
                    />
                    <button 
                        type="submit"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-sky-600 hover:text-sky-700 transition-colors duration-200"
                        aria-label="Kirim pencarian"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container mx-auto px-2 sm:px-4 lg:px-8">
        @if($searchQuery)
            <div class="mb-6 text-center">
                <p class="text-gray-600">
                    Hasil pencarian untuk: <span class="font-semibold text-gray-900">"{{ $searchQuery }}"</span>
                    <a href="{{ route('skema') }}" class="ml-2 text-sky-600 hover:text-sky-700 underline">Hapus filter</a>
                </p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-2xl shadow-medium border border-gray-200 text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900 rounded-tl-2xl">No.</th>
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900">Nomor / Judul Skema</th>
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900">Harga Sertifikasi</th>
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900 rounded-tr-2xl">Dokumen Skema</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($skemaData as $index => $skema)
                    <tr class="hover:bg-sky-50 transition-colors duration-150">
                        <td class="px-6 py-4 align-top text-gray-700 font-inter text-base">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 align-top">
                            <div class="font-bricolage text-xl font-semibold text-gray-900 mb-1">{{ $skema->nama_skema }}</div>
                            <div class="text-sm text-gray-500 mb-2">{{ $skema->nomor_skema }}</div>
                        </td>
                        <td class="px-6 py-4 align-top">
                            @if($skema->harga)
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-xl">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bricolage text-lg font-semibold text-green-700">Rp {{ number_format($skema->harga, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-500 rounded-xl text-sm font-inter">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Hubungi Admin
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 align-top">
                            @php
                                $dokumen = $skema->dokumen_skkni;
                                $isUrl = $dokumen && (str_starts_with($dokumen, 'http://') || str_starts_with($dokumen, 'https://'));
                                $isFile = $dokumen && !$isUrl;
                                $link = $isUrl ? $dokumen : ($isFile ? asset('storage/' . ltrim($dokumen, '/')) : null);
                            @endphp
                            @if($link)
                                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-10 h-10 bg-sky-600 text-white rounded-xl hover:bg-sky-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2" title="Unduh Dokumen Skema">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 bg-gray-300 text-gray-500 rounded-xl cursor-not-allowed" title="Dokumen tidak tersedia">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center text-gray-500 font-inter text-lg">
                            @if($searchQuery)
                                Tidak ada skema yang ditemukan. Coba ubah kata kunci pencarian Anda.
                            @else
                                Belum ada skema tersedia. Skema sertifikasi akan ditampilkan di sini.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Results Count -->
        @if($skemaData->count() > 0)
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Menampilkan {{ $skemaData->count() }} skema sertifikasi
            </p>
        </div>
        @endif
    </div>
</div>

<script>
// Add focus styles for accessibility
document.addEventListener('DOMContentLoaded', function() {
    const focusableElements = document.querySelectorAll('button, a, input, select, textarea');
    focusableElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-sky-500', 'ring-offset-2');
        });
        element.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-sky-500', 'ring-offset-2');
        });
    });
});
</script>
@endsection
