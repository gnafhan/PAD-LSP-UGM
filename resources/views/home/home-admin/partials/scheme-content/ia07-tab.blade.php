{{-- IA07 - Oral Questions Tab --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">IA07 - Pertanyaan Lisan</h2>
            <p class="text-sm text-gray-500">Kelola pertanyaan lisan per unit kompetensi dan elemen</p>
        </div>
        <button type="button" onclick="openIA07Modal()" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Pertanyaan
        </button>
    </div>

    <div id="ia07-list">
        <div class="text-center py-12 text-gray-500" id="ia07-loading">
            <svg class="animate-spin h-8 w-8 mx-auto mb-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p>Memuat pertanyaan...</p>
        </div>
        <div class="text-center py-12 text-gray-500 hidden" id="ia07-empty">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pertanyaan</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan pertanyaan lisan baru.</p>
        </div>
        <div id="ia07-items" class="space-y-6"></div>
    </div>
</div>

<!-- IA07 Modal -->
<div id="ia07-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 modal-backdrop" onclick="closeIA07Modal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="ia07-form" onsubmit="saveIA07(event)">
                <div class="bg-white px-6 pt-6 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" id="ia07-modal-title">Tambah Pertanyaan Baru</h3>
                    <input type="hidden" id="ia07-id" name="id">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Kompetensi <span class="text-red-500">*</span></label>
                            <select id="ia07-uk" name="id_uk" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm border px-3 py-2" onchange="loadElemenUK()">
                                <option value="">-- Pilih UK --</option>
                                @foreach($unitKompetensi as $uk)
                                    <option value="{{ $uk->id_uk }}">{{ $uk->kode_uk }} - {{ $uk->nama_uk }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Elemen UK <span class="text-red-500">*</span></label>
                            <select id="ia07-elemen" name="id_elemen_uk" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm border px-3 py-2">
                                <option value="">-- Pilih Elemen --</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pertanyaan <span class="text-red-500">*</span></label>
                            <textarea id="ia07-pertanyaan" name="pertanyaan" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm border px-3 py-2"></textarea>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="ia07-active" name="is_active" checked class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <label for="ia07-active" class="ml-2 block text-sm text-gray-700">Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
                    <button type="button" onclick="closeIA07Modal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let ia07Questions = [];
const unitKompetensiData = @json($unitKompetensi);

window.loadIA07Content = async function() {
    document.getElementById('ia07-loading').classList.remove('hidden');
    document.getElementById('ia07-empty').classList.add('hidden');
    document.getElementById('ia07-items').innerHTML = '';
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia07`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        document.getElementById('ia07-loading').classList.add('hidden');
        
        if (data.success && data.data.questions && data.data.questions.length > 0) {
            ia07Questions = data.data.questions;
            renderIA07List();
        } else {
            document.getElementById('ia07-empty').classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error loading IA07:', error);
        document.getElementById('ia07-loading').classList.add('hidden');
        showAlert('error', 'Gagal memuat pertanyaan');
    }
};

function renderIA07List() {
    const container = document.getElementById('ia07-items');
    
    // Group by UK
    const grouped = {};
    ia07Questions.forEach(q => {
        const ukKey = q.id_uk;
        if (!grouped[ukKey]) {
            grouped[ukKey] = {
                uk: q.unit_kompetensi,
                questions: []
            };
        }
        grouped[ukKey].questions.push(q);
    });
    
    container.innerHTML = Object.entries(grouped).map(([ukId, data]) => `
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="bg-purple-50 px-4 py-3 border-b border-gray-200">
                <h4 class="font-medium text-purple-800">${data.uk?.kode_uk || 'UK'} - ${data.uk?.nama_uk || 'Unit Kompetensi'}</h4>
            </div>
            <div class="divide-y divide-gray-100">
                ${data.questions.map((q, i) => `
                    <div class="p-4 hover:bg-gray-50 flex items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-1">
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2 py-0.5 rounded">#${i + 1}</span>
                                <span class="ml-2 text-xs text-gray-500">${q.elemen_u_k?.nama_elemen || 'Elemen'}</span>
                                ${!q.is_active ? '<span class="ml-2 bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded">Nonaktif</span>' : ''}
                            </div>
                            <p class="text-sm text-gray-800">${q.pertanyaan}</p>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button type="button" onclick="editIA07(${q.id})" class="text-blue-600 hover:text-blue-800 p-1" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button type="button" onclick="deleteIA07(${q.id})" class="text-red-600 hover:text-red-800 p-1" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    `).join('');
}

function loadElemenUK() {
    const ukId = document.getElementById('ia07-uk').value;
    const elemenSelect = document.getElementById('ia07-elemen');
    elemenSelect.innerHTML = '<option value="">-- Pilih Elemen --</option>';
    
    if (!ukId) return;
    
    const uk = unitKompetensiData.find(u => u.id_uk === ukId);
    if (uk && uk.elemen_uk) {
        uk.elemen_uk.forEach(e => {
            elemenSelect.innerHTML += `<option value="${e.id_elemen_uk}">${e.nama_elemen}</option>`;
        });
    }
}

function openIA07Modal(id = null) {
    document.getElementById('ia07-modal').classList.remove('hidden');
    document.getElementById('ia07-form').reset();
    document.getElementById('ia07-id').value = '';
    document.getElementById('ia07-modal-title').textContent = 'Tambah Pertanyaan Baru';
    document.getElementById('ia07-elemen').innerHTML = '<option value="">-- Pilih Elemen --</option>';
    
    if (id) {
        const q = ia07Questions.find(x => x.id === id);
        if (q) {
            document.getElementById('ia07-modal-title').textContent = 'Edit Pertanyaan';
            document.getElementById('ia07-id').value = q.id;
            document.getElementById('ia07-uk').value = q.id_uk;
            loadElemenUK();
            setTimeout(() => {
                document.getElementById('ia07-elemen').value = q.id_elemen_uk;
            }, 100);
            document.getElementById('ia07-pertanyaan').value = q.pertanyaan || '';
            document.getElementById('ia07-active').checked = q.is_active;
        }
    }
}

function closeIA07Modal() {
    document.getElementById('ia07-modal').classList.add('hidden');
}

function editIA07(id) {
    openIA07Modal(id);
}

async function saveIA07(e) {
    e.preventDefault();
    const id = document.getElementById('ia07-id').value;
    const formData = {
        id_uk: document.getElementById('ia07-uk').value,
        id_elemen_uk: document.getElementById('ia07-elemen').value,
        pertanyaan: document.getElementById('ia07-pertanyaan').value,
        is_active: document.getElementById('ia07-active').checked
    };
    
    try {
        const url = id 
            ? `/admin/skema/${window.skemaId}/content/ia07/${id}`
            : `/admin/skema/${window.skemaId}/content/ia07`;
        const method = id ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', id ? 'Pertanyaan berhasil diperbarui' : 'Pertanyaan berhasil ditambahkan');
            closeIA07Modal();
            loadIA07Content();
        } else {
            showAlert('error', data.message || 'Gagal menyimpan pertanyaan');
        }
    } catch (error) {
        console.error('Error saving IA07:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan');
    }
}

async function deleteIA07(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) return;
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia07/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Pertanyaan berhasil dihapus');
            loadIA07Content();
        } else {
            showAlert('error', data.message || 'Gagal menghapus pertanyaan');
        }
    } catch (error) {
        console.error('Error deleting IA07:', error);
        showAlert('error', 'Terjadi kesalahan saat menghapus');
    }
}
</script>
