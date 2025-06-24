@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 py-32">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="window.history.back()" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                        FR.AK-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 mt-5">
                    <h2 class="text-lg font-semibold mb-4">FR.AK-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI</h2>
                </div>

                <!-- Loading indicator -->
                <div id="loading" class="text-center py-4">
                    <p>Loading data...</p>
                </div>

                <!-- Error message -->
                <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <p id="error-text"></p>
                </div>

                <!-- Main content -->
                <div id="main-content" class="hidden">
                    <!-- Table structure -->
                    <div class="border border-gray-300 rounded-lg p-4 mb-6">
                        <table class="w-full border-collapse border border-gray-300 text-sm">
                            <tr>
                                <td class="border border-gray-300 p-2" colspan="2">
                                    <i>Persetujuan Asesmen ini untuk menjamin bahwa Peserta telah diberi arahan secara rinci tentang perencanaan dan proses asesmen</i>
                                </td>
                            </tr>
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
                                <td class="border border-gray-300 p-2 font-semibold">Bukti yang dikumpulkan</td>
                                <td class="border border-gray-300 p-2" id="bukti-container">
                                    <div id="hasil-items">
                                        <!-- Dynamic content will be loaded here -->
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Pelaksanaan Assesmen yang disepakati</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">Hari/Tanggal</td>
                                <td class="border border-gray-300 p-2" id="tanggal-pelaksanaan">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2">TUK</td>
                                <td class="border border-gray-300 p-2" id="tuk-pelaksanaan">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Asesi</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2" colspan="2">Bahwa saya sudah mendapatkan penjelasan Hak dan Prosedur Banding oleh Asesor</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2 font-semibold" colspan="2">Asesor</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-300 p-2" colspan="2">Saya setuju assesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</td>
                            </tr>
                        </table>
                    </div>

                    <div class="flex justify-between">
                        <div>
                            <div class="flex items-center space-x-2 mt-2">
                                {{-- <input type="checkbox" id="approve-admin" class="h-4 w-4 text-blue-600 border-gray-300 rounded" disabled> --}}
                                <p class="text-sm">Tanda Tangan Asesor</p>
                            </div>
                            <div class="mt-2">
                                <p>TTD: <span id="ttd-asesor-container">-</span></p>
                                <p id="tanggal-ttd-asesor">Tanggal TTD Asesor</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm">Tanda Tangan Asesi</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 border-gray-300 rounded" onchange="handleAsesiSignature(this)">
                                <label for="approve-pemohon" class="text-sm">Saya selaku asesi menyetujui data ini</label>
                            </div>
                            <div class="mt-2">
                                <p>TTD: <span id="ttd-asesi-container">-</span></p>
                                <p id="tanggal-ttd-asesi">Tanggal TTD Asesi</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button id="save-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" onclick="saveAk01Asesi()">SAVE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Get user data from Laravel
const userData = {
    id_asesi: '{{ Auth::user()->asesi->id_asesi ?? "" }}',
    id_asesor: '{{ Auth::user()->asesi->rincianAsesmen->id_asesor ?? "" }}',
    apiUrl: '{{ env('APP_URL') }}',
    apiKey: '{{ env('API_KEY') }}',
    csrfToken: '{{ csrf_token() }}'
};

console.log('User data:', userData); // Debug log

let currentAk01Data = null;

document.addEventListener('DOMContentLoaded', function() {
    // Validate required data
    if (!userData.id_asesi) {
        showError('ID Asesi tidak ditemukan');
        return;
    }

    if (!userData.id_asesor) {
        showError('ID Asesor tidak ditemukan');
        return;
    }

    loadAk01Data(userData.id_asesi);
});

async function loadAk01Data(idAsesi) {
    try {
        console.log('Loading AK01 data for:', idAsesi);
        console.log('API URL:', userData.apiUrl);
        console.log('API Key available:', !!userData.apiKey);
        console.log('CSRF Token available:', !!userData.csrfToken);

        // Construct the full URL
        const apiUrl = `{{ url('/api/v1/asesmen/ak01') }}/${idAsesi}`;
        console.log('Full API URL:', apiUrl);

        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'API_KEY': userData.apiKey,
                'X-CSRF-TOKEN': userData.csrfToken
            }
        });

        console.log('Response status:', response.status);
        console.log('Response statusText:', response.statusText);

        if (!response.ok) {
            const errorText = await response.text();
            console.log('Error response body:', errorText);

            let errorData;
            try {
                errorData = JSON.parse(errorText);
                console.log('Parsed error data:', errorData);
            } catch (e) {
                console.log('Error response is not JSON:', errorText);
            }

            throw new Error(`HTTP ${response.status}: ${errorData?.message || errorText}`);
        }

        const data = await response.json();
        console.log('Response data:', data);

        if (data.status === 'success') {
            currentAk01Data = data.data;
            displayAk01Data(data.data);
        } else {
            throw new Error(data.message || 'Gagal memuat data');
        }
    } catch (error) {
        console.error('Error loading AK01 data:', error);
        console.error('Error stack:', error.stack);
        showError('Gagal memuat data: ' + error.message);
    } finally {
        hideLoading();
    }
}

