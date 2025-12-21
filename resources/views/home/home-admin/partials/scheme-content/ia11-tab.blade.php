{{-- IA11 - Portfolio Checklist Tab --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">IA11 - Checklist Verifikasi Portofolio</h2>
            <p class="text-sm text-gray-500">Kelola item checklist untuk verifikasi portofolio</p>
        </div>
        <button type="button" onclick="openIA11Modal()" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Item
        </button>
    </div>

    <div id="ia11-list">
        <div class="text-center py-12 text-gray-500" id="ia11-loading">
            <svg class="animate-spin h-8 w-8 mx-auto mb-4 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p>Memuat checklist...</p>
        </div>
        <div class="text-center py-12 text-gray-500 hidden" id="ia11-empty">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada item checklist</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan item checklist baru.</p>
        </div>
        <div id="ia11-items" class="space-y-3"></div>
    </div>
</div>

<!-- IA11 Modal -->
<div id="ia11-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 modal-backdrop" onclick="closeIA11Modal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="ia11-form" onsubmit="saveIA11(event)">
                <div class="bg-white px-6 pt-6 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="ia11-modal-title">Tambah Item Checklist</h3>
                    <input type="hidden" id="ia11-id" name="id">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Item <span class="text-red-500">*</span></label>
                            <input type="text" id="ia11-item-name" name="item_name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm border px-3 py-2" placeholder="Contoh: Sertifikat Pelatihan">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea id="ia11-description" name="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm border px-3 py-2" placeholder="Deskripsi item..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kriteria Verifikasi</label>
                            <textarea id="ia11-criteria" name="verification_criteria" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm border px-3 py-2" placeholder="Kriteria yang harus dipenuhi..."></textarea>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="ia11-required" name="is_required" checked class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <label for="ia11-required" class="ml-2 block text-sm text-gray-700">Wajib (Required)</label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
                    <button type="button" onclick="closeIA11Modal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let ia11Items = [];

window.loadIA11Content = async function() {
    document.getElementById('ia11-loading').classList.remove('hidden');
    document.getElementById('ia11-empty').classList.add('hidden');
    document.getElementById('ia11-items').innerHTML = '';
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia11`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        document.getElementById('ia11-loading').classList.add('hidden');
        
        if (data.success && data.data.checklist && data.data.checklist.length > 0) {
            ia11Items = data.data.checklist;
            renderIA11List();
        } else {
            document.getElementById('ia11-empty').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error loading IA11:', error);
        document.getElementById('ia11-loading').classList.add('hidden');
        showAlert('error', 'Gagal memuat checklist');
    }
};

function renderIA11List() {
    const container = document.getElementById('ia11-items');
    container.innerHTML = ia11Items.map((item, i) => `
        <div class="content-card bg-white border border-gray-200 rounded-lg p-4 flex items-start" data-id="${item.id}">
            <div class="flex-1">
                <div class="flex items-center mb-2">
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded">#${i + 1}</span>
                    ${item.is_required ? '<span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-0.5 rounded">Wajib</span>' : '<span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">Opsional</span>'}
                </div>
                <h4 class="text-sm font-medium text-gray-800 mb-1">${item.item_name}</h4>
                ${item.description ? `<p class="text-xs text-gray-600 mb-1">${item.description}</p>` : ''}
                ${item.verification_criteria ? `<p class="text-xs text-gray-500 italic">Kriteria: ${item.verification_criteria}</p>` : ''}
            </div>
            <div class="flex items-center space-x-2 ml-4">
                <button type="button" onclick="editIA11(${item.id})" class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <button type="button" onclick="deleteIA11(${item.id})" class="text-red-600 hover:text-red-800 p-1" title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        </div>
    `).join('');
}

function openIA11Modal(id = null) {
    document.getElementById('ia11-modal').classList.remove('hidden');
    document.getElementById('ia11-form').reset();
    document.getElementById('ia11-id').value = '';
    document.getElementById('ia11-modal-title').textContent = 'Tambah Item Checklist';
    document.getElementById('ia11-required').checked = true;
    
    if (id) {
        const item = ia11Items.find(x => x.id === id);
        if (item) {
            document.getElementById('ia11-modal-title').textContent = 'Edit Item Checklist';
            document.getElementById('ia11-id').value = item.id;
            document.getElementById('ia11-item-name').value = item.item_name || '';
            document.getElementById('ia11-description').value = item.description || '';
            document.getElementById('ia11-criteria').value = item.verification_criteria || '';
            document.getElementById('ia11-required').checked = item.is_required;
        }
    }
}

function closeIA11Modal() {
    document.getElementById('ia11-modal').classList.add('hidden');
}

function editIA11(id) {
    openIA11Modal(id);
}

async function saveIA11(e) {
    e.preventDefault();
    const id = document.getElementById('ia11-id').value;
    const formData = {
        item_name: document.getElementById('ia11-item-name').value,
        description: document.getElementById('ia11-description').value,
        verification_criteria: document.getElementById('ia11-criteria').value,
        is_required: document.getElementById('ia11-required').checked
    };
    
    try {
        const url = id 
            ? `/admin/skema/${window.skemaId}/content/ia11/${id}`
            : `/admin/skema/${window.skemaId}/content/ia11`;
        const method = id ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', id ? 'Item berhasil diperbarui' : 'Item berhasil ditambahkan');
            closeIA11Modal();
            loadIA11Content();
        } else {
            showAlert('error', data.message || 'Gagal menyimpan item');
        }
    } catch (error) {
        console.error('Error saving IA11:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan');
    }
}

async function deleteIA11(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia11/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Item berhasil dihapus');
            loadIA11Content();
        } else {
            showAlert('error', data.message || 'Gagal menghapus item');
        }
    } catch (error) {
        console.error('Error deleting IA11:', error);
        showAlert('error', 'Terjadi kesalahan saat menghapus');
    }
}
</script>
