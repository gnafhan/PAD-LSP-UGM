<?php

namespace Database\Seeders;

use App\Models\Skema;
use Illuminate\Database\Seeder;
use App\Models\Asesi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsesisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues during seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate the table first for clean seeding
        DB::table('asesi')->truncate();
        
        // Get the users by email to fetch their auto-generated IDs
        $yekaUser = User::where('email', 'yeka@email.com')->first();
        $sakuraUser = User::where('email', 'sakura@email.com')->first();
        $hiroUser = User::where('email', 'hiro@email.com')->first();

        // Get skema
        $skema1 = Skema::where('nomor_skema', 'SKM/0317/00010/2/2019/22')->first();
        $skema2 = Skema::where('nomor_skema', 'SKM/2988/00010/2/2021/34')->first();
        $skema3 = Skema::where('nomor_skema', 'SKM/3111/00010/2/2022/65')->first();
        
        // Check if users exist before proceeding
        if (!$yekaUser || !$sakuraUser || !$hiroUser) {
            throw new \Exception('Required users not found. Please run UsersSeeder first.');
        }
        
        // Predefined asesi data
        $predefinedAsesis = [
            [
                'id_user' => $yekaUser->id_user,
                'nama_asesi' => 'Yeka',
                'tempat_tanggal_lahir' => 'Sapporo, 26 Juni 2005',
                'jenis_kelamin' => 'Pria',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Spporo No. 20, Sapporo, Cianjur',
                'kota_domisili' => 'Sleman',
                'no_telp' => '089734567777',
                'no_telp_rumah' => null,
                'email' => 'yeka@email.com',
                'nim' => '23/76788/PA/22134',
                'file_sertifikat' => 'sertifikat_robin.pdf',
                'id_skema' => $skema1->id_skema,
                'file_kelengkapan_pemohon' => json_encode(['ktp_robin.png', 'foto_robin.png']),
                'ttd_pemohon' => 'ttd_robin.png',
                'status_pekerjaan' => 'Tidak bekerja',
                'nama_perusahaan' => 'PT. Tech Indo',
                'jabatan' => 'SE',
                'alamat_perusahaan' => 'Jalan Mangga Dua, Jakarta Selatan',
                'no_telp_perusahaan' => null,
            ],
            [
                'id_user' => $sakuraUser->id_user,
                'nama_asesi' => 'Sakura Yamamoto',
                'tempat_tanggal_lahir' => 'Tokyo, 14 Februari 2002',
                'jenis_kelamin' => 'Wanita',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Merapi No. 5, Jogja',
                'kota_domisili' => 'Yogyakarta',
                'no_telp' => '085678123456',
                'no_telp_rumah' => '0274123456',
                'email' => 'sakura@email.com',
                'nim' => '24/77889/PA/33156',
                'file_sertifikat' => 'sertifikat_sakura.pdf',
                'id_skema' => $skema2->id_skema,
                'file_kelengkapan_pemohon' => json_encode(['ktp_sakura.png', 'foto_sakura.png']),
                'ttd_pemohon' => 'ttd_sakura.png',
                'status_pekerjaan' => 'Tidak bekerja',
                'nama_perusahaan' => 'PT. Tech Indo',
                'jabatan' => 'SE',
                'alamat_perusahaan' => 'Jalan Mangga Dua, Jakarta Selatan',
                'no_telp_perusahaan' => null,
            ],
            [
                'id_user' => $hiroUser->id_user,
                'nama_asesi' => 'Hiro Tanaka',
                'tempat_tanggal_lahir' => 'Osaka, 12 Maret 1999',
                'jenis_kelamin' => 'Pria',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Merbabu No. 9, Semarang',
                'kota_domisili' => 'Semarang',
                'no_telp' => '087654321234',
                'no_telp_rumah' => null,
                'email' => 'hiro@email.com',
                'nim' => '22/66554/PA/11978',
                'file_sertifikat' => 'sertifikat_hiro.pdf',
                'id_skema' => $skema3->id_skema,
                'file_kelengkapan_pemohon' => json_encode(['ktp_hiro.png', 'foto_hiro.png']),
                'ttd_pemohon' => 'ttd_hiro.png',
                'status_pekerjaan' => 'Tidak bekerja',
                'nama_perusahaan' => 'PT. Tech Indo',
                'jabatan' => 'SE',
                'alamat_perusahaan' => 'Jalan Mangga Dua, Jakarta Selatan',
                'no_telp_perusahaan' => null,
            ],
        ];

        // Insert asesis using Asesi model to leverage auto-ID generation
        foreach ($predefinedAsesis as $asesiData) {
            Asesi::create($asesiData);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}