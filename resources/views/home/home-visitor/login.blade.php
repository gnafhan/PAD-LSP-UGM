@extends('home.layouts.layout')

@section('title', 'Login - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-6">
      <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
      <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
      <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Login</h1>

    <!-- Login Form -->
    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter Email..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Password Field -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter Password..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="mb-4 flex items-center">
            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember Me</label>
        </div>

        <!-- Login Button -->
        <div class="flex justify-end mt-6">
            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold transition hover:bg-indigo-700">
                Login
            </button>
        </div>

        <!-- Forgot Password Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-700">Lupa Password? <a href="/password/reset" class="text-indigo-600 hover:text-indigo-800 font-medium">Reset Password</a></p>
        </div>
    </form>

    <!-- Register Link -->
    <div class="text-center mt-6">
        <p class="text-sm text-gray-700">Belum Punya Akun? <a href="/register" class="text-indigo-600 hover:text-indigo-800 font-medium">Register</a></p>
    </div>
  </div>
</div>
@endsection
