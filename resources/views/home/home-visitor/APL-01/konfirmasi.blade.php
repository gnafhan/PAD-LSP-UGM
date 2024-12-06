@extends('home.home-visitor.layouts.layout')

@section('title', 'Daftar Skema - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

        <div class="flex flex-wrap gap-2">
                    <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i> <!-- Ikon Font Awesome -->
                    </a>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                    FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
                    </div>
            </div>

            <div class="flex flex-wrap gap-3 mt-5">
                <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI </h2>
            </div>

            <!-- Progress Bar -->
            <div class="w-full max-w-4xl mx-auto px-4">
                            <div class="flex flex-col md:flex-row justify-start items-start mb-8">
                                <!-- Step 1 -->
                                <div class="flex items-center mb-4 md:mb-0 md:w-auto">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
                                    <p class="text-sm text-gray-800 ml-2">Rincian Data Pemohon Sertifikasi</p>
                                </div>

                                <!-- Garis Penghubung (dihide di tampilan kecil) -->
                                <div class="hidden md:block flex-1 h-0.5 bg-gray-300 mx-2"></div>

                                <!-- Step 2 -->
                                <div class="flex items-center mb-4 md:mb-0 md:w-auto">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">2</div>
                                    <p class="text-sm text-gray-800 ml-2">Data Sertifikasi</p>
                                </div>

                                <!-- Garis Penghubung (dihide di tampilan kecil) -->
                                <div class="hidden md:block flex-1 h-0.5 bg-gray-300 mx-2"></div>

                                <!-- Step 3 -->
                                <div class="flex items-center mb-4 md:mb-0 md:w-auto">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400  text-white">3</div>
                                    <p class="text-sm text-gray-800 ml-2">Bukti Kelengkapan Pemohon</p>
                                </div>

                                <!-- Garis Penghubung (dihide di tampilan kecil) -->
                                <div class="hidden md:block flex-1 h-0.5 bg-gray-300 mx-2"></div>

                                <!-- Step 4 -->
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">4</div>
                                    <p class="text-sm text-gray-800 ml-2">Konfirmasi Data Asesi</p>
                                </div>
                            </div>
                        </div>

            <div class="border border-gray-300 rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Bagian 4 : Konfirmasi Data Asesi</h2>
                <p class="text-sm mb-6">Pada bagian ini, terdapat informasi mengenai status Assesi</p>

                <!-- Asesi Details -->
                <h2 class="text-lg font-semibold mb-2 text-left mt-4">Rekomendasi</h2>
                <p class="text-sm font-bold mb-6 text-red-500">*diisi oleh Admin LSP</p>

                <p class="mb-4">Berdasarkan Ketentuan Persyaratan dasar pemohon maka pemohon:</p>
                <div class="flex mb-4 space-x-2">
                    <button class="px-4 py-2 rounded {{ $asesiPengajuan->status_rekomendasi === 'N/A' ? 'bg-green-500 text-white' : 'bg-gray-300 text-black' }}">
                        N/A
                    </button>
                    <button class="px-4 py-2 rounded {{ $asesiPengajuan->status_rekomendasi === 'Diterima' ? 'bg-green-500 text-white' : 'bg-gray-300 text-black' }}">
                        DITERIMA
                    </button>
                    <button class="px-4 py-2 rounded {{ $asesiPengajuan->status_rekomendasi === 'Tidak diterima' ? 'bg-green-500 text-white' : 'bg-gray-300 text-black' }}">
                        TIDAK DITERIMA
                    </button>
                </div>
                <p>sebagai peserta sertifikasi</p>

                <div class="mt-4 mb-6">
                    <label for="note" class="block text-sm font-medium">Catatan</label>
                    <textarea id="note" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3" readonly>Peserta memenuhi persyaratan silakan lanjut Assesmen Mandiri</textarea>
                </div>

                <div class="flex justify-between">
                    <div>
                        <h3 class="text-sm font-bold">Pemohon **)</h3>
                        <p class="mt-2">Nama: {{ $asesiPengajuan->nama_user }}</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="approve-pemohon" class="text-sm">Dengan ini saya menyetujui permohonan</label>
                        </div>
                        <p class="mt-2">TTD: <img src="{{ asset('images/signature.jpg') }}" alt="Signature" class="h-6 inline"></p>
                        <p>Tgl: 20-10-2024</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold">Admin LSP ***)</h3>
                        <p class="mt-2">Nama: Muhammad Abdul Karim</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <input type="checkbox" id="approve-admin" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked disabled>
                            <label for="approve-admin" class="text-sm">TTD Admin</label>
                        </div>
                        <p class="mt-2">TTD: <img src="{{ asset('images/admin-signature.jpg') }}" alt="Admin Signature" class="h-6 inline"></p>
                        <p>Tgl: 20-10-2024</p>
                    </div>
                    </div>
                </div>


                <!-- Confirmation and Actions -->
                <div class="flex justify-end mt-4">
                    {{-- <a href="/home" id="btn-selanjutnya" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Konfirmasi</a> --}}
                    <button
                    id="btn-konfirmasi"
                    class="font-semibold py-2 px-4 rounded-lg {{ $asesiPengajuan->status_rekomendasi === 'N/A' ? 'bg-gray-300 cursor-not-allowed' : 'bg-green-500 hover:bg-green-700' }} text-white"
                    {{ $asesiPengajuan->status_rekomendasi === 'N/A' ? 'disabled' : '' }} >
                    Konfirmasi
                </button>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('approve-pemohon');
        const button = document.getElementById('btn-konfirmasi');

        button.addEventListener('click', function (e) {
            if (!checkbox.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui permohonan dengan mencentang checkbox terlebih dahulu.');
            }
        });
    });
</script>
@endsection
