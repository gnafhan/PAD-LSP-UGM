@extends('home-asesor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="min-h-screen bg-gray-100 p-6">
        <header class="bg-white shadow-md rounded-md p-4 mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-700">Dashboard Asesor</h1>
            <div class="flex space-x-4">
                <button class="bg-blue-300 text-white px-4 py-2 rounded-md hover:bg-blue-400 transition duration-200">Settings</button>
            </div>
        </header>


        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 Total Events -->
                <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Total Events</h2>
                    <p class="text-4xl font-bold text-blue-500">25</p>
                    <p class="text-gray-500 mt-1">Active events currently available</p>
                </div>

                <!-- Card 2 Total Skema -->
                <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Total Skema</h2>
                    <p class="text-4xl font-bold text-green-500">12</p>
                    <p class="text-gray-500 mt-1">Available certification schemes</p>
                </div>

                <!-- Card 3 Total Asesi -->
                <div class="bg-white p-4 rounded-md shadow-md hover:shadow-lg transition duration-300">
                    <h2 class="text-lg font-semibold mb-2">Total Asesi</h2>
                    <p class="text-4xl font-bold text-orange-500">350</p>
                    <p class="text-gray-500 mt-1">Registered candidates</p>
                </div>

            </section>
</div>
@endsection
