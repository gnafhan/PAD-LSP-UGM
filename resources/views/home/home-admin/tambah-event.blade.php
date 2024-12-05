@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Event - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Formulir Penambahan Event</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Periksa input Anda:</strong>
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah Event -->
    <form action="{{ route('admin.event.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="nama_event" class="block text-gray-700">Nama Event:</label>
        <input type="text" name="nama_event" id="nama_event" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: EVENT-098-1238" required>
      </div>

      <div class="mb-4">
        <label for="tanggal_mulai_event" class="block text-gray-700">Tanggal Mulai Event:</label>
        <input type="date" name="tanggal_mulai_event" id="tanggal_mulai_event" class="w-full p-2 border-2 border-gray-500 rounded-md" required>
      </div>

      <div class="mb-4">
        <label for="tanggal_berakhir_event" class="block text-gray-700">Tanggal Berakhir Event:</label>
        <input type="date" name="tanggal_berakhir_event" id="tanggal_berakhir_event" class="w-full p-2 border-2 border-gray-500 rounded-md" required>
      </div>

      <div class="mb-4">
        <label for="tipe_event" class="block text-gray-700">Tipe Event:</label>
        <input type="text" name="tipe_event" id="tipe_event" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Offline/Online" required>
      </div>

      <div class="mb-4">
        <label for="tuk" class="block text-gray-700">TUK:</label>
        <input type="text" name="tuk" id="tuk" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: TILC" required>
      </div>

      <div class="mb-4">
        <label for="daftar_id_skema" class="block font-medium text-gray-700">Daftar Skema</label>
        <select name="daftar_id_skema[]" id="daftar_id_skema" class="w-full border border-gray-300 rounded p-2">
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
        </tbody>
    </table>

    <script>
        const daftarSkema = []; // Array untuk menyimpan daftar skema yang ditambahkan

        document.getElementById('tambahBtn').addEventListener('click', function() {
            const select = document.getElementById('daftar_id_skema');
            const nomorSkema = select.value;
            const namaSkema = select.options[select.selectedIndex].getAttribute('data-nama');

            if (nomorSkema && namaSkema && !daftarSkema.includes(nomorSkema)) {
                daftarSkema.push(nomorSkema); // Tambah nomor skema ke daftar

                // Update hidden input
                document.getElementById('daftar_id_skema_hidden').value = JSON.stringify(daftarSkema);

                // Buat baris baru di tabel
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="border border-gray-300 p-2">${nomorSkema}</td>
                    <td class="border border-gray-300 p-2">${namaSkema}</td>
                    <td class="border border-gray-300 p-2">
                        <button type="button" class="hapusBtn bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </td>
                `;

                document.getElementById('skemaTableBody').appendChild(newRow);

                // Clear dropdown
                select.value = '';
            } else {
                alert("Pilih skema yang belum ditambahkan.");
            }
        });

        // Event delegation for delete buttons
        document.getElementById('skemaTableBody').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('hapusBtn')) {
                const row = e.target.closest('tr');
                const nomorSkema = row.cells[0].innerText;

                // Hapus nomorSkema dari daftar
                daftarSkema.splice(daftarSkema.indexOf(nomorSkema), 1);

                // Update hidden input
                document.getElementById('daftar_id_skema_hidden').value = JSON.stringify(daftarSkema);

                // Hapus baris dari tabel
                row.remove();
            }
        });
    </script>

    <div class="flex justify-end">
        <button type="submit" class="bg-green-500 text-white p-2 rounded">Simpan Event</button>
    </div>
    </form>
  </div>
</div>

<script>
  // JavaScript untuk menangani penambahan skema input
  document.getElementById('add-scheme').addEventListener('click', function() {
    var newSchemeInput = document.createElement('input');
    newSchemeInput.type = 'text';
    newSchemeInput.name = 'event_scheme[]';
    newSchemeInput.classList.add('w-full', 'p-2', 'border-2', 'border-gray-500', 'rounded-md', 'mb-2');
    newSchemeInput.placeholder = 'Contoh: SKM-XXXX';

    document.getElementById('schemes-list').appendChild(newSchemeInput);
  });
</script>

@endsection
