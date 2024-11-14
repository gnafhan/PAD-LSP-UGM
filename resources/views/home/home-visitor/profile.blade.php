@extends('home.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<div class="flex justify-center items-center py-12 px-4 md:px-8 lg:px-12">
    <div class="bg-white w-full max-w-4xl p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-gray-200 pb-3 text-center">LEGAL PENDIRIAN</h1>
        <ul class="space-y-4 list-disc list-inside">
            <li class="text-lg text-gray-700">
                <span class="font-semibold">Peraturan Rektor 10 tahun 2023::</span> Lembaga Sertifikasi Profesi sebagaimana dimaksud dalam Pasal 10 huruf c merupakan unsur penunjang dan berada di bawah koordinasi serta bertanggung jawab kepada Wakil Rektor Bidang Pendidikan dan Pengajaran
            </li>
            <li class="text-lg text-gray-700">
                <span class="font-semibold">Peraturan Rektor No. 18 tahun 2023:</span>: Lembaga Sertifikasi Profesi selanjutnya disingkat LSP adalah lembaga yang melaksanakan kegiatan uji kompetensi untuk sertifikasi profesi di lingkungan UGM.
            </li>
            <li class="text-lg text-gray-700">
                <span class="font-semibold">UU Nomor 12 Tahun 2012:</span> Serifikat kompetensi sebagaimana dimaksud padaayat (1) diterbitkan oleh Perguruan Tinggi bekerjasama dengan organisasi profesi, lembaga pelatihan, atau lembaga sertifikasi yang terakreditasi kepada lulusan yang lulus uji kompetensi
            </li>
            <li class="text-lg text-gray-700">
                <span class="font-semibold">Peraturan Pemerintah Nomor 4 Tahun 2014:</span> Sertifikat profesi sebagaimana dimaksud pada ayat (1) diterbitkan oleh Perguruan Tinggi bersama dengan Kementerian, Kementerian Lain, LPNK, dan/atau Organisasi Profesi.
            <li class="text-lg text-gray-700">
                <span class="font-semibold">Permendikbud Nomor 81 tahun 2014:</span> Sertifikat Kompetensi dapat diterbitkan oleh perguruan tinggi yang pelaksanaan uji kompetensinya bekerja sama dengan organisasi profesi, lembaga pelatihan, atau lembaga sertifikasi yang terakreditasi.
            </li>
        </ul>
    </div>
</div>
<div class="flex justify-center items-center py-12 px-4 md:px-8 lg:px-12">
    <div class="bg-white w-full max-w-4xl p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-gray-200 pb-3 text-center">STRUKTUR ORGANISASI</h1>
        <img src="/images/pengurus.png" alt="Profile Organisasi">
</div>
</div>
<div class="flex justify-center items-center py-12 px-4 md:px-8 lg:px-12">
    <div class="bg-white w-full max-w-4xl p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b-2 border-gray-200 pb-3 text-center">LETAK LEMBAGA SERTIFIKASI PROFESI UGM</h1>

        <div id="map" style="width: 100%; height: 500px; border-radius: 8px;"></div>

        <script>
           var map = L.map('map', { attributionControl: false }).setView([-7.7749, 110.3748], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            var marker = L.marker([-7.7738306, 110.3724111]).addTo(map);
            marker.bindPopup(
                "<div style='text-align: center;'>" +
                "<b><a href='https://maps.app.goo.gl/1MvvKeFbT7G71AJcA' target='_blank' style='text-decoration: none; color: inherit;'>Lembaga Sertifikasi Profesi <br> Universitas Gadjah Mada</a></b>" +
                "</div>"
            ).openPopup();
        </script>
    </div>
</div>

@endsection

