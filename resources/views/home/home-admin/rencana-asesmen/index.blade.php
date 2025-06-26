@extends('home.home-admin.layouts.layout')

@section('title', 'Manajemen Rencana Asesmen - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    .progress {
        height: 0.5rem;
        overflow: hidden;
        background-color: #e5e7eb;
        border-radius: 0.25rem;
    }
    .progress-bar {
        height: 100%;
        background-color: #10b981;
        transition: width 0.6s ease;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    .badge-green {
        background-color: rgba(16, 185, 129, 0.1);
        color: rgba(6, 95, 70, 1);
    }
    .badge-yellow {
        background-color: rgba(245, 158, 11, 0.1);
        color: rgba(146, 64, 14, 1);
    }
    .badge-red {
        background-color: rgba(239, 68, 68, 0.1);
        color: rgba(153, 27, 27, 1);
    }
    .uk-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }
    .uk-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .uk-card.active {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    .tooltip {
        position: relative;
        display: inline-block;
    }
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 240px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -120px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
    .tab-content {
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .tab-content.active {
        display: block;
        opacity: 1;
    }
    .instruction-card {
        background-color: #f8fafc;
        border-left: 4px solid #3b82f6;
    }
    .uk-selector {
        position: relative;
    }
    .uk-selector:after {
        content: "↓";
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #6b7280;
    }
    .tab-button {
        position: relative;
        transition: all 0.3s ease;
    }
    .tab-button:after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 0;
        height: 2px;
        background-color: #3b82f6;
        transition: width 0.3s ease;
    }
    .tab-button.active:after, .tab-button:hover:after {
        width: 100%;
    }
    .uk-section {
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1.5rem;
    }
    .uk-section:last-child {
        border-bottom: none;
    }
    .uk-section-header {
        background-color: #f3f4f6;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        border-radius: 0.375rem;
        font-weight: 600;
        color: #4b5563;
    }
    .status-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .status-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .status-item:last-child {
        border-bottom: none;
    }
    .status-icon {
        flex-shrink: 0;
        width: 1.5rem;
        height: 1.5rem;
        margin-right: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9999px;
    }
    .status-icon.success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #047857;
    }
    .status-icon.pending {
        background-color: rgba(239, 68, 68, 0.1);
        color: #b91c1c;
    }
    .status-text {
        flex-grow: 1;
    }
    .status-action {
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if (session('success'))
        <div class="mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session('warning'))
        <div class="mb-8 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('warning') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-yellow-500 hover:bg-yellow-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Ada beberapa kesalahan:</h3>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session('info'))
        <div class="mb-8 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('info') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" class="inline-flex rounded-md p-1.5 text-blue-500 hover:bg-blue-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Rencana Asesmen: {{ $skema->nama_skema }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1H7a2 2 0 00-2 2v10a2 2 0 002 2h6a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1zm-1 5a1 1 0 112 0v1a1 1 0 11-2 0V7z" clip-rule="evenodd" />
                            </svg>
                            Kode Skema: {{ $skema->nomor_skema }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex md:mt-0">
                    <a href="{{ route('admin.skema.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Kembali ke Daftar Skema
                    </a>
                </div>
            </div>
        </div>

        <!-- Instruction Card -->
        <div class="instruction-card p-4 rounded-lg shadow-md mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-1">
                <svg class="h-6 w-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1zm0-3a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-gray-900">Panduan Pengisian Rencana Asesmen</h3>
                    <div class="mt-2 text-sm text-gray-600">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Rencana Asesmen merupakan rencana pengumpulan bukti untuk setiap elemen Unit Kompetensi</li>
                            <li>Pilih Unit Kompetensi terlebih dahulu dari kartu di bawah atau gunakan dropdown filter</li>
                            <li><span class="font-semibold text-blue-700">WAJIB:</span> Tekan tombol <strong>"Generate dari Elemen UK"</strong> untuk membuat Rencana Asesmen otomatis dari elemen unit kompetensi</li>
                            <li>Progress dihitung berdasarkan jumlah elemen Unit Kompetensi yang sudah memiliki Rencana Asesmen</li>
                            <li>Jenis Bukti: <strong>L</strong> (Langsung), <strong>TL</strong> (Tidak Langsung), <strong>T</strong> (Tambahan)</li>
                            <li>Metode Asesmen: <strong>CL</strong> (Daftar Periksa), <strong>DIT</strong> (Daftar Instruksi Terstruktur), dll.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Section - Enhanced with animation and better visualization -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="h-5 w-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z" />
                </svg>
                Status Rencana Asesmen
            </h3>
            
            @if($unitKompetensi->isEmpty())
                <div class="text-center py-6 text-gray-500">
                    <p>Tidak ada Unit Kompetensi yang terkait dengan skema ini.</p>
                </div>
            @else
                <ul class="status-list bg-white rounded-md divide-y divide-gray-200">
                    @foreach($unitKompetensi as $uk)
                        @php
                            $hasData = $progressData[$uk->id_uk]['total_rencana'] > 0;
                            $isComplete = $progressData[$uk->id_uk]['percentage'] == 100;
                            $statusBg = $hasData ? 'bg-green-50' : 'bg-red-50';
                            $statusTextColor = $hasData ? 'text-green-700' : 'text-red-700';
                            $isActive = $selectedUK == $uk->id_uk;
                        @endphp
                        <li class="status-item {{ $isActive ? 'bg-blue-50' : '' }}">
                            <div class="flex items-center space-x-3 flex-grow">
                                <div class="flex-shrink-0">
                                    @if($hasData)
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <div class="font-medium text-gray-900">{{ $uk->kode_uk }}</div>
                                    <div class="text-sm text-gray-500 truncate" title="{{ $uk->nama_uk }}">{{ $uk->nama_uk }}</div>
                                    <div class="mt-1 {{ $statusBg }} {{ $statusTextColor }} text-sm py-1 px-3 rounded-md inline-block">
                                        @if($hasData)
                                            <span class="font-medium">Sudah ada data rencana asesmen</span>
                                            <span class="text-xs text-gray-500 ml-1">({{ $progressData[$uk->id_uk]['total_rencana'] }}/{{ $progressData[$uk->id_uk]['total_elemen'] }} elemen)</span>
                                        @else
                                            <span class="font-medium">Belum ada data rencana asesmen</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end justify-center ml-2">
                                <a href="{{ route('admin.skema.rencana-asesmen.index', ['id_skema' => $skema->id_skema, 'id_uk' => $uk->id_uk]) }}" 
                                class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-md text-sm transition-colors">
                                    {{ $isActive ? 'Aktif' : 'Pilih' }}
                                </a>
                                <div class="text-xs text-gray-500 mt-1">
                                    Klik untuk {{ $isActive ? 'sedang aktif' : 'mengelola rencana asesmen' }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <!-- Tabs for Main Content -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div id="tab-content-form" class="tab-content active">
                <!-- UK Filter -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <h3 class="text-base font-semibold text-gray-800 mb-4 md:mb-0">Unit Kompetensi Terpilih:</h3>
                        
                        <div class="uk-selector relative w-full md:w-auto">
                            <select id="uk_filter" class="appearance-none w-full md:w-96 pl-3 pr-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-white">
                                @foreach($unitKompetensi as $uk)
                                    <option value="{{ $uk->id_uk }}" {{ $selectedUK == $uk->id_uk ? 'selected' : '' }}>
                                        {{ $uk->kode_uk }} - {{ Str::limit($uk->nama_uk, 70) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    @if($selectedUK)
                        @php
                            $selectedUkData = $unitKompetensi->firstWhere('id_uk', $selectedUK);
                            $rencanaLength = $progressData[$selectedUK]['total_rencana'];
                            $elemenLength = $progressData[$selectedUK]['total_elemen'];
                            $isGenerateDisabled = $rencanaLength > 0;
                        @endphp
                        @if($selectedUkData)
                            <div class="mt-3 p-3 bg-blue-50 rounded-md text-sm">
                                <p class="font-medium text-blue-800">{{ $selectedUkData->nama_uk }}</p>
                                <div class="mt-2 flex items-center text-gray-600">
                                    <span class="mr-4">
                                        <strong>Total Elemen Unit Kompetensi:</strong> {{ $elemenLength }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                
                <!-- Form to add rencana asesmen -->
                <div class="px-6 py-4 border-b border-gray-200 bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-base font-medium text-gray-800">Tambah Rencana Asesmen Baru</h4>
                        
                        <form action="{{ route('admin.skema.rencana-asesmen.generate', ['id_skema' => $skema->id_skema, 'id_uk' => $selectedUK]) }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white 
                                {{ $isGenerateDisabled ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500' }}"
                                {{ $isGenerateDisabled ? 'disabled' : '' }}
                                title="{{ $isGenerateDisabled ? 'Rencana Asesmen sudah digenerate sebelumnya' : 'Generate Rencana Asesmen dari Elemen UK' }}">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 4a1 1 0 011-1h8a1 1 0 011 1v1h1a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1h1V4zm2 1h6v1H7V5zm5.146 7.146a.5.5 0 00.708.708l2-2a.5.5 0 000-.708l-2-2a.5.5 0 00-.708.708L13.292 10l-1.146 1.146a.5.5 0 00.708.708z" clip-rule="evenodd" />
                                </svg>
                                Generate dari Elemen UK
                            </button>
                        </form>
                    </div>
                    
                    <form id="add_rencana_form" action="{{ route('admin.skema.rencana-asesmen.store', $skema->id_skema) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        @csrf
                        <input type="hidden" name="id_uk" id="form_id_uk" value="{{ $selectedUK }}">
                        
                        <div class="lg:col-span-2">
                            <label for="elemen" class="block text-sm font-medium text-gray-700 mb-1">Elemen</label>
                            <input type="text" name="elemen" id="elemen" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        
                        <div class="lg:col-span-1">
                            <label for="bukti_bukti" class="block text-sm font-medium text-gray-700 mb-1">Bukti-bukti</label>
                            <input type="text" name="bukti_bukti" id="bukti_bukti" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        </div>
                        
                        <div>
                            <label for="jenis_bukti" class="block text-sm font-medium text-gray-700 mb-1">Jenis Bukti</label>
                            <select name="jenis_bukti" id="jenis_bukti" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Pilih Jenis</option>
                                <option value="L">L (Langsung)</option>
                                <option value="TL">TL (Tidak Langsung)</option>
                                <option value="T">T (Tambahan)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="metode_dan_perangkat_asesmen" class="block text-sm font-medium text-gray-700 mb-1">Metode & Perangkat</label>
                            <select name="metode_dan_perangkat_asesmen" id="metode_dan_perangkat_asesmen" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Pilih Metode</option>
                                <option value="CL">CL (Daftar Periksa)</option>
                                <option value="DIT">DIT (Daftar Instruksi Terstruktur)</option>
                                <option value="DPL">DPL (Daftar Pertanyaan Lisan)</option>
                                <option value="DPT">DPT (Daftar Pertanyaan Tertulis)</option>
                                <option value="VP">VP (Verifikasi Portofolio)</option>
                                <option value="CUP">CUP (Ceklis Ulasan Produk)</option>
                            </select>
                        </div>

                        <div class="lg:col-span-5">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Rencana Asesmen
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Table of rencana asesmen for selected UK -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Elemen</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti-bukti</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Bukti</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode & Perangkat</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rencana_table_body" class="bg-white divide-y divide-gray-200">
                            @forelse($rencanaAsesmen as $index => $rencana)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rencana->elemen }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rencana->bukti_bukti }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($rencana->jenis_bukti == 'L')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Langsung
                                            </span>
                                        @elseif($rencana->jenis_bukti == 'TL')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Tidak Langsung
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Tambahan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @php
                                            $metodeMap = [
                                                'CL' => 'Daftar Periksa',
                                                'DIT' => 'Daftar Instruksi Terstruktur',
                                                'DPL' => 'Daftar Pertanyaan Lisan',
                                                'DPT' => 'Daftar Pertanyaan Tertulis',
                                                'VP' => 'Verifikasi Portofolio',
                                                'CUP' => 'Ceklis Ulasan Produk'
                                            ];
                                            $metodeLabel = $metodeMap[$rencana->metode_dan_perangkat_asesmen] ?? $rencana->metode_dan_perangkat_asesmen;
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $rencana->metode_dan_perangkat_asesmen }} ({{ $metodeLabel }})
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="button" 
                                                onclick="openDeleteModal('{{ route('admin.skema.rencana-asesmen.destroy', ['id_skema' => $skema->id_skema, 'id_rencana_asesmen' => $rencana->id_rencana_asesmen]) }}')"
                                                class="text-red-600 hover:text-red-900">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        Belum ada data rencana asesmen untuk unit kompetensi ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all">
                    <div class="p-6">
                        <div class="flex items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Rencana Asesmen</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin menghapus rencana asesmen ini? Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <form id="deleteForm" method="POST" action="" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Hapus
                                </button>
                            </form>
                            <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8" style="margin-top: 50px;">
            <div id="tab-content-preview" class="tab-content" >
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800">Preview Seluruh Rencana Asesmen Skema</h3>
                    <p class="mt-1 text-sm text-gray-500">Menampilkan semua rencana asesmen dari seluruh unit kompetensi dalam skema ini.</p>
                </div>
                
                <div class="p-6">
                    @php
                        // Group by unit kompetensi
                        $groupedRencanaAsesmen = [];
                        foreach($allRencanaAsesmen as $rencana) {
                            if (!isset($groupedRencanaAsesmen[$rencana->id_uk])) {
                                $groupedRencanaAsesmen[$rencana->id_uk] = [
                                    'uk' => $rencana->unitKompetensi,
                                    'rencana' => []
                                ];
                            }
                            $groupedRencanaAsesmen[$rencana->id_uk]['rencana'][] = $rencana;
                        }
                    @endphp
                    
                    @if(count($groupedRencanaAsesmen) > 0)
                        @foreach($groupedRencanaAsesmen as $ukId => $group)
                            <div class="uk-section">
                                <div class="uk-section-header flex items-center">
                                    <span class="text-gray-800">{{ $group['uk']->kode_uk }} - {{ $group['uk']->nama_uk }}</span>
                                    <span class="ml-auto badge {{ count($group['rencana']) == $progressData[$ukId]['total_elemen'] ? 'badge-green' : 'badge-yellow' }}">
                                        {{ count($group['rencana']) }}/{{ $progressData[$ukId]['total_elemen'] }}
                                    </span>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Elemen</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti-bukti</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Bukti</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode & Perangkat</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($group['rencana'] as $index => $rencana)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rencana->elemen }}</td>
                                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rencana->bukti_bukti }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        @if($rencana->jenis_bukti == 'L')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Langsung
                                                            </span>
                                                        @elseif($rencana->jenis_bukti == 'TL')
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                Tidak Langsung
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                Tambahan
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        @php
                                                            $metodeMap = [
                                                                'CL' => 'Daftar Periksa',
                                                                'DIT' => 'Daftar Instruksi Terstruktur',
                                                                'DPL' => 'Daftar Pertanyaan Lisan',
                                                                'DPT' => 'Daftar Pertanyaan Tertulis',
                                                                'VP' => 'Verifikasi Portofolio',
                                                                'CUP' => 'Ceklis Ulasan Produk'
                                                            ];
                                                            $metodeLabel = $metodeMap[$rencana->metode_dan_perangkat_asesmen] ?? $rencana->metode_dan_perangkat_asesmen;
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            {{ $rencana->metode_dan_perangkat_asesmen }} ({{ $metodeLabel }})
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-10 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada rencana asesmen</h3>
                            <p class="mt-1 text-sm text-gray-500">Silakan generate rencana asesmen dari elemen Unit Kompetensi terlebih dahulu.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handling UK filter change
        const ukFilter = document.getElementById('uk_filter');
        const formIdUk = document.getElementById('form_id_uk');
        
        ukFilter.addEventListener('change', function() {
            const selectedUkId = this.value;
            formIdUk.value = selectedUkId;
            
            // Redirect to the same page with id_uk parameter
            window.location.href = "{{ route('admin.skema.rencana-asesmen.index', $skema->id_skema) }}?id_uk=" + selectedUkId;
        });
        
        // Set initial value for form
        formIdUk.value = ukFilter.value;
        
        // Tab switching
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabId = this.id.replace('tab-button-', 'tab-content-');
                
                // Hide all tabs and remove active class
                tabContents.forEach(content => {
                    content.classList.remove('active');
                    content.style.opacity = '0';
                });
                tabButtons.forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Show selected tab and add active class
                const selectedTab = document.getElementById(tabId);
                selectedTab.classList.add('active');
                
                // Slight delay for opacity transition
                setTimeout(() => {
                    selectedTab.style.opacity = '1';
                }, 50);
                
                this.classList.add('active');
            });
        });
        
        // Pre-fill form from selected element (if any)
        const elemenUkSelect = document.getElementById('elemen_uk_select');
        const elemenInput = document.getElementById('elemen');
        const buktiInput = document.getElementById('bukti_bukti');
        
        if (elemenUkSelect) {
            elemenUkSelect.addEventListener('change', function() {
                if (this.value) {
                    elemenInput.value = this.options[this.selectedIndex].text;
                    buktiInput.value = "Hasil Observasi " + this.options[this.selectedIndex].text;
                    document.getElementById('jenis_bukti').value = 'L';
                    document.getElementById('metode_dan_perangkat_asesmen').value = 'CL';
                }
            });
        }
    });

    // Modal functions
    function openDeleteModal(deleteUrl) {
        document.getElementById('deleteForm').action = deleteUrl;
        document.getElementById('deleteModal').classList.remove('hidden');
        // Add animation
        setTimeout(() => {
            document.getElementById('deleteModal').querySelector('.transform').classList.add('scale-100');
            document.getElementById('deleteModal').querySelector('.transform').classList.remove('scale-95', 'opacity-0');
        }, 50);
    }

    function closeDeleteModal() {
        // Add animation
        document.getElementById('deleteModal').querySelector('.transform').classList.add('scale-95', 'opacity-0');
        document.getElementById('deleteModal').querySelector('.transform').classList.remove('scale-100');
        
        // Hide modal after animation completes
        setTimeout(() => {
            document.getElementById('deleteModal').classList.add('hidden');
        }, 300);
    }
</script>
@endsection