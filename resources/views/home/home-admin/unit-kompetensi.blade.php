@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <!-- Tombol Tambah Unit Kompetensi -->
        <div class="mb-4">
            <a href="{{ route('admin.uk.create') }}" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 mb-5">
                Tambah Unit Kompetensi
            </a>
        </div>

        <!-- Form Tambah Unit Kompetensi -->
        <div id="unitModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-white rounded-md p-6 w-1/2">
                <h2 class="text-xl font-bold mb-4">Tambah Unit Kompetensi</h2>
                <form action="{{ route('admin.uk.store') }}" method="POST">
                    @csrf
                    <!-- Input Kode Unit Kompetensi -->
                    <div class="mb-4">
                        <label for="kode-uk" class="block text-gray-700">Kode UK:</label>
                        <input type="text" id="kode-uk" name="kode_uk" class="w-full p-2 border rounded-md" required>
                    </div>
                    <!-- Input Nama Unit Kompetensi -->
                    <div class="mb-4">
                        <label for="nama-uk" class="block text-gray-700">Nama UK:</label>
                        <input type="text" id="nama-uk" name="nama_uk" class="w-full p-2 border rounded-md" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" id="closeModalBtn" class="bg-red-500 text-white p-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-green-500 text-white p-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Unit Kompetensi -->
        <h2 class="text-xl font-bold mb-4">Daftar Unit Kompetensi</h2>
        <table class="w-full bg-white rounded-md shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Kode UK</th>
                    <th class="p-2">Nama UK</th>
                    <th class="p-2">Elemen UK</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uk as $uk)
                <tr>
                    <td class="p-2">{{ $uk->kode_uk }}</td>
                    <td class="p-2">{{ $uk->nama_uk }}</td>
                    <td class="p-2">{{ $uk->elemen_uk }}</td>
                    <td class="p-2">
                        <a href="{{ route('admin.uk.edit', $uk->id_uk) }}" class="bg-blue-500 text-white p-1 rounded">Edit</a>
                        <form action="{{ route('admin.uk.delete', $uk->id_uk) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // JavaScript untuk menangani modal
    document.getElementById('openModalBtn').addEventListener('click', function () {
        document.getElementById('unitModal').classList.remove('hidden');
    });

    document.getElementById('closeModalBtn').addEventListener('click', function () {
        document.getElementById('unitModal').classList.add('hidden');
    });
</script>
@endsection
