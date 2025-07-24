@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'FR-AK-03 Umpan Balik - LSP UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
                {{-- Header Formulir --}}
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                        FR-AK-03 UMPAN BALIK PESERTA
                    </div>
                </div>

                <div class="mt-5">
                    <h2 class="text-lg font-semibold mb-4">FR-AK-03 UMPAN BALIK PESERTA</h2>
                </div>

                {{-- Indikator Loading --}}
                <div id="loading" class="text-center py-4">
                    <div class="flex items-center justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                        <p class="ml-2">Memuat data...</p>
                    </div>
                </div>

                {{-- Pesan Error --}}
                <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <p id="error-text"></p>
                    <button onclick="retryLoad()" class="mt-2 bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                        Coba Lagi
                    </button>
                </div>

                {{-- Konten Utama Formulir --}}
                <div id="main-content" class="hidden">
                    {{-- Informasi Umum --}}
                    <div class="border border-gray-300 rounded-lg p-4 mb-6">
                        <table class="w-full border-collapse border border-gray-300 text-sm">
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Skema Sertifikasi Klaster/Asesmen</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Judul Skema Sertifikasi</td>
                                <td class="border border-gray-300 p-2" id="judul-skema">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nomor Skema Sertifikasi</td>
                                <td class="border border-gray-300 p-2" id="kode-skema">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">TUK</td>
                                <td class="border border-gray-300 p-2" id="nama-tuk">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nama Asesor</td>
                                <td class="border border-gray-300 p-2" id="nama-asesor">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Nama Peserta</td>
                                <td class="border border-gray-300 p-2" id="nama-asesi">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold">Hari/Tanggal</td>
                                <td class="border border-gray-300 p-2" id="tanggal-pelaksanaan">-</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Tabel Umpan Balik --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">Peserta diminta untuk:</h3>
                        <ul class="list-disc list-inside mb-2">
                            <li>Memberikan umpan balik terhadap proses asesmen (diisikan oleh Asesi setelah pengambilan keputusan).</li>
                        </ul>
                        <form id="feedback-form">
                            <table class="w-full border-collapse border border-gray-300 text-sm">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-300 p-2 w-1/12">No.</th>
                                        <th class="border border-gray-300 p-2 w-5/12">Komponen</th>
                                        <th class="border border-gray-300 p-2 w-1/12">Ya</th>
                                        <th class="border border-gray-300 p-2 w-1/12">Tidak</th>
                                        <th class="border border-gray-300 p-2 w-4/12">Catatan Asesi</th>
                                    </tr>
                                </thead>
                                <tbody id="feedback-body">
                                    {{-- Baris akan di-generate oleh JavaScript --}}
                                </tbody>
                            </table>
                        </form>
                    </div>

                    {{-- Bagian Tanda Tangan --}}
                    <div class="flex justify-end">
                        <div>
                            <p class="text-sm font-semibold text-right">Tanda Tangan Asesi</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="checkbox" id="approve-feedback" class="h-4 w-4 text-blue-600 border-gray-300 rounded" onchange="handleAsesiSignature(this)">
                                <label for="approve-feedback" class="text-sm">Saya selaku asesi menyetujui umpan balik ini.</label>
                            </div>
                            <div class="mt-2 text-right">
                                <span id="ttd-asesi-container" class="text-gray-500 italic">Belum ditandatangani</span>
                                <p class="text-xs text-gray-600" id="tanggal-ttd-asesi">-</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end mt-4">
                        <button id="save-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors duration-200" onclick="saveAk03Asesi(false)">
                            <span id="save-btn-text">SIMPAN</span>
                            <div id="save-btn-loading" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="signature-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="rounded-full bg-yellow-100 p-3 mr-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" /></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Tanda Tangan Digital</h3>
            </div>
            <div class="mb-6">
                <p class="text-gray-700 mb-4">Anda akan menandatangani formulir <strong>FR-AK-03 Umpan Balik Peserta</strong> secara digital.</p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-700">Setelah menandatangani, Anda <strong>tidak dapat mengubah</strong> data ini lagi. Tanda tangan digital memiliki kekuatan hukum yang sama dengan tanda tangan manual.</p>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button id="cancel-signature" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">Batal</button>
                <button id="confirm-signature" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 flex items-center">
                    <span id="confirm-signature-text">Ya, Tandatangani</span>
                    <div id="confirm-signature-loading" class="hidden animate-spin rounded-full h-4 w-4 border-b-2 border-white ml-2"></div>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-auto">
        <div class="p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Berhasil Disimpan!</h3>
            <p id="success-message" class="text-gray-600 mb-6"></p>
            <button id="close-success-modal" type="button" class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">Tutup</button>
        </div>
    </div>
