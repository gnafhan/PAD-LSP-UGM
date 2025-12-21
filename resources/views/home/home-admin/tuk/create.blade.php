@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Tempat Uji Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home-admin') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('admin.tuk.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Tempat Uji Kompetensi</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Tambah TUK</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-3xl mx-auto">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 py-6 px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Tambah Tempat Uji Kompetensi</h1>
                    <a href="{{ route('admin.tuk.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                        <svg class="w-5 h-5 mr-1 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                @endif

                <form action="{{ route('admin.tuk.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Kode TUK Field -->
                        <div>
                            <label for="kode_tuk" class="block text-sm font-medium text-gray-700 mb-1">Kode TUK <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_tuk" id="kode_tuk" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kode_tuk') border-red-500 @enderror" 
                                   placeholder="Contoh: TUK-001" required value="{{ old('kode_tuk') }}">
                            @error('kode_tuk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama TUK Field -->
                        <div>
                            <label for="nama_tuk" class="block text-sm font-medium text-gray-700 mb-1">Nama TUK <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_tuk" id="nama_tuk" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_tuk') border-red-500 @enderror" 
                                   placeholder="Contoh: TUK Laboratorium Komputer UGM" required value="{{ old('nama_tuk') }}">
                            @error('nama_tuk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Field -->
                        <div>
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat" id="alamat" rows="3"
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-500 @enderror" 
                                   placeholder="Masukkan alamat lengkap TUK" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Penanggung Jawab Field -->
                        <div>
                            <label for="id_penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab <span class="text-red-500">*</span></label>
                            <select name="id_penanggung_jawab" id="id_penanggung_jawab"
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_penanggung_jawab') border-red-500 @enderror" required>
                                <option value="" disabled selected>--- Pilih Penanggung Jawab ---</option>
                                @foreach ($penanggungJawab as $pj)
                                    <option value="{{ $pj->id_penanggung_jawab }}" {{ old('id_penanggung_jawab') == $pj->id_penanggung_jawab ? 'selected' : '' }}>
                                        {{ $pj->nama_penanggung_jawab }} ({{ $pj->status_penanggung_jawab }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_penanggung_jawab')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Lisensi Field -->
                        <div>
                            <label for="no_lisensi_skkn" class="block text-sm font-medium text-gray-700 mb-1">Nomor Lisensi</label>
                            <input type="text" name="no_lisensi_skkn" id="no_lisensi_skkn" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_lisensi_skkn') border-red-500 @enderror" 
                                   placeholder="Contoh: LSP-UGM/LIS/2023/001" value="{{ old('no_lisensi_skkn') }}">
                            @error('no_lisensi_skkn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Simpan Tempat Uji Kompetensi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection