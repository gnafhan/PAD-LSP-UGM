@extends('home.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="relative w-full h-screen bg-gray-50">
    <div class="flex items-center justify-center w-full h-full">
        <div class="relative w-full max-w-5xl px-6 md:px-12 py-12 bg-white bg-opacity-90 rounded-lg shadow-lg">

            <!-- Heading Section -->
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Panduan Pelaksanaan Sertifikasi</h2>

            <!-- Tabel Panduan Pelaksanaan Sertifikasi -->
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">No</th>
                        <th class="border border-gray-300 px-4 py-2">Tahapan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                        <td class="border border-gray-300 px-4 py-2">Registrasi Akun</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                        <td class="border border-gray-300 px-4 py-2">Pengisian FR.APL-01</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">3</td>
                        <td class="border border-gray-300 px-4 py-2">Briefing Asesmen</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">4</td>
                        <td class="border border-gray-300 px-4 py-2">Pelaksanaan UK</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">5</td>
                        <td class="border border-gray-300 px-4 py-2">Penilaian Oleh Asesor</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">6</td>
                        <td class="border border-gray-300 px-4 py-2">Penentuan Kelulusan</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection
