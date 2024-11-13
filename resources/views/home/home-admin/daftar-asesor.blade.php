@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Asesor - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Daftar Asesor</h2>

        <div class="mb-4 flex justify-start">
            <a href="/form" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Tambah Asesor</a>
        </div>

        <table class="min-w-full bg-white rounded-md shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-4 border-b text-left text-gray-600">Kode Registrasi</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">Nama Asesor</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">No Sertifikat</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">Email</th>
                    <th class="py-3 px-4 border-b text-left text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach([
                ['kode_registrasi' => 'REG001', 'nama_asesor' => 'John Doe', 'no_sertifikat' => 'SERT12345', 'email_asesor' => 'johndoe@example.com'],
                ['kode_registrasi' => 'REG002', 'nama_asesor' => 'Jane Smith', 'no_sertifikat' => 'SERT12346', 'email_asesor' => 'janesmith@example.com'],
                ['kode_registrasi' => 'REG003', 'nama_asesor' => 'Michael Brown', 'no_sertifikat' => 'SERT12347', 'email_asesor' => 'michaelb@example.com'],
                ['kode_registrasi' => 'REG004', 'nama_asesor' => 'Emily Davis', 'no_sertifikat' => 'SERT12348', 'email_asesor' => 'emilydavis@example.com'],
                ['kode_registrasi' => 'REG005', 'nama_asesor' => 'Chris Lee', 'no_sertifikat' => 'SERT12349', 'email_asesor' => 'chrislee@example.com'],
                ['kode_registrasi' => 'REG006', 'nama_asesor' => 'Sarah Wilson', 'no_sertifikat' => 'SERT12350', 'email_asesor' => 'sarahw@example.com'],
                ['kode_registrasi' => 'REG007', 'nama_asesor' => 'David Clark', 'no_sertifikat' => 'SERT12351', 'email_asesor' => 'davidclark@example.com'],
                ['kode_registrasi' => 'REG008', 'nama_asesor' => 'Jessica Johnson', 'no_sertifikat' => 'SERT12352', 'email_asesor' => 'jessicajohnson@example.com'],
                ['kode_registrasi' => 'REG009', 'nama_asesor' => 'Daniel Martinez', 'no_sertifikat' => 'SERT12353', 'email_asesor' => 'danielmartinez@example.com'],
                ['kode_registrasi' => 'REG010', 'nama_asesor' => 'Laura Garcia', 'no_sertifikat' => 'SERT12354', 'email_asesor' => 'lauragarcia@example.com']
            ] as $asesor)
                <tr class="hover:bg-gray-100 transition duration-200">
                    <td class="py-3 px-4 border-b">{{ $asesor['kode_registrasi'] }}</td>
                    <td class="py-3 px-4 border-b">{{ $asesor['nama_asesor'] }}</td>
                    <td class="py-3 px-4 border-b">{{ $asesor['no_sertifikat'] }}</td>
                    <td class="py-3 px-4 border-b">{{ $asesor['email_asesor'] }}</td>
                    <td class="py-3 px-4 border-b">
                        <a href="#" class="text-blue-500 hover:underline">Edit</a>
                        <form action="#" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline ml-4">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
