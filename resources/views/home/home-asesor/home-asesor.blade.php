@extends('home.home-asesor.layouts.layout')

@section('title', 'Home - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mb-4 ms-4">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
        </svg>
        <span class="ms-2 text-xl font-bold text-black">Home Asesor</span>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameHomeAsesor" class="relative z-10 p-8 border border-border bg-white rounded-2xl">
        <p class="pb-3 text-lg font-medium text-black">Profile</p>
        <div class="flex justify-between py-6 px-8 mb-4 bg-bg_dashboard border border-border rounded-2xl">
            <div class="flex items-center p-3 gap-2 rounded-full border border-border bg-white">
                <img id="profilePicture" src="{{ asset('images/image 48.png') }}" alt="Profile Picture" class="m-2 w-24 h-24 rounded-full">
                <div class="font-medium text-black pe-4">
                    <p>Nafa Popcorn Ayuwati</p>
                    <div class="text-sm font-light text-font_desc">asesor@mail.ugm.ac.id</div>
                </div>
            </div>
            <div class="flex w-36 items-center justify-center p-2 rounded-2xl border border-border bg-white">
                <div class="px-2 text-font_selesai justify-items-center items-center text-black">
                    <p class="text-4xl font-semibold">5</p>
                    <p class="font-medium text-center">Kompetensi Teknis</p>
                </div>
            </div>
            <div class="flex gap-4 my-4">
                <div class="flex w-32 items-center justify-center p-2 rounded-2xl border border-border bg-gradient-to-r from-white to-[rgba(139,92,246,0.15)]">
                  <div class="px-2 text-font_selesai justify-items-center items-center text-font_status">
                    <p class="text-4xl font-medium">100</p>
                    <p class="font-medium">Asesi</p>
                  </div>
                </div>
                <div class="flex w-32 items-center justify-center rounded-2xl border border-border bg-gradient-to-r from-white to-[rgba(59,130,246,0.15)]">
                  <div class="px-2 text-font_progress justify-items-center items-center text-font_status">
                    <p class="text-4xl font-medium">75</p>
                    <p class="font-medium">Event</p>
                  </div>
                </div>
                <div class="flex w-32 items-center justify-center rounded-2xl border border-border bg-gradient-to-r from-white to-[rgba(139,92,246,0.15)]">
                  <div class="px-2 text-font_pending justify-items-center items-center text-font_status">
                    <p class="text-4xl font-medium">75</p>
                    <p class="font-medium">Skema</p>
                  </div>
                </div>
            </div>
        </div>
        <p class="pt-4 pb-3 text-lg font-medium text-black">Informasi</p>
        <div class="flex w-80 gap-3 p-4 items-center rounded-2xl bg-white border border-border">
            <svg class="w-16 h-16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="url(#icon-gradient)">
              <defs>
                <linearGradient id="icon-gradient" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stop-color="#3B82F6" />
                  <stop offset="100%" stop-color="#8B5CF6" />
                </linearGradient>
              </defs>
              <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd" />
            </svg>

            <div class="font-medium">
              <p class="text-2xl text-black">Pedoman</p>
              <div class="text-sm font-light text-font_desc">Tata cara dan flow sertifikasi</div>
            </div>
        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[80%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>

@endsection
