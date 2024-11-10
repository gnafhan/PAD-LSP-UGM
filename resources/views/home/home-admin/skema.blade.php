@extends('home.home-admin.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
<div class="container mx-auto p-4">
    <!-- Tombol Tambah Skema -->
    <button id="openModalBtn" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 mb-4">
      Tambah Skema
    </button>

    <!-- Modal -->
    <div id="schemeModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-md p-6 w-1/2">
        <h2 class="text-xl font-bold mb-4">Tambah Skema</h2>
        <form>
          <!-- Bagian untuk Menambahkan Nama Skema -->
          <div class="mb-4">
            <label for="scheme-name" class="block text-gray-700">Nama Skema:</label>
            <input type="text" id="scheme-name" class="w-full p-2 border rounded-md">
          </div>
          <!-- Bagian untuk Menambahkan Dokumen SKKNI -->
          <div class="mb-4">
            <label for="scheme-document" class="block text-gray-700">Dokumen SKKNI:</label>
            <input type="file" id="scheme-document" class="w-full p-2 border rounded-md">
          </div>
          <!-- Bagian untuk Menambahkan Unit Kompetensi -->
          <div class="mb-4">
            <label for="competency-units" class="block text-gray-700">Unit Kompetensi:</label>
            <textarea id="competency-units" rows="4" class="w-full p-2 border rounded-md" placeholder="Masukkan unit kompetensi (satu per baris)"></textarea>
          </div>
          <!-- Bagian untuk Menambahkan Gambar Skema -->
          <div class="mb-4">
            <label for="scheme-image" class="block text-gray-700">Gambar Skema:</label>
            <input type="file" id="scheme-image" class="w-full p-2 border rounded-md" accept="image/*">
          </div>

          <div class="flex justify-end">
            <button type="button" id="closeModalBtn" class="bg-red-500 text-white p-2 rounded mr-2">Batal</button>
            <button type="submit" class="bg-green-500 text-white p-2 rounded">Simpan Skema</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Tabel Daftar Skema -->
    <h2 class="text-xl font-bold mb-4">Daftar Skema</h2>
    <table class="w-full bg-white rounded-md shadow-md">
        <thead>
            <tr class="bg-gray-200">
            <th class="p-2">Nama Skema</th>
            <th class="p-2">Dokumen SKKNI</th>
            <th class="p-2">Unit Kompetensi</th>
            {{-- <th class="p-2">Gambar Skema</th> --}}
            <th class="p-2">Aksi</th>
            </tr>
        </thead>
    <tbody>
        @foreach($skema as $skema)
            <tr>
                <td class="p-2">{{ $skema->nama_skema }}</td>
                <td class="p-2">{{ $skema->dokumen_skkni }}</a></td>
                <td class="p-2">
                    @foreach($skema->unitKompetensi as $uk)
                        {{ $uk->id_uk }}: {{ $uk->nama_uk }}<br>
                    @endforeach
                </td>
                {{-- <td class="p-2"><img src="#" alt="Gambar Skema" class="h-12 w-12"></td> --}}
                <td class="p-2">
                    {{-- <button class="bg-yellow-500 text-white p-1 rounded">Edit</button>
                    <button class="bg-red-500 text-white p-1 rounded">Hapus</button> --}}
                    <a href="{{ route('admin.skema.edit', $skema->id_skema) }}" class="bg-yellow-500 text-white p-1 rounded">Edit</a>
                    <form action="{{ route('admin.skema.delete', $skema->id_skema) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-yellow-500 text-white p-1 rounded">Hapus</button>
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
  document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('schemeModal').classList.remove('hidden');
  });

  document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('schemeModal').classList.add('hidden');
  });
</script>
@endsection
