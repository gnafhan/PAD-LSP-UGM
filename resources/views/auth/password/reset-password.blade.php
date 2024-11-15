@extends('home.layouts.layout')

@section('title', 'Reset Password - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">

    <!-- Logo Section -->
    <div class="flex flex-col items-center mb-6">
      <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-12">
      <h2 class="text-xl font-bold text-gray-800">Lembaga Sertifikasi Profesi</h2>
      <h3 class="text-lg font-semibold text-gray-800">Universitas Gadjah Mada</h3>
    </div>

    <h1 class="text-2xl font-bold text-gray-800 text-center mb-6">Reset Password</h1>

    <!-- Reset Password Form -->
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <!-- Input Token Field -->
        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
        <div class="mb-4">
            <label for="input-token" class="block text-sm font-medium text-gray-700 mb-2">Token</label>
            <input type="text" id="input-token" name="token" placeholder="Enter Token..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Input Email Field -->
        <div class="mb-4">
            <label for="input-email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" id="input-email" name="email" placeholder="Enter Email..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- New Password Field -->
        <div class="mb-4">
            <label for="new-password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
            <input type="password" id="new-password" name="password" placeholder="Enter New Password..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Confirm Password Field -->
        <div class="mb-4">
            <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
            <input type="password" id="confirm-password" name="password_confirmation" placeholder="Enter Confirm Password..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        </div>

        <!-- Reset Password Button -->
        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-md font-semibold transition transform hover:scale-105">
            Reset Password
        </button>

        <!-- Login Link -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-700">Already have an account? <a href="/login" class="text-indigo-600 hover:text-indigo-800 font-medium">Login</a></p>
        </div>
    </form>
  </div>
</div>
@endsection
