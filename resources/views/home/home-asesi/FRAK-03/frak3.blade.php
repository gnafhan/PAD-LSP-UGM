@extends('home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

        <div class="flex flex-wrap gap-2">
            <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
            <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
            FR-AK-03 UMPAN BALIK PESERTA
            </div>
            <button class="bg-blue-500 text-white px-2 py-1 rounded text-sm md:text-base hover:bg-blue-700">SAVE</button>
        </div>
        
        <div class="flex flex-wrap gap-3 mt-5">
            <h2 class="text-lg font-semibold mb-4">FR-AK-03 UMPAN BALIK PESERTA</h2>
        </div>

        <!-- Table structure -->
        <div class="border border-gray-300 rounded-lg p-4 mb-6">
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <tr>
                    <td class="border border-gray-300 p-2" colspan="2"><i>Panduan Mengisi</i></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold" colspan="2">Skema Sertifikasi Klaster/Asesmen</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Judul Skema Sertifikasi</td>
                    <td class="border border-gray-300 p-2">Junior Web Developer</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Nomor Skema Sertifikasi</td>
                    <td class="border border-gray-300 p-2">SKM/0317/00010/2/2019/14</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">TUK</td>
                    <td class="border border-gray-300 p-2">VOKASI UGM</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Nama Asesor</td>
                    <td class="border border-gray-300 p-2">Imam Fahrurrozi</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Nama Peserta</td>
                    <td class="border border-gray-300 p-2">Ahmad Fatha Mumtaza</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Hari/Tanggal</td>
                    <td class="border border-gray-300 p-2" colspan="2">10 November 2024</td>
                </tr>
            </table>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Peserta diminta untuk:</h3>
                <ul>
                    <li>- Umpan Balik dari asesi (diisikan oleh Asesi setelah pengambilan keputusan)</li>
                </ul>
                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 p-2">No.</th>
                            <th class="border border-gray-300 p-2">Komponen</th>
                            <th class="border border-gray-300 p-2">Hasil: Ya</th>
                            <th class="border border-gray-300 p-2">Hasil: Tidak</th>
                            <th class="border border-gray-300 p-2">Catatan Asesi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-300 p-2 text-center">1</td>
                            <td class="border border-gray-300 p-2">Saya mendapatkan penjelasan yang cukup memadai mengenai proses asesmen/uji kompetensi</td>
                            <td class="border border-gray-300 p-2 text-center">
                                <input type="checkbox" id="hasil-ya" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </td>
                            <td class="border border-gray-300 p-2 text-center">
                                <input type="checkbox" id="hasil-tidak" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </td>
                            <td class="border border-gray-300 p-2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
