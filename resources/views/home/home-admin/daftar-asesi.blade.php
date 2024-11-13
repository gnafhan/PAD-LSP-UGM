@extends('home.home-admin.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
  <div class="container mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Daftar Asesi</h2>
    <table class="w-full bg-white rounded-md shadow-md mb-4">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">No</th>
          <th class="p-2">Nama Calon Asesi</th>
          <th class="p-2">Tanggal Daftar</th>
          <th class="p-2">Event</th>
          <th class="p-2">Skema</th>
          <th class="p-2">Pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data Dummy -->
        <tr>
          <td class="p-2 text-center">1</td>
          <td class="p-2">Annisa</td>
          <td class="p-2 text-center">12/12/2024 15:30</td>
          <td class="p-2 text-center">EVENT-111</td>
          <td class="p-2">Junior Developer</td>
          <td class="p-2">
            <a href="/dp" class="bg-blue-500 text-white p-1 rounded">Detail Pengajuan</a>
          </td>
        </tr>
        <tr>
          <td class="p-2 text-center">2</td>
          <td class="p-2">Budi</td>
          <td class="p-2 text-center">14/12/2024 10:15</td>
          <td class="p-2 text-center">EVENT-112</td>
          <td class="p-2">Data Analyst</td>
          <td class="p-2">
            <a href="/dp" class="bg-blue-500 text-white p-1 rounded">Detail Pengajuan</a>
          </td>
        </tr>
        <tr>
          <td class="p-2 text-center">3</td>
          <td class="p-2">Citra</td>
          <td class="p-2 text-center">15/12/2024 13:00</td>
          <td class="p-2 text-center">EVENT-113</td>
          <td class="p-2">Network Engineer</td>
          <td class="p-2">
            <a href="/dp" class="bg-blue-500 text-white p-1 rounded">Detail Pengajuan</a>
          </td>
        </tr>
        <!-- Tambahkan data dummy lain sesuai kebutuhan -->
      </tbody>
    </table>

    <!-- Pagination Manual -->
    <div class="flex justify-center my-4">
      <nav aria-label="Pagination">
        <ul class="inline-flex items-center space-x-2">
          <li><a href="#" class="bg-gray-200 px-3 py-1 rounded">1</a></li>
          <li><a href="#" class="bg-gray-200 px-3 py-1 rounded">2</a></li>
          <li><a href="#" class="bg-gray-200 px-3 py-1 rounded">3</a></li>
          <!-- Tambahkan halaman lainnya sesuai kebutuhan -->
        </ul>
      </nav>
    </div>

    <div id="detail-pengajuan" class="bg-white p-4 rounded shadow-md mb-4 hidden">
      <h2 class="text-xl font-bold mb-4">Detail Pengajuan Asesi</h2>
      <p><strong>Nama Asesi:</strong> Annisa</p>
      <p><strong>Prodi:</strong> TRPL</p>
      <p><strong>Event:</strong> EVENT-111</p>
      <p><strong>Skema:</strong> Junior Developer</p>
      <button class="bg-green-500 text-white mt-4 p-2 rounded">Setujui</button>
    </div>

    <h2 class="text-xl font-bold mb-4">Assign Asesi ke Asesor</h2>
    <table class="w-full bg-white rounded-md shadow-md mb-4">
      <thead>
        <tr class="bg-gray-200">
          <th class="p-2">No</th>
          <th class="p-2">Alamat Email/Nama Asesi</th>
          <th class="p-2">Asal Prodi</th>
          <th class="p-2">Ceklist</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="p-2 text-center">1</td>
          <td class="p-2">Annisa</td>
          <td class="p-2">TRPL</td>
          <td class="p-2 text-center">
            <input type="checkbox" class="form-checkbox">
          </td>
        </tr>
        <!-- Tambahkan data dummy lain sesuai kebutuhan -->
      </tbody>
    </table>

    <!-- Dropdown Asesor di bawah tabel -->
    <div class="mb-4">
      <label for="asesor" class="block mb-2 font-semibold">Pilih Asesor:</label>
      <select id="asesor" class="w-full p-2 border rounded-md">
        <option>Asesor 1</option>
        <option>Asesor 2</option>
        <option>Asesor 3</option>
        <!-- Tambahkan opsi lain sesuai kebutuhan -->
      </select>
    </div>

    <button class="bg-green-500 text-white mt-4 p-2 rounded">Save</button>
  </div>
</div>

<script>
  function showDetail() {
    const detailSection = document.getElementById('detail-pengajuan');
    detailSection.classList.toggle('hidden');
  }
</script>
@endsection
