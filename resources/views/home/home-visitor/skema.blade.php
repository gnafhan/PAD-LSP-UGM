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
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900">Unit Kompetensi</th>
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900">Persyaratan</th>
                        <th class="px-6 py-4 font-bricolage text-lg font-semibold text-gray-900 rounded-tr-2xl">Dokumen</th>
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
                            <button 
                                onclick="toggleTableSection('unit{{ $index }}')"
                                class="inline-flex items-center gap-2 px-3 py-2 bg-sky-100 text-sky-700 font-inter font-semibold text-sm rounded-xl shadow-sm hover:bg-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
                                aria-expanded="false"
                                aria-controls="unit{{ $index }}"
                            >
                                <span class="toggle-text">Tampilkan</span>
                                <svg class="h-4 w-4 toggle-icon transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="unit{{ $index }}" class="hidden mt-3">
                                <ul class="space-y-2">
                                    @foreach ($skema->getUnitKompetensi() as $ukIndex => $unit)
                                    <li class="flex items-start gap-2">
                                        <span class="flex-shrink-0 w-6 h-6 bg-sky-100 text-sky-600 rounded-full flex items-center justify-center text-xs font-semibold">{{ $ukIndex + 1 }}</span>
                                        <span class="text-gray-900 font-inter text-base">{{ $unit->nama_uk }}</span>
                                        <span class="ml-2 text-xs text-gray-500">{{ $unit->kode_uk }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                        <td class="px-6 py-4 align-top">
                            <button 
                                onclick="toggleTableSection('requirement{{ $index }}')"
                                class="inline-flex items-center gap-2 px-3 py-2 bg-orange-100 text-orange-700 font-inter font-semibold text-sm rounded-xl shadow-sm hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                                aria-expanded="false"
                                aria-controls="requirement{{ $index }}"
                            >
                                <span class="toggle-text">Tampilkan</span>
                                <svg class="h-4 w-4 toggle-icon transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="requirement{{ $index }}" class="hidden mt-3">
                                <ul class="space-y-2">
                                    @foreach ($skema->parsed_persyaratan as $reqIndex => $persyaratan)
                                    <li class="flex items-start gap-2">
                                        <span class="flex-shrink-0 w-6 h-6 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xs font-semibold">{{ $reqIndex + 1 }}</span>
                                        <span class="text-gray-900 font-inter text-base">{{ $persyaratan }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                        <td class="px-6 py-4 align-top">
                            @php
                                $dokumen = $skema->dokumen_skkni;
                                $isUrl = $dokumen && (str_starts_with($dokumen, 'http://') || str_starts_with($dokumen, 'https://'));
                                $isFile = $dokumen && !$isUrl;
                                $link = $isUrl ? $dokumen : ($isFile ? asset('storage/' . ltrim($dokumen, '/')) : null);
                            @endphp
                            @if($link)
                                <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-xl hover:bg-sky-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    SKKNI
                                </a>
                            @else
                                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-500 text-sm font-semibold rounded-xl cursor-not-allowed" title="Dokumen tidak tersedia">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Tidak tersedia
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500 font-inter text-lg">
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
function toggleTableSection(id) {
    const content = document.getElementById(id);
    const button = content.previousElementSibling;
    const toggleText = button.querySelector('.toggle-text');
    const toggleIcon = button.querySelector('.toggle-icon');
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    if (isExpanded) {
        content.classList.add('hidden');
        toggleText.textContent = 'Tampilkan';
        toggleIcon.classList.remove('rotate-180');
        button.setAttribute('aria-expanded', 'false');
    } else {
        content.classList.remove('hidden');
        toggleText.textContent = 'Sembunyikan';
        toggleIcon.classList.add('rotate-180');
        button.setAttribute('aria-expanded', 'true');
    }
}

// Add focus styles for accessibility
// Add smooth scroll behavior for better UX
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
