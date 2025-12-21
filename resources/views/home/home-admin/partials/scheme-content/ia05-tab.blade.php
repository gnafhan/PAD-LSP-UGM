{{-- IA05 - Multiple Choice Questions Tab --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">IA05 - Soal Pilihan Ganda</h2>
            <p class="text-sm text-gray-500">Kelola soal pilihan ganda untuk asesmen tertulis</p>
        </div>
        <button type="button" onclick="openIA05Modal()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Soal
        </button>
    </div>

    <div id="ia05-list" class="space-y-4">
        <div class="text-center py-12 text-gray-500" id="ia05-loading">
            <svg class="animate-spin h-8 w-8 mx-auto mb-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p>Memuat soal...</p>
        </div>
        <div class="text-center py-12 text-gray-500 hidden" id="ia05-empty">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada soal</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan soal pilihan ganda baru.</p>
        </div>
        <div id="ia05-items" class="space-y-3"></div>
    </div>
</div>

<!-- IA05 Modal -->
<div id="ia05-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 modal-backdrop" onclick="closeIA05Modal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form id="ia05-form" onsubmit="saveIA05(event)">
                <div class="bg-white px-6 pt-6 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="ia05-modal-title">Tambah Soal Baru</h3>
                    <input type="hidden" id="ia05-kode" name="kode_soal">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pertanyaan <span class="text-red-500">*</span></label>
                            <textarea id="ia05-pertanyaan" name="pertanyaan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2"></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jawaban A <span class="text-red-500">*</span></label>
                                <input type="text" id="ia05-jawaban-a" name="jawaban_a" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jawaban B <span class="text-red-500">*</span></label>
                                <input type="text" id="ia05-jawaban-b" name="jawaban_b" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jawaban C</label>
                                <input type="text" id="ia05-jawaban-c" name="jawaban_c" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jawaban D</label>
                                <input type="text" id="ia05-jawaban-d" name="jawaban_d" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jawaban E</label>
                                <input type="text" id="ia05-jawaban-e" name="jawaban_e" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jawaban Benar <span class="text-red-500">*</span></label>
                                <select id="ia05-jawaban-benar" name="jawaban_benar" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm border px-3 py-2">
                                    <option value="">-- Pilih --</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                    <option value="e">E</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
                    <button type="button" onclick="closeIA05Modal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let ia05Questions = [];

window.loadIA05Content = async function() {
    document.getElementById('ia05-loading').classList.remove('hidden');
    document.getElementById('ia05-empty').classList.add('hidden');
    document.getElementById('ia05-items').innerHTML = '';
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia05`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        document.getElementById('ia05-loading').classList.add('hidden');
        
        if (data.success && data.data.questions && data.data.questions.length > 0) {
            ia05Questions = data.data.questions;
            renderIA05List();
            initIA05Sortable();
        } else {
            document.getElementById('ia05-empty').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error loading IA05:', error);
        document.getElementById('ia05-loading').classList.add('hidden');
        showAlert('error', 'Gagal memuat soal');
    }
};

function renderIA05List() {
    const container = document.getElementById('ia05-items');
    container.innerHTML = ia05Questions.map((q, i) => `
        <div class="content-card bg-white border border-gray-200 rounded-lg p-4 flex items-start" data-kode="${q.kode_soal}">
            <div class="drag-handle mr-3 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center mb-2">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">#${i + 1}</span>
                    <span class="ml-2 text-xs text-gray-400">Jawaban: ${q.jawaban_benar?.toUpperCase() || '-'}</span>
                </div>
                <p class="text-sm text-gray-800 mb-2">${q.pertanyaan}</p>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-2 text-xs text-gray-600">
                    ${q.jawaban_a ? `<span class="${q.jawaban_benar === 'a' ? 'font-bold text-green-600' : ''}">A: ${q.jawaban_a}</span>` : ''}
                    ${q.jawaban_b ? `<span class="${q.jawaban_benar === 'b' ? 'font-bold text-green-600' : ''}">B: ${q.jawaban_b}</span>` : ''}
                    ${q.jawaban_c ? `<span class="${q.jawaban_benar === 'c' ? 'font-bold text-green-600' : ''}">C: ${q.jawaban_c}</span>` : ''}
                    ${q.jawaban_d ? `<span class="${q.jawaban_benar === 'd' ? 'font-bold text-green-600' : ''}">D: ${q.jawaban_d}</span>` : ''}
                    ${q.jawaban_e ? `<span class="${q.jawaban_benar === 'e' ? 'font-bold text-green-600' : ''}">E: ${q.jawaban_e}</span>` : ''}
                </div>
            </div>
            <div class="flex items-center space-x-2 ml-4">
                <button type="button" onclick="editIA05('${q.kode_soal}')" class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button type="button" onclick="deleteIA05('${q.kode_soal}')" class="text-red-600 hover:text-red-800 p-1" title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>
    `).join('');
}

function initIA05Sortable() {
    const container = document.getElementById('ia05-items');
    if (container.sortable) container.sortable.destroy();
    
    container.sortable = new Sortable(container, {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: async function() {
            const order = Array.from(container.children).map(el => el.dataset.kode);
            try {
                await fetch(`/admin/skema/${window.skemaId}/content/ia05/reorder`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
                    body: JSON.stringify({ order })
                });
                showAlert('success', 'Urutan soal berhasil diperbarui');
            } catch (error) {
                console.error('Error reordering:', error);
                showAlert('error', 'Gagal memperbarui urutan');
            }
        }
    });
}

function openIA05Modal(kode = null) {
    document.getElementById('ia05-modal').classList.remove('hidden');
    document.getElementById('ia05-form').reset();
    document.getElementById('ia05-kode').value = '';
    document.getElementById('ia05-modal-title').textContent = 'Tambah Soal Baru';
    
    if (kode) {
        const q = ia05Questions.find(x => x.kode_soal === kode);
        if (q) {
            document.getElementById('ia05-modal-title').textContent = 'Edit Soal';
            document.getElementById('ia05-kode').value = q.kode_soal;
            document.getElementById('ia05-pertanyaan').value = q.pertanyaan || '';
            document.getElementById('ia05-jawaban-a').value = q.jawaban_a || '';
            document.getElementById('ia05-jawaban-b').value = q.jawaban_b || '';
            document.getElementById('ia05-jawaban-c').value = q.jawaban_c || '';
            document.getElementById('ia05-jawaban-d').value = q.jawaban_d || '';
            document.getElementById('ia05-jawaban-e').value = q.jawaban_e || '';
            document.getElementById('ia05-jawaban-benar').value = q.jawaban_benar || '';
        }
    }
}

function closeIA05Modal() {
    document.getElementById('ia05-modal').classList.add('hidden');
}

function editIA05(kode) {
    openIA05Modal(kode);
}

async function saveIA05(e) {
    e.preventDefault();
    const kode = document.getElementById('ia05-kode').value;
    const formData = {
        pertanyaan: document.getElementById('ia05-pertanyaan').value,
        jawaban_a: document.getElementById('ia05-jawaban-a').value,
        jawaban_b: document.getElementById('ia05-jawaban-b').value,
        jawaban_c: document.getElementById('ia05-jawaban-c').value,
        jawaban_d: document.getElementById('ia05-jawaban-d').value,
        jawaban_e: document.getElementById('ia05-jawaban-e').value,
        jawaban_benar: document.getElementById('ia05-jawaban-benar').value
    };
    
    try {
        const url = kode 
            ? `/admin/skema/${window.skemaId}/content/ia05/${kode}`
            : `/admin/skema/${window.skemaId}/content/ia05`;
        const method = kode ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', kode ? 'Soal berhasil diperbarui' : 'Soal berhasil ditambahkan');
            closeIA05Modal();
            loadIA05Content();
        } else {
            showAlert('error', data.message || 'Gagal menyimpan soal');
        }
    } catch (error) {
        console.error('Error saving IA05:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan');
    }
}

async function deleteIA05(kode) {
    if (!confirm('Apakah Anda yakin ingin menghapus soal ini?')) return;
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia05/${kode}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Soal berhasil dihapus');
            loadIA05Content();
        } else {
            showAlert('error', data.message || 'Gagal menghapus soal');
        }
    } catch (error) {
        console.error('Error deleting IA05:', error);
        showAlert('error', 'Terjadi kesalahan saat menghapus');
    }
}
</script>
