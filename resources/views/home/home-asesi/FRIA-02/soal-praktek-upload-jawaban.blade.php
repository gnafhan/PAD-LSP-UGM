@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'FR.IA-02 Soal Praktik - Lembaga Sertifikasi Profesi UGM')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <div class="flex items-center space-x-2 text-sm">
            <i class="fas fa-home text-blue-600"></i>
            <a href="{{ route('asesi.index') }}" class="text-blue-600 hover:text-blue-800">Home</a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <a href="{{ route('asesi.index') }}" class="text-blue-600 hover:text-blue-800">Formulir IA.02</a>
            <i class="fas fa-chevron-right text-xs text-gray-400"></i>
            <span class="text-gray-600">Soal Praktik</span>
        </div>
    </nav>

    <div id="bgGradient"
         class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-blue-400 to-purple-600 opacity-20 blur-[80px]">
    </div>

    <div class="relative z-10 space-y-6">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-clipboard-list mr-3"></i>
                        FR.IA-02 Soal Praktik dan Upload Jawaban
                    </h1>
                    <button type="button" onclick="window.history.back()" 
                            class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-1 rounded-lg text-sm flex items-center transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </button>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="font-bold">Ada kesalahan pada form:</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Detail Tugas Card -->
        @if(isset($data))
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Detail Tugas
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <tbody>
                            <tr class="border-b border-gray-300">
                                <th class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700 w-1/4">Nama Asesi</th>
                                <td class="px-4 py-3 text-gray-900">{{ $data->nama_peserta ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr class="border-b border-gray-300">
                                <th class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Skema Kompetensi</th>
                                <td class="px-4 py-3 text-gray-900">{{ $data->judul_sertifikasi ?? 'Belum diisi' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-gray-50 px-4 py-3 text-left font-medium text-gray-700">Nama Asesor</th>
                                <td class="px-4 py-3 text-gray-900">{{ $data->nama_asesor ?? 'Belum diisi' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Instruksi Tugas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-tasks mr-2"></i>
                    Instruksi dan Skenario Tugas
                </h2>
            </div>
            <div class="p-6">
                @if(isset($data) && $data->instruksi_kerja)
                    <div class="space-y-4">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-clipboard-list mr-2 text-blue-600"></i>
                                Instruksi Kerja:
                            </h4>
                            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                {!! $data->instruksi_kerja !!}
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2 text-yellow-600"></i>
                                Petunjuk Umum:
                            </h4>
                            <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                <li>Baca dan pelajari setiap instruksi kerja di atas dengan cermat sebelum melaksanakan praktik</li>
                                <li>Klarifikasi kepada asesor apabila ada hal-hal yang belum jelas</li>
                                <li>Laksanakan pekerjaan sesuai dengan urutan proses yang sudah ditetapkan</li>
                                <li>Seluruh proses kerja mengacu kepada SOP yang dipersyaratkan</li>
                            </ol>
                        </div>
                    </div>
                @else
                    <div class="space-y-4">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                            <i class="fas fa-info-circle text-4xl text-gray-300 mb-3"></i>
                            <h4 class="font-semibold text-gray-600 mb-2">Instruksi Kerja Belum Tersedia</h4>
                            <p class="text-gray-500">Instruksi kerja untuk tugas praktik ini belum dibuat oleh asesor. Silakan hubungi asesor Anda untuk informasi lebih lanjut.</p>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2 text-yellow-600"></i>
                                Petunjuk Umum:
                            </h4>
                            <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                <li>Hubungi asesor untuk mendapatkan instruksi kerja yang detail</li>
                                <li>Klarifikasi kepada asesor apabila ada hal-hal yang belum jelas</li>
                                <li>Laksanakan pekerjaan sesuai dengan urutan proses yang sudah ditetapkan</li>
                                <li>Seluruh proses kerja mengacu kepada SOP yang dipersyaratkan</li>
                            </ol>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Upload Tugas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-upload mr-2"></i>
                    Kumpulkan Tugas
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Side: Input and Preview Area -->
                    <div class="order-2 lg:order-1">
                        <div class="border-2 border-gray-300 rounded-lg p-6 bg-gray-50 min-h-96">
                            <!-- Dynamic Evidence Input -->
                            <div id="evidence-input" class="hidden">
                                <!-- Dynamic content based on selection -->
                            </div>
                            
                            <!-- Preview Area -->
                            <div id="preview-area" class="min-h-80 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-eye text-4xl mb-3"></i>
                                    <p>Preview akan muncul di sini</p>
                                    <p class="text-sm">Pilih jenis evidence untuk melihat preview</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side: Form Controls -->
                    <div class="order-1 lg:order-2">
                        <div class="border-2 border-blue-200 rounded-lg p-6 bg-blue-50 min-h-96">
                            <h3 class="font-bold text-blue-800 mb-4">**KUMPULKAN TUGAS</h3>
                            <hr class="mb-4">
                            
                            <form action="{{ route('asesi.tugas.store') }}" method="post" id="form-submit" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_asesi" value="{{ $data->id_asesi ?? '' }}">
                                <input type="hidden" name="id_skema" value="{{ $data->id_skema ?? '' }}">
                                
                                <div class="space-y-4">
                                    <div>
                                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                            <strong>Judul Tugas</strong>
                                        </label>
                                        <input type="text" id="judul" name="judul_tugas" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                               placeholder="Input judul tugas" required>
                                    </div>
                                    
                                    <div>
                                        <label for="tugas" class="block text-sm font-medium text-gray-700 mb-2">
                                            <strong>Evidence Tugas</strong>
                                        </label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                                id="tugas" name="jenis_evidence">
                                            <option value="">--pilih--</option>
                                            <option value="1">Teks Jawaban</option>
                                            <option value="2">Link Eksternal</option>
                                            <option value="3">Upload File</option>
                                        </select>
                                    </div>
                                    
                                    <div id="evidence" class="py-2">
                                        <!-- Dynamic content based on selection -->
                                    </div>
                                    
                                    <input type="hidden" name="send">
                                    <button name="send" id="btn-submit" 
                                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-medium py-2 px-4 rounded-lg transition-colors disabled:cursor-not-allowed">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Submit Tugas
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Tugas yang Sudah Dikumpulkan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-list-check mr-2"></i>
                    Bukti Tugas Praktik
                </h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-700">No</th>
                                <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-700">Judul Tugas</th>
                                <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-700">Evidence</th>
                                <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-700">Status</th>
                                <th class="border border-gray-300 px-4 py-3 text-left font-medium text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($tugasSubmitted) && $tugasSubmitted && $tugasSubmitted->count() > 0)
                                @foreach($tugasSubmitted as $index => $tugas)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-3 text-center">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ $tugas->judul_tugas }}</div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $tugas->waktu_submit ? $tugas->waktu_submit->format('d/m/Y H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        @if($tugas->jenis_evidence == '1')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-file-text mr-1"></i> Teks Jawaban
                                            </span>
                                        @elseif($tugas->jenis_evidence == '2')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-link mr-1"></i> Link Eksternal
                                            </span>
                                        @elseif($tugas->jenis_evidence == '3')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                <i class="fas fa-file mr-1"></i> File Upload
                                            </span>
                                            @if($tugas->file_name)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $tugas->file_name }}
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        @if($tugas->status == 'submitted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i> Menunggu Review
                                            </span>
                                        @elseif($tugas->status == 'reviewed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i> Sudah Direview
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($tugas->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            <!-- View Detail Button -->
                                            <button onclick="viewTaskDetail({{ $tugas->id }})" 
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                                                <i class="fas fa-eye mr-1"></i> Lihat
                                            </button>                                            <!-- Download Button (for file uploads) -->
                                            @if($tugas->jenis_evidence == '3' && $tugas->file_path)
                                                <a href="{{ route('asesi.tugas.download', $tugas->id) }}" 
                                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1">
                                                    <i class="fas fa-download mr-1"></i> Download
                                                </a>
                                            @endif
                                            
                                            <!-- Delete Button (only if not reviewed) -->
                                            @if($tugas->status != 'reviewed')
                                                <button onclick="deleteTask({{ $tugas->id }})" 
                                                    class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                                                    <i class="fas fa-trash mr-1"></i> Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                        <p>Belum ada tugas yang dikumpulkan</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.ql-editor {
    min-height: 300px;
    max-height: 400px;
    font-size: 14px;
    max-width: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box;
}
.ql-container {
    font-size: 14px;
    max-width: 100%;
    max-height: 400px;
    overflow: hidden;
    box-sizing: border-box;
}
.ql-toolbar {
    max-width: 100%;
    overflow-x: auto;
    box-sizing: border-box;
    border-bottom: 1px solid #ccc;
}
.preview-quill {
    max-width: 100%;
    max-height: 450px;
    overflow: hidden;
    box-sizing: border-box;
}
.preview-quill .ql-toolbar {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    max-width: 100%;
    overflow-x: auto;
    box-sizing: border-box;
}
.preview-quill .ql-container {
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    max-width: 100%;
    max-height: 400px;
    overflow: hidden;
    box-sizing: border-box;
}
.quill-wrapper {
    width: 100%;
    max-width: 100%;
    max-height: 450px;
    overflow: hidden;
    box-sizing: border-box;
}

/* Upload Area Styles */
.upload-area {
    position: relative;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-area.dragover {
    transform: scale(1.02);
    box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
}

.upload-area:hover {
    border-color: #60a5fa !important;
    background-color: #eff6ff !important;
}

.upload-area.dragover .upload-content i {
    color: #3b82f6 !important;
    transform: scale(1.1);
}

.upload-content {
    transition: all 0.3s ease;
}

.upload-area:hover .upload-content i {
    color: #3b82f6;
    transform: scale(1.05);
}

/* File selected state */
.file-selected {
    border-color: #10b981 !important;
    background-color: #ecfdf5 !important;
}

.file-selected .upload-content i {
    color: #10b981 !important;
}

/* Additional Quill height constraints */
#evidence-input .quill-wrapper {
    max-height: 450px !important;
    overflow: hidden !important;
}

#evidence-input .preview-quill {
    max-height: 400px !important;
    overflow: hidden !important;
}

#evidence-input .ql-container {
    max-height: 340px !important;
}

#evidence-input .ql-editor {
    max-height: 300px !important;
    overflow-y: auto !important;
}
</style>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
console.log('Quill script loaded, Quill available:', typeof Quill !== 'undefined');

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing page...');
    console.log('Quill available:', typeof Quill !== 'undefined');
    
    // Global variables for Quill.js
    let quillEditor = null;
    let quillReady = false;
    
    // Get elements
    const tugasSelect = document.getElementById('tugas');
    const evidenceDiv = document.getElementById('evidence');
    const evidenceInputDiv = document.getElementById('evidence-input');
    const previewArea = document.getElementById('preview-area');
    const submitBtn = document.getElementById('btn-submit');
    const judulInput = document.getElementById('judul');

    // Check if elements exist
    if (!tugasSelect) {
        console.error('tugas select element not found');
        return;
    }
    if (!evidenceDiv) {
        console.error('evidence div not found');
        return;
    }
    if (!evidenceInputDiv) {
        console.error('evidence input div not found');
        return;
    }
    if (!previewArea) {
        console.error('preview area not found');
        return;
    }
    if (!submitBtn) {
        console.error('submit button not found');
        return;
    }
    if (!judulInput) {
        console.error('judul input not found');
        return;
    }

    console.log('All elements found successfully');

    function checkFormValidity() {
        const judulFilled = judulInput.value.trim() !== '';
        const tugasSelected = tugasSelect.value !== '';
        
        let evidenceValid = false;
        
        if (tugasSelected === '1' && quillEditor && quillReady) {
            // Check Quill content
            evidenceValid = quillEditor.getText().trim() !== '';
        } else if (tugasSelected === '2') {
            // Check link input
            const linkInput = document.getElementById('link_eksternal');
            evidenceValid = linkInput && linkInput.value.trim() !== '';
        } else if (tugasSelected === '3') {
            // Check file upload
            const fileInput = document.getElementById('file_upload');
            evidenceValid = fileInput && fileInput.files.length > 0;
        } else if (tugasSelected !== '') {
            evidenceValid = true; // For other types
        }
        
        if (judulFilled && tugasSelected && evidenceValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled');
        }
    }

    function resetPreviewArea() {
        previewArea.innerHTML = `
            <div class="text-center text-gray-500 min-h-80 flex items-center justify-center">
                <div>
                    <i class="fas fa-eye text-4xl mb-3"></i>
                    <p>Preview akan muncul di sini</p>
                    <p class="text-sm">Pilih jenis evidence untuk melihat preview</p>
                </div>
            </div>
        `;
        previewArea.classList.remove('hidden');
        // Hide evidence input area and reset Quill state
        evidenceInputDiv.classList.add('hidden');
        evidenceInputDiv.innerHTML = '';
        // Clear the form evidence div as well
        const evidenceDiv = document.getElementById('evidence');
        if (evidenceDiv) {
            evidenceDiv.innerHTML = '';
        }
        quillEditor = null;
        quillReady = false;
    }

    function initializeQuillEditor() {
        console.log('Initializing Quill editor...');
        
        // Check if Quill is loaded
        if (typeof Quill === 'undefined') {
            console.error('Quill is not loaded');
            setTimeout(() => {
                initializeQuillEditor();
            }, 1000);
            return;
        }

        // Check if container exists
        const container = document.getElementById('quill-preview');
        if (!container) {
            console.error('Quill container not found');
            return;
        }

        try {
            // Destroy existing instance if any
            if (quillEditor) {
                console.log('Destroying existing Quill instance');
                quillEditor = null;
                quillReady = false;
            }

            // Initialize Quill editor
            quillEditor = new Quill('#quill-preview', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'script': 'sub'}, { 'script': 'super' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link']
                    ]
                },
                placeholder: 'Mulai menulis jawaban Anda di sini...',
                bounds: '#quill-preview'
            });

            // Ensure editor height constraint
            const editorElement = document.querySelector('#quill-preview .ql-editor');
            if (editorElement) {
                editorElement.style.maxHeight = '300px';
                editorElement.style.overflowY = 'auto';
            }

            // Mark as ready
            quillReady = true;
            console.log('Quill editor initialized successfully');

            // Update hidden textarea when Quill content changes
            quillEditor.on('text-change', function() {
                const content = quillEditor.root.innerHTML;
                const hiddenTextarea = document.getElementById('teks_jawaban');
                if (hiddenTextarea) {
                    hiddenTextarea.value = content;
                }
                checkFormValidity();
            });

        } catch (error) {
            console.error('Error initializing Quill:', error);
            quillEditor = null;
            quillReady = false;
        }
    }

    function createQuillInPreview() {
        console.log('Creating Quill in preview area...');
        
        // Show input area and add Quill editor
        evidenceInputDiv.classList.remove('hidden');
        evidenceInputDiv.innerHTML = `
            <div class="mb-3 text-center">
                <h4 class="font-semibold text-gray-700 flex items-center justify-center">
                    <i class="fas fa-edit mr-2 text-blue-600"></i>
                    Rich Text Editor
                </h4>
                <p class="text-sm text-gray-500">Tulis jawaban Anda dengan formatting yang lengkap</p>
            </div>
            <div class="quill-wrapper w-full overflow-hidden" style="max-height: 450px;">
                <div id="quill-preview" class="preview-quill bg-white rounded-lg border border-gray-300" style="height: 400px; width: 100%; max-width: 100%; max-height: 400px;"></div>
            </div>
        `;
        
        // Create the textarea inside the FORM instead of preview area
        const evidenceDiv = document.getElementById('evidence');
        if (evidenceDiv) {
            evidenceDiv.innerHTML = `<textarea id="teks_jawaban" name="teks_jawaban" class="hidden"></textarea>`;
        }
        
        // Hide preview area when using Quill
        previewArea.classList.add('hidden');

        // Initialize Quill editor with delay
        setTimeout(() => {
            initializeQuillEditor();
        }, 300);
    }

    function createFilePreview() {
        // Show input area with completely integrated upload and preview
        evidenceInputDiv.classList.remove('hidden');
        evidenceInputDiv.innerHTML = `
            <div class="mb-3 text-center">
                <h4 class="font-semibold text-gray-700 flex items-center justify-center">
                    <i class="fas fa-cloud-upload-alt mr-2 text-green-600"></i>
                    Upload File
                </h4>
                <p class="text-sm text-gray-500">Pilih atau drag & drop file yang akan diupload</p>
            </div>
            
            <!-- Integrated Upload and Preview Area -->
            <div id="upload-preview-area" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 bg-white">
                <div id="upload-content" class="upload-content">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <div class="text-lg font-medium text-gray-700 mb-2">
                        Drag & Drop file disini
                    </div>
                    <div class="text-sm text-gray-500 mb-4">
                        atau <span class="text-blue-600 font-medium">klik untuk memilih file</span>
                    </div>
                    <div class="text-xs text-gray-400">
                        Format: PDF, DOC, DOCX, JPG, PNG, ZIP, RAR (Max: 10MB)
                    </div>
                </div>
            </div>
        `;
        
        // Create the file input inside the FORM instead of preview area
        const evidenceDiv = document.getElementById('evidence');
        if (evidenceDiv) {
            // Add file input inside the form
            const fileInputHTML = `<input type="file" id="file_upload" name="file_upload" 
                                              class="hidden"
                                              accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">`;
            evidenceDiv.innerHTML = fileInputHTML;
        }
        
        // Hide preview area when using integrated upload
        previewArea.classList.add('hidden');
    }

    function createLinkPreview() {
        // Hide input area since link input will be on the right
        evidenceInputDiv.classList.add('hidden');
        evidenceInputDiv.innerHTML = '';
        
        // Show preview area on the left with permanent preview
        previewArea.classList.remove('hidden');
        previewArea.innerHTML = `
            <div class="w-full min-h-80 flex flex-col">
                <div class="mb-3 text-center">
                    <h4 class="font-semibold text-gray-700 flex items-center justify-center">
                        <i class="fas fa-link mr-2 text-purple-600"></i>
                        Link Preview
                    </h4>
                    <p class="text-sm text-gray-500">Preview link yang akan dikumpulkan</p>
                </div>
                <div id="link-preview-content" class="bg-white rounded-lg border border-gray-300 p-4 flex-1 flex items-center justify-center">
                    <div class="text-center text-gray-400">
                        <i class="fas fa-external-link-alt text-6xl mb-3"></i>
                        <p>Masukkan URL untuk melihat preview</p>
                        <p class="text-sm">Contoh: https://drive.google.com/...</p>
                    </div>
                </div>
            </div>
        `;
    }

    function handleFileUpload(file) {
        // Update the integrated upload-preview area
        const uploadPreviewArea = document.getElementById('upload-preview-area');
        if (uploadPreviewArea) {
            uploadPreviewArea.classList.add('file-selected');
            uploadPreviewArea.classList.remove('cursor-pointer');
            
            // Show file preview directly in the same area
            handleFilePreview(file, uploadPreviewArea);
        }
    }

    function handleFilePreview(file, previewContainer = null) {
        if (!previewContainer) {
            previewContainer = document.getElementById('upload-preview-area');
        }
        
        if (!previewContainer) return;
        
        const isImage = file.type.startsWith('image/');
        const isPDF = file.type === 'application/pdf';
        const isVideo = file.type.startsWith('video/');
        
        let previewHTML = `<div class="file-preview text-center">`;
        
        if (isImage) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewHTML = `
                    <div class="file-preview text-center">
                        <div class="border border-gray-300 rounded-lg overflow-hidden mb-4">
                            <img src="${e.target.result}" alt="Preview" class="w-full max-h-96 object-contain bg-gray-50">
                        </div>
                        <div class="space-y-2">
                            <div class="text-lg font-medium text-gray-800">
                                File berhasil dipilih
                            </div>
                            <div class="text-sm text-gray-600">
                                ${file.name}
                            </div>
                            <div class="text-xs text-gray-500">
                                Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB
                            </div>
                            <button type="button" onclick="resetFileUpload()" class="text-blue-600 hover:text-blue-800 text-sm underline mt-2">
                                Ganti file
                            </button>
                        </div>
                    </div>`;
                previewContainer.innerHTML = previewHTML;
            };
            reader.readAsDataURL(file);
        } else if (isPDF) {
            previewHTML += `
                <div class="border border-gray-300 rounded-lg p-8 bg-gray-50 mb-4">
                    <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                    <div class="text-gray-600">File PDF</div>
                    <div class="text-sm text-gray-500 mt-2">
                        Preview tidak tersedia, file akan diupload saat form disubmit
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="text-lg font-medium text-gray-800">
                        File berhasil dipilih
                    </div>
                    <div class="text-sm text-gray-600">
                        ${file.name}
                    </div>
                    <div class="text-xs text-gray-500">
                        Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB
                    </div>
                    <button type="button" onclick="resetFileUpload()" class="text-blue-600 hover:text-blue-800 text-sm underline mt-2">
                        Ganti file
                    </button>
                </div>
            </div>`;
            previewContainer.innerHTML = previewHTML;
        } else if (isVideo) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewHTML = `
                    <div class="file-preview text-center">
                        <div class="border border-gray-300 rounded-lg overflow-hidden mb-4">
                            <video controls class="w-full max-h-96">
                                <source src="${e.target.result}" type="${file.type}">
                                Browser Anda tidak mendukung video.
                            </video>
                        </div>
                        <div class="space-y-2">
                            <div class="text-lg font-medium text-gray-800">
                                File berhasil dipilih
                            </div>
                            <div class="text-sm text-gray-600">
                                ${file.name}
                            </div>
                            <div class="text-xs text-gray-500">
                                Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB
                            </div>
                            <button type="button" onclick="resetFileUpload()" class="text-blue-600 hover:text-blue-800 text-sm underline mt-2">
                                Ganti file
                            </button>
                        </div>
                    </div>`;
                previewContainer.innerHTML = previewHTML;
            };
            reader.readAsDataURL(file);
        } else {
            previewHTML += `
                <div class="border border-gray-300 rounded-lg p-8 bg-gray-50 mb-4">
                    <i class="fas fa-file text-6xl text-gray-500 mb-4"></i>
                    <div class="text-gray-600">File: ${file.name}</div>
                    <div class="text-sm text-gray-500 mt-2">
                        Preview tidak tersedia untuk jenis file ini
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="text-lg font-medium text-gray-800">
                        File berhasil dipilih
                    </div>
                    <div class="text-sm text-gray-600">
                        ${file.name}
                    </div>
                    <div class="text-xs text-gray-500">
                        Ukuran: ${(file.size / 1024 / 1024).toFixed(2)} MB
                    </div>
                    <button type="button" onclick="resetFileUpload()" class="text-blue-600 hover:text-blue-800 text-sm underline mt-2">
                        Ganti file
                    </button>
                </div>
            </div>`;
            previewContainer.innerHTML = previewHTML;
        }
    }

    // Global function for resetting file upload (accessible from onclick)
    window.resetFileUpload = function() {
        const uploadPreviewArea = document.getElementById('upload-preview-area');
        const fileInput = document.getElementById('file_upload');
        
        if (uploadPreviewArea) {
            uploadPreviewArea.classList.remove('file-selected');
            uploadPreviewArea.classList.add('cursor-pointer');
            uploadPreviewArea.innerHTML = `
                <div class="upload-content text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <div class="text-lg font-medium text-gray-700 mb-2">
                        Drag & Drop file disini
                    </div>
                    <div class="text-sm text-gray-500 mb-4">
                        atau <span class="text-blue-600 font-medium">klik untuk memilih file</span>
                    </div>
                    <div class="text-xs text-gray-400">
                        Format: PDF, DOC, DOCX, JPG, PNG, ZIP, RAR (Max: 10MB)
                    </div>
                </div>
            `;
            
            // Clear file input
            if (fileInput) {
                fileInput.value = '';
            }
            
            // Re-add event listeners for the reset upload area
            setTimeout(() => {
                const newUploadPreviewArea = document.getElementById('upload-preview-area');
                const newFileInput = document.getElementById('file_upload');
                
                if (newUploadPreviewArea && newFileInput) {
                    // Re-add click listener
                    newUploadPreviewArea.addEventListener('click', () => {
                        newFileInput.click();
                    });
                    
                    // Re-add file input change listener
                    newFileInput.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            const file = this.files[0];
                            const maxSize = 10 * 1024 * 1024; // 10MB
                            
                            if (file.size > maxSize) {
                                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                                this.value = ''; // Clear the input
                                return;
                            }
                            
                            handleFileUpload(file);
                        }
                        checkFormValidity();
                    });
                    
                    // Re-add drag and drop listeners
                    addDragDropListeners(newUploadPreviewArea, newFileInput);
                }
            }, 50);
        }
        
        checkFormValidity();
    };

    // Helper function to add drag and drop listeners
    function addDragDropListeners(uploadArea, fileInput) {
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
            uploadArea.classList.add('border-blue-500', 'bg-blue-100');
            uploadArea.classList.remove('border-gray-300');
        });
        
        uploadArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            uploadArea.classList.remove('border-blue-500', 'bg-blue-100');
            uploadArea.classList.add('border-gray-300');
        });
        
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            uploadArea.classList.remove('border-blue-500', 'bg-blue-100');
            uploadArea.classList.add('border-gray-300');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                const allowedTypes = ['.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png', '.zip', '.rar'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                const maxSize = 10 * 1024 * 1024; // 10MB
                
                if (!allowedTypes.includes(fileExtension)) {
                    alert('Format file tidak didukung. Gunakan: PDF, DOC, DOCX, JPG, PNG, ZIP, RAR');
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    return;
                }
                
                const dt = new DataTransfer();
                dt.items.add(file);
                fileInput.files = dt.files;
                
                handleFileUpload(file);
                checkFormValidity();
            }
        });
    }

    function handleLinkPreview(url) {
        const linkPreviewContent = document.getElementById('link-preview-content');
        if (!linkPreviewContent) return;
        
        if (url) {
            linkPreviewContent.innerHTML = `
                <div class="text-center w-full">
                    <i class="fas fa-external-link-alt text-6xl mb-4 text-purple-500"></i>
                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                        <p class="font-medium text-gray-700 mb-2">Link Destination:</p>
                        <a href="${url}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all text-sm">
                            ${url}
                        </a>
                    </div>
                    <p class="text-sm text-gray-500">Klik link di atas untuk membuka di tab baru</p>
                </div>
            `;
        } else {
            linkPreviewContent.innerHTML = `
                <div class="text-center text-gray-400">
                    <i class="fas fa-external-link-alt text-6xl mb-3"></i>
                    <p>Masukkan URL untuk melihat preview</p>
                    <p class="text-sm">Contoh: https://drive.google.com/...</p>
                </div>
            `;
        }
    }

    // Event listeners
    judulInput.addEventListener('input', checkFormValidity);
    
    tugasSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        evidenceDiv.innerHTML = '';
        
        console.log('Selected value:', selectedValue);

        switch(selectedValue) {
            case '1': // Teks Jawaban with Quill
                console.log('Creating Teks Jawaban option...');
                // createQuillInPreview() will handle placing the textarea inside the form
                createQuillInPreview();
                break;
                
            case '2': // Link Eksternal
                evidenceDiv.innerHTML = `
                    <div class="space-y-4">
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <p class="text-sm text-purple-700 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Masukkan link di bawah ini, preview akan muncul di sebelah kiri
                            </p>
                        </div>
                        <div>
                            <label for="link_eksternal" class="block text-sm font-medium text-gray-700 mb-2">Link Eksternal</label>
                            <input type="url" id="link_eksternal" name="link_eksternal" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="https://example.com/your-answer">
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Contoh: Google Drive, Dropbox, GitHub, atau platform lainnya
                            </p>
                        </div>
                    </div>
                `;
                createLinkPreview();
                
                // Add event listener for link input
                setTimeout(() => {
                    const linkInput = document.getElementById('link_eksternal');
                    if (linkInput) {
                        linkInput.addEventListener('input', function() {
                            handleLinkPreview(this.value);
                            checkFormValidity();
                        });
                    }
                }, 100);
                break;
                
            case '3': // Upload File
                // createFilePreview() will handle placing the file input inside the form
                createFilePreview();
                
                // Add drag and drop functionality
                setTimeout(() => {
                    const uploadPreviewArea = document.getElementById('upload-preview-area');
                    const fileInput = document.getElementById('file_upload');
                    
                    if (uploadPreviewArea && fileInput) {
                        // Click to select file
                        uploadPreviewArea.addEventListener('click', () => {
                            fileInput.click();
                        });
                        
                        // File input change
                        fileInput.addEventListener('change', function() {
                            if (this.files.length > 0) {
                                const file = this.files[0];
                                const maxSize = 10 * 1024 * 1024; // 10MB
                                
                                if (file.size > maxSize) {
                                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                                    this.value = ''; // Clear the input
                                    return;
                                }
                                
                                handleFileUpload(file);
                            }
                            checkFormValidity();
                        });
                        
                        // Add drag and drop listeners
                        addDragDropListeners(uploadPreviewArea, fileInput);
                    }
                }, 100);
                break;
                
            default:
                resetPreviewArea();
                break;
        }
        
        checkFormValidity();
    });

    // Form submission handler
    document.getElementById('form-submit').addEventListener('submit', function(e) {
        console.log('Form submission started...');
        
        // If Quill editor is active, make sure the content is saved
        if (quillEditor && quillReady && tugasSelect.value === '1') {
            const content = quillEditor.root.innerHTML;
            const hiddenTextarea = document.getElementById('teks_jawaban');
            if (hiddenTextarea) {
                hiddenTextarea.value = content;
                console.log('Quill content saved:', content);
            }
        }
        
        // Validation
        if (!judulInput.value.trim()) {
            e.preventDefault();
            alert('Mohon isi judul tugas terlebih dahulu.');
            return false;
        }
        
        if (!tugasSelect.value) {
            e.preventDefault();
            alert('Mohon pilih jenis evidence tugas terlebih dahulu.');
            return false;
        }
        
        // Validate based on evidence type
        if (tugasSelect.value === '1' && quillEditor && quillReady) {
            const content = quillEditor.getText().trim();
            if (!content) {
                e.preventDefault();
                alert('Mohon isi jawaban terlebih dahulu.');
                return false;
            }
        } else if (tugasSelect.value === '2') {
            const linkInput = document.getElementById('link_eksternal');
            if (!linkInput || !linkInput.value.trim()) {
                e.preventDefault();
                alert('Mohon isi link eksternal terlebih dahulu.');
                return false;
            }
        } else if (tugasSelect.value === '3') {
            const fileInput = document.getElementById('file_upload');
            if (!fileInput || fileInput.files.length === 0) {
                e.preventDefault();
                alert('Mohon pilih file untuk diupload terlebih dahulu.');
                return false;
            }
            
            // Validate file size (max 10MB)
            const file = fileInput.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB in bytes
            if (file.size > maxSize) {
                e.preventDefault();
                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                return false;
            }
        }
    });

    // Initial check
    checkFormValidity();
    console.log('Page initialization completed');
});

