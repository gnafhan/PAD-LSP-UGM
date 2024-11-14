@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Event - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Event</h2>

        <form action="{{ route('admin.event.update', $event->id_event) }}" method="POST" class="bg-white p-6 rounded-md shadow-md">
            @csrf
            @method('PUT')


            <div class="mb-4">
                <label for="nama_event" class="block text-gray-700">Nama Event</label>
                <input type="text" name="nama_event" id="nama_event" value="{{ $event->nama_event }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="tanggal_mulai_event" class="block text-gray-700">Tanggal Mulai Event</label>
                <input type="date" name="tanggal_mulai_event" id="tanggal_mulai_event" value="{{ $event->tanggal_mulai_event }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="tanggal_berakhir_event" class="block text-gray-700">Tanggal Berakhir Event</label>
                <input type="date" name="tanggal_berakhir_event" id="tanggal_berakhir_event" value="{{ $event->tanggal_berakhir_event }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="tipe_event" class="block text-gray-700">Tipe Event</label>
                <input type="text" name="tipe_event" id="tipe_event" value="{{ $event->tipe_event }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="tuk" class="block text-gray-700">TUK</label>
                <input type="text" name="tuk" id="tuk" value="{{ $event->tuk }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="daftar_id_skema" class="block font-medium text-gray-700">Daftar Skema</label>
                <select name="daftar_id_skema_select" id="daftar_id_skema" class="w-full border border-gray-300 rounded p-2">
                    <option value="">Pilih Skema</option>
                    @foreach($skemaList as $skema)
                        <option value="{{ $skema->nomor_skema }}" data-nama="{{ $skema->nama_skema }}">{{ $skema->nomor_skema }} - {{ $skema->nama_skema }}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="daftar_id_skema" id="daftar_id_skema_hidden">

            <div class="flex flex-wrap gap-2 mb-4">
                <button type="button" id="tambahBtn" class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">Tambah Skema</button>
            </div>

            <table class="w-full border border-gray-200 text-sm mb-4">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 text-left font-semibold">Nomor Skema</th>
                        <th class="border border-gray-300 p-2 text-left font-semibold">Nama Skema</th>
                        <th class="border border-gray-300 p-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody id="skemaTableBody">
                    @foreach(json_decode($event->daftar_id_skema, true) as $nomorSkema)
                        @php
                            $skema = $skemaList->firstWhere('nomor_skema', $nomorSkema);
                        @endphp
                        @if($skema)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $skema->nomor_skema }}</td>
                                <td class="border border-gray-300 p-2">{{ $skema->nama_skema }}</td>
                                <td class="border border-gray-300 p-2">
                                    <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    // Ambil data unit kompetensi dan daftar_id_uk dari JSON yang dikirim oleh controller
    const unitKompetensiList = {!! $unitKompetensiJson !!};
    const daftarIdUk = JSON.parse('{!! $daftarIdUkJson !!}'); // Parse JSON dari PHP

    // Fungsi untuk mengisi tabel dengan data Unit Kompetensi yang sudah ada
    function isiTabelUK() {
        const ukTableBody = document.getElementById('ukTableBody');
        ukTableBody.innerHTML = ''; // Hapus isi tabel saat ini

        // Iterasi setiap id_uk yang ada di daftarIdUk
        daftarIdUk.forEach(idUk => {
            // Cari unit kompetensi yang sesuai berdasarkan id_uk
            const uk = unitKompetensiList.find(uk => uk.id_uk === idUk);

            if (uk) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="border border-gray-300 p-2">${uk.kode_uk}</td>
                    <td class="border border-gray-300 p-2">${uk.nama_uk}</td>
                    <td class="border border-gray-300 p-2">${uk.jenis_standar}</td>
                    <td class="border border-gray-300 p-2">
                        <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </td>
                `;
                ukTableBody.appendChild(newRow);
            }
        });

        document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarIdUk);
    }

    // Panggil fungsi untuk inisialisasi tabel saat halaman di-load
    document.addEventListener('DOMContentLoaded', isiTabelUK);

    // Tambahkan unit kompetensi baru
    document.getElementById('tambahBtn').addEventListener('click', function() {
        const select = document.getElementById('daftar_id_uk');
        const idUK = select.value;
        const kodeUK = select.options[select.selectedIndex].getAttribute('data-kode');
        const namaUK = select.options[select.selectedIndex].getAttribute('data-nama');
        const jenisStandar = select.options[select.selectedIndex].getAttribute('data-jenis-standar');

        if (idUK && namaUK && !daftarIdUk.includes(idUK)) {
            daftarIdUk.push(idUK);

            // Perbarui input hidden
            document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarIdUk);

            const newRow = document.createElement('tr');
            newRow.setAttribute('data-id', idUK);
            newRow.innerHTML = `
                <td class="border border-gray-300 p-2">${kodeUK}</td>
                <td class="border border-gray-300 p-2">${namaUK}</td>
                <td class="border border-gray-300 p-2">${jenisStandar}</td>
                <td class="border border-gray-300 p-2">
                    <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </td>
            `;

            document.getElementById('ukTableBody').appendChild(newRow);
            select.value = '';
        } else {
            alert("Pilih unit kompetensi yang belum ditambahkan.");
        }
    });

    // Hapus unit kompetensi dari tabel
    document.getElementById('ukTableBody').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('hapusBtn')) {
            const row = e.target.closest('tr');
            // const kodeUK = row.cells[0].innerText;
            const idUK = row.getAttribute('data-id');

            // Hapus kode UK dari daftar
            daftarIdUk.splice(daftarIdUk.indexOf(idUK), 1);

            // Perbarui input hidden
            document.getElementById('daftar_id_uk_hidden').value = JSON.stringify(daftarIdUk);

            // Hapus baris dari tabel
            row.remove();
        }
    });
</script>

@endsection
