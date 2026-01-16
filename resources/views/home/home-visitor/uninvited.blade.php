@extends('home.layouts.layout')

@section('title', 'Akses Ditolak - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-16 mb-2">
      <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
      <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
    </div>

    <!-- Error Icon -->
    <div class="flex justify-center mb-6">
      <div class="rounded-full bg-red-100 p-4">
        <svg class="h-16 w-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
      </div>
    </div>

    <!-- Error Message -->
    <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">Akses Ditolak</h1>
    <p class="text-center text-gray-600 mb-6">
      Email Anda tidak terdaftar dalam sistem undangan sertifikasi LSP UGM.
    </p>

    <!-- Information Box -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
      <h4 class="font-bold text-yellow-900 mb-2">Mengapa ini terjadi?</h4>
      <ul class="list-disc pl-5 space-y-2 text-sm text-yellow-800">
        <li>Email Anda belum didaftarkan oleh administrator untuk mengikuti event sertifikasi</li>
        <li>Anda mungkin menggunakan email yang berbeda dari email yang menerima undangan</li>
        <li>Undangan Anda mungkin telah dicabut atau belum diproses</li>
      </ul>
    </div>

    <!-- Contact Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
      <h4 class="font-bold text-blue-900 mb-2">Apa yang harus dilakukan?</h4>
      <div class="text-sm text-blue-800 space-y-2">
        <p>Jika Anda merasa seharusnya memiliki akses, silakan hubungi administrator LSP UGM:</p>
        <div class="mt-3 space-y-1">
          <p class="flex items-center">
            <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
            </svg>
            <span class="font-medium">Email:</span>
            <a href="mailto:lsp@ugm.ac.id" class="ml-1 text-blue-600 hover:underline">lsp@ugm.ac.id</a>
          </p>
          <p class="flex items-center">
            <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
              <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
            </svg>
            <span class="font-medium">Telepon:</span>
            <span class="ml-1">(0274) 123-4567</span>
          </p>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="space-y-3">
      <a href="{{ route('login') }}" 
         class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 shadow-md hover:shadow-lg">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Kembali ke Halaman Login
      </a>
      
      <a href="https://lsp.ugm.ac.id" 
         class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Kunjungi Website LSP UGM
      </a>
    </div>

    <!-- Additional Help -->
    <div class="mt-6 text-center">
      <p class="text-xs text-gray-500">
        Pastikan Anda menggunakan email yang sama dengan yang menerima undangan sertifikasi
      </p>
    </div>
  </div>
</div>
@endsection
