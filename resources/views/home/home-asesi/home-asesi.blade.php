@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Dashboard Asesi - Lembaga Sertifikasi Profesi UGM')

<style>
    /* Style refinements */
    .profile-section-header,
    .section-header,
    .status-section-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2); /* Soft border for headers */
    }
    .profile-section-header h2,
    .section-header h2,
    .status-section-header h2 {
        color: white !important;
    }

    .profile-section-header { background-color: #3B82F6 !important; } /* Blue-500 */
    .section-header { background-color: #6366F1 !important; } /* Indigo-500 */
    .status-section-header { background-color: #22C55E !important; } /* Green-500 */

    .stat-card, .document-card, .info-item {
        transition: all 0.3s ease;
    }
    .stat-card:hover, .document-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1), 0 4px 8px -3px rgba(0, 0, 0, 0.06);
    }
    .info-item:hover {
        background-color: #f9fafb; /* Lighter gray on hover */
    }

    .profile-img {
        height: 90px; /* Slightly smaller */
        width: 90px;
        border: 3px solid white;
        box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .progress-ring-container {
        position: relative;
        width: 100px; /* Larger ring */
        height: 100px;
    }
    .progress-ring-circle {
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
        stroke-dasharray: 283; /* Circumference for r=45 */
        transition: stroke-dashoffset 0.6s ease;
    }
    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 600; /* Semibold */
        font-size: 1.25rem; /* Larger text */
    }
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: .5; }
    }

    /* Ensure consistent card styling */
    .card {
        background-color: white;
        border-radius: 0.75rem; /* Slightly larger radius (12px) */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden; /* Ensure header radius applies correctly */
        margin-bottom: 1.5rem; /* Consistent bottom margin */
    }
    .card-header {
        padding: 1rem 1.5rem; /* Consistent header padding */
    }
    .card-content {
        padding: 1.5rem; /* Consistent content padding */
    }

</style>

