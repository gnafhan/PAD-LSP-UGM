<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Ak07SeederASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Seed kategori modifikasi
        $kategoriModifikasi = [
            [
                'id' => 1,
                'nama_kategori' => 'Keterbatasan Bahasa, Literasi, Numerasi',
                'deskripsi' => 'Keterbatasan asesi terhadap persyaratan bahasa, literasi, numerasi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'nama_kategori' => 'Dukungan Pembaca/Penerjemah',
                'deskripsi' => 'Penyedia dukungan pembaca, penerjemah, pelayan, penulis.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'nama_kategori' => 'Teknologi Adaptif',
                'deskripsi' => 'Penggunaan teknologi adaptif atau peralatan khusus. (Tidak dapat menggunakan teknologi adaptif seperti komputer dan printer, peralatan digital dsb).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'nama_kategori' => 'Fleksibilitas Waktu',
                'deskripsi' => 'Pelaksanaan asesmen secara fleksibel karena alasan keletihan atau keperluan pengobatan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'nama_kategori' => 'Peralatan Khusus',
                'deskripsi' => 'Penyediaan peralatan asesmen berupa braille, audio/video-tape.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'nama_kategori' => 'Penyesuaian Lingkungan',
                'deskripsi' => 'Penyesuaian tempat fisik/lingkungan asesmen',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 7,
                'nama_kategori' => 'Pertimbangan Umur/Gender',
                'deskripsi' => 'Pertimbangan umur/usia lanjut/gender asesi. (Adanya perbedaan usia dengan asesor yang lebih muda).',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 8,
                'nama_kategori' => 'Pertimbangan Budaya/Agama',
                'deskripsi' => 'Pertimbangan budaya/tradisi/agama.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('ak07_seeder_a_s')->insert($kategoriModifikasi);

        // Seed opsi penyesuaian
        $opsiPenyesuaian = [
            // Kategori 1: Keterbatasan Bahasa, Literasi, Numerasi
            [
                'ak07_seeder_a_s_id' => 1,
                'deskripsi_opsi' => 'Memerlukan dukungan pembaca, penerjemah, pelayan, penulis untuk merekam jawaban asesi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 1,
                'deskripsi_opsi' => 'Melakukan asesmen verbal (gunakan pertanyaan lisan/pertanyaan wawancara) dengan dilengkapi gambar diagram dan bentuk-bentuk visual.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 1,
                'deskripsi_opsi' => 'Menggunakan hasil produksi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 1,
                'deskripsi_opsi' => 'Menggunakan ceklis observasi/demonstrasi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 1,
                'deskripsi_opsi' => 'Menggunakan daftar instruksi terstruktur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 2: Dukungan Pembaca/Penerjemah
            [
                'ak07_seeder_a_s_id' => 2,
                'deskripsi_opsi' => 'Menggunakan pertanyaan lisan dengan dilengkapi gambar diagram dan bentuk-bentuk visual.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 2,
                'deskripsi_opsi' => 'Menggunakan pertanyaan wawancara dengan dilengkapi gambar diagram dan bentuk-bentuk visual.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 3: Teknologi Adaptif
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Ceklis observasi/demonstrasi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Pertanyaan lisan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Pertanyaan tertulis.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Pertanyaan wawancara.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Daftar instruksi terstruktur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Ceklis verifikasi portofolio.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 3,
                'deskripsi_opsi' => 'Menggunakan dukungan operator komputer.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 4: Fleksibilitas Waktu
            [
                'ak07_seeder_a_s_id' => 4,
                'deskripsi_opsi' => 'Menggunakan juru tulis.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 4,
                'deskripsi_opsi' => 'Menggunakan kameramen perekam video/audio.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 4,
                'deskripsi_opsi' => 'Memperbolehkan periode waktu yang lebih panjang untuk menyelesaikan tugas pekerjaan dalam asesmen.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 4,
                'deskripsi_opsi' => 'Melakukan tugas pekerjaan dalam asesmen dengan waktu lebih pendek.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 4,
                'deskripsi_opsi' => 'Menggunakan instruksi-instruksi spesifik pada proyek yang dapat dilakukan pada berbagai tingkatan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 5: Peralatan Khusus
            [
                'ak07_seeder_a_s_id' => 5,
                'deskripsi_opsi' => 'Menggunakan pertanyaan wawancara.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 5,
                'deskripsi_opsi' => 'Menggunakan pertanyaan lisan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 6: Penyesuaian Lingkungan
            [
                'ak07_seeder_a_s_id' => 6,
                'deskripsi_opsi' => 'Pertanyaan lisan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 6,
                'deskripsi_opsi' => 'Pertanyaan tulis.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 6,
                'deskripsi_opsi' => 'Pertanyaan wawancara.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 6,
                'deskripsi_opsi' => 'Ceklis verifikasi portofolio.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 6,
                'deskripsi_opsi' => 'Ceklis review produk.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 6,
                'deskripsi_opsi' => 'Daftar instruksi terstruktur.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 7: Pertimbangan Umur/Gender
            [
                'ak07_seeder_a_s_id' => 7,
                'deskripsi_opsi' => 'Menggunakan studi kasus/daftar instruksi terstruktur',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 7,
                'deskripsi_opsi' => 'Menggunakan instrumen asesmen dengan huruf normal jangan terlalu kecil.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 7,
                'deskripsi_opsi' => 'Menggunakan asesor dengan jenis kelamin yang sama dengan asesi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 7,
                'deskripsi_opsi' => 'Menggunakan instrumen asesmen yang sama walaupun berbeda jenis kelamin (tidak boleh memberi tanda tambahan pada instrumen asesmen yang digunakan dengan tujuan untuk membedakan jenis kelamin).',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Kategori 8: Pertimbangan Budaya/Agama
            [
                'ak07_seeder_a_s_id' => 8,
                'deskripsi_opsi' => 'Menggunakan studi kasus daftar instruksi terstruktur',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 8,
                'deskripsi_opsi' => 'Menggunakan asesor tanpa pertimbangan budaya/tradisi/agama.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'ak07_seeder_a_s_id' => 8,
                'deskripsi_opsi' => 'Menggunakan instrumen asesmen yang sama walaupun berbeda budaya/tradisi/agama.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('opsi_penyesuaian')->insert($opsiPenyesuaian);

    }
}
