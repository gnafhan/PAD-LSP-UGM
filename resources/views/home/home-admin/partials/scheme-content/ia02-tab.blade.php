{{-- IA02 - Work Instructions Template Tab --}}
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">IA02 - Template Instruksi Kerja</h2>
            <p class="text-sm text-gray-500">Kelola template instruksi kerja untuk tugas praktik</p>
        </div>
        <button type="button" onclick="saveIA02()" id="ia02-save-btn" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan Template
        </button>
    </div>

    <div id="ia02-loading" class="text-center py-12 text-gray-500">
        <svg class="animate-spin h-8 w-8 mx-auto mb-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p>Memuat template...</p>
    </div>

    <div id="ia02-content" class="hidden">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded-r-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">Template ini akan digunakan sebagai instruksi kerja default untuk tugas praktik pada skema ini. Anda dapat menggunakan HTML untuk formatting.</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Instruksi Kerja</label>
            <textarea id="ia02-instruksi" rows="15" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm border px-3 py-2 font-mono" placeholder="Masukkan instruksi kerja di sini..."></textarea>
        </div>

        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Preview</h4>
            <div id="ia02-preview" class="prose prose-sm max-w-none bg-white p-4 rounded border border-gray-200 min-h-[100px]">
                <p class="text-gray-400 italic">Preview akan muncul di sini...</p>
            </div>
        </div>
    </div>
</div>

<script>
let ia02Template = null;

window.loadIA02Content = async function() {
    document.getElementById('ia02-loading').classList.remove('hidden');
    document.getElementById('ia02-content').classList.add('hidden');
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia02`, {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        document.getElementById('ia02-loading').classList.add('hidden');
        document.getElementById('ia02-content').classList.remove('hidden');
        
        if (data.success && data.data.template) {
            ia02Template = data.data.template;
            document.getElementById('ia02-instruksi').value = data.data.template.instruksi_kerja || '';
            updateIA02Preview();
        }
    } catch (error) {
        console.error('Error loading IA02:', error);
        document.getElementById('ia02-loading').classList.add('hidden');
        document.getElementById('ia02-content').classList.remove('hidden');
        showAlert('error', 'Gagal memuat template');
    }
};

document.getElementById('ia02-instruksi')?.addEventListener('input', function() {
    updateIA02Preview();
});

function updateIA02Preview() {
    const content = document.getElementById('ia02-instruksi').value;
    const preview = document.getElementById('ia02-preview');
    
    if (content.trim()) {
        preview.innerHTML = content;
    } else {
        preview.innerHTML = '<p class="text-gray-400 italic">Preview akan muncul di sini...</p>';
    }
}

async function saveIA02() {
    const content = document.getElementById('ia02-instruksi').value;
    
    try {
        const response = await fetch(`/admin/skema/${window.skemaId}/content/ia02`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
            body: JSON.stringify({ instruksi_kerja: content })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Template berhasil disimpan');
            ia02Template = data.data;
        } else {
            showAlert('error', data.message || 'Gagal menyimpan template');
        }
    } catch (error) {
        console.error('Error saving IA02:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan');
    }
}
</script>
