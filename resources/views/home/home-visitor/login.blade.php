@extends('home.layouts.layout')

@section('title', 'Login - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-32 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-8">
      <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-16 mb-2">
      <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
      <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 text-center mb-4">Selamat Datang</h1>
    <p class="text-center text-gray-600 mb-8">Silakan login menggunakan akun Google Anda</p>

    <!-- Google Login Button - More Prominent -->
    <div class="flex justify-center mb-8">
        <a href="{{ route('oauth.google') }}" class="flex items-center justify-center w-full py-3 px-6 border border-gray-300 rounded-lg shadow-md bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <img class="h-6 w-6 mr-3" src="https://www.svgrepo.com/show/355037/google.svg" alt="Google logo">
            <span>Login dengan Google</span>
        </a>
    </div>

    <!-- Important Information -->
    <div class="mb-8">
        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg shadow-sm">
            <h4 class="font-bold text-lg text-blue-900 mb-2">Penting:</h4>
            <ul class="list-disc pl-5 space-y-2">
                <li class="text-base">
                    Hanya peserta yang telah diundang oleh administrator yang dapat mengakses sistem
                </li>
                <li class="text-base">
                    Gunakan email yang sama dengan yang menerima undangan sertifikasi
                </li>
                <li class="text-base">
                    Sistem akan otomatis membuat akun saat Anda pertama kali login dengan email yang diundang
                </li>
            </ul>
        </div>
    </div>

    <!-- Help Text -->
    <div class="text-center">
        <p class="text-sm text-gray-600">Mengalami kesulitan? Silakan hubungi administrator LSP UGM</p>
    </div>
  </div>
</div>

<!-- Load SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for session messages and display SweetAlert notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#4F46E5',
            timer: 4000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#4F46E5',
            timer: 4000,
            timerProgressBar: true
        });
    @endif
});
</script>
@endsection
