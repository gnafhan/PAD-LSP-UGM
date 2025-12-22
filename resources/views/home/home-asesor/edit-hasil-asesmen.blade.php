@extends('home.home-asesor.layouts.layout')

@section('title', 'Edit Hasil Asesmen - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg class="w-8 h-8" viewBox="0 0 15 15" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"
              d="M1.96484 12.75L4.88151 9.83336M7.94926 11.5081C5.76526 11.0123 3.70259 8.94961 3.20676 6.76561C3.12801 6.42028 3.08893 6.24761 3.20268 5.96703C3.31584 5.68703 3.45526 5.59953 3.73293 5.42628C4.36059 5.03428 5.04076 4.90945 5.74601 4.97128C6.73593 5.05936 7.23118 5.10311 7.47851 4.9742C7.72526 4.84586 7.89268 4.54486 8.22868 3.94345L8.65334 3.18103C8.93334 2.67936 9.07334 2.42795 9.40293 2.30953C9.73251 2.19111 9.93084 2.26286 10.3275 2.40636C10.7834 2.57005 11.1974 2.83255 11.5398 3.17503C11.8823 3.51752 12.1448 3.93151 12.3085 4.38736C12.452 4.78403 12.5238 4.98236 12.4053 5.31194C12.2869 5.64094 12.0361 5.78095 11.5338 6.06153L10.7539 6.49611C10.1531 6.83095 9.85326 6.99894 9.72434 7.24803C9.59601 7.49769 9.64268 7.98186 9.73601 8.95019C9.80484 9.66186 9.68643 10.3467 9.28918 10.9825C9.11534 11.2602 9.02843 11.399 8.74784 11.5128C8.46784 11.6259 8.29518 11.5869 7.94926 11.5081Z" />
        </svg>
        <p class="ms-2 text-xl font-bold text-black">Edit Hasil Asesmen</p>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>

    <!-- Breadcrumbs -->
    <div class="relative z-10 mx-4 mb-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('asesor.hasil-asesmen.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-biru">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Hasil Asesmen
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <div id="frameEdit" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl mx-4">
        <p id="titlePage" class="mb-6 text-lg font-medium text-black">Edit Hasil Asesmen</p>

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
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <h3 class="text-md font-semibold text-gray-700 mb-3">Informasi Asesi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Nama Asesi</p>
                    <p class="text-base font-medium text-gray-900">{{ $hasilAsesmen->rincianAsesmen->asesi->nama_asesi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">ID Asesi</p>
                    <p class="text-base font-medium text-gray-900">{{ $hasilAsesmen->rincianAsesmen->asesi->id_asesi }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Skema Sertifikasi</p>
                    <p class="text-base font-medium text-gray-900">{{ $hasilAsesmen->rincianAsesmen->asesi->skema->nama_skema ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Kode Skema</p>
                    <p class="text-base font-medium text-gray-900">{{ $hasilAsesmen->rincianAsesmen->asesi->skema->nomor_skema ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">TUK</p>
                    <p class="text-base font-medium text-gray-900">{{ $hasilAsesmen->rincianAsesmen->event->tuk->nama_tuk ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Status Saat Ini</p>
                    @if($hasilAsesmen->status === 'kompeten')
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-hijau bg-green-100 rounded-md">KOMPETEN</span>
                    @elseif($hasilAsesmen->status === 'tidak_kompeten')
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-red-500 bg-red-100 rounded-md">TIDAK KOMPETEN</span>
                    @else
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-gray-500 bg-gray-100 rounded-md">BELUM ADA HASIL</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Edit/Create Status -->
        <form action="{{ $hasilAsesmen->id ? route('asesor.hasil-asesmen.update', $hasilAsesmen->id) : route('asesor.hasil-asesmen.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($hasilAsesmen->id)
                @method('PUT')
            @else
                <input type="hidden" name="id_rincian_asesmen" value="{{ $hasilAsesmen->id_rincian_asesmen }}">
            @endif

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status Hasil Asesmen <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status" required
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-biru focus:border-biru">
                    <option value="">-- Pilih Status --</option>
                    <option value="kompeten" {{ $hasilAsesmen->status === 'kompeten' ? 'selected' : '' }}>Kompeten</option>
                    <option value="tidak_kompeten" {{ $hasilAsesmen->status === 'tidak_kompeten' ? 'selected' : '' }}>Tidak Kompeten</option>
                    <option value="belum_ada_hasil" {{ $hasilAsesmen->status === 'belum_ada_hasil' ? 'selected' : '' }}>Belum Ada Hasil</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-4">
                <a href="{{ route('asesor.hasil-asesmen.index') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-biru to-ungu text-white rounded-lg hover:opacity-90 transition-opacity">
                    {{ $hasilAsesmen->id ? 'Simpan Perubahan' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>
@endsection
