@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

            <div class="flex flex-wrap gap-2 items-center">
                <a href="/assesi" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
                    Kembali
                </a>
                <div class="bg-green-500 text-white px-2 py-1 rounded text-xs sm:text-sm md:text-base lg:text-lg text-center w-full md:w-auto">
                    FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
                </div>

            </div>
                <div class="flex flex-wrap gap-3 mt-5">
                    <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI</h2>
                </div>
                <div id="message" class="text-center mt-4"></div>
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

                <!-- Form Card untuk Profil Peserta -->
            <form class="border border-gray-300 rounded-lg p-4" readonly disabled>
                @csrf
                <h2 class="text-lg font-semibold mb-4">Bagian 1 : Rincian Data Pemohon Sertifikasi</h2>
                <p class="text-sm mb-6">Pada bagian ini, cantumkan data pribadi, data pendidikan formal serta data pekerjaan anda pada saat ini.</p>
                <!-- Bagian 1: Rincian Data Pemohon Sertifikasi -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Bagian 1: Rincian Data Pemohon Sertifikasi</h2>

                    <!-- Data Pribadi -->
                    <h3 class="text-lg font-semibold mb-2">a. Data Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Nama Lengkap</label>
                            <input type="text" value="{{ $asesiPengajuan->nama_user }}" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">No. KTP/NIK/Paspor</label>
                            <input type="text" value="{{ $asesiPengajuan->nik }}" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Tempat / Tgl. Lahir</label>
                            <input type="text" value="{{ $asesiPengajuan->tempat_tanggal_lahir }}" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Jenis Kelamin</label>
                            <input type="text" value="{{ $asesiPengajuan->jenis_kelamin }}" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Kebangsaan</label>
                            <input type="text" value="{{ $asesiPengajuan->kebangsaan }}" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Alamat Rumah</label>
                            <input type="text" value="{{ $asesiPengajuan->alamat_rumah }}" class="w-full p-2 border rounded-md" />
                        </div>
                        {{-- <div>
                            <label class="block text-gray-700">Kode Pos</label>
                            <input type="text" value="{{  }}" class="w-full p-2 border rounded-md" />
                        </div> --}}
                        <div>
                            <label class="block text-gray-700">No. Telepon / E-mail</label>
                            <input type="text" value="{{ $asesiPengajuan->no_telp }}" class="w-full p-2 border rounded-md" />
                        </div>
                        {{-- <div>
                            <label class="block text-gray-700">Kualifikasi Pendidikan</label>
                            <input type="text" value="S1 Teknik Informatika" class="w-full p-2 border rounded-md" />
                        </div> --}}
                    </div>

                    <!-- Data Pekerjaan Sekarang -->
                    <h3 class="text-lg font-semibold mt-6 mb-2">b. Data Pekerjaan Sekarang</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700">Nama Institusi / Perusahaan</label>
                            <input type="text" value="PT Teknologi Indonesia" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Jabatan</label>
                            <input type="text" value="Software Developer" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Alamat Kantor</label>
                            <input type="text" value="Jl. Sudirman No. 10, Jakarta" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">Kode Pos</label>
                            <input type="text" value="10220" class="w-full p-2 border rounded-md" />
                        </div>
                        <div>
                            <label class="block text-gray-700">No. Telp/Fax/E-mail</label>
                            <input type="text" value="02112345678 / info@teknologi.com" class="w-full p-2 border rounded-md" />
                        </div>
                    </div>
                </div>

                <!-- Isi Form
                <div class="mb-4">
                    <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="nama_user" name="nama_user" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="Belda Putri Pramono" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" id="nik" name="nik" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="1234567890123456" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="nim" name="nim" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="23/519666/SV/23155" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="kota_domisili" class="block text-sm font-medium text-gray-700">Kota Domisili</label>
                    <input type="text" id="kota_domisili" name="kota_domisili" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="Yogyakarta" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="tempat_tanggal_lahir" class="block text-sm font-medium text-gray-700">Tempat dan Tanggal Lahir</label>
                    <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="Yogyakarta, 01 Januari 2000" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm" readonly disabled>
                        <option value="pria">Pria</option>
                        <option value="wanita">Wanita</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="kebangsaan" class="block text-sm font-medium text-gray-700">Kebangsaan</label>
                    <input type="text" id="kebangsaan" name="kebangsaan" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="Indonesia" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="alamat_rumah" class="block text-sm font-medium text-gray-700">Alamat Rumah</label>
                    <input type="text" id="alamat_rumah" name="alamat_rumah" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="Jl. Merdeka No. 10, Yogyakarta" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="no_telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="081234567890" readonly disabled>
                </div>

                <div class="mb-4">
                    <label for="pendidikan_terakhir" class="block text-sm font-medium text-gray-700">Pendidikan Terakhir</label>
                    <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="mt-1 block w-full rounded-md border border-gray-400 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="" placeholder="Sarjana Teknik Informatika" readonly  disabled>
                </div> -->

                <!-- Button Kembali dan Selanjutnya -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Selanjutnya</button>
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
