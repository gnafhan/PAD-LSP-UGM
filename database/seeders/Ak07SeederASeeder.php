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

        $data = [
            [
                'nama_kategori' => 'Keterbatasan Bahasa, Literasi, Numerasi',
                'deskripsi' => 'Keterbatasan asesi terhadap persyaratan bahasa, literasi, numerasi.',
                'opsi_penyesuaian' => [
                    'Memerlukan dukungan pembaca, penerjemah, pelayan, penulis untuk merekam jawaban asesi.',
                    'Melakukan asesmen verbal (gunakan pertanyaan lisan/pertanyaan wawancara) dengan dilengkapi gambar diagram dan bentuk-bentuk visual.',
                    'Menggunakan hasil produksi',
                    'Menggunakan ceklis observasi/demonstrasi.',
                    'Menggunakan daftar instruksi terstruktur.',
                ],
            ],
            [
                'nama_kategori' => 'Dukungan Pembaca/Penerjemah',
                'deskripsi' => 'Penyedia dukungan pembaca, penerjemah, pelayan, penulis.',
                'opsi_penyesuaian' => [
                    'Menggunakan pertanyaan lisan dengan dilengkapi gambar diagram dan bentuk-bentuk visual.',
                    'Menggunakan pertanyaan wawancara dengan dilengkapi gambar diagram dan bentuk-bentuk visual.',
                ],
            ],
            [
                'nama_kategori' => 'Teknologi Adaptif',
                'deskripsi' => 'Penggunaan teknologi adaptif atau peralatan khusus. (Tidak dapat menggunakan teknologi adaptif seperti komputer dan printer, peralatan digital dsb).',
                'opsi_penyesuaian' => [
                    'Ceklis observasi/demonstrasi.',
                    'Pertanyaan lisan',
                    'Pertanyaan tertulis.',
                    'Pertanyaan wawancara.',
                    'Daftar instruksi terstruktur.',
                    'Ceklis verifikasi portofolio.',
                    'Menggunakan dukungan operator komputer.',
                ],
            ],
            [
                'nama_kategori' => 'Fleksibilitas Waktu',
                'deskripsi' => 'Pelaksanaan asesmen secara fleksibel karena alasan keletihan atau keperluan pengobatan.',
                'opsi_penyesuaian' => [
                    'Menggunakan juru tulis.',
                    'Menggunakan kameramen perekam video/audio.',
                    'Memperbolehkan periode waktu yang lebih panjang untuk menyelesaikan tugas pekerjaan dalam asesmen.',
                    'Melakukan tugas pekerjaan dalam asesmen dengan waktu lebih pendek.',
                    'Menggunakan instruksi-instruksi spesifik pada proyek yang dapat dilakukan pada berbagai tingkatan.',
                ],
            ],
            [
                'nama_kategori' => 'Peralatan Khusus',
                'deskripsi' => 'Penyediaan peralatan asesmen berupa braille, audio/video-tape.',
                'opsi_penyesuaian' => [
                    'Menggunakan pertanyaan wawancara.',
                    'Menggunakan pertanyaan lisan.',
                ],
            ],
            [
                'nama_kategori' => 'Penyesuaian Lingkungan',
                'deskripsi' => 'Penyesuaian tempat fisik/lingkungan asesmen',
                'opsi_penyesuaian' => [
                    'Pertanyaan lisan.',
                    'Pertanyaan tulis.',
                    'Pertanyaan wawancara.',
                    'Ceklis verifikasi portofolio.',
                    'Ceklis review produk.',
                    'Daftar instruksi terstruktur.',
                ],
            ],
            [
                'nama_kategori' => 'Pertimbangan Umur/Gender',
                'deskripsi' => 'Pertimbangan umur/usia lanjut/gender asesi. (Adanya perbedaan usia dengan asesor yang lebih muda).',
                'opsi_penyesuaian' => [
                    'Menggunakan studi kasus/daftar instruksi terstruktur',
                    'Menggunakan instrumen asesmen dengan huruf normal jangan terlalu kecil.',
                    'Menggunakan asesor dengan jenis kelamin yang sama dengan asesi.',
                    'Menggunakan instrumen asesmen yang sama walaupun berbeda jenis kelamin (tidak boleh memberi tanda tambahan pada instrumen asesmen yang digunakan dengan tujuan untuk membedakan jenis kelamin).',
                ],
            ],
            [
                'nama_kategori' => 'Pertimbangan Budaya/Agama',
                'deskripsi' => 'Pertimbangan budaya/tradisi/agama.',
                'opsi_penyesuaian' => [
                    'Menggunakan studi kasus daftar instruksi terstruktur',
                    'Menggunakan asesor tanpa pertimbangan budaya/tradisi/agama.',
                    'Menggunakan instrumen asesmen yang sama walaupun berbeda budaya/tradisi/agama.',
                ],
            ],
        ];

        // Hapus data lama (opsional)
        // DB::table('ak07_seeder_a_s')->truncate();

        foreach ($data as $item) {
            DB::table('ak07_seeder_a_s')->insert([
                'nama_kategori' => $item['nama_kategori'],
                'deskripsi' => $item['deskripsi'],
                'opsi_penyesuaian' => json_encode($item['opsi_penyesuaian']),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
