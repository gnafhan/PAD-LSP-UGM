@extends('home.home-visitor.layouts.layout')

@section('title', 'Bukti Kelengkapan - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="bg-gray-100 min-h-screen py-32 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl mx-auto overflow-hidden">
        <!-- Header Section -->
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Formulir Permohonan Sertifikasi Kompetensi
            </h2>
        </div>

        <!-- Progress Indicator -->
        <div class="px-8 pt-6">
            <div class="flex flex-wrap justify-between items-center mb-8">
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs mt-2 text-gray-600">Data Pribadi</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-green-200"></div>
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-xs mt-2 text-gray-600">Data Sertifikasi</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-blue-200"></div>
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">3</div>
                    <span class="text-xs mt-2 text-blue-800 font-semibold">Bukti Kelengkapan</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-semibold">4</div>
                    <span class="text-xs mt-2 text-gray-600">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Alert Message Container -->
        <div id="message" class="px-8 mt-4">
            @if(isset($revisionMessage))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ $revisionMessage }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error') || session('errorSession'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ session('error') ?? session('errorSession') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium">Periksa kembali data yang Anda masukkan:</p>
                    </div>
                    <ul class="mt-2 text-sm text-red-700 pl-6 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Form Content -->
        <div class="p-8">
            <form id="bukti-kelengkapan-form" method="POST" action="{{ route('user.apl1.save.bukti') }}" enctype="multipart/form-data">
                @csrf

                <!-- Section: Bukti Kelengkapan Pemohon -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Bukti Kelengkapan Pemohon</h3>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 ml-11">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Petunjuk Pengisian:</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Hanya upload dokumen yang relevan</li>
                                        <li>Upload hasil Kompetensi dengan keterangannya (Scan Ijazah Kompetensi, kursus, pengalaman kerja, dll yang berhubungan dengan keahlian Anda)</li>
                                        <li>Semua dokumen harus dalam format PDF dengan ukuran maksimal 2MB per file</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Bukti Persyaratan Dasar -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Bukti Persyaratan Dasar Pemohon</h3>
                        </div>

                        <p class="text-sm text-gray-500 mb-4 ml-11">Unggah semua file dalam bentuk PDF dengan ukuran maksimal 2MB per file.</p>

                        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm ml-11">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 text-center">NO</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Dasar</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">1</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Siswa Jenjang SMK / Sederajat Semester Akhir</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <input id="bukti_jenjang_siswa" name="bukti_jenjang_siswa" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 2MB)</p>
                                            <!-- Tambahkan di dalam <td> setelah input file bukti_ktp -->
                                            @if(isset($pengajuan->file_kelengkapan_pemohon['bukti_ktp']))
                                                <div class="file-selected-indicator text-xs text-green-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>File sudah diupload</span>
                                                    <a href="{{ asset($pengajuan->file_kelengkapan_pemohon['bukti_ktp']) }}" target="_blank" class="ml-2 text-blue-500 underline">Lihat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">2</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Transkrip Nilai / Sertifikat pelatihan di bidang Skema</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <input id="bukti_transkrip" name="bukti_transkrip" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 2MB)</p>
                                            @if(isset($pengajuan->file_kelengkapan_pemohon['bukti_transkrip']))
                                                <div class="file-selected-indicator text-xs text-green-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>File sudah diupload</span>
                                                    <a href="{{ asset($pengajuan->file_kelengkapan_pemohon['bukti_transkrip']) }}" target="_blank" class="ml-2 text-blue-500 underline">Lihat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">3</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Surat Pengalaman Kerja</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <input id="bukti_pengalaman_kerja" name="bukti_pengalaman_kerja" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 2MB)</p>
                                            @if(isset($pengajuan->file_kelengkapan_pemohon['bukti_pengalaman_kerja']))
                                                <div class="file-selected-indicator text-xs text-green-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>File sudah diupload</span>
                                                    <a href="{{ asset($pengajuan->file_kelengkapan_pemohon['bukti_pengalaman_kerja']) }}" target="_blank" class="ml-2 text-blue-500 underline">Lihat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">4</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Surat Keterangan PKL/Magang</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <input id="bukti_magang" name="bukti_magang" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 2MB)</p>
                                            @if(isset($pengajuan->file_kelengkapan_pemohon['bukti_magang']))
                                                <div class="file-selected-indicator text-xs text-green-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>File sudah diupload</span>
                                                    <a href="{{ asset($pengajuan->file_kelengkapan_pemohon['bukti_magang']) }}" target="_blank" class="ml-2 text-blue-500 underline">Lihat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Section: Bukti Administratif -->
                    <div class="mb-8">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800">Bukti Administratif</h3>
                        </div>

                        <p class="text-sm text-gray-500 mb-4 ml-11">Dokumen administratif wajib dilengkapi.</p>

                        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm ml-11">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 text-center">NO</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Administratif</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Upload Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">1</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">KTP</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <input id="bukti_ktp" name="bukti_ktp" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 2MB)</p>
                                            @if(isset($pengajuan->file_kelengkapan_pemohon['bukti_ktp']))
                                                <div class="file-selected-indicator text-xs text-green-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>File sudah diupload</span>
                                                    <a href="{{ asset($pengajuan->file_kelengkapan_pemohon['bukti_ktp']) }}" target="_blank" class="ml-2 text-blue-500 underline">Lihat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">2</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">Foto 3x4</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <input id="bukti_foto" name="bukti_foto" type="file" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Format: PDF (Maks. 2MB)</p>
                                            @if(isset($pengajuan->file_kelengkapan_pemohon['bukti_foto']))
                                                <div class="file-selected-indicator text-xs text-green-600 mt-1 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>File sudah diupload</span>
                                                    <a href="{{ asset($pengajuan->file_kelengkapan_pemohon['bukti_foto']) }}" target="_blank" class="ml-2 text-blue-500 underline">Lihat</a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 ml-11 bg-blue-50 p-4 rounded-lg shadow-sm border border-blue-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">Pastikan dokumen yang Anda unggah memiliki kualitas gambar yang baik dan terbaca. Dokumen yang tidak jelas dapat menyebabkan proses verifikasi tertunda.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between">
            <a href="{{ route('user.apl1.sertifikasi') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            <button type="button" id="btn-selanjutnya" class="px-4 py-2 rounded-md border border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                <span id="button-text">Simpan & Lanjutkan</span>
                <span id="button-loading" class="hidden ml-1">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // File upload visual feedback
        const fileInputs = document.querySelectorAll('input[type="file"]');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileLabel = this.nextElementSibling;
                if (this.files.length) {
                    // Check file size (max 2MB)
                    const fileSize = this.files[0].size / 1024 / 1024; // in MB
                    const maxSize = this.accept.includes('image') ? 1 : 2; // 1MB for images, 2MB for PDFs

                    if (fileSize > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: `Ukuran file maksimal ${maxSize}MB. File Anda berukuran ${fileSize.toFixed(2)}MB.`,
                            confirmButtonColor: '#EF4444'
                        });
                        this.value = ''; // Reset file input
                        return;
                    }

                    // Add a checkmark or some visual indicator that file is selected
                    const parent = this.closest('td');
                    if (parent) {
                        if (!parent.querySelector('.file-selected-indicator')) {
                            const indicator = document.createElement('div');
                            indicator.className = 'file-selected-indicator text-xs text-green-600 mt-1 flex items-center';
                            indicator.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                File dipilih: ${this.files[0].name}
                            `;
                            parent.appendChild(indicator);
                        } else {
                            parent.querySelector('.file-selected-indicator').innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                File dipilih: ${this.files[0].name}
                            `;
                        }
                    }
                }
            });
        });

    // Form submission handler
    document.getElementById('btn-selanjutnya').addEventListener('click', function(event) {
        event.preventDefault();

        // Show loading state
        const buttonText = document.getElementById('button-text');
        const buttonLoading = document.getElementById('button-loading');

        buttonText.textContent = 'Mengunggah...';
        buttonLoading.classList.remove('hidden');
        this.disabled = true;

        // Definisi semua jenis dokumen yang perlu diperiksa
        const documentTypes = [
            'bukti_ktp',
            'bukti_foto',
            'bukti_jenjang_siswa',
            'bukti_transkrip',
            'bukti_pengalaman_kerja',
            'bukti_magang'
        ];

        // Menyimpan status dokumen wajib (KTP)
        let ktpExists = false;

        // Menyimpan status apakah ada dokumen yang dipilih/diupload
        let anyDocumentExists = false;

        // Periksa setiap jenis dokumen
        documentTypes.forEach(docType => {
            // Periksa jika ada file baru yang diupload
            const input = document.getElementById(docType);
            if (input && input.files.length > 0) {
                anyDocumentExists = true;
                if (docType === 'bukti_ktp') {
                    ktpExists = true;
                }
            }

            // Periksa jika sudah ada file yang diupload sebelumnya
            const inputCell = input ? input.closest('td') : null;
            if (inputCell && inputCell.querySelector('.file-selected-indicator')) {
                anyDocumentExists = true;
                if (docType === 'bukti_ktp') {
                    ktpExists = true;
                }
            }
        });

        // Jika tidak ada dokumen sama sekali
        if (!anyDocumentExists) {
            // Reset button state
            buttonText.textContent = 'Simpan & Lanjutkan';
            buttonLoading.classList.add('hidden');
            this.disabled = false;

            Swal.fire({
                icon: 'warning',
                title: 'Formulir Belum Lengkap',
                text: 'Unggah minimal satu dokumen untuk melanjutkan.',
                confirmButtonColor: '#F59E0B'
            });
            return;
        }

        // Khusus untuk KTP (dokumen wajib)
        if (!ktpExists) {
            // Reset button state
            buttonText.textContent = 'Simpan & Lanjutkan';
            buttonLoading.classList.add('hidden');
            this.disabled = false;

            Swal.fire({
                icon: 'warning',
                title: 'Dokumen Wajib',
                text: 'Unggah scan KTP Anda (dokumen wajib).',
                confirmButtonColor: '#F59E0B'
            });
            return;
        }

        // Submit the form
        document.getElementById('bukti-kelengkapan-form').submit();
        });
    });
</script>
@endsection
