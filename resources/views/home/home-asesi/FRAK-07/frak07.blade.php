@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'FR.AK-07 - Penyesuaian yang Wajar dan Beralasan')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-24">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home-asesi') }}" class="text-gray-500 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">FR.AK-07</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">FR.AK-07 - Penyesuaian yang Wajar dan Beralasan</h1>
            <p class="mt-2 text-gray-600">Formulir penyesuaian sesuai karakteristik asesi dalam mengikuti asesmen kompetensi.</p>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="flex justify-center items-center py-12">
            <div class="text-center">
                <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-gray-600">Memuat data...</p>
            </div>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 hidden" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span id="errorText">Terjadi kesalahan.</span>
            </div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 hidden" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span id="successText">Berhasil!</span>
            </div>
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="hidden">
            <!-- Info Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Asesmen
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Peserta</p>
                            <p id="namaPeserta" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama Asesor</p>
                            <p id="namaAsesor" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Skema Sertifikasi</p>
                            <p id="judulSkema" class="font-medium text-gray-900">-</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Skema</p>
                            <p id="nomorSkema" class="font-medium text-gray-900">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div id="statusCard" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Status Formulir</h3>
                            <p id="statusText" class="text-sm text-gray-600">Menunggu asesor mengisi formulir</p>
                        </div>
                        <div id="statusBadge" class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-medium">
                            Belum Diisi
                        </div>
                    </div>
                </div>
            </div>

            <!-- Potensi Asesi Section -->
            <div id="potensiSection" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h3 class="text-white font-semibold">Potensi Asesi</h3>
                </div>
                <div class="p-6">
                    <div id="potensiContent" class="space-y-2">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Bagian A Section -->
            <div id="bagianASection" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-white font-semibold">Bagian A. Penyesuaian sesuai karakteristik asesi</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700 border border-gray-300">
                        <thead class="bg-gray-100 text-gray-900">
                            <tr>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center align-middle w-12">No</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 align-middle">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi (karakteristik asesi)</th>
                                <th colspan="2" class="border border-gray-300 px-2 py-2 text-center">Penyesuaian</th>
                            </tr>
                            <tr>
                                <th class="border border-gray-300 px-2 py-2 text-center w-16">Ya</th>
                                <th class="border border-gray-300 px-2 py-2 text-center w-16">Tidak</th>
                            </tr>
                        </thead>
                        <tbody id="bagianAContent">
                            <!-- Content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bagian B Section -->
            <div id="bagianBSection" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 hidden">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                    <h3 class="text-white font-semibold">Bagian B. Penyesuaian Rencana Asesmen</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700 border border-gray-300">
                        <thead class="bg-gray-100 text-gray-900">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2 text-center w-12">No</th>
                                <th class="border border-gray-300 px-4 py-2 text-left">Rekaman Rencana Asesmen</th>
                                <th class="border border-gray-300 px-4 py-2 text-center w-16">Ya</th>
                                <th class="border border-gray-300 px-4 py-2 text-center w-16">Tidak</th>
                                <th class="border border-gray-300 px-4 py-2 text-left w-1/4">Keputusan Penyesuaian</th>
                            </tr>
                        </thead>
                        <tbody id="bagianBContent">
                            <!-- Content will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Signature Section -->
            <div id="signatureSection" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h3 class="text-white font-semibold">Tanda Tangan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Asesor Signature -->
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-700 mb-2">Tanda Tangan Asesor</p>
                            <div id="asesorSignatureArea" class="w-full flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-10 bg-gray-50 min-h-[150px]">
                                <div id="asesorSignatureContent" class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Belum ditandatangani</p>
                                </div>
                                <div id="asesorSignaturePreview" class="hidden">
                                    <img id="asesorSignatureImage" src="" alt="Tanda Tangan Asesor" class="max-h-24 w-auto mx-auto border border-gray-200 rounded bg-white p-2">
                                    <p id="asesorSignatureDate" class="text-xs text-center mt-2 text-gray-500">Tanggal: -</p>
                                </div>
                            </div>
                            <p id="asesorName" class="mt-2 text-sm font-medium text-gray-700">-</p>
                        </div>

                        <!-- Asesi Signature -->
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-700 mb-2">Tanda Tangan Peserta</p>
                            <div id="asesiSignatureArea" class="w-full flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 px-6 py-10 bg-gray-50 min-h-[150px]">
                                <div id="asesiSignatureContent" class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Belum ditandatangani</p>
                                </div>
                                <div id="asesiSignaturePreview" class="hidden">
                                    <img id="asesiSignatureImage" src="" alt="Tanda Tangan Peserta" class="max-h-24 w-auto mx-auto border border-gray-200 rounded bg-white p-2">
                                    <p id="asesiSignatureDate" class="text-xs text-center mt-2 text-gray-500">Tanggal: -</p>
                                </div>
                            </div>
                            <p id="asesiName" class="mt-2 text-sm font-medium text-gray-700">-</p>
                            
                            <!-- Sign Button for Asesi (only show if asesor has signed but asesi hasn't) -->
                            <div id="signButtonContainer" class="mt-4 hidden">
                                <div class="flex items-center justify-center mb-3">
                                    <input id="agreeCheckbox" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                    <label for="agreeCheckbox" class="ml-2 text-sm text-gray-700">Saya menyetujui dan menandatangani formulir ini</label>
                                </div>
                                <button id="signButton" type="button" disabled class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Tanda Tangan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="flex justify-start">
                <a href="{{ route('home-asesi') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Not Available Section -->
        <div id="notAvailableSection" class="hidden">
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-8 text-center">
                <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Formulir Belum Tersedia</h3>
                <p class="text-yellow-700 mb-4">Formulir AK.07 belum diisi oleh asesor. Silakan tunggu asesor untuk mengisi formulir ini.</p>
                <a href="{{ route('home-asesi') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesiId: @json(Auth::user()->asesi->id_asesi ?? null),
        asesorId: @json(Auth::user()->asesi->rincianAsesmen->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    const headers = {
        'Content-Type': 'application/json',
        'API-KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest'
    };

    let currentData = null;

    async function loadAK07Data() {
        if (!apiConfig.asesiId) {
            showError('ID Asesi tidak ditemukan. Silakan login kembali.');
            return;
        }

        try {
            const response = await fetch(`${apiConfig.url}/asesmen/ak07/${apiConfig.asesiId}`, {
                method: 'GET',
                headers: headers
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success' && result.data) {
                currentData = result.data;
                displayData(result.data);
            } else {
                throw new Error(result.message || 'Gagal memuat data');
            }
        } catch (error) {
            console.error('Error loading AK07 data:', error);
            showError('Gagal memuat data: ' + error.message);
        }
    }

    function displayData(data) {
        hideLoading();

        const generalInfo = data.general_info;
        const ak07 = data.ak07;
        const recordExists = data.record_exists;

        // Update general info
        document.getElementById('namaPeserta').textContent = generalInfo?.nama_asesi || '-';
        document.getElementById('namaAsesor').textContent = generalInfo?.nama_asesor || '-';
        document.getElementById('judulSkema').textContent = generalInfo?.judul_skema || '-';
        document.getElementById('nomorSkema').textContent = generalInfo?.kode_skema || '-';

        if (!recordExists || !ak07) {
            document.getElementById('mainContent').classList.add('hidden');
            document.getElementById('notAvailableSection').classList.remove('hidden');
            return;
        }

        document.getElementById('mainContent').classList.remove('hidden');

        // Update status
        const isAsesorSigned = ak07.waktu_tanda_tangan_asesor;
        const isAsesiSigned = ak07.waktu_tanda_tangan_asesi;

        if (isAsesorSigned && isAsesiSigned) {
            document.getElementById('statusText').textContent = 'Formulir telah selesai';
            document.getElementById('statusBadge').className = 'px-4 py-2 rounded-full bg-green-100 text-green-800 font-medium';
            document.getElementById('statusBadge').textContent = 'Selesai';
        } else if (isAsesorSigned) {
            document.getElementById('statusText').textContent = 'Menunggu tanda tangan peserta';
            document.getElementById('statusBadge').className = 'px-4 py-2 rounded-full bg-blue-100 text-blue-800 font-medium';
            document.getElementById('statusBadge').textContent = 'Menunggu TTD Peserta';
        } else {
            document.getElementById('statusText').textContent = 'Menunggu asesor mengisi formulir';
            document.getElementById('statusBadge').className = 'px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-medium';
            document.getElementById('statusBadge').textContent = 'Belum Diisi';
        }

        // Display Potensi Asesi
        if (ak07.hasil_yang_akan_dikumpulkan && ak07.hasil_yang_akan_dikumpulkan.length > 0) {
            document.getElementById('potensiSection').classList.remove('hidden');
            let potensiHtml = '';
            ak07.hasil_yang_akan_dikumpulkan.forEach((item, index) => {
                potensiHtml += `<div class="flex items-center p-2 bg-blue-50 rounded">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-gray-700">${item}</span>
                </div>`;
            });
            document.getElementById('potensiContent').innerHTML = potensiHtml;
        }

        // Display Bagian A
        if (ak07.bagian_a && ak07.bagian_a.length > 0) {
            document.getElementById('bagianASection').classList.remove('hidden');
            let bagianAHtml = '';
            ak07.bagian_a.forEach((item, index) => {
                const penyesuaian = item.penyesuaian;
                const isYa = penyesuaian === 1 || penyesuaian === true || penyesuaian === '1';
                bagianAHtml += `<tr class="border-b border-gray-200">
                    <td class="border border-gray-300 px-2 py-2 text-center">${index + 1}</td>
                    <td class="border border-gray-300 px-2 py-2">${item.item || '-'}</td>
                    <td class="border border-gray-300 px-2 py-2 text-center">
                        ${isYa ? '<svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : ''}
                    </td>
                    <td class="border border-gray-300 px-2 py-2 text-center">
                        ${!isYa ? '<svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' : ''}
                    </td>
                </tr>`;
            });
            document.getElementById('bagianAContent').innerHTML = bagianAHtml;
        }

        // Display Bagian B
        if (ak07.bagian_b && ak07.bagian_b.length > 0) {
            document.getElementById('bagianBSection').classList.remove('hidden');
            let bagianBHtml = '';
            ak07.bagian_b.forEach((item, index) => {
                const penyesuaian = item.penyesuaian;
                const isYa = penyesuaian === 1 || penyesuaian === true || penyesuaian === '1';
                bagianBHtml += `<tr class="border-b border-gray-200">
                    <td class="border border-gray-300 px-4 py-2 text-center">${index + 1}</td>
                    <td class="border border-gray-300 px-4 py-2">${item.item || '-'}</td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        ${isYa ? '<svg class="w-5 h-5 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : ''}
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        ${!isYa ? '<svg class="w-5 h-5 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' : ''}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">${item.lainnya || '-'}</td>
                </tr>`;
            });
            document.getElementById('bagianBContent').innerHTML = bagianBHtml;
        }

        // Show signature section
        document.getElementById('signatureSection').classList.remove('hidden');

        // Asesor signature
        if (ak07.tanda_tangan_asesor) {
            document.getElementById('asesorSignatureContent').classList.add('hidden');
            document.getElementById('asesorSignaturePreview').classList.remove('hidden');
            document.getElementById('asesorSignatureImage').src = ak07.tanda_tangan_asesor;
            document.getElementById('asesorSignatureDate').textContent = 'Tanggal: ' + (ak07.waktu_tanda_tangan_asesor || '-');
        }
        document.getElementById('asesorName').textContent = generalInfo?.nama_asesor || '-';

        // Asesi signature
        if (ak07.tanda_tangan_asesi) {
            document.getElementById('asesiSignatureContent').classList.add('hidden');
            document.getElementById('asesiSignaturePreview').classList.remove('hidden');
            document.getElementById('asesiSignatureImage').src = ak07.tanda_tangan_asesi;
            document.getElementById('asesiSignatureDate').textContent = 'Tanggal: ' + (ak07.waktu_tanda_tangan_asesi || '-');
        }
        document.getElementById('asesiName').textContent = generalInfo?.nama_asesi || '-';

        // Show sign button if asesor has signed but asesi hasn't
        if (isAsesorSigned && !isAsesiSigned) {
            document.getElementById('signButtonContainer').classList.remove('hidden');
        }
    }

    // Sign function for asesi
    async function signAK07() {
        if (!apiConfig.asesiId || !apiConfig.asesorId) {
            showError('Data tidak lengkap untuk menandatangani.');
            return;
        }

        const signButton = document.getElementById('signButton');
        const signButtonContainer = document.getElementById('signButtonContainer');
        const originalButtonHtml = signButton.innerHTML;
        
        signButton.disabled = true;
        signButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';

        try {
            const response = await fetch(`${apiConfig.url}/asesmen/ak07/asesi/save`, {
                method: 'POST',
                headers: headers,
                body: JSON.stringify({
                    id_asesi: apiConfig.asesiId,
                    id_asesor: apiConfig.asesorId,
                    is_signing: true
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success') {
                showSuccess('Formulir berhasil ditandatangani!');
                // Hide the sign button container immediately
                signButtonContainer.classList.add('hidden');
                // Reload page after short delay to show updated data
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(result.message || 'Gagal menandatangani formulir');
            }
        } catch (error) {
            console.error('Error signing AK07:', error);
            showError('Gagal menandatangani: ' + error.message);
            // Reset button state on error
            signButton.disabled = false;
            signButton.innerHTML = originalButtonHtml;
            document.getElementById('agreeCheckbox').checked = false;
        }
    }

    function showError(message) {
        document.getElementById('loadingIndicator').classList.add('hidden');
        document.getElementById('errorMessage').classList.remove('hidden');
        document.getElementById('errorText').textContent = message;
    }

    function showSuccess(message) {
        document.getElementById('successMessage').classList.remove('hidden');
        document.getElementById('successText').textContent = message;
        setTimeout(() => {
            document.getElementById('successMessage').classList.add('hidden');
        }, 5000);
    }

    function hideLoading() {
        document.getElementById('loadingIndicator').classList.add('hidden');
    }

    // Event listeners
    document.getElementById('agreeCheckbox').addEventListener('change', function() {
        document.getElementById('signButton').disabled = !this.checked;
    });

    document.getElementById('signButton').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menandatangani formulir ini? Tanda tangan tidak dapat dibatalkan.')) {
            signAK07();
        }
    });

    // Initialize
    loadAK07Data();
});
</script>
@endsection
