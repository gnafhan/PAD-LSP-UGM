@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Bidang Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-2xl mx-auto">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 py-6 px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Tambah Bidang Kompetensi</h1>
                    <a href="{{ route('admin.bidang-kompetensi.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 rounded-lg text-sm px-4 py-2">Kembali</a>
                </div>
            </div>
            <div class="p-8">
                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Terdapat kesalahan input:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.bidang-kompetensi.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="nama_bidang" class="block text-sm font-medium text-gray-700 mb-1">Nama Bidang <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_bidang" id="nama_bidang" value="{{ old('nama_bidang') }}" class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_bidang') border-red-500 @enderror" placeholder="Contoh: Teknologi Informasi" required maxlength="60">
                            @error('nama_bidang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


