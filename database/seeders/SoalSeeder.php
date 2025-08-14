<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Soal;
use App\Models\Skema;

class SoalSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch skema by nomor_skema
        $skema1 = Skema::where('nomor_skema', 'SKM/0317/00010/2/2019/22')->first(); // Programmer
        $skema2 = Skema::where('nomor_skema', 'SKM/2988/00010/2/2021/34')->first(); // Backend Developer
        $skema3 = Skema::where('nomor_skema', 'SKM/3111/00010/2/2022/65')->first(); // Data Science

        $questions = [
            // Programmer
            $skema1->id_skema => [
                [
                    'pertanyaan' => 'Bahasa pemrograman manakah yang digunakan untuk membuat aplikasi Android secara native?',
                    'jawaban_a' => 'Python',
                    'jawaban_b' => 'Java',
                    'jawaban_c' => 'C#',
                    'jawaban_d' => 'Ruby',
                    'jawaban_e' => 'Go',
                    'jawaban_benar' => 'b',
                ],
                [
                    'pertanyaan' => 'Apa kepanjangan dari HTML?',
                    'jawaban_a' => 'HyperText Markup Language',
                    'jawaban_b' => 'Hyperlinks and Text Mark Language',
                    'jawaban_c' => 'Home Tool Markup Language',
                    'jawaban_d' => 'Hyper Transfer Markup Language',
                    'jawaban_e' => 'HighText Machine Language',
                    'jawaban_benar' => 'a',
                ],
                [
                    'pertanyaan' => 'Struktur data manakah yang menggunakan prinsip FIFO?',
                    'jawaban_a' => 'Stack',
                    'jawaban_b' => 'Array',
                    'jawaban_c' => 'Queue',
                    'jawaban_d' => 'Tree',
                    'jawaban_e' => 'Graph',
                    'jawaban_benar' => 'c',
                ],
                [
                    'pertanyaan' => 'Manakah yang merupakan bahasa pemrograman berparadigma fungsional?',
                    'jawaban_a' => 'Java',
                    'jawaban_b' => 'Haskell',
                    'jawaban_c' => 'C++',
                    'jawaban_d' => 'PHP',
                    'jawaban_e' => 'Assembly',
                    'jawaban_benar' => 'b',
                ],
                [
                    'pertanyaan' => 'Operator manakah yang digunakan untuk perbandingan identitas di PHP?',
                    'jawaban_a' => '==',
                    'jawaban_b' => '!=',
                    'jawaban_c' => '===',
                    'jawaban_d' => '!==',
                    'jawaban_e' => '<>',
                    'jawaban_benar' => 'c',
                ],
            ],

            // Backend Developer
            $skema2->id_skema => [
                [
                    'pertanyaan' => 'Framework backend manakah yang berbasis PHP?',
                    'jawaban_a' => 'Laravel',
                    'jawaban_b' => 'React',
                    'jawaban_c' => 'Angular',
                    'jawaban_d' => 'Vue.js',
                    'jawaban_e' => 'Svelte',
                    'jawaban_benar' => 'a',
                ],
                [
                    'pertanyaan' => 'Manakah protokol yang digunakan untuk transfer data di web?',
                    'jawaban_a' => 'FTP',
                    'jawaban_b' => 'SMTP',
                    'jawaban_c' => 'HTTP',
                    'jawaban_d' => 'SNMP',
                    'jawaban_e' => 'IMAP',
                    'jawaban_benar' => 'c',
                ],
                [
                    'pertanyaan' => 'Perintah SQL untuk mengambil data dari tabel adalah?',
                    'jawaban_a' => 'INSERT',
                    'jawaban_b' => 'UPDATE',
                    'jawaban_c' => 'DELETE',
                    'jawaban_d' => 'SELECT',
                    'jawaban_e' => 'ALTER',
                    'jawaban_benar' => 'd',
                ],
                [
                    'pertanyaan' => 'Jenis database manakah yang termasuk NoSQL?',
                    'jawaban_a' => 'MySQL',
                    'jawaban_b' => 'PostgreSQL',
                    'jawaban_c' => 'MongoDB',
                    'jawaban_d' => 'Oracle',
                    'jawaban_e' => 'MariaDB',
                    'jawaban_benar' => 'c',
                ],
                [
                    'pertanyaan' => 'Manakah yang merupakan metode HTTP untuk mengirim data?',
                    'jawaban_a' => 'GET',
                    'jawaban_b' => 'POST',
                    'jawaban_c' => 'PUT',
                    'jawaban_d' => 'PATCH',
                    'jawaban_e' => 'Semua benar',
                    'jawaban_benar' => 'e',
                ],
            ],

            // Data Science
            $skema3->id_skema => [
                [
                    'pertanyaan' => 'Bahasa pemrograman yang paling umum digunakan untuk analisis data adalah?',
                    'jawaban_a' => 'Python',
                    'jawaban_b' => 'JavaScript',
                    'jawaban_c' => 'C',
                    'jawaban_d' => 'Ruby',
                    'jawaban_e' => 'Swift',
                    'jawaban_benar' => 'a',
                ],
                [
                    'pertanyaan' => 'Manakah yang merupakan library Python untuk analisis data?',
                    'jawaban_a' => 'Pandas',
                    'jawaban_b' => 'NumPy',
                    'jawaban_c' => 'Scikit-learn',
                    'jawaban_d' => 'TensorFlow',
                    'jawaban_e' => 'Semua benar',
                    'jawaban_benar' => 'e',
                ],
                [
                    'pertanyaan' => 'Apa singkatan dari CSV?',
                    'jawaban_a' => 'Comma-Separated Values',
                    'jawaban_b' => 'Character-Separated Values',
                    'jawaban_c' => 'Common String Variables',
                    'jawaban_d' => 'Cell-Separated Values',
                    'jawaban_e' => 'Comma-Separated Variables',
                    'jawaban_benar' => 'a',
                ],
                [
                    'pertanyaan' => 'Metode pembelajaran mesin yang melibatkan label pada data disebut?',
                    'jawaban_a' => 'Unsupervised Learning',
                    'jawaban_b' => 'Supervised Learning',
                    'jawaban_c' => 'Reinforcement Learning',
                    'jawaban_d' => 'Deep Learning',
                    'jawaban_e' => 'Transfer Learning',
                    'jawaban_benar' => 'b',
                ],
                [
                    'pertanyaan' => 'Grafik yang paling tepat untuk melihat distribusi data adalah?',
                    'jawaban_a' => 'Histogram',
                    'jawaban_b' => 'Pie Chart',
                    'jawaban_c' => 'Line Chart',
                    'jawaban_d' => 'Scatter Plot',
                    'jawaban_e' => 'Bar Chart',
                    'jawaban_benar' => 'a',
                ],
            ],
        ];

        foreach ($questions as $id_skema => $soals) {
            foreach ($soals as $item) {
                Soal::create(array_merge(['id_skema' => $id_skema], $item));
            }
        }
    }
}
