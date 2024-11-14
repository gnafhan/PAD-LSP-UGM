@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="container mx-auto p-4">
            <h2 class="text-xl font-bold mb-4">Daftar Unit Kompetensi</h2>

            <!-- Tombol Tambah Unit Kompetensi -->
            <div class="mb-4">
                <a href="{{ route('admin.uk.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                    @foreach ($uk as $uk)
                    <tr>
                        <td class="border px-4 py-2">{{ $uk->kode_uk }}</td>
                        <td class="border px-4 py-2">{{ $uk->nama_uk }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.uk.edit', $uk->id_uk) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form action="{{ route('admin.uk.delete', $uk->id_uk) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
