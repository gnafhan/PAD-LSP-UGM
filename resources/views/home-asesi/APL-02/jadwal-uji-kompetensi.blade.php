@extends('home.layouts.layout')

@section('title', 'Jadwal Uji Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="relative w-full h-screen bg-gray-50">
    <div class="flex items-center justify-center w-full h-full">
        <div class="relative w-full max-w-5xl px-6 md:px-12 py-12 bg-white bg-opacity-90 rounded-lg shadow-lg">

            <!-- Heading Section -->
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Jadwal Uji Kompetensi</h2>

            <!-- Informasi Asesi -->
            <div class="mb-8 text-center">
                <h3 class="text-xl font-semibold">Jadwal Uji Kompetensi untuk: <span class="text-blue-600">Asesi A</span></h3>
            </div>

            <!-- Tabel Jadwal Uji Kompetensi -->
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">No</th>
                        <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                        <th class="border border-gray-300 px-4 py-2">Waktu</th>
                        <th class="border border-gray-300 px-4 py-2">Skema Sertifikasi</th>
                        <th class="border border-gray-300 px-4 py-2">Tempat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                        <td class="border border-gray-300 px-4 py-2">10 Nov 2024</td>
                        <td class="border border-gray-300 px-4 py-2">09:00 - 11:00</td>
                        <td class="border border-gray-300 px-4 py-2">Web Developer</td>
                        <td class="border border-gray-300 px-4 py-2">Ruang Uji 1</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                        <td class="border border-gray-300 px-4 py-2">11 Nov 2024</td>
                        <td class="border border-gray-300 px-4 py-2">13:00 - 15:00</td>
                        <td class="border border-gray-300 px-4 py-2">Data Scientist</td>
                        <td class="border border-gray-300 px-4 py-2">Ruang Uji 2</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">3</td>
                        <td class="border border-gray-300 px-4 py-2">12 Nov 2024</td>
                        <td class="border border-gray-300 px-4 py-2">10:00 - 12:00</td>
                        <td class="border border-gray-300 px-4 py-2">Mobile Developer</td>
                        <td class="border border-gray-300 px-4 py-2">Ruang Uji 3</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
