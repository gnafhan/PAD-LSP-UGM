@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Asesor - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Asesor</h2>

        <form action="{{ route('admin.asesor.update', $asesor->id_asesor) }}" method="POST" class="bg-white p-6 rounded-md shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="kode_registrasi" class="block text-gray-700">Kode Registrasi</label>
                <input type="text" name="kode_registrasi" id="kode_registrasi" value="{{ $asesor->kode_registrasi }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="nama_asesor" class="block text-gray-700">Nama Asesor</label>
                <input type="text" name="nama_asesor" id="nama_asesor" value="{{ $asesor->nama_asesor }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="no_sertifikat" class="block text-gray-700">No Sertifikat</label>
                <input type="text" name="no_sertifikat" id="no_sertifikat" value="{{ $asesor->no_sertifikat }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ $asesor->email }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4 mt-4">
                        <label for="masa-berlaku" class="block text-gray-700">Masa Berlaku:</label>
                        <input type="date" id="masa-berlaku" name="masa_berlaku" value="{{ $asesor->masa_berlaku }}" class="w-full p-2 border-2 border-gray-500 rounded-md">
                    </div>

                    <div class="mb-4">
                        <label for="status-asesor" class="block text-gray-700">Status Asesor:</label>
                        <input type="text" name="status_asesor" id="status-asesor" value="{{ $asesor->status_asesor }}" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Aktif" required>
                    </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
