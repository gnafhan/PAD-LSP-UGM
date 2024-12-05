@extends('home.layouts.layout')

@section('title', 'Skema Sertifikasi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">

        <!-- Daftar Skema Sertifikasi -->
        <h2 class="text-xl font-bold mb-4 text-center">Daftar Skema Sertifikasi</h2>
        <table class="w-full bg-white rounded-md shadow-md">
            <!-- Pencarian -->
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Cari..." class="p-2 flex justify-end w-1/4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-left">No.</th>
                    <th class="p-2 text-left">Nomor / Judul Skema</th>
                    <th class="p-2 text-left">Unit dan Persyaratan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($skemaData as $index => $skema)
                <tr>
                    <td class="p-2 align-top">{{ $index + 1 }}</td>
                    <td class="p-2 text-start align-top">
                        {{ $skema->nomor_skema }} - {{ $skema->nama_skema }} <br>
                        <a href="#" class="bg-blue-500 text-white p-1 rounded">Dokumen SKKNI</a>
                    </td>
                    <td class="p-2 text-start">
                        <!-- Tombol Unit Kompetensi -->
                        <button onclick="toggleContent('unit{{ $index }}')" class="bg-blue-600 text-white p-2 rounded mb-2">Unit Kompetensi</button>
                        <!-- Konten Unit Kompetensi dengan tabel dummy -->
                        <div id="unit{{ $index }}" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">No.</th>
                                        <th class="p-2 text-left">Unit Kompetensi</th>
                                        {{-- <th class="p-2 text-left">Deskripsi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skema->unitKompetensi as $ukIndex => $unit)
                                    <tr>
                                        <td class="p-2 text-center">{{ $ukIndex + 1 }}</td>
                                        <td class="p-2">{{ $unit->nama_uk }}</td>
                                        {{-- <td class="p-2">Memahami dan menganalisis kebutuhan sistem informasi.</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Tombol Persyaratan Dasar Peserta -->
                        <button onclick="toggleContent('requirement{{ $index }}')" class="bg-blue-600 text-white p-2 rounded mb-2 mt-4">Persyaratan Dasar Peserta</button>
                        <!-- Konten Persyaratan Dasar Peserta dengan tabel dummy -->
                        <div id="requirement{{ $index }}" class="hidden mt-2 p-4 bg-gray-50 rounded-md">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-200">
                                        <th class="p-2 text-left">No.</th>
                                        <th class="p-2 text-left">Persyaratan</th>
                                        {{-- <th class="p-2 text-left">Deskripsi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($skema->parsed_persyaratan as $reqIndex => $persyaratan)
                                    <tr>
                                        <td class="p-2 text-center">{{ $reqIndex + 1 }}</td>
                                        <td class="p-2">{{ $persyaratan }}</td>
                                        {{-- <td class="p-2">Minimal lulusan SMA atau SMK dengan nilai memadai.</td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                @endforeach

                <!-- Tambahkan baris lain untuk skema lainnya -->

            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleContent(id) {
        const content = document.getElementById(id);
        content.classList.toggle('hidden');
    }
</script>
@endsection