</div>

<script>
const apiConfig = {
    url: @json(config('services.api.url')),
    key: @json(config('services.api.key')),
    asesiId: @json(Auth::user()->asesi->id_asesi ?? null),
    csrfToken: @json(csrf_token())
};

const feedbackComponents = [
    "Saya mendapatkan penjelasan yang cukup memadai mengenai proses asesmen/uji kompetensi",
    "Saya mendapatkan informasi yang jelas tentang kriteria kompetensi yang diujikan",
    "Sertifikasi kompetensi yang dilakukan sesuai dengan standar yang ditetapkan oleh lembaga sertifikasi",
    "Proses asesmen dilakukan secara objektif dan independen",
    "Penyampaian hasil asesmen dilakukan dengan jelas dan transparan",
    "Saya memahami langkah-langkah yang harus dilakukan setelah mendapatkan hasil asesmen",
    "Saya diberikan kesempatan untuk melakukan klarifikasi apabila ada ketidakjelasan dalam hasil asesmen",
    "Proses asesmen dilakukan sesuai dengan jadwal yang telah ditentukan sebelumnya",
    "Saya merasa nyaman dengan fasilitas yang disediakan selama proses asesmen",
    "Saya mendapatkan informasi yang cukup mengenai sertifikat yang akan diterbitkan setelah asesmen"
];

let isProcessing = false;

// ===================================================================================
// INISIALISASI
// ===================================================================================
document.addEventListener('DOMContentLoaded', function() {
    initializeForm();
    initializeModals();
});

function initializeForm() {
    if (!apiConfig.url || !apiConfig.key || !apiConfig.asesiId) {
        showError('Konfigurasi tidak lengkap. Harap hubungi administrator.');
        return;
    }
    generateFeedbackRows();
    loadAk03Data(apiConfig.asesiId);
}

function generateFeedbackRows() {
    const tbody = document.getElementById('feedback-body');
    tbody.innerHTML = feedbackComponents.map((text, index) => {
        const id = index + 1;
        return `
            <tr data-id="${id}">
                <td class="border border-gray-300 p-2 text-center">${id}</td>
                <td class="border border-gray-300 p-2">${text}</td>
                <td class="border border-gray-300 p-2 text-center">
                    <input type="radio" name="hasil-${id}" value="ya" class="form-radio h-4 w-4 text-blue-600 border-gray-300">
                </td>
                <td class="border border-gray-300 p-2 text-center">
                    <input type="radio" name="hasil-${id}" value="tidak" class="form-radio h-4 w-4 text-blue-600 border-gray-300">
                </td>
                <td class="border border-gray-300 p-2">
                    <input type="text" name="catatan-${id}" class="w-full border-gray-300 rounded text-sm p-1">
                </td>
            </tr>
        `;
    }).join('');
}

// ===================================================================================
// PEMUATAN DATA (API GET)
// ===================================================================================
async function loadAk03Data(idAsesi) {
    try {
        showLoading(true);
        hideError();

        // Mengambil data umum dari AK-01 dan data spesifik dari AK-03
        // Disarankan untuk membuat endpoint baru yang menggabungkan informasi ini
        const generalInfoUrl = `${apiConfig.url}/asesmen/ak01/${idAsesi}`;
        const ak03Url = `${apiConfig.url}/asesmen/ak03/${idAsesi}`;
        const headers = { 'API-KEY': apiConfig.key, 'Accept': 'application/json' };

        const [generalResponse, ak03Response] = await Promise.all([
            fetch(generalInfoUrl, { headers }),
            fetch(ak03Url, { headers })
        ]);

        if (!generalResponse.ok) throw new Error('Gagal mengambil data umum.');

        const generalData = await generalResponse.json();
        const ak03Data = ak03Response.ok ? await ak03Response.json() : { data: null };

        if (generalData.status === 'success') {
            displayData(generalData.data.general_info, ak03Data.data ? ak03Data.data.ak03 : null);
            showMainContent();
        } else {
            throw new Error(generalData.message || 'Format data umum tidak sesuai');
        }
    } catch (error) {
        showError('Gagal memuat data: ' + error.message);
    } finally {
        showLoading(false);
    }
}

