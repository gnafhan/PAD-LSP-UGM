@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
  <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">Selamat Datang, Assesi!</h1> 

    <p class="text-sm text-gray-700 mb-6">Anda telah berhasil masuk sebagai asesi.</p>
    
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
            <td class="border border-gray-300 px-4 py-2">user@example.id</td> 
          </tr>
          <tr>
            <td class="border border-gray-300 px-4 py-2">Skema Sertifikasi</td>
            <td class="border border-gray-300 px-4 py-2">Web Developer</td> 

          </tr>
          <tr>
            <td class="border border-gray-300 px-4 py-2">Status</td>
            <td class="border border-gray-300 px-4 py-2">aktif</td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
