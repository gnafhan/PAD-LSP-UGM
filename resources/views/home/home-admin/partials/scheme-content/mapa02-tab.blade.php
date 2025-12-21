{{-- MAPA02 - Assessment Instrument Config Tab --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">MAPA02 - Konfigurasi Instrumen Asesmen</h2>
            <p class="text-sm text-gray-500">Atur MUK dan default potensi untuk skema ini</p>
        </div>
        <button type="button" onclick="saveMAPA02()" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-lg hover:bg-yellow-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Konfigurasi
        </button>
    </div>

    <div id="mapa02-loading" class="text-center py-12 text-gray-500">
        <svg class="animate-spin h-8 w-8 mx-auto mb-4 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p>Memuat konfigurasi...</p>
    </div>

    <div id="mapa02-content" class="hidden">
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">Konfigurasi ini menentukan MUK yang tersedia dan default potensi untuk MAPA02 pada skema ini.</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- MUK Items -->
            <div>
                <h3 class="text-md font-medium text-gray-800 mb-4">Materi Uji Kompetensi (MUK)</h3>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="muk[]" value="FR.IA.01" class="mapa02-muk h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">FR.IA.01 - Ceklis Observasi Aktivitas di Tempat Kerja</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="muk[]" value="FR.IA.02" class="mapa02-muk h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">FR.IA.02 - Tugas Praktik Demonstrasi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="muk[]" value="FR.IA.03" class="mapa02-muk h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">FR.IA.03 - Pertanyaan untuk Mendukung Observasi</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="muk[]" value="FR.IA.05" class="mapa02-muk h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">FR.IA.05 - Pertanyaan Tertulis Pilihan Ganda</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="muk[]" value="FR.IA.07" class="mapa02-muk h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">FR.IA.07 - Pertanyaan Lisan</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="muk[]" value="FR.IA.11" class="mapa02-muk h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">FR.IA.11 - Ceklis Verifikasi Portofolio</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Default Potensi -->
            <div>
                <h3 class="text-md font-medium text-gray-800 mb-4">Default Potensi Asesi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Potensi Terkait Bahasa, Literasi, dan Numerasi</label>
                        <select id="mapa02-potensi-bahasa" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm border px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="tidak_ada">Tidak Ada</option>
                            <option value="ada_minor">Ada (Minor)</option>
                            <option value="ada_signifikan">Ada (Signifikan)</option>
                        </select>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Potensi Terkait Fisik</label>
                        <select id="mapa02-potensi-fisik" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm border px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="tidak_ada">Tidak Ada</option>
                            <option value="ada_minor">Ada (Minor)</option>
                            <option value="ada_signifikan">Ada (Signifikan)</option>
                        </select>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Potensi Terkait Lokasi/Tempat Kerja</label>
                        <select id="mapa02-potensi-lokasi" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm border px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="tidak_ada">Tidak Ada</option>
                            <option value="ada_minor">Ada (Minor)</option>
                            <option value="ada_signifikan">Ada (Signifikan)</option>
                        </select>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Potensi Lainnya</label>
                        <select id="mapa02-potensi-lain" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm border px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option value="tidak_ada">Tidak Ada</option>
                            <option value="ada_minor">Ada (Minor)</option>
                            <option value="ada_signifikan">Ada (Signifikan)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                <textarea id="mapa02-catatan" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm border px-3 py-2" placeholder="Catatan tambahan untuk instrumen asesmen..."></textarea>
            </div>
        </div>
    </div>
</div>

<script>
let mapa02Config = null;

window.loadMAPA02Content = async function() {
    document.getElementById('mapa02-loading').classList.remove('hidden');
    document.getElementById('mapa02-content').classList.add('hidden');
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/mapa02`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        document.getElementById('mapa02-loading').classList.add('hidden');
        document.getElementById('mapa02-content').classList.remove('hidden');
        
        if (data.success && data.data.config) {
            mapa02Config = data.data.config;
            populateMAPA02Form(data.data.config);
        }
    } catch (error) {
        console.error('Error loading MAPA02:', error);
        document.getElementById('mapa02-loading').classList.add('hidden');
        document.getElementById('mapa02-content').classList.remove('hidden');
        showAlert('error', 'Gagal memuat konfigurasi');
    }
};

function populateMAPA02Form(config) {
    // Reset all checkboxes
    document.querySelectorAll('.mapa02-muk').forEach(cb => cb.checked = false);
    
    // Set MUK items
    if (config.muk_items && Array.isArray(config.muk_items)) {
        config.muk_items.forEach(m => {
            const cb = document.querySelector(`.mapa02-muk[value="${m}"]`);
            if (cb) cb.checked = true;
        });
    }
    
    // Set default potensi
    const potensi = config.default_potensi || {};
    document.getElementById('mapa02-potensi-bahasa').value = potensi.bahasa || '';
    document.getElementById('mapa02-potensi-fisik').value = potensi.fisik || '';
    document.getElementById('mapa02-potensi-lokasi').value = potensi.lokasi || '';
    document.getElementById('mapa02-potensi-lain').value = potensi.lain || '';
    document.getElementById('mapa02-catatan').value = potensi.catatan || '';
}

async function saveMAPA02() {
    const mukItems = Array.from(document.querySelectorAll('.mapa02-muk:checked')).map(cb => cb.value);
    const defaultPotensi = {
        bahasa: document.getElementById('mapa02-potensi-bahasa').value,
        fisik: document.getElementById('mapa02-potensi-fisik').value,
        lokasi: document.getElementById('mapa02-potensi-lokasi').value,
        lain: document.getElementById('mapa02-potensi-lain').value,
        catatan: document.getElementById('mapa02-catatan').value
    };
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/mapa02`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify({ muk_items: mukItems, default_potensi: defaultPotensi })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Konfigurasi MAPA02 berhasil disimpan');
            mapa02Config = data.data;
        } else {
            showAlert('error', data.message || 'Gagal menyimpan konfigurasi');
        }
    } catch (error) {
        console.error('Error saving MAPA02:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan');
    }
}
</script>
