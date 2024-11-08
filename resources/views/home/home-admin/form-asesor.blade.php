@extends('home.home-admin.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Asesor</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="min-h-screen bg-gray-100 p-4">
  <div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-center">Form Tambah Asesor</h2>

    <form id="asesor-form" method="POST" action="{{ route('admin.asesor.store') }}" class="bg-white p-6 rounded-md shadow-md">
      @csrf
      <input type="hidden" id="asesor-id" name="id_asesor">

      <div class="grid grid-cols-2 gap-4">
        <!-- Kode Registrasi -->
        <div class="mb-4">
          <label for="kode-registrasi" class="block text-gray-700">Kode Registrasi:</label>
          <input type="text" id="kode-registrasi" name="kode_registrasi" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Nama Asesor -->
        <div class="mb-4">
          <label for="nama-asesor" class="block text-gray-700">Nama Asesor:</label>
          <input type="text" id="nama-asesor" name="nama_asesor" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- No Sertifikat -->
        <div class="mb-4">
          <label for="no-sertifikat" class="block text-gray-700">No Sertifikat:</label>
          <input type="text" id="no-sertifikat" name="no_sertifikat" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- No HP -->
        <div class="mb-4">
          <label for="no-hp" class="block text-gray-700">No HP:</label>
          <input type="text" id="no-hp" name="no_hp" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email:</label>
          <input type="email" id="email" name="email" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Alamat -->
        <div class="mb-4">
          <label for="alamat" class="block text-gray-700">Alamat:</label>
          <input type="text" id="alamat" name="alamat" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Bidang -->
        <div class="mb-4">
          <label for="bidang" class="block text-gray-700">Bidang:</label>
          <input type="text" id="bidang" name="bidang" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Status Asesor -->
        <div class="mb-4">
          <label for="status-asesor" class="block text-gray-700">Status Asesor:</label>
          <input type="text" id="status-asesor" name="status_asesor" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Gelar Depan -->
        <div class="mb-4">
          <label for="gelar-depan" class="block text-gray-700">Gelar Depan:</label>
          <input type="text" id="gelar-depan" name="gelar_depan" class="w-full p-2 border rounded-md">
        </div>

        <!-- Gelar Belakang -->
        <div class="mb-4">
          <label for="gelar-belakang" class="block text-gray-700">Gelar Belakang:</label>
          <input type="text" id="gelar-belakang" name="gelar_belakang" class="w-full p-2 border rounded-md">
        </div>

        <!-- No KTP -->
        <div class="mb-4">
          <label for="no-ktp" class="block text-gray-700">No KTP:</label>
          <input type="text" id="no-ktp" name="no_ktp" class="w-full p-2 border rounded-md" required>
        </div>

        <!-- Jenis Kelamin -->
        <div class="mb-4">
          <label for="jenis-kelamin" class="block text-gray-700">Jenis Kelamin:</label>
          <select id="jenis-kelamin" name="jenis_kelamin" class="w-full p-2 border rounded-md" required>
            <option value="">Pilih</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <!-- Pendidikan Terakhir -->
        <div class="mb-4">
          <label for="pendidikan-terakhir" class="block text-gray-700">Pendidikan Terakhir:</label>
          <input type="text" id="pendidikan-terakhir" name="pendidikan_terakhir" class="w-full p-2 border rounded-md">
        </div>

        <!-- Keahlian -->
        <div class="mb-4">
          <label for="keahlian" class="block text-gray-700">Keahlian:</label>
          <input type="text" id="keahlian" name="keahlian" class="w-full p-2 border rounded-md">
        </div>

        <!-- Tempat Lahir -->
        <div class="mb-4">
          <label for="tempat-lahir" class="block text-gray-700">Tempat Lahir:</label>
          <input type="text" id="tempat-lahir" name="tempat_lahir" class="w-full p-2 border rounded-md">
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-4">
          <label for="tanggal-lahir" class="block text-gray-700">Tanggal Lahir:</label>
          <input type="date" id="tanggal-lahir" name="tanggal_lahir" class="w-full p-2 border rounded-md">
        </div>

        <!-- Kebangsaan -->
        <div class="mb-4">
          <label for="kebangsaan" class="block text-gray-700">Kebangsaan:</label>
          <input type="text" id="kebangsaan" name="kebangsaan" class="w-full p-2 border rounded-md">
        </div>

        <!-- No Lisensi -->
        <div class="mb-4">
          <label for="no-lisensi" class="block text-gray-700">No Lisensi:</label>
          <input type="text" id="no-lisensi" name="no_lisensi" class="w-full p-2 border rounded-md">
        </div>

        <!-- Masa Berlaku -->
        <div class="mb-4">
          <label for="masa-berlaku" class="block text-gray-700">Masa Berlaku:</label>
          <input type="date" id="masa-berlaku" name="masa_berlaku" class="w-full p-2 border rounded-md">
        </div>

        <!-- Institusi Asal -->
        <div class="mb-4">
          <label for="institusi-asal" class="block text-gray-700">Institusi Asal:</label>
          <input type="text" id="institusi-asal" name="institusi_asal" class="w-full p-2 border rounded-md">
        </div>

        <!-- No Telp Institusi Asal -->
        <div class="mb-4">
          <label for="no-telp-institusi-asal" class="block text-gray-700">No Telp Institusi Asal:</label>
          <input type="text" id="no-telp-institusi-asal" name="no_telp_institusi_asal" class="w-full p-2 border rounded-md">
        </div>

        <!-- Fax Institusi Asal -->
        <div class="mb-4">
          <label for="fax-institusi-asal" class="block text-gray-700">Fax Institusi Asal:</label>
          <input type="text" id="fax-institusi-asal" name="fax_institusi_asal" class="w-full p-2 border rounded-md">
        </div>

        <!-- Email Institusi Asal -->
        <div class="mb-4">
          <label for="email-institusi-asal" class="block text-gray-700">Email Institusi Asal:</label>
          <input type="email" id="email-institusi-asal" name="email_institusi_asal" class="w-full p-2 border rounded-md">
        </div>
      </div>

      <div class="flex justify-center mt-6">
        <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-700">Tambah Asesor</button>
      </div>
    </form>
  </div>
</div>
<script>
    function saveAsesor(event) {
      event.preventDefault();
      alert('Data asesor berhasil disimpan.');
    }
  </script>
</body>
</html>
@endsection
