@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Selamat datang, Assesi!</h1>
    <p class="text-gray-600 mb-2">Anda login jam: {{ now()->format('H:i:s') }}</p>

    <!-- Shortcuts -->
    <div class="flex flex-wrap space-x-4 mb-6">
      <a href="/forget-password" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Ganti Password</a>
      <a href="/home-asesi/jadwal-uji-kompetensi" class="bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition">Petunjuk</a>
    </div>

    <!-- Event Sertifikasi yang Sudah Diikuti -->
    <div class="mb-8">
      <h2 class="text-lg font-semibold mb-2">Event Sertifikasi yang Sudah Diikuti</h2>
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
            <th class="border px-4 py-2">Hasil</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">Event A</td>
            <td class="border px-4 py-2">TUK 1</td>
            <td class="border px-4 py-2">Type 1</td>
            <td class="border px-4 py-2">123</td>
            <td class="border px-4 py-2">Web Developer</td>
            <td class="border px-4 py-2">Assessor A</td>
            <td class="border px-4 py-2">Lulus</td>
          </tr>
          <tr>
            <td colspan="8" class="border px-4 py-2 text-center">No data available in table</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Event Sertifikasi yang Diikuti -->
    <div>
      <h2 class="text-lg font-semibold mb-2">Event Sertifikasi yang Diikuti</h2>
      <table class="w-full border border-gray-300 mb-4">
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
            <td class="border px-4 py-2">Event B</td>
            <td class="border px-4 py-2">TUK 2</td>
            <td class="border px-4 py-2">Type 2</td>
            <td class="border px-4 py-2">456</td>
            <td class="border px-4 py-2">Data Scientist</td>
            <td class="border px-4 py-2">Assessor B</td>
            <td class="border px-4 py-2">
              <button onclick="toggleActions('aksi1')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Pilih</button>
            </td>
          </tr>
          <!-- Baris untuk tombol pilih aksi -->
          <tr id="aksi1" class="hidden">
              <td colspan="8" class="border px-4 py-2">
                <div class="flex flex-wrap space-x-2 md:space-x-3">
                <a href="/persetujuan" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition my-2">Persetujuan</a>
                <a href="/apl1/b1" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.APL.01</a>
                <a href="/apl2" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.APL.02</a>
                <a href="/ak1" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.AK.01</a>
                <a href="/ia2" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.IA.02 SOAL PRAKTEK/UPLOAD JAWABAN</a>
                <a href="/ak3" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.AK.03 Umpan Balik</a>
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
