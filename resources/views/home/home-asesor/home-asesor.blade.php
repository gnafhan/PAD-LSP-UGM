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
        // Get API key from environment variable
        const apiKey = "{{ env('API_KEY') }}";

        // Get asesor ID dynamically from the authenticated user
        const asesorId = @json(Auth::user()->asesor->id_asesor ?? 'ASESOR_DEFAULT_ID');

        // Use a real asesor ID as fallback for testing
        // const asesorId = "{{ Auth::user()->id_asesor ?? 'ASESOR202500005' }}";

        // Construct the API URL using the app URL from environment
        const apiUrl = {{ rtrim(env('APP_URL', 'http://localhost'), '/') }}/api/v1/asesor/dashboard/${asesorId};

        // Get references to DOM elements we'll update
        const asesorNameElement = document.getElementById('asesorName');
        const asesorEmailElement = document.getElementById('asesorEmail');
        const jumlahKompetensiTeknisElement = document.getElementById('jumlahKompetensiTeknis');
        const jumlahAsesiElement = document.getElementById('jumlahAsesi');
        const jumlahEventElement = document.getElementById('jumlahEvent');
        const jumlahSkemaElement = document.getElementById('jumlahSkema');

        console.log('API URL:', apiUrl);
        console.log('API Key:', apiKey);
        console.log('Asesor ID:', asesorId);
        // Make API request
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-API-KEY': apiKey,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    // Handle specific HTTP error codes
                    if (response.status === 404) {
                        if (asesorNameElement) asesorNameElement.textContent = 'Asesor tidak ditemukan';
                        if (asesorEmailElement) asesorEmailElement.textContent = 'ID asesor tidak terdaftar dalam sistem';
                    } else if (response.status === 401 || response.status === 403) {
                        if (asesorNameElement) asesorNameElement.textContent = 'Akses tidak diizinkan';
                        if (asesorEmailElement) asesorEmailElement.textContent = 'API key tidak valid atau akses tidak diizinkan';
                    } else if (response.status >= 500) {
                        if (asesorNameElement) asesorNameElement.textContent = 'Kesalahan server';
                        if (asesorEmailElement) asesorEmailElement.textContent = 'Terjadi kesalahan pada server, coba lagi nanti';
                    } else {
                        if (asesorNameElement) asesorNameElement.textContent = 'Error memuat data';
                        if (asesorEmailElement) asesorEmailElement.textContent = Error: ${err.message || response.statusText || 'Unknown error'};
                    }

                    // Set numeric fields to 'Tidak ada data' upon error
                    if (jumlahKompetensiTeknisElement) jumlahKompetensiTeknisElement.textContent = 'N/A';
                    if (jumlahAsesiElement) jumlahAsesiElement.textContent = 'N/A';
                    if (jumlahEventElement) jumlahEventElement.textContent = 'N/A';
                    if (jumlahSkemaElement) jumlahSkemaElement.textContent = 'N/A';

                    throw new Error(HTTP error ${response.status}: ${err.message || response.statusText});
                });
            }
            return response.json();
        })
        .then(result => {
            if (result.success && result.data) {
                const data = result.data;

                // Update profile information
                if (asesorNameElement) asesorNameElement.textContent = data.nama_asesor || 'Nama tidak tersedia';
                if (asesorEmailElement) asesorEmailElement.textContent = data.email_asesor || 'Email tidak tersedia';

                // Update statistics counters
                if (jumlahKompetensiTeknisElement) {
                    jumlahKompetensiTeknisElement.textContent =
                        data.jumlah_kompetensi_teknis !== undefined ? data.jumlah_kompetensi_teknis : '0';
                }
                if (jumlahAsesiElement) {
                    jumlahAsesiElement.textContent =
                        data.jumlah_asesi !== undefined ? data.jumlah_asesi : '0';
                }
                if (jumlahEventElement) {
                    jumlahEventElement.textContent =
                        data.jumlah_event !== undefined ? data.jumlah_event : '0';
                }
                if (jumlahSkemaElement) {
                    jumlahSkemaElement.textContent =
                        data.jumlah_skema !== undefined ? data.jumlah_skema : '0';
                }
            } else {
                // Handle cases where success is false or data is not present
                if (asesorNameElement) asesorNameElement.textContent = 'Tidak dapat memuat data';
                if (asesorEmailElement) asesorEmailElement.textContent = result.message || 'Format respons tidak sesuai';

                // Set numeric fields to 'Tidak ada data'
                if (jumlahKompetensiTeknisElement) jumlahKompetensiTeknisElement.textContent = 'N/A';
                if (jumlahAsesiElement) jumlahAsesiElement.textContent = 'N/A';
                if (jumlahEventElement) jumlahEventElement.textContent = 'N/A';
                if (jumlahSkemaElement) jumlahSkemaElement.textContent = 'N/A';

                console.error('API returned success=false or missing data:', result);
            }
        })
        .catch(error => {
            console.error('Error fetching asesor dashboard data:', error);

            // If there's a network error that wasn't caught by previous handlers
            if (!navigator.onLine) {
                if (asesorNameElement) asesorNameElement.textContent = 'Tidak dapat terhubung ke server';
                if (asesorEmailElement) asesorEmailElement.textContent = 'Periksa koneksi internet Anda';
            }
        });
    });
</script>
@endsection

