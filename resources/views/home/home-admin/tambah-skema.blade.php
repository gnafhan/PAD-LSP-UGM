@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Skema - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Tambah Skema</h2>

        <form action="{{ route('admin.skema.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ku komen dulu karena udah otomatis kegenerate --}}
            {{-- <div class="mb-4">
                <label for="id_skema" class="block font-medium text-gray-700">ID Skema</label>
                <input type="text" name="id_skema" id="id_skema" class="w-full border border-gray-300 rounded p-2" required>
            </div>

            <div class="mb-4">
                <label for="nomor_skema" class="block font-medium text-gray-700">Nomor Skema</label>
                <input type="text" name="nomor_skema" id="nomor_skema" class="w-full border border-gray-500 rounded p-2" placeholder="NS-123" required>
            </div>

            <div class="mb-4">
                <label for="nama_skema" class="block font-medium text-gray-700">Nama Skema</label>
                <input type="text" name="nama_skema" id="nama_skema" class="w-full border border-gray-500 rounded p-2" placeholder="Contoh Nama Skema" required>
            </div>

            <div class="mb-4">
                <label for="dokumen_skkni" class="block font-medium text-gray-700">Dokumen SKKNI</label>
                <input type="file" name="dokumen_skkni" id="dokumen_skkni" class="w-full border border-gray-500 rounded p-2">
            </div>

            <div class="mb-4">
                <label for="daftar_id_uk" class="block font-medium text-gray-700">Daftar Unit Kompetensi</label>
                <select name="daftar_id_uk[]" id="daftar_id_uk" class="w-full border border-gray-300 rounded p-2" multiple required>
                    <option value="UK001">UK001 - Unit Kompetensi A</option>
                    <option value="UK002">UK002 - Unit Kompetensi B</option>
                    <option value="UK003">UK003 - Unit Kompetensi C</option>
                    <option value="UK004">UK004 - Unit Kompetensi D</option>
                    <option value="UK005">UK005 - Unit Kompetensi E</option>
                </select>
            </div>

            <input type="hidden" name="daftar_id_uk" id="daftar_id_uk_hidden">

            <div class="flex flex-wrap gap-2 mb-4">
                <button type="button" id="tambahBtn" class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">Tambah</button>
            </div>

            <table class="w-full border border-gray-200 text-sm mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 text-left font-semibold">Kode UK</th>
                        <th class="border border-gray-300 p-2 text-left font-semibold">Nama UK</th>
                        <th class="border border-gray-300 p-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody id="ukTableBody">
                </tbody>
            </table>

            <script>
                const daftarUK = []; // Array untuk menyimpan daftar kode UK yang ditambahkan

                document.getElementById('tambahBtn').addEventListener('click', function() {
                    const select = document.getElementById('daftar_id_uk');
                    const kodeUK = select.value;
                    const namaUK = select.options[select.selectedIndex].getAttribute('data-nama');

                    if (kodeUK && namaUK && !daftarUK.includes(kodeUK)) {
                        daftarUK.push(kodeUK); // Tambah kode UK ke daftar

                        // Update hidden input
                        document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarUK);

                        // Buat baris baru di tabel
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td class="border border-gray-300 p-2">${kodeUK}</td>
                            <td class="border border-gray-300 p-2">${namaUK}</td>
                            <td class="border border-gray-300 p-2">
                                <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        `;

                        document.getElementById('ukTableBody').appendChild(newRow);

                        // Clear dropdown
                        select.value = '';
                    } else {
                        alert("Pilih unit kompetensi yang belum ditambahkan.");
                    }
                });

                // Event delegation for delete buttons
                document.getElementById('ukTableBody').addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('hapusBtn')) {
                        const row = e.target.closest('tr');
                        const kodeUK = row.cells[0].innerText;

                        // Hapus kodeUK dari daftar
                        daftarUK.splice(daftarUK.indexOf(kodeUK), 1);

                        // Update hidden input
                        document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarUK);

                        // Hapus baris dari tabel
                        row.remove();
                    }
                });
            </script>


            <div class="mb-4">
                <label for="persyaratan_skema" class="block font-medium text-gray-700">Persyaratan Skema</label>
                <textarea name="persyaratan_skema" id="persyaratan_skema" class="w-full border border-gray-500 rounded p-2" rows="3" placeholder="Masukkan persyaratan untuk skema"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded font-semibold hover:bg-blue-600">Tambah Skema</button>
        </form>
    </div>
</div>
@endsection
