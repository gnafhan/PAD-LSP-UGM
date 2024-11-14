@extends('home.layouts.layout')

@section('title', 'Forget Password - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-6">
      <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
      <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
      <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
    </div>

    <!-- Title Section -->
    <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Forget Password</h1>

    <!-- Form Section -->
    <form action="{{ route('password.email') }}" method="POST">
      @csrf

      <!-- Email Field -->
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter Email..."
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end mt-6">
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-semibold transition hover:bg-indigo-700">
          Send Link Reset Password
        </button>
      </div>

      <!-- Login Link -->
      <div class="text-center mt-6">
        <p class="text-sm text-gray-700">Remembered your password? <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium">Login</a></p>
      </div>
    </form>
  </div>
</div>
@endsection