// Function to view task detail
function viewTaskDetail(taskId) {
    console.log('Fetching task details for ID:', taskId);
    fetch(`/asesi/tugas/${taskId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Task data received:', data);
            if (data.success) {
                const task = data.data;
                let contentHtml = '';
                
                // Create modal content based on evidence type
                if (task.jenis_evidence === 'Teks Jawaban') {
                    console.log('Rendering text answer content');
                    contentHtml = `
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teks Jawaban:</label>
                            <div class="border rounded-lg p-4 bg-gray-50 max-h-60 overflow-y-auto">
                                <div class="whitespace-pre-wrap">${task.teks_jawaban || 'Tidak ada teks jawaban'}</div>
                            </div>
                        </div>
                    `;
                } else if (task.jenis_evidence === 'Link Eksternal') {
                    console.log('Rendering external link content');
                    contentHtml = `
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Eksternal:</label>
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <a href="${task.link_eksternal}" target="_blank" class="text-blue-600 hover:text-blue-800 underline break-all">
                                    ${task.link_eksternal}
                                </a>
                                <div class="mt-2">
                                    <button onclick="window.open('${task.link_eksternal}', '_blank')" 
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100">
                                        <i class="fas fa-external-link-alt mr-1"></i> Buka Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                } else if (task.jenis_evidence === 'Upload File') {
                    console.log('Rendering file upload content, file URL:', task.file_url);
                    const fileName = task.file_name.toLowerCase();
                    const fileExtension = fileName ? fileName.split('.').pop().toLowerCase() : '';
                    console.log('File extension:', fileExtension);
                    
                    let filePreview = '';
                    
                    // Check file type and create appropriate preview
                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                        // Image file
                        filePreview = `
                            <div class="mt-3">
                                <img src="${task.file_url}" alt="${task.file_name}" 
                                     class="max-w-full max-h-96 rounded-lg border shadow-sm cursor-pointer"
                                     onclick="window.open('${task.file_url}', '_blank')"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vdCBmb3VuZDwvdGV4dD48L3N2Zz4=';">
                                <p class="text-xs text-gray-500 mt-1 text-center">Klik untuk memperbesar</p>
                            </div>
                        `;
                    } else if (fileExtension === 'pdf') {
                        // PDF file
                        filePreview = `
                            <div class="mt-3">
                                <div class="border rounded-lg p-4 bg-red-50">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file-pdf text-3xl text-red-600"></i>
                                        <div class="flex-1">
                                            <div class="font-medium text-red-800">PDF Document</div>
                                            <div class="text-sm text-red-600">Klik tombol di bawah untuk melihat PDF</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button onclick="window.open('${task.file_url}', '_blank')" 
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded hover:bg-red-100">
                                            <i class="fas fa-eye mr-2"></i> Lihat PDF
                                        </button>
                                        <button onclick="downloadFile('${task.file_url}', '${task.file_name}')" 
                                                class="ml-2 inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else if (['doc', 'docx'].includes(fileExtension)) {
                        // Word document
                        filePreview = `
                            <div class="mt-3">
                                <div class="border rounded-lg p-4 bg-blue-50">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file-word text-3xl text-blue-600"></i>
                                        <div class="flex-1">
                                            <div class="font-medium text-blue-800">Word Document</div>
                                            <div class="text-sm text-blue-600">Dokumen Microsoft Word</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button onclick="downloadFile('${task.file_url}', '${task.file_name}')" 
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else if (['zip', 'rar'].includes(fileExtension)) {
                        // Archive file
                        filePreview = `
                            <div class="mt-3">
                                <div class="border rounded-lg p-4 bg-purple-50">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file-archive text-3xl text-purple-600"></i>
                                        <div class="flex-1">
                                            <div class="font-medium text-purple-800">Archive File</div>
                                            <div class="text-sm text-purple-600">File terkompresi ${fileExtension.toUpperCase()}</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button onclick="downloadFile('${task.file_url}', '${task.file_name}')" 
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-purple-600 bg-purple-50 border border-purple-200 rounded hover:bg-purple-100">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        // Other file types
                        filePreview = `
                            <div class="mt-3">
                                <div class="border rounded-lg p-4 bg-gray-50">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file text-3xl text-gray-400"></i>
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-800">File Attachment</div>
                                            <div class="text-sm text-gray-600">Format: ${fileExtension.toUpperCase()}</div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button onclick="downloadFile('${task.file_url}', '${task.file_name}')" 
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 rounded hover:bg-gray-100">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    contentHtml = `
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Upload:</label>
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-file text-xl text-gray-400"></i>
                                        <div>
                                            <div class="font-medium text-gray-800">${task.file_name}</div>
                                            <div class="text-sm text-gray-500">${task.file_size || 'Unknown size'}</div>
                                        </div>
                                    </div>
                                </div>
                                ${filePreview}
                            </div>
                        </div>
                    `;
                }

                console.log(task)
                
                // Add status and timestamp info
                contentHtml += `
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status:</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${task?.status?.toLowerCase() === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'}">
                                ${task?.status?.toLowerCase() === 'submitted' ? 'Menunggu Review' : 'Sudah Direview'}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Submit:</label>
                            <div class="text-sm text-gray-900">${task.waktu_submit || '-'}</div>
                        </div>
                    </div>
                `;
                
                // Add notes if reviewed
                if (task.catatan_asesor) {
                    contentHtml += `
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Asesor:</label>
                            <div class="border rounded-lg p-4 bg-yellow-50">
                                <div class="whitespace-pre-wrap">${task.catatan_asesor}</div>
                            </div>
                        </div>
                    `;
                }
                
                console.log('Final content HTML:', contentHtml);
                
                // Show modal
                showModal('Detail Tugas: ' + task.judul_tugas, contentHtml);
            } else {
                console.error('Error from server:', data.error);
                alert('Gagal memuat detail tugas: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail tugas');
        });
}

// Function to delete task
function deleteTask(taskId) {
    if (confirm('Apakah Anda yakin ingin menghapus tugas ini?')) {
        fetch(`/asesi/tugas/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Tugas berhasil dihapus!');
                location.reload(); // Refresh page to update the list
            } else {
                alert('Gagal menghapus tugas: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus tugas');
        });
    }
}

// Function to show modal
function showModal(title, content) {
    // Create modal HTML
    const modalHtml = `
        <div id="taskModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-lg font-bold text-gray-900">${title}</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-2">
                    ${content}
                </div>
                <div class="flex justify-end pt-4">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('taskModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

// Function to close modal
function closeModal() {
    const modal = document.getElementById('taskModal');
    if (modal) {
        modal.remove();
    }
}

// Function to download file
function downloadFile(fileUrl, fileName) {
    const link = document.createElement('a');
    link.href = fileUrl;
    link.download = fileName;
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
