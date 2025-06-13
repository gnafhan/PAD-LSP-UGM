@extends('home.home-asesor.layouts.layout')

@section('title', 'Biodata - Asesor')

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
                    <label for="nama-panjang" class="block text-sm/6 font-medium text-sidebar_font">Nama Lengkap</label>
                    <div class="mt-2">
                        <input type="text" name="nama-panjang" id="nama-panjang" autocomplete="given-name" placeholder="Isikan Nama Lengkap Anda"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6">
                    </div>
                </div>
                <!-- Kebangsaan -->
                <div class="sm:col-span-2">
                    <label for="kebangsaan" class="block text-sm/6 font-medium text-sidebar_font">Kebangsaan</label>
                    <div class="mt-2">
                        <select id="kebangsaan" name="kebangsaan" autocomplete="kebangsaan"
    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                            <option disabled selected>Pilih Kebangsaan</option>
                            <option value="KR">Korean</option>
                            <option value="JP">Japanese</option>
                            <option value="FR">French</option>
                            <option value="GR">German</option>
                            <option value="ID">Indonesia</option>
                            <option value="US">American</option>
                            <option value="CN">Chinese</option>
                            <option value="GB">British</option>
                            <option value="IN">Indian</option>
                            <option value="BR">Brazilian</option>
                            <option value="RU">Russian</option>
                            <option value="ZA">South African</option>
                            <option value="ES">Spanish</option>
                        </select>
                    </div>
                </div>
                <!-- NIK -->
                <div class="sm:col-span-2">
                    <label for="nik" class="block text-sm/6 font-medium text-sidebar_font">NIK</label>
                    <div class="mt-2">
                        <input type="number" name="nik" id="nik" autocomplete="nik" placeholder="Isikan NIK Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- Alamat -->
                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-sm/6 font-medium text-sidebar_font">Alamat Domisili</label>
                    <div class="mt-2">
                        <input type="text" name="alamat" id="alamat" autocomplete="alamat" placeholder="Isikan Alamat Domisili Anda sesuai KTP"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- Tempat Lahir -->
                <div class="sm:col-span-2">
                    <label for="tempat_lahir" class="block text-sm font-medium text-sidebar_font">Tempat Lahir</label>
                    <div class="mt-2">
                        <select id="tempat_lahir" name="tempat_lahir" autocomplete="birth-place"
                        class="w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm placeholder:placeholder_input">
                        <option disabled selected>Pilih Tempat Lahir</option>
                        <option>DI Yogykarta</option>
                        <option>Jakarta</option>
                        <option>Solo</option>
                        <option>Bandung</option>
                        <option>Surabaya</option>
                        <option>Medan</option>
                        <option>Semarang</option>
                        <option>Probolinggo</option>
                        <option>Malang</option>
                        <option>Palembang</option>
                        <option>Makassar</option>
                        <option>Batam</option>
                        <option>Denpasar</option>
                        <option>Bandar Lampung</option>
                        <option>Pekanbaru</option>
                        <option>Balikpapan</option>
                        <option>Ambon</option>
                        <option>Manado</option>
                        <option>Jayapura</option>
                        <option>Palangkaraya</option>
                        <!-- Tambahkan lainnya sesuai kebutuhan -->
                        </select>
                    </div>
                </div>

                <!-- Kabupaten/Kota Domisili -->
                <div class="sm:col-span-2">
                    <label for="kota-domisili" class="block text-sm font-medium text-sidebar_font">Kabupaten/Kota Domisili</label>
                    <div class="mt-2">
                        <select id="kota-domisili" name="kota-domisili" autocomplete="address-level2"
                        class="w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm placeholder:placeholder_input">
                        <option disabled selected>Pilih Kabupaten/Kota</option>
                        <option>Yogyakarta</option>
                        <option>Sleman</option>
                        <option>Bantul</option>
                        <option>Gunungkidul</option>
                        <option>Klaten</option>
                        <option>Jakarta</option>
                        <option>Bekasi</option>
                        <option>Bandung</option>
                        <option>Surabaya</option>
                        <option>Medan</option>
                        <option>Semarang</option>
                        <option>Probolinggo</option>
                        <option>Malang</option>
                        <option>Palembang</option>
                        <option>Makassar</option>
                        <option>Batam</option>
                        <option>Denpasar</option>
                        <option>Bandar Lampung</option>
                        <option>Pekanbaru</option>
                        <option>Balikpapan</option>
                        <option>Ambon</option>
                        <option>Manado</option>
                        <option>Jayapura</option>
                        <option>Palangkaraya</option>
                        <!-- Tambahkan lainnya sesuai kebutuhan -->
                        </select>
                    </div>
                </div>
                <!-- Tanggal Lahir -->
                <div class="sm:col-span-2">
                    <label for="tanggal-lahir" class="block text-sm/6 font-medium text-sidebar_font">Tanggal Lahir</label>
                    <div class="mt-2">
                        <input id="datepicker-autohide" datepicker datepicker-autohide type="text"
                        class="border border-border_input text-sm rounded-lg focus:ring-biru focus:border-biru block w-full ps-3 p-2 text-black placeholder-placeholder_input"
                        placeholder="PIlih Tanggal Lahir" name="tanggal_lahir" id="tanggal_lahir">
                    </div>
                </div>
                <!-- Provinsi -->
                <div class="sm:col-span-2">
                    <label for="provinsi" class="block text-sm/6 font-medium text-sidebar_font">Provinsi</label>
                    <div class="mt-2">
                        <select id="provinsi" name="provinsi" autocomplete="provinsi"
    class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                            <option disabled selected>Pilih Provinsi</option>
                            <option>Jawa Tengah</option>
                            <option>Jawa Timur</option>
                            <option>Jawa Barat</option>
                            <option>Bali</option>
                            <option>Nusa Tenggara Barat</option>
                            <option>Nusa Tenggara Timur</option>
                            <option>Kalimantan Barat</option>
                            <option>Kalimantan Timur</option>
                            <option>Kalimantan Selatan</option>
                            <option>Kalimantan Tengah</option>
                            <option>Sumatera Utara</option>
                            <option>Sumatera Selatan</option>
                            <option>Daerah Istimewa Yogyakarta</option>
                            <option>DKI Jakarta</option>
                            <option>Jawa Tengah</option>
                            <option>Jawa Timur</option>
                            <option>Jawa Barat</option>
                        </select>
                    </div>
                </div>
                <!-- Jenis Kelamin -->
                <div class="sm:col-span-2">
                    <label for="kelamin" class="block text-sm/6 font-medium text-sidebar_font">Jenis Kelamin</label>
                    <div class="mt-2">
                        <select id="kelamin" name="kelamin" autocomplete="kelamin" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                            <option disabled selected>Pilih Jenis Kelamin</option>
                            <option>Pria</option>
                            <option>Wanita</option>
                        </select>
                    </div>
                </div>
                <!-- Kode Pos -->
                <div class="sm:col-span-2">
                    <label for="kode_pos" class="block text-sm/6 font-medium text-sidebar_font">Kode Pos</label>
                    <div class="mt-2">
                        <input type="number" name="kode_pos" id="kode_pos" autocomplete="kode_pos" placeholder="Isikan Kode Pos"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- No HP -->
                <div class="sm:col-span-2">
                    <label for="no-hp" class="block text-sm/6 font-medium text-sidebar_font">No WhatsApp/Telp</label>
                    <div class="mt-2">
                        <input type="number" name="no_wa" id="no_wa" autocomplete="tanggal_lahir" placeholder="Isikan Nomor Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- No MET  -->
                <div class="sm:col-span-2">
                    <label for="no-met" class="block text-sm/6 font-medium text-sidebar_font">Nomor MET</label>
                    <div class="mt-2">
                        <input type="number" name="no_met" id="no_met" autocomplete="no_met" placeholder="Isikan Nomor MET Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- Email -->
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-medium text-sidebar_font">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" placeholder="Isikan Email Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- No Sertifikasi -->
                <div class="sm:col-span-2">
                    <label for="no-sertif" class="block text-sm/6 font-medium text-sidebar_font">Nomor Sertifikasi</label>
                    <div class="mt-2">
                        <input type="number" name="no_sertif" id="no_sertif" autocomplete="no_sertif" placeholder="Isikan Nomor Sertifikat Anda"
    class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black border border-border_input outline-1 placeholder-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6 placeholder:placeholder_input">
                    </div>
                </div>
                <!-- upload gambar -->
                <div class="mt-6 sm:col-span-2">
                    <label for="cover-photo" class="block text-sm/6 font-medium text-sidebar_font">Foto Formal</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-border_input px-6 py-10">
                        <div class="text-center">
                            <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm/6 text-gray-600">
                                <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-biru focus-within:ring-2 focus-within:ring-biru focus-within:ring-offset-1.5 focus-within:outline-hidden hover:text-biru">
                                    <span>Unggah gambar</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:col-span-2">
                    <label for="cover-photo" class="block text-sm/6 font-medium text-sidebar_font">Upload Tanda Tangan PNG</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-border_input px-6 py-10">
                        <div class="text-center">
                            <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                            </svg>
                            <div class="mt-4 flex text-sm/6 text-gray-600">

                                <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-biru focus-within:ring-2 focus-within:ring-biru focus-within:ring-offset-1.5 focus-within:outline-hidden hover:text-biru">
                                    <span>Unggah gambar</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" accept="image/png,image/jpeg,image/jpg">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                        </div>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const datepickerEl = document.getElementById('datepicker-autohide');
    new Datepicker(datepickerEl, {
      autohide: true,
      format: 'dd/mm/yyyy', // ⬅️ Ini format yang diinginkan
    });
    const form = document.getElementById('biodataForm');
    const message = document.getElementById('biodataMessage');
    // Replace with your API endpoint
    const apiUrl = '/api/biodata';

    // Fetch and populate form
    axios.get(apiUrl)
        .then(res => {
            const data = res.data.data || res.data;
            document.getElementById('nama-panjang').value = data.full_name || '';
            document.getElementById('email').value = data.email || '';
            // ...populate other fields similarly...
        })
        .catch(() => {});


        // Submit form via AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        message.textContent = 'Saving...';
        console.log('Form submitted');
        // const formData = new FormData(form);
        // axios.post(apiUrl, Object.fromEntries(formData))
        //     .then(res => {
        //         message.textContent = 'Biodata berhasil disimpan!';
        //         message.className = 'mt-4 text-green-600 text-sm';
        //     })
        //     .catch(err => {
        //         message.textContent = 'Gagal menyimpan biodata.';
        //         message.className = 'mt-4 text-red-600 text-sm';
        //     });
    });
});
</script>
@endpush
