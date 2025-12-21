@extends('home.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="relative w-full min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Hero Heading -->
        <div class="text-center mb-16">
            <h1 class="font-bricolage text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 tracking-tight mb-4">
                Panduan Pelaksanaan Sertifikasi
            </h1>
            <p class="font-inter text-lg text-gray-600 max-w-3xl mx-auto">
                Ikuti langkah-langkah berikut untuk menyelesaikan proses sertifikasi kompetensi Anda
            </p>
        </div>

        <!-- Timeline Container -->
        <div class="relative">
            <!-- Timeline Connector Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 bg-gray-200 h-full hidden lg:block"></div>
            
            <!-- Timeline Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                
                <!-- Step 1 -->
                <div class="relative group col-span-1 lg:col-start-1">
                    <div class="absolute left-0 top-0 w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center shadow-medium z-10">
                        <span class="font-inter text-white font-bold text-lg">1</span>
                    </div>
                    <div class="ml-16 bg-white rounded-2xl shadow-medium p-6 border border-gray-100 hover:shadow-large transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-3 gap-2 flex-nowrap">
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">
                                Registrasi Akun
                            </h3>
                            <span class="font-inter text-sm font-medium text-sky-500 bg-sky-50 px-3 py-1 rounded-full whitespace-nowrap flex-shrink-0">
                                Langkah 1
                            </span>
                        </div>
                        <p class="font-inter text-gray-600 leading-relaxed">
                            Buat akun baru di sistem LSP UGM dengan mengisi formulir registrasi yang tersedia. Pastikan data yang dimasukkan akurat dan lengkap.
                        </p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="relative group col-span-1 lg:col-start-2 lg:mt-16">
                    <div class="absolute left-0 top-0 w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center shadow-medium z-10">
                        <span class="font-inter text-white font-bold text-lg">2</span>
                    </div>
                    <div class="ml-16 bg-white rounded-2xl shadow-medium p-6 border border-gray-100 hover:shadow-large transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-3 gap-2 flex-nowrap">
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">
                                Pengisian FR.APL-01
                            </h3>
                            <span class="font-inter text-sm font-medium text-sky-500 bg-sky-50 px-3 py-1 rounded-full whitespace-nowrap flex-shrink-0">
                                Langkah 2
                            </span>
                        </div>
                        <p class="font-inter text-gray-600 leading-relaxed">
                            Lengkapi formulir APL-01 dengan data pribadi, riwayat pendidikan, pengalaman kerja, dan kompetensi yang dimiliki.
                        </p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="relative group col-span-1 lg:col-start-1">
                    <div class="absolute left-0 top-0 w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center shadow-medium z-10">
                        <span class="font-inter text-white font-bold text-lg">3</span>
                    </div>
                    <div class="ml-16 bg-white rounded-2xl shadow-medium p-6 border border-gray-100 hover:shadow-large transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-3 gap-2 flex-nowrap">
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">
                                Pra-Asesmen
                            </h3>
                            <span class="font-inter text-sm font-medium text-sky-500 bg-sky-50 px-3 py-1 rounded-full whitespace-nowrap flex-shrink-0">
                                Langkah 3
                            </span>
                        </div>
                        <p class="font-inter text-gray-600 leading-relaxed">
                            Ikuti sesi briefing yang diselenggarakan untuk menjelaskan proses asesmen, kriteria penilaian, dan persiapan yang diperlukan.
                        </p>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="relative group col-span-1 lg:col-start-2 lg:mt-16">
                    <div class="absolute left-0 top-0 w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center shadow-medium z-10">
                        <span class="font-inter text-white font-bold text-lg">4</span>
                    </div>
                    <div class="ml-16 bg-white rounded-2xl shadow-medium p-6 border border-gray-100 hover:shadow-large transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-3 gap-2 flex-nowrap">
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">
                                Asesmen
                            </h3>
                            <span class="font-inter text-sm font-medium text-sky-500 bg-sky-50 px-3 py-1 rounded-full whitespace-nowrap flex-shrink-0">
                                Langkah 4
                            </span>
                        </div>
                        <p class="font-inter text-gray-600 leading-relaxed">
                            Laksanakan uji kompetensi sesuai dengan jadwal yang telah ditentukan. Pastikan semua persyaratan dan dokumen pendukung telah disiapkan.
                        </p>
                    </div>
                </div>
                <!-- Step 5 -->
                <div class="relative group col-span-1 lg:col-start-1">
                    <div class="absolute left-0 top-0 w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center shadow-medium z-10">
                        <span class="font-inter text-white font-bold text-lg">5</span>
                    </div>
                    <div class="ml-16 bg-white rounded-2xl shadow-medium p-6 border border-gray-100 hover:shadow-large transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-3 gap-2 flex-nowrap">
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">
                                Penilaian Oleh Asesor
                            </h3>
                            <span class="font-inter text-sm font-medium text-sky-500 bg-sky-50 px-3 py-1 rounded-full whitespace-nowrap flex-shrink-0">
                                Langkah 5
                            </span>
                        </div>
                        <p class="font-inter text-gray-600 leading-relaxed">
                            Asesor akan melakukan penilaian terhadap kompetensi Anda berdasarkan standar yang telah ditetapkan dan memberikan feedback.
                        </p>
                    </div>
                </div>
                <!-- Step 6 -->
                <div class="relative group col-span-1 lg:col-start-2 lg:mt-16">
                    <div class="absolute left-0 top-0 w-12 h-12 bg-sky-500 rounded-full flex items-center justify-center shadow-medium z-10">
                        <span class="font-inter text-white font-bold text-lg">6</span>
                    </div>
                    <div class="ml-16 bg-white rounded-2xl shadow-medium p-6 border border-gray-100 hover:shadow-large transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-3 gap-2 flex-nowrap">
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">
                                Penentuan Kelulusan
                            </h3>
                            <span class="font-inter text-sm font-medium text-sky-500 bg-sky-50 px-3 py-1 rounded-full whitespace-nowrap flex-shrink-0">
                                Langkah 6
                            </span>
                        </div>
                        <p class="font-inter text-gray-600 leading-relaxed">
                            Setelah semua tahapan selesai, tim asesor akan menentukan kelulusan dan mengeluarkan sertifikat kompetensi bagi yang memenuhi standar.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Mobile Timeline Connector -->
            <div class="absolute left-6 top-0 w-0.5 bg-gray-200 h-full lg:hidden"></div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-16">
            <div class="bg-white rounded-2xl shadow-medium p-8 border border-gray-100 max-w-2xl mx-auto">
                <h3 class="font-bricolage text-2xl font-semibold text-gray-900 mb-4">
                    Siap Memulai Sertifikasi?
                </h3>
                <p class="font-inter text-gray-600 mb-6">
                    Ikuti panduan di atas untuk memulai perjalanan sertifikasi kompetensi Anda bersama LSP UGM.
                </p>
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-inter font-semibold rounded-xl transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                    Daftar Sekarang
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection
