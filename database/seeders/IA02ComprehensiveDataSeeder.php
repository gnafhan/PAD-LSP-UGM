<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IA02;
use App\Models\IA02Kompetensi;
use App\Models\IA02ProsesAssessment;
use App\Models\IA02InstruksiKerja;

class IA02ComprehensiveDataSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Data lengkap untuk setiap kombinasi asesi-asesor-skema
        $dataIA02 = [
            // Data untuk Programmer (SKEMA202500001)
            [
                'id_asesi' => 'ASESI202500001',
                'id_asesor' => 'ASESOR202500001',
                'id_skema' => 'SKEMA202500001',
                'judul_sertifikasi' => 'Programmer',
                'nomor_sertifikasi' => 'SKM-PROG-001-2025',
                'nama_peserta' => 'Yeka',
                'nama_asesor' => 'Budi Santoso',
                'tuk' => 'LSP UGM',
                'status' => 'draft',
                'kompetensis' => [
                    [
                        'id_uk' => 'UK202500001',
                        'kode_uk' => 'J.620100.009.02',
                        'nama_uk' => 'Melakukan coding sederhana',
                        'deskripsi_kompetensi' => 'Kemampuan melakukan pemrograman dasar dengan struktur dan logika yang benar',
                        'urutan' => 1
                    ],
                    [
                        'id_uk' => 'UK202500002',
                        'kode_uk' => 'J.620100.013.07',
                        'nama_uk' => 'Menulis kode dengan kaidah yang baik',
                        'deskripsi_kompetensi' => 'Kemampuan menulis kode yang clean, terstruktur, dan mengikuti best practices',
                        'urutan' => 2
                    ]
                ],
                'proses_assessments' => [
                    [
                        'nomor_proses' => 1,
                        'judul_proses' => 'Implementasi Algoritma Dasar',
                        'deskripsi_proses' => 'Proses assessment untuk menguji kemampuan implementasi algoritma dasar pemrograman',
                        'urutan' => 1,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Buatlah program untuk menghitung faktorial dari sebuah angka',
                                'standar_alat_media' => 'Komputer, Text Editor/IDE (VS Code, IntelliJ, dll)',
                                'output_yang_diharapkan' => 'Program yang dapat menghitung faktorial dengan benar'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Implementasikan algoritma sorting (bubble sort atau selection sort)',
                                'standar_alat_media' => 'Komputer, IDE, Debugger',
                                'output_yang_diharapkan' => 'Program sorting yang berfungsi dengan kompleksitas yang tepat'
                            ],
                            [
                                'nomor_urut' => 3,
                                'instruksi_kerja' => 'Buatlah program pencarian data dalam array (linear search)',
                                'standar_alat_media' => 'Komputer, IDE dengan debugging tools',
                                'output_yang_diharapkan' => 'Program pencarian yang dapat menemukan elemen dalam array'
                            ]
                        ]
                    ],
                    [
                        'nomor_proses' => 2,
                        'judul_proses' => 'Struktur Data dan Fungsi',
                        'deskripsi_proses' => 'Assessment untuk menguji pemahaman struktur data dan penggunaan fungsi',
                        'urutan' => 2,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Buatlah program menggunakan array dan loop untuk menghitung rata-rata',
                                'standar_alat_media' => 'Komputer, IDE dengan syntax highlighting',
                                'output_yang_diharapkan' => 'Program yang menghitung rata-rata dari sekumpulan data'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Implementasikan fungsi rekursif untuk menghitung deret Fibonacci',
                                'standar_alat_media' => 'Komputer, IDE, Tools untuk monitoring memory',
                                'output_yang_diharapkan' => 'Fungsi rekursif yang menghasilkan deret Fibonacci yang benar'
                            ]
                        ]
                    ],
                    [
                        'nomor_proses' => 3,
                        'judul_proses' => 'Penanganan Error dan Debugging',
                        'deskripsi_proses' => 'Assessment kemampuan debugging dan penanganan error dalam kode',
                        'urutan' => 3,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Debug kode yang diberikan dan perbaiki error yang ada',
                                'standar_alat_media' => 'Komputer, IDE dengan debugger, Browser dev tools',
                                'output_yang_diharapkan' => 'Kode yang bersih dari error dan berjalan sesuai spesifikasi'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Implementasikan exception handling pada program kalkulator',
                                'standar_alat_media' => 'Komputer, IDE dengan error tracking',
                                'output_yang_diharapkan' => 'Program dengan penanganan error yang robust'
                            ]
                        ]
                    ]
                ]
            ],

            // Data untuk Backend Developer (SKEMA202500002)
            [
                'id_asesi' => 'ASESI202500002',
                'id_asesor' => 'ASESOR202500002',
                'id_skema' => 'SKEMA202500002',
                'judul_sertifikasi' => 'Backend Developer',
                'nomor_sertifikasi' => 'SKM-BACK-002-2025',
                'nama_peserta' => 'Sakura Yamamoto',
                'nama_asesor' => 'Siti Rahmawati',
                'tuk' => 'LSP UGM',
                'status' => 'draft',
                'kompetensis' => [
                    [
                        'id_uk' => 'UK202500002',
                        'kode_uk' => 'J.620100.013.07',
                        'nama_uk' => 'Menulis kode dengan kaidah yang baik',
                        'deskripsi_kompetensi' => 'Kemampuan menulis kode backend yang clean, maintainable, dan mengikuti design patterns',
                        'urutan' => 1
                    ],
                    [
                        'id_uk' => 'UK202500003',
                        'kode_uk' => 'J.620100.027.02',
                        'nama_uk' => 'Mengimplementasikan pemrograman kotlin',
                        'deskripsi_kompetensi' => 'Kemampuan mengembangkan aplikasi backend menggunakan Kotlin dan framework terkait',
                        'urutan' => 2
                    ]
                ],
                'proses_assessments' => [
                    [
                        'nomor_proses' => 1,
                        'judul_proses' => 'API Development dan Database Integration',
                        'deskripsi_proses' => 'Assessment kemampuan membangun REST API dan integrasi database',
                        'urutan' => 1,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Buatlah REST API untuk CRUD operasi user management',
                                'standar_alat_media' => 'Komputer, IDE, Database (MySQL/PostgreSQL), Postman/Insomnia',
                                'output_yang_diharapkan' => 'API dengan endpoint GET, POST, PUT, DELETE yang berfungsi'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Implementasikan autentikasi JWT pada API',
                                'standar_alat_media' => 'Komputer, IDE, Database, API Testing Tools',
                                'output_yang_diharapkan' => 'Sistem autentikasi yang secure dengan JWT token'
                            ],
                            [
                                'nomor_urut' => 3,
                                'instruksi_kerja' => 'Buatlah sistem validasi input dan error handling',
                                'standar_alat_media' => 'Komputer, IDE, Testing framework',
                                'output_yang_diharapkan' => 'API dengan validasi yang comprehensive dan error response yang konsisten'
                            ]
                        ]
                    ],
                    [
                        'nomor_proses' => 2,
                        'judul_proses' => 'Optimasi Performance dan Security',
                        'deskripsi_proses' => 'Assessment kemampuan optimasi dan implementasi security pada backend',
                        'urutan' => 2,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Implementasikan caching mechanism untuk meningkatkan performance',
                                'standar_alat_media' => 'Komputer, IDE, Redis/Memcached, Performance monitoring tools',
                                'output_yang_diharapkan' => 'Sistem caching yang mengurangi response time secara signifikan'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Implementasikan rate limiting dan API security headers',
                                'standar_alat_media' => 'Komputer, IDE, Security testing tools',
                                'output_yang_diharapkan' => 'API yang secure dengan rate limiting dan proper security headers'
                            ]
                        ]
                    ]
                ]
            ],

            // Data untuk Data Science (SKEMA202500003)
            [
                'id_asesi' => 'ASESI202500003',
                'id_asesor' => 'ASESOR202500003',
                'id_skema' => 'SKEMA202500003',
                'judul_sertifikasi' => 'Data Science',
                'nomor_sertifikasi' => 'SKM-DS-003-2025',
                'nama_peserta' => 'Hiro Tanaka',
                'nama_asesor' => 'Andi Prasetyo',
                'tuk' => 'LSP UGM',
                'status' => 'draft',
                'kompetensis' => [
                    [
                        'id_uk' => 'UK202500004',
                        'kode_uk' => 'J.450100.027.02',
                        'nama_uk' => 'Melakukan visualisasi data',
                        'deskripsi_kompetensi' => 'Kemampuan membuat visualisasi data yang informatif dan menarik menggunakan tools yang tepat',
                        'urutan' => 1
                    ],
                    [
                        'id_uk' => 'UK202500005',
                        'kode_uk' => 'J.6289700.027.02',
                        'nama_uk' => 'Membuat contoh model machine learning',
                        'deskripsi_kompetensi' => 'Kemampuan merancang, melatih, dan mengevaluasi model machine learning untuk solve real-world problems',
                        'urutan' => 2
                    ]
                ],
                'proses_assessments' => [
                    [
                        'nomor_proses' => 1,
                        'judul_proses' => 'Data Analysis dan Preprocessing',
                        'deskripsi_proses' => 'Assessment kemampuan analisis data dan preprocessing untuk machine learning',
                        'urutan' => 1,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Lakukan eksplorasi data (EDA) pada dataset yang diberikan',
                                'standar_alat_media' => 'Komputer, Python/R, Jupyter Notebook, Pandas, Matplotlib/Seaborn',
                                'output_yang_diharapkan' => 'Report EDA dengan insight yang clear dan visualisasi yang informatif'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Lakukan data cleaning dan preprocessing (missing values, outliers, normalization)',
                                'standar_alat_media' => 'Komputer, Python, Pandas, Numpy, Scikit-learn',
                                'output_yang_diharapkan' => 'Dataset yang clean dan siap untuk modeling'
                            ],
                            [
                                'nomor_urut' => 3,
                                'instruksi_kerja' => 'Buatlah feature engineering untuk meningkatkan model performance',
                                'standar_alat_media' => 'Komputer, Python, Feature selection tools',
                                'output_yang_diharapkan' => 'Features yang optimal untuk model dengan justifikasi yang clear'
                            ]
                        ]
                    ],
                    [
                        'nomor_proses' => 2,
                        'judul_proses' => 'Model Development dan Evaluation',
                        'deskripsi_proses' => 'Assessment kemampuan membangun dan mengevaluasi model machine learning',
                        'urutan' => 2,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Bangun model klasifikasi/regresi menggunakan algoritma yang tepat',
                                'standar_alat_media' => 'Komputer, Python, Scikit-learn, TensorFlow/PyTorch',
                                'output_yang_diharapkan' => 'Model yang trained dengan performance metrics yang baik'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Lakukan hyperparameter tuning untuk optimasi model',
                                'standar_alat_media' => 'Komputer, Python, Grid Search/Random Search tools',
                                'output_yang_diharapkan' => 'Model dengan hyperparameter yang optimal'
                            ],
                            [
                                'nomor_urut' => 3,
                                'instruksi_kerja' => 'Evaluasi model menggunakan cross-validation dan metrics yang tepat',
                                'standar_alat_media' => 'Komputer, Python, Validation tools, Visualization libraries',
                                'output_yang_diharapkan' => 'Comprehensive model evaluation dengan interpretation yang clear'
                            ]
                        ]
                    ],
                    [
                        'nomor_proses' => 3,
                        'judul_proses' => 'Data Visualization dan Reporting',
                        'deskripsi_proses' => 'Assessment kemampuan membuat visualisasi dan reporting hasil analysis',
                        'urutan' => 3,
                        'instruksi_kerjas' => [
                            [
                                'nomor_urut' => 1,
                                'instruksi_kerja' => 'Buatlah dashboard interaktif untuk menampilkan hasil analysis',
                                'standar_alat_media' => 'Komputer, Python, Streamlit/Dash/Tableau, Plotly',
                                'output_yang_diharapkan' => 'Dashboard yang user-friendly dan informatif'
                            ],
                            [
                                'nomor_urut' => 2,
                                'instruksi_kerja' => 'Buatlah report teknis yang comprehensive dengan business recommendations',
                                'standar_alat_media' => 'Komputer, Documentation tools, Presentation software',
                                'output_yang_diharapkan' => 'Technical report dengan actionable insights dan recommendations'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // Create IA02 records dengan data yang comprehensive
        foreach ($dataIA02 as $data) {
            $this->command->info("Creating IA02 for {$data['nama_peserta']} - {$data['judul_sertifikasi']}");
            
            // Create main IA02 record
            $ia02 = IA02::create([
                'id_asesi' => $data['id_asesi'],
                'id_asesor' => $data['id_asesor'],
                'id_skema' => $data['id_skema'],
                'judul_sertifikasi' => $data['judul_sertifikasi'],
                'nama_peserta' => $data['nama_peserta'],
                'nama_asesor' => $data['nama_asesor'],
                'status' => $data['status'],
                'instruksi_kerja' => $this->generateInstruksiKerjaContent($data['judul_sertifikasi'])
            ]);

            // Create kompetensis
            foreach ($data['kompetensis'] as $kompetensi) {
                IA02Kompetensi::create([
                    'ia02_id' => $ia02->id,
                    'id_uk' => $kompetensi['id_uk'],
                    'kode_uk' => $kompetensi['kode_uk'],
                    'nama_uk' => $kompetensi['nama_uk'],
                    'deskripsi_kompetensi' => $kompetensi['deskripsi_kompetensi'],
                    'urutan' => $kompetensi['urutan']
                ]);
            }

            // Create proses assessments
            foreach ($data['proses_assessments'] as $prosesData) {
                $proses = IA02ProsesAssessment::create([
                    'ia02_id' => $ia02->id,
                    'nomor_proses' => $prosesData['nomor_proses'],
                    'judul_proses' => $prosesData['judul_proses'],
                    'deskripsi_proses' => $prosesData['deskripsi_proses'],
                    'urutan' => $prosesData['urutan']
                ]);

                // Create instruksi kerjas for each process
                foreach ($prosesData['instruksi_kerjas'] as $instruksi) {
                    IA02InstruksiKerja::create([
                        'proses_assessment_id' => $proses->id,
                        'nomor_urut' => $instruksi['nomor_urut'],
                        'instruksi_kerja' => $instruksi['instruksi_kerja'],
                        'standar_alat_media' => $instruksi['standar_alat_media'],
                        'output_yang_diharapkan' => $instruksi['output_yang_diharapkan']
                    ]);
                }
            }

            $this->command->info("✅ IA02 created successfully for {$data['nama_peserta']}");
        }

        $this->command->info('🎉 IA02 comprehensive data seeder completed successfully!');
        $this->command->info('📊 Created:');
        $this->command->info('   - 3 IA02 main records');
        $this->command->info('   - 6 kompetensi records');
        $this->command->info('   - 7 proses assessment records');
        $this->command->info('   - 20 instruksi kerja records');
    }

    /**
     * Generate instruksi kerja content based on skema
     */
    private function generateInstruksiKerjaContent($skema)
    {
        switch ($skema) {
            case 'Programmer':
                return '<p><strong>Skenario Programmer</strong></p>
                       <p>Anda ditugaskan untuk mengembangkan aplikasi sederhana yang mengelola data mahasiswa. Aplikasi ini harus dapat melakukan operasi CRUD (Create, Read, Update, Delete) dan memiliki validasi input yang baik.</p>
                       <p><strong>Instruksi Kerja:</strong></p>
                       <ol>
                         <li>Buatlah struktur data yang tepat untuk menyimpan informasi mahasiswa</li>
                         <li>Implementasikan fungsi-fungsi CRUD dengan algoritma yang efisien</li>
                         <li>Tambahkan validasi input dan error handling</li>
                         <li>Buatlah dokumentasi code yang clear dan comprehensive</li>
                       </ol>';

            case 'Backend Developer':
                return '<p><strong>Skenario Backend Developer</strong></p>
                       <p>Perusahaan membutuhkan sistem backend untuk aplikasi e-commerce. Sistem ini harus dapat menangani user management, product catalog, dan order processing dengan performance yang optimal dan security yang baik.</p>
                       <p><strong>Instruksi Kerja:</strong></p>
                       <ol>
                         <li>Desain dan implementasikan REST API architecture</li>
                         <li>Buatlah sistem autentikasi dan autorisasi yang secure</li>
                         <li>Implementasikan database design yang optimal</li>
                         <li>Tambahkan caching mechanism untuk performance optimization</li>
                         <li>Implementasikan comprehensive testing strategy</li>
                       </ol>';

            case 'Data Science':
                return '<p><strong>Skenario Data Science</strong></p>
                       <p>Sebuah retail company ingin menganalisis customer behavior untuk meningkatkan sales. Anda diminta untuk menganalisis data transaksi customer dan membuat model prediksi untuk customer segmentation dan sales forecasting.</p>
                       <p><strong>Instruksi Kerja:</strong></p>
                       <ol>
                         <li>Lakukan exploratory data analysis (EDA) yang comprehensive</li>
                         <li>Identifikasi pattern dan insight dari data customer</li>
                         <li>Buatlah model machine learning untuk customer segmentation</li>
                         <li>Develop model untuk sales forecasting</li>
                         <li>Buatlah visualisasi yang informatif dan dashboard interaktif</li>
                         <li>Presentasikan findings dan recommendations kepada business stakeholders</li>
                       </ol>';

            default:
                return '<p><strong>Instruksi Kerja Umum</strong></p>
                       <p>Silakan ikuti instruksi yang diberikan oleh asesor dan demonstrasikan kompetensi sesuai dengan skema sertifikasi yang diambil.</p>';
        }
    }
}
