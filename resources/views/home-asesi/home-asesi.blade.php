@extends('home.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
  <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">Selamat Datang, Asesi</h1>
    
    <p class="text-sm text-gray-700 mb-6">Anda telah berhasil masuk sebagai asesi. 
    <br>Berikut adalah informasi penting dan tautan yang dapat membantu Anda dalam proses sertifikasi.</p>
    
    <!-- Tabel Informasi Asesi -->
    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">Informasi Anda</h2>
      <table class="min-w-full bg-white border border-gray-300">
        <thead>
          <tr class="bg-gray-200">
            <th class="border border-gray-300 px-4 py-2">Label</th>
            <th class="border border-gray-300 px-4 py-2">Informasi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="border border-gray-300 px-4 py-2">ID Peserta</td>
            <td class="border border-gray-300 px-4 py-2">12345</td>
          </tr>
          <tr>
            <td class="border border-gray-300 px-4 py-2">Email</td>
            <td class="border border-gray-300 px-4 py-2">asesi@example.com</td>
          </tr>
          <tr>
            <td class="border border-gray-300 px-4 py-2">Skema Sertifikasi</td>
            <td class="border border-gray-300 px-4 py-2">Skema Sertifikasi Contoh</td>
          </tr>
          <tr>
            <td class="border border-gray-300 px-4 py-2">Status</td>
            <td class="border border-gray-300 px-4 py-2">Aktif</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Tautan Penting dalam Bentuk Kartu -->
    <div class="mb-6">
      <h2 class="text-lg font-semibold mb-2">Tautan Penting</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-500 shadow-lg rounded-lg p-4 text-center hover:bg-blue-600 transition duration-300">
          <a href="/jadwal-uji-kompetensi" class="font-semibold text-white hover:underline">Jadwal Uji Kompetensi</a>
        </div>
        <div class="bg-blue-500 shadow-lg rounded-lg p-4 text-center hover:bg-blue-600 transition duration-300">
          <a href="/data-pengajuan" class="font-semibold text-white hover:underline">Alur Pendaftaran</a>
        </div>
        <div class="bg-red-500 shadow-lg rounded-lg p-4 text-center hover:bg-red-600 transition duration-300">
          <a href="/home" class="font-semibold text-white hover:underline">Logout</a>
        </div>
      </div>
    </div>

    <div class="flex justify-end">
        <a href="/home" class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-400">Kembali</a>
    </div>
  </div>
</div>
@endsection
