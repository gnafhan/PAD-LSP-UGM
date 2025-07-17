@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - FR.IA-02')

@section('content')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <i class="fas fa-home text-blue-600"></i>
                <a href="{{ route('asesi.index') }}" class="hover:underline text-blue-600">Home</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <span>Formulir IA.02</span>
            </div>
        </nav>

        <!-- Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clipboard-list text-white text-lg"></i>
                    <h2 class="text-xl font-bold text-white">FR.IA.02. Tugas Praktik Demonstrasi</h2>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100 text-gray-800 text-sm uppercase border-b">
                    <tr>

                        <th class="px-6 py-4 text-left"><i class="fas fa-search"></i></th>
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Kode Skema</th>
                        <th class="px-6 py-4 text-left">Skema Sertifikasi</th>
                        <th class="px-6 py-4 text-left">Tujuan Asesi</th>
                        <th class="px-6 py-4 text-left">Jadwal Pelaksanaan</th>
                        <th class="px-6 py-4 text-left">Nama Asesor</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="data-table">
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap"><a
                                    href="{{ route('ia2.detail', ['id' => $data['id_skema']]) }}"
                                    class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                <i class="fas fa-search"></i>
                            </a></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">1</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $data['nomor_skema'] }}</div>
                            <div class="text-xs text-gray-500">Kode Skema</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $data['nama_skema'] }}</div>
                            <div class="text-xs text-gray-500">Skema Sertifikasi</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $data['tujuan_asesi'] === 'Sertifikasi' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $data['tujuan_asesi'] ?: '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $data['tanggal_asesi'] ?: '—' }}</div>
                            <div class="text-xs text-gray-500">Jadwal Pelaksanaan</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $data['nama_asesor'] ?: '—' }}</div>
                            <div class="text-xs text-gray-500">Asesor</div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-sm text-gray-600">
                <p>Copyright © 2025 PT. Kirana Adhirajasa Indonesia untuk
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Jana Dharma Indonesia</a>.
                    All rights reserved.
                </p>
                <p class="mt-2">
                    <span class="font-medium">Version</span> 3.1.7
                </p>
            </div>
        </div>
    </footer>
@endsection
