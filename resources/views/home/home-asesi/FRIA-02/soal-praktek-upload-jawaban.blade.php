@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

                <div class="flex flex-wrap gap-2">
                    <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                                <i class="fas fa-arrow-left"></i> <!-- Ikon Font Awesome -->
                    </a>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                    FR.IA-02 SOAL PRAKTEK DAN UPLOAD JAWABAN
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 mt-5">
                    <h2 class="text-lg font-semibold mb-4">FR.IA-02 SOAL PRAKTEK DAN UPLOAD JAWABAN</h2>
                </div>

                <!-- Table for Assesi Questions -->
                <div class="border border-gray-300 rounded-lg p-4 mb-4 h-60"> <!-- Set height -->
                    <h3 class="font-semibold text-center">Daftar Soal Assesi</h3>
                    <table class="w-full border-collapse mt-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">ID SOAL</th>
                                <th class="border border-gray-300 px-4 py-2">Keterangan Soal</th>
                                <th class="border border-gray-300 px-4 py-2">Download/Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">SN108</td>
                                <td class="border border-gray-300 px-4 py-2">Soal Praktik Skema</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <div class="flex justify-center items-center space-x-2">
                                        <!-- Button Download -->
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 flex items-center">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </button>

                                        <!-- Form Upload -->
                                        <form action="/upload" method="POST" enctype="multipart/form-data" class="inline-block">
                                            @csrf
                                            <label for="file-upload-001" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 cursor-pointer flex items-center">
                                                <i class="fas fa-upload mr-2"></i> Upload
                                            </label>
                                            <input type="file" id="file-upload-001" name="file" class="hidden" onchange="this.form.submit()">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <!-- Bukti Tugas Prakitk -->
                <div class="border border-gray-300 rounded-lg p-4 h-60">
                    <h3 class="font-semibold text-center">Bukti Tugas Praktik</h3>
                    <table class="w-full border-collapse mt-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">ID SOAL</th>
                                <th class="border border-gray-300 px-4 py-2">Bukti Tugas Praktek</th>
                                <th class="border border-gray-300 px-4 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="border border-gray-300 px-4 py-2 text-center">No data available in table</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end mt-4">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">SAVE</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