function displayAk01Data(data) {
    const { general_info, ak01, record_exists } = data;

    // Display general information
    document.getElementById('judul-skema').textContent = general_info.judul_skema || '-';
    document.getElementById('kode-skema').textContent = general_info.kode_skema || '-';
    document.getElementById('nama-tuk').textContent = general_info.nama_tuk || '-';
    document.getElementById('nama-asesor').textContent = general_info.nama_asesor || '-';
    document.getElementById('nama-asesi').textContent = general_info.nama_asesi || '-';
    document.getElementById('tanggal-pelaksanaan').textContent = general_info.pelaksanaan_asesmen_disepakati_mulai || '-';
    document.getElementById('tuk-pelaksanaan').textContent = general_info.nama_tuk || '-';

    if (record_exists && ak01) {
        // Display hasil yang akan dikumpulkan
        displayHasilItems(ak01.hasil_yang_akan_dikumpulkan || []);

        // Display signature information
        displaySignatureInfo(ak01);
    } else {
        // Show empty state for hasil items
        document.getElementById('hasil-items').innerHTML = '<p class="text-gray-500">Belum ada data hasil yang akan dikumpulkan</p>';

        // Initialize empty signature info
        displaySignatureInfo({
            tanda_tangan_asesi: null,
            waktu_tanda_tangan_asesi: null,
            tanda_tangan_asesor: null,
            waktu_tanda_tangan_asesor: null
        });
    }

    // Show main content
    document.getElementById('main-content').classList.remove('hidden');
}

function displayHasilItems(hasilItems) {
    const container = document.getElementById('hasil-items');

    let html = '';
    hasilItems.forEach((item, index) => {
        const id = `hasil-item-${index}`;
        html += `
            <div class="flex items-center mb-2">
                <input type="checkbox" id="${id}" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked disabled>
                <label for="${id}" class="ml-2">${item}</label>
            </div>
        `;
    });

    if (hasilItems.length === 0) {
        html = '<p class="text-gray-500">Belum ada data hasil yang akan dikumpulkan</p>';
    }

    container.innerHTML = html;
}

function displaySignatureInfo(ak01) {
    // Asesi signature
    if (ak01.tanda_tangan_asesi && ak01.tanda_tangan_asesi !== 'null') {
        // Handle path - API response already includes /storage/ prefix
        let signaturePath = ak01.tanda_tangan_asesi;

        document.getElementById('ttd-asesi-container').innerHTML =
            `<img src="${signaturePath}" alt="Tanda Tangan Asesi" class="h-12 inline border">`;
        document.getElementById('approve-pemohon').checked = true;
        document.getElementById('approve-pemohon').disabled = true;

        // Update button state for signed form
        const saveBtn = document.getElementById('save-btn');
        saveBtn.textContent = 'SUDAH DITANDATANGANI';
        saveBtn.disabled = true;
        saveBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
        saveBtn.classList.add('bg-gray-400', 'cursor-not-allowed');

        console.log('Asesi signature found and form locked');
    } else {
        document.getElementById('ttd-asesi-container').textContent = 'Belum ditandatangani';
        document.getElementById('approve-pemohon').checked = false;
        document.getElementById('approve-pemohon').disabled = false;

        // Reset button state for unsigned form
        const saveBtn = document.getElementById('save-btn');
        saveBtn.textContent = 'SAVE';
        saveBtn.disabled = false;
        saveBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
        saveBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');

        console.log('Asesi signature not found, form available for signing');
    }

    // Display signature timestamp - handle both null and valid timestamps
    let displayTimeAsesi = ak01.waktu_tanda_tangan_asesi;
    if (!displayTimeAsesi || displayTimeAsesi === 'null') {
        displayTimeAsesi = '-';
    }
    document.getElementById('tanggal-ttd-asesi').textContent = displayTimeAsesi;

    // Asesor signature
    if (ak01.tanda_tangan_asesor && ak01.tanda_tangan_asesor !== 'null') {
        // Handle path - API response already includes /storage/ prefix
        let asesorSignaturePath = ak01.tanda_tangan_asesor;

        document.getElementById('ttd-asesor-container').innerHTML =
            `<img src="${asesorSignaturePath}" alt="Tanda Tangan Asesor" class="h-12 inline border">`;
    } else {
        document.getElementById('ttd-asesor-container').textContent = 'Belum ditandatangani';
    }

    // Display asesor signature timestamp
    let displayTimeAsesor = ak01.waktu_tanda_tangan_asesor;
    if (!displayTimeAsesor || displayTimeAsesor === 'null') {
        displayTimeAsesor = '-';
    }
    document.getElementById('tanggal-ttd-asesor').textContent = displayTimeAsesor;
}

