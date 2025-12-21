<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skema;
use App\Models\Soal;
use App\Models\IA02Template;
use App\Models\IA07Question;
use App\Models\UK;
use App\Models\ElemenUK;

/**
 * SchemeContentSeeder
 * 
 * Seeds sample content for assessment instruments per scheme:
 * - IA05: Multiple choice questions (Soal)
 * - IA02: Work instruction templates (IA02Template)
 * - IA07: Oral questions (IA07Question)
 * 
 * Requirements: 1.1, 2.1, 3.1
 */
class SchemeContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedIA05Questions();
        $this->seedIA02Templates();
        $this->seedIA07Questions();
    }

    /**
     * Seed IA05 multiple choice questions for existing schemes.
     * Requirements: 1.1
     */
    private function seedIA05Questions(): void
    {
        // Fetch existing schemes
        $skema1 = Skema::where('nomor_skema', 'SKM/0317/00010/2/2019/22')->first(); // Programmer
        $skema2 = Skema::where('nomor_skema', 'SKM/2988/00010/2/2021/34')->first(); // Backend Developer
        $skema3 = Skema::where('nomor_skema', 'SKM/3111/00010/2/2022/65')->first(); // Data Science

        if (!$skema1 || !$skema2 || !$skema3) {
            $this->command->warn('Some schemes not found. Skipping IA05 seeding.');
            return;
        }

        $questions = [
            // Programmer - Additional questions with display_order
            $skema1->id_skema => [
                [
                    'pertanyaan' => 'Apa yang dimaksud dengan algoritma dalam pemrograman?',
                    'jawaban_a' => 'Bahasa pemrograman',
                    'jawaban_b' => 'Langkah-langkah sistematis untuk menyelesaikan masalah',
                    'jawaban_c' => 'Perangkat keras komputer',
                    'jawaban_d' => 'Sistem operasi',
                    'jawaban_e' => 'Database',
                    'jawaban_benar' => 'b',
                    'display_order' => 1,
                ],
                [
                    'pertanyaan' => 'Manakah yang merupakan tipe data primitif dalam Java?',
                    'jawaban_a' => 'String',
                    'jawaban_b' => 'Array',
                    'jawaban_c' => 'int',
                    'jawaban_d' => 'Object',
                    'jawaban_e' => 'ArrayList',
                    'jawaban_benar' => 'c',
                    'display_order' => 2,
                ],
                [
                    'pertanyaan' => 'Apa fungsi dari keyword "return" dalam sebuah fungsi?',
                    'jawaban_a' => 'Menghentikan program',
                    'jawaban_b' => 'Mengembalikan nilai dari fungsi',
                    'jawaban_c' => 'Membuat variabel baru',
                    'jawaban_d' => 'Memanggil fungsi lain',
                    'jawaban_e' => 'Mendeklarasikan fungsi',
                    'jawaban_benar' => 'b',
                    'display_order' => 3,
                ],
            ],

            // Backend Developer - Additional questions with display_order
            $skema2->id_skema => [
                [
                    'pertanyaan' => 'Apa yang dimaksud dengan RESTful API?',
                    'jawaban_a' => 'Database relasional',
                    'jawaban_b' => 'Arsitektur untuk membangun web service',
                    'jawaban_c' => 'Bahasa pemrograman',
                    'jawaban_d' => 'Framework frontend',
                    'jawaban_e' => 'Sistem operasi server',
                    'jawaban_benar' => 'b',
                    'display_order' => 1,
                ],
                [
                    'pertanyaan' => 'HTTP status code 404 menandakan?',
                    'jawaban_a' => 'Request berhasil',
                    'jawaban_b' => 'Server error',
                    'jawaban_c' => 'Resource tidak ditemukan',
                    'jawaban_d' => 'Unauthorized',
                    'jawaban_e' => 'Bad request',
                    'jawaban_benar' => 'c',
                    'display_order' => 2,
                ],
                [
                    'pertanyaan' => 'Apa fungsi dari middleware dalam aplikasi web?',
                    'jawaban_a' => 'Menyimpan data',
                    'jawaban_b' => 'Memproses request sebelum mencapai controller',
                    'jawaban_c' => 'Menampilkan view',
                    'jawaban_d' => 'Membuat database',
                    'jawaban_e' => 'Mengirim email',
                    'jawaban_benar' => 'b',
                    'display_order' => 3,
                ],
            ],

            // Data Science - Additional questions with display_order
            $skema3->id_skema => [
                [
                    'pertanyaan' => 'Apa yang dimaksud dengan overfitting dalam machine learning?',
                    'jawaban_a' => 'Model terlalu sederhana',
                    'jawaban_b' => 'Model terlalu kompleks dan tidak generalize dengan baik',
                    'jawaban_c' => 'Data terlalu sedikit',
                    'jawaban_d' => 'Algoritma terlalu lambat',
                    'jawaban_e' => 'Hardware tidak memadai',
                    'jawaban_benar' => 'b',
                    'display_order' => 1,
                ],
                [
                    'pertanyaan' => 'Teknik apa yang digunakan untuk mengurangi dimensi data?',
                    'jawaban_a' => 'PCA (Principal Component Analysis)',
                    'jawaban_b' => 'SQL Query',
                    'jawaban_c' => 'HTTP Request',
                    'jawaban_d' => 'File Compression',
                    'jawaban_e' => 'Data Backup',
                    'jawaban_benar' => 'a',
                    'display_order' => 2,
                ],
                [
                    'pertanyaan' => 'Apa fungsi dari cross-validation dalam machine learning?',
                    'jawaban_a' => 'Mempercepat training',
                    'jawaban_b' => 'Mengevaluasi performa model secara lebih akurat',
                    'jawaban_c' => 'Menambah data',
                    'jawaban_d' => 'Menghapus outlier',
                    'jawaban_e' => 'Mengubah format data',
                    'jawaban_benar' => 'b',
                    'display_order' => 3,
                ],
            ],
        ];

        foreach ($questions as $id_skema => $soals) {
            foreach ($soals as $item) {
                // Check if question already exists
                $exists = Soal::where('id_skema', $id_skema)
                    ->where('pertanyaan', $item['pertanyaan'])
                    ->exists();
                
                if (!$exists) {
                    Soal::create(array_merge(['id_skema' => $id_skema], $item));
                }
            }
        }

        $this->command->info('IA05 sample questions seeded successfully.');
    }


    /**
     * Seed IA02 work instruction templates for existing schemes.
     * Requirements: 2.1
     */
    private function seedIA02Templates(): void
    {
        // Fetch existing schemes
        $skema1 = Skema::where('nomor_skema', 'SKM/0317/00010/2/2019/22')->first(); // Programmer
        $skema2 = Skema::where('nomor_skema', 'SKM/2988/00010/2/2021/34')->first(); // Backend Developer
        $skema3 = Skema::where('nomor_skema', 'SKM/3111/00010/2/2022/65')->first(); // Data Science

        if (!$skema1 || !$skema2 || !$skema3) {
            $this->command->warn('Some schemes not found. Skipping IA02 seeding.');
            return;
        }

        $templates = [
            // Programmer
            $skema1->id_skema => [
                'instruksi_kerja' => '<h2>Instruksi Kerja - Tugas Praktik Programmer</h2>
<h3>Tujuan</h3>
<p>Mendemonstrasikan kemampuan dalam mengembangkan aplikasi sesuai dengan standar kompetensi programmer.</p>

<h3>Tugas</h3>
<ol>
    <li><strong>Analisis Kebutuhan</strong>
        <ul>
            <li>Baca dan pahami spesifikasi kebutuhan yang diberikan</li>
            <li>Identifikasi input, proses, dan output yang diperlukan</li>
            <li>Buat flowchart atau pseudocode dari solusi</li>
        </ul>
    </li>
    <li><strong>Implementasi Kode</strong>
        <ul>
            <li>Tulis kode program sesuai dengan spesifikasi</li>
            <li>Gunakan best practices dalam penulisan kode</li>
            <li>Berikan komentar yang jelas pada kode</li>
        </ul>
    </li>
    <li><strong>Testing</strong>
        <ul>
            <li>Lakukan unit testing pada fungsi-fungsi utama</li>
            <li>Dokumentasikan hasil testing</li>
        </ul>
    </li>
</ol>

<h3>Waktu Pengerjaan</h3>
<p>120 menit</p>

<h3>Kriteria Penilaian</h3>
<ul>
    <li>Ketepatan logika program (40%)</li>
    <li>Kualitas kode dan dokumentasi (30%)</li>
    <li>Hasil testing (30%)</li>
</ul>',
                'is_default' => true,
            ],

            // Backend Developer
            $skema2->id_skema => [
                'instruksi_kerja' => '<h2>Instruksi Kerja - Tugas Praktik Backend Developer</h2>
<h3>Tujuan</h3>
<p>Mendemonstrasikan kemampuan dalam mengembangkan backend application dan API.</p>

<h3>Tugas</h3>
<ol>
    <li><strong>Desain Database</strong>
        <ul>
            <li>Buat ERD (Entity Relationship Diagram) berdasarkan kebutuhan</li>
            <li>Implementasikan schema database</li>
            <li>Buat migration dan seeder</li>
        </ul>
    </li>
    <li><strong>Pengembangan API</strong>
        <ul>
            <li>Buat RESTful API endpoints sesuai spesifikasi</li>
            <li>Implementasikan authentication dan authorization</li>
            <li>Tambahkan validasi input</li>
        </ul>
    </li>
    <li><strong>Dokumentasi</strong>
        <ul>
            <li>Dokumentasikan API menggunakan format standar</li>
            <li>Sertakan contoh request dan response</li>
        </ul>
    </li>
</ol>

<h3>Waktu Pengerjaan</h3>
<p>150 menit</p>

<h3>Kriteria Penilaian</h3>
<ul>
    <li>Desain database yang baik (25%)</li>
    <li>Implementasi API yang benar (40%)</li>
    <li>Keamanan dan validasi (20%)</li>
    <li>Dokumentasi (15%)</li>
</ul>',
                'is_default' => true,
            ],

            // Data Science
            $skema3->id_skema => [
                'instruksi_kerja' => '<h2>Instruksi Kerja - Tugas Praktik Data Science</h2>
<h3>Tujuan</h3>
<p>Mendemonstrasikan kemampuan dalam analisis data dan machine learning.</p>

<h3>Tugas</h3>
<ol>
    <li><strong>Eksplorasi Data</strong>
        <ul>
            <li>Load dan eksplorasi dataset yang diberikan</li>
            <li>Identifikasi missing values dan outliers</li>
            <li>Buat visualisasi untuk memahami distribusi data</li>
        </ul>
    </li>
    <li><strong>Preprocessing</strong>
        <ul>
            <li>Lakukan data cleaning</li>
            <li>Feature engineering jika diperlukan</li>
            <li>Split data menjadi training dan testing set</li>
        </ul>
    </li>
    <li><strong>Modeling</strong>
        <ul>
            <li>Pilih dan implementasikan algoritma yang sesuai</li>
            <li>Lakukan hyperparameter tuning</li>
            <li>Evaluasi model menggunakan metrik yang tepat</li>
        </ul>
    </li>
</ol>

<h3>Waktu Pengerjaan</h3>
<p>180 menit</p>

<h3>Kriteria Penilaian</h3>
<ul>
    <li>Eksplorasi dan preprocessing data (30%)</li>
    <li>Pemilihan dan implementasi model (40%)</li>
    <li>Evaluasi dan interpretasi hasil (30%)</li>
</ul>',
                'is_default' => true,
            ],
        ];

        foreach ($templates as $id_skema => $template) {
            // Check if template already exists for this scheme
            $exists = IA02Template::where('id_skema', $id_skema)->exists();
            
            if (!$exists) {
                IA02Template::create(array_merge(['id_skema' => $id_skema], $template));
            }
        }

        $this->command->info('IA02 sample templates seeded successfully.');
    }


    /**
     * Seed IA07 oral questions for existing schemes.
     * Requirements: 3.1
     */
    private function seedIA07Questions(): void
    {
        // Fetch existing schemes
        $skema1 = Skema::where('nomor_skema', 'SKM/0317/00010/2/2019/22')->first(); // Programmer
        $skema2 = Skema::where('nomor_skema', 'SKM/2988/00010/2/2021/34')->first(); // Backend Developer
        $skema3 = Skema::where('nomor_skema', 'SKM/3111/00010/2/2022/65')->first(); // Data Science

        if (!$skema1 || !$skema2 || !$skema3) {
            $this->command->warn('Some schemes not found. Skipping IA07 seeding.');
            return;
        }

        // Get UK and ElemenUK for each scheme
        $this->seedIA07ForScheme($skema1);
        $this->seedIA07ForScheme($skema2);
        $this->seedIA07ForScheme($skema3);

        $this->command->info('IA07 sample questions seeded successfully.');
    }

    /**
     * Seed IA07 questions for a specific scheme.
     */
    private function seedIA07ForScheme(Skema $skema): void
    {
        // Get unit kompetensi for this scheme
        $unitKompetensiList = $skema->getUnitKompetensi();

        if ($unitKompetensiList->isEmpty()) {
            $this->command->warn("No UK found for scheme: {$skema->nama_skema}");
            return;
        }

        // Generic oral questions that can be adapted per UK/Elemen
        $genericQuestions = [
            'Jelaskan pemahaman Anda tentang kompetensi ini dan bagaimana Anda menerapkannya dalam pekerjaan sehari-hari.',
            'Berikan contoh konkret dari pengalaman Anda yang menunjukkan penguasaan kompetensi ini.',
            'Apa tantangan terbesar yang Anda hadapi terkait kompetensi ini dan bagaimana Anda mengatasinya?',
            'Bagaimana Anda memastikan kualitas pekerjaan Anda sesuai dengan standar kompetensi ini?',
            'Jelaskan langkah-langkah yang Anda lakukan untuk terus meningkatkan kemampuan di bidang ini.',
        ];

        $displayOrder = 1;

        foreach ($unitKompetensiList as $uk) {
            // Get elemen UK for this UK
            $elemenList = ElemenUK::where('id_uk', $uk->id_uk)->get();

            if ($elemenList->isEmpty()) {
                // Create questions at UK level without elemen
                foreach (array_slice($genericQuestions, 0, 2) as $question) {
                    $exists = IA07Question::where('id_skema', $skema->id_skema)
                        ->where('id_uk', $uk->id_uk)
                        ->where('pertanyaan', $question)
                        ->exists();

                    if (!$exists) {
                        IA07Question::create([
                            'id_skema' => $skema->id_skema,
                            'id_uk' => $uk->id_uk,
                            'id_elemen_uk' => null,
                            'pertanyaan' => $question,
                            'display_order' => $displayOrder++,
                            'is_active' => true,
                        ]);
                    }
                }
            } else {
                // Create questions for each elemen
                foreach ($elemenList as $elemen) {
                    // Create 1-2 questions per elemen
                    $questionsForElemen = [
                        "Terkait dengan '{$elemen->nama_elemen}', jelaskan bagaimana Anda menerapkan kompetensi ini.",
                        "Berikan contoh hasil kerja Anda yang menunjukkan penguasaan '{$elemen->nama_elemen}'.",
                    ];

                    foreach ($questionsForElemen as $question) {
                        $exists = IA07Question::where('id_skema', $skema->id_skema)
                            ->where('id_uk', $uk->id_uk)
                            ->where('id_elemen_uk', $elemen->id_elemen_uk)
                            ->where('pertanyaan', $question)
                            ->exists();

                        if (!$exists) {
                            IA07Question::create([
                                'id_skema' => $skema->id_skema,
                                'id_uk' => $uk->id_uk,
                                'id_elemen_uk' => $elemen->id_elemen_uk,
                                'pertanyaan' => $question,
                                'display_order' => $displayOrder++,
                                'is_active' => true,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
