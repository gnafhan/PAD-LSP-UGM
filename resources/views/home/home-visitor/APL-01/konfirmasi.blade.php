@extends('home.home-visitor.layouts.layout')

@section('title', 'Daftar Skema - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
<div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

<div class="flex flex-wrap gap-2">
            <a href="/apl/3" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
            <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
            FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
            </div>
    </div>

    <div class="flex flex-wrap gap-3 mt-5">
        <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI </h2>
    </div>

    <!-- Progress Bar -->
    <div class="flex justify-between items-center mb-8">
    <!-- Update breadcrumb di sini -->
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
        <p class="text-sm text-gray-800 ml-2">Rincian Data Pemohon Sertifikasi</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">2</div>
        <p class="text-sm text-gray-800 ml-2">Data Sertifikasi</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">3</div>
        <p class="text-sm text-gray-800 ml-2">Bukti Kelengkapan Pemohon</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">4</div>
        <p class="text-sm text-gray-800 ml-2">Konfirmasi Data Asesi</p>
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
            <button class="bg-gray-300 text-black px-4 py-2 rounded">N/A</button>
            <button class="bg-green-500 text-white px-4 py-2 rounded">DITERIMA</button>
            <button class="bg-gray-300 text-white px-4 py-2 rounded">TIDAK DITERIMA</button>
        </div>
        <p>sebagai peserta sertifikasi</p>

        <div class="mt-4 mb-6">
            <label for="note" class="block text-sm font-medium">Catatan</label>
            <textarea id="note" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3" readonly>Peserta memenuhi persyaratan silakan lanjut Assesmen Mandiri</textarea>
        </div>

        <div class="flex justify-between">
            <div>
                <h3 class="text-sm font-bold">Pemohon **)</h3>
                <p class="mt-2">Nama: Belda Putri Pramono</p>
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="approve-pemohon" class="text-sm">Dengan ini saya menyetujui permohonan</label>
                </div>
                <p class="mt-2">TTD: <img src="signature.png" alt="Signature" class="h-6 inline"></p>
                <p>Tgl: 20-10-2024</p>
            </div>
            <div>
                <h3 class="text-sm font-bold">Admin LSP ***)</h3>
                <p class="mt-2">Nama: Muhammad Abdul Karim</p>
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" id="approve-admin" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked disabled>
                    <label for="approve-admin" class="text-sm">TTD Admin</label>
                </div>
                <p class="mt-2">TTD: <img src="admin-signature.png" alt="Admin Signature" class="h-6 inline"></p>
                <p>Tgl: 20-10-2024</p>
            </div>
            </div>
        </div>


        <!-- Confirmation and Actions -->
        <div class="flex justify-end">
            <a href="/home" id="btn-selanjutnya" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Konfirmasi</a>
        </div>
        <!-- <div class="flex justify-end mt-6">
            <!-- <form action="/home" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-700">Konfirmasi</button>
            </form> -->
        </div> -->
@endsection
