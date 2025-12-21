@extends('home.home-admin.layouts.layout')

@section('title', 'Manajemen Penugasan Asesor - Skema')

@section('styles')
<style>
    .assignment-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        margin: 0.125rem;
    }
    .assignment-badge-blue {
        background-color: #dbeafe;
        color: #1e40af;
    }
    .assignment-badge-remove {
        margin-left: 0.5rem;
        cursor: pointer;
        color: #6b7280;
        transition: color 0.2s;
    }
    .assignment-badge-remove:hover {
        color: #dc2626;
    }
    .asesor-card {
        transition: all 0.2s ease-in-out;
    }
    .asesor-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 font-medium">Penugasan Asesor - Skema</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Alert Messages Container -->
        <div id="alert-container" class="mb-6"></div>

        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 py-6 px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Manajemen Penugasan Asesor - Skema</h1>
                        <p class="text-indigo-100 mt-1">Kelola penugasan skema sertifikasi untuk setiap asesor</p>
                    </div>
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
                        <strong>Catatan:</strong> Asesor hanya dapat mengakses dan mengelola skema yang ditugaskan kepada mereka. 
                        Klik tombol <strong>"Tambah Skema"</strong> untuk menugaskan skema baru ke asesor.
                    </p>
                </div>
            </div>
        </div>

        <!-- Asesor List -->
        <div class="space-y-4">
            @forelse($asesors as $asesor)
                <div class="asesor-card bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <!-- Asesor Info -->
                        <div class="flex items-center mb-4 lg:mb-0">
                            <div class="flex-shrink-0 h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $asesor->nama_asesor }}</h3>
                                <p class="text-sm text-gray-500">{{ $asesor->kode_registrasi ?? 'N/A' }} • {{ $asesor->email ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Add Scheme Button -->
                        <button type="button" 
                                onclick="openAssignModal('{{ $asesor->id_asesor }}', '{{ $asesor->nama_asesor }}')"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Skema
                        </button>
                    </div>

                    <!-- Assigned Schemes -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm font-medium text-gray-700 mb-2">Skema yang Ditugaskan:</p>
                        <div class="flex flex-wrap gap-2" id="assignments-{{ $asesor->id_asesor }}">
                            @forelse($asesor->skemaAssignments as $assignment)
                                <span class="assignment-badge assignment-badge-blue" data-assignment-id="{{ $assignment->id }}" data-skema-id="{{ $assignment->id_skema }}">
                                    {{ $assignment->skema->nama_skema ?? 'Unknown' }}
                                    <span class="assignment-badge-remove" onclick="confirmRevoke('{{ $asesor->id_asesor }}', '{{ $assignment->id_skema }}', '{{ $assignment->skema->nama_skema ?? 'Unknown' }}', '{{ $asesor->nama_asesor }}')" title="Hapus penugasan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                </span>
                            @empty
                                <span class="text-sm text-gray-500 italic" id="no-assignments-{{ $asesor->id_asesor }}">Belum ada skema yang ditugaskan</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada asesor</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada data asesor yang terdaftar dalam sistem.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>


<!-- Assign Scheme Modal -->
<div id="assign-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeAssignModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Tambah Penugasan Skema
                        </h3>
                        <p class="text-sm text-gray-500 mt-1" id="modal-asesor-name"></p>
                        <div class="mt-4">
                            <label for="skema-select" class="block text-sm font-medium text-gray-700">Pilih Skema</label>
                            <select id="skema-select" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md border">
                                <option value="">-- Pilih Skema --</option>
                                @foreach($allSkemas as $skema)
                                    <option value="{{ $skema->id_skema }}">{{ $skema->nama_skema }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="assign-btn" onclick="assignScheme()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Tugaskan
                </button>
                <button type="button" onclick="closeAssignModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Revoke Confirmation Modal -->
<div id="revoke-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="revoke-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeRevokeModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="revoke-modal-title">
                            Hapus Penugasan Skema
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="revoke-modal-message">
                                Apakah Anda yakin ingin menghapus penugasan ini?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="revoke-btn" onclick="revokeScheme()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Hapus
                </button>
                <button type="button" onclick="closeRevokeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Store all skemas for filtering
    window.allSkemas = @json($allSkemas);
});

// Current modal state
let currentAsesorId = null;
let currentAsesorName = null;
let revokeAsesorId = null;
let revokeSkemaId = null;

// Alert function
function showAlert(type, message) {
    const alertContainer = document.getElementById('alert-container');
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

    setTimeout(() => {
        const alert = alertContainer.querySelector('[role="alert"]');
        if (alert) {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
}


// Open assign modal
function openAssignModal(asesorId, asesorName) {
    currentAsesorId = asesorId;
    currentAsesorName = asesorName;
    
    document.getElementById('modal-asesor-name').textContent = 'Asesor: ' + asesorName;
    document.getElementById('skema-select').value = '';
    
    // Filter out already assigned schemes
    const assignmentsContainer = document.getElementById('assignments-' + asesorId);
    const assignedSkemaIds = Array.from(assignmentsContainer.querySelectorAll('[data-skema-id]'))
        .map(el => el.dataset.skemaId);
    
    const select = document.getElementById('skema-select');
    select.innerHTML = '<option value="">-- Pilih Skema --</option>';
    
    window.allSkemas.forEach(skema => {
        if (!assignedSkemaIds.includes(skema.id_skema)) {
            const option = document.createElement('option');
            option.value = skema.id_skema;
            option.textContent = skema.nama_skema;
            select.appendChild(option);
        }
    });
    
    document.getElementById('assign-modal').classList.remove('hidden');
}

// Close assign modal
function closeAssignModal() {
    document.getElementById('assign-modal').classList.add('hidden');
    currentAsesorId = null;
    currentAsesorName = null;
}

// Assign scheme to asesor
function assignScheme() {
    const skemaId = document.getElementById('skema-select').value;
    
    if (!skemaId) {
        showAlert('error', 'Silakan pilih skema terlebih dahulu.');
        return;
    }
    
    const btn = document.getElementById('assign-btn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';
    
    fetch(`/admin/asesor/${currentAsesorId}/assign-skema`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_skema: skemaId })
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = 'Tugaskan';
        
        if (data.success) {
            // Add the new badge to the assignments container
            const container = document.getElementById('assignments-' + currentAsesorId);
            const noAssignments = document.getElementById('no-assignments-' + currentAsesorId);
            if (noAssignments) {
                noAssignments.remove();
            }
            
            const skemaName = data.data.nama_skema;
            const badge = document.createElement('span');
            badge.className = 'assignment-badge assignment-badge-blue';
            badge.dataset.skemaId = skemaId;
            badge.innerHTML = `
                ${skemaName}
                <span class="assignment-badge-remove" onclick="confirmRevoke('${currentAsesorId}', '${skemaId}', '${skemaName}', '${currentAsesorName}')" title="Hapus penugasan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </span>
            `;
            container.appendChild(badge);
            
            closeAssignModal();
            showAlert('success', data.message || 'Skema berhasil ditugaskan.');
        } else {
            showAlert('error', data.message || 'Gagal menugaskan skema.');
        }
    })
    .catch(error => {
        btn.disabled = false;
        btn.textContent = 'Tugaskan';
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menugaskan skema.');
    });
}


// Confirm revoke
function confirmRevoke(asesorId, skemaId, skemaName, asesorName) {
    revokeAsesorId = asesorId;
    revokeSkemaId = skemaId;
    
    document.getElementById('revoke-modal-message').textContent = 
        `Apakah Anda yakin ingin menghapus penugasan skema "${skemaName}" dari asesor "${asesorName}"? Asesor tidak akan dapat mengakses skema ini setelah penugasan dihapus.`;
    
    document.getElementById('revoke-modal').classList.remove('hidden');
}

// Close revoke modal
function closeRevokeModal() {
    document.getElementById('revoke-modal').classList.add('hidden');
    revokeAsesorId = null;
    revokeSkemaId = null;
}

// Revoke scheme from asesor
function revokeScheme() {
    const btn = document.getElementById('revoke-btn');
    btn.disabled = true;
    btn.textContent = 'Memproses...';
    
    fetch(`/admin/asesor/${revokeAsesorId}/revoke-skema/${revokeSkemaId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        btn.disabled = false;
        btn.textContent = 'Hapus';
        
        if (data.success) {
            // Remove the badge from the assignments container
            const container = document.getElementById('assignments-' + revokeAsesorId);
            const badge = container.querySelector(`[data-skema-id="${revokeSkemaId}"]`);
            if (badge) {
                badge.remove();
            }
            
            // Check if there are no more assignments
            if (container.querySelectorAll('[data-skema-id]').length === 0) {
                const noAssignments = document.createElement('span');
                noAssignments.className = 'text-sm text-gray-500 italic';
                noAssignments.id = 'no-assignments-' + revokeAsesorId;
                noAssignments.textContent = 'Belum ada skema yang ditugaskan';
                container.appendChild(noAssignments);
            }
            
            closeRevokeModal();
            showAlert('success', data.message || 'Penugasan skema berhasil dihapus.');
        } else {
            showAlert('error', data.message || 'Gagal menghapus penugasan skema.');
        }
    })
    .catch(error => {
        btn.disabled = false;
        btn.textContent = 'Hapus';
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menghapus penugasan skema.');
    });
}
</script>
@endsection
