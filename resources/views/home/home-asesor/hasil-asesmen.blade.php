@extends('home.home-asesor.layouts.layout')

@section('title', 'Hasil Asesmen - Asesor')

@section('content')
<div class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div class="p-6 border border-border bg-white rounded-2xl">
        <div class="overflow-x-auto">
            <table id="skema-periode-table" class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead class="bg-bg_dashboard text-center">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                        <div class="flex items-center">
                            No
                            <span class="sort-icon ml-1">↕</span>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                        <div class="flex items-center">
                            Lihat
                            <span class="sort-icon ml-1">↕</span>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">
                        <div class="flex items-center">
                            Nama Peserta
                            <span class="sort-icon ml-1">↕</span>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                        <div class="flex items-center">
                            Skema Sertifikasi
                            <span class="sort-icon ml-1">↕</span>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">
                        <div class="flex items-center">
                            Kode Skema
                            <span class="sort-icon ml-1">↕</span>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">
                        <div class="flex items-center">
                            Progress
                            <span class="sort-icon ml-1">↕</span>
                        </div>
                    </th>
                </tr>
            </thead>
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


@endsection