function displayData(general_info, ak03) {
    // Tampilkan informasi umum
    updateElementText('judul-skema', general_info.judul_skema);
    updateElementText('kode-skema', general_info.kode_skema);
    updateElementText('nama-tuk', general_info.nama_tuk);
    updateElementText('nama-asesor', general_info.nama_asesor);
    updateElementText('nama-asesi', general_info.nama_asesi);
    updateElementText('tanggal-pelaksanaan', general_info.pelaksanaan_asesmen_disepakati_mulai);

    // Isi formulir umpan balik jika data ada
    if (ak03 && ak03.umpan_balik) {
        ak03.umpan_balik.forEach(item => {
            const id = item.komponen_id;
            if (item.hasil) {
                const radio = document.querySelector(`input[name="hasil-${id}"][value="${item.hasil}"]`);
                if (radio) radio.checked = true;
            }
            const catatan = document.querySelector(`input[name="catatan-${id}"]`);
            if (catatan) catatan.value = item.catatan || '';
        });
    }

    // Tampilkan informasi tanda tangan
    const asesiSigned = ak03 && ak03.tanda_tangan_asesi;
    const asesiCheckbox = document.getElementById('approve-feedback');
    const saveBtn = document.getElementById('save-btn');
    const formInputs = document.querySelectorAll('#feedback-form input');

    if (asesiSigned) {
        const imageUrl = buildImageUrl(ak03.tanda_tangan_asesi);
        document.getElementById('ttd-asesi-container').innerHTML = `<img src="${imageUrl}" alt="Tanda Tangan Asesi" class="h-20 inline border border-gray-300 rounded">`;
        updateElementText('tanggal-ttd-asesi', ak03.waktu_tanda_tangan_asesi || '-');

        // Kunci formulir
        asesiCheckbox.checked = true;
        asesiCheckbox.disabled = true;
        formInputs.forEach(input => input.disabled = true);
        saveBtn.textContent = 'SUDAH DITANDATANGANI';
        saveBtn.disabled = true;
        saveBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
    } else {
        document.getElementById('ttd-asesi-container').innerHTML = '<span class="text-gray-500 italic">Belum ditandatangani</span>';
        updateElementText('tanggal-ttd-asesi', '-');
        asesiCheckbox.disabled = false;
        formInputs.forEach(input => input.disabled = false);
        saveBtn.disabled = false;
    }
}


// ===================================================================================
// PENYIMPANAN DATA (API POST)
// ===================================================================================
function collectFeedbackData() {
    const feedbackData = [];
    const rows = document.querySelectorAll('#feedback-body tr');
    rows.forEach(row => {
        const id = row.dataset.id;
        const hasilRadio = document.querySelector(`input[name="hasil-${id}"]:checked`);
        const catatanInput = document.querySelector(`input[name="catatan-${id}"]`);
        feedbackData.push({
            komponen_id: parseInt(id),
            hasil: hasilRadio ? hasilRadio.value : null,
            catatan: catatanInput ? catatanInput.value : ''
        });
    });
    return feedbackData;
}

