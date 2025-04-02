@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

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
                            <a href="{{ route('admin.uk.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Unit Kompetensi</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Tambah Unit Kompetensi</span>
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
                    <h1 class="text-2xl font-bold text-white">Tambah Unit Kompetensi</h1>
                    <a href="{{ route('admin.uk.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
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

                <form action="{{ route('admin.uk.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Kode UK Field -->
                        <div>
                            <label for="kode_uk" class="block text-sm font-medium text-gray-700 mb-1">Kode Unit Kompetensi <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_uk" id="kode_uk" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kode_uk') border-red-500 @enderror" 
                                   placeholder="Contoh: KUK-01" required value="{{ old('kode_uk') }}">
                            @error('kode_uk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama UK Field -->
                        <div>
                            <label for="nama_uk" class="block text-sm font-medium text-gray-700 mb-1">Nama Unit Kompetensi <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_uk" id="nama_uk" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_uk') border-red-500 @enderror" 
                                   placeholder="Contoh: Pengembangan Aplikasi Web" required value="{{ old('nama_uk') }}">
                            @error('nama_uk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bidang UK Field -->
                        <div>
                            <label for="id_bidang" class="block text-sm font-medium text-gray-700 mb-1">Bidang Unit Kompetensi <span class="text-red-500">*</span></label>
                            <select name="id_bidang" id="id_bidang"
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_bidang') border-red-500 @enderror" required>
                                <option value="" disabled selected>--- Pilih Bidang Unit Kompetensi ---</option>
                                @foreach ($daftarBidangUK as $bidangUK)
                                    <option value="{{ $bidangUK->id_bidang }}" {{ old('id_bidang') == $bidangUK->id_bidang ? 'selected' : '' }}>
                                        {{ $bidangUK->nama_bidang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_bidang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Standar Field -->
                        <div>
                            <label for="jenis_standar" class="block text-sm font-medium text-gray-700 mb-1">Jenis Standar <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_standar" id="jenis_standar" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_standar') border-red-500 @enderror" 
                                   placeholder="Contoh: Standar Nasional" required value="{{ old('jenis_standar') }}">
                            @error('jenis_standar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Elemen UK Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Daftar Elemen Unit Kompetensi <span class="text-red-500">*</span></label>
                            <div class="mt-2 p-4 bg-gray-50 rounded-md border border-gray-200">
                                <div id="elemen-container" class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="elemen_uk[]" 
                                               class="flex-1 px-4 py-2.5 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Masukkan elemen UK" required>
                                        <button type="button" class="bg-red-500 text-white p-2.5 rounded-md hover:bg-red-600 transition-colors hapus-elemen hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="tambah-elemen-btn" 
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white hover:bg-blue-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Tambah Elemen
                                </button>
                            </div>
                            @error('elemen_uk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Minimal harus ada satu elemen unit kompetensi</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Simpan Unit Kompetensi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tambahElemenBtn = document.getElementById('tambah-elemen-btn');
        const elemenContainer = document.getElementById('elemen-container');
        
        // Tambahkan elemen baru
        tambahElemenBtn.addEventListener('click', function() {
            const newElemen = document.createElement('div');
            newElemen.className = 'flex items-center gap-2 animate-fade-in';
            newElemen.innerHTML = `
                <input type="text" name="elemen_uk[]" 
                       class="flex-1 px-4 py-2.5 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       placeholder="Masukkan elemen UK" required>
                <button type="button" class="bg-red-500 text-white p-2.5 rounded-md hover:bg-red-600 transition-colors hapus-elemen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            elemenContainer.appendChild(newElemen);
            
            // Tampilkan tombol hapus pada elemen pertama jika ada lebih dari satu elemen
            if (elemenContainer.querySelectorAll('.flex').length > 1) {
                const firstDeleteBtn = elemenContainer.querySelector('.hapus-elemen');
                if (firstDeleteBtn.classList.contains('hidden')) {
                    firstDeleteBtn.classList.remove('hidden');
                }
            }

            // Focus pada input baru
            newElemen.querySelector('input').focus();
        });
        
        // Event delegation untuk tombol hapus
        elemenContainer.addEventListener('click', function(e) {
            const deleteButton = e.target.closest('.hapus-elemen');
            if (deleteButton) {
                const elemenItem = deleteButton.closest('.flex');
                
                // Jangan hapus jika hanya ada satu elemen tersisa
                const totalElems = elemenContainer.querySelectorAll('.flex').length;
                if (totalElems > 1) {
                    // Animasi penghapusan
                    elemenItem.style.opacity = '0';
                    elemenItem.style.transform = 'translateX(10px)';
                    elemenItem.style.transition = 'opacity 300ms, transform 300ms';
                    
                    setTimeout(() => {
                        elemenItem.remove();
                        
                        // Sembunyikan tombol hapus jika hanya tersisa satu elemen
                        if (elemenContainer.querySelectorAll('.flex').length === 1) {
                            elemenContainer.querySelector('.hapus-elemen').classList.add('hidden');
                        }
                    }, 300);
                } else {
                    // Tampilkan pesan pengingat jika mencoba menghapus elemen terakhir
                    const input = elemenItem.querySelector('input');
                    input.classList.add('border-red-500');
                    input.classList.add('bg-red-50');
                    
                    setTimeout(() => {
                        input.classList.remove('border-red-500');
                        input.classList.remove('bg-red-50');
                    }, 1500);
                }
            }
        });
    });
</script>

<style>
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection