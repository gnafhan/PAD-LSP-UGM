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
                <select id="skemaSelect" class="w-full border border-gray-300 rounded p-2">
                    <option value="">Pilih Skema</option>
                    @foreach($skemaList as $skema)
                        <option value="{{ $skema->id_skema }}" data-nomor="{{ $skema->nomor_skema }}" data-nama="{{ $skema->nama_skema }}">{{ $skema->nomor_skema }} - {{ $skema->nama_skema }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <input type="hidden" name="daftar_id_skema" id="daftar_id_skema_hidden"> --}}

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
                    @foreach($event->skemas as $skema)
                        <tr data-id="{{ $skema->id_skema }}">
                            <td class="border border-gray-300 p-2">{{ $skema->nomor_skema }}</td>
                            <td class="border border-gray-300 p-2">{{ $skema->nama_skema }}</td>
                            <td class="border border-gray-300 p-2">
                                <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <input type="hidden" name="daftar_id_skema" id="daftarIdSkemaHidden" value="{{ $event->skemas->pluck('id_skema')->implode(',') }}">

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('tambahBtn').addEventListener('click', function() {
        const select = document.getElementById('skemaSelect');
        const idSkema = select.value;
        const nomorSkema = select.options[select.selectedIndex]?.getAttribute('data-nomor');
        const namaSkema = select.options[select.selectedIndex]?.getAttribute('data-nama');
        const tableBody = document.getElementById('skemaTableBody');
        const hiddenInput = document.getElementById('daftarIdSkemaHidden');

        if (!idSkema || !nomorSkema || !namaSkema) {
            alert('Pilih skema terlebih dahulu.');
            return;
        }

        if ([...tableBody.querySelectorAll('tr')].some(row => row.dataset.id === idSkema)) {
            alert('Skema sudah ada di tabel.');
            return;
        }

        const newRow = document.createElement('tr');
        newRow.setAttribute('data-id', idSkema);
        newRow.innerHTML = `
            <td class="border border-gray-300 p-2">${nomorSkema}</td>
            <td class="border border-gray-300 p-2">${namaSkema}</td>
            <td class="border border-gray-300 p-2">
                <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                    <i class="fas fa-trash-alt"></i> Hapus
                </button>
            </td>
        `;
        tableBody.appendChild(newRow);

        const daftarId = hiddenInput.value ? hiddenInput.value.split(',') : [];
        daftarId.push(idSkema);
        hiddenInput.value = daftarId.join(',');
    });

    document.getElementById('skemaTableBody').addEventListener('click', function(e) {
        if (e.target.classList.contains('hapusBtn')) {
            const row = e.target.closest('tr');
            const idSkema = row.dataset.id;
            row.remove();

            const hiddenInput = document.getElementById('daftarIdSkemaHidden');
            const daftarId = hiddenInput.value.split(',').filter(id => id !== idSkema);
            hiddenInput.value = daftarId.join(',');
        }
    });
</script>

@endsection
