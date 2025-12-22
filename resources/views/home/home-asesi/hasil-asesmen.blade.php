@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Hasil Asesmen')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
                <!-- Header dengan tombol back -->
                <div class="flex flex-wrap gap-2 mb-5">
                    <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                        HASIL ASESMEN
                    </div>
                </div>

                <h2 class="text-lg font-semibold mb-4">Status Hasil Asesmen Anda</h2>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Informasi Asesi -->
                <div class="border border-gray-300 rounded-lg p-4 mb-6">
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold bg-gray-50" colspan="2">Informasi Peserta</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold w-1/3">Nama Lengkap</td>
                            <td class="border border-gray-300 p-2">{{ $asesi->nama_asesi }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold">Nomor Peserta</td>
                            <td class="border border-gray-300 p-2">{{ $asesi->id_asesi }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold">Skema Sertifikasi</td>
                            <td class="border border-gray-300 p-2">{{ $asesi->skema->nama_skema ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold">Kode Skema</td>
                            <td class="border border-gray-300 p-2">{{ $asesi->skema->nomor_skema ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Status Hasil Asesmen -->
                <div class="border border-gray-300 rounded-lg p-4 mb-6">
                    <h3 class="text-md font-semibold mb-4">Status Hasil Asesmen</h3>
                    
                    @if($hasilAsesmen)
                        <div class="p-6 rounded-lg border-2 text-center
                            @if($hasilAsesmen->status === 'kompeten') 
                                bg-green-50 border-green-300
                            @elseif($hasilAsesmen->status === 'tidak_kompeten') 
                                bg-red-50 border-red-300
                            @else 
                                bg-gray-50 border-gray-300
                            @endif">
                            
                            <div class="flex items-center justify-center mb-4">
                                @if($hasilAsesmen->status === 'kompeten')
                                    <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                    <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>

                            <div>
                                @if($hasilAsesmen->status === 'kompeten')
                                    <p class="text-3xl font-bold text-green-600 mb-2">KOMPETEN</p>
                                    <p class="text-gray-700">Selamat! Anda telah dinyatakan kompeten dalam skema sertifikasi ini.</p>
                                @elseif($hasilAsesmen->status === 'tidak_kompeten')
                                    <p class="text-3xl font-bold text-red-600 mb-2">TIDAK KOMPETEN</p>
                                    <p class="text-gray-700">Mohon maaf, Anda belum memenuhi standar kompetensi yang ditetapkan.</p>
                                @else
                                    <p class="text-3xl font-bold text-gray-600 mb-2">BELUM ADA HASIL</p>
                                    <p class="text-gray-700">Hasil asesmen Anda masih dalam proses penilaian oleh asesor.</p>
                                @endif
                            </div>

                            @if($hasilAsesmen->tanggal_selesai)
                                <div class="mt-4 pt-4 border-t border-gray-300">
                                    <p class="text-sm text-gray-600">Tanggal Selesai Asesmen</p>
                                    <p class="text-base font-medium text-gray-900">{{ $hasilAsesmen->tanggal_selesai->format('d F Y') }}</p>
                                </div>
                            @endif
                        </div>

                        @if($hasilAsesmen->status === 'kompeten')
                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-blue-900">Informasi Sertifikat</p>
                                        <p class="text-sm text-blue-800 mt-1">Sertifikat Anda sedang dalam proses. Silakan hubungi admin untuk informasi lebih lanjut mengenai pengambilan sertifikat.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($hasilAsesmen->status === 'tidak_kompeten')
                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-yellow-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-yellow-900">Informasi Lanjutan</p>
                                        <p class="text-sm text-yellow-800 mt-1">Anda dapat mengajukan banding atau mengikuti asesmen ulang. Silakan hubungi asesor atau admin untuk informasi lebih lanjut.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @else
                        <div class="p-6 bg-gray-50 border-2 border-gray-300 rounded-lg text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-lg font-medium text-gray-700 mb-2">Belum Ada Data Hasil Asesmen</p>
                            <p class="text-gray-600">Data hasil asesmen Anda belum tersedia. Silakan hubungi asesor atau admin untuk informasi lebih lanjut.</p>
                        </div>
                    @endif
                </div>

                <!-- Tombol Kembali -->
                <div class="flex justify-center mt-6">
                    <a href="{{ route('asesi.index') }}" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
