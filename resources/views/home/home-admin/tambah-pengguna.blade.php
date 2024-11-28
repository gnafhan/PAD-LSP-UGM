@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Pengguna - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto max-w-3xl bg-white rounded-md shadow-md border border-gray-500 p-6">
        <!-- Tombol Tambah Pengguna -->
        <div class="mb-4">
            <a href="/pengguna" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Daftar Pengguna
            </a>
        </div>

        <!-- Form Tambah Pengguna -->
        <h1 class="text-xl font-bold mb-4">Tambah Pengguna</h1>
        <form action="/simpan-pengguna" method="POST">
            @csrf
            <!-- Input Nama Pengguna -->
            <div class="mb-4  border-gray-500 pb-2">
                <label for="username" class="block text-gray-700 font-medium mb-1">Nama Pengguna</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="block w-full border border-gray-500 rounded-md p-2 placeholder-gray-400 focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="Masukkan nama pengguna" 
                    required>
            </div>
            <!-- Input Nama -->
            <div class="mb-4  border-gray-500 pb-2">
                <label for="name" class="block text-gray-700 font-medium mb-1">Nama</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="block w-full border border-gray-500 rounded-md p-2 placeholder-gray-400 focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="Masukkan nama lengkap" 
                    required>
            </div>
            <!-- Input Email -->
            <div class="mb-4  border-gray-500 pb-2">
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="block w-full border border-gray-500 rounded-md p-2 placeholder-gray-400 focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="Masukkan alamat email" 
                    required>
            </div>
            <!-- Input Peranan -->
            <div class="mb-4  border-gray-500 pb-2">
                <label for="role" class="block text-gray-700 font-medium mb-1">Peranan</label>
                <select 
                    id="role" 
                    name="role" 
                    class="block w-full border border-gray-500 rounded-md p-2 placeholder-gray-400 focus:ring focus:ring-blue-300 focus:outline-none"
                    required>
                    <option value="" disabled selected>Pilih peranan</option>
                    <option value="Admin">Admin</option>
                    <option value="Asesor">Asesor</option>
                </select>
            </div>
            <!-- Tombol Simpan -->
            <div class="flex justify-end mt-4">
                <button 
                    type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring focus:ring-blue-300">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
