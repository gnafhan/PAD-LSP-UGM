@extends('home.home-asesor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    {{-- <div class="absolute inset-x-0 -top-3 -z-10 transform-gpu overflow-hidden px-36 blur-3xl" aria-hidden="true">
        <div class="mx-auto aspect-1155/678 w-[72.1875rem] bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div> --}}
    <div class="flex items-center mb-4 ms-4">
        <svg class="w-8 h-8 text-biru_tua" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
        </svg>
        <span class="ms-2 text-xl font-bold text-black">Dashboard Asesor</span>
    </div>
    <div class="p-8 border border-border bg-white rounded-2xl">
        <p class="pb-3 text-lg font-medium text-black">Profile</p>
        <div class="flex justify-between py-4 px-8 mb-4 bg-bg_dashboard border border-border rounded-2xl">
            <div class="flex items-center p-3 gap-2 rounded-full border border-border bg-white">
                <svg class="w-24 h-24 text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                </svg>
                <div class="font-medium text-black pe-2">
                    <p>ABCDEFGHIJKLMNOPQRSTUVWXYZ</p>
                    <div class="text-sm font-light text-font_desc">email@gmail.com</div>
                </div>
            </div>
            <div class="flex items-center p-3 my-6 rounded-full border border-border bg-white">
                <div class="px-4 font-medium text-black justify-items-center items-center">
                    <p class="text-3xl font-medium">100</p>
                    <p class="font-normal">Asesi</p>
                </div>
            </div>
            <div class="flex gap-4 my-6">
                <div class="flex items-center p-2 rounded-2xl border border-border bg-fill_selesai">
                    <div class="px-2 text-font_selesai justify-items-center items-center">
                        <p class="text-3xl font-medium">20</p>
                        <p class="font-normal">Selesai</p>
                    </div>
                </div>
                <div class="flex items-center p-2 rounded-2xl border border-border bg-fill_progress">
                    <div class="px-2 text-font_progress justify-items-center items-center">
                        <p class="text-3xl font-medium">75</p>
                        <p class="font-normal">Progress</p>
                    </div>
                </div>
                <div class="flex items-center p-2 rounded-2xl border border-border bg-fill_pending">
                    <div class="px-2 text-font_pending justify-items-center items-center">
                        <p class="text-3xl font-medium">5</p>
                        <p class="font-normal">Pending</p>
                    </div>
                </div>
            </div>
        </div>
        <p class="pb-3 text-lg font-medium text-black">Informasi</p>
        <div class="grid grid-cols-3 gap-6 mb-4">
            <div class="flex gap-3 py-4 items-center justify-center rounded-2xl bg-white border border-border">
                <svg class="w-16 h-16 text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                </svg>
                <p class="text-2xl text-font_desc py-4">
                    <div class="font-medium text-black pe-2">
                        <p>Pedoman</p>
                        <div class="text-sm font-light text-font_desc">Tata cara dan flow sertifikasi</div>
                    </div>
                </p>
            </div>
            {{-- <div class="flex items-center justify-center h-24 rounded-sm bg-gray-50 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center h-24 rounded-sm bg-gray-50 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div> --}}
        </div>
        {{-- <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center h-48 mb-4 rounded-sm bg-gray-50 ">
            <p class="text-2xl text-gray-400 dark:text-gray-500">
                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
            <div class="flex items-center justify-center rounded-sm bg-gray-50 h-28 ">
                <p class="text-2xl text-gray-400 dark:text-gray-500">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                    </svg>
                </p>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="bg-white">

<div class="min-h-screen bg-gray-100">
    <div class="min-h-screen bg-gray-100 p-6">
        <header class="bg-white shadow-md rounded-md p-4 mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-700">Dashboard Asesor</h1>
            <div class="flex space-x-4">
                <button class="bg-blue-300 text-black px-4 py-2 rounded-md hover:bg-blue-400 transition duration-200">Settings</button>
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
</div> --}}
@endsection
