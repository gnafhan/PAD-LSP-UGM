@extends('home-admin.layouts.layout')

@section('title', 'Event Management - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
  <div class="container mx-auto p-4">
    <!-- Tombol Tambah Event -->
    <button id="openModalBtn" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 mb-4">
      Tambah Event
    </button>

    <!-- Modal -->
    <div id="eventModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-md p-6 w-1/2">
        <h2 class="text-xl font-bold mb-4">Tambah Event</h2>
        <form>
          <div class="mb-4">
            <label for="event-name" class="block text-gray-700">Nama Event:</label>
            <input type="text" id="event-name" class="w-full p-2 border rounded-md" placeholder="EVENT-098-1238">
          </div>
          <div class="mb-4">
            <label for="start-date" class="block text-gray-700">Tanggal Mulai Event:</label>
            <input type="date" id="start-date" class="w-full p-2 border rounded-md">
          </div>
          <div class="mb-4">
            <label for="end-date" class="block text-gray-700">Tanggal Berakhir Event:</label>
            <input type="date" id="end-date" class="w-full p-2 border rounded-md">
          </div>
          <div class="mb-4">
            <label for="event-type" class="block text-gray-700">Tipe Event:</label>
            <input type="text" id="event-type" class="w-full p-2 border rounded-md">
          </div>
          <div class="mb-4">
            <label for="event-scheme" class="block text-gray-700">Nama Skema:</label>
            <div id="schemes-list">
              <input type="text" class="w-full p-2 border rounded-md mb-2" placeholder="SKM-XXXX">
            </div>
            <button type="button" class="bg-blue-500 text-white p-2 rounded">Tambah Skema</button>
          </div>
          <div class="flex justify-end">
            <button type="button" id="closeModalBtn" class="bg-red-500 text-white p-2 rounded mr-2">Batal</button>
            <button type="submit" class="bg-green-500 text-white p-2 rounded">Simpan Event</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Daftar Event -->
    <h2 class="text-xl font-bold mb-4">Daftar Event</h2>
    <table class="w-full bg-white rounded-md shadow-md">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">Tgl Event</th>
          <th class="p-2">TUK</th>
          <th class="p-2">Tipe Event</th>
          <th class="p-2">Skema</th>
          <th class="p-2">Asesor</th>
          <th class="p-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="p-2 text-center">12/12/2024</td>
          <td class="p-2">TILC</td>
          <td class="p-2">Offline</td>
          <td class="p-2">SKM-II</td>
          <td class="p-2">
            <a href="/admin5" class="bg-yellow-500 text-white p-1 rounded">Button Asesor</a>
          </td>
          <td class="p-2">
            <a href="/admin4" class="bg-blue-500 text-white p-1 rounded">Button Asesi</a>
          </td>
        </tr>
        <!-- Tambahkan baris lain sesuai kebutuhan -->
      </tbody>
    </table>
  </div>
</div>

<script>
  // JavaScript untuk menangani modal
  document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('eventModal').classList.remove('hidden');
  });

  document.getElementById('closeModalBtn').addEventListener('click', function() {
    document.getElementById('eventModal').classList.add('hidden');
  });
</script>
@endsection
