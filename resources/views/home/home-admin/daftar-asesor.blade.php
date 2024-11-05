@extends('home-admin.layouts.layout')

@section('title', 'Daftar Asesor - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Daftar Asesor</h2>

        <div class="mb-4 flex justify-start">
            <a href="/form" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Tambah Asesor</a>
        </div>

        <table class="min-w-full bg-white rounded-md shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 border-b text-left text-gray-600">Kode Registrasi</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">Nama Asesor</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">No Sertifikat</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">Email</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dinamis dari database -->
                <tr class="hover:bg-gray-100 transition duration-200">
                    <td class="py-3 px-4 border-b">REG12345</td>
                    <td class="py-3 px-4 border-b">John Doe</td>
                    <td class="py-3 px-4 border-b">CERT98765</td>
                    <td class="py-3 px-4 border-b">john@example.com</td>
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-red-500 hover:underline ml-4">Hapus</a>
                    </td>
                </tr>
                <tr class="hover:bg-gray-100 transition duration-200">
                    <td class="py-3 px-4 border-b">REG67890</td>
                    <td class="py-3 px-4 border-b">Jane Smith</td>
                    <td class="py-3 px-4 border-b">CERT54321</td>
                    <td class="py-3 px-4 border-b">jane@example.com</td>
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <a href="#" class="text-red-500 hover:underline ml-4">Hapus</a>
                    </td>
                </tr>
                <!-- Tambahkan data asesor lainnya di sini -->
            </tbody>
        </table>
    </div>
</div>
@endsection
