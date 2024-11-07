@extends('home.home-admin.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="min-h-screen bg-gray-100 p-4">
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-center">Detail Pengajuan</h2>

    <form id="asesor-form" onsubmit="return saveAsesor(event)" class="bg-white p-6 rounded-md shadow-md">
      <input type="hidden" id="asesor-id">
      
      <div class="grid grid-cols-2 gap-4">
        <!-- ID PENGAJUAN -->
        <div class="mb-4">
          <label for="kode-registrasi" class="block text-gray-700">ID Pengajuan:</label>
          <input type="text" id="kode-registrasi" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- ID USER -->
        <div class="mb-4">
          <label for="nama-asesor" class="block text-gray-700">ID User:</label>
          <input type="text" id="nama-asesor" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- ID SKEMA -->
        <div class="mb-4">
          <label for="no-sertifikat" class="block text-gray-700">ID Skema:</label>
          <input type="text" id="no-sertifikat" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- SUMBER ANGGARAN -->
        <div class="mb-4">
          <label for="email-asesor" class="block text-gray-700">Sumber Anggaran:</label>
          <input type="email" id="email-asesor" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- NIK -->
        <div class="mb-4">
          <label for="alamat" class="block text-gray-700">NIK:</label>
          <input type="text" id="alamat" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- JENIS KELAMIN -->
        <div class="mb-4">
          <label for="bidang" class="block text-gray-700">Jenis Kelamin:</label>
          <input type="text" id="bidang" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Tempat Lahir -->
        <div class="mb-4">
          <label for="status-asesor" class="block text-gray-700">Tempat Lahir:</label>
          <input type="text" id="status-asesor" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-4">
          <label for="gelar-depan" class="block text-gray-700">Tanggal Lahir:</label>
          <input type="text" id="gelar-depan" class="w-full p-2 border rounded-md">
        </div>

        <!-- ALAMAT -->
        <div class="mb-4">
          <label for="gelar-belakang" class="block text-gray-700">Alamat:</label>
          <input type="text" id="gelar-belakang" class="w-full p-2 border rounded-md">
        </div>

        <!-- KODE POS -->
        <div class="mb-4">
          <label for="no-ktp" class="block text-gray-700">Kode Pos:</label>
          <input type="text" id="no-ktp" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- EMAIL -->
        <div class="mb-4">
          <label for="jenis-kelamin" class="block text-gray-700">Email:</label>
          <input type="text" id="email" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- NIM -->
        <div class="mb-4">
          <label for="pendidikan-terakhir" class="block text-gray-700">NIM:</label>
          <input type="text" id="pendidikan-terakhir" class="w-full p-2 border rounded-md">
        </div>

        <!-- NO TELP PRIBADI -->
        <div class="mb-4">
          <label for="keahlian" class="block text-gray-700">No Telepon:</label>
          <input type="text" id="keahlian" class="w-full p-2 border rounded-md">
        </div>

        <!-- Kewarganegaraan -->
        <div class="mb-4">
          <label for="tempat-lahir" class="block text-gray-700">Kewarganegaraan:</label>
          <input type="text" id="tempat-lahir" class="w-full p-2 border rounded-md">
        </div>

        <!-- FILE PORTOFOLIO PENGAJUAN -->
        <div class="mb-4">
          <label for="tanggal-lahir" class="block text-gray-700">File Portofolio:</label>
          <input type="date" id="tanggal-lahir" class="w-full p-2 border rounded-md">
        </div>

      <div class="flex justify-end mt-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function saveAsesor(event) {
    event.preventDefault();
    // Tambahkan logika untuk menyimpan data ke backend
    alert('Data asesor berhasil disimpan.');
  }
</script>
</body>
</html>
@endsection
