@extends('home.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

    <div class="relative w-full h-screen bg-gray-100">
        <img src="{{ asset('images/bg.jpg') }}" alt="Campus Background" class="absolute inset-0 w-full h-full object-cover opacity-70">
        <div class="flex items-center justify-center w-full h-full">
            <div class="relative flex flex-col items-center w-full max-w-5xl px-4 md:px-0 py-10 bg-white bg-opacity-80 rounded-lg shadow-lg">

                <!-- Item-Item Timeline -->
                <div class="grid grid-cols-1 gap-y-8 w-full md:grid-cols-2 md:gap-y-16 md:gap-x-8">

                    <!-- Item Kolom Kiri -->
                    <div class="flex flex-col items-center md:items-end space-y-8 md:space-y-16">
                        <div class="flex flex-col items-center md:flex-row md:space-x-reverse md:space-x-4 transition-transform transform hover:scale-105">
                            <div class="bg-blue-500 p-6 rounded-lg text-center w-full md:w-48 text-white font-bold shadow-md hover:shadow-xl">1. Pendaftaran & APL-01</div>
                            <div class="w-5 h-5 bg-yellow-500 rounded-full hidden md:block"></div>
                        </div>
                        <div class="flex flex-col items-center md:flex-row md:space-x-reverse md:space-x-4 transition-transform transform hover:scale-105">
                            <div class="bg-blue-500 p-6 rounded-lg text-center w-full md:w-48 text-white font-bold shadow-md hover:shadow-xl">2. Pengisian APL-02</div>
                            <div class="w-5 h-5 bg-yellow-500 rounded-full hidden md:block"></div>
                        </div>
                        <div class="flex flex-col items-center md:flex-row md:space-x-reverse md:space-x-4 transition-transform transform hover:scale-105">
                            <div class="bg-blue-500 p-6 rounded-lg text-center w-full md:w-48 text-white font-bold shadow-md hover:shadow-xl">3. Briefing Asesmen</div>
                            <div class="w-5 h-5 bg-yellow-500 rounded-full hidden md:block"></div>
                        </div>
                    </div>

                    <!-- Item Kolom Kanan -->
                    <div class="flex flex-col items-center md:items-start space-y-8 md:space-y-16">
                        <div class="flex flex-col items-center md:flex-row md:space-x-4 transition-transform transform hover:scale-105">
                            <div class="w-5 h-5 bg-yellow-500 rounded-full hidden md:block"></div>
                            <div class="bg-blue-500 p-6 rounded-lg text-center w-full md:w-48 text-white font-bold shadow-md hover:shadow-xl">4. Pelaksanaan UK</div>
                        </div>
                        <div class="flex flex-col items-center md:flex-row md:space-x-4 transition-transform transform hover:scale-105">
                            <div class="w-5 h-5 bg-yellow-500 rounded-full hidden md:block"></div>
                            <div class="bg-blue-500 p-6 rounded-lg text-center w-full md:w-48 text-white font-bold shadow-md hover:shadow-xl">5. Penilaian Oleh Asesor</div>
                        </div>
                        <div class="flex flex-col items-center md:flex-row md:space-x-4 transition-transform transform hover:scale-105">
                            <div class="w-5 h-5 bg-yellow-500 rounded-full hidden md:block"></div>
                            <div class="bg-blue-500 p-6 rounded-lg text-center w-full md:w-48 text-white font-bold shadow-md hover:shadow-xl">6. Penentuan Kelulusan</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