async function handleAsesiSignature(checkbox) {
    if (checkbox.checked) {
        const confirmSign = confirm('Apakah Anda yakin ingin menandatangani formulir AK01 ini?');
        if (!confirmSign) {
            checkbox.checked = false;
            return;
        }

        // Disable checkbox during processing
        checkbox.disabled = true;

        // Show loading state
        const saveBtn = document.getElementById('save-btn');
        saveBtn.textContent = 'Menandatangani...';
        saveBtn.disabled = true;

        await saveAk01Asesi(true);
    }
}

async function saveAk01Asesi(isSigning = false) {
    try {
        const requestData = {
            id_asesi: userData.id_asesi,
            id_asesor: userData.id_asesor,
            is_signing: isSigning
        };

        console.log('Saving AK01 data:', requestData);

        // Construct the full URL
        const saveUrl = `{{ url('/api/v1/asesmen/ak01/asesi/save') }}`;
        console.log('Save URL:', saveUrl);

        const response = await fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'API_KEY': userData.apiKey,
                'X-CSRF-TOKEN': userData.csrfToken
            },
            body: JSON.stringify(requestData)
        });

        console.log('Save response status:', response.status);
        console.log('Save response statusText:', response.statusText);

        // Log the request body that was sent
        console.log('Request body sent:', JSON.stringify(requestData, null, 2));

        if (!response.ok) {
            const errorText = await response.text();
            console.log('Save error response body:', errorText);

            let errorData;
            try {
                errorData = JSON.parse(errorText);
                console.log('Parsed save error data:', errorData);
            } catch (e) {
                console.log('Save error response is not JSON:', errorText);
            }

            throw new Error(`HTTP ${response.status}: ${errorData?.message || errorText}`);
        }

        const data = await response.json();
        console.log('Save response data:', data);

        if (data.status === 'success') {
            if (isSigning) {
                alert('Formulir AK01 berhasil ditandatangani dan disimpan!');

                // Update display with current timestamp
                const now = new Date();
                const jakartaTime = new Date(now.getTime() + (7 * 60 * 60 * 1000)); // UTC+7
                const displayTime = jakartaTime.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }).replace(/\//g, '-') + ' ' +
                jakartaTime.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }) + ' WIB';

                document.getElementById('tanggal-ttd-asesi').textContent = displayTime;
                console.log('Updated display with timestamp:', displayTime);
            } else {
                alert(data.message || 'Data berhasil disimpan');
            }

            // Reload data to reflect changes and show signature
            setTimeout(async () => {
                await loadAk01Data(userData.id_asesi);
            }, 1000); // Wait 1 second before reloading to ensure backend processing is complete
        } else {
            throw new Error(data.message || 'Gagal menyimpan data');
        }
    } catch (error) {
        console.error('Error saving AK01 data:', error);
        console.error('Error stack:', error.stack);
        alert('Gagal menyimpan data: ' + error.message);

        // Reset checkbox if error during signing
        if (isSigning) {
            const checkbox = document.getElementById('approve-pemohon');
            checkbox.checked = false;
            checkbox.disabled = false;

            // Reset button state
            const saveBtn = document.getElementById('save-btn');
            saveBtn.textContent = 'SAVE';
            saveBtn.disabled = false;
            saveBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
            saveBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
        }
    }
}

function showError(message) {
    document.getElementById('error-text').textContent = message;
    document.getElementById('error-message').classList.remove('hidden');
    hideLoading();
}

function hideLoading() {
    document.getElementById('loading').style.display = 'none';
}
</script>

@endsection
