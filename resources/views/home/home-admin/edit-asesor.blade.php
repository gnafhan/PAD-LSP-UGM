@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Data Asesor - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Edit Data Asesor
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Terakhir diperbarui: {{ now()->format('d F Y') }}
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

        <!-- Profil Asesor -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-indigo-50 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-full bg-purple-200 flex items-center justify-center">
                            <span class="text-lg font-bold text-purple-700">
                                {{ strtoupper(substr($asesor->nama_asesor, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $asesor->nama_asesor }}
                        </h3>
                        <div class="text-sm text-gray-600">
                            {{ $asesor->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit Asesor -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Edit Informasi Asesor</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Perbarui data asesor, termasuk status, masa berlaku, dan bidang kompetensi
                </p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.pengguna.asesor.update-status', $asesor->id_asesor ) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_asesor" value="{{ $asesor->id_asesor }}">
                    <input type="hidden" id="bidang_kompetensi_hidden" name="bidang_kompetensi" value="{{ json_encode(array_column($asesor->bidang_kompetensi_data ?? [], 'id')) }}">

                    <div class="grid grid-cols-1 gap-y-6 gap-x-8 sm:grid-cols-2">
                        <!-- Kolom Kiri - Informasi Utama -->
                        <div class="space-y-6">
                            <div>
                                <label for="kode_registrasi" class="block text-sm font-medium text-gray-700 mb-1">
                                    Kode Registrasi
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="kode_registrasi" name="kode_registrasi"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('kode_registrasi') border-red-500 @enderror"
                                        value="{{ old('kode_registrasi', $asesor->kode_registrasi) }}">
                                </div>
                                @error('kode_registrasi')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_sertifikat" class="block text-sm font-medium text-gray-700 mb-1">
                                    No. Sertifikat BNSP
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="no_sertifikat" name="no_sertifikat"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('no_sertifikat') border-red-500 @enderror"
                                        value="{{ old('no_sertifikat', $asesor->no_sertifikat) }}">
                                </div>
                                @error('no_sertifikat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status_asesor" class="block text-sm font-medium text-gray-700 mb-1">
                                    Status Asesor
                                </label>
                                <div class="mt-1">
                                    <select id="status_asesor" name="status_asesor"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('status_asesor') border-red-500 @enderror">
                                        <option value="Aktif" {{ (old('status_asesor', $asesor->status_asesor) == 'Aktif') ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak" {{ (old('status_asesor', $asesor->status_asesor) == 'Tidak') ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                @error('status_asesor')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="masa_berlaku" class="block text-sm font-medium text-gray-700 mb-1">
                                    Masa Berlaku (Isi Kembali)
                                </label>
                                <div class="mt-1">
                                    <input type="date" id="masa_berlaku" name="masa_berlaku"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('masa_berlaku') border-red-500 @enderror"
                                        value="{{ old('masa_berlaku', $asesor->masa_berlaku) }}">
                                </div>
                                @if($asesor->masa_berlaku)
                                    <p class="mt-1 text-xs text-gray-500">
                                        Masa berlaku saat ini: {{ \Carbon\Carbon::parse($asesor->masa_berlaku)->format('d F Y') }}
                                    </p>
                                @endif
                                @error('masa_berlaku')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">
                                    Fakultas
                                </label>
                                <div class="mt-1 flex space-x-2">
                                    <select id="fakultas_select" name="fakultas"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('fakultas') border-red-500 @enderror">
                                        <option value="">Pilih Fakultas</option>
                                        @foreach($fakultasList as $fakultas)
                                            <option value="{{ $fakultas }}" {{ old('fakultas', $asesor->fakultas) == $fakultas ? 'selected' : '' }}>{{ $fakultas }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="tambahFakultasBtn"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Fakultas tempat asesor berafiliasi</p>
                                @error('fakultas')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="file_sertifikat_asesor" class="block text-sm font-medium text-gray-700 mb-1">
                                    Sertifikat BNSP Asesor Kompetensi
                                </label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" id="file_sertifikat_asesor" name="file_sertifikat_asesor"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('file_sertifikat_asesor') border-red-500 @enderror">
                                </div>
                                @if($asesor->file_sertifikat_asesor)
                                    <p class="mt-1 text-xs text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        File saat ini: {{ $asesor->file_sertifikat_asesor }}
                                    </p>
                                @endif
                                <p class="mt-1 text-xs text-gray-500">
                                    Format: PDF, JPG, JPEG, PNG (maksimal 2MB)
                                </p>
                                @error('file_sertifikat_asesor')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan - Bidang Kompetensi -->
                        <div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Bidang Kompetensi
                                </label>
                                <div class="flex space-x-2">
                                    <select id="id_bidang"
                                        class="px-4 py-2 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="" disabled selected>Pilih Bidang Kompetensi</option>
                                        @foreach($bidangKompetensi as $bidang)
                                            <option value="{{ $bidang->id_bidang_kompetensi }}" data-nama="{{ $bidang->nama_bidang }}">
                                                {{ $bidang->nama_bidang }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="tambahBidangBtn"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button type="button" id="tambahBidangBaruBtn"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Baru
                                    </button>
                                </div>
                            </div>

                            <div class="mt-4 bg-white border border-gray-200 rounded-md overflow-hidden">
                                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-700">
                                        Bidang Kompetensi Terpilih
                                    </h4>
                                </div>
                                <ul id="bidangList" class="divide-y divide-gray-200 max-h-[350px] overflow-y-auto">
                                    <li id="empty-bidang-row" class="px-4 py-3 text-center text-sm text-gray-500 italic {{ !empty($asesor->bidang_kompetensi_data) ? 'hidden' : '' }}">
                                        Belum ada bidang kompetensi yang dipilih
                                    </li>

                                    @if(!empty($asesor->bidang_kompetensi_data))
                                        @foreach($asesor->bidang_kompetensi_data as $bidang)
                                            <li class="px-4 py-3 flex justify-between items-center">
                                                <span class="text-sm text-gray-700">{{ $bidang['nama_bidang'] }}</span>
                                                <button type="button" class="hapusBidangBtn text-red-500 hover:text-red-700" data-id="{{ $bidang['id'] }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit & Cancel -->
                    <div class="pt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.pengguna.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Bidang Kompetensi Baru -->
<div id="modalTambahBidang" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tambah Bidang Kompetensi Baru</h3>
                <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formTambahBidang">
                <div class="mb-4">
                    <label for="nama_bidang_baru" class="block text-sm font-medium text-gray-700 mb-2">Nama Bidang Kompetensi <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_bidang_baru" name="nama_bidang_baru" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Masukkan nama bidang kompetensi" required>
                    <div id="error_nama_bidang" class="hidden text-sm text-red-600 mt-1"></div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button type="submit" id="submitBidangBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Fakultas Baru -->
<div id="modalTambahFakultas" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tambah Fakultas Baru</h3>
                <button type="button" id="closeFakultasModalBtn" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="formTambahFakultas">
                <div class="mb-4">
                    <label for="nama_fakultas_baru" class="block text-sm font-medium text-gray-700 mb-2">Nama Fakultas <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_fakultas_baru" name="nama_fakultas_baru" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Masukkan nama fakultas" required>
                    <div id="error_nama_fakultas" class="hidden text-sm text-red-600 mt-1"></div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelFakultasBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button type="submit" id="submitFakultasBtn" class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi array bidang kompetensi global
    window.daftarBidangKompetensi = [];

    // Isi array dari data yang ada
    @if(!empty($asesor->bidang_kompetensi_data))
        @foreach($asesor->bidang_kompetensi_data as $bidang)
            window.daftarBidangKompetensi.push({
                id: "{{ $bidang['id'] }}",
                nama: "{{ $bidang['nama_bidang'] }}"
            });
        @endforeach
    @endif

    // Update hidden input
    document.getElementById('bidang_kompetensi_hidden').value = JSON.stringify(window.daftarBidangKompetensi.map(b => b.id));

    // Event listener untuk tombol tambah bidang
    document.getElementById('tambahBidangBtn').addEventListener('click', function() {
        const select = document.getElementById('id_bidang');
        if (!select.value) {
            alert("Pilih bidang kompetensi terlebih dahulu.");
            return;
        }

        const id_bidang = select.value;
        const namaBidang = select.options[select.selectedIndex].getAttribute('data-nama');

        if (window.daftarBidangKompetensi.some(b => b.id === id_bidang)) {
            alert("Bidang kompetensi ini sudah ditambahkan.");
            return;
        }

        // Tambahkan ke daftar
        window.daftarBidangKompetensi.push({
            id: id_bidang,
            nama: namaBidang
        });

        // Update hidden input
        document.getElementById('bidang_kompetensi_hidden').value = JSON.stringify(window.daftarBidangKompetensi.map(b => b.id));

        // Sembunyikan pesan kosong
        const emptyRow = document.getElementById('empty-bidang-row');
        if (emptyRow) {
            emptyRow.classList.add('hidden');
        }

        // Tambahkan ke UI
        const bidangList = document.getElementById('bidangList');
        const newItem = document.createElement('li');
        newItem.className = 'px-4 py-3 flex justify-between items-center';
        newItem.innerHTML = `
            <span class="text-sm text-gray-700">${namaBidang}</span>
            <button type="button" class="hapusBidangBtn text-red-500 hover:text-red-700" data-id="${id_bidang}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        `;
        bidangList.appendChild(newItem);
    });

    // Event delegation untuk tombol hapus bidang
    document.getElementById('bidangList').addEventListener('click', function(e) {
        if (e.target.closest('.hapusBidangBtn')) {
            const button = e.target.closest('.hapusBidangBtn');
            const id_bidang = button.getAttribute('data-id');
            const listItem = button.closest('li');

            // Hapus dari array
            const index = window.daftarBidangKompetensi.findIndex(b => b.id === id_bidang);
            if (index !== -1) {
                window.daftarBidangKompetensi.splice(index, 1);

                // Update hidden input
                document.getElementById('bidang_kompetensi_hidden').value = JSON.stringify(window.daftarBidangKompetensi.map(b => b.id));

                // Animasi hapus
                listItem.style.opacity = '0';
                listItem.style.transform = 'translateX(10px)';
                listItem.style.transition = 'opacity 300ms, transform 300ms';

                setTimeout(() => {
                    listItem.remove();

                    // Tampilkan pesan kosong jika tidak ada bidang lagi
                    if (window.daftarBidangKompetensi.length === 0) {
                        const emptyRow = document.getElementById('empty-bidang-row');
                        if (emptyRow) {
                            emptyRow.classList.remove('hidden');
                        }
                    }
                }, 300);
            }
        }
    });

    // Event listener untuk tombol tambah bidang baru
    document.getElementById('tambahBidangBaruBtn').addEventListener('click', function() {
        document.getElementById('modalTambahBidang').classList.remove('hidden');
        document.getElementById('nama_bidang_baru').focus();
    });

    // Event listener untuk tombol close modal
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('modalTambahBidang').classList.add('hidden');
        document.getElementById('formTambahBidang').reset();
        document.getElementById('error_nama_bidang').classList.add('hidden');
    });

    // Event listener untuk tombol cancel
    document.getElementById('cancelBtn').addEventListener('click', function() {
        document.getElementById('modalTambahBidang').classList.add('hidden');
        document.getElementById('formTambahBidang').reset();
        document.getElementById('error_nama_bidang').classList.add('hidden');
    });

    // Event listener untuk form tambah bidang
    document.getElementById('formTambahBidang').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const namaBidang = document.getElementById('nama_bidang_baru').value.trim();
        const submitBtn = document.getElementById('submitBidangBtn');
        const errorDiv = document.getElementById('error_nama_bidang');
        
        if (!namaBidang) {
            errorDiv.textContent = 'Nama bidang kompetensi tidak boleh kosong';
            errorDiv.classList.remove('hidden');
            return;
        }
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';
        
        // Send AJAX request
        fetch('{{ route("admin.pengguna.bidang-kompetensi.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nama_bidang: namaBidang
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new bidang to dropdown
                const select = document.getElementById('id_bidang');
                const newOption = document.createElement('option');
                newOption.value = data.data.id;
                newOption.setAttribute('data-nama', data.data.nama);
                newOption.textContent = data.data.nama;
                select.appendChild(newOption);
                
                // Close modal
                document.getElementById('modalTambahBidang').classList.add('hidden');
                document.getElementById('formTambahBidang').reset();
                errorDiv.classList.add('hidden');
                
                // Show success message
                alert('Bidang kompetensi berhasil ditambahkan!');
                
                // Auto-select the new bidang
                select.value = data.data.id;
                
            } else {
                // Show error
                if (data.errors && data.errors.nama_bidang) {
                    errorDiv.textContent = data.errors.nama_bidang[0];
                } else {
                    errorDiv.textContent = data.message || 'Terjadi kesalahan';
                }
                errorDiv.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorDiv.textContent = 'Terjadi kesalahan pada server';
            errorDiv.classList.remove('hidden');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan';
        });
    });

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

    // ========== FAKULTAS MODAL HANDLERS ==========
    
    // Event listener untuk tombol tambah fakultas baru
    document.getElementById('tambahFakultasBtn').addEventListener('click', function() {
        document.getElementById('modalTambahFakultas').classList.remove('hidden');
        document.getElementById('nama_fakultas_baru').focus();
    });

    // Event listener untuk tombol close modal fakultas
    document.getElementById('closeFakultasModalBtn').addEventListener('click', function() {
        document.getElementById('modalTambahFakultas').classList.add('hidden');
        document.getElementById('formTambahFakultas').reset();
        document.getElementById('error_nama_fakultas').classList.add('hidden');
    });

    // Event listener untuk tombol cancel fakultas
    document.getElementById('cancelFakultasBtn').addEventListener('click', function() {
        document.getElementById('modalTambahFakultas').classList.add('hidden');
        document.getElementById('formTambahFakultas').reset();
        document.getElementById('error_nama_fakultas').classList.add('hidden');
    });

    // Event listener untuk form tambah fakultas
    document.getElementById('formTambahFakultas').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const namaFakultas = document.getElementById('nama_fakultas_baru').value.trim();
        const errorDiv = document.getElementById('error_nama_fakultas');
        
        if (!namaFakultas) {
            errorDiv.textContent = 'Nama fakultas tidak boleh kosong';
            errorDiv.classList.remove('hidden');
            return;
        }
        
        // Check if fakultas already exists in dropdown
        const fakultasSelect = document.getElementById('fakultas_select');
        const existingOptions = Array.from(fakultasSelect.options).map(opt => opt.value.toLowerCase());
        
        if (existingOptions.includes(namaFakultas.toLowerCase())) {
            errorDiv.textContent = 'Fakultas ini sudah ada dalam daftar';
            errorDiv.classList.remove('hidden');
            return;
        }
        
        // Add new fakultas to dropdown
        const newOption = document.createElement('option');
        newOption.value = namaFakultas;
        newOption.textContent = namaFakultas;
        fakultasSelect.appendChild(newOption);
        
        // Select the new fakultas
        fakultasSelect.value = namaFakultas;
        
        // Close modal
        document.getElementById('modalTambahFakultas').classList.add('hidden');
        document.getElementById('formTambahFakultas').reset();
        errorDiv.classList.add('hidden');
        
        // Show success message
        alert('Fakultas berhasil ditambahkan!');
    });
});
</script>
@endsection
