<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asesi;

class AsesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_asesi' => 'Robin Minase',
                'tempat_tanggal_lahir' => 'Sapporo, 26 Juni 2005',
                'jenis_kelamin' => 'Pria',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Spporo No. 20, Sapporo, Cianjur',
                'kota_domisili' => 'Sleman',
                'no_telp' => '089734567777',
                'no_telp_rumah' => null,
                'email' => 'robinminase@gmail.com',
                'nim' => '23/76788/PA/22134',
                'id_user' => 'USER1',
                'file_sertifikat' => 'sertifikat_robin.pdf',
                'id_skema' => 'SKEMA1',
                'id_asesor' => 'ASESOR1',
                'file_kelengkapan_pemohon' => json_encode(['ktp_robin.png', 'foto_robin.png']),
                'ttd_pemohon' => 'ttd_robin.png',
            ],
            [
                'nama_asesi' => 'Sakura Yamamoto',
                'tempat_tanggal_lahir' => 'Tokyo, 14 Februari 2002',
                'jenis_kelamin' => 'Wanita',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Merapi No. 5, Jogja',
                'kota_domisili' => 'Yogyakarta',
                'no_telp' => '085678123456',
                'no_telp_rumah' => '0274123456',
                'email' => 'sakura.yamamoto@example.com',
                'nim' => '24/77889/PA/33156',
                'id_user' => 'USER2',
                'file_sertifikat' => 'sertifikat_sakura.pdf',
                'id_skema' => 'SKEMA2',
                'id_asesor' => 'ASESOR1',
                'file_kelengkapan_pemohon' => json_encode(['ktp_sakura.png', 'foto_sakura.png']),
                'ttd_pemohon' => 'ttd_sakura.png',
            ],
            [
                'nama_asesi' => 'Hiro Tanaka',
                'tempat_tanggal_lahir' => 'Osaka, 12 Maret 1999',
                'jenis_kelamin' => 'Pria',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Merbabu No. 9, Semarang',
                'kota_domisili' => 'Semarang',
                'no_telp' => '087654321234',
                'no_telp_rumah' => null,
                'email' => 'hiro.tanaka@example.com',
                'nim' => '22/66554/PA/11978',
                'id_user' => 'USER3',
                'file_sertifikat' => 'sertifikat_hiro.pdf',
                'id_skema' => 'SKEMA3',
                'id_asesor' => 'ASESOR2',
                'file_kelengkapan_pemohon' => json_encode(['ktp_hiro.png', 'foto_hiro.png']),
                'ttd_pemohon' => 'ttd_hiro.png',
            ],
        ];

        foreach ($data as $item) {
            Asesi::create($item);
        }
    }
}
