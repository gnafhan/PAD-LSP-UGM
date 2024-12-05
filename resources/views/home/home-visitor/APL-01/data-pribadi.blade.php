@extends('home.home-visitor.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

                <div class="flex flex-wrap gap-2">
                    <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0 flex items-center">
                        <i class="fas fa-arrow-left"></i> <!-- Ikon Font Awesome -->
                    </a>
                    <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                        FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 mt-5">
                    <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI</h2>
                </div>

                <!-- Progress Bar -->
                    <div class="w-full max-w-4xl mx-auto px-4">
                        <div class="flex flex-col md:flex-row justify-start items-start mb-8">
                            <!-- Step 1 -->
                            <div class="flex items-center mb-4 md:mb-0 md:w-auto">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
                                <p class="text-sm text-gray-800 ml-2">Rincian Data Pemohon Sertifikasi</p>
                            </div>

                            <!-- Garis Penghubung (dihide di tampilan kecil) -->
                            <div class="hidden md:block flex-1 h-0.5 bg-gray-300 mx-2"></div>

                            <!-- Step 2 -->
                            <div class="flex items-center mb-4 md:mb-0 md:w-auto">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">2</div>
                                <p class="text-sm text-gray-800 ml-2">Data Sertifikasi</p>
                            </div>

                            <!-- Garis Penghubung (dihide di tampilan kecil) -->
                            <div class="hidden md:block flex-1 h-0.5 bg-gray-300 mx-2"></div>

                            <!-- Step 3 -->
                            <div class="flex items-center mb-4 md:mb-0 md:w-auto">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">3</div>
                                <p class="text-sm text-gray-800 ml-2">Bukti Kelengkapan Pemohon</p>
                            </div>

                            <!-- Garis Penghubung (dihide di tampilan kecil) -->
                            <div class="hidden md:block flex-1 h-0.5 bg-gray-300 mx-2"></div>

                            <!-- Step 4 -->
                            <div class="flex items-center">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-300 text-white">4</div>
                                <p class="text-sm text-gray-800 ml-2">Konfirmasi Data Asesi</p>
                            </div>
                        </div>
                    </div>

                <div id="message" class="text-center mt-4"></div>

                <!-- Form Card untuk Profil Peserta -->
                <form action="{{ route('sertifikasi') }}" method="POST" class="rounded-lg p-4">
                @csrf
                <h2 class="text-lg font-semibold mb-4">Bagian 1 : Rincian Data Pemohon Sertifikasi</h2>
                <p class="text-sm mb-6">Pada bagian ini, cantumkan data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini.</p>

                Isi Form
                <div class="mb-4">
                    <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="nama_user" name="nama_user" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('nama_user') }}" placeholder="Belda Putri Pramono">
                </div>

                <div class="mb-4">
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" id="nik" name="nik" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('nik') }}" placeholder="1234567890123456">
                </div>

                <div class="mb-4">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('nim') }}" placeholder="123456789">
                </div>

                <div class="mb-4">
                    <label for="kota_domisili" class="block text-sm font-medium text-gray-700">Kota Domisili</label>
                    <input type="text" id="kota_domisili" name="kota_domisili" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('kota_domisili') }}" placeholder="Yogyakarta">
                </div>

                <div class="mb-4">
                    <label for="tempat_tanggal_lahir" class="block text-sm font-medium text-gray-700">Tempat dan Tanggal Lahir</label>
                    <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('tempat_tanggal_lahir') }}" placeholder="Yogyakarta, 01 Januari 2000">
                </div>

                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm">
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="kebangsaan" class="block text-sm font-medium text-gray-700">Kebangsaan</label>
                    <input type="text" id="kebangsaan" name="kebangsaan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('kebangsaan') }}" placeholder="Indonesia">
                </div>

                <div class="mb-4">
                    <label for="alamat_rumah" class="block text-sm font-medium text-gray-700">Alamat Rumah</label>
                    <input type="text" id="alamat_rumah" name="alamat_rumah" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('alamat_rumah') }}" placeholder="Jl. Merdeka No. 10, Yogyakarta">
                </div>

                <div class="mb-4">
                    <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('no_telp') }}" placeholder="081234567890">
                </div>

                <div class="mb-4">
                    <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                    <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('pendidikan_terakhir') }}" placeholder="Sarjana Teknik Informatika">
                </div>

                <!-- Bagian Data Pekerjaan Sekarang -->
                <h3 class="text-lg font-semibold mb-4">Bagian 2: Data Pekerjaan Sekarang</h3>
                <div class="mb-4">
                    <label for="status_pekerjaan" class="block text-sm font-medium text-gray-700">Status Pekerjaan</label>
                    <select id="status_pekerjaan" name="status_pekerjaan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm">
                        <option value="Bekerja">Bekerja</option>
                        <option value="Tidak Bekerja">Tidak Bekerja</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                    <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('nama_perusahaan') }}" placeholder="PT. Tech Innovators">
                </div>

                <div class="mb-4">
                    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('jabatan') }}" placeholder="Software Engineer">
                </div>

                <div class="mb-4">
                    <label for="alamat_perusahaan" class="block text-sm font-medium text-gray-700">Alamat Perusahaan</label>
                    <input type="text" id="alamat_perusahaan" name="alamat_perusahaan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('alamat_perusahaan') }}" placeholder="Jl. Teknologi No. 20, Jakarta">
                </div>

                <div class="mb-4">
                    <label for="no_telp_perusahaan" class="block text-sm font-medium text-gray-700">Nomor Telepon Perusahaan</label>
                    <input type="text" id="no_telp_perusahaan" name="no_telp_perusahaan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('no_telp_perusahaan') }}" placeholder="0211234567">
                </div>

                <!-- Tombol Submit -->
                <div class="mt-6 text-right">
                    <button type="submit" id="btn-selanjutnya" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Kirim</button>
                </div>

                </form>
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
                status_pekerjaan: $('#status_pekerjaan').val(),
                nama_perusahaan: $('#nama_perusahaan').val(),
                jabatan: $('#jabatan').val(),
                alamat_perusahaan: $('#alamat_perusahaan').val(),
                no_telp_perusahaan: $('#no_telp_perusahaan').val(),
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
                    if (xhr.status === 422) {
                        // Jika ada error validasi, tampilkan pesan error yang sesuai
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '<ul class="text-red-500">';
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += `<li>${errors[key][0]}</li>`;
                            }
                        }
                        errorMessage += '</ul>';
                        $('#message').html(errorMessage);
                    } else {
                        // Error lainnya
                        console.error('Error menyimpan data pribadi:', error);
                        $('#message').html('<p class="text-red-500">Gagal menyimpan data. Silakan coba lagi.</p>');
                    }
                }
            });
        }
        $('#btn-selanjutnya').on('click', function(event) {
            event.preventDefault();
            saveDataPribadi();
        });
    </script>
@endsection
