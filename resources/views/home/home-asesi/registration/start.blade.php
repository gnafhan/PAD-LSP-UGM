@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Pendaftaran Asesi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Welcome Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-16 h-16 mr-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $user->name ?: 'Peserta' }}!</h1>
                    <p class="text-gray-600">Anda telah diundang untuk mengikuti sertifikasi kompetensi</p>
                </div>
            </div>
        </div>

        <!-- Event and Skema Information (Read-only) -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Informasi Event dan Skema</h2>
            
            <!-- Event Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Event Sertifikasi</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Event</label>
                            <p class="text-gray-800 font-semibold">{{ $event->nama_event }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pelaksanaan</label>
                            <p class="text-gray-800 font-semibold">{{ $event->rentang_waktu }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Uji Kompetensi (TUK)</label>
                            <p class="text-gray-800 font-semibold">{{ $event->tuk->nama_tuk ?? 'Belum ditentukan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tahun Pelaksanaan</label>
                            <p class="text-gray-800 font-semibold">{{ $event->tahun_pelaksanaan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skema Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Skema Sertifikasi</h3>
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Skema</label>
                            <p class="text-gray-800 font-semibold">{{ $skema->nama_skema }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Skema</label>
                            <p class="text-gray-800 font-semibold">{{ $skema->nomor_skema }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Skema</label>
                            <p class="text-gray-800 font-semibold">{{ $skema->jenis_skema }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-yellow-800">Informasi Penting</p>
                        <p class="text-sm text-yellow-700 mt-1">Event dan skema telah ditentukan oleh administrator dan tidak dapat diubah. Pastikan informasi di atas sudah sesuai sebelum melanjutkan pendaftaran.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Form Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pribadi</h2>
            
            <form action="{{ route('asesi.registration.complete') }}" method="POST">
                @csrf
                
                <!-- Pre-populated User Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" 
                               value="{{ $user->name ?: $user->email }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-medium" 
                               readonly>
                        <p class="text-xs text-gray-500 mt-1">Dari akun Google Anda</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" 
                               value="{{ $user->email }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-800 font-medium" 
                               readonly>
                        <p class="text-xs text-gray-500 mt-1">Dari akun Google Anda</p>
                    </div>
                </div>

                <!-- Information Notice -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Langkah Selanjutnya</p>
                            <p class="text-sm text-blue-700 mt-1">
                                Setelah mengklik tombol "Lanjutkan ke Proses Asesmen", Anda akan diarahkan ke dashboard asesi untuk melengkapi dokumen-dokumen berikut:
                            </p>
                            <ul class="list-disc list-inside text-sm text-blue-700 mt-2 ml-4 space-y-1">
                                <li>Upload tanda tangan digital (APL-01)</li>
                                <li>Formulir Persetujuan Asesmen & Kerahasiaan</li>
                                <li>Asesmen Mandiri (APL-02)</li>
                                <li>Dokumen pendukung lainnya</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('login') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                        Lanjutkan ke Proses Asesmen
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Butuh Bantuan?</h3>
            <p class="text-gray-600 text-sm">
                Jika Anda mengalami kesulitan atau memiliki pertanyaan mengenai proses pendaftaran, 
                silakan hubungi administrator LSP UGM melalui email atau telepon yang tertera di website resmi.
            </p>
        </div>
    </div>
</div>

<!-- Load SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for session messages and display SweetAlert notifications
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#2563EB',
            timer: 4000,
            timerProgressBar: true
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#2563EB',
            timer: 4000,
            timerProgressBar: true
        });
    @endif
});
</script>
@endsection
