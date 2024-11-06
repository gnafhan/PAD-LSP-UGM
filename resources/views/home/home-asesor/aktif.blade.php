@extends('home.home-asesor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="w-full bg-white p-4 shadow-md">
        <div class="flex flex-wrap gap-2">
            <a href="/persetujuan" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0" disabled>Assesi</a>
            <a href="/apl1/b1" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Surat Tugas</a>
            <a href="/apl2" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Absensi</a>
            <a href="/ak1" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">BA</a>
            <a href="/ia2" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">FR.AK-05</a>
            <a href="/persetujuan" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0" disabled>FR.AK-06</a>
            <a href="/persetujuan" class="bg-blue-500 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0" disabled>FR.IA-05</a>
        </div>
    </div>
</div>
@endsection
