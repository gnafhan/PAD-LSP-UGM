@extends('home.layouts.layout')

@section('title', 'Skema Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">

        <!-- Daftar Skema Sertifikasi -->
        <h2 class="text-xl font-bold mb-4 text-center">Daftar Skema Sertifikasi</h2>
        <table class="w-full bg-white rounded-md shadow-md">
            <!-- Pencarian -->
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari..." class="p-2 flex justify-end w-1/4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-left">No.</th>
                    <th class="p-2 text-left">Nomor / Judul Skema</th>
                    <th class="p-2 text-left">Unit dan Persyaratan</th>
                </tr>
            </thead>
            <tbody>
                <!-- Skema 1 -->
                <tr>
                    <td class="p-2 align-top">1</td>
                    <td class="p-2 text-start align-top">
                        SKM/0317/00010/2/2019/22 - Programmer <br>
                        <a href="#" class="bg-blue-500 text-white p-1 rounded">Dokumen SKKNI</a>
                    </td>
                    <td class="p-2 text-start">
                        <!-- Tombol Unit Kompetensi -->
                        <button onclick="toggleContent('unit1')" class="bg-blue-600 text-white p-2 rounded mb-2">Unit Kompetensi</button>
                        <!-- Konten Unit Kompetensi dengan tabel dummy -->
                        <div id="unit1" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">No.</th>
                                        <th class="p-2 text-left">Unit Kompetensi</th>
                                        <th class="p-2 text-left">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-2 text-center">1</td>
                                        <td class="p-2">Analisis Sistem Informasi</td>
                                        <td class="p-2">Memahami dan menganalisis kebutuhan sistem informasi.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">2</td>
                                        <td class="p-2">Pemrograman Web</td>
                                        <td class="p-2">Mengembangkan aplikasi web menggunakan teknologi modern.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tombol Persyaratan Dasar Peserta -->
                        <button onclick="toggleContent('requirement1')" class="bg-blue-600 text-white p-2 rounded mb-2 mt-4">Persyaratan Dasar Peserta</button>
                        <!-- Konten Persyaratan Dasar Peserta dengan tabel dummy -->
                        <div id="requirement1" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">No.</th>
                                        <th class="p-2 text-left">Persyaratan</th>
                                        <th class="p-2 text-left">Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-2 text-center">1</td>
                                        <td class="p-2">Lulusan SMA/SMK</td>
                                        <td class="p-2">Minimal lulusan SMA atau SMK dengan nilai memadai.</td>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">2</td>
                                        <td class="p-2">Pengalaman Kerja</td>
                                        <td class="p-2">Memiliki pengalaman kerja minimal 1 tahun di bidang terkait.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                
                <!-- Tambahkan baris lain untuk skema lainnya -->
                
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleContent(id) {
        const content = document.getElementById(id);
        content.classList.toggle('hidden');
    }
</script>
@endsection
