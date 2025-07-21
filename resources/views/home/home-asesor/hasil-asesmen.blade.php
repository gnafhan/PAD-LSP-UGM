@extends('home.home-asesor.layouts.layout')

@section('title', 'Hasil Asesmen - Asesor')

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
        <p class="ms-2 text-xl font-bold text-black">IA.01</p>
    </div>

    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameHasil" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir IA.02 Tugas Praktik dan Demonstrasi</p>
        <!-- Search Form -->
        <form id="searchHasil" class="max-w-md mb-4 rounded-xl" method="GET" action="">
            <div class="relative">
            <input type="search" id="default-search" name="search" value="{{ old('search', isset($search) ? $search : request('search')) }}" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" />
                
            </div>
        </form>
        <div class="overflow-x-auto shadow-sm rounded-lg">
            <table id="daftarHasil" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">TUK</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Hasil</th>
                    </tr>
                </thead>
            <tbody class="divide-y divide-gray-200 text-black text-center">
                @forelse($hasilAsesmens as $index => $hasil)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $hasil->nama_asesi }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $hasil->nama_skema }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $hasil->nomor_skema }}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">{{ $hasil->nama_tuk }}</td>
                        <td class="px-4 py-0">
                            @if($hasil->status === 'kompeten')
                                <div class="my-4 mx-5 justify-center items-center rounded-md bg-green-100">
                                    <p class="text-hijau font-semibold">KOMPETEN</p>
                                </div>
                            @elseif($hasil->status === 'tidak_kompeten')
                                <div class="my-4 mx-5 justify-center items-center rounded-md bg-red-100">
                                    <p class="text-red-500 font-semibold">TIDAK KOMPETEN</p>
                                </div>
                            @else
                                <div class="my-4 mx-5 justify-center items-center rounded-md bg-gray-100">
                                    <p class="text-gray-500 font-semibold">-</p>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-gray-500 text-center">Tidak ada data hasil asesmen.</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>

    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<script>
function showSummary() {
    // Sembunyikan elemen pencarian utama
    document.getElementById('searchIA02').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarIA02').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailIA02').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailIA02').scrollIntoView({ behavior: 'smooth' });
}
</script>

@endsection
