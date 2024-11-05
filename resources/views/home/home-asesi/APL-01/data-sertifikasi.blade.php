@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
<div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

    <div class="flex flex-wrap gap-2">
            <a href="/apl1/b1" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
            <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
            FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
            </div>
    </div>
    
    <div class="flex flex-wrap gap-3 mt-5">
        <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI </h2>
    </div>

    <!-- Progress Bar -->
    <div class="flex justify-between items-center mb-8">
    <!-- Update breadcrumb di sini -->
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
        <p class="text-sm text-gray-800 ml-2">Rincian Data Pemohon Sertifikasi</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">2</div>
        <p class="text-sm text-gray-800 ml-2">Data Sertifikasi</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">3</div>
        <p class="text-sm text-gray-800 ml-2">Bukti Kelengkapan Pemohon</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">4</div>
        <p class="text-sm text-gray-800 ml-2">Konfirmasi Data Asesi</p>
    </div>

</div>

    <div class="border border-gray-300 rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-4">Bagian 2 : Data Sertifikasi</h2>
        <p class="text-sm mb-6">Tuliskan Judul dan Nomor Skema Sertifikasi, Tujuan Assesmen serta Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi yang Anda ajukan untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang Anda miliki.</p>

        <!-- Certification Details -->
        <div class="border border-gray-300 rounded-lg p-4 mb-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Skema Sertifikasi</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="kkni">KKNI</option>
                    <option value="okupasi">Okupasi</option>
                    <option value="klaster">Klaster</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Judul Skema Sertifikasi</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="Frontend Developer" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nomor Skema Sertifikasi</label>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="SKM/0720/00020/2/2024/24" readonly>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tujuan Assesmen</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="sertifikasi">Sertifikasi</option>
                    <option value="pkt">Pengakuan Kompetensi Terkini '(PKT)'</option>
                    <option value="rpl">Rekognisi Pembelajaran Lampau '(RPL)'</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
        </div>

        <!-- Competency Table -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Daftar Unit Kompetensi</h3>
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">No.</th>
                        <th class="border border-gray-300 p-2">Kode Unit</th>
                        <th class="border border-gray-300 p-2">Judul Unit</th>
                        <th class="border border-gray-300 p-2">Jenis Standar '(Standar Khusus/Standar Internasional/SKKNI)'</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2 text-center">1</td>
                        <td class="border border-gray-300 p-2">G.890000.005.02</td>
                        <td class="border border-gray-300 p-2">Mengimplementasikan User Interface</td>
                        <td class="border border-gray-300 p-2">SKKNI</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 text-center">2</td>
                        <td class="border border-gray-300 p-2">G.456000.021.10/td>
                        <td class="border border-gray-300 p-2">Menerapkan Perintah Eksekusi Bahasa Pemrograman Berbasis Teks, Grafik, dan Multimedia</td>
                        <td class="border border-gray-300 p-2">SKKNI</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
    </div>

    
    <!-- Button Kembali dan Selanjutnya -->
    <div class="flex justify-end">
    <a href="/apl1/b3" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Selanjutnya</a>
    </div>
    </div>
</div>
</div>
@endsection
