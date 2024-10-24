@extends('home.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
  <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
    <!-- Progress Bar -->
    <div class="flex justify-between items-center mb-8">
      <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
        <p class="text-sm text-gray-800 ml-2">Data Pengajuan</p>
      </div>

      <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
      <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">2</div>
        <p class="text-sm text-gray-800 ml-2">Profil Peserta</p>
      </div>

      <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
      <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">3</div>
        <p class="text-sm text-gray-800 ml-2">Menunggu Konfirmasi</p>
      </div>

      <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
      <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">4</div>
        <p class="text-sm text-gray-800 ml-2">Dokumen Portofolio</p>
      </div>
      
      <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
      <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">5</div>
        <p class="text-sm text-gray-800 ml-2">Asesmen Mandiri</p>
      </div>
    </div>

    <!-- Form Card -->
    <div class="border border-gray-300 rounded-lg p-4">
      <h2 class="text-lg font-semibold mb-4">Data Pengajuan</h2>
      <p class="text-sm mb-6">Silahkan Pilih Jadwal Uji Kompetensi dan Sumber Anggaran</p>

      <div class="mb-4">
        <label for="skema" class="block text-sm font-medium text-gray-700">Skema</label>
        <input type="text" id="skema" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
      </div>

      <div class="mb-4">
        <label for="jadwal" class="block text-sm font-medium text-gray-700">Jadwal Uji Kompetensi</label>
        <input type="text" id="jadwal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
      </div>

      <div class="mb-6">
        <label for="anggaran" class="block text-sm font-medium text-gray-700">Sumber Anggaran</label>
        <select id="anggaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
          <option>Pilih Sumber Anggaran</option>
          <option>Anggaran Mandiri</option>
          <option>Beasiswa</option>
        </select>
      </div>

      <div class="flex justify-between">
        <a href="/home-asesi" class="bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-400">Kembali</a>
        <a href="/profile-peserta" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">Selanjutnya</a>
      </div>
    </div>
  </div>
</div>

@endsection
