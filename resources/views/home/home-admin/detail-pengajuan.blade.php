@extends('home.home-admin.layouts.layout')

@section('title', 'Detail Pengajuan - Lembaga Sertifikasi Profesi UGM')

<style>
    .pdf-container {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        overflow: hidden;
        height: 250px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        position: relative;
    }

    .pdf-container iframe, .pdf-container embed {
        width: 100%;
        height: 100%;
        border: none;
    }

    .document-card {
        transition: all 0.3s ease;
    }

    .document-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .status-badge {
        position: relative;
        overflow: hidden;
    }

    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, transparent 49%, rgba(255,255,255,0.2) 50%, transparent 51%);
        background-size: 200% 200%;
        animation: shine 1.5s linear infinite;
    }

    @keyframes shine {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    .signature-area {
        border: 1px dashed #cbd5e0;
        border-radius: 0.375rem;
        padding: 0.5rem;
        background-color: #f9fafb;
    }

    .form-section {
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        background-color: white;
        padding: 1.5rem;
    }

    .section-header {
        position: relative;
        padding-bottom: 0.75rem;
        margin-bottom: 1.25rem;
        font-weight: 600;
    }

    .section-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 3rem;
        height: 2px;
        background-color: #4F46E5;
    }

    .btn-action {
        transition: all 0.2s ease;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-action svg {
        margin-right: 0.5rem;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }
</style>

@section('content')
<div class="min-h-screen bg-gray-50 py-32">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header with breadcrumbs -->
            <div class="mb-6 flex justify-between items-center">
                @if(Auth::user()->level === 'admin')
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Permohonan Sertifikasi</h1>
                        <div class="text-sm breadcrumbs mt-1">
                            <ul class="flex text-gray-500 space-x-1">
                                <li><a href="{{ route('home-admin') }}" class="hover:text-indigo-600">Dashboard</a></li>
                                <li><span class="mx-1">/</span></li>
                                <li><a href="{{ route('admin.asesi.index') }}" class="hover:text-indigo-600">Daftar Pengajuan</a></li>
                                <li><span class="mx-1">/</span></li>
                                <li class="text-gray-700 font-medium">{{ $asesiPengajuan->nama_user }}</li>
                            </ul>
                        </div>
                    </div>
                @else
                <div class="flex justify-end mt-8">
                    <button type="button" onclick="window.history.back()" class="btn-action px-5 py-2.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                         Kembali
                   </button>
                </div>
                @endif

                <!-- Status Badge -->
                <div>
                    @if($asesiPengajuan->status_rekomendasi === 'Diterima')
                        <span class="status-badge px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Pengajuan Diterima
                        </span>
                    @elseif($asesiPengajuan->status_rekomendasi === 'Ditolak')
                        <span class="status-badge px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Pengajuan Ditolak
                        </span>
                    @elseif($asesiPengajuan->status === 'needs_revision')
                        <span class="status-badge px-4 py-2 bg-amber-100 text-amber-800 rounded-full text-sm font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Menunggu Revisi
                        </span>
                    @else
                        <span class="status-badge px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Menunggu Persetujuan
                        </span>
                    @endif

                    <div class="text-xs text-gray-500 text-right mt-1">
                        ID: {{ $asesiPengajuan->id_pengajuan }}
                    </div>
                </div>
            </div>

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

        @if($asesiPengajuan->status === 'revised_by_asesi')
        <div class="mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Asesi telah menyelesaikan revisi. Mohon periksa data yang telah diperbarui.</p>
                </div>
            </div>
        </div>
        @endif


            <!-- Document information card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-8 overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-800">FR.APL.01 Permohonan Sertifikasi Kompetensi</h2>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.asesi.process', $asesiPengajuan->id_pengajuan) }}" method="POST" id="process-pengajuan-form">
                    @csrf
                    <!-- Bagian 1: Rincian Data Pemohon -->
                    <div class="form-section mb-8">
                        <h2 class="section-header font-semibold text-lg text-gray-800 mb-3">Bagian 1: Rincian Data Pemohon Sertifikasi</h2>
                         <!-- Change one of these to a different name to avoid conflicts -->
                         <input type="hidden" name="form_action" id="form-action" value="">
                         <input type="hidden" name="action" id="form-action-input">

                        <!-- Data Pribadi -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Data Pribadi
                            </h4>

                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" value="{{ $asesiPengajuan->nama_user ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">No. KTP/NIK/Paspor</label>
                                        <input type="text" value="{{ $asesiPengajuan->nik ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat / Tgl. Lahir</label>
                                        <input type="text" value="{{ $asesiPengajuan->tempat_tanggal_lahir ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                        <input type="text" value="{{ $asesiPengajuan->jenis_kelamin ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kebangsaan</label>
                                        <input type="text" value="{{ $asesiPengajuan->kebangsaan ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Rumah</label>
                                        <input type="text" value="{{ $asesiPengajuan->alamat_rumah ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota Domisili</label>
                                        <input type="text" value="{{ $asesiPengajuan->kota_domisili ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon </label>
                                        <input type="text" value="{{ $asesiPengajuan->no_telp ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1"> E-mail</label>
                                        <input type="text" value="{{ $asesiPengajuan->email ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir</label>
                                        <input type="text" value="{{ $asesiPengajuan->pendidikan_terakhir ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Pekerjaan -->
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Data Pekerjaan Sekarang
                            </h4>

                            <div class="bg-gray-50 p-4 rounded-md">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pekerjaan</label>
                                        <input type="text" value="{{ $asesiPengajuan->status_pekerjaan ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi / Perusahaan</label>
                                        <input type="text" value="{{ $asesiPengajuan->nama_perusahaan ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                        <input type="text" value="{{ $asesiPengajuan->jabatan ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Perusahaan</label>
                                        <input type="text" value="{{ $asesiPengajuan->alamat_perusahaan ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Perusahaan</label>
                                        <input type="text" value="{{ $asesiPengajuan->no_telp_perusahaan ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 2: Data Sertifikasi -->
                    <div class="form-section mb-8">
                        <h2 class="section-header font-semibold text-lg text-gray-800 mb-3">Bagian 2: Data Sertifikasi</h>

                        <div class="bg-gray-50 p-4 rounded-md">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Skema Sertifikasi</label>
                                    <input type="text" value="{{ $asesiPengajuan->nama_skema ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor</label>
                                    <input type="text" value="{{ $asesiPengajuan->nomor_skema ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Asesmen</label>
                                    <input type="text" value="{{ $asesiPengajuan->tujuan_asesmen ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sumber Anggaran</label>
                                    <input type="text" value="{{ $asesiPengajuan->sumber_anggaran ?? 'N/A' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 3: Bukti Kelengkapan Pemohon -->
                    <div class="form-section mb-8">
                        <h2 class="section-header font-semibold text-lg text-gray-800 mb-3">Bagian 3: Bukti Kelengkapan Dokumen</h2>

                    @php
                        // Decode JSON string to PHP array if it's a string
                        $fileKelengkapan = is_string($asesiPengajuan->file_kelengkapan_pemohon)
                            ? json_decode($asesiPengajuan->file_kelengkapan_pemohon, true)
                            : $asesiPengajuan->file_kelengkapan_pemohon;

                        // Define file type mapping - sesuaikan dengan key yang sebenarnya
                        $fileMapping = [
                            'bukti_jenjang_siswa' => 'Ijazah Pendidikan',
                            'bukti_transkrip' => 'Transkrip Nilai',
                            'bukti_pengalaman_kerja' => 'Bukti Pengalaman Kerja',
                            'bukti_magang' => 'Sertifikat Magang/PKL',
                            'bukti_ktp' => 'KTP/Kartu Identitas',
                            'bukti_foto' => 'Pas Foto',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        @foreach($fileMapping as $key => $label)
                            <div class="document-card bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                                    <h5 class="font-medium text-gray-700">{{ $label }}</h5>

                                    @if(isset($fileKelengkapan[$key]) && !empty($fileKelengkapan[$key]))
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Tersedia</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Tidak Tersedia</span>
                                    @endif
                                </div>

                                <div class="p-4">
                                    @if(isset($fileKelengkapan[$key]) && !empty($fileKelengkapan[$key]))
                                        <div class="pdf-container">
                                            <object data="{{ asset($fileKelengkapan[$key]) }}" type="application/pdf" width="100%" height="100%">
                                                <iframe src="https://docs.google.com/viewer?url={{ urlencode(asset($fileKelengkapan[$key])) }}&embedded=true" width="100%" height="100%" frameborder="0">
                                                    Browser tidak mendukung tampilan PDF. <a href="{{ asset($fileKelengkapan[$key]) }}" target="_blank">Klik untuk mengunduh</a>
                                                </iframe>
                                            </object>
                                        </div>
                                        <div class="mt-3 flex justify-end">
                                            <a href="{{ asset($fileKelengkapan[$key]) }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                                Buka di tab baru
                                            </a>
                                        </div>
                                    @else
                                        <div class="h-48 flex flex-col items-center justify-center bg-gray-50 rounded border border-dashed border-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">Dokumen tidak tersedia</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tanda Tangan dan Persetujuan -->
                    <div class="form-section mb-8">
                        <h3 class="section-header text-lg text-gray-800">Persetujuan dan Tanda Tangan</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-4">
                            <!-- Pemohon -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-700 mb-2">Pemohon</h4>
                                <p class="text-gray-600 mb-4 text-sm">Dengan ini saya menyetujui permohonan</p>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" value="{{ $asesiPengajuan->nama_user }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                </div>

                                <div class="signature-area flex flex-col items-center justify-center p-3 mt-2">
                                    @if($asesiPengajuan->ttd_pemohon)
                                        <img src="{{ asset('storage/' . $asesiPengajuan->ttd_pemohon) }}" alt="Tanda Tangan Pemohon" class="h-20 mb-2">
                                        <p class="text-xs text-gray-500">Ditandatangani pada: {{ $asesiPengajuan->created_at ? date('d M Y, H:i', strtotime($asesiPengajuan->created_at)) : 'N/A' }}</p>
                                    @else
                                        <div class="text-center py-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="mt-1 text-sm text-gray-500">Belum ditandatangani</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Admin LSP -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-700 mb-2">Admin LSP</h4>

                                @if($asesiPengajuan->status_rekomendasi != 'Diterima' && $asesiPengajuan->status_rekomendasi != 'Ditolak')
                                    <div class="flex items-center mb-3">
                                        <input type="checkbox" id="approve-admin" name="admin_signed" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        <label for="approve-admin" class="ml-2 text-sm text-gray-700">Tandatangani permohonan ini</label>
                                    </div>
                                @else
                                    <p class="text-gray-600 mb-4 text-sm">
                                        @if($asesiPengajuan->status_rekomendasi === 'Diterima')
                                            Permohonan telah disetujui
                                        @else
                                            Permohonan telah ditolak
                                        @endif
                                    </p>
                                @endif

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Admin</label>
                                    @if (Auth::user()->level != 'admin')
                                        <input type="text" value="{{ Auth::user()->asesiPengajuan->admin->name ?? 'Admin LSP' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    @else
                                    <input type="text" value="{{ Auth::user()->name ?? 'Admin LSP' }}" class="w-full p-2 border border-gray-300 rounded-md bg-white text-gray-800" readonly />
                                    @endif
                                </div>

                                <div class="signature-area flex flex-col items-center justify-center p-3 mt-2">
                                    @if (Auth::user()->level != 'admin')
                                        @php
                                            $adminTtd = Auth::user()->asesiPengajuan->admin->getTandaTanganPadaWaktu($asesiPengajuan->waktu_tanda_tangan)->first();
                                        @endphp

                                        @if($adminTtd && $adminTtd->file_tanda_tangan)
                                            <img src="{{ asset('storage/' . $adminTtd->file_tanda_tangan) }}" alt="Tanda Tangan Admin" class="h-20 mb-2">
                                        @else
                                            <div class="text-center py-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="mt-1 text-sm text-gray-500">Tanda tangan tidak tersedia</p>
                                            </div>
                                        @endif
                                    @else
                                        @php
                                            $adminTtd = Auth::user()->tandaTanganAktif()->first();
                                        @endphp

                                        @if($adminTtd && $adminTtd->file_tanda_tangan)
                                            <img src="{{ asset('storage/' . $adminTtd->file_tanda_tangan) }}" alt="Tanda Tangan Admin" class="h-20 mb-2">
                                        @else
                                            <div class="text-center py-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="mt-1 text-s text-gray-500">Tanda tangan tidak tersedia</p>
                                                <span class="mt-1 text-sm font-bold text-gray-500">Upload data tanda tangan di halaman Pengguna!</span>
                                            </div>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alasan Penolakan -->
                    <div id="reject-reason-container" class="form-section mb-8 {{ $asesiPengajuan->status_rekomendasi === 'Ditolak' ? '' : 'hidden' }}">
                        <h3 class="section-header text-lg text-gray-800">Alasan Penolakan</h3>

                        <div class="bg-gray-50 p-4 rounded-md">
                            @if($asesiPengajuan->status_rekomendasi === 'Ditolak')
                                <p class="text-gray-700 italic">{{ $asesiPengajuan->alasan_penolakan_pengajuan }}</p>
                            @else
                                <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" class="w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jelaskan alasan penolakan pengajuan ini..."></textarea>
                                <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter. Informasi ini akan ditampilkan kepada pemohon.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Formulir Revisi -->
                    <div id="revision-section" class="form-section mb-8 {{ $asesiPengajuan->status === 'needs_revision' ? '' : 'hidden' }}">
                        <h3 class="section-header text-lg text-gray-800">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Permintaan Revisi
                            </div>
                        </h3>

                        <div class="bg-gray-50 p-4 rounded-md">
                            @if($asesiPengajuan->status === 'needs_revision')
                                <div class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-medium text-gray-700">Catatan Revisi:</span>
                                    </div>
                                    <div class="ml-7 p-3 bg-white rounded-md border border-gray-200 text-gray-700">
                                        {{ $asesiPengajuan->revision_notes ?? 'Tidak ada catatan spesifik.' }}
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="font-medium text-gray-700">Bagian yang Perlu Direvisi:</span>
                                    </div>
                                    <div class="ml-7">
                                        <ul class="list-disc pl-5 text-gray-700 space-y-1">
                                            @if(is_array($asesiPengajuan->sections_to_revise))
                                                @foreach($asesiPengajuan->sections_to_revise as $section)
                                                    <li class="text-gray-700">
                                                        @if($section == \App\Models\AsesiPengajuan::STEP_DATA_PRIBADI)
                                                            Data Pribadi
                                                        @elseif($section == \App\Models\AsesiPengajuan::STEP_DATA_SERTIFIKASI)
                                                            Data Sertifikasi
                                                        @elseif($section == \App\Models\AsesiPengajuan::STEP_BUKTI_KELENGKAPAN)
                                                            Bukti Kelengkapan
                                                        @elseif($section == \App\Models\AsesiPengajuan::STEP_KONFIRMASI)
                                                            Konfirmasi
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="text-gray-500 italic">Tidak ada bagian spesifik yang ditandai.</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                            @else
                                <div class="mb-4">
                                    <label for="revision_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Revisi</label>
                                    <textarea id="revision_notes" name="revision_notes" rows="4" class="w-full p-3 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Jelaskan bagian apa yang perlu direvisi dan instruksi spesifik..."></textarea>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter. Berikan instruksi yang jelas kepada pemohon.</p>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bagian yang Perlu Direvisi</label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="revise_data_pribadi" name="sections_to_revise[]" value="{{ \App\Models\AsesiPengajuan::STEP_DATA_PRIBADI }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="revise_data_pribadi" class="ml-2 text-sm text-gray-700">Data Pribadi</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="revise_data_sertifikasi" name="sections_to_revise[]" value="{{ \App\Models\AsesiPengajuan::STEP_DATA_SERTIFIKASI }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="revise_data_sertifikasi" class="ml-2 text-sm text-gray-700">Data Sertifikasi</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="revise_bukti_kelengkapan" name="sections_to_revise[]" value="{{ \App\Models\AsesiPengajuan::STEP_BUKTI_KELENGKAPAN }}" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <label for="revise_bukti_kelengkapan" class="ml-2 text-sm text-gray-700">Bukti Kelengkapan</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btn-confirm-revision" class="mt-4 w-full bg-amber-600  bg-white border border-black-500 text-black-600 hover:bg-amber-700 text-black px-4 py-2 rounded-md transition flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Kirim Permintaan Revisi
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    @if(Auth::user()->level === 'admin')
                        @if($asesiPengajuan->status_rekomendasi != 'Diterima' && $asesiPengajuan->status_rekomendasi != 'Ditolak')
                            <div class="flex justify-end space-x-4 mt-8">
                                <input type="hidden" name="action" id="form-action-input" value="">

                                <button type="button" id="btn-reject" class="btn-action px-5 py-2.5 bg-white border border-red-500 text-red-600 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Pengajuan
                                </button>

                                <button type="button" id="btn-revise" class="btn-action px-5 py-2.5 bg-white border border-amber-500 text-amber-600 rounded-md hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Minta Revisi
                                </button>

                                <button type="button" id="btn-approve" class="btn-action px-5 py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Pengajuan
                                </button>
                            </div>
                        @else
                            <div class="flex justify-end mt-8">
                                <a href="{{ route('admin.asesi.index') }}" class="btn-action px-5 py-2.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Kembali ke Daftar
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="flex justify-end mt-8">
                            <button type="button" onclick="window.history.back()" class="btn-action px-5 py-2.5 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Kembali
                            </button>
                        </div>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnApprove = document.getElementById('btn-approve');
    const btnReject = document.getElementById('btn-reject');
    const btnRevise = document.getElementById('btn-revise');
    const form = document.getElementById('process-pengajuan-form');
    const rejectReasonContainer = document.getElementById('reject-reason-container');
    const revisionSection = document.getElementById('revision-section');
    const approveAdminCheckbox = document.getElementById('approve-admin');

    // Fix the form action field - pastikan hanya menggunakan satu field
    const actionInput = document.getElementById('form-action-input');
    const formAction = document.getElementById('form-action');
    const confirmRevisionBtn = document.getElementById('btn-confirm-revision');

    if (btnApprove) {
        btnApprove.addEventListener('click', function() {
            if (!approveAdminCheckbox.checked) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanda Tangan Diperlukan',
                    text: 'Anda harus menandatangani formulir terlebih dahulu!',
                    confirmButtonColor: '#4F46E5'
                });
                return;
            }

            Swal.fire({
                title: 'Setujui Pengajuan?',
                text: 'Apakah Anda yakin akan menyetujui pengajuan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set form action value pada kedua field
                    actionInput.value = 'approve';
                    if (formAction) formAction.value = 'approve';

                    // Hide sections that shouldn't be visible
                    rejectReasonContainer.classList.add('hidden');
                    revisionSection.classList.add('hidden');

                    // Submit form
                    form.submit();
                }
            });
        });
    }

    if (btnReject) {
        btnReject.addEventListener('click', function() {
            // Set form action pada kedua field
            actionInput.value = 'reject';
            if (formAction) formAction.value = 'reject';

            // Show reject section, hide revision section
            rejectReasonContainer.classList.remove('hidden');
            revisionSection.classList.add('hidden');

            // Scroll to the rejection reason field
            rejectReasonContainer.scrollIntoView({ behavior: 'smooth' });

            // Don't submit yet, wait for user to fill in reason
            const existingButton = rejectReasonContainer.querySelector('#btn-confirm-reject');

            if (!existingButton) {
                // Create and add the confirm reject button
                const submitReject = document.createElement('button');
                submitReject.type = 'button';
                submitReject.id = 'btn-confirm-reject';
                submitReject.className = 'mt-4 w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition flex items-center justify-center';
                submitReject.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg> Konfirmasi Penolakan';

                submitReject.addEventListener('click', function() {
                    const reasonField = document.getElementById('alasan_penolakan');

                    if (!reasonField.value || reasonField.value.length < 10) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Alasan Diperlukan',
                            text: 'Berikan alasan penolakan minimal 10 karakter.',
                            confirmButtonColor: '#4F46E5'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Tolak Pengajuan?',
                        text: 'Apakah Anda yakin akan menolak pengajuan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#DC2626',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Tolak',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });

                // Add the button to the reject reason container
                rejectReasonContainer.appendChild(submitReject);
            }
        });
    }

    // New handler for revision button
    if (btnRevise) {
        btnRevise.addEventListener('click', function() {
            // Show revision form, hide reject section
            revisionSection.classList.remove('hidden');
            rejectReasonContainer.classList.add('hidden');

            // Set the action value pada kedua field
            actionInput.value = 'revise';
            if (formAction) formAction.value = 'revise';

            // Scroll to the revision section
            revisionSection.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Event handler untuk tombol "Kirim Permintaan Revisi"
    if (confirmRevisionBtn) {
        confirmRevisionBtn.addEventListener('click', function() {
            const notesField = document.getElementById('revision_notes');
            const checkboxes = document.querySelectorAll('input[name="sections_to_revise[]"]:checked');

            if (!notesField.value || notesField.value.length < 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Catatan Revisi Diperlukan',
                    text: 'Berikan catatan revisi minimal 10 karakter.',
                    confirmButtonColor: '#4F46E5'
                });
                return;
            }

            if (checkboxes.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pilih Bagian untuk Direvisi',
                    text: 'Pilih minimal satu bagian yang perlu direvisi.',
                    confirmButtonColor: '#4F46E5'
                });
                return;
            }

            Swal.fire({
                title: 'Kirim Permintaan Revisi?',
                text: 'Apakah Anda yakin akan meminta asesi merevisi pengajuan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#EAB308',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Kirim Permintaan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Memastikan kedua field action terisi dengan benar
                    actionInput.value = 'revise';
                    if (formAction) formAction.value = 'revise';

                    // Jika ada field alasan penolakan, kosongkan untuk mencegah validasi
                    const reasonField = document.getElementById('alasan_penolakan');
                    if (reasonField) {
                        // Beri nilai placeholder agar lolos validasi jika diperlukan
                        reasonField.value = "REVISI - TIDAK DIPERLUKAN";
                    }

                    form.submit();
                }
            });
        });
    }
});
</script>
<!-- Load SweetAlert if not already loaded -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