async function saveAk03Asesi(isSigning = false) {
    if (isProcessing) return;
    isProcessing = true;

    const saveBtn = document.getElementById('save-btn');
    const saveBtnText = document.getElementById('save-btn-text');
    const saveBtnLoading = document.getElementById('save-btn-loading');

    // Update UI tombol
    saveBtn.disabled = true;
    saveBtnText.textContent = isSigning ? 'MENANDATANGANI...' : 'MENYIMPAN...';
    saveBtnLoading.classList.remove('hidden');

    try {
        const payload = {
            id_asesi: apiConfig.asesiId,
            umpan_balik: collectFeedbackData(),
            is_signing: isSigning
        };

        const response = await fetch(`${apiConfig.url}/asesmen/ak03/asesi/save`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'API-KEY': apiConfig.key,
                'X-CSRF-TOKEN': apiConfig.csrfToken,
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        if (!response.ok || result.status !== 'success') {
            throw new Error(result.message || 'Gagal menyimpan data.');
        }

        if (isSigning) {
            hideSignatureModal();
            showSuccessModal('Formulir berhasil ditandatangani dan disimpan.');
        } else {
            showSuccessModal('Data umpan balik berhasil disimpan.');
        }

        // Muat ulang data untuk menampilkan status terbaru
        setTimeout(() => loadAk03Data(apiConfig.asesiId), 500);

    } catch (error) {
        if (isSigning) hideSignatureModal();
        showError('Gagal menyimpan: ' + error.message);
        // Jika gagal tanda tangan, buka kembali checkbox
        if (isSigning) {
            document.getElementById('approve-feedback').checked = false;
        }
    } finally {
        // Reset UI tombol
        saveBtnText.textContent = 'SIMPAN';
        saveBtnLoading.classList.add('hidden');
        // Tombol tetap terkunci jika sudah ditandatangani
        const isSigned = document.getElementById('approve-feedback').disabled;
        if (!isSigned) {
            saveBtn.disabled = false;
        }
        isProcessing = false;
    }
}

// ===================================================================================
// LOGIKA TANDA TANGAN & MODAL
// ===================================================================================
function initializeModals() {
    const signatureModal = document.getElementById('signature-modal');
    document.getElementById('cancel-signature').addEventListener('click', () => {
        hideSignatureModal();
        document.getElementById('approve-feedback').checked = false;
    });
    document.getElementById('confirm-signature').addEventListener('click', () => {
        hideSignatureModal();
        saveAk03Asesi(true);
    });
    document.getElementById('close-success-modal').addEventListener('click', () => {
        hideSuccessModal();
        loadAk03Data(apiConfig.asesiId);
    });

    // Klik di luar modal untuk menutup
    signatureModal.addEventListener('click', e => { if(e.target === signatureModal) document.getElementById('cancel-signature').click(); });
}

function handleAsesiSignature(checkbox) {
    if (checkbox.checked) {
        showSignatureModal();
    }
}

function showSignatureModal() {
    document.getElementById('signature-modal').classList.remove('hidden');
    document.getElementById('signature-modal').style.display = 'flex';
}

function hideSignatureModal() {
    document.getElementById('signature-modal').classList.add('hidden');
    document.getElementById('signature-modal').style.display = 'none';
    document.getElementById('main-content').classList.remove('hidden');
}

function showSuccessModal(message) {
    document.getElementById('success-message').textContent = message;
    document.getElementById('success-modal').classList.remove('hidden');
    document.getElementById('success-modal').style.display = 'flex';
}

function hideSuccessModal() {
    document.getElementById('success-modal').classList.add('hidden');
    document.getElementById('success-modal').style.display = 'none';
    document.getElementById('main-content').classList.remove('hidden');
}

// ===================================================================================
// FUNGSI UTILITAS
// ===================================================================================
function updateElementText(id, text) {
    const element = document.getElementById(id);
    if (element) element.textContent = text || '-';
}

function buildImageUrl(path) {
    if (!path || path === 'null') return '';
    const baseUrl = "{{ url('') }}";
    return path.startsWith('http') ? path : `${baseUrl}/${path.replace(/^\//, '')}`;
}

function showLoading(show) {
    document.getElementById('loading').style.display = show ? 'block' : 'none';
    if(show) document.getElementById('main-content').classList.add('hidden');
}

function showMainContent() {
    document.getElementById('main-content').classList.remove('hidden');
}

function showError(message) {
    document.getElementById('error-text').textContent = message;
    document.getElementById('error-message').classList.remove('hidden');
    document.getElementById('loading').style.display = 'none';
    document.getElementById('main-content').classList.add('hidden');
}

function hideError() {
    document.getElementById('error-message').classList.add('hidden');
}

function retryLoad() {
    hideError();
    loadAk03Data(apiConfig.asesiId);
}

</script>
@endsection