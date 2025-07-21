@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.AK-04 - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <!-- Biru -->
                    <stop offset="100%" stop-color="#8B5CF6" /> <!-- Ungu -->
                </linearGradient>
            </defs>
            <path
                d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
            />
        </svg>
        <p class="ms-2 text-xl font-bold text-black">AK.04</p>
    </div>
    <div id="breadcrumbs" class="pb-4 px-6">
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('home-asesor') }}" class="inline-flex items-center text-sm font-medium text-black hover:text-sidebar_font">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <a href="{{ route('frak04-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.AK.04
                        </a>
                    </div>
                </li>
                <!-- Memanggil data nama asesi -->
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-black">{{ $asesi->nama_asesi }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameAK01" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        
        <!-- Search Form -->
        
        <div class="overflow-x-auto shadow-sm rounded-lg">
           
        </div>
        <div id="detailAK01" class="p-4 text-black">
            <p id="judulDetail" class="text-lg font-medium text-black">FR.AK 04. Asesmen Banding</p>
            <p id="descDetail" class="font text-sidebar_font mt-2">Banding ini diajukan atas Keputusan Asesmen yang dibuat terhadap Skema Sertifikasi (Kualifikasi/Klaster/Okupasi) berikut :</p>

            <!-- Input Formulir APL.02 -->
            <div id="FRAK01" class="p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $asesi->nama_skema }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $asesi->nomor_skema }}
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $asesi->nama_asesi }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $asesi->nama_asesor }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        {{ $asesi->nama_tuk }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Banding -->
            <div id="bandingSection" class="p-4">
                <p class="block mb-2 font-semibold text-sidebar_font text-lg">Banding</p>
                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Persyaratan</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Ya</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Tidak</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black text-center items-center">
                            @foreach($pertanyaan_banding->where('jenis_pertanyaan', 'true_false')->values() as $index => $pertanyaan)
                                @php
                                    $jawaban = $jawaban_banding->firstWhere('id_pertanyaan_banding', $pertanyaan->id);
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-gray-700 text-left">{{ $pertanyaan->pertanyaan }}</td>
                                    <td class="px-4 py-3">
                                        <input type="radio" name="banding{{ $index + 1 }}" value="ya" class="form-radio h-4 w-4 text-biru"
                                            @if(isset($jawaban) && ($jawaban->jawaban === 'ya' || $jawaban->jawaban === 'true')) checked @endif disabled>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="radio" name="banding{{ $index + 1 }}" value="tidak" class="form-radio h-4 w-4 text-biru"
                                            @if(isset($jawaban) && ($jawaban->jawaban === 'tidak' || $jawaban->jawaban === 'false')) checked @endif disabled>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @php
                    $textPertanyaan = $pertanyaan_banding->where('jenis_pertanyaan', 'text')->values();
                @endphp
                @if($textPertanyaan->count() > 0)
                    <div class="mt-6 space-y-6">
                        @foreach($textPertanyaan as $index => $pertanyaan)
                            @php
                                $jawaban = $jawaban_banding->firstWhere('id_pertanyaan_banding', $pertanyaan->id);
                            @endphp
                            <div>
                                <label for="alasanBanding{{ $index + 1 }}" class="block mb-2 font-semibold text-sidebar_font">
                                    {{ $pertanyaan->pertanyaan }}
                                </label>
                                <textarea id="alasanBanding{{ $index + 1 }}" rows="4" class="block p-2.5 w-full text-sm text-sidebar_font rounded-lg border border-border_input bg-gray-100" placeholder="---" readonly>{{ $jawaban ? $jawaban->jawaban : '' }}</textarea>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        

        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<script>
function showSummary() {
    // Sembunyikan elemen judul halaman
    document.getElementById('titlePage').classList.add('hidden');

    // Sembunyikan elemen pencarian utama
    document.getElementById('searchAK01').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarAK01').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailAK01').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailAK01').scrollIntoView({ behavior: 'smooth' });
}
</script>

@endsection
