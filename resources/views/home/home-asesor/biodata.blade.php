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
    <!-- Dynamic Message Card (untuk pesan dari JavaScript) -->
    <div id="dynamicMessageCard" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
        <strong id="dynamicMessageTitle" class="font-bold">Error!</strong>
        <span id="dynamicMessageText" class="block sm:inline">Pesan error akan muncul di sini.</span>
        <button id="closeMessageBtn" type="button" class="absolute top-0 right-0 px-4 py-3" aria-label="close">
            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M14.354 5.646a.5.5 0 10-.708-.708L10 9.293 5.354 4.646a.5.5 0 10-.708.708L9.293 10l-4.647 4.646a.5.5 0 00.708.708L10 10.707l4.646 4.647a.5.5 0 00.708-.708L10.707 10l4.647-4.646z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
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
            <!-- Modal Konfirmasi Simpan -->
            <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex justify-center items-center hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Konfirmasi Simpan Data</h3>
                        <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-700 mb-4">Apakah Anda yakin ingin menyimpan perubahan pada biodata? Pastikan data yang dimasukkan sudah benar.</p>
                    <div class="flex justify-end gap-3">
                        <button id="cancelSave" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Batal
                        </button>
                        <button id="confirmSave" class="px-4 py-2 bg-gradient-to-r from-biru to-ungu text-white rounded-md hover:opacity-90">
                            Simpan Data
                        </button>
                    </div>
                </div>
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
/* Kelas dasar untuk input, label, dan grup form */
.input-field {
    @apply block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6;
    transition: all 0.2s ease-in-out;
}

.form-group {
    @apply mb-4;
}

.form-label {
    @apply block text-sm/6 font-medium text-sidebar_font mb-1;
}

.required-field::after {
    content: "*";
    @apply text-red-500 ml-1;
}

/* Upload Area Styling */
.upload-area {
    min-height: 200px;
    transition: all 0.2s ease-in-out;
}

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

#profile-preview, #signature-preview {
    width: 100%;
}

/* Loading Spinner */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spinner 0.8s ease-in-out infinite;
}

@keyframes spinner {
    to {
        transform: rotate(360deg);
    }
}

/* Card animations */
.fade-in {
    animation: fadeIn 0.5s ease-in-out forwards;
}

.fade-out {
    animation: fadeOut 0.3s ease-in-out forwards;
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

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}

/* Pulse animation */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.6;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Modal animations */
.modal-fade-out {
    animation: modalFadeOut 0.25s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes modalFadeOut {
    from {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    to {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
    }
}

#confirmModal:not(.hidden) {
    animation: modalFadeIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Unsaved changes badge */
#unsavedBadge {
    white-space: nowrap;
    font-size: 10px;
    border: 1px solid #fef08a;
    padding: 2px 8px;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
}

#unsavedBadge::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: #f59e0b;
    margin-right: 4px;
}

/* Form changed indicator */
.form-changed {
    border-color: #fbbf24 !important;
    animation: highlight 2s ease-in-out;
}

.form-changed:focus {
    outline-color: #f59e0b !important;
}

@keyframes highlight {
    0%, 100% {
        border-color: #fbbf24;
    }
    50% {
        border-color: #f59e0b;
    }
}

/* Tooltip styles */
.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip .tooltip-text {
    visibility: hidden;
    width: 180px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
    font-size: 12px;
}

.tooltip:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}

/* Message card transitions */
#dynamicMessageCard {
    transition: opacity 0.3s ease-in-out;
}

.opacity-0 {
    opacity: 0;
}

/* Button animations */
button {
    transition: all 0.2s ease-in-out;
}

button:active {
    transform: scale(0.98);
}

/* Responsive adjustments */
@media (max-width: 640px) {
    #frameBiodatasesor {
        padding: 1rem;
    }

    .upload-area {
        min-height: 150px;
        padding: 1rem;
    }

    #confirmModal .bg-white {
        width: 90%;
        margin: 0 auto;
        max-height: 80vh;
        overflow-y: auto;
    }
}

/* No image overlay */
.no-image-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(55, 65, 81, 0.7);
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
}
</style>

