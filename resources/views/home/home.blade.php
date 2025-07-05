@extends('home.layouts.layout')

@section('title', 'LSP UGM - Lembaga Sertifikasi Profesi Universitas Gadjah Mada')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center bg-gradient-to-br from-sky-50 to-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-sky-500/10 to-blue-600/10"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid mt-8 sm:mt-0 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-on-scroll slide-left">
                    <h1 class="font-bricolage text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 leading-tight tracking-tight mb-6">
                        Sertifikasi Profesi
                        <span class="text-sky-600">Terpercaya</span>
                        untuk Masa Depan
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Lembaga Sertifikasi Profesi UGM memberikan sertifikasi berkualitas tinggi yang diakui BNSP untuk mahasiswa aktif, mengukuhkan kompetensi dan membuka peluang karir.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#features" class="btn-primary text-center">
                            Pelajari Lebih Lanjut
                        </a>
                        <a href="#contact" class="btn-secondary text-center">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
                
                <!-- Right Image -->
                <div class="animate-on-scroll slide-right">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-sky-400 to-blue-600 rounded-2xl transform rotate-3 scale-105 opacity-20"></div>
                        <img src="{{ asset('images/bg.jpg') }}" alt="LSP UGM Campus" class="relative rounded-2xl shadow-large w-full h-96 lg:h-[500px] object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Apa Itu LSP UGM Section -->
    <section class="section-spacing bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
            <div class="ios-card w-full max-w-3xl animate-on-scroll fade-in-up flex flex-col items-center">
                <div class="w-16 h-16 flex items-center justify-center rounded-full bg-sky-100 mb-4">
                    <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <h2 class="font-bricolage text-3xl sm:text-4xl font-bold text-sky-700 mb-4 tracking-tight text-center">
                    Apa Itu LSP UGM?
                </h2>
                <p class="text-lg sm:text-xl text-gray-800 font-inter font-normal leading-relaxed text-center">
                    Lembaga Sertifikasi Profesi Universitas Gadjah Mada (LSP UGM) adalah lembaga pionir yang memberikan sertifikasi kepada mahasiswa aktifnya. Sertifikat yang diberikan oleh LSP UGM diakui oleh Badan Nasional Sertifikasi Profesi (BNSP), mengukuhkan kualitas dan kemampuan peserta didik untuk bersaing di dunia profesional.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 animate-on-scroll fade-in-up">
                <h2 class="font-bricolage text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 mb-4 tracking-tight">
                    Mengapa Memilih LSP UGM?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kami menyediakan layanan sertifikasi profesional dengan standar tinggi dan pengakuan nasional.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card animate-on-scroll fade-in-up">
                    <div class="feature-icon w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-card-text font-bricolage text-xl font-semibold text-gray-900 mb-3 tracking-tight">
                        Diakui BNSP
                    </h3>
                    <p class="feature-card-text text-gray-600 leading-relaxed">
                        Sertifikat yang kami berikan diakui secara resmi oleh Badan Nasional Sertifikasi Profesi (BNSP) dan berlaku secara nasional.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card animate-on-scroll fade-in-up" style="animation-delay: 0.1s;">
                    <div class="feature-icon w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="feature-card-text font-bricolage text-xl font-semibold text-gray-900 mb-3 tracking-tight">
                        Standar Akademik Tinggi
                    </h3>
                    <p class="feature-card-text text-gray-600 leading-relaxed">
                        Menggunakan standar akademik UGM yang tinggi dengan asesor berpengalaman dan metodologi asesmen yang teruji.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card animate-on-scroll fade-in-up" style="animation-delay: 0.2s;">
                    <div class="feature-icon w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-card-text font-bricolage text-xl font-semibold text-gray-900 mb-3 tracking-tight">
                        Peluang Karir Luas
                    </h3>
                    <p class="feature-card-text text-gray-600 leading-relaxed">
                        Sertifikasi membuka peluang karir yang lebih luas dengan pengakuan kompetensi profesional di berbagai industri.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center animate-on-scroll fade-in-up">
                <div class="bg-white rounded-2xl shadow-medium p-8 lg:p-12">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-sky-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-sky-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                        </div>
                    </div>
                    <blockquote class="text-xl lg:text-2xl text-gray-700 mb-6 leading-relaxed">
                        "Sertifikasi dari LSP UGM telah membuka banyak peluang karir bagi saya. Proses asesmen yang profesional dan sertifikat yang diakui BNSP memberikan nilai tambah yang signifikan."
                    </blockquote>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/ronaldo.png') }}" alt="Testimonial" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div class="text-left">
                            <div class="font-inter font-semibold text-gray-900">Ahmad Ronaldo</div>
                            <div class="text-gray-600">Mahasiswa Teknik Informatika UGM</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="section-spacing bg-gradient-to-br from-sky-500 to-sky-600 flex items-center justify-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
            <div class="ios-card w-full max-w-2xl text-center animate-on-scroll fade-in-up bg-white/90 shadow-large">
                <h2 class="font-bricolage text-3xl sm:text-4xl lg:text-5xl font-bold text-sky-700 mb-6 tracking-tight">
                    Siap Memulai Perjalanan Sertifikasi?
                </h2>
                <p class="text-xl text-gray-800 font-inter font-normal mb-8 leading-relaxed">
                    Bergabunglah dengan ribuan mahasiswa yang telah memperoleh sertifikasi profesional dari LSP UGM.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dev-register') }}" class="bg-sky-500 hover:bg-sky-600 text-white font-inter font-semibold text-sm tracking-wide px-8 py-4 rounded-lg transition-all duration-300 ease-out hover:shadow-large focus:outline-none focus:ring-2 focus:ring-sky-700 focus:ring-offset-2">
                        Daftar Sekarang
                    </a>
                    <a href="#features" class="border-2 border-sky-500 text-sky-700 hover:bg-sky-50 hover:text-sky-800 font-inter font-semibold text-sm tracking-wide px-8 py-4 rounded-lg transition-all duration-300 ease-out focus:outline-none focus:ring-2 focus:ring-sky-700 focus:ring-offset-2">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
