@extends('home.layouts.layout')

@section('title', 'Login - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-36 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-6">
      <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
      <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
      <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Login</h1>

    <!-- Login Form -->
    <form action="{{ route('login.post') }}" method="POST" id="loginForm">
        @csrf

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            <p id="emailError" class="mt-1 text-sm text-red-600 hidden">Email harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id)</p>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- UGM Email Info -->
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-3 rounded-lg">
            <p class="text-sm">Login menggunakan email UGM resmi dengan format:</p>
            <ul class="list-disc pl-5 text-sm mt-1">
                <li>namaanda@mail.ugm.ac.id, atau</li>
                <li>namaanda@ugm.ac.id</li>
            </ul>
        </div>

        <!-- Login Button -->
        <div class="flex justify-end mt-6">
            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold transition hover:bg-indigo-700">
                Login
            </button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="text-center mt-6">
        <p class="text-sm text-gray-700">Belum Punya Akun? <a href="/dev/register" class="text-indigo-600 hover:text-indigo-800 font-medium">Register</a></p>
    </div>
  </div>
</div>

<!-- Load SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Email validation function
    function validateUGMEmail(email) {
        const ugmEmailRegex = /^[a-zA-Z0-9._%+-]+@(mail\.ugm\.ac\.id|ugm\.ac\.id)$/;
        return ugmEmailRegex.test(email);
    }

    // Form validation
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');

    loginForm.addEventListener('submit', function(event) {
        const email = emailInput.value.trim();
        
        if (!validateUGMEmail(email)) {
            event.preventDefault();
            emailError.classList.remove('hidden');
            
            Swal.fire({
                icon: 'error',
                title: 'Email Tidak Valid',
                text: 'Anda harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id)',
                confirmButtonColor: '#4F46E5'
            });
        } else {
            emailError.classList.add('hidden');
        }
    });

    // Email input validation on change
    emailInput.addEventListener('input', function() {
        const email = emailInput.value.trim();
        if (email && !validateUGMEmail(email)) {
            emailError.classList.remove('hidden');
        } else {
            emailError.classList.add('hidden');
        }
    });

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

    // Display authentication errors
    @if($errors->has('email'))
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '{{ $errors->first('email') }}',
            confirmButtonColor: '#4F46E5'
        });
    @endif
});
</script>
@endsection