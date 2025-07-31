@extends('home.home-asesor.layouts.layout')

@section('title', 'Biodata - Asesor')

<!-- Meta CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')

<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mb-4 ms-4">
        <!-- icon gradasi -->
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        </svg>
        <span class="ms-2 text-xl font-bold text-black">Biodata Asesor</span>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <!-- Loading State Indicator -->
    <div id="loadingDataState" class="relative z-10 p-8 border border-border bg-white rounded-2xl mb-4">
        <div class="w-full flex flex-col items-center justify-center py-8">
            <div class="flex items-center space-x-2 mb-4">
                <svg class="animate-spin h-8 w-8 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-lg font-medium text-gray-700">Memuat data biodata...</span>
            </div>
            <div class="text-sm text-gray-500 text-center max-w-md">
                Sistem sedang mengambil informasi biodata asesor dari server. Mohon tunggu sebentar.
            </div>
        </div>
    </div>

    <div id="frameBiodatasesor" class="relative z-10 p-8 border border-border bg-white rounded-2xl">
        <p class="text-lg font-medium text-black">Biodata Pribadi</p>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Terdapat kesalahan input:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="biodataForm" onsubmit="return false;">
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-4">
                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label for="nama-panjang" class="block text-sm/6 font-medium text-sidebar_font">Nama Lengkap
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="text" name="nama-panjang" id="nama-panjang" autocomplete="given-name" placeholder="Isikan Nama Lengkap Anda"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6" required>
                    </div>
                </div>

                <!-- Kebangsaan -->
                <div class="sm:col-span-2">
                    <label for="kebangsaan" class="block text-sm/6 font-medium text-sidebar_font">Kebangsaan
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <select id="kebangsaan" name="kebangsaan" autocomplete="kebangsaan"
    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                            <option value="" disabled selected>Pilih Kebangsaan</option>
                            <option value="Indonesia">Indonesia</option>
                            <option value="Korean">Korean</option>
                            <option value="Japanese">Japanese</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                            <option value="American">American</option>
                            <option value="Chinese">Chinese</option>
                            <option value="British">British</option>
                            <option value="Indian">Indian</option>
                            <option value="Brazilian">Brazilian</option>
                            <option value="Russian">Russian</option>
                            <option value="South African">South African</option>
                            <option value="Spanish">Spanish</option>
                        </select>
                    </div>
                </div>

                <!-- NIK -->
                <div class="sm:col-span-2">
                    <label for="nik" class="block text-sm/6 font-medium text-sidebar_font">Nomor Induk Kependudukan (NIK)
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="number" name="nik" id="nik" autocomplete="nik" placeholder="Isikan NIK Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-sm/6 font-medium text-sidebar_font">Alamat Domisili
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="text" name="alamat" id="alamat" autocomplete="alamat" placeholder="Isikan Alamat Domisili Anda sesuai KTP"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                    </div>
                </div>

                <!-- Tempat Lahir -->
                <div class="sm:col-span-2">
                    <label for="tempat_lahir" class="block text-sm font-medium text-sidebar_font">Tempat Lahir
                    </label>
                    <div class="mt-2">
                        <select id="tempat_lahir" name="tempat_lahir" autocomplete="birth-place"
                        class="w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm placeholder:placeholder_input">
                        <option value="" disabled selected>Pilih Tempat Lahir</option>
                        <option value="DI Yogyakarta">DI Yogyakarta</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Solo">Solo</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Medan">Medan</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Probolinggo">Probolinggo</option>
                        <option value="Malang">Malang</option>
                        <option value="Palembang">Palembang</option>
                        <option value="Makassar">Makassar</option>
                        <option value="Batam">Batam</option>
                        <option value="Denpasar">Denpasar</option>
                        <option value="Bandar Lampung">Bandar Lampung</option>
                        <option value="Pekanbaru">Pekanbaru</option>
                        <option value="Balikpapan">Balikpapan</option>
                        <option value="Ambon">Ambon</option>
                        <option value="Manado">Manado</option>
                        <option value="Jayapura">Jayapura</option>
                        <option value="Palangkaraya">Palangkaraya</option>
                        </select>
                    </div>
                </div>

                <!-- Kabupaten/Kota Domisili -->
                <div class="sm:col-span-2">
                    <label for="kota-domisili" class="block text-sm font-medium text-sidebar_font">Kabupaten/Kota Domisili
                    </label>
                    <div class="mt-2">
                        <select id="kota-domisili" name="kota-domisili" autocomplete="address-level2"
                        class="w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm placeholder:placeholder_input">
                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                        <option value="Sleman">Sleman</option>
                        <option value="Bantul">Bantul</option>
                        <option value="Gunungkidul">Gunungkidul</option>
                        <option value="Klaten">Klaten</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Bekasi">Bekasi</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Medan">Medan</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Probolinggo">Probolinggo</option>
                        <option value="Malang">Malang</option>
                        <option value="Palembang">Palembang</option>
                        <option value="Makassar">Makassar</option>
                        <option value="Batam">Batam</option>
                        <option value="Denpasar">Denpasar</option>
                        <option value="Bandar Lampung">Bandar Lampung</option>
                        <option value="Pekanbaru">Pekanbaru</option>
                        <option value="Balikpapan">Balikpapan</option>
                        <option value="Ambon">Ambon</option>
                        <option value="Manado">Manado</option>
                        <option value="Jayapura">Jayapura</option>
                        <option value="Palangkaraya">Palangkaraya</option>
                        </select>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="sm:col-span-2">
                    <label for="tanggal-lahir" class="block text-sm/6 font-medium text-sidebar_font">Tanggal Lahir
                    </label>
                    <div class="mt-2">
                        <input id="datepicker-autohide" datepicker datepicker-autohide type="text"
                        class="border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru block w-full ps-3 p-2 text-black placeholder-placeholder_input"
                        placeholder="Pilih Tanggal Lahir" name="tanggal_lahir">
                    </div>
                </div>

                <!-- Provinsi -->
                <div class="sm:col-span-2">
                    <label for="provinsi" class="block text-sm/6 font-medium text-sidebar_font">Provinsi
                    </label>
                    <div class="mt-2">
                        <select id="provinsi" name="provinsi" autocomplete="provinsi"
    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                            <option value="" disabled selected>Pilih Provinsi</option>
                            <option value="Daerah Istimewa Yogyakarta">Daerah Istimewa Yogyakarta</option>
                            <option value="DKI Jakarta">DKI Jakarta</option>
                            <option value="Jawa Tengah">Jawa Tengah</option>
                            <option value="Jawa Timur">Jawa Timur</option>
                            <option value="Jawa Barat">Jawa Barat</option>
                            <option value="Bali">Bali</option>
                            <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                            <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                            <option value="Kalimantan Barat">Kalimantan Barat</option>
                            <option value="Kalimantan Timur">Kalimantan Timur</option>
                            <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                            <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                            <option value="Sumatera Utara">Sumatera Utara</option>
                            <option value="Sumatera Selatan">Sumatera Selatan</option>
                        </select>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="sm:col-span-2">
                    <label for="kelamin" class="block text-sm/6 font-medium text-sidebar_font">Jenis Kelamin
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <select id="kelamin" name="kelamin" autocomplete="kelamin" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                </div>

                <!-- Kode Pos -->
                <div class="sm:col-span-2">
                    <label for="kode_pos" class="block text-sm/6 font-medium text-sidebar_font">Kode Pos
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="number" name="kode_pos" id="kode_pos" autocomplete="kode_pos" placeholder="Isikan Kode Pos"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                    </div>
                </div>

                <!-- No HP -->
                <div class="sm:col-span-2">
                    <label for="no-hp" class="block text-sm/6 font-medium text-sidebar_font">No HP/Telp
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="number" name="no_wa" id="no_wa" autocomplete="tel" placeholder="Isikan Nomor Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" required>
                    </div>
                </div>

                <!-- No MET  -->
                <div class="sm:col-span-2">
                    <label for="no-met" class="block text-sm/6 font-medium text-sidebar_font">Nomor MET
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="text" name="no_met" id="no_met" autocomplete="no_met" placeholder="Isikan Nomor MET Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" disabled>
                    </div>
                </div>

                <!-- Email -->
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-medium text-sidebar_font">Email
                    </label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" placeholder="Isikan Email Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" disabled>
                    </div>
                </div>

                <!-- No Sertifikasi -->
                <div class="sm:col-span-2">
                    <label for="no-sertif" class="block text-sm/6 font-medium text-sidebar_font">Nomor Sertifikasi
                    <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="text" name="no_sertif" id="no_sertif" autocomplete="no_sertif" placeholder="Isikan Nomor Sertifikat Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input" disabled>
                    </div>
                </div>

                <!-- Upload Foto Profil dengan Preview -->
                <div class="mt-6 col-span-2">
                    <label for="file_profile" class="block text-sm/6 font-medium text-sidebar_font">Unggah Foto Profil
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <!-- Upload Area -->
                        <div id="profile-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 cursor-pointer hover:border-biru transition-colors upload-area">
                            <div class="text-center" id="profile-content">
                                <svg class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Zm.394 9.553a1 1 0 0 0-1.817.062l-2.5 6A1 1 0 0 0 8 19h8a1 1 0 0 0 .894-1.447l-2-4A1 1 0 0 0 13.2 13.4l-.53.706-1.276-2.553ZM13 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" clip-rule="evenodd"/>
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <span class="font-semibold text-biru">Upload foto profil</span>
                                    <span class="pl-1">atau drag and drop</span>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                            </div>
                            <!-- Preview Image -->
                            <div id="profile-preview" class="hidden text-center">
                                <img id="profile-image" src="" alt="Preview Foto Profil" class="max-h-48 w-auto rounded-lg mx-auto">
                                <div class="mt-2 text-center">
                                    <button type="button" id="remove-profile" class="text-red-500 text-sm hover:text-red-700">
                                        Hapus foto
                                    </button>
                                </div>
                            </div>
                        </div>
                        <input type="file" name="file_profile" id="file_profile" class="hidden" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>

                <!-- Upload Tanda Tangan dengan Preview -->
                <div class="mt-6 col-span-2">
                    <label for="file_tanda_tangan" class="block text-sm/6 font-medium text-sidebar_font">Unggah Tanda Tangan (Utamakan PNG)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <!-- Upload Area -->
                        <div id="signature-upload-area" class="w-full flex flex-col items-center justify-center rounded-lg border border-dashed border-border_input px-6 py-10 cursor-pointer hover:border-biru transition-colors upload-area">
                            <div class="text-center" id="signature-content">
                                <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32l8.4-8.4z" />
                                </svg>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <span class="font-semibold text-biru">Upload tanda tangan</span>
                                    <span class="pl-1">atau drag and drop</span>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">PNG, JPG, JPEG maksimal 2MB</p>
                            </div>
                            <!-- Preview Image -->
                            <div id="signature-preview" class="hidden text-center">
                                <img id="signature-image" src="" alt="Preview Tanda Tangan" class="max-h-48 w-auto rounded-lg mx-auto p-0">
                                <div class="mt-2 text-center">
                                    <button type="button" id="remove-signature" class="text-red-500 text-sm hover:text-red-700">
                                        Hapus tanda tangan
                                    </button>
                                </div>
                            </div>

                        </div>
                        <input type="file" name="file_tanda_tangan" id="file_tanda_tangan" class="hidden" accept="image/png,image/jpeg,image/jpg">
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button id="simpanBiodata" type="submit" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none mt-6">Simpan</button>
            </div>
            <div id="biodataMessage" class="mt-4 text-sm"></div>
        </form>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[80%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<!-- CSS untuk Upload Area -->
<style>
.upload-area:hover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
}

