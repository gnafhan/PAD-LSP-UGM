@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="container flex flex-col mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">Selamat datang, Assesi!</h1>
  <p class="text-gray-600 mb-2">Anda login jam: </p>

  <!-- Shortcuts -->
  <div class="flex space-x-4 mb-6">
    <a href="/forget-password" class="bg-blue-500 text-white py-2 px-4 rounded">Ganti Password</a>
    <button class="bg-gray-500 text-white py-2 px-4 rounded">Log Out</button>
    <button class="bg-green-500 text-white py-2 px-4 rounded">Exams File</button>
    <a href="/home-asesi/jadwal-uji-kompetensi" class="bg-purple-500 text-white py-2 px-4 rounded">Petunjuk</a>
  </div>

  <!-- Event Sertifikasi yang Sudah diikuti -->
  <div class="mb-8">
    <h2 class="text-lg font-semibold mb-2">Event Sertifikasi yang Sudah diikuti</h2>
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
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">12</td>
            <td class="border px-4 py-2">12</td>
          </tr>
          <tr>
            <td colspan="8" class="border px-4 py-2 text-center">No data available in table</td>
          </tr>
      </tbody>
    </table>
  </div>

  <!-- Event Sertifikasi yang diikuti -->
  <div>
    <h2 class="text-lg font-semibold mb-2">Event Sertifikasi yang diikuti</h2>
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
              <a href="/aksi" class="bg-blue-500 text-white px-2 py-1 rounded">Pilih</a>
            </td>
          </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection
