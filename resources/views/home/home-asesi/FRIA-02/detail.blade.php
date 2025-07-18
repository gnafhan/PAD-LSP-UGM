@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Hasil Asesmen Sertifikasi Programmer')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-sm">
                <i class="fas fa-home text-blue-600"></i>
                <a href="{{ route('asesi.index') }}" class="breadcrumb-item">Home</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <a href="{{ route('asesi.fr.ia2') }}" class="breadcrumb-item">Formulir IA.02</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <span class="breadcrumb-item">Detail</span>
            </div>
        </nav>

    <div class="container mx-auto px-4 max-w-4xl">
        <div class="pt-6 pb-4 mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">FR.IA.02. Tugas Praktik Demonstrasi</h1>
        </div>

        <!-- Certificate Info -->
        <div class="glass-effect rounded-xl p-8 mb-8 hover-scale">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Skema Kompetensi:</span>
                        <span class="text-gray-900">{{ $data['nama_skema'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nomor Skema:</span>
                        <span class="text-gray-900">{{ $data['nomor_skema'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Peserta:</span>
                        <span class="text-gray-900">{{ $data['nama_peserta'] }}</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Asesor:</span>
                        <span class="text-gray-900">{{ $data['nama_asesor'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">TUK:</span>
                        <span class="text-gray-900">{{ $data['tuk'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Jadwal Pelaksanaan:</span>
                        <span class="text-gray-900">{{ $data['tanggal_asesi'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5"></div>
        <!-- Unit Kompetensi -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Unit Kompetensi (UK)</h2>

            @if($data['uk'] && $data['uk']->isNotEmpty())
                <div class="space-y-6">
                    @foreach($data['uk'] as $index => $uk)
                        <div class="p-4">
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        UK {{ $index + 1 }}: {{ $uk->nama_uk }}
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $uk->jenis_standar == 'Internasional' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $uk->jenis_standar }}
                                </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div class="flex">
                                        <span class="font-medium text-gray-600 w-20">ID UK:</span>
                                        <span class="text-gray-800">{{ $uk->id_uk }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-gray-600 w-20">Kode UK:</span>
                                        <span class="text-gray-800">{{ $uk->kode_uk }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Elemen UK -->
                            @if($uk->elemen_uk && $uk->elemen_uk->isNotEmpty())
                                <div class="mt-4">
                                    <h4 class="font-medium text-gray-700 mb-3">Elemen Kompetensi:</h4>
                                    <div class="space-y-2">
                                        @foreach($uk->elemen_uk as $elemenIndex => $elemen)
                                            <div class="bg-gray-50 rounded-md p-3">
                                                <div class="flex items-start">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-800 rounded-full text-xs font-medium mr-3 mt-0.5">
                                                    {{ $elemenIndex + 1 }}
                                                </span>
                                                    <div class="flex-1">
                                                        <p class="text-gray-800 font-medium">{{ $elemen->nama_elemen }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            ID: {{ $elemen->id_elemen_uk }} |
                                                            Dibuat: {{ date('d/m/Y', strtotime($elemen->created_at)) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <p class="text-yellow-800 text-sm">Tidak ada elemen kompetensi untuk UK ini.</p>
                                </div>
                            @endif
                        </div>
                        @if($index < count($data['uk']) - 1)
                            <hr class="my-6 border-gray-200">
                        @endif
                    @endforeach
                </div>
            @else
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-md">
                    <p class="text-gray-600">Tidak ada data Unit Kompetensi.</p>
                </div>
            @endif
        </div>
        <div class="mb-5"></div>
        <!-- Assessment Results -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Hasil Penilaian Sertifikasi</h2>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kemampuan Programming Kandidat:</label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="kinerja" value="kompeten" class="mr-2">
                        <span>Kompeten</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="kinerja" value="belum-kompeten" class="mr-2">
                        <span>Belum Kompeten</span>
                    </label>
                </div>
                <div class="mt-4">
                    <label for="feedback" class="block text-gray-700 font-semibold mb-2">Catatan Asesor:</label>
                    <textarea id="feedback" name="feedback" rows="3" class="text-gray-500 w-full p-2 border border-gray-300 rounded-md" placeholder="Berikan feedback mengenai kemampuan programming kandidat..."></textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
