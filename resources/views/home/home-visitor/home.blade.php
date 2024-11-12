@extends('home.home-visitor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <img src="{{ asset('images/bg.jpg') }}" alt="Campus Background" class="w-full h-96 object-cover">
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-white text-4xl font-bold text-center">LEMBAGA SERTIFIKASI PROFESI <br> UNIVERSITAS GADJAH MADA</h1>
        </div>
    </section>

    <!-- Apa Itu LSP UGM Section -->
    <section class="py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-blue-600">Apa Itu LSP UGM?</h2>
            <p class="text-lg mt-4 text-gray-700 max-w-2xl mx-auto">
                Lembaga Sertifikasi Profesi Universitas Gadjah Mada (LSP UGM) adalah lembaga pionir yang memberikan sertifikasi kepada mahasiswa aktifnya. Sertifikat yang diberikan oleh LSP UGM adalah sertifikat yang diakui oleh Badan Nasional Sertifikasi Profesi (BNSP), mengukuhkan kualitas dan kemampuan peserta didik.
            </p>
        </div>
    </section>
@endsection
