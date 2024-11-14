@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Formulir Penambahan Unit Kompetensi</h2>

        <form action="{{ route('admin.uk.store') }}" method="POST">
            @csrf

            {{-- gausa ya karna dah digenerate --}}
            {{-- <div class="mb-4">
                <label for="id_uk" class="block font-medium text-gray-700">ID Unit Kompetensi</label>
                <input type="text" name="id_uk" id="id_uk" class="w-full border-2 border-gray-500 rounded p-2" placeholder="Contoh: UK-001" required>
            </div> --}}

            <div class="mb-4">
                <label for="kode_uk" class="block font-medium text-gray-700">Kode Unit Kompetensi</label>
                <input type="text" name="kode_uk" id="kode_uk" class="w-full border-2 border-gray-500 rounded p-2" placeholder="Contoh: KUK-01" required>
            </div>

            <div class="mb-4">
                <label for="nama_uk" class="block font-medium text-gray-700">Nama Unit Kompetensi</label>
                <input type="text" name="nama_uk" id="nama_uk" class="w-full border-2 border-gray-500 rounded p-2" placeholder="Contoh: Pengembangan Aplikasi Web" required>
            </div>

            <div class="mb-4">
                <label for="id_bidang" class="block font-medium text-gray-700">ID Bidang</label>
                <input type="text" name="id_bidang" id="id_bidang" class="w-full border-2 border-gray-500 rounded p-2" placeholder="Contoh: B01">
            </div>

            <div class="mb-4">
                <label for="jenis_standar" class="block font-medium text-gray-700">Jenis Standar</label>
                <input type="text" name="jenis_standar" id="jenis_standar" class="w-full border-2 border-gray-500 rounded p-2" placeholder="Contoh: Standar Nasional" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded font-semibold hover:bg-blue-600">Tambah Unit Kompetensi</button>
        </form>
    </div>
</div>
@endsection
