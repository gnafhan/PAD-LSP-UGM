<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AsesiPengajuan;

class AsesiPengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 'USER1',
                'id_skema' => 'SKEMA1',
                'nama_user' => 'Annisa Mutia Rahman',
                'nik' => '332256609074562',
                'nim' => '23/51678/SV/90874',
                'kota_domisili' => 'Depok',
                'tempat_tanggal_lahir' => 'Sukoharjo, 27 Juli 2005',
                'jenis_kelamin' => 'Wanita',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Tobi No 32 Semarang Jawa Tengah',
                'no_telp' => '0219875348809',
                'pendidikan_terakhir' => 'S1',
                'skema_sertifikasi' => 'Sertifikasi',
                'nama_skema' => 'Data science',
                'nomor_skema' => 'SKM/2323/987/09',
                'tujuan_asesmen' => 'Sertifikasi',
                'sumber_anggaran' => 'Beasiswa',
                'email' => 'annisa@example.com',
                'file_persyaratan_dasar_pemohon' => json_encode(['/bukti_pemohon/surat_ijazah.pdf', '/bukti_pemohon/surat_magang.pdf']),
                'file_administratif' => json_encode(['/bukti_pemohon/foto_ktp.png', '/bukti_pemohon/foto_3x4.png']),
                'ttd_pemohon' => 'ttd_annisa.png',
                'status_rekomendasi' => 'N/A',
            ],
        ];

        foreach ($data as $item) {
            AsesiPengajuan::create($item);
        }
    }
}
