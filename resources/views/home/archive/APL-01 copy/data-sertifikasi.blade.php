@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')

<div class="min-h-screen bg-gray-100 flex items-center justify-center">
<div class="w-3/4 bg-white rounded-lg shadow-lg p-6">

    <div class="flex flex-wrap gap-2">
            <a href="/apl1/b1" class="bg-black hover:bg-gray-400 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">Kembali</a>
            <div class="bg-green-500 text-white px-2 py-1 rounded text-sm md:text-base flex-shrink-0">
            FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI
            </div>
    </div>

    <div class="flex flex-wrap gap-3 mt-5">
        <h2 class="text-lg font-semibold mb-4">FR.APL-01 FORMULIR PERMOHONAN SERTIFIKASI KOMPETENSI </h2>
    </div>

    <!-- Progress Bar -->
    <div class="flex justify-between items-center mb-8">
    <!-- Update breadcrumb di sini -->
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">1</div>
        <p class="text-sm text-gray-800 ml-2">Rincian Data Pemohon Sertifikasi</p>
    </div>

    <div class="flex-1 h-0.5 bg-gray-300 mx-2"></div>
    <div class="flex items-center">
        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-400 text-white">2</div>
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

    <div class="border border-gray-300 rounded-lg p-4">
        <h2 class="text-lg font-semibold mb-4">Bagian 2 : Data Sertifikasi</h2>
        <p class="text-sm mb-6">Tuliskan Judul dan Nomor Skema Sertifikasi, Tujuan Assesmen serta Daftar Unit Kompetensi sesuai kemasan pada skema sertifikasi yang Anda ajukan untuk mendapatkan pengakuan sesuai dengan latar belakang pendidikan, pelatihan serta pengalaman kerja yang Anda miliki.</p>

        <form id="sertifikasiForm" method="POST" action="{{ route('save.data.sertifikasi') }}">
        @csrf
        <!-- Certification Details -->
        <div class="border border-gray-300 rounded-lg p-4 mb-6">
            <div class="mb-4">
                <label for="skema_sertifikasi" class="block text-sm font-medium text-gray-700">Skema Sertifikasi</label>
                <select id="skema_sertifikasi" name="skema_sertifikasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="kkni">KKNI</option>
                    <option value="okupasi">Okupasi</option>
                    <option value="klaster">Klaster</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="skemaDropdown" class="block text-sm font-medium text-gray-700">Judul Skema Sertifikasi</label>
                <select id="skemaDropdown" name="skemaDropdown" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Skema</option>
                    @foreach($skemaList as $skema)
                        <option value="{{ $skema->nama_skema }}">{{ $skema->nama_skema }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nomorSkemaInput" class="block text-sm font-medium text-gray-700">Nomor Skema Sertifikasi</label>
                <input type="text" id="nomorSkemaInput" name="nomorSkemaInput" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="" readonly>
            </div>

            <div class="mb-4">
                <label for="tujuan_asesmen" class="block text-sm font-medium text-gray-700">Tujuan Assesmen</label>
                <select id="tujuan_asesmen" name="tujuan_asesmen" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="sertifikasi">Sertifikasi</option>
                    <option value="pkt">Pengakuan Kompetensi Terkini '(PKT)'</option>
                    <option value="rpl">Rekognisi Pembelajaran Lampau '(RPL)'</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
        </div>

        <!-- Competency Table -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Daftar Unit Kompetensi</h3>
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">No.</th>
                        <th class="border border-gray-300 p-2">Kode Unit</th>
                        <th class="border border-gray-300 p-2">Judul Unit</th>
                        <th class="border border-gray-300 p-2">Jenis Standar (Standar Khusus/Standar Internasional/SKKNI)</th>
                    </tr>
                </thead>
                <tbody id="ukTableBody">
                </tbody>
            </table>
        </div>

        <!-- Button Kembali dan Selanjutnya -->
        <div class="flex justify-end">
            {{-- <a href="{{ route('bukti') }}" id="btn-selanjutnya" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Selanjutnya</a> --}}
            <button type="submit" id="btn-selanjutnya" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">Selanjutnya</button>
        </div>
        </form>
    </div>
</div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            console.log("Script loaded");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $('#skemaDropdown').change(function() {
                var namaSkema = $(this).val();
                console.log("Nama Skema:", namaSkema);

                // AJAX untuk mendapatkan nomor skema dan tujuan asesmen berdasarkan nama skema
                $.get('/get-nomor-skema', { nama_skema: namaSkema }, function(response) {
                    console.log(response);
                    $('#nomorSkemaInput').val(response.nomor_skema || '');
                    $('#tujuan_asesmen').val(response.tujuan_asesmen || 'sertifikasi');
                });

                // AJAX untuk mendapatkan daftar UK berdasarkan skema
                $.get('/get-daftar-uk', { nama_skema: namaSkema }, function(response) {
                    console.log(response);

                    $('#ukTableBody').empty();

                    if (response.ukList.length > 0) {
                        response.ukList.forEach(function(uk, index) {
                            $('#ukTableBody').append(`
                                <tr>
                                    <td class="border border-gray-300 p-2 text-center">${index + 1}</td>
                                    <td class="border border-gray-300 p-2">${uk.id_uk}</td>
                                    <td class="border border-gray-300 p-2">${uk.nama_uk}</td>
                                    <td class="border border-gray-300 p-2">${uk.jenis_standar}</td>
                                </tr>
                            `);
                        });
                    }
                });
            });
            $('#sertifikasiForm').submit(function(event) {
            event.preventDefault();

            $.ajax({
                type: 'POST',
                url: "{{ route('save.data.sertifikasi') }}",
                data: JSON.stringify({
                    skema_sertifikasi: $('#skema_sertifikasi').val(),
                    skemaDropdown: $('#skemaDropdown').val(),
                    nomorSkemaInput: $('#nomorSkemaInput').val(),
                    tujuan_asesmen: $('#tujuan_asesmen').val(),
                }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Data sertifikasi berhasil disimpan:', response);
                    window.location.href = "{{ route('bukti') }}";
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan:', error);
                }
            });

        });

    });
    </script>
@endsection
