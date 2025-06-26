<?php

namespace Database\Seeders;

use App\Models\Asesor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AsesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data asesor yang akan dibuat
        $data = [
            [
                'kode_registrasi' => 'R.57599.00.12.24',
                'nama_asesor' => 'Budi Santoso',
                'no_sertifikat' => 'SERT123456789',
                'no_hp' => '081234567890',
                'no_met' => 'MET12345',
                'email' => 'budi.santoso@mail.ugm.ac.id',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'budi.jpg',
                'no_ktp' => '3322145609087656',
                'jenis_kelamin' => 'Laki-laki',
                'kebangsaan' => 'Indonesia',
                'kode_pos' => '12345',
                'masa_berlaku' => '2025-12-31 23:59:59',
            ],
            [
                'kode_registrasi' => 'R.57600.01.01.25',
                'nama_asesor' => 'Siti Rahmawati',
                'no_sertifikat' => 'SERT987654321',
                'no_hp' => '082234567891',
                'no_met' => 'MET67890',
                'email' => 'siti.rahmawati@mail.ugm.ac.id',
                'alamat' => 'Jl. Merdeka No. 456, Bandung',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'siti.jpg',
                'no_ktp' => '3322145609081234',
                'jenis_kelamin' => 'Perempuan',
                'kebangsaan' => 'Indonesia',
                'kode_pos' => '45678',
                'masa_berlaku' => '2026-05-15 23:59:59',
            ],
            [
                'kode_registrasi' => 'R.57601.02.02.26',
                'nama_asesor' => 'Andi Prasetyo',
                'no_sertifikat' => 'SERT654987321',
                'no_hp' => '085234567892',
                'no_met' => 'MET23456',
                'email' => 'andi.prasetyo@mail.ugm.ac.id',
                'alamat' => 'Jl. Sudirman No. 789, Surabaya',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'andi.jpg',
                'no_ktp' => '3322145609084321',
                'jenis_kelamin' => 'Laki-laki',
                'kebangsaan' => 'Indonesia',
                'kode_pos' => '67890',
                'masa_berlaku' => '2027-04-20 23:59:59',
            ],
            [
                'kode_registrasi' => 'R.57602.03.03.27',
                'nama_asesor' => 'Fitriani Kurniawati',
                'no_sertifikat' => 'SERT123789654',
                'no_hp' => '089234567893',
                'no_met' => 'MET78901',
                'email' => 'fitriani.kurniawati@mail.ugm.ac.id',
                'alamat' => 'Jl. Kebon Jeruk No. 101, Jakarta',
                'status_asesor' => 'Aktif',
                'foto_asesor' => 'fitriani.jpg',
                'no_ktp' => '3322145609088765',
                'jenis_kelamin' => 'Perempuan',
                'kebangsaan' => 'Indonesia',
                'kode_pos' => '10111',
                'masa_berlaku' => '2026-11-30 23:59:59',
            ],
        ];

        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            foreach ($data as $item) {
                // Cek apakah user dengan email ini sudah ada
                $user = User::where('email', $item['email'])->first();
                
                // Jika belum ada, buat user baru dengan level asesor
                if (!$user) {
                    $user = User::create([
                        'name' => $item['nama_asesor'],
                        'email' => $item['email'],
                        'password' => Hash::make('password123'), // Password default
                        'no_hp' => $item['no_hp'],
                        'level' => 'asesor',
                    ]);
                } else {
                    // Jika user sudah ada, update levelnya menjadi asesor
                    $user->level = 'asesor';
                    $user->name = $item['nama_asesor'];
                    $user->save();
                }
                
                // Cek apakah asesor dengan email ini sudah ada
                $existingAsesor = Asesor::where('email', $item['email'])->first();
                
                if (!$existingAsesor) {
                    // Buat data asesor dengan menggunakan id_user dari user
                    Asesor::create(array_merge($item, [
                        'id_user' => $user->id_user
                    ]));
                }
            }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}