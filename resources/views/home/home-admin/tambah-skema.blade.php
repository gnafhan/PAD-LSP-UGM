@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Skema - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    /* Updated: 2026-01-21 - Improved spacing and padding */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
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

        display: flex !important;
        align-items: center;
        gap: 12px;
    }
    
    .uk-suggestion-item:last-child {
        border-bottom: none;
    }
    
    .uk-suggestion-item:hover,
    .uk-suggestion-item.active {
        background-color: #f3f4f6;
    }
    
    .uk-suggestion-item .uk-code {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.875rem;
        white-space: nowrap;
        min-width: fit-content;
    }
    
    .uk-suggestion-item .uk-separator {
        color: #9ca3af;
        font-weight: 400;
        margin: 0;
    }
    
    .uk-suggestion-item .uk-name {
        color: #4b5563;
        font-size: 0.875rem;
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .uk-no-results {
        padding: 16px;
        text-align: center;
        color: #9ca3af;
        font-size: 0.875rem;
    }

    #uk_suggestions {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .uk-search-hint {
        padding: 12px 16px;
        background-color: #f9fafb;
        font-size: 0.8125rem;
        color: #6b7280;
        font-weight: 500;
        border-bottom: 1px solid #e5e7eb;
    }
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .uk-suggestion-item:last-child {
        border-bottom: none;
    }
    
    .uk-suggestion-item:hover,
    .uk-suggestion-item.active {
        background-color: #f3f4f6;
    }
    
    .uk-suggestion-item .uk-code {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.875rem;
        white-space: nowrap;
        min-width: fit-content;
    }
    
    .uk-suggestion-item .uk-separator {
        color: #9ca3af;
        font-weight: 400;
        margin: 0;
    }
    
    .uk-suggestion-item .uk-name {
        color: #4b5563;
        font-size: 0.875rem;
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .uk-no-results {
        padding: 16px;
        text-align: center;
        color: #9ca3af;
        font-size: 0.875rem;
    }

    #uk_suggestions {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .uk-search-hint {
        padding: 12px 16px;
        background-color: #f9fafb;
        font-size: 0.8125rem;
        color: #6b7280;
        font-weight: 500;
        border-bottom: 1px solid #e5e7eb;
    }
