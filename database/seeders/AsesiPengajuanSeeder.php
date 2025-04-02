<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AsesiPengajuan;
use App\Models\User;
use App\Models\Skema;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AsesiPengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraints issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate the table first for clean seeding
        DB::table('asesi_pengajuan')->truncate();
        
        // Create faker instance for generating realistic data
        $faker = Faker::create('id_ID');
        
        // Get users by email to fetch their auto-generated IDs
        $yekaUser = User::where('email', 'yeka@email.com')->first();
        $sakuraUser = User::where('email', 'sakura@email.com')->first();
        
        // Get skemas by name to fetch their auto-generated IDs
        $skemaProgrammer = Skema::where('nama_skema', 'Programmer')->first();
        $skemaBackend = Skema::where('nama_skema', 'Backend Developer')->first();
        $skemaDataScience = Skema::where('nama_skema', 'Data Science')->first();
        
        // Check if users and skemas exist before proceeding
        if (!$yekaUser || !$sakuraUser || !$skemaProgrammer || !$skemaBackend || !$skemaDataScience) {
            throw new \Exception('Required users or skemas not found. Please run UsersSeeder and SkemaSeeder first.');
        }
        
        // Create data with dynamic IDs
        $data = [
            [
                'id_user' => $yekaUser->id_user,
                'id_skema' => $skemaProgrammer->id_skema,
                'nama_user' => 'Yeka Nurfy',
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
                'nama_skema' => $skemaProgrammer->nama_skema,
                'nomor_skema' => $skemaProgrammer->nomor_skema,
                'tujuan_asesmen' => 'Sertifikasi',
                'sumber_anggaran' => 'Beasiswa',
                'email' => 'yeka@email.com',
                'file_kelengkapan_pemohon' => json_encode(['/bukti_pemohon/surat_ijazah.pdf', '/bukti_pemohon/surat_magang.pdf', '/bukti_pemohon/foto_ktp.png', '/bukti_pemohon/foto_3x4.png']),
                'ttd_pemohon' => 'ttd_yeka.png',
                'status_rekomendasi' => 'N/A',
                'status_pekerjaan' => 'Tidak bekerja',
                'nama_perusahaan' => 'PT. Tech Indo',
                'jabatan' => 'Junior Developer',
                'alamat_perusahaan' => 'Jalan Mangga Dua, Jakarta Selatan',
                'no_telp_perusahaan' => '0217539980',
            ],
            [
                'id_user' => $sakuraUser->id_user,
                'id_skema' => $skemaBackend->id_skema,
                'nama_user' => 'Sakura Yamamoto',
                'nik' => '332256609074563',
                'nim' => '24/77889/PA/33156',
                'kota_domisili' => 'Yogyakarta',
                'tempat_tanggal_lahir' => 'Tokyo, 14 Februari 2002',
                'jenis_kelamin' => 'Wanita',
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => 'Jalan Merapi No. 5, Jogja',
                'no_telp' => '085678123456',
                'pendidikan_terakhir' => 'S1',
                'skema_sertifikasi' => 'Sertifikasi',
                'nama_skema' => $skemaBackend->nama_skema,
                'nomor_skema' => $skemaBackend->nomor_skema,
                'tujuan_asesmen' => 'Sertifikasi',
                'sumber_anggaran' => 'Mandiri',
                'email' => 'sakura@email.com',
                'file_kelengkapan_pemohon' => json_encode(['/bukti_pemohon/surat_ijazah_sakura.pdf', '/bukti_pemohon/foto_ktp_sakura.png']),
                'ttd_pemohon' => 'ttd_sakura.png',
                'status_rekomendasi' => 'N/A',
                'status_pekerjaan' => 'Tidak bekerja',
                'nama_perusahaan' => null,
                'jabatan' => null,
                'alamat_perusahaan' => null,
                'no_telp_perusahaan' => null,
            ],
        ];

        // Add 10 more entries with a good distribution across skemas
        $skemaObjects = [
            $skemaProgrammer,
            $skemaBackend,
            $skemaDataScience
        ];
        
        $pendidikan = ['SMA/SMK', 'D3', 'S1', 'S2'];
        $status_pekerjaan = ['Bekerja', 'Tidak bekerja', 'Freelance'];
        $tujuan = ['Sertifikasi', 'Peningkatan Kompetensi', 'Persyaratan Kerja'];
        $sumber = ['Mandiri', 'Beasiswa', 'Perusahaan', 'Kampus'];
        
        // Get additional users beyond the first two
        $additionalUsers = User::where('level', 'asesi')
            ->whereNotIn('email', ['yeka@email.com', 'sakura@email.com', 'hiro@email.com'])
            ->take(10)
            ->get();
            
        $i = 0;
        foreach($additionalUsers as $user) {
            // Determine which skema to use, ensuring even distribution
            $skemaIndex = $i % 3;
            $skemaObj = $skemaObjects[$skemaIndex];
            
            // Random gender
            $gender = $faker->randomElement(['Pria', 'Wanita']);
            $firstName = $gender === 'Pria' ? $faker->firstNameMale : $faker->firstNameFemale;
            $lastName = $faker->lastName;
            $fullName = $firstName . ' ' . $lastName;
            
            // Generate a realistic birth date and place
            $birthDate = $faker->dateTimeBetween('-30 years', '-20 years')->format('d-m-Y');
            $birthPlace = $faker->city;
            $birthInfo = $birthPlace . ', ' . $birthDate;
            
            // Generate NIM with realistic format for UGM
            $year = rand(19, 23);
            $faculty = rand(10000, 99999);
            $nim = $year . '/' . $faculty . '/SV/' . rand(10000, 99999);
            
            // Randomly decide if this person is working
            $isWorking = $faker->randomElement($status_pekerjaan);
            
            // Company details (only filled if working)
            $companyName = $isWorking === 'Bekerja' ? 'PT. ' . $faker->company : null;
            $jobTitle = $isWorking === 'Bekerja' ? $faker->jobTitle : null;
            $companyAddress = $isWorking === 'Bekerja' ? $faker->address : null;
            $companyPhone = $isWorking === 'Bekerja' ? $faker->phoneNumber : null;
            
            $data[] = [
                'id_user' => $user->id_user,
                'id_skema' => $skemaObj->id_skema,
                'nama_user' => $fullName,
                'nik' => $faker->nik,
                'nim' => $nim,
                'kota_domisili' => $faker->city,
                'tempat_tanggal_lahir' => $birthInfo,
                'jenis_kelamin' => $gender,
                'kebangsaan' => 'Indonesia',
                'alamat_rumah' => $faker->address,
                'no_telp' => $faker->phoneNumber,
                'pendidikan_terakhir' => $faker->randomElement($pendidikan),
                'skema_sertifikasi' => 'Sertifikasi',
                'nama_skema' => $skemaObj->nama_skema,
                'nomor_skema' => $skemaObj->nomor_skema,
                'tujuan_asesmen' => $faker->randomElement($tujuan),
                'sumber_anggaran' => $faker->randomElement($sumber),
                'email' => $user->email,
                'file_kelengkapan_pemohon' => json_encode([
                    '/bukti_pemohon/ijazah_' . $i . '.pdf', 
                    '/bukti_pemohon/ktp_' . $i . '.png',
                    '/bukti_pemohon/foto_' . $i . '.jpg'
                ]),
                'ttd_pemohon' => 'ttd_' . strtolower($firstName) . '.png',
                'status_rekomendasi' => 'N/A',
                'status_pekerjaan' => $isWorking,
                'nama_perusahaan' => $companyName,
                'jabatan' => $jobTitle,
                'alamat_perusahaan' => $companyAddress,
                'no_telp_perusahaan' => $companyPhone,
            ];
            $i++;
        }

        // Insert data using model creation to leverage boot method for ID generation
        foreach ($data as $item) {
            AsesiPengajuan::create($item);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}