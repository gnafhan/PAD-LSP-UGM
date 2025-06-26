@extends('home.layouts.layout')

@section('title', 'Skema Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 pt-36 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-xl font-bold mb-4 text-center">Daftar Skema Sertifikasi</h2>

        <!-- Form Pencarian -->
        <form class="w-1/2 mx-auto pb-8" onsubmit="return false;">
            <label for="searchInput" class="mb-2 text-sm font-medium text-gray-900 sr-only">Cari</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" id="searchInput" onkeyup="searchTable()" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Skema Sertifikasi..." />
            </div>
        </form>

        <!-- Tabel Skema Sertifikasi -->
        <table class="w-full bg-white rounded-md shadow-md">
            <thead class="bg-gray-300 rounded-t-md">
                <tr>
                    <th class="p-2 text-left">No.</th>
                    <th class="p-2 text-left">Nomor / Judul Skema</th>
                    <th class="p-2 text-left">Unit dan Persyaratan</th>
                </tr>
            </thead>
            <tbody id="skemaTable">
                @forelse($skemaData as $index => $skema)
                <tr>
                    <td class="p-2 align-top">{{ $index + 1 }}</td>
                    <td class="p-2 align-top">
                        {{ $skema->nomor_skema }} - {{ $skema->nama_skema }} <br>
                        <a href="#" class="bg-blue-500 text-white p-1 rounded">Dokumen SKKNI</a>
                    </td>
                    <td class="p-2">
                        <!-- Unit Kompetensi -->
                        <button onclick="toggleContent('unit{{ $index }}')" class="bg-blue-600 text-white p-2 rounded mb-2">Unit Kompetensi</button>
                        <div id="unit{{ $index }}" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">No.</th>
                                        <th class="p-2 text-left">Unit Kompetensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skema->unitKompetensi as $ukIndex => $unit)
                                    <tr>
                                        <td class="p-2 text-center">{{ $ukIndex + 1 }}</td>
                                        <td class="p-2">{{ $unit->nama_uk }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Persyaratan -->
                        <button onclick="toggleContent('requirement{{ $index }}')" class="bg-blue-600 text-white p-2 rounded mb-2 mt-4">Persyaratan Dasar Peserta</button>
                        <div id="requirement{{ $index }}" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">No.</th>
                                        <th class="p-2 text-left">Persyaratan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skema->parsed_persyaratan as $reqIndex => $persyaratan)
                                    <tr>
                                        <td class="p-2 text-center">{{ $reqIndex + 1 }}</td>
                                        <td class="p-2">{{ $persyaratan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">Tidak ada skema yang tersedia.</td>
                </tr>
                @endforelse

                <!-- Baris error untuk pencarian -->
                <tr id="noDataRow" class="hidden">
                    <td colspan="3" class="p-4 text-center text-red-500 italic">Tidak ada skema yang dapat ditemukan.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function searchTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const rows = document.querySelectorAll("#skemaTable tr:not(#noDataRow)");
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const isMatch = text.includes(input);
            row.style.display = isMatch ? "" : "none";
            if (isMatch) visibleCount++;
        });

        const noDataRow = document.getElementById("noDataRow");
        noDataRow.classList.toggle('hidden', visibleCount > 0);
    }

    function toggleContent(id) {
        const content = document.getElementById(id);
        content.classList.toggle('hidden');
    }
</script>
@endsection
