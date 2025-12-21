@extends('home.home-admin.layouts.layout')

@section('title', 'Konfigurasi Perangkat Asesmen - ' . $skema->nama_skema)

@section('styles')
<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s;
        border-radius: 24px;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    
    input:checked + .toggle-slider {
        background-color: #3b82f6;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }
    
    input:disabled + .toggle-slider {
        background-color: #22c55e;
        cursor: not-allowed;
    }
    
    input:disabled + .toggle-slider:before {
        background-color: #f0fdf4;
    }
    
    .assessment-card {
        transition: all 0.2s ease-in-out;
    }
    
    .assessment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .mandatory-badge {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }
    
    .category-header {
        position: relative;
        padding-left: 12px;
    }
    
    .category-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        border-radius: 2px;
    }
    
    .category-apl::before { background-color: #22c55e; }
    .category-ak::before { background-color: #3b82f6; }
    .category-ia::before { background-color: #8b5cf6; }
    .category-mapa::before { background-color: #f59e0b; }
    .category-other::before { background-color: #6b7280; }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home-admin') }}" class="text-gray-700 hover:text-blue-600 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('admin.skema.index') }}" class="ml-1 text-gray-700 hover:text-blue-600 md:ml-2">Skema Sertifikasi</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Konfigurasi Perangkat Asesmen</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Alert Messages Container -->
        <div id="alert-container" class="mb-6"></div>

        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 py-6 px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Konfigurasi Perangkat Asesmen</h1>
                        <p class="text-blue-100 mt-1">{{ $skema->nomor_skema }} - {{ $skema->nama_skema }}</p>
                    </div>
                    <a href="{{ route('admin.skema.index') }}" class="flex items-center text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                        <svg class="w-5 h-5 mr-1 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Catatan:</strong> Perangkat APL (APL01 & APL02) bersifat <strong>wajib</strong> untuk semua skema dan tidak dapat dinonaktifkan.
                        Perangkat lainnya dapat diaktifkan atau dinonaktifkan sesuai kebutuhan skema.
                    </p>
                </div>
            </div>
        </div>

        <!-- Assessment Configuration Form -->
        <form id="assessment-config-form">
            @csrf

            <!-- APL Section - Mandatory -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="category-header category-apl text-lg font-semibold text-gray-800 mb-4">
                    APL - Aplikasi Permohonan Lisensi
                    <span class="mandatory-badge ml-2 text-xs text-white px-2 py-1 rounded-full">Wajib</span>
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assessmentConfig as $config)
                        @if(in_array($config['assessment_type'], ['APL01', 'APL02']))
                            <div class="assessment-card bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $config['assessment_type'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $assessmentLabels[$config['assessment_type']] ?? $config['assessment_type'] }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs text-green-600 font-medium mr-3">Selalu Aktif</span>
                                        <label class="toggle-switch">
                                            <input type="checkbox" 
                                                   name="config[{{ $config['assessment_type'] }}]" 
                                                   value="1"
                                                   checked 
                                                   disabled>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- AK Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="category-header category-ak text-lg font-semibold text-gray-800 mb-4">
                    AK - Asesmen Kompetensi
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assessmentConfig as $config)
                        @if(in_array($config['assessment_type'], ['AK01', 'AK02', 'AK04', 'AK07']))
                            <div class="assessment-card bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $config['assessment_type'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $assessmentLabels[$config['assessment_type']] ?? $config['assessment_type'] }}</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" 
                                               name="config[{{ $config['assessment_type'] }}]" 
                                               value="1"
                                               {{ $config['is_enabled'] ? 'checked' : '' }}
                                               data-type="{{ $config['assessment_type'] }}">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- IA Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="category-header category-ia text-lg font-semibold text-gray-800 mb-4">
                    IA - Instrumen Asesmen
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assessmentConfig as $config)
                        @if(in_array($config['assessment_type'], ['IA01', 'IA02', 'IA05', 'IA07', 'IA11']))
                            <div class="assessment-card bg-white border border-gray-200 rounded-lg p-4 hover:border-purple-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $config['assessment_type'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $assessmentLabels[$config['assessment_type']] ?? $config['assessment_type'] }}</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" 
                                               name="config[{{ $config['assessment_type'] }}]" 
                                               value="1"
                                               {{ $config['is_enabled'] ? 'checked' : '' }}
                                               data-type="{{ $config['assessment_type'] }}">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- MAPA Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="category-header category-mapa text-lg font-semibold text-gray-800 mb-4">
                    MAPA - Materi Perencanaan Asesmen
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assessmentConfig as $config)
                        @if(in_array($config['assessment_type'], ['MAPA01', 'MAPA02']))
                            <div class="assessment-card bg-white border border-gray-200 rounded-lg p-4 hover:border-amber-300">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $config['assessment_type'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $assessmentLabels[$config['assessment_type']] ?? $config['assessment_type'] }}</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" 
                                               name="config[{{ $config['assessment_type'] }}]" 
                                               value="1"
                                               {{ $config['is_enabled'] ? 'checked' : '' }}
                                               data-type="{{ $config['assessment_type'] }}">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Other Tools Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="category-header category-other text-lg font-semibold text-gray-800 mb-4">
                    Perangkat Lainnya
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($assessmentConfig as $config)
                        @if(in_array($config['assessment_type'], ['KONSUL_PRA_UJI', 'KETIDAKBERPIHAKAN', 'TUGAS_PESERTA']))
                            <div class="assessment-card bg-white border border-gray-200 rounded-lg p-4 hover:border-gray-400">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $config['assessment_type'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $assessmentLabels[$config['assessment_type']] ?? $config['assessment_type'] }}</p>
                                    </div>
                                    <label class="toggle-switch">
                                        <input type="checkbox" 
                                               name="config[{{ $config['assessment_type'] }}]" 
                                               value="1"
                                               {{ $config['is_enabled'] ? 'checked' : '' }}
                                               data-type="{{ $config['assessment_type'] }}">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.skema.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit" id="save-btn" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span id="save-btn-text">Simpan Konfigurasi</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('assessment-config-form');
    const saveBtn = document.getElementById('save-btn');
    const saveBtnText = document.getElementById('save-btn-text');
    const alertContainer = document.getElementById('alert-container');
    const skemaId = '{{ $skema->id_skema }}';

    // IA02 and TUGAS_PESERTA are bundled together
    const ia02Checkbox = document.querySelector('input[data-type="IA02"]');
    const tugasPesertaCheckbox = document.querySelector('input[data-type="TUGAS_PESERTA"]');

    // Sync IA02 and TUGAS_PESERTA checkboxes
    function syncBundledCheckboxes(source, target) {
        if (source && target) {
            source.addEventListener('change', function() {
                target.checked = this.checked;
            });
        }
    }

    // Setup bidirectional sync for IA02 and TUGAS_PESERTA
    syncBundledCheckboxes(ia02Checkbox, tugasPesertaCheckbox);
    syncBundledCheckboxes(tugasPesertaCheckbox, ia02Checkbox);

    // Function to show alert
    function showAlert(type, message) {
        const alertClass = type === 'success' 
            ? 'bg-green-100 border-green-500 text-green-700' 
            : 'bg-red-100 border-red-500 text-red-700';
        const iconPath = type === 'success'
            ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'
            : 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z';
        
        alertContainer.innerHTML = `
            <div class="${alertClass} border-l-4 p-4 rounded shadow-md" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="${iconPath}" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button type="button" class="inline-flex rounded-md p-1.5 hover:bg-opacity-20 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Auto-hide after 5 seconds
        setTimeout(() => {
            const alert = alertContainer.querySelector('[role="alert"]');
            if (alert) {
                alert.style.transition = 'opacity 0.3s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    }

    // Function to set loading state
    function setLoading(loading) {
        saveBtn.disabled = loading;
        if (loading) {
            saveBtnText.textContent = 'Menyimpan...';
            saveBtn.classList.add('opacity-75', 'cursor-not-allowed');
        } else {
            saveBtnText.textContent = 'Simpan Konfigurasi';
            saveBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    }

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Build config object from checkboxes
        const config = {};
        const checkboxes = form.querySelectorAll('input[type="checkbox"][data-type]');
        
        checkboxes.forEach(checkbox => {
            const type = checkbox.dataset.type;
            config[type] = checkbox.checked;
        });

        // Always include APL types as enabled
        config['APL01'] = true;
        config['APL02'] = true;

        setLoading(true);

        // Send AJAX request
        fetch(`/admin/skema/${skemaId}/assessment-config`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ config: config })
        })
        .then(response => response.json())
        .then(data => {
            setLoading(false);
            
            if (data.success) {
                showAlert('success', data.message || 'Konfigurasi berhasil disimpan!');
            } else {
                showAlert('error', data.message || 'Gagal menyimpan konfigurasi.');
            }
        })
        .catch(error => {
            setLoading(false);
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat menyimpan konfigurasi.');
        });
    });
});
</script>
@endsection
