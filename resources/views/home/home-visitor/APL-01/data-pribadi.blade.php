@extends('home.home-visitor.layouts.layout')

@section('title', 'Data Pribadi Pemohon - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="bg-gray-100 min-h-screen py-32 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl mx-auto overflow-hidden">
        <!-- Header Section -->
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Formulir Permohonan Sertifikasi Kompetensi
            </h2>
        </div>

        <!-- Progress Indicator -->
        <div class="px-8 pt-6">
            <div class="flex flex-wrap justify-between items-center mb-8">
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">1</div>
                    <span class="text-xs mt-2 text-blue-800 font-semibold">Data Pribadi</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-semibold">2</div>
                    <span class="text-xs mt-2 text-gray-600">Data Sertifikasi</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center mb-4 sm:mb-0">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-semibold">3</div>
                    <span class="text-xs mt-2 text-gray-600">Bukti Kelengkapan</span>
                </div>
                <div class="hidden sm:block w-1/6 h-1 bg-gray-300"></div>
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-semibold">4</div>
                    <span class="text-xs mt-2 text-gray-600">Konfirmasi</span>
                </div>
            </div>
        </div>

        <!-- Alert Message Container -->
        <div id="message" class="px-8 mt-4">
            @if(isset($revisionMessage))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ $revisionMessage }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <span class="font-medium">Perhatian:</span> Jangan keluar dari halaman ini sebelum menyelesaikan seluruh proses pengajuan. Data akan disimpan per tahap.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form Content -->
        <div class="p-8">
            <form id="data-pribadi-form">
                @csrf

                <!-- Section: Data Pribadi -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Data Pribadi</h3>
                    </div>

                    <p class="text-sm text-gray-600 mb-6 pl-11">Pada bagian ini, cantumkan data pribadi Anda dengan lengkap dan akurat.</p>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama_user" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="nama_user" name="nama_user" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->nama_user ?? old('nama_user') }}" placeholder="Masukkan nama lengkap">
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                                <input type="text" id="nik" name="nik" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->nik ?? old('nik') }}" placeholder="Masukkan 16 digit NIK">
                            </div>

                            <div>
                                <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">NIM</label>
                                <input type="text" id="nim" name="nim" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->nim ?? old('nim') }}" placeholder="Masukkan NIM">
                            </div>

                            <div>
                                <label for="tempat_tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat & Tanggal Lahir</label>
                                <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->tempat_tanggal_lahir ?? old('tempat_tanggal_lahir') }}" placeholder="Contoh: Yogyakarta, 01 Januari 2000">
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Pria" {{ ($pengajuan->jenis_kelamin ?? old('jenis_kelamin')) == 'Pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="Wanita" {{ ($pengajuan->jenis_kelamin ?? old('jenis_kelamin')) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
                            </div>

                            <div>
                                <label for="kebangsaan" class="block text-sm font-medium text-gray-700 mb-1">Kebangsaan</label>
                                <input type="text" id="kebangsaan" name="kebangsaan" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->kebangsaan ?? old('kebangsaan', 'Indonesia') }}" placeholder="Masukkan kebangsaan">
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat_rumah" class="block text-sm font-medium text-gray-700 mb-1">Alamat Rumah</label>
                                <input type="text" id="alamat_rumah" name="alamat_rumah" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->alamat_rumah ?? old('alamat_rumah') }}" placeholder="Masukkan alamat lengkap">
                            </div>

                            <div>
                                <label for="kota_domisili" class="block text-sm font-medium text-gray-700 mb-1">Kota Domisili</label>
                                <input type="text" id="kota_domisili" name="kota_domisili" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->kota_domisili ?? old('kota_domisili') }}" placeholder="Masukkan kota domisili">
                            </div>

                            <div>
                                <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" id="no_telp" name="no_telp" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->no_telp ?? old('no_telp') }}" placeholder="Contoh: 081234567890">
                            </div>

                            <div>
                                <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Terakhir</label>
                                <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->pendidikan_terakhir ?? old('pendidikan_terakhir') }}" placeholder="Contoh: S1 Teknik Informatika">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Data Pekerjaan -->
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Data Pekerjaan</h3>
                    </div>

                    <p class="text-sm text-gray-600 mb-6 pl-11">Lengkapi informasi tentang pekerjaan Anda saat ini.</p>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="status_pekerjaan" class="block text-sm font-medium text-gray-700 mb-1">Status Pekerjaan</label>
                                <select id="status_pekerjaan" name="status_pekerjaan" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Status Pekerjaan</option>
                                    <option value="Bekerja" {{ ($pengajuan->status_pekerjaan ?? old('status_pekerjaan')) == 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
                                    <option value="Tidak Bekerja" {{ ($pengajuan->status_pekerjaan ?? old('status_pekerjaan')) == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                </select>
                            </div>

                            <div>
                                <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan/Institusi</label>
                                <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->nama_perusahaan ?? old('nama_perusahaan') }}" placeholder="Masukkan nama perusahaan">
                            </div>

                            <div>
                                <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                <input type="text" id="jabatan" name="jabatan" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->jabatan ?? old('jabatan') }}" placeholder="Masukkan jabatan">
                            </div>

                            <div>
                                <label for="no_telp_perusahaan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Perusahaan</label>
                                <input type="text" id="no_telp_perusahaan" name="no_telp_perusahaan" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->no_telp_perusahaan ?? old('no_telp_perusahaan') }}" placeholder="Contoh: 021-7654321">
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat_perusahaan" class="block text-sm font-medium text-gray-700 mb-1">Alamat Perusahaan</label>
                                <input type="text" id="alamat_perusahaan" name="alamat_perusahaan" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" value="{{ $pengajuan->alamat_perusahaan ?? old('alamat_perusahaan') }}" placeholder="Masukkan alamat perusahaan">
                            </div>
                        </div>

                        <div class="mt-4 text-xs text-gray-500">
                            <p class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Jika Anda tidak bekerja, kosongkan data perusahaan/institusi
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Action Buttons -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between">
            <a href="javascript:history.back()" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>

            <button type="button" id="btn-selanjutnya" class="px-4 py-2 rounded-md border border-transparent text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center">
                <span id="button-text">Simpan & Lanjutkan</span>
                <span id="button-loading" class="hidden ml-1">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
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

        // Toggle employment fields based on status
        const statusPekerjaan = document.getElementById('status_pekerjaan');
        const employmentFields = ['nama_perusahaan', 'jabatan', 'alamat_perusahaan', 'no_telp_perusahaan'];

        function toggleEmploymentFields() {
            const isWorking = statusPekerjaan.value === 'Bekerja';

            employmentFields.forEach(field => {
                const fieldElement = document.getElementById(field);
                const fieldContainer = fieldElement.closest('div');

                if (!isWorking) {
                    fieldElement.value = '';
                }

                fieldElement.disabled = !isWorking;
                fieldContainer.style.opacity = isWorking ? '1' : '0.5';
            });
        }

        statusPekerjaan.addEventListener('change', toggleEmploymentFields);

        // Initial toggle if value is set
        if (statusPekerjaan.value) {
            toggleEmploymentFields();
        }

        // Submit handler
        document.getElementById('btn-selanjutnya').addEventListener('click', function(event) {
            event.preventDefault();
            saveDataPribadi();
        });

        // Form submission with improved UI feedback
        function saveDataPribadi() {
            // Show loading state
            const buttonText = document.getElementById('button-text');
            const buttonLoading = document.getElementById('button-loading');

            buttonText.textContent = 'Menyimpan...';
            buttonLoading.classList.remove('hidden');
            document.getElementById('btn-selanjutnya').disabled = true;

            // Get form data
            const formData = {
                _token: '{{ csrf_token() }}',
                nama_user: $('#nama_user').val(),
                nik: $('#nik').val(),
                nim: $('#nim').val(),
                kota_domisili: $('#kota_domisili').val(),
                tempat_tanggal_lahir: $('#tempat_tanggal_lahir').val(),
                jenis_kelamin: $('#jenis_kelamin').val(),
                kebangsaan: $('#kebangsaan').val(),
                alamat_rumah: $('#alamat_rumah').val(),
                no_telp: $('#no_telp').val(),
                pendidikan_terakhir: $('#pendidikan_terakhir').val(),
                status_pekerjaan: $('#status_pekerjaan').val(),
                nama_perusahaan: $('#nama_perusahaan').val(),
                jabatan: $('#jabatan').val(),
                alamat_perusahaan: $('#alamat_perusahaan').val(),
                no_telp_perusahaan: $('#no_telp_perusahaan').val(),
            };

            $.ajax({
                url: '/user/apl1/save-data-pribadi',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Data pribadi tersimpan:', response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Data Tersimpan!',
                        text: 'Data pribadi Anda berhasil disimpan.',
                        confirmButtonColor: '#3B82F6'
                    }).then(() => {
                        window.location.href = "{{ route('user.apl1.sertifikasi') }}";
                    });
                },
                error: function(xhr, status, error) {
                    // Reset button state
                    buttonText.textContent = 'Simpan & Lanjutkan';
                    buttonLoading.classList.add('hidden');
                    document.getElementById('btn-selanjutnya').disabled = false;

                    // Handle validation errors
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorHtml = '<div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">';
                        errorHtml += '<div class="flex items-center">';
                        errorHtml += '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
                        errorHtml += '<p class="text-sm text-red-700 font-medium">Periksa kembali data yang Anda masukkan:</p>';
                        errorHtml += '</div><ul class="mt-2 text-sm text-red-700 pl-6 list-disc">';

                        Object.keys(errors).forEach(key => {
                            // Highlight error fields
                            $(`#${key}`).addClass('border-red-500 bg-red-50');

                            errors[key].forEach(message => {
                                errorHtml += `<li>${message}</li>`;
                            });
                        });

                        errorHtml += '</ul></div>';

                        $('#message').html(errorHtml);

                        // Scroll to error message
                        $('html, body').animate({
                            scrollTop: $('#message').offset().top - 100
                        }, 200);
                    } else {
                        // General error
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

        // Remove error highlighting when field is edited
        $('input, select').on('input change', function() {
            $(this).removeClass('border-red-500 bg-red-50');
        });
    });
</script>
@endsection