@section('content')
<div class="min-h-screen bg-gray-100 py-10"> <!-- Lighter background -->

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"> <!-- Increased vertical padding -->
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-lg p-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-2xl font-bold mb-1">Selamat Datang, {{ $asesi->nama_asesi }}!</h1>
                <p class="text-blue-100">Dashboard Asesi Lembaga Sertifikasi Profesi UGM</p>
            </div>
            <div class="mt-4 md:mt-0 bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                <p class="text-sm text-white/90">Terakhir login: {{ now()->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Stat Card 1: Status -->
            <div class="stat-card card !mb-0 border-t-4 border-blue-500"> <!-- Use card class, remove mb-8 -->
                <div class="card-content flex items-center">
                    <div class="rounded-full bg-blue-100 p-3 mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Status</p>
                        <h3 class="text-xl font-semibold text-gray-800">Aktif</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card 2: Program -->
            <div class="stat-card card !mb-0 border-t-4 border-purple-500">
                <div class="card-content flex items-center">
                    <div class="rounded-full bg-purple-100 p-3 mr-4 flex-shrink-0">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Program</p>
                        <h3 class="text-xl font-semibold text-gray-800">Sertifikasi Profesi</h3>
                    </div>
                </div>
            </div>

            <!-- Stat Card 3: Nomor Asesi -->
            <div class="stat-card card !mb-0 border-t-4 border-green-500">
                <div class="card-content flex items-center">
                    <div class="rounded-full bg-green-100 p-3 mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h4a2 2 0 012 2v1m-4 0h4m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Nomor Asesi</p>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $asesi->id_asesi }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6"> <!-- Reduced gap -->
            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="card profile-section"> <!-- Use card class -->
                    <div class="card-header profile-section-header">
                        <h2 class="text-xl font-semibold text-white">Profil Asesi</h2> <!-- Semibold -->
                    </div>

                    <div class="card-content">
                        <div class="flex items-center mb-6">
                            <div class="profile-img rounded-full bg-gray-200 overflow-hidden flex items-center justify-center flex-shrink-0">
                                {{-- Placeholder Icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{-- If image exists: <img src="{{ asset('path/to/image.jpg') }}" alt="Foto Profil" class="h-full w-full object-cover"> --}}
                            </div>
                            <div class="ml-5">
                                <h3 class="text-xl font-bold text-gray-800">{{ $asesi->nama_asesi }}</h3>
                                <p class="text-gray-600">{{ $asesi->email }}</p>
                                <a href="#" class="text-sm text-blue-600 hover:underline mt-1 inline-block">Edit Profil</a>
                            </div>
                        </div>

                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Detail Informasi</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                             <div class="info-item flex justify-between py-2 px-3 rounded-md">
                                <span class="text-gray-500">NIM/Identitas</span>
                                <span class="font-medium text-gray-800 text-right">{{ $asesi->nim }}</span>
                            </div>
                             <div class="info-item flex justify-between py-2 px-3 rounded-md">
                                <span class="text-gray-500">Jenis Kelamin</span>
                                <span class="font-medium text-gray-800 text-right">{{ $asesi->jenis_kelamin ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between py-2 px-3 rounded-md">
                                <span class="text-gray-500">Telepon</span>
                                <span class="font-medium text-gray-800 text-right">{{ $asesi->no_telp ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between py-2 px-3 rounded-md">
                                <span class="text-gray-500">Alamat</span>
                                <span class="font-medium text-gray-800 text-right">{{ $asesi->alamat_rumah ?: '-' }}</span>
                            </div>
                            <div class="info-item flex justify-between py-2 px-3 rounded-md sm:col-span-2">
                               <span class="text-gray-500">Tempat dan Tanggal Lahir</span>
                               <span class="font-medium text-gray-800 text-right">{{ $asesi->tempat_tanggal_lahir ?: '-' }}</span>
                           </div>

                        </div>
                    </div>
                </div>

                <!-- Skema Information -->
                <div class="card"> <!-- Use card class -->
                    <div class="card-header section-header">
                        <h2 class="text-xl font-semibold text-white">Skema Sertifikasi</h2> <!-- Semibold -->
                    </div>

                    <div class="card-content">
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2.5 uppercase rounded-full text-indigo-600 bg-indigo-200">
                                    {{ $asesi->skema->nomor_skema }}
                                </span>
                                <h3 class="text-lg font-semibold text-gray-800 mt-2">{{ $asesi->skema->nama_skema }}</h3>
                                <p class="text-sm text-gray-600">{{ $asesi->skema->jenis_skema }}</p>
                            </div>

                            @if($asesi->skema->dokumen_skkni)
                            <a href="{{ asset('storage/' . $asesi->skema->dokumen_skkni) }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 transition font-medium flex-shrink-0 mt-2 sm:mt-0">
                                <svg class="mr-1.5 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                Dokumen Skema
                            </a>
                            @endif
                        </div>

                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Unit Kompetensi</h4>
                        <div class="space-y-3">
                            @forelse($asesi->skema->getUnitKompetensi() as $index => $uk)
                            <div class="border border-gray-200 rounded-lg p-4 transition hover:bg-gray-50 hover:shadow-sm">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-indigo-100 rounded-md h-8 w-8 flex items-center justify-center text-indigo-700 font-semibold text-xs">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <p class="text-sm font-medium text-gray-900">{{ $uk->nama_uk }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $uk->kode_unit }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-500 italic">Belum ada unit kompetensi untuk skema ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="lg:col-span-1">
                <!-- Progress Card -->
                <div class="card"> <!-- Use card class -->
                    <div class="card-header status-section-header">
                        <h2 class="text-xl font-semibold text-white">Status Sertifikasi</h2> <!-- Semibold -->
                    </div>

                    <div class="card-content">
                        <div class="flex flex-col items-center justify-center mb-8">
                            <div class="progress-ring-container mb-4">
                                <svg class="w-full h-full" viewBox="0 0 100 100">
                                    <circle class="text-gray-200" stroke-width="10" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" />
                                    <circle class="progress-ring-circle {{ $progressPercentage >= 100 ? 'text-green-500' : 'text-blue-500' }}" stroke-width="10" stroke-linecap="round" stroke="currentColor" fill="transparent" r="45" cx="50" cy="50" style="stroke-dashoffset: {{ 283 * (1 - $progressPercentage / 100) }}" />
                                </svg>
                                <div class="progress-text {{ $progressPercentage >= 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $progressPercentage }}%</div>
                            </div>
                            <p class="text-center text-gray-600 font-medium text-lg">
                                {{ $progressPercentage >= 100 ? 'Asesmen Selesai' : 'Proses Asesmen' }}
                            </p>
                            @if($progressPercentage < 100)
                            <p class="text-center text-gray-500 text-sm mt-1">Sedang berlangsung</p>
                            @endif
                        </div>

                        @if($certificateStatus == 'issued')
                        {{-- Certificate Download Section - Sertifikat sudah diupload --}}
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center mb-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-green-800">Selamat!</p>
                                    <p class="text-xs text-green-600">Sertifikat Anda sudah tersedia</p>
                                </div>
                            </div>
                            <a href="{{ route('asesi.certificate.download') }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Sertifikat
                            </a>
                        </div>
                        @elseif($certificateStatus == 'waiting')
                        {{-- Certificate Waiting Section - Menunggu admin upload --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-yellow-800">Asesmen Selesai!</p>
                                    <p class="text-xs text-yellow-600">Sertifikat belum siap. Silakan tunggu admin memproses sertifikat Anda.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Hasil Asesmen Section --}}
                        @if($asesi->rincianAsesmen && $asesi->rincianAsesmen->hasilAsesmen->isNotEmpty())
                        @php
                            $hasilAsesmen = $asesi->rincianAsesmen->hasilAsesmen->first();
                        @endphp
                        <div class="mb-6 p-4 rounded-lg border-2
                            @if($hasilAsesmen->status === 'kompeten')
                                bg-green-50 border-green-300
                            @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                bg-red-50 border-red-300
                            @else
                                bg-gray-50 border-gray-300
                            @endif
                        ">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 rounded-full 
                                    @if($hasilAsesmen->status === 'kompeten')
                                        bg-green-100
                                    @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                        bg-red-100
                                    @else
                                        bg-gray-100
                                    @endif
                                    flex items-center justify-center">
                                    @if($hasilAsesmen->status === 'kompeten')
                                        <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                        <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold 
                                        @if($hasilAsesmen->status === 'kompeten')
                                            text-green-800
                                        @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                            text-red-800
                                        @else
                                            text-gray-800
                                        @endif
                                    ">Hasil Asesmen</p>
                                    <p class="text-xs 
                                        @if($hasilAsesmen->status === 'kompeten')
                                            text-green-600
                                        @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                            text-red-600
                                        @else
                                            text-gray-600
                                        @endif
                                    ">
                                        @if($hasilAsesmen->status === 'kompeten')
                                            Kompeten
                                        @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                            Tidak Kompeten
                                        @else
                                            Belum Ada Hasil
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Tahapan Proses</h4>
                        <div class="space-y-4">
                            {{-- Status Item: Completed --}}
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-700">Pendaftaran Selesai</p>
                                    <p class="text-xs text-gray-500">Data awal diterima</p>
                                </div>
                            </div>

                            {{-- Status Item: Completed --}}
                             <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-700">Verifikasi Dokumen</p>
                                     <p class="text-xs text-gray-500">Dokumen valid</p>
                                </div>
                            </div>

                            {{-- Status Item: Completed --}}
                             <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                     <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-700">Jadwal Asesmen</p>
                                     <p class="text-xs text-gray-500">Jadwal ditentukan</p>
                                </div>
                            </div>

                            {{-- Status Item: Proses Asesmen - Completed or In Progress based on progress --}}
                            <div class="flex items-center">
                                @if($progressPercentage >= 100)
                                {{-- Completed --}}
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-green-700">Proses Asesmen</p>
                                    <p class="text-xs text-green-600">Selesai</p>
                                </div>
                                @else
                                {{-- In Progress --}}
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center pulse-animation">
                                    <svg class="h-5 w-5 text-yellow-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                      </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-yellow-700">Proses Asesmen</p>
                                    <p class="text-xs text-gray-500">Sedang berlangsung</p>
                                </div>
                                @endif
                            </div>

                            {{-- Status Item: Sertifikat - based on certificateStatus --}}
                            <div class="flex items-center {{ $certificateStatus == 'not_eligible' ? 'opacity-60' : '' }}">
                                @if($certificateStatus == 'issued')
                                {{-- Sertifikat Diterbitkan --}}
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-700">Sertifikat Diterbitkan</p>
                                    <a href="{{ route('asesi.certificate.download') }}" class="text-xs text-green-600 hover:underline">Download Sertifikat</a>
                                </div>
                                @elseif($certificateStatus == 'waiting')
                                {{-- Menunggu Sertifikat --}}
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-yellow-700">Menunggu Sertifikat</p>
                                    <p class="text-xs text-yellow-600">Sertifikat sedang diproses admin</p>
                                </div>
                                @else
                                {{-- Not Eligible --}}
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 border border-gray-300 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Sertifikat</p>
                                    <p class="text-xs text-gray-400">Menunggu hasil asesmen</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions/Links (Optional) -->
                 <div class="card">
                    <div class="card-header bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-700">Aksi Cepat</h2>
                    </div>
                    <div class="card-content">
                        <ul class="space-y-2">
                            <li><a href="{{ route("asesi.index") }}" class="block text-sm text-blue-600 hover:underline font-medium">Upload Dokumen Pendukung</a></li>
                            <li><a href="{{ route("asesi.index") }}" class="block text-sm text-blue-600 hover:underline font-medium">Lihat Jadwal Uji Kompetensi</a></li>
                            <li><a href="tel:081234567" class="block text-sm text-blue-600 hover:underline font-medium">Hubungi Sekretariat LSP</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
