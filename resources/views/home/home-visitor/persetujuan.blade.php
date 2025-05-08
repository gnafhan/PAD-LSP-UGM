@extends('home.home-visitor.layouts.layout')

@section('title', 'Persetujuan Proses Assessment - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl max-w-3xl mx-auto overflow-hidden">
        <!-- Header Section -->
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Persetujuan Proses Assessment
            </h2>
        </div>

        <!-- Error Message Container -->
        <div id="message" class="px-6 pt-4"></div>

        <!-- Main Content -->
        <div class="p-6">
            <div class="mb-6 text-center">
                <h3 class="text-xl font-bold text-gray-800 mb-2">SURAT PERNYATAAN ASESI</h3>
                <p class="text-sm text-gray-500">Dalam Mengikuti Proses Asesmen Kompetensi</p>
            </div>

            <!-- Agreement Points -->
            <div class="bg-gray-50 rounded-lg p-5 mb-6">
                <ol class="space-y-4">
                    <li class="flex">
                        <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600 font-semibold mr-3">1</span>
                        <p class="text-gray-700">Bahwa selama mengikuti proses asesmen ini, saya akan mengikuti semua tahapan proses asesmen mulai dari pengisian form pendaftaran, form asesmen mandiri, form Persetujuan Asesmen & Kerahasiaan, form yang berkaitan dengan metode asesmen (soal praktek, soal tertulis, soal lisan), form keputusan asesmen, dan form umpan balik.</p>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600 font-semibold mr-3">2</span>
                        <p class="text-gray-700">Bahwa <span class="text-red-600 font-bold">tanda tangan image digital</span> yang saya upload dan saya gunakan pada setiap form yang berkaitan dengan proses asesmen, menjadi bukti persetujuan saya.</p>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600 font-semibold mr-3">3</span>
                        <p class="text-gray-700">Bahwa jika dalam proses asesmen, saya meninggalkan proses asesmen tanpa alasan yang patut, saya bersedia diberikan keputusan BK (Belum Kompeten) oleh asesor.</p>
                    </li>
                    <li class="flex">
                        <span class="flex-shrink-0 flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600 font-semibold mr-3">4</span>
                        <p class="text-gray-700">Demikian pernyataan saya untuk dapat dijadikan bukti bagi pihak asesor / LSP.</p>
                    </li>
                </ol>
            </div>

            <!-- Signature Upload Section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2" for="signature">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Tanda Tangan Digital
                    </span>
                </label>
                
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                        <div id="signature-preview" class="hidden mb-3">
                            <img id="preview-image" src="#" alt="Preview" class="mx-auto h-32 object-contain">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="signature" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Upload tanda tangan</span>
                                <input id="signature" name="signature" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                    </div>
                </div>
                
                <!-- User Data Information -->
                <div class="mt-4 bg-blue-50 p-3 rounded-lg">
                    <p class="text-sm text-gray-700 font-medium">{{ $data }}</p>
                    <p class="text-sm text-gray-700">Tanggal: {{ date('d-m-Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Footer Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
            <a href="javascript:history.back()" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Batal
            </a>

            <button type="button" id="btn-selanjutnya" class="px-4 py-2 rounded-md border border-transparent text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span id="button-text">Setuju dan Lanjutkan</span>
                <span id="button-loading" class="hidden ml-1">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // File input preview functionality
        const signatureInput = document.getElementById('signature');
        const previewContainer = document.getElementById('signature-preview');
        const previewImage = document.getElementById('preview-image');

        signatureInput.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });

        // Form submission with improved UI feedback
        function saveDataPersetujuan() {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            
            const fileInput = document.getElementById('signature');
            if (fileInput.files.length > 0) {
                formData.append('signature', fileInput.files[0]);
            }

            // Show loading state
            const buttonText = document.getElementById('button-text');
            const buttonLoading = document.getElementById('button-loading');
            
            buttonText.textContent = 'Mengirim...';
            buttonLoading.classList.remove('hidden');
            document.getElementById('btn-selanjutnya').disabled = true;

            $.ajax({
                url: '/user/persetujuan/save',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Persetujuan telah disimpan.',
                        confirmButtonColor: '#10B981'
                    }).then(() => {
                        window.location.href = "{{ route('user.apl1.pribadi') }}";
                    });
                },
                error: function(xhr, status, error) {
                    // Reset button state
                    buttonText.textContent = 'Setuju dan Lanjutkan';
                    buttonLoading.classList.add('hidden');
                    document.getElementById('btn-selanjutnya').disabled = false;

                    // Handle validation errors
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        
                        Object.keys(errors).forEach(key => {
                            errors[key].forEach(message => {
                                errorMessage += `${message}<br>`;
                            });
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Menyimpan',
                            html: errorMessage,
                            confirmButtonColor: '#EF4444'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal menyimpan data. Silakan coba lagi.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                }
            });
        }

        // Event listener for the submit button
        document.getElementById('btn-selanjutnya').addEventListener('click', function(event) {
            event.preventDefault();
            
            // Check if file is selected
            if (!document.getElementById('signature').files.length) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanda Tangan Diperlukan',
                    text: 'Silakan unggah tanda tangan digital Anda sebelum melanjutkan.',
                    confirmButtonColor: '#F59E0B'
                });
                return;
            }
            
            saveDataPersetujuan();
        });

        // Optional: Add drag and drop functionality
        const dropArea = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-50');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-50');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length) {
                document.getElementById('signature').files = files;
                const event = new Event('change');
                document.getElementById('signature').dispatchEvent(event);
            }
        }
    });
</script>
@endsection