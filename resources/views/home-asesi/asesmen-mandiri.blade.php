@extends('home.layouts.layout')

@section('title', 'Profil Peserta - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
        <!-- Progress Bar -->
        <div class="flex justify-between items-center mb-8">
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
        <p class="text-sm text-gray-800 ml-2">Data Pengajuan</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">2</div>
        <p class="text-sm text-gray-800 ml-2">Profil Peserta</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400  text-white">3</div>
        <p class="text-sm text-gray-800 ml-2">Menunggu Konfirmasi</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">4</div>
        <p class="text-sm text-gray-800 ml-2">Dokumen Portofolio</p>
    </div>
    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">5</div>
        <p class="text-sm text-gray-800 ml-2">Asesmen Mandiri</p>
    </div>
    </div>

    <!-- Judul Form -->
    <div class="border border-gray-300 rounded-lg p-4">
        <h2 class="text-xl font-semibold mb-4 text-center">Asesmen Mandiri</h2>
        <p class="text-sm mb-6 text-center">Centang data jika sudah sesuai!</p>

        <!-- Tabel Unit Kompetensi -->
        <div class="border border-gray-300 rounded-lg p-4 mb-8">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">NO</th>
                        <th class="border border-gray-300 px-4 py-2">Kode Unit</th>
                        <th class="border border-gray-300 px-4 py-2">Kriteria Unit Kompetensi</th>
                        <th class="border border-gray-300 px-4 py-2">K</th>
                        <th class="border border-gray-300 px-4 py-2">BK</th>
                        <th class="border border-gray-300 px-4 py-2">Bukti Relevan</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">1</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">3415431</td>
                        <td class="border border-gray-300 px-4 py-2 text-bold text-black">Mengaplikasikan prinsip desain</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            </td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-bold">Apakah anda dapat menjelaskan definisi Desain?</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                                <input type="file" id="dokumen5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-bold">Apakah anda dapat menjelaskan konsep Desain?</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                                <input type="file" id="dokumen5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">2</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">466425</td>
                        <td class="border border-gray-300 px-4 py-2 text-bold text-black">Menjelaskan pengertian dasar desain</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            </td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-bold">Apakah Anda dapat menguraikan mengenai elemen desain?</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                                <input type="file" id="dokumen5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-bold">Apakah Anda dapat menjelaskan seni dan desain?</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                                <input type="file" id="dokumen5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </td>
                    </tr>

                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"></td>
                        <td class="border border-gray-300 px-4 py-2 text-bold">Apakah Anda dapat menjelaskan yang dimaksud dengan DKV?</td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center"> 
                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                                <input type="file" id="dokumen5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        <div class="flex justify-between">
        <a href="/asesmen-mandiri" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">Selanjutnya</a>
        </div>
    </div>
</div>
@endsection
