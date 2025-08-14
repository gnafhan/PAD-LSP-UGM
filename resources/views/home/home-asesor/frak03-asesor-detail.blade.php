@extends('home.home-asesor.layouts.layout')

@section('title', 'Detail FR.AK-03 - Asesor')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
        <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
                <defs>
                    <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                        <stop offset="0%" stop-color="#3B82F6" />
                        <stop offset="100%" stop-color="#8B5CF6" />
                    </linearGradient>
                </defs>
                <path d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z" />
            </svg>
            <p class="ms-2 text-xl font-bold bg-gradient-to-r from-biru to-ungu text-transparent bg-clip-text">Formulir Umpan Balik dan Catatan Asesmen</p>
        </div>
        <div id="breadcrumbs" class="pb-4 px-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home-asesor') }}" class="inline-flex items-center text-sm font-medium text-black hover:text-sidebar_font">
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4" />
                            </svg>
                            <a href="{{ route('frak03-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                                FR.AK.03
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4" />
                            </svg>
                            <span id="breadcrumbAsesiName" class="ms-1 text-sm font-medium text-black">Memuat...</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div id="bgGradient" class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
        </div>

        <div id="loadingIndicator" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
            <span>Memuat data...</span>
        </div>

        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
            <span id="errorText">Terjadi kesalahan saat memuat data.</span>
        </div>

        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 hidden" role="alert">
            <span id="successText">Data berhasil disimpan.</span>
        </div>

        <div id="frameAK03" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
            <form id="ak03Form" class="text-black">
                <div class="p-4 space-y-2">
                    <div class="flex">
                        <span class="inline-flex items-center min-w-fit w-1/3 md:w-1/4">Judul Sertifikasi</span>
                        <p id="judulSertifikasi" class="font-semibold">Memuat...</p>
                    </div>
                    <div class="flex">
                        <span class="inline-flex items-center min-w-fit w-1/3 md:w-1/4">Nomor Sertifikasi</span>
                        <p id="nomorSertifikasi">Memuat...</p>
                    </div>
                    <hr class="my-4">
                    <div class="flex">
                        <span class="inline-flex items-center min-w-fit w-1/3 md:w-1/4">Nama Peserta Sertifikasi</span>
                        <p id="namaPeserta" class="font-semibold">Memuat...</p>
                    </div>
                    <div class="flex">
                        <span class="inline-flex items-center min-w-fit w-1/3 md:w-1/4">Nama Asesor</span>
                        <p id="namaAsesor">Memuat...</p>
                    </div>
                    <div class="flex">
                        <span class="inline-flex items-center min-w-fit w-1/3 md:w-1/4">TUK</span>
                        <p id="tuk">Memuat...</p>
                    </div>
                </div>

                <div class="p-4 mt-6">
                    <p class="font-medium text-black">Umpan balik kepada asesi (diisi oleh asesor setelah pengambilan keputusan):</p>
                    <div class="border rounded-lg mt-2 overflow-hidden">
                        <table class="min-w-full text-sm">
                            <tbody class="divide-y divide-gray-200">
                                <tr class="divide-x divide-gray-200">
                                    <td class="p-3 w-1/3 md:w-1/4 font-semibold text-gray-700">Umpan balik terhadap pencapaian unjuk kerja</td>
                                    <td class="p-2">
                                        <textarea id="umpan_balik_pencapaian" name="umpan_balik_pencapaian" rows="3" class="block p-2.5 w-full text-sm rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Contoh: Identifikasi kesenjangan pencapaian unjuk kerja"></textarea>
                                    </td>
                                </tr>
                                <tr class="divide-x divide-gray-200">
                                    <td class="p-3 w-1/3 md:w-1/4 font-semibold text-gray-700">Saran tindak lanjut hasil asesmen</td>
                                    <td class="p-2">
                                        <textarea id="saran_tindak_lanjut" name="saran_tindak_lanjut" rows="3" class="block p-2.5 w-full text-sm rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Contoh: Agar memelihara kompetensi yang telah dicapai"></textarea>
                                    </td>
                                </tr>
                                <tr class="divide-x divide-gray-200">
                                    <td class="p-3 w-1/3 md:w-1/4 font-semibold text-gray-700">Seluruh Elemen Kompetensi/Kriteria Unjuk Kerja (KUK) yang diujikan telah tercapai</td>
                                    <td class="p-2">
                                        <textarea id="catatan_pencapaian_kompetensi" name="catatan_pencapaian_kompetensi" rows="3" class="block p-2.5 w-full text-sm rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Contoh: Tidak ada kesenjangan"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="asesiFeedbackContainer" class="p-4 mt-2">
                    <p class="font-medium text-black">Umpan balik dari asesi (diisi oleh asesi setelah pengambilan keputusan):</p>
                    <div id="asesiFeedbackContent" class="mt-2">
                        <p class="text-center text-gray-500">Memuat umpan balik asesi...</p>
                    </div>
                </div>

                <div id="unitKompetensiContainer" class="p-4 space-y-8">
                    <p class="text-center text-gray-500">Memuat unit kompetensi...</p>
                </div>

                <div class="p-4">
                    <label for="rekomendasi" class="block mb-2 text-sm font-medium">Catatan</label>
                    <textarea id="rekomendasi" name="rekomendasi" rows="4" class="block p-2.5 w-full text-sm rounded-lg border border-border_input focus:ring-biru focus:border-biru" placeholder="Masukkan catatan atau umpan balik lainnya di sini..."></textarea>
                </div>

                <div id="signatureContainer" class="p-4 mt-8">
                    <p class="font-medium text-black mb-4">Tandatangan</p>
                    <div class="flex flex-col md:flex-row justify-between items-start gap-8">
                        <div class="w-full md:w-1/2 text-center">
                            <p id="asesorSignatureDate" class="mb-2">15 Maret 2025</p>
                            <div id="asesorSignatureImage" class="h-28 flex justify-center items-center">
                                <span class="text-gray-400">Tanda Tangan Asesor</span>
                            </div>
                            <p class="font-semibold mt-2 border-t pt-2" id="asesorSignatureName">Memuat...</p>
                            <p>Asesor</p>
                        </div>
                        <div class="w-full md:w-1/2 text-center">
                            <p id="asesiSignatureDate" class="mb-2">15 Maret 2025</p>
                            <div id="asesiSignatureImage" class="h-28 flex justify-center items-center">
                                <span class="text-gray-400">Tanda Tangan Asesi</span>
                            </div>
                            <p class="font-semibold mt-2 border-t pt-2" id="asesiSignatureName">Memuat...</p>
                            <p>Asesi</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end p-4">
                    <button id="simpanAK03" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-8 py-3 text-sm font-semibold hover:bg-biru_soft focus:outline-none">
                        Simpan dan Setuju
                    </button>
                </div>
            </form>
        </div>
        <div id="bgGradient" class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
        </div>
    </div>

    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4" id="confirmationTitle">Konfirmasi Penyimpanan</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="confirmationMessage">
                        Apakah Anda yakin ingin menyimpan penilaian untuk formulir FR.AK-03 ini?
                        <br><br>
                        <strong class="text-red-600">Perhatian:</strong> Data yang sudah disimpan mungkin tidak dapat diubah lagi. Pastikan semua penilaian sudah benar.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmYesBtn" class="px-4 py-2 bg-gradient-to-r from-biru to-ungu text-white text-base font-medium rounded-md w-20 mr-2 hover:from-blue-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Ya
                    </button>
                    <button id="confirmNoBtn" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-20 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // =================================================================================
            // KONFIGURASI DAN INISIALISASI
            // =================================================================================
            const apiConfig = {
                url: @json(config('services.api.url')),
                key: @json(config('services.api.key')),
                asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
                csrfToken: @json(csrf_token()),
                baseUrl: @json(url(''))
            };

            const currentAsesiId = '{{ $asesiId ?? null }}';

            const headers = {
                'Content-Type': 'application/json',
                'API-KEY': apiConfig.key,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': apiConfig.csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            };

            const feedbackComponents = [
                "Saya mendapatkan penjelasan yang cukup memadai mengenai proses asesmen/uji kompetensi", "Saya mendapatkan informasi yang jelas tentang kriteria kompetensi yang diujikan", "Sertifikasi kompetensi yang dilakukan sesuai dengan standar yang ditetapkan oleh lembaga sertifikasi", "Proses asesmen dilakukan secara objektif dan independen", "Penyampaian hasil asesmen dilakukan dengan jelas dan transparan", "Saya memahami langkah-langkah yang harus dilakukan setelah mendapatkan hasil asesmen", "Saya diberikan kesempatan untuk melakukan klarifikasi apabila ada ketidakjelasan dalam hasil asesmen", "Proses asesmen dilakukan sesuai dengan jadwal yang telah ditentukan sebelumnya", "Saya merasa nyaman dengan fasilitas yang disediakan selama proses asesmen", "Saya mendapatkan informasi yang cukup mengenai sertifikat yang akan diterbitkan setelah asesmen"
            ];

            if (!apiConfig.url || !apiConfig.key || !apiConfig.asesorId || !currentAsesiId) {
                showMessage('Konfigurasi atau ID Asesi tidak lengkap. Silakan kembali dan coba lagi.', 'error');
                return;
            }

            // =================================================================================
            // FUNGSI-FUNGSI BANTUAN (MODAL, PESAN, URL GAMBAR)
            // =================================================================================
            function showConfirmationModal(title, message, onConfirm) {
                const modal = document.getElementById('confirmationModal');
                document.getElementById('confirmationTitle').textContent = title;
                document.getElementById('confirmationMessage').innerHTML = message;
                const yesBtn = document.getElementById('confirmYesBtn');
                const noBtn = document.getElementById('confirmNoBtn');
                const newYesBtn = yesBtn.cloneNode(true);
                yesBtn.parentNode.replaceChild(newYesBtn, yesBtn);

                newYesBtn.addEventListener('click', () => {
                    modal.classList.add('hidden');
                    if (onConfirm) onConfirm();
                });
                noBtn.addEventListener('click', () => modal.classList.add('hidden'));
                modal.classList.remove('hidden');
            }

            function showMessage(message, type = 'info', duration = 5000) {
                const elements = {
                    success: document.getElementById('successMessage'),
                    error: document.getElementById('errorMessage'),
                    loading: document.getElementById('loadingIndicator')
                };
                Object.values(elements).forEach(el => el.classList.add('hidden'));

                const activeElement = elements[type];
                if (activeElement) {
                    activeElement.querySelector('span').textContent = message;
                    activeElement.classList.remove('hidden');
                    if (duration > 0) {
                        setTimeout(() => activeElement.classList.add('hidden'), duration);
                    }
                }
            }

            function buildImageUrl(path) {
                if (!path || path === 'null') return '';
                return path.startsWith('http') ? path : `${apiConfig.baseUrl}/${path.replace(/^\//, '')}`;
            }

            // =================================================================================
            // FUNGSI MEMUAT DATA (FETCH API)
            // =================================================================================
            function loadAK03Data(asesiId) {
                if (!asesiId) return;
                showMessage('Memuat data FR.AK.03...', 'loading', 0);
                const ak03ApiUrl = `${apiConfig.url}/asesmen/ak03/${asesiId}`;

                fetch(ak03ApiUrl, { method: 'GET', headers: headers })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(result => {
                        if (result.status === 'success' && result.data) {
                            populateForm(result.data);
                            showMessage('Data FR.AK.03 berhasil dimuat.', 'success');
                        } else {
                            throw new Error(result.message || 'Gagal memuat detail data.');
                        }
                    })
                    .catch(error => {
                        showMessage(`Error: ${error.message}`, 'error');
                        document.getElementById('unitKompetensiContainer').innerHTML = `<p class="text-center text-red-500">${error.message}</p>`;
                        document.getElementById('asesiFeedbackContent').innerHTML = `<p class="text-center text-red-500">Gagal memuat umpan balik: ${error.message}</p>`;
                    });
            }

            // =================================================================================
            // FUNGSI RENDER DAN POPULASI FORM
            // =================================================================================
            function populateForm(data) {
                // Populate general info
                document.getElementById('judulSertifikasi').textContent = data.general_info.judul_skema || 'N/A';
                document.getElementById('nomorSertifikasi').textContent = data.general_info.kode_skema || 'N/A';
                document.getElementById('namaPeserta').textContent = data.general_info.nama_asesi || 'N/A';
                document.getElementById('namaAsesor').textContent = data.general_info.nama_asesor || 'N/A';
                document.getElementById('tuk').textContent = data.general_info.nama_tuk || 'N/A';
                document.getElementById('breadcrumbAsesiName').textContent = data.general_info.nama_asesi || 'Detail';

                // Selalu isi data catatan asesor yang sudah ada, jika belum ada akan kosong
                document.getElementById('rekomendasi').value = data.ak03?.general_feedback || '';
                document.getElementById('umpan_balik_pencapaian').value = data.ak03?.umpan_balik_pencapaian || '';
                document.getElementById('saran_tindak_lanjut').value = data.ak03?.saran_tindak_lanjut || '';
                document.getElementById('catatan_pencapaian_kompetensi').value = data.ak03?.catatan_pencapaian_kompetensi || '';

                // Populate asesi feedback table (read-only by default in html string)
                const asesiFeedbackContainer = document.getElementById('asesiFeedbackContent');
                asesiFeedbackContainer.innerHTML = '';
                if (data.ak03 && data.ak03.umpan_balik && data.ak03.umpan_balik.length > 0) {
                    let feedbackHtml = `<div class="border rounded-lg overflow-x-auto"><table class="min-w-full"><thead class="bg-gray-100"><tr><th class="p-2 text-center text-sm font-semibold text-gray-600 w-12">No</th><th class="p-2 text-left text-sm font-semibold text-gray-600">Komponen Umpan Balik Asesi</th><th class="p-2 text-center text-sm font-semibold text-gray-600 w-16">Ya</th><th class="p-2 text-center text-sm font-semibold text-gray-600 w-16">Tidak</th><th class="p-2 text-left text-sm font-semibold text-gray-600">Tanggapan</th></tr></thead><tbody>`;
                    data.ak03.umpan_balik.forEach((item, index) => {
                        const componentText = feedbackComponents[item.komponen_id - 1] || 'Komponen tidak diketahui';
                        const isYa = item.hasil ? item.hasil.toLowerCase() === 'ya' : false;
                        // Atribut 'disabled' pada radio button membuat bagian ini read-only untuk asesor
                        feedbackHtml += `<tr class="border-t"><td class="p-2 text-center">${index + 1}</td><td class="p-2">${componentText}</td><td class="p-2 text-center"><input type="radio" name="feedback_${index}" ${isYa ? 'checked' : ''} disabled></td><td class="p-2 text-center"><input type="radio" name="feedback_${index}" ${!isYa ? 'checked' : ''} disabled></td><td class="p-2">${item.catatan || '<em>-</em>'}</td></tr>`;
                    });
                    feedbackHtml += '</tbody></table></div>';
                    asesiFeedbackContainer.innerHTML = feedbackHtml;
                } else {
                    asesiFeedbackContainer.innerHTML = '<p class="text-center text-gray-500 py-4">Asesi belum memberikan umpan balik.</p>';
                }

                // Populate Assessor KUK Assessment
                const unitContainer = document.getElementById('unitKompetensiContainer');
                unitContainer.innerHTML = '';
                if (!data.units || data.units.length === 0) {
                    unitContainer.innerHTML = '<p class="text-center text-gray-500">Tidak ada unit kompetensi yang ditemukan.</p>';
                } else {
                    data.units.forEach(unit => {
                        let tableRows = '';
                        unit.kuks.forEach((kuk, index) => {
                            const savedDecision = data.ak03?.penilaian?.find(p => p.id_kuk === kuk.id_kuk)?.keputusan;
                            tableRows += `<tr><td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td><td class="px-4 py-3 text-gray-700 text-left">${kuk.nama_kuk}</td><td class="flex px-4 py-3 justify-center"><select name="penilaian_kuk" data-id-unit="${unit.id_unit}" data-id-kuk="${kuk.id_kuk}" class="border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru block w-40 p-1"><option value="" ${!savedDecision ? 'selected' : ''}>Pilih</option><option value="K" ${savedDecision === 'K' ? 'selected' : ''}>Kompeten</option><option value="BK" ${savedDecision === 'BK' ? 'selected' : ''}>Belum Kompeten</option></select></td></tr>`;
                        });
                        const unitHtml = `<div class="unit-section"><p class="text-sidebar_font font-semibold pb-2">${unit.kode_unit} - ${unit.nama_unit}</p><div class="overflow-x-auto shadow-md rounded-lg mb-4"><table class="min-w-full bg-white"><thead class="bg-bg_dashboard text-center"><tr><th class="px-4 py-3 text-sm font-semibold text-gray-600 w-16">No</th><th class="px-4 py-3 text-sm font-semibold text-gray-600 text-left">Kriteria Unjuk Kerja</th><th class="px-4 py-3 text-sm font-semibold text-gray-600 w-48">Keputusan Asesor</th></tr></thead><tbody class="divide-y divide-gray-200 text-black text-center">${tableRows}</tbody></table></div></div>`;
                        unitContainer.innerHTML += unitHtml;
                    });
                }

                // Populate Signatures
                document.getElementById('asesorSignatureName').textContent = data.general_info.nama_asesor || 'N/A';
                document.getElementById('asesiSignatureName').textContent = data.general_info.nama_asesi || 'N/A';
                const asesiSignatureImageEl = document.getElementById('asesiSignatureImage');
                if (data.ak03 && data.ak03.tanda_tangan_asesi) {
                    asesiSignatureImageEl.innerHTML = `<img src="${buildImageUrl(data.ak03.tanda_tangan_asesi)}" alt="Tanda Tangan Asesi" class="h-28 object-contain">`;
                } else {
                    asesiSignatureImageEl.innerHTML = '<span class="text-gray-400">Tanda Tangan Asesi Belum Ada</span>';
                }

                // **PERUBAHAN UTAMA DI SINI**
                // Logika baru: Kunci form HANYA JIKA asesor sudah memberikan penilaian final.
                // Kita bisa asumsikan ini terjadi jika semua KUK sudah dinilai.
                const saveButton = document.getElementById('simpanAK03');

                // Cek apakah salah satu field umpan balik dari asesor sudah terisi.
                const isAsesorFeedbackSubmitted = data.ak03 && (
                    data.ak03.umpan_balik_pencapaian ||
                    data.ak03.saran_tindak_lanjut ||
                    data.ak03.catatan_pencapaian_kompetensi ||
                    data.ak03.general_feedback
                );

                if (isAsesorFeedbackSubmitted) {
                    // JIKA SUDAH DISIMPAN: Nonaktifkan semua input dan tombol simpan
                    console.log('Feedback asesor sudah final. Mengunci formulir.');

                    // Nonaktifkan semua textarea dan dropdown di dalam form
                    document.querySelectorAll('#ak03Form textarea, #ak03Form select').forEach(el => el.disabled = true);

                    // Ubah tampilan tombol simpan menjadi nonaktif
                    saveButton.textContent = 'Data Telah Disimpan Final';
                    saveButton.disabled = true;
                    saveButton.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru_soft');
                    saveButton.classList.add('bg-gray-400', 'cursor-not-allowed');

                } else {
                    // JIKA BELUM DISIMPAN: Pastikan semua input aktif
                    console.log('Feedback asesor belum diisi. Formulir aktif.');

                    // Aktifkan semua textarea dan dropdown
                    document.querySelectorAll('#ak03Form textarea, #ak03Form select').forEach(el => el.disabled = false);

                    // Pastikan tombol simpan aktif
                    saveButton.textContent = 'Simpan dan Setuju';
                    saveButton.disabled = false;
                    saveButton.classList.add('bg-gradient-to-r', 'from-biru', 'to-ungu', 'hover:bg-biru_soft');
                    saveButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                }
            }

            // =================================================================================
            // FUNGSI SIMPAN DATA (POST API)
            // =================================================================================
            function saveAK03Data() {
                if (!currentAsesiId) {
                    showMessage('ID Asesi tidak valid.', 'error');
                    return;
                }

                const penilaian = [];
                document.querySelectorAll('select[name="penilaian_kuk"]').forEach(select => {
                    if (select.value) {
                        penilaian.push({
                            id_unit: select.dataset.idUnit,
                            id_kuk: select.dataset.idKuk,
                            keputusan: select.value
                        });
                    }
                });

                // if (penilaian.length === 0) {
                // 	showMessage('Harap isi setidaknya satu penilaian KUK.', 'error');
                // 	return;
                // }

                // Mengumpulkan semua data catatan dari asesor untuk dikirim/diperbarui
                const requestData = {
                    id_asesi: currentAsesiId,
                    id_asesor: apiConfig.asesorId,
                    penilaian: penilaian,
                    // Catatan dari Asesor
                    umpan_balik_pencapaian: document.getElementById('umpan_balik_pencapaian').value,
                    saran_tindak_lanjut: document.getElementById('saran_tindak_lanjut').value,
                    catatan_pencapaian_kompetensi: document.getElementById('catatan_pencapaian_kompetensi').value,
                    rekomendasi: document.getElementById('rekomendasi').value
                };

                const saveApiUrl = `${apiConfig.url}/asesmen/ak03/save`;
                showMessage('Menyimpan data...', 'loading', 0);

                fetch(saveApiUrl, {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify(requestData)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            showMessage('Penilaian asesor berhasil diperbarui!', 'success');
                            setTimeout(() => {
                                loadAK03Data(currentAsesiId); // Muat ulang data untuk mengunci form
                            }, 1500);
                        } else {
                            throw new Error(result.message || 'Terjadi kesalahan saat menyimpan.');
                        }
                    })
                    .catch(error => showMessage(`Error: ${error.message}`, 'error'));
            }

            // =================================================================================
            // EVENT LISTENERS & EKSEKUSI AWAL
            // =================================================================================
            document.getElementById('simpanAK03').addEventListener('click', function(e) {
                e.preventDefault();
                showConfirmationModal(
                    'Konfirmasi Penyimpanan',
                    'Anda yakin ingin menyimpan penilaian ini? Data akan difinalisasi dan tidak dapat diubah lagi.',
                    saveAK03Data
                );
            });

            // Panggil fungsi untuk memuat data saat halaman pertama kali dibuka
            loadAK03Data(currentAsesiId);
        });
    </script>
@endsection