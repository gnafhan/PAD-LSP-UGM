@extends('home.home-admin.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<!-- Header Tetap Melekat dengan Navbar -->
<header class="flex justify-between items-center bg-white p-4 shadow-md">
    <h1 class="text-2xl font-bold text-gray-700">Dashboard Admin</h1>
</header>

<!-- Main Content -->
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 Total Events -->
            <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300 m-4">
                <h2 class="text-lg font-semibold mb-2">Total Events</h2>
                <p class="text-4xl font-bold text-blue-500">25</p>
                <p class="text-gray-500 mt-1">Active events currently available</p>
            </div>

            <!-- Card 2 Total Skema -->
            <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300 m-4">
                <h2 class="text-lg font-semibold mb-2">Total Skema</h2>
                <p class="text-4xl font-bold text-green-500">12</p>
                <p class="text-gray-500 mt-1">Available certification schemes</p>
            </div>

            <!-- Card 3 Total Asesi -->
            <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300 m-4">
                <h2 class="text-lg font-semibold mb-2">Total Asesi</h2>
                <p class="text-4xl font-bold text-orange-500">350</p>
                <p class="text-gray-500 mt-1">Registered candidates</p>
            </div>

            <!-- Card 4 Total Asesor -->
            <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300 m-4">
                <h2 class="text-lg font-semibold mb-2">Total Asesor</h2>
                <p class="text-4xl font-bold text-red-500">20</p>
                <p class="text-gray-500 mt-1">Registered assessors</p>
            </div>
        </section>
    </div>
</div>

@endsection
