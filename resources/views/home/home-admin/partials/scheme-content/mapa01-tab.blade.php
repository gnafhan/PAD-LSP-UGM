{{-- MAPA01 - Assessment Planning Config Tab --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">MAPA01 - Konfigurasi Perencanaan Asesmen</h2>
            <p class="text-sm text-gray-500">Atur default pendekatan asesmen untuk skema ini</p>
        </div>
        <button type="button" onclick="saveMAPA01()" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Konfigurasi
        </button>
    </div>

    <div id="mapa01-loading" class="text-center py-12 text-gray-500">
        <svg class="animate-spin h-8 w-8 mx-auto mb-4 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p>Memuat konfigurasi...</p>
    </div>

    <div id="mapa01-content" class="hidden">
        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6 rounded-r-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div class="ml-3">
                    <p class="text-sm text-orange-700">Konfigurasi ini akan menjadi default saat asesor membuat MAPA01 untuk asesi pada skema ini.</p>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <h3 class="text-md font-medium text-gray-800 mb-4">Pendekatan Asesmen Default</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Metode Asesmen</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="metode[]" value="observasi" class="mapa01-metode h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Observasi Langsung</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="metode[]" value="portofolio" class="mapa01-metode h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Portofolio</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="metode[]" value="tes_tertulis" class="mapa01-metode h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Tes Tertulis</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="metode[]" value="wawancara" class="mapa01-metode h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Wawancara</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="metode[]" value="demonstrasi" class="mapa01-metode h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Demonstrasi Praktis</span>
                            </label>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Asesmen</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="tempat" value="tuk" class="mapa01-tempat h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Tempat Uji Kompetensi (TUK)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="tempat" value="tempat_kerja" class="mapa01-tempat h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Tempat Kerja</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="tempat" value="kombinasi" class="mapa01-tempat h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">Kombinasi</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                <textarea id="mapa01-catatan" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm border px-3 py-2" placeholder="Catatan tambahan untuk perencanaan asesmen..."></textarea>
            </div>
        </div>
    </div>
</div>

<script>
let mapa01Config = null;

window.loadMAPA01Content = async function() {
    document.getElementById('mapa01-loading').classList.remove('hidden');
    document.getElementById('mapa01-content').classList.add('hidden');
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/mapa01`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        document.getElementById('mapa01-loading').classList.add('hidden');
        document.getElementById('mapa01-content').classList.remove('hidden');
        
        if (data.success && data.data.config) {
            mapa01Config = data.data.config;
            populateMAPA01Form(data.data.config.config_data || {});
        }
    } catch (error) {
        console.error('Error loading MAPA01:', error);
        document.getElementById('mapa01-loading').classList.add('hidden');
        document.getElementById('mapa01-content').classList.remove('hidden');
        showAlert('error', 'Gagal memuat konfigurasi');
    }
};

function populateMAPA01Form(config) {
    // Reset all checkboxes
    document.querySelectorAll('.mapa01-metode').forEach(cb => cb.checked = false);
    document.querySelectorAll('.mapa01-tempat').forEach(rb => rb.checked = false);
    
    // Set metode
    if (config.metode && Array.isArray(config.metode)) {
        config.metode.forEach(m => {
            const cb = document.querySelector(`.mapa01-metode[value="${m}"]`);
            if (cb) cb.checked = true;
        });
    }
    
    // Set tempat
    if (config.tempat) {
        const rb = document.querySelector(`.mapa01-tempat[value="${config.tempat}"]`);
        if (rb) rb.checked = true;
    }
    
    // Set catatan
    document.getElementById('mapa01-catatan').value = config.catatan || '';
}

async function saveMAPA01() {
    const metode = Array.from(document.querySelectorAll('.mapa01-metode:checked')).map(cb => cb.value);
    const tempatEl = document.querySelector('.mapa01-tempat:checked');
    const tempat = tempatEl ? tempatEl.value : null;
    const catatan = document.getElementById('mapa01-catatan').value;
    
    const configData = { metode, tempat, catatan };
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/mapa01`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify({ config_data: configData })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Konfigurasi MAPA01 berhasil disimpan');
            mapa01Config = data.data;
        } else {
            showAlert('error', data.message || 'Gagal menyimpan konfigurasi');
        }
    } catch (error) {
        console.error('Error saving MAPA01:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan');
    }
}
</script>
