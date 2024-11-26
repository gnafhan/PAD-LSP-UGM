<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asesor;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_registrasi' => 'R.57599.00.12.24',
                'nama_asesor' => 'Budi Santoso',
                'no_sertifikat' => 'SERT123456789',
                'no_hp' => '081234567890',
                'email' => 'budi.santoso@example.com',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'bidang' => 'Teknik Informatika',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'budi.jpg',
                'gelar_depan' => 'Dr.',
                'gelar_belakang' => 'M.T.',
                'no_ktp' => '3322145609087656',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S2',
                'keahlian' => 'Pemrograman, Database',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-07-21 00:00:00',
                'kebangsaan' => 'Indonesia',
                'no_lisensi' => 'LIS-9876543210',
                'masa_berlaku' => '2025-12-31 23:59:59',
                'institusi_asal' => 'Universitas Gadjah Mada',
                'no_telp_institusi_asal' => '0211234567',
                'fax_institusi_asal' => '0217654321',
                'email_institusi_asal' => 'ugm@mail.ugm.ac.id'
            ],
            [
                'kode_registrasi' => 'R.57600.01.01.25',
                'nama_asesor' => 'Siti Rahmawati',
                'no_sertifikat' => 'SERT987654321',
                'no_hp' => '082234567891',
                'email' => 'siti.rahmawati@example.com',
                'alamat' => 'Jl. Merdeka No. 456, Bandung',
                'bidang' => 'Manajemen',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'siti.jpg',
                'gelar_depan' => 'Ir.',
                'gelar_belakang' => 'M.M.',
                'no_ktp' => '3322145609081234',
                'jenis_kelamin' => 'Wanita',
                'pendidikan_terakhir' => 'S2',
                'keahlian' => 'Manajemen Sumber Daya Manusia, Kepemimpinan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1983-11-30 00:00:00',
                'kebangsaan' => 'Indonesia',
                'no_lisensi' => 'LIS-9876543211',
                'masa_berlaku' => '2026-05-15 23:59:59',
                'institusi_asal' => 'Universitas Padjadjaran',
                'no_telp_institusi_asal' => '0221234567',
                'fax_institusi_asal' => '0227654321',
                'email_institusi_asal' => 'unpad@mail.unpad.ac.id'
            ],
            [
                'kode_registrasi' => 'R.57601.02.02.26',
                'nama_asesor' => 'Andi Prasetyo',
                'no_sertifikat' => 'SERT654987321',
                'no_hp' => '085234567892',
                'email' => 'andi.prasetyo@example.com',
                'alamat' => 'Jl. Sudirman No. 789, Surabaya',
                'bidang' => 'Teknik Elektro',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'andi.jpg',
                'gelar_depan' => 'Dr.',
                'gelar_belakang' => 'ST., M.Eng.',
                'no_ktp' => '3322145609084321',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S3',
                'keahlian' => 'Elektronika, Telekomunikasi',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1980-09-14 00:00:00',
                'kebangsaan' => 'Indonesia',
                'no_lisensi' => 'LIS-9876543212',
                'masa_berlaku' => '2027-04-20 23:59:59',
                'institusi_asal' => 'Institut Teknologi Sepuluh Nopember',
                'no_telp_institusi_asal' => '0311234567',
                'fax_institusi_asal' => '0317654321',
                'email_institusi_asal' => 'its@mail.its.ac.id'
            ],
            [
                'kode_registrasi' => 'R.57602.03.03.27',
                'nama_asesor' => 'Fitriani Kurniawati',
                'no_sertifikat' => 'SERT123789654',
                'no_hp' => '089234567893',
                'email' => 'fitriani.kurniawati@example.com',
                'alamat' => 'Jl. Kebon Jeruk No. 101, Jakarta',
                'bidang' => 'Pemasaran',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'fitriani.jpg',
                'gelar_depan' => 'S.E.',
                'gelar_belakang' => 'M.M.',
                'no_ktp' => '3322145609088765',
                'jenis_kelamin' => 'Wanita',
                'pendidikan_terakhir' => 'S2',
                'keahlian' => 'Pemasaran Digital, Manajemen Bisnis',
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '1987-05-25 00:00:00',
                'kebangsaan' => 'Indonesia',
                'no_lisensi' => 'LIS-9876543213',
                'masa_berlaku' => '2026-11-30 23:59:59',
                'institusi_asal' => 'Universitas Sumatera Utara',
                'no_telp_institusi_asal' => '0611234567',
                'fax_institusi_asal' => '0617654321',
                'email_institusi_asal' => 'usu@mail.usu.ac.id'
            ],
        ];

        foreach ($data as $item) {
            Asesor::create($item);
        }
    }
}
