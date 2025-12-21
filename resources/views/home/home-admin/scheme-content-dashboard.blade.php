@extends('home.home-admin.layouts.layout')

@section('title', 'Manajemen Konten Asesmen per Template - ' . $skema->nama_skema)

@section('styles')
<style>
    .tab-btn { transition: all 0.2s ease; }
    .tab-btn.active { border-bottom: 3px solid #4f46e5; color: #4f46e5; background-color: #eef2ff; }
    .tab-btn:hover:not(.active) { background-color: #f3f4f6; }
    .content-card { transition: all 0.2s ease-in-out; }
    .content-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
    .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); }
    .sortable-ghost { opacity: 0.4; background-color: #e0e7ff; }
    .drag-handle { cursor: grab; }
    .drag-handle:active { cursor: grabbing; }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home-admin') }}" class="text-gray-700 hover:text-indigo-600 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('admin.skema.index') }}" class="ml-1 text-gray-700 hover:text-indigo-600 md:ml-2">Skema Sertifikasi</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-gray-500 md:ml-2 font-medium">Konten per Template IA</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Alert Container -->
        <div id="alert-container" class="mb-6"></div>

        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 py-6 px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Manajemen Konten per Template IA</h1>
                        <p class="text-indigo-100 mt-1">{{ $skema->nomor_skema }} - {{ $skema->nama_skema }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button type="button" onclick="openCopyModal()" class="flex items-center text-white bg-indigo-800 hover:bg-indigo-900 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            Salin dari Skema Lain
                        </button>
                        <a href="{{ route('admin.skema.index') }}" class="flex items-center text-white bg-indigo-800 hover:bg-indigo-900 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                            <svg class="w-5 h-5 mr-1 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Content Summary Cards -->
            <div class="grid grid-cols-3 gap-4 p-6 bg-gray-50">
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $summary['ia05_count'] }}</div>
                    <div class="text-xs text-gray-500">IA05 Soal</div>
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <div class="text-2xl font-bold {{ $summary['ia02_exists'] ? 'text-blue-600' : 'text-gray-400' }}">{{ $summary['ia02_exists'] ? '✓' : '—' }}</div>
                    <div class="text-xs text-gray-500">IA02 Template</div>
                </div>
                <div class="bg-white rounded-lg p-4 border border-gray-200 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $summary['ia07_count'] }}</div>
                    <div class="text-xs text-gray-500">IA07 Pertanyaan</div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex overflow-x-auto" aria-label="Tabs">
                    <button type="button" class="tab-btn active whitespace-nowrap py-4 px-6 font-medium text-sm" data-tab="ia05">
                        IA05 - Pilihan Ganda
                        <span class="ml-2 bg-green-100 text-green-800 py-0.5 px-2 rounded-full text-xs">{{ $summary['ia05_count'] }}</span>
                    </button>
                    <button type="button" class="tab-btn whitespace-nowrap py-4 px-6 font-medium text-sm text-gray-500" data-tab="ia02">
                        IA02 - Instruksi Kerja
                        <span class="ml-2 {{ $summary['ia02_exists'] ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600' }} py-0.5 px-2 rounded-full text-xs">{{ $summary['ia02_exists'] ? '✓' : '—' }}</span>
                    </button>
                    <button type="button" class="tab-btn whitespace-nowrap py-4 px-6 font-medium text-sm text-gray-500" data-tab="ia07">
                        IA07 - Pertanyaan Lisan
                        <span class="ml-2 bg-purple-100 text-purple-800 py-0.5 px-2 rounded-full text-xs">{{ $summary['ia07_count'] }}</span>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab Content Panels -->
        <div id="tab-content">
            <!-- IA05 Tab -->
            <div id="tab-ia05" class="tab-panel">
                @include('home.home-admin.partials.scheme-content.ia05-tab')
            </div>
            
            <!-- IA02 Tab -->
            <div id="tab-ia02" class="tab-panel hidden">
                @include('home.home-admin.partials.scheme-content.ia02-tab')
            </div>
            
            <!-- IA07 Tab -->
            <div id="tab-ia07" class="tab-panel hidden">
                @include('home.home-admin.partials.scheme-content.ia07-tab')
            </div>
        </div>
    </div>
</div>

<!-- Copy Content Modal -->
@include('home.home-admin.partials.scheme-content.copy-modal')

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const skemaId = '{{ $skema->id_skema }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Expose functions globally first
    window.skemaId = skemaId;
    window.csrfToken = csrfToken;
    window.showAlert = showAlert;
    window.loadTabContent = loadTabContent;
    
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Update button states
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
                b.classList.add('text-gray-500');
            });
            this.classList.add('active');
            this.classList.remove('text-gray-500');
            
            // Show/hide panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            
            // Load content if needed
            loadTabContent(tabId);
        });
    });
    
    // Initial load - use setTimeout to ensure all scripts are loaded
    setTimeout(function() {
        loadTabContent('ia05');
    }, 100);
});

function loadTabContent(tabId) {
    // Each tab has its own load function
    const funcName = 'load' + tabId.toUpperCase() + 'Content';
    if (typeof window[funcName] === 'function') {
        window[funcName]();
    }
}

function showAlert(type, message) {
    const container = document.getElementById('alert-container');
    const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    const iconPath = type === 'success' 
        ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'
        : 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z';
    
    container.innerHTML = `
        <div class="${alertClass} border-l-4 p-4 rounded shadow-md" role="alert">
            <div class="flex">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="${iconPath}" clip-rule="evenodd"></path></svg>
                <div class="ml-3"><p class="text-sm">${message}</p></div>
                <button type="button" class="ml-auto" onclick="this.parentElement.parentElement.remove()">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        </div>
    `;
    
    setTimeout(() => container.innerHTML = '', 5000);
}

function openCopyModal() {
    document.getElementById('copy-modal').classList.remove('hidden');
    loadSourceSchemes();
}

function closeCopyModal() {
    document.getElementById('copy-modal').classList.add('hidden');
}

async function loadSourceSchemes() {
    try {
        const response = await fetch('/admin/content/copy/sources', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken }
        });
        const data = await response.json();
        
        if (data.success) {
            const select = document.getElementById('source-skema');
            select.innerHTML = '<option value="">-- Pilih Skema Sumber --</option>';
            data.data.forEach(s => {
                if (s.id_skema !== window.skemaId) {
                    select.innerHTML += `<option value="${s.id_skema}">${s.nama_skema}</option>`;
                }
            });
        }
    } catch (error) {
        console.error('Error loading source schemes:', error);
    }
}

async function copyContent() {
    const sourceId = document.getElementById('source-skema').value;
    const overwrite = document.getElementById('overwrite-content').checked;
    
    if (!sourceId) {
        showAlert('error', 'Pilih skema sumber terlebih dahulu');
        return;
    }
    
    try {
        const response = await fetch('/admin/content/copy', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({
                source_skema_id: sourceId,
                target_skema_id: window.skemaId,
                overwrite: overwrite
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert('success', 'Konten berhasil disalin');
            closeCopyModal();
            location.reload();
        } else {
            showAlert('error', data.message || 'Gagal menyalin konten');
        }
    } catch (error) {
        console.error('Error copying content:', error);
        showAlert('error', 'Terjadi kesalahan saat menyalin konten');
    }
}
</script>
@endsection
