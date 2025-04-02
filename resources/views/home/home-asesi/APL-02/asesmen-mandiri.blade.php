@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
<!-- Kontainer Utama -->
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

                <!-- Tombol Aksi -->
                <div class="flex flex-wrap gap-2">
                    <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i> <!-- Ikon Font Awesome -->
                    </a>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                        FR.APL.02 ASESMEN MANDIRI
                    </div>
                </div>

                <!-- Judul Halaman -->
                <h2 class="text-lg font-semibold mb-4 mt-2">FR-APL-02 ASSESMEN MANDIRI</h2>

                <!-- Struktur Tabel -->
                <div class="border border-gray-300 rounded-lg p-4 mb-6">
                    <table class="w-full border-collapse border border-gray-300 text-sm mb-6">
                        <tbody>
                            <tr>
                                <td colspan="2" class="border border-gray-300 p-2"><i>Panduan Assesmen Mandiri</i></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border border-gray-300 p-2 font-semibold">Skema Sertifikasi Klaster/Asesmen</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Judul Skema Sertifikasi</td>
                                <td class="border border-gray-300 p-2">{{ $asesi->skema->nama_skema ?? 'Tidak ditemukan' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nomor Skema Sertifikasi</td>
                                <td class="border border-gray-300 p-2">{{ $asesi->skema->nomor_skema ?? 'Tidak ditemukan' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">TUK</td>
                                <td class="border border-gray-300 p-2">{{ $event->tuk ?? 'Tidak ditemukan' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nama Asesor</td>
                                <td class="border border-gray-300 p-2">{{ $asesi->asesor->nama_asesor ?? 'Tidak ditemukan' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nama Peserta</td>
                                <td class="border border-gray-300 p-2">{{ $asesi->nama_asesi ?? 'Tidak ditemukan' }}</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Hari/Tanggal</td>
                                <td class="border border-gray-300 p-2">{{ $today->translatedFormat('l, d F Y') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Instruksi untuk Peserta -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold">Peserta diminta untuk:</h3>
                        <ul class="list-disc ml-5 mb-4">
                            <li>Mempelajari Kriteria Unjuk Kerja (KUK), Batasan Variabel, Panduan Penilaian, dan Aspek Kritis seluruh Unit Kompetensi yang diminta untuk di Ases.</li>
                            <li>Melaksanakan Penilaian Mandiri secara obyektif atas sejumlah pertanyaan yang diajukan.</li>
                            <li>Mengisi bukti-bukti kompetensi yang relevan atas sejumlah pertanyaan yang dinyatakan Kompeten (bila ada).</li>
                            <li>Menandatangani form Asesmen Mandiri.</li>
                        </ul>

                        <!-- Bukti Kompetensi -->
                        <div class="p-4 mb-4 flex flex-col gap-4">
                            <h2 class="text-lg font-semibold">Bukti Kompetensi</h2>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <button id="tambahBukti" class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600 mb-4">
                                    Tambah Bukti
                                </button>
                            </div>
                            <table id="tabelBukti" class="w-full border border-gray-200 text-sm mb-4">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border border-gray-300 p-2 text-left font-semibold">Bukti Portfolio yang relevan</th>
                                        <th class="border border-gray-300 p-2 text-left font-semibold">Keterangan</th>
                                        <th class="border border-gray-300 p-2 text-left font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <!-- Unit Kompetensi -->
                            <h2 class="text-lg font-semibold mb-4">Unit Kompetensi</h2>

                            @foreach($unitKompetensi as $uk)
                            <table class="w-full border-collapse border border-gray-300 text-sm mb-4">
                                <tr>
                                    <td class="border border-gray-300 p-2 font-semibold w-1/4">Kode Unit</td>
                                    <td class="border border-gray-300 p-2">{{ $uk->kode_uk }}</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 p-2 font-semibold">Judul Unit</td>
                                    <td class="border border-gray-300 p-2">{{ $uk->nama_uk }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="border border-gray-300 p-2 font-semibold text-left">Elemen Unit Kompetensi</td>
                                </tr>
                                <!-- Menampilkan elemen_uk langsung tanpa foreach -->
                                <tr class="bg-gray-100">
                                    <td class="border border-gray-300 p-2" colspan="2">
                                        <!-- Tampilkan setiap elemen dengan checkbox masing-masing -->
                                        <table class="w-full">
                                            <thead>
                                                <tr>
                                                    <th class="text-left w-3/4 p-1">Elemen Kompetensi</th>
                                                    <th class="text-center w-1/4 p-1">Kompeten</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($uk->elemen_uk as $index => $elemen)
                                                <tr>
                                                    <td class="p-1">
                                                        <div class="flex">
                                                            <span class="mr-2">{{ $index + 1 }}.</span>
                                                            <span>{{ $elemen->nama_elemen }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center p-1">
                                                        <input type="checkbox" name="kompeten[{{ $uk->id_uk }}][{{ $elemen->id_elemen_uk }}]" class="h-4 w-4 text-blue-500" />
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="2" class="p-1 text-gray-500 italic">Tidak ada elemen yang tersedia</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">SAVE</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#tambahBukti').on('click', function() {
            const tbody = $('#tabelBukti tbody');
            const row = $('<tr>');

            row.html(`
                <td class="border border-gray-300 p-2">
                    <input type="file" name="bukti_portofolio[]" class="w-full border border-gray-300 p-1" />
                </td>
                <td class="border border-gray-300 p-2">
                    <input type="text" name="keterangan[]" placeholder="Masukkan keterangan" class="w-full border border-gray-300 p-1" />
                </td>
                <td class="border border-gray-300 p-2">
                    <button type="button" class="hapusBukti bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                        Hapus
                    </button>
                </td>
            `);

            tbody.append(row);

            // Tambahkan event listener untuk tombol hapus
            row.find('.hapusBukti').on('click', function() {
                row.remove();
            });
        });
    });
</script>
@endsection
