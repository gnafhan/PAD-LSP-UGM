@extends('home-asesor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
  <div class="container flex flex-col mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Hai Asesor</h1>

    <!-- Shortcuts -->
    <div class="flex space-x-4 mb-6">
      <a href="/forget-password" class="bg-blue-500 text-white py-2 px-4 rounded">Ganti Password</a>
      <a href="/home-asesi/jadwal-uji-kompetensi" class="bg-purple-500 text-white py-2 px-4 rounded">Petunjuk</a>
    </div>

    <!-- Event Sertifikasi yang Sudah diikuti -->
    <div class="mb-8">
      <h2 class="text-lg font-semibold mb-2">Event Aktif</h2>
      <table class="w-full border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2">Tgl Event</th>
            <th class="border px-4 py-2">Nama Event</th>
            <th class="border px-4 py-2">TUK</th>
            <th class="border px-4 py-2">Type Event</th>
            <th class="border px-4 py-2">No Peserta</th>
            <th class="border px-4 py-2">Skema</th>
            <th class="border px-4 py-2">Assessor</th>
            <th class="border px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td>
              <button onclick="toggleActions('aksi2')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Pilih</button>
            </td>
          </tr>
          <!-- Baris untuk tombol pilih aksi -->
          <tr id="aksi2" class="hidden">
              <td colspan="8" class="border px-4 py-2">
                <div class="flex flex-wrap space-x-2 md:space-x-3">
                <a href="/tutup0" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2" disabled>Assesi</a>
                <a href="/tutup1" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">Surat Tugas</a>
                <a href="/tutup2" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">Absensi</a>
                <a href="/tutup3" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">BA</a>
                <a href="/frak5" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.AK-05</a>
                <a href="/persetujuan" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2" disabled>FR.AK-06</a>
                <a href="/tutup6" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2" disabled>FR.IA-05</a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Event Sertifikasi yang diikuti -->
    <div>
      <h2 class="text-lg font-semibold mb-2">Event Tutup</h2>
      <table class="w-full border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="border px-4 py-2">Tgl Event</th>
            <th class="border px-4 py-2">Nama Event</th>
            <th class="border px-4 py-2">TUK</th>
            <th class="border px-4 py-2">Type Event</th>
            <th class="border px-4 py-2">No Peserta</th>
            <th class="border px-4 py-2">Skema</th>
            <th class="border px-4 py-2">Assessor</th>
            <th class="border px-4 py-2">Aksi</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">12</td>
              <td class="border px-4 py-2">
              <button onclick="toggleActions('aksi3')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Pilih</button>
            </td>
          </tr>
          <!-- Baris untuk tombol pilih aksi -->
          <tr id="aksi3" class="hidden">
              <td colspan="8" class="border px-4 py-2">
                <div class="flex flex-wrap space-x-2 md:space-x-3">
                <a href="/tutup0" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition my-2" disabled>Assesi</a>
                <a href="/tutup1" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">Surat Tugas</a>
                <a href="/tutup2" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">Absensi</a>
                <a href="/tutup3" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">BA</a>
                <a href="/frak5" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.AK-05</a>
                <a href="/persetujuan" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition my-2" disabled>FR.AK-06</a>
                <a href="/tutup6" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition my-2" disabled>FR.IA-05</a>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  function toggleActions(id) {
    const row = document.getElementById(id);
    row.classList.toggle('hidden');
  }
</script>

@endsection
