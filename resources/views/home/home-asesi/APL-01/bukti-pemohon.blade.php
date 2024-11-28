@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

                <div class="flex flex-wrap gap-2">
                    <a href="/apl1/2" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
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
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">3</div>
                    <p class="text-sm text-gray-800 ml-2">Bukti Kelengkapan Pemohon</p>
                </div>

                <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">4</div>
                    <p class="text-sm text-gray-800 ml-2">Konfirmasi Data Asesi</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('errorSession'))
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    {{ session('errorSession') }}
                </div>
            @endif


            <!-- Judul Form -->
            <form method="POST" action="{{ route('save') }}" enctype="multipart/form-data">
                @csrf
                <div class="border border-gray-300 rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-4">Bagian 3 : Bukti Kelengkapan Pemohon</h2>
                    <p class="text-lg font-semibold mb-2">Petunjuk</p>
                    <ul class="text-sm mb-6">
                        <li>a. Hanya upload dokumen yang relevan</li>
                        <li>b. Upload hasil Kompetensi dengan keterangannya (Scan Ijazah Kompetensi, kursus, pengalaman kerja, dll yang berhubungan dengan keahlian Anda)</li>
                    </ul>

                    <!-- 3.1 Bukti Persyaratan Dasar Pemohon -->
                    <h2 class="text-lg font-semibold mb-4 text-left">3.1 Bukti Persyaratan Dasar Pemohon</h2>
                    <div class="mt-4 mb-4">
                        <label class="block text-sm font-medium text-gray-700">Jenis Kandidat Asesi</label>
                        <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Pilih Jenis Kandidat Asesi</option>
                            <option value="slta">Tenaga kerja berpendidikan minimal SLTA atau sederajat</option>
                        </select>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">NO</th>
                                <th class="border border-gray-300 px-4 py-2">Bukti Dasar</th>
                                <th class="border border-gray-300 px-4 py-2">Upload Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                                <td class="border border-gray-300 px-4 py-2">Siswa Jenjang SMK / Sederajat Semester Akhir</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input id="bukti_jenjang_siswa" name="bukti_jenjang_siswa" type="file" class="block w-full text-sm border-gray-300 rounded-md">
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                                <td class="border border-gray-300 px-4 py-2">Transkrip Nilai / Sertifikat pelatihan di bidang Skema</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input id="bukti_transkrip" name="bukti_transkrip" type="file" class="block w-full text-sm border-gray-300 rounded-md">
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                                <td class="border border-gray-300 px-4 py-2">Surat Pengalaman Kerja</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input id="bukti_pengalaman_kerja" name="bukti_pengalaman_kerja" type="file" class="block w-full text-sm border-gray-300 rounded-md">
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                                <td class="border border-gray-300 px-4 py-2">Surat Keterangan PKL/Magang</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input  id="bukti_magang" name="bukti_magang" type="file" class="block w-full text-sm border-gray-300 rounded-md">
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 3.1 Bukti Persyaratan Dasar Pemohon -->
                    <h2 class="text-lg font-semibold mb-4 text-left mt-4">3.2 Bukti Administratif</h2>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">NO</th>
                                <th class="border border-gray-300 px-4 py-2">Bukti Administratif</th>
                                <th class="border border-gray-300 px-4 py-2">Upload Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                                <td class="border border-gray-300 px-4 py-2">KTP</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input id="bukti_ktp" name="bukti_ktp" type="file" class="block w-full text-sm border-gray-300 rounded-md">
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                                <td class="border border-gray-300 px-4 py-2">Foto 3x4</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input id="bukti_foto" name="bukti_foto" type="file" class="block w-full text-sm border-gray-300 rounded-md">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end mt-4">
                    {{-- <a type="submit" href="{{ route('konfirmasi') }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Kirim</a> --}}
                    <button type="submit" id="btn-kirim" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
