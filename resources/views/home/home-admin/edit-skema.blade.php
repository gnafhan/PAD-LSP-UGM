@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Skema - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Skema</h2>

        <form action="{{ route('admin.skema.update', $skema->id_skema) }}" method="POST" class="bg-white p-6 rounded-md shadow-md">
            @csrf
            @method('PUT')


            <div class="mb-4">
                <label for="nama_skema" class="block text-gray-700">Nama Skema</label>
                <input type="text" name="nama_skema" id="nama_skema" value="{{ $skema->nama_skema }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="dokumen_skkni" class="block text-gray-700">Dokumen SKKNI</label>
                <input type="text" name="dokumen_skkni" id="dokumen_skkni" value="{{ $skema->dokumen_skkni }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="daftar_id_uk" class="block text-gray-700">Unit Kompetensi</label>
                <input type="text" name="daftar_id_uk" id="daftar_id_uk" value="{{ $skema->daftar_id_uk }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
