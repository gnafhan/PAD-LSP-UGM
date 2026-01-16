@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Event - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    
    .select2-container--default .select2-selection--multiple {
        border-color: #e5e7eb;
        border-radius: 0.375rem;
        min-height: 38px;
        padding: 0.25rem;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3b82f6;
        box-shadow: 0 0 0 1px #3b82f6;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e5e7eb;
        border: none;
        border-radius: 0.25rem;
        padding: 0.125rem 0.5rem;
        margin-right: 0.5rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: #6b7280;
        margin-right: 0.25rem;
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
                            <a href="{{ route('admin.event.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Event</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Edit Event</span>
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
                    <h1 class="text-2xl font-bold text-white">Edit Event</h1>
                    <a href="{{ route('admin.event.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
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

                <form action="{{ route('admin.event.update', $event->id_event) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Row 1: Nama Event & Tipe Event -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Event Field -->
                            <div>
                                <label for="nama_event" class="block text-sm font-medium text-gray-700 mb-1">Nama Event <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_event" id="nama_event" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_event') border-red-500 @enderror" 
                                       placeholder="Masukkan nama event" required value="{{ old('nama_event', $event->nama_event) }}">
                                @error('nama_event')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipe Event Field -->
                            <div>
                                <label for="tipe_event" class="block text-sm font-medium text-gray-700 mb-1">Tipe Event <span class="text-red-500">*</span></label>
                                <select name="tipe_event" id="tipe_event" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tipe_event') border-red-500 @enderror" required>
                                    <option value="" disabled>--- Pilih Tipe Event ---</option>
                                    <option value="Regular" {{ old('tipe_event', $event->tipe_event) == 'Regular' ? 'selected' : '' }}>Regular</option>
                                    <option value="Non Reguler" {{ old('tipe_event', $event->tipe_event) == 'Non Reguler' ? 'selected' : '' }}>Non Reguler</option>
                                </select>
                                @error('tipe_event')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Metode Pelaksanaan & TUK -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Metode Pelaksanaan Field -->
                            <div>
                                <label for="metode_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Metode Pelaksanaan <span class="text-red-500">*</span></label>
                                <select name="metode_pelaksanaan" id="metode_pelaksanaan" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('metode_pelaksanaan') border-red-500 @enderror" required>
                                    <option value="" disabled>--- Pilih Metode ---</option>
                                    <option value="Online" {{ old('metode_pelaksanaan', $event->metode_pelaksanaan) == 'Online' ? 'selected' : '' }}>Online</option>
                                    <option value="Offline" {{ old('metode_pelaksanaan', $event->metode_pelaksanaan) == 'Offline' ? 'selected' : '' }}>Offline</option>
                                </select>
                                @error('metode_pelaksanaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- TUK Field -->
                            <div>
                                <label for="id_tuk" class="block text-sm font-medium text-gray-700 mb-1">Tempat Uji Kompetensi (TUK) <span class="text-red-500">*</span></label>
                                <select name="id_tuk" id="id_tuk" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('id_tuk') border-red-500 @enderror" required>
                                    <option value="" disabled>--- Pilih TUK ---</option>
                                    @foreach($tukList as $tuk)
                                        <option value="{{ $tuk->id_tuk }}" {{ old('id_tuk', $event->id_tuk) == $tuk->id_tuk ? 'selected' : '' }}>{{ $tuk->nama_tuk }}</option>
                                    @endforeach
                                </select>
                                @error('id_tuk')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Tanggal Mulai & Tanggal Berakhir -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Mulai Field -->
                            <div>
                                <label for="tanggal_mulai_event" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_mulai_event" id="tanggal_mulai_event" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_mulai_event') border-red-500 @enderror" 
                                       required value="{{ old('tanggal_mulai_event', $event->tanggal_mulai_event->format('Y-m-d')) }}">
                                @error('tanggal_mulai_event')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Berakhir Field -->
                            <div>
                                <label for="tanggal_berakhir_event" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berakhir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_berakhir_event" id="tanggal_berakhir_event" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_berakhir_event') border-red-500 @enderror" 
                                       required value="{{ old('tanggal_berakhir_event', $event->tanggal_berakhir_event->format('Y-m-d')) }}">
                                @error('tanggal_berakhir_event')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Periode Pelaksanaan & Tahun Pelaksanaan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Periode Pelaksanaan Field -->
                            <div>
                                <label for="periode_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Periode Pelaksanaan <span class="text-red-500">*</span></label>
                                <select name="periode_pelaksanaan" id="periode_pelaksanaan" 
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('periode_pelaksanaan') border-red-500 @enderror" required>
                                    <option value="" disabled>--- Pilih Periode ---</option>
                                    @for($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}" {{ old('periode_pelaksanaan', $event->periode_pelaksanaan) == $i ? 'selected' : '' }}>Periode {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('periode_pelaksanaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Pelaksanaan Field -->
                            <div>
                                <label for="tahun_pelaksanaan" class="block text-sm font-medium text-gray-700 mb-1">Tahun Pelaksanaan <span class="text-red-500">*</span></label>
                                <select name="tahun_pelaksanaan" id="tahun_pelaksanaan"
                                       class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tahun_pelaksanaan') border-red-500 @enderror" required>
                                    <option value="" disabled>--- Pilih Tahun ---</option>
                                    @php
                                        $currentYear = date('Y');
                                        $startYear = $currentYear - 2;
                                        $endYear = $currentYear + 3;
                                    @endphp
                                    @for($year = $startYear; $year <= $endYear; $year++)
                                        <option value="{{ $year }}" {{ old('tahun_pelaksanaan', $event->tahun_pelaksanaan) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                                @error('tahun_pelaksanaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Simpan Perubahan
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih skema sertifikasi",
            allowClear: true
        });

        // Validation for end date to be after start date
        $('#tanggal_mulai_event, #tanggal_berakhir_event').on('change', function() {
            var startDate = $('#tanggal_mulai_event').val();
            var endDate = $('#tanggal_berakhir_event').val();
            
            if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                alert('Tanggal berakhir harus setelah tanggal mulai');
                $('#tanggal_berakhir_event').val('');
            }
        });

        // Auto-fill tahun_pelaksanaan based on tanggal_mulai_event
        $('#tanggal_mulai_event').on('change', function() {
            var startDate = new Date($(this).val());
            if (startDate) {
                var year = startDate.getFullYear();
                $('#tahun_pelaksanaan').val(year);
            }
        });
    });
</script>
@endsection