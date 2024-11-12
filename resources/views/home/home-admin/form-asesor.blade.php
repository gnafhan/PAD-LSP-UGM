@extends('home.home-admin.layouts.layout')

@section('title', 'Tambah Asesor - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Tambah Asesor</h2>
        
        <!-- Form Tambah Asesor -->
        <form action="{{ route('admin.asesor.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="kode-registrasi" class="block text-gray-700">Kode Registrasi:</label>
                <input type="text" name="kode_registrasi" id="kode-registrasi" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="nama-asesor" class="block text-gray-700">Nama Asesor:</label>
                <input type="text" name="nama_asesor" id="nama-asesor" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="no-sertifikat" class="block text-gray-700">No Sertifikat:</label>
                <input type="text" name="no_sertifikat" id="no-sertifikat" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="no-hp" class="block text-gray-700">No HP:</label>
                <input type="text" name="no_hp" id="no-hp" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" name="email" id="email" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="alamat" class="block text-gray-700">Alamat:</label>
                <input type="text" name="alamat" id="alamat" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="bidang" class="block text-gray-700">Bidang:</label>
                <input type="text" name="bidang" id="bidang" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="status-asesor" class="block text-gray-700">Status Asesor:</label>
                <input type="text" name="status_asesor" id="status-asesor" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="gelar-depan" class="block text-gray-700">Gelar Depan:</label>
                <input type="text" name="gelar_depan" id="gelar-depan" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="gelar-belakang" class="block text-gray-700">Gelar Belakang:</label>
                <input type="text" name="gelar_belakang" id="gelar-belakang" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="no-ktp" class="block text-gray-700">No KTP:</label>
                <input type="text" name="no_ktp" id="no-ktp" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="jenis-kelamin" class="block text-gray-700">Jenis Kelamin:</label>
                <select name="jenis_kelamin" id="jenis-kelamin" class="w-full p-2 border rounded-md" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="pendidikan-terakhir" class="block text-gray-700">Pendidikan Terakhir:</label>
                <input type="text" name="pendidikan_terakhir" id="pendidikan-terakhir" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="keahlian" class="block text-gray-700">Keahlian:</label>
                <input type="text" name="keahlian" id="keahlian" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="tempat-lahir" class="block text-gray-700">Tempat Lahir:</label>
                <input type="text" name="tempat_lahir" id="tempat-lahir" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="tanggal-lahir" class="block text-gray-700">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" id="tanggal-lahir" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="kebangsaan" class="block text-gray-700">Kebangsaan:</label>
                <input type="text" name="kebangsaan" id="kebangsaan" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="no-lisensi" class="block text-gray-700">No Lisensi:</label>
                <input type="text" name="no_lisensi" id="no-lisensi" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="masa-berlaku" class="block text-gray-700">Masa Berlaku:</label>
                <input type="date" name="masa_berlaku" id="masa-berlaku" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="institusi-asal" class="block text-gray-700">Institusi Asal:</label>
                <input type="text" name="institusi_asal" id="institusi-asal" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="no-telp-institusi-asal" class="block text-gray-700">No Telp Institusi Asal:</label>
                <input type="text" name="no_telp_institusi_asal" id="no-telp-institusi-asal" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="fax-institusi-asal" class="block text-gray-700">Fax Institusi Asal:</label>
                <input type="text" name="fax_institusi_asal" id="fax-institusi-asal" class="w-full p-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label for="email-institusi-asal" class="block text-gray-700">Email Institusi Asal:</label>
                <input type="email" name="email_institusi_asal" id="email-institusi-asal" class="w-full p-2 border rounded-md">
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-green-500 text-white p-2 rounded-md">Simpan Asesor</button>
            </div>
        </form>
    </div>
</div>
@endsection
