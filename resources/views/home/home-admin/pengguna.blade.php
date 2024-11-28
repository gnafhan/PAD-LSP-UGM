@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Pengguna - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto">
        <div class="mb-4">
            <a href="/tambah-pengguna" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 mb-5">
            <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
            </a>
        </div>
        <!-- Header -->
        <!-- <div class="flex justify-start items-center mb-4">
            <a href="/tambah-pengguna" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center">
                <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
            </a>
        </div> -->
        <div class="flex justify-start items-center mb-4">
        <h1 class="text-xl font-bold">Daftar Pengguna</h1>
        </div>
        <!-- Table Daftar Pengguna -->
        <table class="w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">No</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama Pengguna</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Peranan</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh Data -->
                <tr>
                    <td class="border border-gray-300 px-4 py-2">1</td>
                    <td class="border border-gray-300 px-4 py-2">belda.pramono</td>
                    <td class="border border-gray-300 px-4 py-2">Belda Putri Pramono</td>
                    <td class="border border-gray-300 px-4 py-2">belda@gmail.com</td>
                    <td class="border border-gray-300 px-4 py-2">Admin</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">Edit</button>
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                    </td>
                </tr>
                <!-- Tambahkan data dinamis di sini -->
            </tbody>
        </table>
    </div>
</div>
@endsection
