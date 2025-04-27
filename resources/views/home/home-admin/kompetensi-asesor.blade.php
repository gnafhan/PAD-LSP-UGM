@extends('home.home-admin.layouts.layout')

@section('title', 'Kelola Kompetensi Asesor - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-blue {
        background-color: rgba(59, 130, 246, 0.1);
        color: rgba(29, 78, 216, 1);
    }
    
    .badge-green {
        background-color: rgba(16, 185, 129, 0.1);
        color: rgba(6, 95, 70, 1);
    }
    
    .badge-purple {
        background-color: rgba(139, 92, 246, 0.1);
        color: rgba(91, 33, 182, 1);
    }
    
    .badge-red {
        background-color: rgba(239, 68, 68, 0.1);
        color: rgba(185, 28, 28, 1);
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

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Kelola Kompetensi Teknis Asesor
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            {{ $asesor->nama_asesor }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex md:mt-0">
                    <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>

                </div>
            </div>
        </div>

        <!-- Informasi Asesor -->
        <div class="bg-white shadow overflow-hidden rounded-lg divide-y divide-gray-200 mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Informasi Asesor
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Informasi dasar asesor.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Nama Lengkap
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->nama_asesor }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->email }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($asesor->status_asesor == 'Aktif')
                                <span class="badge badge-green">Aktif</span>
                            @else
                                <span class="badge badge-red">Tidak Aktif</span>
                            @endif
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Tambah Sertifikat -->
        <div class="bg-white shadow overflow-hidden rounded-lg divide-y divide-gray-200 mb-6">
            <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Tambah Sertifikat Kompetensi Teknis
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Tambahkan sertifikat kompetensi teknis baru untuk asesor ini.
                        </p>
                    </div>
                </div>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('admin.pengguna.kompetensi.store', $asesor->id_asesor) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                        <!-- Lembaga Sertifikasi -->
                        <div class="sm:col-span-3">
                            <label for="lembaga_sertifikasi" class="block text-sm font-medium text-gray-700 mb-1">
                                Lembaga Sertifikasi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                </div>
                                <input type="text" name="lembaga_sertifikasi" id="lembaga_sertifikasi" 
                                    class="pl-10 py-3 focus:ring-blue-500 focus:border-blue-500 block w-full text-base border-gray-300 rounded-md @error('lembaga_sertifikasi') border-red-500 @enderror" 
                                    value="{{ old('lembaga_sertifikasi') }}" 
                                    placeholder="Contoh: BNSP, LSP Migas, dll">
                                @error('lembaga_sertifikasi')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Skema Kompetensi -->
                        <div class="sm:col-span-3">
                            <label for="skema_kompetensi" class="block text-sm font-medium text-gray-700 mb-1">
                                Skema Kompetensi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 4a1 1 0 011-1h8a1 1 0 011 1v1H5V4zm4 3V3a1 1 0 011-1h.5a.5.5 0 01.5.5V3h1V2.5a.5.5 0 01.5-.5H12a1 1 0 011 1v4h-1V7H8v3h6V8h1v7a1 1 0 01-1 1H6a1 1 0 01-1-1V8h1v2h2V7z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="skema_kompetensi" id="skema_kompetensi" 
                                    class="pl-10 py-3 focus:ring-blue-500 focus:border-blue-500 block w-full text-base border-gray-300 rounded-md @error('skema_kompetensi') border-red-500 @enderror" 
                                    value="{{ old('skema_kompetensi') }}" 
                                    placeholder="Contoh: Pemeliharaan Instalasi Listrik">
                                @error('skema_kompetensi')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6">
                        <!-- Masa Berlaku -->
                        <div class="sm:col-span-3">
                            <label for="masa_berlaku" class="block text-sm font-medium text-gray-700 mb-1">
                                Masa Berlaku <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="date" name="masa_berlaku" id="masa_berlaku" 
                                    class="pl-10 py-3 focus:ring-blue-500 focus:border-blue-500 block w-full text-base border-gray-300 rounded-md @error('masa_berlaku') border-red-500 @enderror" 
                                    value="{{ old('masa_berlaku') }}">
                                @error('masa_berlaku')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- File Sertifikat -->
                        <div class="sm:col-span-3">
                            <label for="file_sertifikat" class="block text-sm font-medium text-gray-700 mb-1">
                                File Sertifikat <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1 flex items-center">
                                <div class="relative rounded-md shadow-sm w-full">
                                    <label for="file_sertifikat" class="cursor-pointer bg-white py-3 px-3 border border-gray-300 rounded-md shadow-sm text-base leading-6 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none w-full flex items-center @error('file_sertifikat') border-red-500 @enderror">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span id="file-name" class="truncate">Pilih file...</span>
                                        <input type="file" name="file_sertifikat" id="file_sertifikat" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                </div>
                            </div>
                            @error('file_sertifikat')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1.5 text-xs text-gray-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                Format: PDF, JPG, JPEG, PNG (maksimal 2MB)
                            </p>
                        </div>
                    </div>
                    
                    <!-- Divider -->
                    <div class="pt-2">
                        <div class="border-t border-gray-200"></div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Tambah Sertifikat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Sertifikat -->
        <div class="bg-white shadow overflow-hidden rounded-lg divide-y divide-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Daftar Sertifikat Kompetensi Teknis
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Kelola sertifikat kompetensi teknis yang dimiliki asesor.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if(count($sertifikat) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lembaga Sertifikasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skema Kompetensi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masa Berlaku</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sertifikat as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->lembaga_sertifikasi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->skema_kompetensi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->masa_berlaku)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($item->file_sertifikat)
                                                <a href="{{ asset('storage/sertifikat_kompetensi/' . $item->file_sertifikat) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                    Lihat File
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.pengguna.kompetensi.destroy', ['id' => $asesor->id_asesor, 'kompetensiId' => $item->id_kompetensi_teknis]) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500 italic">
                        Belum ada data sertifikat kompetensi teknis. Silakan tambahkan sertifikat baru menggunakan form di atas.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert && alert.parentNode) {
                alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
    
    // Update file input display
    const fileInput = document.getElementById('file_sertifikat');
    const fileNameDisplay = document.getElementById('file-name');
    
    if (fileInput && fileNameDisplay) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Pilih file...';
            }
        });
    }
    
    // Set min date for masa berlaku to today
    const masaBerlakuInput = document.getElementById('masa_berlaku');
    if (masaBerlakuInput) {
        const today = new Date().toISOString().split('T')[0];
        masaBerlakuInput.setAttribute('min', today);
    }
});
</script>
@endsection