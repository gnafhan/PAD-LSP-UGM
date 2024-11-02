@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<!-- Kontainer Utama -->
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

        <!-- Tombol Aksi -->
        <div class="flex flex-wrap gap-2">
            <a href="/aksi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
            <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                FR.APL.02 ASESMEN MANDIRI
            </div>
            <button class="bg-blue-500 text-white px-2 py-1 rounded text-sm md:text-base hover:bg-blue-700">SAVE</button>
        </div>

        <!-- Judul Halaman -->
        <h2 class="text-lg font-semibold mb-4 mt-2">FR-APL-02 ASSESMEN MANDIRI</h2>

        <!-- Struktur Tabel -->
        <div class="border border-gray-300 rounded-lg p-4 mb-6">
            <table class="w-full border-collapse border border-gray-300 text-sm mb-6">
                <tbody>
                    <tr>
                        <td colspan="2" class="border border-gray-300 p-2"><i>Panduan Assesmen Mandiri</i></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border border-gray-300 p-2 font-semibold">Skema Sertifikasi Klaster/Asesmen</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold">Judul Skema Sertifikasi</td>
                        <td class="border border-gray-300 p-2">Junior Web Developer</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold">Nomor Skema Sertifikasi</td>
                        <td class="border border-gray-300 p-2">SKM/0317/00010/2/2019/14</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold">TUK</td>
                        <td class="border border-gray-300 p-2">VOKASI UGM</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold">Nama Asesor</td>
                        <td class="border border-gray-300 p-2">Imam Fahrurrozi</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold">Nama Peserta</td>
                        <td class="border border-gray-300 p-2">Ahmad Fatha Mumtaza</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold">Hari/Tanggal</td>
                        <td class="border border-gray-300 p-2">10 November 2024</td>
                    </tr>
                </tbody>
            </table>

            <!-- Instruksi untuk Peserta -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold">Peserta diminta untuk:</h3>
                <ul class="list-disc ml-5 mb-4">
                    <li>Mempelajari Kriteria Unjuk Kerja (KUK), Batasan Variabel, Panduan Penilaian, dan Aspek Kritis seluruh Unit Kompetensi yang diminta untuk di Ases.</li>
                    <li>Melaksanakan Penilaian Mandiri secara obyektif atas sejumlah pertanyaan yang diajukan.</li>
                    <li>Mengisi bukti-bukti kompetensi yang relevan atas sejumlah pertanyaan yang dinyatakan Kompeten (bila ada).</li>
                    <li>Menandatangani form Asesmen Mandiri.</li>
                </ul>

                <!-- Bukti Kompetensi -->
                <div class="p-4 mb-4 flex flex-col gap-4">
                    <h2 class="text-lg font-semibold">Bukti Kompetensi</h2>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">Tambah</button>
                    </div>
                    <table class="w-full border border-gray-200 text-sm mb-4">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 p-2 text-left font-semibold">Bukti Portfolio yang relevan</th>
                                <th class="border border-gray-300 p-2 text-left font-semibold">Keterangan</th>
                                <th class="border border-gray-300 p-2 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 p-2 text-blue-600">
                                    <a href="#" class="hover:underline">apl2_6714627cc248a.pdf</a>
                                </td>
                                <td class="border border-gray-300 p-2">Portofolio Ahmad Fatha Mumtaza</td>
                                <td class="border border-gray-300 p-2">
                                    <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Unit Kompetensi -->
                    <h2 class="text-lg font-semibold mb-4">Unit Kompetensi</h2>
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold w-1/4">Kode Unit</td>
                            <td class="border border-gray-300 p-2">J.620100.005.02</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold">Judul Unit</td>
                            <td class="border border-gray-300 p-2">Mengimplementasikan User Interface</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border border-gray-300 p-2 font-semibold text-center">Dapatkah saya ...?</td>
                        </tr>

                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Element</th>
                            <th class="border border-gray-300 p-2 text-center">Penilaian</th>
                            <th class="border border-gray-300 p-2 text-left">Bukti-Bukti Kompetensi</th>
                        </tr>

                        <tr>
                            <td class="border border-gray-300 p-2" rowspan="4">
                                <div class="font-semibold">Mengidentifikasi rancangan user interface</div>
                                <div class="text-gray-700">Kriteria untuk kerja:</div>
                                <ul class="list-disc ml-4 text-gray-700">
                                    <li>1.1 Mengidentifikasi rancangan user interface sesuai kebutuhan.</li>
                                    <li>1.2 Mengidentifikasi Komponen user interface dialog sesuai konteks rancangan proses</li>
                                    <li>1.3 Menjelaskan Urutan dari akses komponen user interface dialog</li>
                                    <li>1.4 Mengembangkan Simulasi (mock-up) dari aplikasi yang akan dibuat</li>
                                </ul>
                            </td>
                            <td class="border border-gray-300 p-2 text-center">
                                <input type="checkbox" checked disabled class="h-4 w-4 text-blue-500" />
                            </td>
                            <td class="border border-gray-300 p-2">
                                <a href="#" class="text-blue-600 hover:underline">1. Portofolio Ahmad Fatha Mumtaza</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
