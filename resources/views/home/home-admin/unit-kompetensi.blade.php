@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto p-4">
            <h2 class="text-xl font-bold mb-4">Daftar Unit Kompetensi</h2>

            <!-- Tombol Tambah Unit Kompetensi -->
            <div class="mb-4">
                <a href="{{ route('admin.units.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Unit Kompetensi
                </a>
            </div>

            <!-- Tabel Daftar Unit Kompetensi -->
            <table class="table-auto w-full bg-white shadow-md rounded">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border">Kode UK</th>
                        <th class="px-4 py-2 border">Nama UK</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data Dummy Unit Kompetensi -->
                    <tr>
                        <td class="border px-4 py-2">UK001</td>
                        <td class="border px-4 py-2">Unit Kompetensi 1</td>
                        <td class="border px-4 py-2">
                            <a href="#" class="text-blue-500 hover:underline">Edit</a>
                            |
                            <a href="#" class="text-red-500 hover:underline">Hapus</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2">UK002</td>
                        <td class="border px-4 py-2">Unit Kompetensi 2</td>
                        <td class="border px-4 py-2">
                            <a href="#" class="text-blue-500 hover:underline">Edit</a>
                            |
                            <a href="#" class="text-red-500 hover:underline">Hapus</a>
                        </td>
                    </tr>
                    <!-- Tambahkan data unit kompetensi lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