<!-- JavaScript Lengkap -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Datepicker jika tersedia
    const datepickerEl = document.getElementById('datepicker-autohide');
    if (datepickerEl && typeof Datepicker !== 'undefined') {
        new Datepicker(datepickerEl, {
            autohide: true,
            format: 'dd/mm/yyyy',
        });
    }

    const form = document.getElementById('biodataForm');
    const message = document.getElementById('biodataMessage');
    const dynamicMessageCard = document.getElementById('dynamicMessageCard');
    const dynamicMessageTitle = document.getElementById('dynamicMessageTitle');
    const dynamicMessageText = document.getElementById('dynamicMessageText');
    const confirmModal = document.getElementById('confirmModal');

    // Variabel untuk melacak status perubahan form
    let formChanged = false;
    let originalFormData = {};
    let formInitialized = false;

    // API configuration
    const apiKey = "{{ env('API_KEY') }}";
    const asesorId = @json(Auth::user()->asesor->id_asesor ?? null);

    console.log('Asesor ID:', asesorId);

    if (!asesorId) {
        console.error('Asesor ID tidak ditemukan');
        showMessageCard('Asesor ID tidak ditemukan', 'error');
        return;
    }

    // Gunakan URL API yang dinamis
    const apiUrl = "{{ url('/api/v1/asesor/biodata') }}/" + asesorId;
    const headers = {
        'accept': 'application/json',
        'API_KEY': apiKey,
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
    };

    // Fetch dengan timeout
    const fetchWithTimeout = (url, options, timeout = 30000) => {
        return Promise.race([
            fetch(url, options),
            new Promise((_, reject) =>
                setTimeout(() => reject(new Error('Request timeout')), timeout)
            )
        ]);
    };

    // Function to save form state to localStorage
    function saveFormState() {
        const formState = {};
        const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');

        inputs.forEach(input => {
            if (input.id && !input.disabled) {
                formState[input.id] = input.value;
            }
        });

        localStorage.setItem('biodataFormState', JSON.stringify(formState));
        console.log('Form state saved to localStorage');
    }

    // Function to load form state from localStorage
    function loadFormState() {
        const formState = localStorage.getItem('biodataFormState');
        if (formState) {
            try {
                const state = JSON.parse(formState);
                for (const [id, value] of Object.entries(state)) {
                    const element = document.getElementById(id);
                    if (element && !element.disabled) {
                        element.value = value;
                    }
                }
                console.log('Form state restored from localStorage');
                showMessageCard('Perubahan terakhir telah dipulihkan', 'info', 5000);
                localStorage.removeItem('biodataFormState');

                // Check for changes after loading saved state
                setTimeout(checkFormChanged, 500);
            } catch (e) {
                console.error('Error loading form state:', e);
            }
        }
    }

    // Fungsi untuk menyimpan nilai awal form
    function captureFormState() {
        originalFormData = {};
        const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');

        inputs.forEach(input => {
            if (input.id && !input.disabled) {
                originalFormData[input.id] = input.value;
            }
        });

        console.log('Original form state captured');
        formChanged = false;
        updateUnsavedChangesIndicator();
        formInitialized = true;
    }

    // Fungsi untuk memeriksa apakah form telah berubah
    function checkFormChanged() {
        if (!formInitialized || Object.keys(originalFormData).length === 0) return false;

        const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');
        let changed = false;

        inputs.forEach(input => {
            if (input.id && !input.disabled) {
                if (originalFormData[input.id] !== input.value) {
                    changed = true;
                    // Highlight changed field
                    input.classList.add('form-changed');
                } else {
                    // Remove highlight from unchanged field
                    input.classList.remove('form-changed');
                }
            }
        });

        // Check if file inputs have changed
        if (document.getElementById('file_profile').files.length > 0 ||
            document.getElementById('file_tanda_tangan').files.length > 0) {
            changed = true;
        }

        formChanged = changed;
        updateUnsavedChangesIndicator();
        return changed;
    }

    // Function to update unsaved changes indicator
    function updateUnsavedChangesIndicator() {
        // Add or remove unsaved badge next to title
        const unsavedBadge = document.getElementById('unsavedBadge');

        if (formChanged) {
            if (!unsavedBadge) {
                const badge = document.createElement('span');
                badge.id = 'unsavedBadge';
                badge.className = 'ml-2 px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full animate-pulse';
                badge.textContent = 'Perubahan belum tersimpan';

                const pageTitle = document.querySelector('#judulPage span');
                if (pageTitle) {
                    pageTitle.appendChild(badge);
                }
            }

            // Show warning message in card
            showMessageCard('Ada perubahan yang belum tersimpan. Klik "Simpan" untuk menyimpan perubahan.', 'warning', 0);

            // Add tooltip to save button
            const saveButton = document.getElementById('simpanBiodata');
            if (saveButton && !saveButton.classList.contains('highlight-save')) {
                saveButton.classList.add('highlight-save', 'animate-pulse', 'bg-yellow-500');
            }
        } else {
            if (unsavedBadge) {
                unsavedBadge.remove();
            }

            // Hide warning message card
            const warningCard = document.getElementById('dynamicMessageCard');
            if (warningCard && warningCard.classList.contains('bg-yellow-100')) {
                warningCard.classList.add('hidden');
            }

            // Remove highlight from save button
            const saveButton = document.getElementById('simpanBiodata');
            if (saveButton) {
                saveButton.classList.remove('highlight-save', 'animate-pulse', 'bg-yellow-500');
            }
        }
    }

    // Setup change detection
    function setupChangeDetection() {
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            // Remove any existing listeners to prevent duplicates
            input.removeEventListener('change', handleInputChange);
            input.removeEventListener('keyup', handleInputChange);

            // Add new listeners
            input.addEventListener('change', handleInputChange);

            // For text inputs, also detect keyup events
            if (input.type === 'text' || input.type === 'email' || input.type === 'number' || input.tagName === 'TEXTAREA') {
                input.addEventListener('keyup', handleInputChange);
            }
        });

        // Add beforeunload handler
        window.addEventListener('beforeunload', handleBeforeUnload);
    }

    // Handler for input changes
    function handleInputChange() {
        checkFormChanged();
    }

    // Handler for beforeunload event
    function handleBeforeUnload(e) {
        if (formChanged) {
            // Standard message (actual text is controlled by browser)
            const message = 'Ada perubahan yang belum tersimpan. Yakin ingin meninggalkan halaman ini?';
            e.returnValue = message;
            return message;
        }
    }

    // Fungsi pendukung untuk update konten message card
    function updateMessageCardContent(text, type) {
        dynamicMessageText.textContent = text;

        const titles = {
            'success': 'Berhasil!',
            'error': 'Error!',
            'warning': 'Perhatian!',
            'info': 'Informasi'
        };
        dynamicMessageTitle.textContent = titles[type] || titles.info;

        // Reset class
        dynamicMessageCard.className = 'mb-6 px-4 py-3 rounded relative border transition-opacity duration-300';

        // Add appropriate styling based on type
        const typeClasses = {
            'success': 'bg-green-100 border-green-400 text-green-700',
            'error': 'bg-red-100 border-red-400 text-red-700',
            'warning': 'bg-yellow-100 border-yellow-400 text-yellow-700',
            'info': 'bg-blue-100 border-blue-400 text-blue-700'
        };

        dynamicMessageCard.classList.add(...typeClasses[type].split(' '));
    }

    // Enhanced Message display helper (displays in both card and inline)
    function showMessageCard(text, type = 'info', duration = 0) {
        // Update the inline message for backward compatibility
        if (message) {
            message.textContent = text;
            const typeClasses = {
                'success': 'text-green-600',
                'error': 'text-red-600',
                'warning': 'text-yellow-600',
                'info': 'text-blue-600'
            };
            message.className = `mt-4 text-sm ${typeClasses[type] || typeClasses.info}`;
        }

        // Update card UI with improved animation
        if (dynamicMessageCard && dynamicMessageText && dynamicMessageTitle) {
            // If card is already visible, fade out first
            if (!dynamicMessageCard.classList.contains('hidden')) {
                dynamicMessageCard.classList.add('opacity-0');
                setTimeout(() => {
                    updateMessageCardContent(text, type);
                    dynamicMessageCard.classList.remove('opacity-0');
                }, 150);
            } else {
                updateMessageCardContent(text, type);
                dynamicMessageCard.classList.remove('hidden');
                // Small delay to trigger fade-in animation
                setTimeout(() => dynamicMessageCard.classList.add('fade-in'), 10);
            }

            // Smooth scroll to message if error or warning
            if (type === 'error' || type === 'warning') {
                const topPos = dynamicMessageCard.offsetTop - 20;
                window.scrollTo({
                    top: topPos,
                    behavior: 'smooth'
                });
            }
        }

        // Auto-hide with fade animation
        if (duration > 0) {
            setTimeout(() => {
                if (dynamicMessageCard) {
                    dynamicMessageCard.classList.add('opacity-0');
                    setTimeout(() => {
                        dynamicMessageCard.classList.add('hidden');
                        dynamicMessageCard.classList.remove('opacity-0');
                    }, 300);
                }
            }, duration);
        }
    }

    // Original message display helper (kept for backward compatibility)
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
            console.error('Upload elements not found for:', inputId);
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

            // Check for form changes when file is selected
            checkFormChanged();
        });

        // Remove button handler
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.stopPropagation();
                clearPreview();

                // Check for form changes when file is removed
                checkFormChanged();
            });
        }

        // Handler untuk error gambar
        function handleImageError(imageElement, containerElement) {
            // Remove any existing overlays
            const existingOverlay = containerElement.querySelector('.no-image-overlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            // Create overlay
            containerElement.classList.add('relative');
            const overlay = document.createElement('div');
            overlay.className = 'no-image-overlay';
            overlay.innerHTML = '<span>Tidak ada foto</span>';
            containerElement.appendChild(overlay);

            // Set default image if available
            imageElement.src = '{{ asset("images/default-profile.png") }}';
        }

        function handleFileSelection(file) {
            // Validate file type
            const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
            if (!allowedTypes.includes(file.type)) {
                showMessageCard('File harus berformat PNG, JPG, atau JPEG', 'error');
                return;
            }

            // Validate file size (10MB)
            const maxSize = 10 * 1024 * 1024;
            if (file.size > maxSize) {
                showMessageCard('Ukuran file maksimal 10MB', 'error');
                return;
            }

            // Show preview with better loading state
            showMessageCard('Memproses gambar...', 'info', 3000);

            // Remove any existing overlay
            const existingOverlay = preview.querySelector('.no-image-overlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                content.classList.add('hidden');
                preview.classList.remove('hidden');

                // Update input files
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;

                console.log('Preview berhasil ditampilkan untuk:', inputId);
            };
            reader.onerror = function() {
                showMessageCard('Gagal membaca file', 'error');
            };
            reader.readAsDataURL(file);
        }

        function clearPreview() {
            image.src = '';
            content.classList.remove('hidden');
            preview.classList.add('hidden');
            input.value = '';

            // Remove any overlay
            const overlay = preview.querySelector('.no-image-overlay');
            if (overlay) {
                overlay.remove();
            }

            console.log('Preview dihapus untuk:', inputId);
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

                        // Remove any existing overlay
                        const existingOverlay = preview.querySelector('.no-image-overlay');
                        if (existingOverlay) {
                            existingOverlay.remove();
                        }

                        console.log('Preview set dari URL:', url);
                    };
                    testImg.onerror = function() {
                        console.warn('Gagal memuat gambar dari URL:', url);
                        handleImageError(image, preview);
                        content.classList.add('hidden');
                        preview.classList.remove('hidden');
                    };
                    testImg.src = url;
                } else {
                    // No URL provided, show default state
                    handleImageError(image, preview);
                    content.classList.add('hidden');
                    preview.classList.remove('hidden');
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
            console.log(`Set ${id} to:`, value);
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
                    console.log(`Set ${selectId} to:`, option.textContent);
                    break;
                }
            }
        }
    }

    // Fetch and populate form data
    function loadBiodataData() {
        showMessageCard('Memuat data biodata...', 'info', 0);

        fetchWithTimeout(apiUrl, {
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

                // Check if there are saved changes to restore
                loadFormState();

                // After form is populated and any saved state is restored,
                // capture the initial state for change detection
                setTimeout(() => {
                    captureFormState();
                    setupChangeDetection();
                }, 500);

                showMessageCard('Data berhasil dimuat', 'success', 5000);
            } else {
                showMessageCard('Data tidak ditemukan', 'warning');

                // Still try to load saved form state if any
                loadFormState();
            }
        })
        .catch(err => {
            showMessageCard(`Gagal memuat data biodata: ${err.message}`, 'error');

            // Still try to load saved form state if any
            loadFormState();
        });
    }

    // Load data when page loads
    loadBiodataData();

    // Fungsi untuk mengelola modal dengan lebih baik
    function showConfirmModal(message, onConfirm) {
        const modal = document.getElementById('confirmModal');
        const modalMessage = document.querySelector('#confirmModal p');
        const confirmButton = document.getElementById('confirmSave');

        // Set pesan yang custom
        if (message) {
            modalMessage.textContent = message;
        } else {
            modalMessage.textContent = 'Apakah Anda yakin ingin menyimpan perubahan pada biodata? Pastikan data yang dimasukkan sudah benar.';
        }

        // Reset any previous handlers
        const newConfirmButton = confirmButton.cloneNode(true);
        confirmButton.parentNode.replaceChild(newConfirmButton, confirmButton);

        // Add new handler
        newConfirmButton.addEventListener('click', function() {
            closeModalWithAnimation();

            // Call the provided callback with slight delay
            setTimeout(() => {
                if (typeof onConfirm === 'function') {
                    onConfirm();
                }
            }, 100);
        });

        // Show modal
        modal.classList.remove('hidden');
    }

    // Setup modal event handlers
    if (document.getElementById('closeMessageBtn')) {
        document.getElementById('closeMessageBtn').addEventListener('click', function() {
            dynamicMessageCard.classList.add('opacity-0');
            setTimeout(() => {
                dynamicMessageCard.classList.add('hidden');
                dynamicMessageCard.classList.remove('opacity-0');
            }, 300);
        });
    }

    // Tambahkan fungsi untuk menutup modal dengan animasi
    function closeModalWithAnimation() {
        // Tambahkan kelas animasi fade-out
        confirmModal.classList.add('modal-fade-out');

        // Tunggu animasi selesai sebelum menyembunyikan modal
        setTimeout(() => {
            confirmModal.classList.remove('modal-fade-out');
            confirmModal.classList.add('hidden');
        }, 300);
    }

    // Modifikasi event handler untuk tombol tutup
    if (document.getElementById('closeModal')) {
        document.getElementById('closeModal').addEventListener('click', function() {
            closeModalWithAnimation();
        });
    }

    // Modifikasi event handler untuk tombol batal
    if (document.getElementById('cancelSave')) {
        document.getElementById('cancelSave').addEventListener('click', function() {
            closeModalWithAnimation();
        });
    }

    // Modified form submission handler - now just validates and shows confirmation modal
    form.addEventListener('submit', function(e) {
        e.preventDefault();

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
                showMessageCard(`${field.name} wajib diisi`, 'error');
                element?.focus();
                return;
            }
        }

        // Validate select fields
        const kebangsaanSelect = document.getElementById('kebangsaan');
        const kelaminSelect = document.getElementById('kelamin');

        if (!kebangsaanSelect.value || kebangsaanSelect.selectedIndex === 0) {
            showMessageCard('Kebangsaan wajib dipilih', 'error');
            kebangsaanSelect.focus();
            return;
        }

        if (!kelaminSelect.value || kelaminSelect.selectedIndex === 0) {
            showMessageCard('Jenis Kelamin wajib dipilih', 'error');
            kelaminSelect.focus();
            return;
        }

        // Save form state in case user cancels or error occurs
        saveFormState();

        // Show custom message based on form state
        if (formChanged) {
            showConfirmModal('Ada perubahan pada data biodata Anda. Lanjutkan menyimpan?', saveFormData);
        } else {
            showConfirmModal('Tidak ada perubahan terdeteksi. Tetap ingin menyimpan data?', saveFormData);
        }
    });

    // Function to handle actual form data submission
    function saveFormData() {
        showMessageCard('Menyimpan data...', 'info', 0);

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
        const kelaminSelect = document.getElementById('kelamin');
        const selectedKelamin = kelaminSelect.options[kelaminSelect.selectedIndex];
        let kelaminValue = selectedKelamin.value;
        if (kelaminValue === 'Pria') {
            kelaminValue = 'Laki-laki';
        } else if (kelaminValue === 'Wanita') {
            kelaminValue = 'Perempuan';
        }
        formData.append('jenis_kelamin', kelaminValue);

        // Handle kebangsaan
        const kebangsaanSelect = document.getElementById('kebangsaan');
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
                const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
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
            'API_KEY': apiKey,
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        };

        // Debug: Log formData contents
        console.log('FormData contents:');
        for (let [key, value] of formData.entries()) {
            console.log(key, typeof value === 'object' && value instanceof File ? `File: ${value.name}` : value);
        }

        // Disable submit button
        const submitButton = document.getElementById('simpanBiodata');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="loading-spinner mr-2"></span>Menyimpan...';

        fetchWithTimeout(apiUrl, {
            method: 'POST', // Gunakan POST dengan _method=PUT untuk Laravel
            headers: putHeaders,
            body: formData
        }, 60000) // 60 detik timeout untuk upload file
        .then(response => {
            console.log('Update response status:', response.status);
            return response.json();
        })
        .then(res => {
            console.log('Update response:', res);
            if (res.success) {
                // Clear saved form state since update was successful
                localStorage.removeItem('biodataFormState');

                // Reset form changed state and highlight
                formChanged = false;
                const inputs = form.querySelectorAll('input:not([type="file"]), select, textarea');
                inputs.forEach(input => {
                    input.classList.remove('form-changed');
                });

                // Update original form data
                captureFormState();

                showMessageCard(res.message || 'Biodata berhasil diupdate!', 'success');

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
                showMessageCard(errorMessage, 'error');

                // Keep form state saved in localStorage for later recovery
                saveFormState();
            }
        })
        .catch(err => {
            console.error('Error updating data:', err);
            showMessageCard(`Gagal mengupdate biodata: ${err.message}`, 'error');

            // Keep form state saved in localStorage for later recovery
            saveFormState();
        })
        .finally(() => {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        });
    }
});
</script>

@endsection
