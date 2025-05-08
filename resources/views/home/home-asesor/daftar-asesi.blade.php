@extends('home.home-asesor.layouts.layout')

@section('title', 'Daftar Asesi - Asesor')

@section('content')
<div class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div class="p-6 border border-border bg-white rounded-2xl">
        <div class="overflow-x-auto">
            <table id="daftarAsesi" class="min-w-full bg-white shadow-lg">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                            <div class="flex items-center">
                                No
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                            <div class="flex items-center">
                                Aksi
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">
                            <div class="flex items-center">
                                Nama Peserta
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                            <div class="flex items-center">
                                Skema Sertifikasi
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">
                            <div class="flex items-center">
                                Kode Skema
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">
                            <div class="flex items-center">
                                Progress
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black">
                    <td class="px-4 py-3 text-sm text-gray-700">1</td>
                    <td class="items-center">
                        <button onclick="showSummary()" class="text-biru hover:text-ungu">
                            <svg class="w-6 h-6 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </td>
                    <td>Nafa</td>
                    <td>Sertifikasi Frontend</td>
                    <td>12345</td>
                    <td>50%</td>
                </tbody>
                    {{-- <tbody class="divide-y divide-gray-200">
                        @if($skemaStats->isEmpty())
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data skema per periode yang tersedia</td>
                            </tr>
                        @else
                            @foreach($skemaStats as $index => $stat)
                            <tr class="hover:bg-gray-50 skema-row" data-periode="{{ $stat->periode }}" data-tahun="{{ $stat->tahun }}">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->nama_skema }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->periode }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->tahun }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->jumlah_asesi }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody> --}}
            </table>

            <div id="detailAsesi" class="hidden p-4 text-black">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <span class="ms-2 text-xl font-semibold text-black">Nama Asesi</span>
                </div>


                <form class="max-w-md mb-4 rounded-xl">
                    <div class="relative">
                        <input type="search" id="default-search" class="block w-full p-2 text-sm text-abu border border-abu rounded-lg bg-white focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                        <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </button>
                    </div>
                </form>
                {{-- Tabel Pelaksanaan Asesmen --}}
                <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                    <table id="pelaksanaan-asesmen-table" class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                                    <div class="flex items-center">
                                        No
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">
                                    <div class="flex items-center">
                                        Lihat
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                                    <div class="flex items-center">
                                        Pelaksanaan Asesmen
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                                    <div class="flex items-center">
                                        Tanggal Asesi
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">
                                    <div class="flex items-center">
                                        Progress
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black">
                            <td class="px-4 py-3 text-sm text-gray-700">1</td>
                            <td class="items-center">
                                <svg class="w-6 h-6 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td>Sertifikasi Frontend</td>
                            <td>12345</td>
                            <td class="items-center">
                                <svg class="w-6 h-6 text-hijau" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tbody>
                        {{-- <tbody class="divide-y divide-gray-200">
                            @if($skemaStats->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data skema per periode yang tersedia</td>
                                </tr>
                            @else
                                @foreach($skemaStats as $index => $stat)
                                <tr class="hover:bg-gray-50 skema-row" data-periode="{{ $stat->periode }}" data-tahun="{{ $stat->tahun }}">
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->nama_skema }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->periode }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->tahun }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->jumlah_asesi }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody> --}}
                    </table>
                </div>
                {{-- Tabel Perangkat Asesmen --}}
                <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                    <table id="perangkat-asesmen-table" class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                                    <div class="flex items-center">
                                        No
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">
                                    <div class="flex items-center">
                                        Lihat
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                                    <div class="flex items-center">
                                        Perangkat Asesmen
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                                    <div class="flex items-center">
                                        Tanggal Asesi
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">
                                    <div class="flex items-center">
                                        Progress
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black">
                            <td class="px-4 py-3 text-sm text-gray-700">1</td>
                            <td class="items-center">
                                <svg class="w-6 h-6 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td>Sertifikasi Frontend</td>
                            <td>12345</td>
                            <td class="items-center">
                                <svg class="w-6 h-6 text-hijau" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tbody>
                        {{-- <tbody class="divide-y divide-gray-200">
                            @if($skemaStats->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data skema per periode yang tersedia</td>
                                </tr>
                            @else
                                @foreach($skemaStats as $index => $stat)
                                <tr class="hover:bg-gray-50 skema-row" data-periode="{{ $stat->periode }}" data-tahun="{{ $stat->tahun }}">
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->nama_skema }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->periode }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->tahun }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->jumlah_asesi }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody> --}}
                    </table>
                </div>
                {{-- Tabel Keputusan --}}
                <div class="overflow-x-auto shadow-md rounded-lg mb-8">
                    <table id="keputusan-table" class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                                    <div class="flex items-center">
                                        No
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">
                                    <div class="flex items-center">
                                        Lihat
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                                    <div class="flex items-center">
                                        Pelaksanaan Asesmen
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                                    <div class="flex items-center">
                                        Tanggal Asesi
                                    </div>
                                </th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">
                                    <div class="flex items-center">
                                        Progress
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black">
                            <td class="px-4 py-3 text-sm text-gray-700">1</td>
                            <td class="items-center">
                                <svg class="w-6 h-6 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td>Sertifikasi Frontend</td>
                            <td>12345</td>
                            <td class="items-center">
                                <svg class="w-6 h-6 text-hijau" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tbody>
                        {{-- <tbody class="divide-y divide-gray-200">
                            @if($skemaStats->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data skema per periode yang tersedia</td>
                                </tr>
                            @else
                                @foreach($skemaStats as $index => $stat)
                                <tr class="hover:bg-gray-50 skema-row" data-periode="{{ $stat->periode }}" data-tahun="{{ $stat->tahun }}">
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->nama_skema }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->periode }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->tahun }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->jumlah_asesi }}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody> --}}
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function showSummary() {
        const detailAsesi = document.getElementById('detailAsesi');
        const daftarAsesi = document.getElementById('daftarAsesi');

        // Sembunyikan tabel
        daftarAsesi.classList.add('hidden');

        // Tampilkan rangkuman
        detailAsesi.classList.remove('hidden');
        detailAsesi.scrollIntoView({ behavior: 'smooth' });
    }
</script>


@endsection
