@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Unit Kompetensi</h2>

        <form action="{{ route('admin.uk.update', $uk->id_uk) }}" method="POST" class="bg-white p-6 rounded-md shadow-md">
            @csrf
            @method('PUT')


            <div class="mb-4">
                <label for="kode_uk" class="block text-gray-700">Kode UK</label>
                <input type="text" name="kode_uk" id="kode_uk" value="{{ $uk->kode_uk }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="nama_uk" class="block text-gray-700">Nama Asesor</label>
                <input type="text" name="nama_uk" id="nama_uk" value="{{ $uk->nama_uk }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="id_bidang" class="block text-gray-700">ID Bidang</label>
                <input type="text" name="id_bidang" id="id_bidang" value="{{ $uk->id_bidang }}" class="w-full px-4 py-2 border rounded-md">
            </div>

            <div class="mb-4">
                <label for="jenis_standar" class="block text-gray-700">No Sertifikat</label>
                <input type="text" name="jenis_standar" id="jenis_standar" value="{{ $uk->jenis_standar }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
            </div>

        </form>
    </div>
</div>
@endsection
