@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Asesor - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Formulir Penambahan Asesor</h2>

        <!-- Form Tambah Asesor -->
        <form id="asesor-form" action="{{ route('admin.asesor.store') }}" method="POST">
            @csrf

            <!-- Grid Container untuk dua kolom -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- Bagian 1: Data Pribadi -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Bagian 1: Data Pribadi</h3>

                    <div class="mb-4">
                        <label for="kode-registrasi" class="block text-gray-700">Kode Registrasi:</label>
                        <input type="text" name="kode_registrasi" id="kode-registrasi" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: SKN-01" required>
                    </div>

                    <div class="mb-4">
                        <label for="nama-asesor" class="block text-gray-700">Nama Asesor:</label>
                        <input type="text" name="nama_asesor" id="nama-asesor" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: John Doe" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="no-sertifikat" class="block text-gray-700">No Sertifikat:</label>
                            <input type="text" name="no_sertifikat" id="no-sertifikat" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: 123456789" required>
                        </div>
                        <div>
                            <label for="no-hp" class="block text-gray-700">No HP:</label>
                            <input type="text" name="no_hp" id="no-hp" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: 081234567890" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email:</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: email@domain.com" required>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-gray-700">Alamat:</label>
                        <input type="text" name="alamat" id="alamat" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Jl. Merdeka No. 123" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tempat-lahir" class="block text-gray-700">Tempat Lahir:</label>
                            <input type="text" name="tempat_lahir" id="tempat-lahir" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Jakarta">
                        </div>
                        <div>
                            <label for="tanggal-lahir" class="block text-gray-700">Tanggal Lahir:</label>
                            <input type="date" name="tanggal_lahir" id="tanggal-lahir" class="w-full p-2 border-2 border-gray-500 rounded-md">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="jenis-kelamin" class="block text-gray-700">Jenis Kelamin:</label>
                            <select name="jenis_kelamin" id="jenis-kelamin" class="w-full p-2 border-2 border-gray-500 rounded-md" required>
                                <option value="">Pilih</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="kebangsaan" class="block text-gray-700">Kebangsaan:</label>
                            <input type="text" name="kebangsaan" id="kebangsaan" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Indonesia">
                        </div>
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="pendidikan-terakhir" class="block text-gray-700">Pendidikan Terakhir:</label>
                        <input type="text" name="pendidikan_terakhir" id="pendidikan-terakhir" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: S1 Teknik Informatika">
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="no-ktp" class="block text-gray-700">No KTP:</label>
                        <input type="text" id="no-ktp" name="no_ktp" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="33113456782" required>
                    </div>
                </div>

                <!-- Bagian 2: Informasi Institusi dan Keahlian -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Bagian 2: Informasi Institusi dan Keahlian</h3>

                    <div class="mb-4">
                        <label for="bidang" class="block text-gray-700">Bidang:</label>
                        <input type="text" name="bidang" id="bidang" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Teknologi Informasi" required>
                    </div>

                    <div class="mb-4">
                        <label for="status-asesor" class="block text-gray-700">Status Asesor:</label>
                        <input type="text" name="status_asesor" id="status-asesor" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Aktif" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="gelar-depan" class="block text-gray-700">Gelar Depan:</label>
                            <input type="text" name="gelar_depan" id="gelar-depan" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Dr." >
                        </div>
                        <div>
                            <label for="gelar-belakang" class="block text-gray-700">Gelar Belakang:</label>
                            <input type="text" name="gelar_belakang" id="gelar-belakang" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: M.T.">
                        </div>
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="keahlian" class="block text-gray-700">Keahlian:</label>
                        <input type="text" name="keahlian" id="keahlian" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Pengembangan Web">
                    </div>

                    <div class="mb-4">
                        <label for="institusi-asal" class="block text-gray-700">Institusi Asal:</label>
                        <input type="text" name="institusi_asal" id="institusi-asal" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: Universitas UGM">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="no-telp-institusi-asal" class="block text-gray-700">No Telp Institusi Asal:</label>
                            <input type="text" name="no_telp_institusi_asal" id="no-telp-institusi-asal" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: 0274-1234567">
                        </div>
                        <div>
                            <label for="fax-institusi-asal" class="block text-gray-700">Fax Institusi Asal:</label>
                            <input type="text" name="fax_institusi_asal" id="fax-institusi-asal" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: 0274-1234568">
                        </div>
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="email-institusi-asal" class="block text-gray-700">Email Institusi Asal:</label>
                        <input type="email" id="email-institusi-asal" name="email_institusi_asal" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh: ugm@gmail">
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="no-lisensi" class="block text-gray-700">No Lisensi:</label>
                        <input type="text" id="no-lisensi" name="no_lisensi" class="w-full p-2 border-2 border-gray-500 rounded-md" placeholder="Contoh:SK/22/55">
                    </div>

                    <div class="mb-4 mt-4">
                        <label for="masa-berlaku" class="block text-gray-700">Masa Berlaku:</label>
                        <input type="date" id="masa-berlaku" name="masa_berlaku" class="w-full p-2 border-2 border-gray-500 rounded-md">
                    </div>
                    

                </div>
            </div>

            <div class="text-center mt-8">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
