@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

    <div class="flex flex-wrap gap-2">
        <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
            <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
            FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
            </div>
    </div>

        <div class="flex flex-wrap gap-3 mt-5">
            <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI </h2>
        </div>
        <div id="message" class="text-center mt-4"></div>


        <!-- Progress Bar -->
        <div class="flex justify-between items-center mb-8">
        <!-- Update breadcrumb di sini -->
        <div class="flex items-center">
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
            <p class="text-sm text-gray-800 ml-2">Rincian Data Pemohon Sertifikasi</p>
        </div>

        <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
        <div class="flex items-center">
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">2</div>
            <p class="text-sm text-gray-800 ml-2">Data Sertifikasi</p>
        </div>

        <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
        <div class="flex items-center">
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">3</div>
            <p class="text-sm text-gray-800 ml-2">Bukti Kelengkapan Pemohon</p>
        </div>

        <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
        <div class="flex items-center">
            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">4</div>
            <p class="text-sm text-gray-800 ml-2">Konfirmasi Data Asesi</p>
        </div>

    </div>

        <!-- Form Card untuk Profil Peserta -->
        <div class="border border-gray-300 rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-4">Bagian 1 : Rincian Data Pemohon Sertifikasi</h2>
        <p class="text-sm mb-6">Pada bagian ini, cantumkan data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini.</p>

        <!-- Isi Form -->
        <div class="mb-4">
            <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" id="nama_user" name="nama_user" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
            <input type="text" id="nik" name="nik" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
            <input type="text" id="nim" name="nim" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="kota_domisili" class="block text-sm font-medium text-gray-700">Kota Domisili</label>
            <input type="text" id="kota_domisili" name="kota_domisili" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="tempat_tanggal_lahir" class="block text-sm font-medium text-gray-700">Tempat dan Tanggal Lahir</label>
            <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
            {{-- <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value=""> --}}
            <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="pria">Pria</option>
                <option value="wanita">Wanita</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="kebangsaan" class="block text-sm font-medium text-gray-700">Kebangsaan</label>
            <input type="text" id="kebangsaan" name="kebangsaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="alamat_rumah" class="block text-sm font-medium text-gray-700">Alamat Rumah</label>
            <input type="text" id="alamat_rumah" name="alamat_rumah" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" id="no_telp" name="no_telp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <div class="mb-4">
            <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="">
        </div>

        <!-- Button Kembali dan Selanjutnya -->
        <div class="flex justify-end">
        {{-- <a href="{{ route('sertifikasi') }}" id="btn-selanjutnya" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Selanjutnya</a> --}}
            <button type="button" id="btn-selanjutnya" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Selanjutnya</button>
        </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        // AJAX untuk menyimpan data sementara
        function saveDataPribadi() {
            const dataPribadi = {
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
            };

            $.ajax({
                url: '/save-data-pribadi',
                type: 'POST',
                data: dataPribadi,
                success: function(response) {
                    console.log('Data pribadi tersimpan sementara:', response);
                    window.location.href = "{{ route('sertifikasi') }}";
                },
                error: function(xhr, status, error) {
                    console.error('Error menyimpan data pribadi:', error);
                    $('#message').html('<p class="text-red-500">Gagal menyimpan data. Silakan coba lagi.</p>');
                }
            });
        }
        $('#btn-selanjutnya').on('click', function(event) {
            event.preventDefault();
            saveDataPribadi();
        });
    </script>
@endsection