.upload-area.dragover {
    border-color: #3B82F6;
    background-color: #EFF6FF;
    transform: scale(1.02);
}

#profile-preview img,
#signature-preview img {
    max-width: 100%;
    height: auto;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

#signature-preview img {
    border: 1px solid #e5e7eb;
    padding: 8px;
    background: white;
}

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #3498db;
    border-radius: 50%;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Fix untuk flex layout pada upload area */
.upload-area {
    min-height: 200px;
}

#profile-preview, #signature-preview {
    width: 100%;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Datepicker jika tersedia
    const datepickerEl = document.getElementById('datepicker-autohide');
    if (datepickerEl && typeof Datepicker !== 'undefined') {
        new Datepicker(datepickerEl, {
            autohide: true,
            format: 'mm/dd/yyyy',
        });
    }

    const form = document.getElementById('biodataForm');
    const message = document.getElementById('biodataMessage');
    const loadingDataState = document.getElementById('loadingDataState');
    const frameBiodatasesor = document.getElementById('frameBiodatasesor');

    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        showMessage('Konfigurasi API URL tidak ditemukan', 'error');
        hideLoadingState();
        return;
    }

    if (!apiConfig.key) {
        showMessage('Konfigurasi API Key tidak ditemukan', 'error');
        hideLoadingState();
        return;
    }

    if (!apiConfig.asesorId) {
        showMessage('Asesor ID tidak ditemukan', 'error');
        hideLoadingState();
        return;
    }

    // Build API URL dynamically
    const apiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;

    // Headers configuration
    const headers = {
        'accept': 'application/json',
        'API-KEY': apiConfig.key,
        'X-CSRF-TOKEN': apiConfig.csrfToken
    };

    // Loading state management
    function showLoadingState() {
        if (loadingDataState) {
            loadingDataState.classList.remove('hidden');
        }
        if (frameBiodatasesor) {
            frameBiodatasesor.style.opacity = '0.5';
            frameBiodatasesor.style.pointerEvents = 'none';
        }
    }

    function hideLoadingState() {
        if (loadingDataState) {
            loadingDataState.classList.add('hidden');
        }
        if (frameBiodatasesor) {
            frameBiodatasesor.style.opacity = '1';
            frameBiodatasesor.style.pointerEvents = 'auto';
        }
    }

    // Message display helper
    function showMessage(text, type = 'info', duration = 5000) {
        if (!message) return;

        message.textContent = text;

        const typeClasses = {
            'success': 'text-green-600',
            'error': 'text-red-600',
            'warning': 'text-yellow-600',
            'info': 'text-blue-600'
        };

        message.className = `mt-4 text-sm ${typeClasses[type] || typeClasses.info}`;

        if (duration > 0) {
            setTimeout(() => {
                message.textContent = '';
            }, duration);
        }
    }

    // Image Upload dengan Preview Function
    function setupImageUpload(config) {
        const {
            inputId,
            uploadAreaId,
            contentId,
            previewId,
            imageId,
            removeButtonId
        } = config;

        const input = document.getElementById(inputId);
        const uploadArea = document.getElementById(uploadAreaId);
        const content = document.getElementById(contentId);
        const preview = document.getElementById(previewId);
        const image = document.getElementById(imageId);
        const removeButton = document.getElementById(removeButtonId);

        if (!input || !uploadArea || !content || !preview || !image) {
            return null;
        }

        // Click handler untuk upload area
        uploadArea.addEventListener('click', function(e) {
            if (e.target !== removeButton && !removeButton?.contains(e.target)) {
                input.click();
            }
        });

        // Drag and drop handlers
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelection(files[0]);
            }
        });

        // File input change handler
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleFileSelection(file);
            }
        });

        // Remove button handler
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.stopPropagation();
                clearPreview();
            });
        }

        function handleFileSelection(file) {
            // Validate file type
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                showMessage('File harus berformat PNG, JPG, atau JPEG', 'error');
                return;
            }

            // Validate file size (10MB)
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                showMessage('Ukuran file maksimal 10MB', 'error');
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                content.classList.add('hidden');
                preview.classList.remove('hidden');

                // Update input files
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
            };
            reader.onerror = function() {
                showMessage('Gagal membaca file', 'error');
            };
            reader.readAsDataURL(file);
        }

        function clearPreview() {
            image.src = '';
            content.classList.remove('hidden');
            preview.classList.add('hidden');
            input.value = '';
        }

        // Public methods
        return {
            setPreviewFromUrl: function(url) {
                if (url) {
                    // Test if image loads successfully
                    const testImg = new Image();
                    testImg.onload = function() {
                        image.src = url;
                        content.classList.add('hidden');
                        preview.classList.remove('hidden');
                    };
                    testImg.onerror = function() {
                        // Silent fail for security
                    };
                    testImg.src = url;
                }
            },
            clearPreview: clearPreview,
            hasFile: function() {
                return input.files && input.files.length > 0;
            }
        };
    }

    // Setup upload untuk foto profil
    const profileUpload = setupImageUpload({
        inputId: 'file_profile',
        uploadAreaId: 'profile-upload-area',
        contentId: 'profile-content',
        previewId: 'profile-preview',
        imageId: 'profile-image',
        removeButtonId: 'remove-profile'
    });

    // Setup upload untuk tanda tangan
    const signatureUpload = setupImageUpload({
        inputId: 'file_tanda_tangan',
        uploadAreaId: 'signature-upload-area',
        contentId: 'signature-content',
        previewId: 'signature-preview',
        imageId: 'signature-image',
        removeButtonId: 'remove-signature'
    });

    // Helper functions untuk form population
    function setFieldValue(id, value) {
        const element = document.getElementById(id);
        if (element && value !== null && value !== undefined && value !== '') {
            element.value = value;
        }
    }

    function setSelectValue(selectId, value) {
        const select = document.getElementById(selectId);
        if (select && value) {
            for (let i = 0; i < select.options.length; i++) {
                const option = select.options[i];
                if (option.value === value ||
                    option.textContent.trim() === value ||
                    option.value.toLowerCase() === value.toLowerCase() ||
                    option.textContent.toLowerCase().includes(value.toLowerCase())) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
    }

    // Fetch and populate form data
    function loadBiodataData() {
        showLoadingState();
        showMessage('Memuat data biodata...', 'info', 0);

        fetch(apiUrl, {
            method: 'GET',
            headers: headers
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(res => {
            if (res.success && res.data) {
                const data = res.data;

                // Populate all form fields
                setFieldValue('nama-panjang', data.nama_asesor);
                setFieldValue('email', data.email);
                setFieldValue('nik', data.no_ktp);
                setFieldValue('alamat', data.alamat);
                setFieldValue('kode_pos', data.kode_pos);
                setFieldValue('no_wa', data.no_hp);
                setFieldValue('no_met', data.no_met);
                setFieldValue('no_sertif', data.no_sertifikat);

                // Set select fields
                setSelectValue('kebangsaan', data.kebangsaan);
                setSelectValue('tempat_lahir', data.tempat_lahir);
                setSelectValue('provinsi', data.provinsi);
                setSelectValue('kota-domisili', data.kabupaten_kota);

                // Handle jenis kelamin mapping
                let jenisKelamin = data.jenis_kelamin;
                if (jenisKelamin === 'Laki-laki') {
                    jenisKelamin = 'Pria';
                } else if (jenisKelamin === 'Perempuan') {
                    jenisKelamin = 'Wanita';
                }
                setSelectValue('kelamin', jenisKelamin);

                // Set tanggal lahir
                if (data.tanggal_lahir) {
                    const tanggalElement = document.getElementById('datepicker-autohide');
                    if (tanggalElement) {
                        const date = new Date(data.tanggal_lahir);
                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();
                        tanggalElement.value = `${day}/${month}/${year}`;
                    }
                }

                // Handle existing foto profil
                if (data.foto_asesor && profileUpload) {
                    const imageUrl = `/storage/data_asesor/${data.foto_asesor}`;
                    profileUpload.setPreviewFromUrl(imageUrl);
                }

                // Handle existing tanda tangan
                if (data.file_url_tanda_tangan && signatureUpload) {
                    const signatureUrl = data.file_url_tanda_tangan;
                    signatureUpload.setPreviewFromUrl(signatureUrl);
                }

                showMessage('Data berhasil dimuat', 'success', 3000);
            } else {
                showMessage('Data tidak ditemukan', 'warning');
            }
        })
        .catch(err => {
            showMessage('Gagal memuat data biodata', 'error');
        })
        .finally(() => {
            // Hide loading state setelah selesai (berhasil atau gagal)
            setTimeout(() => {
                hideLoadingState();
            }, 500);
        });
    }

    // Load data when page loads
    loadBiodataData();

    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        showMessage('Menyimpan data...', 'info', 0);

        // Validate required fields
        const requiredFields = [
            { id: 'nama-panjang', name: 'Nama Lengkap' },
            { id: 'nik', name: 'NIK' },
            { id: 'alamat', name: 'Alamat' },
            { id: 'kode_pos', name: 'Kode Pos' },
            { id: 'no_wa', name: 'No HP' },
            { id: 'no_met', name: 'No MET' },
            { id: 'no_sertif', name: 'No Sertifikat' }
        ];

        for (const field of requiredFields) {
            const element = document.getElementById(field.id);
            if (!element || !element.value.trim()) {
                showMessage(`${field.name} wajib diisi`, 'error');
                element?.focus();
                return;
            }
        }

        // Validate select fields
        const kebangsaanSelect = document.getElementById('kebangsaan');
        const kelaminSelect = document.getElementById('kelamin');

        if (!kebangsaanSelect.value || kebangsaanSelect.selectedIndex === 0) {
            showMessage('Kebangsaan wajib dipilih', 'error');
            kebangsaanSelect.focus();
            return;
        }

        if (!kelaminSelect.value || kelaminSelect.selectedIndex === 0) {
            showMessage('Jenis Kelamin wajib dipilih', 'error');
            kelaminSelect.focus();
            return;
        }

        // Create FormData sesuai dengan API documentation
        const formData = new FormData();

        // WAJIB: Method spoofing untuk Laravel PUT request
        formData.append('_method', 'PUT');

        // Required fields sesuai dokumentasi API
        formData.append('nama_asesor', document.getElementById('nama-panjang').value.trim());
        formData.append('no_sertifikat', document.getElementById('no_sertif').value.trim());
        formData.append('no_hp', document.getElementById('no_wa').value.trim());
        formData.append('alamat', document.getElementById('alamat').value.trim());
        formData.append('no_ktp', document.getElementById('nik').value.trim());
        formData.append('no_met', document.getElementById('no_met').value.trim());
        formData.append('kode_pos', document.getElementById('kode_pos').value.trim());

        // Email field (bisa kosong sesuai dokumentasi)
        const emailValue = document.getElementById('email').value.trim();
        if (emailValue) {
            formData.append('email', emailValue);
        }

        // Handle jenis kelamin - convert kembali ke format API
        const selectedKelamin = kelaminSelect.options[kelaminSelect.selectedIndex];
        let kelaminValue = selectedKelamin.value;
        if (kelaminValue === 'Pria') {
            kelaminValue = 'Laki-laki';
        } else if (kelaminValue === 'Wanita') {
            kelaminValue = 'Perempuan';
        }
        formData.append('jenis_kelamin', kelaminValue);

        // Handle kebangsaan
        const selectedKebangsaan = kebangsaanSelect.options[kebangsaanSelect.selectedIndex];
        formData.append('kebangsaan', selectedKebangsaan.value);

        // Optional fields
        const tempatLahirSelect = document.getElementById('tempat_lahir');
        const selectedTempatLahir = tempatLahirSelect.options[tempatLahirSelect.selectedIndex];
        if (selectedTempatLahir && !selectedTempatLahir.disabled && selectedTempatLahir.value) {
            formData.append('tempat_lahir', selectedTempatLahir.value);
        }

        const provinsiSelect = document.getElementById('provinsi');
        const selectedProvinsi = provinsiSelect.options[provinsiSelect.selectedIndex];
        if (selectedProvinsi && !selectedProvinsi.disabled && selectedProvinsi.value) {
            formData.append('provinsi', selectedProvinsi.value);
        }

        const kotaSelect = document.getElementById('kota-domisili');
        const selectedKota = kotaSelect.options[kotaSelect.selectedIndex];
        if (selectedKota && !selectedKota.disabled && selectedKota.value) {
            formData.append('kabupaten_kota', selectedKota.value);
        }

        // Handle tanggal lahir - convert dari dd/mm/yyyy ke yyyy-mm-dd
        const tanggalLahir = document.getElementById('datepicker-autohide').value;
        if (tanggalLahir) {
            const parts = tanggalLahir.split('/');
            if (parts.length === 3) {
                const formattedDate = `${parts[2]}-${parts[0]}-${parts[1]}`;
                formData.append('tanggal_lahir', formattedDate);
            }
        }

        // Handle file uploads
        const fotoUpload = document.getElementById('file_profile');
        if (fotoUpload && fotoUpload.files.length > 0) {
            formData.append('foto_asesor', fotoUpload.files[0]);
        }

        const signatureUploadInput = document.getElementById('file_tanda_tangan');
        if (signatureUploadInput && signatureUploadInput.files.length > 0) {
            formData.append('tanda_tangan', signatureUploadInput.files[0]);
        }

        // Kode registrasi (optional)
        formData.append('kode_registrasi', '');

        // Headers untuk PUT request (tanpa Content-Type untuk multipart/form-data)
        const putHeaders = {
            'accept': 'application/json',
            'API-KEY': apiConfig.key,
            'X-CSRF-TOKEN': apiConfig.csrfToken
        };

        // Disable submit button
        const submitButton = document.getElementById('simpanBiodata');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="loading-spinner mr-2"></span>Menyimpan...';

        fetch(apiUrl, {
            method: 'POST', // Gunakan POST dengan _method=PUT untuk Laravel
            headers: putHeaders,
            body: formData
        })
        .then(response => {
            return response.json();
        })
        .then(res => {
            if (res.success) {
                showMessage(res.message || 'Biodata berhasil diupdate!', 'success');

                // Reload data setelah update berhasil
                setTimeout(() => {
                    loadBiodataData();
                }, 1000);
            } else {
                let errorMessage = 'Gagal mengupdate biodata';
                if (res.errors) {
                    const errorList = Object.values(res.errors).flat();
                    errorMessage += ': ' + errorList.join(', ');
                } else if (res.message) {
                    errorMessage += ': ' + res.message;
                }
                showMessage(errorMessage, 'error');
            }
        })
        .catch(err => {
            showMessage('Gagal mengupdate biodata', 'error');
        })
        .finally(() => {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
    });
});
</script>
@endsection
