@extends('home.home-visitor.layouts.layout')

@section('title', 'Konfirmasi Data - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="bg-gray-100 min-h-screen py-32 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl mx-auto overflow-hidden">
        <!-- Header Section -->
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Formulir Permohonan Sertifikasi Kompetensi
            </h2>
        </div>

        <!-- Progress Indicator -->
        <div class="px-8 pt-6">
            <!-- Progress bar code here... -->
        </div>

        <!-- Alert Message Container -->
        <div id="message" class="px-8 mt-4">
            @if($asesiPengajuan->status == 'needs_revision')
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium">Pengajuan Anda memerlukan revisi: {{ $asesiPengajuan->revision_notes }}</p>
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="p-8">
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $asesiPengajuan->status === 'needs_revision' ? 'Konfirmasi Revisi Data' : 'Konfirmasi Data Asesi' }}
                    </h3>
                </div>

                <p class="text-sm text-gray-600 mb-6 pl-11">
                    {{ $asesiPengajuan->status === 'needs_revision' ? 'Silakan konfirmasi persetujuan atas revisi data yang telah dilakukan.' : 'Pada bagian ini, silakan konfirmasi persetujuan Anda terhadap data yang telah diisi.' }}
                </p>
            </div>

            <!-- Recommendation Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200 shadow-sm">
                <h4 class="text-lg font-semibold mb-2 text-gray-800">Rekomendasi</h4>
                <p class="text-sm font-medium text-red-500 mb-4">*diisi oleh Admin LSP</p>

                <p class="mb-4 text-gray-700">Berdasarkan Ketentuan Persyaratan dasar pemohon maka pemohon:</p>

                <div class="mb-4">
                    @if($asesiPengajuan->status === 'needs_revision')
                        <div class="px-4 py-3 rounded-md bg-yellow-100 border border-yellow-300 text-yellow-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">PERLU REVISI</span>
                        </div>
                    @elseif($asesiPengajuan->status_rekomendasi === 'Diterima')
                        <div class="px-4 py-3 rounded-md bg-green-100 border border-green-300 text-green-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">DITERIMA</span>
                        </div>
                    @elseif($asesiPengajuan->status === 'revised_by_asesi')
                    <div class="px-4 py-3 rounded-md bg-blue-100 border border-blue-300 text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">MENUNGGU ADMIN ME-REVIEW HASIL REVISI</span>
                        </div>
                    @elseif($asesiPengajuan->status_rekomendasi === 'Ditolak')
                        <div class="px-4 py-3 rounded-md bg-red-100 border border-red-300 text-red-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">DITOLAK</span>
                        </div>
                    @else
                        <div class="px-4 py-3 rounded-md bg-blue-100 border border-blue-300 text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">MENUNGGU</span>
                        </div>
                    @endif
                </div>

                <p class="text-gray-700 mb-4">sebagai peserta sertifikasi</p>

                <div class="mt-4 mb-6">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <div class="p-3 bg-gray-100 rounded-md border border-gray-200 text-sm text-gray-700">
                        @if($asesiPengajuan->status === 'needs_revision')
                            {{ $asesiPengajuan->revision_notes ?? 'Pengajuan perlu direvisi' }}
                        @elseif($asesiPengajuan->status_rekomendasi === 'Diterima')
                            Peserta memenuhi persyaratan silakan lanjut Assesmen Mandiri
                        @elseif($asesiPengajuan->status === 'revised_by_asesi')
                            Menunggu review data hasil revisi asesi dari admin LSP
                        @elseif($asesiPengajuan->status_rekomendasi === 'Ditolak')
                            {{ $asesiPengajuan->alasan_penolakan ?? 'Peserta tidak memenuhi persyaratan' }}
                        @else
                            Menunggu review dari admin LSP
                        @endif
                    </div>
                </div>

                @if($asesiPengajuan->status === 'needs_revision')
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <span class="font-medium">Penting:</span> Setelah melakukan revisi data, klik tombol "Kirim Revisi" untuk menyimpan perubahan. Pastikan semua data sudah benar sebelum mengirim.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Signatures Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border-r-0 md:border-r border-gray-200 pr-0 md:pr-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Pemohon **)</h4>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-700">Nama: <span class="font-medium">{{ $asesiPengajuan->nama_user }}</span></p>

                            <div class="flex items-center mt-3">
                                <label for="approve-pemohon" class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <span class="ml-2 text-sm text-gray-700">Dengan ini saya menyetujui permohonan</span>
                                </label>
                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-700 mb-1">TTD:</p>
                                <div class="border border-gray-200 rounded-md p-2 bg-gray-50 h-16 flex items-center justify-center">
                                    @if(isset($asesiPengajuan->ttd_pemohon))
                                        <img src="{{ asset("/storage/".$asesiPengajuan->ttd_pemohon) }}" alt="Tanda Tangan Pemohon" class="max-h-12">
                                    @else
                                        <p class="text-sm text-gray-400 italic">Tanda tangan akan muncul setelah disetujui</p>
                                    @endif
                                </div>
                            </div>

                            <p class="text-sm text-gray-700 mt-2">Tgl: {{ date('d-m-Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Admin LSP ***)</h4>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-700">Nama: <span class="font-medium">
                                @if($asesiPengajuan->id_admin)
                                    {{ $asesiPengajuan->admin->nama ?? 'Muhammad Abdul Karim' }}
                                @else
                                    Belum ditugaskan
                                @endif
                            </span></p>

                            <div class="flex items-center mt-3">
                                <div class="flex items-center">
                                    <input type="checkbox" id="approve-admin" class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 transition duration-150 ease-in-out"
                                        {{ $asesiPengajuan->status_rekomendasi !== 'N/A' ? 'checked' : '' }} disabled>
                                    <span class="ml-2 text-sm text-gray-700">TTD Admin</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-700 mb-1">TTD:</p>
                                <div class="border border-gray-200 rounded-md p-2 bg-gray-50 h-16 flex items-center justify-center">
                                    @if($asesiPengajuan->status_rekomendasi !== 'N/A')
                                        <img src="{{ asset('images/admin-signature.jpg') }}" alt="Admin Signature" class="max-h-12">
                                    @else
                                        <p class="text-sm text-gray-400 italic">Admin belum menandatangani</p>
                                    @endif
                                </div>
                            </div>

                            <p class="text-sm text-gray-700 mt-2">Tgl:
                                @if($asesiPengajuan->status_rekomendasi !== 'N/A')
                                    {{ date('d-m-Y', strtotime($asesiPengajuan->updated_at)) }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan Informasi -->
            @if($asesiPengajuan->status === 'rejected')
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Catatan:</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                        <li class="font-medium text-red-700">Pengajuan Anda telah ditolak. Jangan khawatir, Anda masih bisa mengajukan kembali</li>
                                        <li class="font-medium text-red-700">Klik tombol "Ulangi Proses Pengajuan" di bawah untuk memulai pengajuan baru</li>
                                        <li class="font-medium text-red-700">Harap perhatikan alasan penolakan untuk perbaikan pengajuan berikutnya</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Catatan:</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc pl-5 space-y-1">
                                        <li>Centang kotak persetujuan untuk melanjutkan proses pengajuan</li>
                                        <li>Status rekomendasi akan diisi oleh Admin LSP</li>
                                        <li>Setelah dikonfirmasi, data tidak dapat diubah</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form pengajuan final -->
        <form id="konfirmasi-form" action="{{ route('user.apl1.submit') }}" method="POST">
            @csrf
            <!-- Form tidak memerlukan input fields, cukup token CSRF -->
        </form>

        <!-- Footer Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between">
            <a href="{{ route('user.apl1.bukti') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            @if($asesiPengajuan->status === 'rejected')
                <form action="{{ route('user.apl1.restart') }}" method="POST" class="ml-auto mr-2">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-md border border-transparent text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Ulangi Proses Pengajuan
                    </button>
                </form>
            @endif

            <button type="button" id="btn-konfirmasi"
                class="px-4 py-2 rounded-md border border-transparent text-white
                    {{ $asesiPengajuan->status === 'submitted' || $asesiPengajuan->status === 'approved' || $asesiPengajuan->status === 'revised_by_asesi' || $asesiPengajuan->status === 'rejected' ?
                        'bg-gray-400 cursor-not-allowed' :
                        ($asesiPengajuan->status === 'needs_revision' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700') }}
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors flex items-center"
                {{ $asesiPengajuan->status === 'submitted' || $asesiPengajuan->status === 'approved' || $asesiPengajuan->status === 'rejected' ? 'disabled' : '' }}>
                <span id="button-text">
                    {{ $asesiPengajuan->status === 'needs_revision' ? 'Kirim Revisi' : 'Konfirmasi & Kirim' }}
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('approve-pemohon');
        const button = document.getElementById('btn-konfirmasi');
        const konfirmasiForm = document.getElementById('konfirmasi-form');

        // Only enable if not already submitted/approved/rejected
        if (!button.disabled) {
            button.addEventListener('click', function (e) {
                if (!checkbox.checked) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Persetujuan Diperlukan',
                        text: 'Anda harus menyetujui permohonan dengan mencentang kotak persetujuan terlebih dahulu.',
                        confirmButtonColor: '#3B82F6'
                    });
                } else {
                    Swal.fire({
                        title: 'Konfirmasi Pengajuan',
                        text: 'Dengan ini Anda menyetujui semua data yang telah diisi. Data tidak dapat diubah setelah dikonfirmasi. Lanjutkan?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10B981',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Ya, Konfirmasi',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit form
                            konfirmasiForm.submit();
                        }
                    });
                }
            });
        }

        // Toggle checkbox style when checked
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                this.classList.add('bg-blue-500');
            } else {
                this.classList.remove('bg-blue-500');
            }
        });
    });
</script>
@endsection
