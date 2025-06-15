@extends('home.home-asesor.layouts.layout')

@section('title', 'Home - Asesor')

@section('content')
<div id="backFrame" class="lg:pt-[88px] lg:pb-80 lg:px-16 md:bg-bg_dashboard lg:ml-64">
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
            <div class="flex w-fit items-center p-3 gap-2 rounded-full border border-border bg-white">
                <img id="profilePicture" src="{{ asset('images/image 48.png') }}" alt="Profile Picture" class="m-2 w-24 h-24 rounded-full">
                <div class="font-medium text-black pe-4 ">
                    <p id="asesorName">Nama Asesor</p>
                    <div id="asesorEmail" class="text-sm font-light text-font_desc">Email Asesor</div>
                </div>
            </div>

            <div class="flex gap-4 my-4">
                <div class="flex w-36 items-center justify-center mx-6 p-2 rounded-2xl border border-border bg-white">
                    <div class="px-2 text-font_selesai justify-items-center items-center text-black">
                        <p id="jumlahKompetensiTeknis" class="text-4xl font-semibold">0</p>
                        <p class="font-medium text-center">Kompetensi Teknis</p>
                    </div>
                </div>
                <div class="flex w-32 items-center justify-center p-2 rounded-2xl border border-border bg-gradient-to-r from-white to-[rgba(139,92,246,0.15)]">
                  <div class="px-2 text-font_selesai justify-items-center items-center text-font_status">
                    <p id="jumlahAsesi" class="text-4xl font-medium">0</p>
                    <p class="font-medium">Asesi</p>
                  </div>
                </div>
                <div class="flex w-32 items-center justify-center rounded-2xl border border-border bg-gradient-to-r from-white to-[rgba(59,130,246,0.15)]">
                  <div class="px-2 text-font_progress justify-items-center items-center text-font_status">
                    <p id="jumlahEvent" class="text-4xl font-medium">0</p>
                    <p class="font-medium">Event</p>
                  </div>
                </div>
                <div class="flex w-32 items-center justify-center rounded-2xl border border-border bg-gradient-to-r from-white to-[rgba(139,92,246,0.15)]">
                  <div class="px-2 text-font_pending justify-items-center items-center text-font_status">
                    <p id="jumlahSkema" class="text-4xl font-medium">0</p>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const apiKey = "{{ env('API_KEY') }}";

            // Get asesor ID dynamically from the authenticated user with proper error handling
            const asesorId = @json(Auth::user()->asesor->id_asesor ?? 'ASESOR202500005');

            // Stop execution if no asesor ID is found
            if (!asesorId) {
                console.error('No asesor ID found for the authenticated user');
                document.getElementById('asesorName').textContent = 'User tidak teridentifikasi';
                document.getElementById('asesorEmail').textContent = 'Silahkan login kembali';
                return;
            }

            // PERBAIKAN: Gunakan URL yang benar
            const apiUrl = "{{ url('/api/v1/asesor/dashboard') }}/" + asesorId;

            // Debug output
            console.log('Fetching data for asesor ID:', asesorId);
            console.log('API URL:', apiUrl);

            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Make API request
            fetch(apiUrl, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'API_KEY': apiKey,
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken || '',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(result => {
                console.log('API Response:', result);

                if (result.success && result.data) {
                    const data = result.data;

                    // Update profile information
                    document.getElementById('asesorName').textContent = data.nama_asesor || 'Nama tidak tersedia';
                    document.getElementById('asesorEmail').textContent = data.email_asesor || 'Email tidak tersedia';

                    // Update statistics counters
                    document.getElementById('jumlahKompetensiTeknis').textContent = data.jumlah_kompetensi_teknis || '0';
                    document.getElementById('jumlahAsesi').textContent = data.jumlah_asesi || '0';
                    document.getElementById('jumlahEvent').textContent = data.jumlah_event || '0';
                    document.getElementById('jumlahSkema').textContent = data.jumlah_skema || '0';
                } else {
                    console.error('API returned success=false or missing data:', result);
                    document.getElementById('asesorName').textContent = 'Tidak dapat memuat data';
                    document.getElementById('asesorEmail').textContent = result.message || 'Format respons tidak sesuai';
                }
            })
            .catch(error => {
                console.error('Error details:', error);
                document.getElementById('asesorName').textContent = 'Error: ' + (error.message || 'Unknown error');
            });
        });
    </script>
@endsection
