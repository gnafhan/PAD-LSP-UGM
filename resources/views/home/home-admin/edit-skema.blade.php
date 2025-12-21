@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Skema Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
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
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Edit Skema</span>
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
                    <h1 class="text-2xl font-bold text-white">Edit Skema Sertifikasi</h1>
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

                <form action="{{ route('admin.skema.update', $skema->id_skema) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Bidang Kompetensi (optional) -->
                        <div>
                            <label for="id_bidang_kompetensi" class="block text-sm font-medium text-gray-700 mb-1">Bidang Kompetensi (Opsional)</label>
                            <select name="id_bidang_kompetensi" id="id_bidang_kompetensi" class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">— Pilih Bidang Kompetensi —</option>
                                @isset($bidangKompetensis)
                                @foreach($bidangKompetensis as $bk)
                                    <option value="{{ $bk->id_bidang_kompetensi }}" {{ old('id_bidang_kompetensi', $skema->id_bidang_kompetensi) == $bk->id_bidang_kompetensi ? 'selected' : '' }}>
                                        {{ $bk->nama_bidang }}
                                    </option>
                                @endforeach
                                @endisset
                            </select>
                            @error('id_bidang_kompetensi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Nomor Skema Field -->
                        <div>
                            <label for="nomor_skema" class="block text-sm font-medium text-gray-700 mb-1">Nomor Skema <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_skema" id="nomor_skema" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nomor_skema') border-red-500 @enderror" 
                                   placeholder="Contoh: SKM-001" required value="{{ old('nomor_skema', $skema->nomor_skema) }}">
                            @error('nomor_skema')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Skema Field -->
                        <div>
                            <label for="nama_skema" class="block text-sm font-medium text-gray-700 mb-1">Nama Skema <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_skema" id="nama_skema" 
                                   class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_skema') border-red-500 @enderror" 
                                   placeholder="Contoh: Junior Web Developer" required value="{{ old('nama_skema', $skema->nama_skema) }}">
                            @error('nama_skema')
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
                                    <span class="text-sm text-gray-600" id="file-name">
                                        {{ $skema->dokumen_skkni ? basename($skema->dokumen_skkni) : 'Pilih file PDF' }}
                                    </span>
                                    <input type="file" name="dokumen_skkni" id="dokumen_skkni" class="sr-only" accept=".pdf">
                                </label>
                            </div>
                            @error('dokumen_skkni')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-sm text-gray-500">Format file: PDF</p>
                                @if($skema->dokumen_skkni)
                                <div class="mt-2 flex items-center text-sm">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <a href="{{ asset('storage/' . $skema->dokumen_skkni) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat dokumen saat ini
                                    </a>
                                </div>
                                @endif
                            @enderror
                        </div>

                        <hr class="border-gray-200">

                        <!-- Unit Kompetensi Section -->
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Pilih Unit Kompetensi</h3>
                            
                            <!-- Bidang Field -->
                            <div class="mb-4">
                                <label for="id_bidang" class="block text-sm font-medium text-gray-700 mb-1">Bidang Unit Kompetensi <span class="text-red-500">*</span></label>
                                <select name="id_bidang" id="id_bidang"
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_bidang') border-red-500 @enderror">
                                    <option value="" disabled selected>--- Pilih Bidang Unit Kompetensi ---</option>
                                    @foreach($daftarBidangUK as $bidangUK)
                                        <option value="{{ $bidangUK->id_bidang }}">
                                            {{ $bidangUK->nama_bidang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_bidang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Unit Kompetensi Field -->
                            <div class="mb-4">
                                <label for="id_uk" class="block text-sm font-medium text-gray-700 mb-1">Unit Kompetensi</label>
                                <div class="flex space-x-2">
                                    <select id="id_uk"
                                           class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="" disabled selected>Pilih Bidang Unit Kompetensi Terlebih Dahulu</option>
                                    </select>
                                    <button type="button" id="tambahBtn" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-sm">
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
                            <input type="hidden" name="daftar_id_uk" id="daftar_id_uk_hidden" value="{{ $daftarIdUkJson }}">
                            
                            <!-- Selected Unit Kompetensi Table -->
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Unit Kompetensi Terpilih:</h4>
                                <div class="border border-gray-200 rounded-md overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode UK</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama UK</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Standar</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ukTableBody" class="bg-white divide-y divide-gray-200">
                                            <!-- Tabel akan diisi oleh JavaScript -->
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
                                   placeholder="Cantumkan persyaratan untuk mengikuti skema ini...">{{ old('persyaratan_skema', $skema->persyaratan_skema) }}</textarea>
                            @error('persyaratan_skema')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Update Skema Sertifikasi
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

    // Tambahkan CSRF token untuk semua request AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Inisialisasi array daftar Unit Kompetensi
    let daftarIdUk = JSON.parse('{!! $daftarIdUkJson !!}');
    
    // Fungsi untuk mengisi tabel dengan data Unit Kompetensi yang sudah ada
    function updateUKTable() {
        const unitKompetensiList = {!! $unitKompetensiJson !!};
        const ukTableBody = document.getElementById('ukTableBody');
        ukTableBody.innerHTML = ''; // Hapus isi tabel saat ini
        
        // Iterasi setiap id_uk yang ada di daftarIdUk
        daftarIdUk.forEach(idUk => {
            // Cari unit kompetensi yang sesuai berdasarkan id_uk
            const uk = unitKompetensiList.find(uk => uk.id_uk === idUk);
            
            if (uk) {
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', uk.id_uk);
                newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${uk.kode_uk}</td>
                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">${uk.nama_uk}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${uk.jenis_standar}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button type="button" class="hapusBtn inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-md text-white transition-all" data-id="${uk.id_uk}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </td>
                `;
                ukTableBody.appendChild(newRow);
            }
        });
        
        // Update hidden input
        document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarIdUk);
        
        // Tampilkan pesan "tidak ada data" jika tidak ada baris
        if (daftarIdUk.length === 0) {
            const emptyRow = document.createElement('tr');
            emptyRow.id = 'empty-row';
            emptyRow.innerHTML = `
                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada unit kompetensi yang dipilih</td>
            `;
            ukTableBody.appendChild(emptyRow);
        }
    }
    
    // Panggil fungsi untuk inisialisasi tabel saat halaman di-load
    updateUKTable();
    
    // Dependent dropdown handling
    $('#id_bidang').change(function() {
        const id_bidang = $(this).val();
        const ukSelect = $('#id_uk');
        
        if (id_bidang) {
            $.ajax({
                url: '{{ route("admin.uk.getUK") }}',
                method: 'GET',
                data: {
                    id_bidang: id_bidang
                },
                dataType: 'json',
                beforeSend: function() {
                    ukSelect.html('<option value="" disabled selected>Loading...</option>');
                },
                success: function(data) {
                    let options = '<option value="" disabled selected>Pilih Unit Kompetensi ...</option>';
                    if (data && data.length > 0) {
                        data.forEach(function(uk) {
                            // Periksa apakah UK sudah ada di daftar
                            const isInList = daftarIdUk.includes(uk.id_uk);
                            if (!isInList) {
                                options += `<option value="${uk.id_uk}" data-kode="${uk.kode_uk}" data-nama="${uk.nama_uk}" data-jenis-standar="${uk.jenis_standar}">${uk.kode_uk} - ${uk.nama_uk}</option>`;
                            }
                        });
                    } else {
                        options = '<option value="" disabled selected>Tidak ada Unit Kompetensi</option>';
                    }
                    ukSelect.html(options);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching UK data:", error);
                    console.error("Response:", xhr.responseText);
                    ukSelect.html('<option value="" disabled selected>Error loading data</option>');
                }
            });
        } else {
            ukSelect.html('<option value="" disabled selected>Pilih Bidang Unit Kompetensi Terlebih Dahulu</option>');
        }
    });
    
    // Tambah Unit Kompetensi ke tabel
    $('#tambahBtn').click(function() {
        const select = document.getElementById('id_uk');
        if (!select.value) {
            alert("Pilih unit kompetensi terlebih dahulu.");
            return;
        }
        
        const id_uk = select.value;
        const kodeUK = select.options[select.selectedIndex].getAttribute('data-kode');
        const namaUK = select.options[select.selectedIndex].getAttribute('data-nama');
        const jenisStandar = select.options[select.selectedIndex].getAttribute('data-jenis-standar');
        
        // Periksa duplikasi
        if (daftarIdUk.includes(id_uk)) {
            alert("Unit kompetensi ini sudah ditambahkan.");
            return;
        }
        
        // Tambah ke daftar
        daftarIdUk.push(id_uk);
        
        // Sembunyikan pesan "tidak ada data" jika ada
        const emptyRow = document.getElementById('empty-row');
        if (emptyRow) {
            emptyRow.remove();
        }
        
        // Buat baris baru di tabel
        const ukTableBody = document.getElementById('ukTableBody');
        const newRow = document.createElement('tr');
        newRow.className = 'animate-fade-in';
        newRow.setAttribute('data-id', id_uk);
        newRow.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${kodeUK}</td>
            <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">${namaUK}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${jenisStandar}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button type="button" class="hapusBtn inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-md text-white transition-all" data-id="${id_uk}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </td>
        `;
        ukTableBody.appendChild(newRow);
        
        // Update hidden input
        document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarIdUk);
        
        // Reset dropdown
        select.value = '';
        
        // Refresh dropdown untuk menghapus opsi yang sudah dipilih
        $('#id_bidang').trigger('change');
    });
    
    // Event delegation untuk tombol hapus
    $('#ukTableBody').on('click', '.hapusBtn', function() {
        const id_uk = $(this).data('id');
        const row = $(this).closest('tr');
        
        // Hapus id_uk dari daftar
        const index = daftarIdUk.indexOf(id_uk);
        if (index !== -1) {
            daftarIdUk.splice(index, 1);
            
            // Update hidden input
            document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarIdUk);
            
            // Animasi penghapusan
            row.css({
                'transition': 'opacity 300ms, transform 300ms',
                'opacity': '0',
                'transform': 'translateX(10px)'
            });
            
            setTimeout(() => {
                row.remove();
                
                // Tampilkan pesan "tidak ada data" jika tidak ada baris lagi
                if (daftarIdUk.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.id = 'empty-row';
                    emptyRow.innerHTML = `
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada unit kompetensi yang dipilih</td>
                    `;
                    document.getElementById('ukTableBody').appendChild(emptyRow);
                }
                
                // Refresh dropdown jika bidang sudah dipilih
                if ($('#id_bidang').val()) {
                    $('#id_bidang').trigger('change');
                }
            }, 300);
        }
    });
});
</script>
@endsection