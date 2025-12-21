@extends('home.home-admin.layouts.layout')

@section('title', 'Detail Asesi - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    .info-card {
        transition: all 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    .progress-bar {
        transition: width 0.5s ease-in-out;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if (session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('home-admin') }}" class="text-gray-500 hover:text-blue-600">Dashboard</a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <a href="{{ route('admin.pengguna.index') }}" class="ml-1 text-gray-500 hover:text-blue-600">Pengguna</a>
                                </div>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-gray-700 font-medium">{{ $asesi->nama_asesi }}</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Detail Asesi
                    </h2>
                </div>
                <div class="mt-5 flex space-x-3 md:mt-0">
                    <a href="{{ route('admin.asesi.edit', $asesi->id_asesi) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Data
                    </a>
                    <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Status & Progress Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="flex-shrink-0 h-16 w-16 flex items-center justify-center rounded-full bg-orange-100 text-orange-800 font-bold text-2xl">
                        {{ strtoupper(substr($asesi->nama_asesi ?? 'A', 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $asesi->nama_asesi }}</h3>
                        <p class="text-sm text-gray-500">ID: {{ $asesi->id_asesi }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-end">
                    @if($statusKompetensi == 'Kompeten')
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Kompeten
                        </span>
                    @elseif($statusKompetensi == 'Masih Proses')
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            Masih Proses
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Belum Mulai
                        </span>
                    @endif
                    
                    @if($statusKompetensi == 'Kompeten')
                        <a href="{{ route('admin.asesi.certificate.download', $asesi->id_asesi) }}" class="mt-2 inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 rounded-md text-white text-sm transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download Sertifikat
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Progress Bar -->
            @if($progressData)
            <div class="mt-6">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress Asesmen</span>
                    <span class="text-sm font-medium text-gray-700">{{ $progressData['progress_percentage'] }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="progress-bar h-3 rounded-full {{ $progressData['progress_percentage'] >= 100 ? 'bg-green-600' : ($progressData['progress_percentage'] > 0 ? 'bg-blue-600' : 'bg-gray-400') }}" style="width: {{ $progressData['progress_percentage'] }}%"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500">{{ $progressData['completed_steps'] }} dari {{ $progressData['total_steps'] }} langkah selesai</p>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Data Pribadi -->
            <div class="info-card bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Data Pribadi
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Nama Lengkap</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->nama_asesi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Email</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->email ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">NIM</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->nim ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Tempat/Tanggal Lahir</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->tempat_tanggal_lahir ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Jenis Kelamin</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->jenis_kelamin ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Kebangsaan</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->kebangsaan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">No. Telepon</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->no_telp ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Alamat</span>
                        <span class="text-sm font-medium text-gray-900 text-right max-w-xs">{{ $asesi->alamat_rumah ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-gray-500">Kota Domisili</span>
                        <span class="text-sm font-medium text-gray-900">{{ $asesi->kota_domisili ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Data Sertifikasi & Pekerjaan -->
            <div class="space-y-6">
                <!-- Data Sertifikasi -->
                <div class="info-card bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                        Data Sertifikasi
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Skema</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->skema->nama_skema ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Nomor Skema</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->skema->nomor_skema ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">Tanggal Daftar</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->created_at ? $asesi->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Data Pekerjaan -->
                <div class="info-card bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Data Pekerjaan
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Status Pekerjaan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->status_pekerjaan ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Nama Perusahaan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->nama_perusahaan ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Jabatan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->jabatan ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Alamat Perusahaan</span>
                            <span class="text-sm font-medium text-gray-900 text-right max-w-xs">{{ $asesi->alamat_perusahaan ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-sm text-gray-500">No. Telp Perusahaan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $asesi->no_telp_perusahaan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rincian Asesmen -->
        @if($asesi->rincianAsesmen)
        <div class="info-card bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Rincian Asesmen
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <span class="text-sm text-gray-500">Asesor</span>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $asesi->rincianAsesmen->asesor->nama_asesor ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <span class="text-sm text-gray-500">Event</span>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $asesi->rincianAsesmen->event->nama_event ?? '-' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <span class="text-sm text-gray-500">Tanggal Assign</span>
                    <p class="text-sm font-medium text-gray-900 mt-1">{{ $asesi->rincianAsesmen->created_at ? $asesi->rincianAsesmen->created_at->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
