@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Pengguna - Lembaga Sertifikasi Profesi UGM')

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
                            <a href="{{ route('admin.pengguna.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Pengguna</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Tambah Pengguna</span>
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
                    <h1 class="text-2xl font-bold text-white">Tambah Pengguna Baru</h1>
                    <a href="{{ route('admin.pengguna.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
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

                <form action="{{ old('user_type') == 'admin' ? route('admin.pengguna.admin.store') : route('admin.pengguna.asesor.store') }}" 
                method="POST" id="userForm" enctype="multipart/form-data">                    @csrf
                    <div class="space-y-6">
                        <!-- Jenis Pengguna -->
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Jenis Pengguna</h3>
                            
                            <!-- User Type Field -->
                            <div class="mb-4">
                                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1">Jenis Pengguna <span class="text-red-500">*</span></label>
                                <select name="user_type" id="user_type" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('user_type') border-red-500 @enderror" 
                                       required onchange="toggleUserFields()">
                                    <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="asesor" {{ old('user_type') == 'asesor' ? 'selected' : '' }}>Asesor</option>
                                </select>
                                @error('user_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Informasi Akun -->
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Informasi Akun</h3>
                            
                            <!-- Email Field (Umum) -->
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Universitas Gadjah Mada (contoh: johndoe@mail.ugm.ac.id) <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror" 
                                       placeholder="Email pengguna" required value="{{ old('email') }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Field Admin -->
                            <div id="admin_fields">
                                <!-- Nama Admin Field -->
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror" 
                                        placeholder="Contoh: John Doe" value="{{ old('name') }}">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- No HP Admin Field -->
                                <div class="mb-4">
                                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                                    <input type="text" name="no_hp" id="no_hp" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_hp') border-red-500 @enderror" 
                                        placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="file_tanda_tangan" class="block text-sm font-medium text-gray-700 mb-1">Tanda Tangan Admin <span class="text-red-500">*</span></label>
                                    <input type="file" name="file_tanda_tangan" id="file_tanda_tangan" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('file_tanda_tangan') border-red-500 @enderror" 
                                        accept="image/png,image/jpeg,image/jpg" required>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Upload gambar tanda tangan (JPG, JPEG, atau PNG). Pastikan gambar memiliki latar belakang transparan.
                                    </p>
                                    @error('file_tanda_tangan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Field Asesor -->
                            <div id="asesor_fields" class="hidden">
                                <!-- Nama Asesor Field -->
                                <div class="mb-4">
                                    <label for="nama_asesor" class="block text-sm font-medium text-gray-700 mb-1">Nama Asesor <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_asesor" id="nama_asesor" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_asesor') border-red-500 @enderror" 
                                        placeholder="Masukkan nama lengkap asesor" value="{{ old('nama_asesor') }}">
                                    @error('nama_asesor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- No HP Asesor Field -->
                                <div class="mb-4">
                                    <label for="no_hp_asesor" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                    <input type="text" name="no_hp_asesor" id="no_hp_asesor" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_hp_asesor') border-red-500 @enderror" 
                                        placeholder="Contoh: 08123456789" value="{{ old('no_hp_asesor') }}">
                                    @error('no_hp_asesor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- No KTP Asesor Field -->
                                <div class="mb-4">
                                    <label for="no_ktp" class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP</label>
                                    <input type="text" name="no_ktp" id="no_ktp" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_ktp') border-red-500 @enderror" 
                                        placeholder="Nomor KTP" value="{{ old('no_ktp') }}">
                                    @error('no_ktp')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kode Registrasi Asesor Field -->
                                <div class="mb-4">
                                    <label for="kode_registrasi" class="block text-sm font-medium text-gray-700 mb-1">Kode Registrasi</label>
                                    <input type="text" name="kode_registrasi" id="kode_registrasi" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kode_registrasi') border-red-500 @enderror" 
                                        placeholder="Kode registrasi asesor" value="{{ old('kode_registrasi') }}">
                                    @error('kode_registrasi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- No Sertifikat BNSP Field -->
                                <div class="mb-4">
                                    <label for="no_sertifikat" class="block text-sm font-medium text-gray-700 mb-1">No. Sertifikat BNSP</label>
                                    <input type="text" name="no_sertifikat" id="no_sertifikat" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_sertifikat') border-red-500 @enderror" 
                                        placeholder="Nomor sertifikat BNSP" value="{{ old('no_sertifikat') }}">
                                    @error('no_sertifikat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- File Sertifikat BNSP Field -->
                                <div class="mb-4">
                                    <label for="file_sertifikat_asesor" class="block text-sm font-medium text-gray-700 mb-1">Sertifikat BNSP Asesor Kompetensi</label>
                                    <input type="file" name="file_sertifikat_asesor" id="file_sertifikat_asesor" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('file_sertifikat_asesor') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Format: PDF, JPG, JPEG, PNG (maksimal 2MB)
                                    </p>
                                    @error('file_sertifikat_asesor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nomor MET Asesor Field -->
                                <div class="mb-4">
                                    <label for="nomor_met" class="block text-sm font-medium text-gray-700 mb-1">Nomor MET</label>
                                    <input type="text" name="no_met" id="no_met" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_sertifikat') border-red-500 @enderror" 
                                        placeholder="Nomor MET" value="{{ old('no_met') }}">
                                    @error('no_met')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status Asesor Field -->
                                <div class="mb-4">
                                    <label for="status_asesor" class="block text-sm font-medium text-gray-700 mb-1">Status Asesor <span class="text-red-500">*</span></label>
                                    <select name="status_asesor" id="status_asesor" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status_asesor') border-red-500 @enderror">
                                        <option value="Aktif" {{ old('status_asesor') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak" {{ old('status_asesor') == 'Tidak' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status_asesor')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Masa Berlaku Field -->
                                <div class="mb-4">
                                    <label for="masa_berlaku" class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku<span class="text-red-500">*</span></label>
                                    <input type="date" name="masa_berlaku" id="masa_berlaku" 
                                        class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('masa_berlaku') border-red-500 @enderror" 
                                        value="{{ old('masa_berlaku') }}">
                                    <p class="mt-1 text-xs text-gray-500">Masa berlaku sertifikat asesor</p>
                                    @error('masa_berlaku')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bidang Kompetensi section -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bidang Kompetensi<span class="text-red-500">*</span></label>
                                    
                                    <div class="flex space-x-2 mb-3">
                                        <select id="id_bidang" 
                                            class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="" disabled selected>Pilih Bidang Kompetensi</option>
                                            @foreach($bidangKompetensi as $bidang)
                                                <option value="{{ $bidang->id_bidang_kompetensi }}" data-nama="{{ $bidang->nama_bidang }}">
                                                    {{ $bidang->nama_bidang }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" id="tambahBidangBtn" 
                                            class="inline-flex items-center px-3 py-2 bg-blue-600 text-white border border-transparent rounded-md font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <input type="hidden" id="bidang_kompetensi_hidden" name="bidang_kompetensi" value="[]">
                                    
                                    <div class="bg-white border border-gray-200 rounded-md overflow-hidden">
                                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                            <h4 class="text-sm font-medium text-gray-700">Bidang Kompetensi Terpilih</h4>
                                        </div>
                                        <ul id="bidangList" class="divide-y divide-gray-200 max-h-48 overflow-y-auto">
                                            <li id="empty-bidang-row" class="px-4 py-3 text-center text-sm text-gray-500 italic">
                                                Belum ada bidang kompetensi yang dipilih
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Keamanan Akun section to be replaced -->
                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 mb-4">Informasi Login</h3>
                            
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-m text-blue-800">
                                            <strong>Tentang Login:</strong> Akun ini menggunakan metode login dengan Google.
                                        </p>
                                        <p class="text-m text-blue-700 mt-1">
                                            Setelah membuat akun melalui panel admin ini (dengan mengatur Role User, seperti Asesor/Admin), pengguna hanya perlu masuk dengan akun Google UGM mereka (@mail.ugm.ac.id atau @ugm.ac.id). 
                                            Tidak perlu mengingat atau membuat password terpisah.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Simpan Pengguna Baru
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
// Tambahkan ke dalam script yang sudah ada
    function toggleUserFields() {
        const userType = document.getElementById('user_type').value;
        const adminFields = document.getElementById('admin_fields');
        const asesorFields = document.getElementById('asesor_fields');
        const form = document.getElementById('userForm');
        const fileTandaTangan = document.getElementById('file_tanda_tangan');
        
        if (userType === 'admin') {
            adminFields.classList.remove('hidden');
            asesorFields.classList.add('hidden');
            
            // Enable admin required fields
            fileTandaTangan.required = true;
            
            // Ubah action form ke route admin
            form.action = "{{ route('admin.pengguna.admin.store') }}";
            
            // Disable asesor fields validation
            document.getElementById('nama_asesor').required = false;
            document.getElementById('status_asesor').required = false;
        } else if (userType === 'asesor') {
            adminFields.classList.add('hidden');
            asesorFields.classList.remove('hidden');
            
            // Disable admin required fields
            fileTandaTangan.required = false;
            
            // Ubah action form ke route asesor
            form.action = "{{ route('admin.pengguna.asesor.store') }}";
            
            // Enable asesor fields validation
            document.getElementById('nama_asesor').required = true;
            document.getElementById('status_asesor').required = true;
        }
    }
    
    // Run on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleUserFields();
        
        // Inisialisasi array bidang kompetensi global
        window.daftarBidangKompetensi = [];
        
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
            newItem.className = 'px-4 py-3 flex justify-between items-center animate-fade-in';
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
    });
</script>
@endsection