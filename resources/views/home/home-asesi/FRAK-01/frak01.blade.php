@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
                <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                                <i class="fas fa-arrow-left"></i> <!-- Ikon Font Awesome -->
                    </button>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                    FR.AK-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
                    </div>
                </div>

            <div class="flex flex-wrap gap-3 mt-5">
                <h2 class="text-lg font-semibold mb-4">FR.AK-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI </h2>
            </div>
                <!-- Table structure -->
                <div class="border border-gray-300 rounded-lg p-4 mb-6">
                    <table class="w-full border-collapse border border-gray-300 text-sm">
                        <tr>
                            <td class="border border-gray-300 p-2" colspan="2"> <i>Persetujuan Asesmen ini untuk menjamin bahwa Peserta telah diberi arahan secara rinci tentang perencanaan dan proses asesmen</i></td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold" colspan="2">Skema Sertifikasi Klaster/Asesmen</td>
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
                            <td class="border border-gray-300 p-2">
                                <select id="tuk-select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="pilih TUK">Pilih TUK</option>
                                    <option value="sewaktu">Sewaktu</option>
                                    <option value="tempat-kerja">Tempat Kerja</option>
                                    <option value="mandiri">Mandiri</option>
                                </select>
                            </td>
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
                            <td class="border border-gray-300 p-2 font-semibold">Bukti yang dikumpulkan</td>
                            <td class="border border-gray-300 p-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="portfolio-verification" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="portfolio-verification" class="ml-2">TL : Hasil Verifikasi Portfolio</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="essay-question" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="essay-question" class="ml-2">T : Hasil Pertanyaan Tulis Essay</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="multiple-choice" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="multiple-choice" class="ml-2">T : Hasil Tulis Pilihan Ganda</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="oral-question" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="oral-question" class="ml-2">T : Hasil Pertanyaan Lisan</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="essay-question" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="essay-question" class="ml-2">L : Hasil Observasi Langsung</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="multiple-choice" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="multiple-choice" class="ml-2">L : Hasil Kegiatan Terstruktur</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="oral-question" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label for="oral-question" class="ml-2">T : Hasil Pertanyaan Wawancara</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold" colspan="2">Pelaksanaan Assesmen yang disepakati</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2">Hari/Tanggal</td>
                            <td class="border border-gray-300 p-2" colspan="2">{{ $today->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2">TUK</td>
                            <td class="border border-gray-300 p-2" colspan="2">
                                @if(is_string($event->tuk))
                                        {{ $event->tuk }}
                                    @elseif(is_object($event->tuk))
                                        <div>
                                            <span class="font-semibold">{{ $event->tuk->nama_tuk }}</span> ({{ $event->tuk->kode_tuk }})
                                            <div class="text-xs text-gray-600 mt-1">{{ $event->tuk->alamat }}</div>
                                            <div class="text-xs text-gray-500">No. Lisensi: {{ $event->tuk->no_lisensi_skkn }}</div>
                                        </div>
                                    @else
                                        Tidak ditemukan
                                    @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold" colspan="2">Asesi</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2" colspan="2">Bahwa saya sudah mendapatkan penjelasan Hak dan Prosedur Banding Oleh Asesor</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2 font-semibold" colspan="2">Assesor</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-300 p-2" colspan="2">Saya setuju assesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</td>
                        </tr>


                        <!-- Additional rows as needed -->
                    </table>
                </div>

                    <div class="flex justify-between">
                        <div>
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <label for="approve-pemohon" class="text-sm">Tanda Tangan Asesi</label>
                            </div>
                            <p class="mt-2">TTD: <img src="{{ asset('images/signature.jpg') }}" alt="Signature" class="h-6 inline"></p>
                            <p>{{ $today->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="checkbox" id="approve-admin" checked disabled class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked readonly>
                                <label for="approve-admin" class="text-sm">Tanda Tangan Assesor</label>
                            </div>
                            <p class="mt-2">TTD: <img src="{{ asset('images/admin-signature.jpg') }}" alt="Asesor Signature" class="h-6 inline"></p>
                            <p>{{ $today->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
