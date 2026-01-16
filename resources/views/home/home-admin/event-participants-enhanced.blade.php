@extends('home.home-admin.layouts.layout')

@section('title', 'Manajemen Peserta Event - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-blue {
        background-color: rgba(59, 130, 246, 0.1);
        color: rgba(29, 78, 216, 1);
    }
    
    .badge-green {
        background-color: rgba(16, 185, 129, 0.1);
        color: rgba(6, 95, 70, 1);
    }
    
    .badge-yellow {
        background-color: rgba(245, 158, 11, 0.1);
        color: rgba(180, 83, 9, 1);
    }
    
    .badge-gray {
        background-color: rgba(107, 114, 128, 0.1);
        color: rgba(55, 65, 81, 1);
    }
    
    .badge-red {
        background-color: rgba(239, 68, 68, 0.1);
        color: rgba(153, 27, 27, 1);
    }
    
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .spinner {
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3B82F6;
        border-radius: 50%;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Alert Container -->
        <div id="alert-container"></div>

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Manajemen Peserta: {{ $event->nama_event ?? 'Event '.$event->id_event }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            {{ $event->tanggal_mulai_event->format('d M Y') }} - {{ $event->tanggal_berakhir_event->format('d M Y') }}
                        </div>
                        
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $event->tuk->nama_tuk ?? 'TUK Belum Ditentukan' }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex md:mt-0">
                    <a href="{{ route('admin.event.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Add Participant Forms -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Single Participant Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Peserta Tunggal</h3>
                <form id="single-participant-form">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Peserta</label>
                            <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="contoh@ugm.ac.id" required>
                        </div>
                        <div>
                            <label for="id_skema" class="block text-sm font-medium text-gray-700 mb-1">Skema Sertifikasi</label>
                            <select name="id_skema" id="id_skema" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih Skema</option>
                                @foreach($skemas as $skema)
                                    <option value="{{ $skema->id_skema }}">{{ $skema->nama_skema }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="single-submit-btn" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span id="single-btn-text">Tambah Peserta</span>
                            <div class="spinner ml-2 hidden" id="single-spinner"></div>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bulk Participant Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Peserta Massal</h3>
                <form id="bulk-participant-form">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="bulk_emails" class="block text-sm font-medium text-gray-700 mb-1">Email Peserta (pisahkan dengan koma atau spasi)</label>
                            <textarea name="emails" id="bulk_emails" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="email1@ugm.ac.id, email2@ugm.ac.id" required></textarea>
                            <p class="mt-1 text-xs text-gray-500">Contoh: email1@ugm.ac.id, email2@ugm.ac.id atau satu email per baris</p>
                        </div>
                        <div>
                            <label for="bulk_id_skema" class="block text-sm font-medium text-gray-700 mb-1">Skema Sertifikasi</label>
                            <select name="id_skema" id="bulk_id_skema" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih Skema</option>
                                @foreach($skemas as $skema)
                                    <option value="{{ $skema->id_skema }}">{{ $skema->nama_skema }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="bulk-submit-btn" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span id="bulk-btn-text">Tambah Peserta Massal</span>
                            <div class="spinner ml-2 hidden" id="bulk-spinner"></div>
                        </button>
                    </div>
                </form>
                
                <!-- Progress Indicator for Bulk -->
                <div id="bulk-progress" class="mt-4 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-blue-900">Mengirim undangan...</span>
                            <span class="text-sm font-medium text-blue-900" id="progress-text">0/0</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-2">
                            <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Participants List -->
        <div id="participants-list">
            @include('home.home-admin.partials.participants-list')
        </div>
    </div>
</div>

<!-- Edit Participant Modal -->
<div id="editParticipantModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Edit Peserta</h3>
                    <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="editParticipantForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div>
                            <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="edit_email" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" readonly>
                            <p class="mt-1 text-xs text-gray-500">Email tidak dapat diubah</p>
                        </div>
                        <div>
                            <label for="edit_id_skema" class="block text-sm font-medium text-gray-700">Skema Sertifikasi</label>
                            <select name="id_skema" id="edit_id_skema" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                @foreach($skemas as $skema)
                                    <option value="{{ $skema->id_skema }}">{{ $skema->nama_skema }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
const eventId = '{{ $event->id_event }}';
const csrfToken = '{{ csrf_token() }}';
let statusCheckInterval = null;
let pendingParticipants = [];

// Alert functions
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const alertClass = type === 'success' ? 'green' : 'red';
    const iconPath = type === 'success' 
        ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'
        : 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z';
    
    const alert = document.createElement('div');
    alert.className = `mb-8 bg-${alertClass}-100 border-l-4 border-${alertClass}-500 text-${alertClass}-700 p-4 rounded shadow-md animate-fade-in`;
    alert.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-${alertClass}-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="${iconPath}" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm">${message}</p>
            </div>
            <div class="ml-auto pl-3">
                <button type="button" class="inline-flex rounded-md p-1.5 text-${alertClass}-500 hover:bg-${alertClass}-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    alertContainer.appendChild(alert);
    
    setTimeout(() => alert.remove(), 5000);
}

// Single participant form
document.getElementById('single-participant-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('single-submit-btn');
    const btnText = document.getElementById('single-btn-text');
    const spinner = document.getElementById('single-spinner');
    
    btn.disabled = true;
    btnText.textContent = 'Mengirim...';
    spinner.classList.remove('hidden');
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(`/admin/events/${eventId}/participants`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert(data.message, 'success');
            this.reset();
            
            // Add to pending list for status checking
            if (data.participant) {
                pendingParticipants.push(data.participant.id);
                startStatusChecking();
            }
            
            // Reload participants list after a short delay
            setTimeout(() => location.reload(), 2000);
        } else {
            showAlert(data.message || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        showAlert('Terjadi kesalahan: ' + error.message, 'error');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Tambah Peserta';
        spinner.classList.add('hidden');
    }
});

// Bulk participant form
document.getElementById('bulk-participant-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('bulk-submit-btn');
    const btnText = document.getElementById('bulk-btn-text');
    const spinner = document.getElementById('bulk-spinner');
    const progressDiv = document.getElementById('bulk-progress');
    
    btn.disabled = true;
    btnText.textContent = 'Memproses...';
    spinner.classList.remove('hidden');
    progressDiv.classList.remove('hidden');
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(`/admin/events/${eventId}/participants/bulk`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showAlert(data.message, 'success');
            this.reset();
            
            // Add to pending list for status checking
            if (data.participants) {
                data.participants.forEach(p => pendingParticipants.push(p.id));
                startStatusChecking();
                updateBulkProgress(0, data.count);
            }
            
            // Reload participants list after a short delay
            setTimeout(() => location.reload(), 3000);
        } else {
            showAlert(data.message || 'Terjadi kesalahan', 'error');
            progressDiv.classList.add('hidden');
        }
    } catch (error) {
        showAlert('Terjadi kesalahan: ' + error.message, 'error');
        progressDiv.classList.add('hidden');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Tambah Peserta Massal';
        spinner.classList.add('hidden');
    }
});

function updateBulkProgress(sent, total) {
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const percentage = (sent / total) * 100;
    
    progressBar.style.width = percentage + '%';
    progressText.textContent = `${sent}/${total}`;
}

// Status checking
function startStatusChecking() {
    if (statusCheckInterval) return;
    
    statusCheckInterval = setInterval(async () => {
        if (pendingParticipants.length === 0) {
            stopStatusChecking();
            return;
        }
        
        try {
            const response = await fetch(`/admin/events/${eventId}/participants/check-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    participant_ids: pendingParticipants
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Remove participants that are no longer pending
                pendingParticipants = pendingParticipants.filter(id => {
                    const participant = data.participants.find(p => p.id === id);
                    return participant && participant.invitation_status === 'pending';
                });
                
                // Update UI if needed
                if (pendingParticipants.length === 0) {
                    location.reload();
                }
            }
        } catch (error) {
            console.error('Status check failed:', error);
        }
    }, 3000); // Check every 3 seconds
}

function stopStatusChecking() {
    if (statusCheckInterval) {
        clearInterval(statusCheckInterval);
        statusCheckInterval = null;
    }
}

// Clean up on page unload
window.addEventListener('beforeunload', stopStatusChecking);

// Edit modal functions
function openEditModal(participantId, email, skemaId) {
    const modal = document.getElementById('editParticipantModal');
    const form = document.getElementById('editParticipantForm');
    const emailInput = document.getElementById('edit_email');
    const skemaSelect = document.getElementById('edit_id_skema');
    
    form.action = `/admin/events/${eventId}/participants/${participantId}`;
    emailInput.value = email;
    skemaSelect.value = skemaId;
    
    modal.classList.remove('hidden');
}

function closeEditModal() {
    const modal = document.getElementById('editParticipantModal');
    modal.classList.add('hidden');
}

// Delete confirmation function
function confirmDelete(participantId, email) {
    if (confirm(`Apakah Anda yakin ingin menghapus peserta dengan email ${email}? Akses mereka akan dicabut segera.`)) {
        document.getElementById(`delete-form-${participantId}`).submit();
    }
}
</script>
@endsection
@endsection
