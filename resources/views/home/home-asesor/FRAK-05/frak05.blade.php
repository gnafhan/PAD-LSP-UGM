@extends('home.home-asesor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
            <div class="flex flex-wrap gap-2">
                <a href="/asesor1" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
                <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                FR.AK-05 LAPORAN ASESSMEN
                </div>
                <button class="bg-blue-500 text-white px-2 py-1 rounded text-sm md:text-base hover:bg-blue-700">SAVE</button>
            </div>

            <div class="flex flex-wrap gap-3 mt-5">
                <h2 class="text-lg font-semibold mb-4">FR.AK-05 LAPORAN ASESSMEN</h2>
            </div>
        <!-- Table structure -->

            <table class="w-full border-collapse border border-gray-300 text-sm">
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold" colspan="2">Skema Sertifikasi KKNI/Okupasi/Klaster</td>
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
                    <td class="border border-gray-300 p-2">Nama Asesor</td>
                    <td class="border border-gray-300 p-2" colspan="2">Annisa Mutia</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2">Tanggal</td>
                    <td class="border border-gray-300 p-2" colspan="2">10 November 2024</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold" colspan="2">Unit Kompetensi</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Kode Unit</td>
                    <td class="border border-gray-300 p-2">SKM/0317/123456/231</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Judul Unit</td>
                    <td class="border border-gray-300 p-2">Unit</td>
                </tr>

                <!-- Additional rows as needed -->
            </table>

            <!-- Table for Asesi Recommendations -->
            <table class="w-full border-collapse border border-gray-300 text-sm mt-5">
                <tr>
                    <th class="border border-gray-300 p-2 text-center">No.</th>
                    <th class="border border-gray-300 p-2 text-center">Nama Asesi</th>
                    <th class="border border-gray-300 p-2 text-center">Rekomendasi</th>
                    <th class="border border-gray-300 p-2 text-center">Keterangan</th>
                </tr>
                <!-- Row 1 -->
                <tr>
                    <td class="border border-gray-300 p-2 text-center">1.</td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2 text-center">
                        <input type="checkbox" class="mr-2"> K
                        <input type="checkbox" class="ml-4"> BK
                    </td>
                    <td class="border border-gray-300 p-2"></td>
                </tr>
                <!-- Row 2 -->
                <tr>
                    <td class="border border-gray-300 p-2 text-center">2.</td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2 text-center">
                        <input type="checkbox" class="mr-2"> K
                        <input type="checkbox" class="ml-4"> BK
                    </td>
                    <td class="border border-gray-300 p-2"></td>
                </tr>
                <!-- Row 3 -->
                <tr>
                    <td class="border border-gray-300 p-2 text-center">3.</td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2 text-center">
                        <input type="checkbox" class="mr-2"> K
                        <input type="checkbox" class="ml-4"> BK
                    </td>
                    <td class="border border-gray-300 p-2"></td>
                </tr>
                <!-- Row 4 -->
                <tr>
                    <td class="border border-gray-300 p-2 text-center">4.</td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2 text-center">
                        <input type="checkbox" class="mr-2"> K
                        <input type="checkbox" class="ml-4"> BK
                    </td>
                    <td class="border border-gray-300 p-2"></td>
                </tr>
            </table>

            <!-- Additional Information Table -->
            <table class="w-full border-collapse border border-gray-300 text-sm mt-5">
                <tr>
                    <th colspan="4" class="border border-gray-300 p-2 text-center text-sm font-normal">
                        Tuliskan Kode dan Judul Unit Kompetensi yang Dinyatakan BK
                    </th>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Aspek Negatif dan Positif dalam Asesmen</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 h-24"></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Pencatatan Penolakan Hasil Asesmen</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 h-24"></td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 font-semibold">Saran Perbaikan: (Asesor/Personil Terkait)</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2 h-24"></td>
                </tr>
            </table>

            <!-- Notes and Assessor Information -->
            <div class="mt-5">
                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <tr>
                        <td class="border border-gray-300 p-2 font-semibold w-1/2">Catatan :</td>
                        <td class="border border-gray-300 p-2 font-semibold w-1/2">Asesor :</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2 h-20"></td>
                        <td class="border border-gray-300 p-2">
                            <p>Nama :</p>
                            <p>No. Reg :</p>
                            <p>Tanda tangan/ Tanggal :</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
        </div>
    </div>
</div>
@endsection
