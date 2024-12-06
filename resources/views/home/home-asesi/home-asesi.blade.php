@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="min-h-screen bg-gray-100 p-6">
        <header class="bg-white shadow-md rounded-md p-4 mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-700">Dashboard Asesi</h1>
        </header>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Selamat Datang, Assesi!</h2>
            <p class="text-sm text-gray-700 mb-6">Berikut informasi profil Anda:</p>

            <!-- Tabel Informasi Asesi -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-md shadow-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="border border-gray-300 px-4 py-2 text-left">Label</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Informasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <td class="border border-gray-300 px-4 py-2 font-medium">Nama Asesi</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $asesi->nama_asesi }}</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <td class="border border-gray-300 px-4 py-2 font-medium">Email</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $asesi->email }}</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <td class="border border-gray-300 px-4 py-2 font-medium">NIM</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $asesi->nim }}</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <td class="border border-gray-300 px-4 py-2 font-medium">Skema Sertifikasi</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $asesi->skema->nomor_skema }} - {{ $asesi->skema->nama_skema }}</td>
                        </tr>
                        <tr class="hover:bg-gray-100 transition duration-150">
                            <td class="border border-gray-300 px-4 py-2 font-medium">Status</td>
                            <td class="border border-gray-300 px-4 py-2">Aktif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
