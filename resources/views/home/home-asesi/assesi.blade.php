@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Selamat datang, Assesi!</h1>
    <p class="text-gray-600 mb-2">Anda login jam: {{ now()->format('H:i:s') }}</p>

    <!-- Shortcuts -->
    <div class="flex flex-wrap space-x-4 mb-6">
      <a href="/forget-password" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition flex items-center space-x-2">
        <i class="fas fa-key"></i>
        <span>Ganti Password</span>
      </a>
      <a href="/home-asesi" class="bg-purple-500 text-white py-2 px-4 rounded hover:bg-purple-600 transition flex items-center space-x-2">
        <i class="fas fa-info-circle"></i>
        <span>Petunjuk</span>
      </a>
    </div>


    <!-- Event Sertifikasi yang Sudah Diikuti -->
    <div class="mb-8">
      <h2 class="text-lg font-semibold mb-2">Event Sertifikasi yang Sudah Diikuti</h2>
      <div class="overflow-x-auto">
        <table class="w-full border border-gray-300">
          <thead>
            <tr class="bg-gray-200">
              <th class="border px-4 py-2">Tanggal</th>
              <th class="border px-4 py-2">Nama Event</th>
              <th class="border px-4 py-2">TUK</th>
              <th class="border px-4 py-2">Jenis Event</th>
              <th class="border px-4 py-2">Nomor Peserta</th>
              <th class="border px-4 py-2">Skema</th>
              <th class="border px-4 py-2">Assessor</th>
              <th class="border px-4 py-2">Hasil</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border px-4 py-2">2024-05-12</td>
              <td class="border px-4 py-2">Sertifikasi Web Developer</td>
              <td class="border px-4 py-2">TUK UGM</td>
              <td class="border px-4 py-2">Online</td>
              <td class="border px-4 py-2">A12345</td>
              <td class="border px-4 py-2">Web Developer</td>
              <td class="border px-4 py-2">Dr. Assessor</td>
              <td class="border px-4 py-2">Lulus</td>
            </tr>
            <tr>
              <td colspan="8" class="border px-4 py-2 text-center">No data available in table</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Event Sertifikasi yang Diikuti -->
    <div>
      <h2 class="text-lg font-semibold mb-2">Event Sertifikasi yang Diikuti</h2>
      <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 mb-4">
          <thead>
            <tr class="bg-gray-200">
              <th class="border px-4 py-2">Tanggal</th>
              <th class="border px-4 py-2">Nama Event</th>
              <th class="border px-4 py-2">TUK</th>
              <th class="border px-4 py-2">Jenis Event</th>
              <th class="border px-4 py-2">Nomor Peserta</th>
              <th class="border px-4 py-2">Skema</th>
              <th class="border px-4 py-2">Assessor</th>
              <th class="border px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="border px-4 py-2">2024-05-15</td>
              <td class="border px-4 py-2">Data Scientist Certification</td>
              <td class="border px-4 py-2">TUK UGM 2</td>
              <td class="border px-4 py-2">Offline</td>
              <td class="border px-4 py-2">B67890</td>
              <td class="border px-4 py-2">Data Scientist</td>
              <td class="border px-4 py-2">Dr. Assessor B</td>
              <td class="border px-4 py-2">
                <button onclick="toggleActions('aksi1')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Pilih</button>
              </td>
            </tr>
            <!-- Baris untuk tombol pilih aksi -->
            <tr id="aksi1" class="hidden">
              <td colspan="8" class="border px-4 py-2">
                <div class="flex flex-wrap space-x-2 md:space-x-3">
                  <a href="/persetujuan" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 transition my-2">Persetujuan</a>
                  <a href="/apl1/1" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.APL.01</a>
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
</div>

<script>
  function toggleActions(id) {
    const row = document.getElementById(id);
    row.classList.toggle('hidden');
  }
</script>
@endsection