</style>
@endsection

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
                            <a href="{{ route('admin.skema.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Skema Sertifikasi</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Tambah Skema</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 py-6 px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Tambah Skema Sertifikasi</h1>
                    <a href="{{ route('admin.skema.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
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

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Terdapat kesalahan input:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.skema.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-6">
                        <!-- Nomor Skema Field -->
                        <div>
                            <label for="nomor_skema" class="block text-sm font-medium text-gray-700 mb-1">Nomor Skema <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_skema" id="nomor_skema" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nomor_skema') border-red-500 @enderror" 
                                   placeholder="Contoh: SKM-001" required value="{{ old('nomor_skema') }}">
                            @error('nomor_skema')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Skema Field -->
                        <div>
                            <label for="nama_skema" class="block text-sm font-medium text-gray-700 mb-1">Nama Skema <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_skema" id="nama_skema" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_skema') border-red-500 @enderror" 
                                   placeholder="Contoh: Junior Web Developer" required value="{{ old('nama_skema') }}">
                            @error('nama_skema')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bidang Kompetensi (optional) -->
                        <div>
                            <label for="id_bidang_kompetensi" class="block text-sm font-medium text-gray-700 mb-1">Bidang Kompetensi (Opsional)</label>
                            <select name="id_bidang_kompetensi" id="id_bidang_kompetensi" class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">— Pilih Bidang Kompetensi —</option>
                                @isset($bidangKompetensis)
                                @foreach($bidangKompetensis as $bk)
                                    <option value="{{ $bk->id_bidang_kompetensi }}" {{ old('id_bidang_kompetensi') == $bk->id_bidang_kompetensi ? 'selected' : '' }}>
                                        {{ $bk->nama_bidang }}
                                    </option>
                                @endforeach
                                @endisset
                            </select>
                            @error('id_bidang_kompetensi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dokumen SKKNI Field -->
                        <div>
                            <label for="dokumen_skkni" class="block text-sm font-medium text-gray-700 mb-1">Dokumen Skema</label>
                            <div class="mt-1 flex items-center">
                                <label class="w-full flex items-center justify-center px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-100 focus:outline-none">
                                    <svg class="h-6 w-6 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <span class="text-sm text-gray-600" id="file-name">Pilih file PDF</span>
                                    <input type="file" name="dokumen_skkni" id="dokumen_skkni" class="sr-only" accept=".pdf">
                                </label>
                            </div>
                            @error('dokumen_skkni')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Format file: PDF</p>
                            @enderror
                        </div>

                        <!-- Harga Field (Optional) -->
                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga Sertifikasi 
                                <span class="text-gray-500 text-xs">(Opsional)</span>
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="text" name="harga" id="harga" 
                                       class="w-full pl-12 pr-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('harga') border-red-500 @enderror"
                                       placeholder="0"
                                       value="{{ old('harga') }}">
                            </div>
                            @error('harga')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Kosongkan jika harga belum ditentukan</p>
                            @enderror
                        </div>

                        <hr class="border-gray-200">

                        <!-- Unit Kompetensi Section -->
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Pilih Unit Kompetensi</h3>
                            
                            <!-- Unit Kompetensi Field with Search -->
                            <div class="mb-4">
                                <label for="uk_search" class="block text-sm font-medium text-gray-700 mb-2">Cari Unit Kompetensi</label>
                                <div class="flex gap-3">
                                    <div class="flex-1 relative">
                                        <input 
                                            type="text" 
                                            id="uk_search" 
                                            placeholder="Ketik untuk mencari kode atau nama UK..."
                                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                            autocomplete="off"
                                        />
                                        <!-- Dropdown suggestions -->
                                        <div id="uk_suggestions" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-80 overflow-y-auto">
                                            <div class="py-3 px-4 bg-gray-50 text-xs text-gray-500 font-medium border-b border-gray-200">Cari berdasarkan kode UK atau nama UK</div>
                                            <div id="uk_suggestions_list"></div>
                                        </div>
                                    </div>
                                    <button 
                                        type="button" 
                                        id="tambahBtn" 
                                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm whitespace-nowrap"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Tambah
                                    </button>
                                </div>
                                @error('daftar_id_uk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hidden field to store selected Unit Kompetensi IDs -->
                            <input type="hidden" name="daftar_id_uk" id="daftar_id_uk_hidden" value="[]">
                            
                            <!-- Selected Unit Kompetensi Table -->
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Unit Kompetensi Terpilih:</h4>
                                <div class="border border-gray-200 rounded-md overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode UK</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama UK</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ukTableBody" class="bg-white divide-y divide-gray-200">
                                            <tr id="empty-row">
                                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada unit kompetensi yang dipilih</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Minimal satu unit kompetensi harus dipilih</p>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Persyaratan Skema Field -->
                        <div>
                            <label for="persyaratan_skema" class="block text-sm font-medium text-gray-700 mb-1">Persyaratan Skema <span class="text-red-500">*</span></label>
                            <textarea name="persyaratan_skema" id="persyaratan_skema" rows="4"
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('persyaratan_skema') border-red-500 @enderror" 
                                   placeholder="Cantumkan persyaratan untuk mengikuti skema ini...">{{ old('persyaratan_skema') }}</textarea>
                            @error('persyaratan_skema')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Simpan Skema Sertifikasi
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
    // File upload preview
    const fileInput = document.getElementById('dokumen_skkni');
    const fileLabel = document.getElementById('file-name');
    
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            fileLabel.textContent = fileInput.files[0].name;
        } else {
            fileLabel.textContent = 'Pilih file PDF';
        }
    });

    // Format harga input dengan pemisah ribuan
    const hargaInput = document.getElementById('harga');
    if (hargaInput) {
        hargaInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value) {
                e.target.value = parseInt(value).toLocaleString('id-ID');
            } else {
                e.target.value = '';
            }
        });

        const form = hargaInput.closest('form');
        form.addEventListener('submit', function() {
            if (hargaInput.value) {
                hargaInput.value = hargaInput.value.replace(/\./g, '');
            }
        });
    }

    // UK Autocomplete
    const ukData = @json($ukList);
    const searchInput = document.getElementById('uk_search');
    const suggestionsBox = document.getElementById('uk_suggestions');
    const suggestionsList = document.getElementById('uk_suggestions_list');
    let selectedUK = null;
    let currentFocus = -1;

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        currentFocus = -1;
        
        if (query.length === 0) {
            suggestionsBox.classList.add('hidden');
            return;
        }

        const filtered = ukData.filter(uk => 
            uk.kode_uk.toLowerCase().includes(query) || 
            uk.nama_uk.toLowerCase().includes(query)
        );

        if (filtered.length === 0) {
            suggestionsList.innerHTML = '<div class="py-4 px-4 text-center text-gray-400 text-sm">Tidak ada hasil ditemukan</div>';
            suggestionsBox.classList.remove('hidden');
            return;
        }

        suggestionsList.innerHTML = filtered.map(uk => `
            <div class="flex items-center gap-3 py-3 px-4 cursor-pointer transition-colors duration-150 border-b border-gray-200 hover:bg-gray-50 last:border-b-0" data-id="${uk.id_uk}" data-kode="${uk.kode_uk}" data-nama="${uk.nama_uk}">
                <span class="font-semibold text-gray-800 text-sm whitespace-nowrap">${uk.kode_uk}</span>
                <span class="text-gray-400">-</span>
                <span class="text-gray-600 text-sm flex-1 truncate">${uk.nama_uk}</span>
            </div>
        `).join('');

        suggestionsBox.classList.remove('hidden');

        // Add click handlers
        document.querySelectorAll('#uk_suggestions_list > div').forEach(item => {
            item.addEventListener('click', function() {
                selectUK(this);
            });
        });
    });

    // Keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        const items = document.querySelectorAll('#uk_suggestions_list > div');
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentFocus > -1 && items[currentFocus]) {
                selectUK(items[currentFocus]);
            }
        } else if (e.key === 'Escape') {
            suggestionsBox.classList.add('hidden');
        }
    });

    function setActive(items) {
        items.forEach((item, index) => {
            item.classList.remove('bg-gray-100');
            if (index === currentFocus) {
                item.classList.add('bg-gray-100');
                item.scrollIntoView({ block: 'nearest' });
            }
        });
    }

    function selectUK(element) {
        selectedUK = {
            id: element.dataset.id,
            kode: element.dataset.kode,
            nama: element.dataset.nama
        };
        searchInput.value = `${element.dataset.kode} - ${element.dataset.nama}`;
        suggestionsBox.classList.add('hidden');
    }

    // Click outside to close
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add('hidden');
        }
    });

    // Tambahkan CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Inisialisasi array daftar UK
    const daftarUK = [];

    // Tambah UK ke tabel
    document.getElementById('tambahBtn').addEventListener('click', function() {
        if (!selectedUK) {
            alert("Pilih unit kompetensi terlebih dahulu.");
            return;
        }
        
        const id_uk = selectedUK.id;
        const kodeUK = selectedUK.kode;
        const namaUK = selectedUK.nama;

        if (daftarUK.includes(id_uk)) {
            alert("Unit kompetensi ini sudah ditambahkan.");
            return;
        }

        daftarUK.push(id_uk);
        document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarUK);

        // Sembunyikan pesan "tidak ada data"
        const emptyRow = document.getElementById('empty-row');
        if (emptyRow) {
            emptyRow.classList.add('hidden');
        }

        // Buat baris baru di tabel
        const newRow = document.createElement('tr');
        newRow.className = 'animate-fade-in hover:bg-gray-50';
        newRow.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${kodeUK}</td>
            <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">${namaUK}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button type="button" class="hapusBtn inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-md text-white transition-all" data-id="${id_uk}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </td>
        `;

        document.getElementById('ukTableBody').appendChild(newRow);

        // Reset search
        searchInput.value = '';
        selectedUK = null;
        suggestionsBox.classList.add('hidden');
    });

    // Event delegation untuk tombol hapus
    document.getElementById('ukTableBody').addEventListener('click', function(e) {
        if (e.target.closest('.hapusBtn')) {
            const button = e.target.closest('.hapusBtn');
            const row = button.closest('tr');
            const id_uk = button.getAttribute('data-id');

            // Hapus id_uk dari daftar
            const index = daftarUK.indexOf(id_uk);
            if (index !== -1) {
                daftarUK.splice(index, 1);
                
                // Update hidden input
                document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarUK);
                
                // Animasi penghapusan
                row.style.opacity = '0';
                row.style.transform = 'translateX(10px)';
                row.style.transition = 'opacity 300ms, transform 300ms';
                
                setTimeout(() => {
                    row.remove();
                    
                    // Tampilkan pesan "tidak ada data" jika tidak ada baris lagi
                    if (daftarUK.length === 0) {
                        const emptyRow = document.getElementById('empty-row');
                        if (emptyRow) {
                            emptyRow.classList.remove('hidden');
                        } else {
                            const newEmptyRow = document.createElement('tr');
                            newEmptyRow.id = 'empty-row';
                            newEmptyRow.innerHTML = `
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada unit kompetensi yang dipilih</td>
                            `;
                            document.getElementById('ukTableBody').appendChild(newEmptyRow);
                        }
                    }
                }, 300);
            }
        }
    });
});
</script>
@endsection