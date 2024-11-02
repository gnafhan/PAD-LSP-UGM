@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="w-full bg-white p-4 shadow-md">
        <div class="flex flex-wrap gap-2">
            <a href="/persetujuan" class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 hover:bg-green-700">Persetujuan</a>
            <a href="/apl1/b1" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">FR.APL.01</a>
            <a href="/apl2" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">FR.APL.02</a>
            <a href="/ak1" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">FR.AK.01</a>
            <a href="/ia2" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">FR.IA.02 SOAL PRAKTEK/UPLOAD JAWABAN</a>
            <a href="/ak3" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">FR.AK.03 Umpan Balik</a>
        </div>
    </div>
</div>
@endsection
