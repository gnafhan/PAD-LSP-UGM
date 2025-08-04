<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\RincianAsesmen;
use App\Models\ProgresAsesmen;
use App\Models\Fria07;
use App\Models\UK;
use Illuminate\Support\Str;

class Fria07TestSeeder extends Seeder
{
    public function run(): void
    {
        $asesiList = Asesi::take(5)->get();
        $asesor = \App\Models\Asesor::first();
        $event = \App\Models\Event::first();

        if (!$asesor || !$event) {
            $this->command->error('Asesor atau Event tidak ditemukan!');
            return;
        }

        foreach ($asesiList as $asesi) {
            $progres = ProgresAsesmen::firstOrCreate([
                'id_asesi' => $asesi->id_asesi,
            ]);

            if (!$progres->ia02) {
                $progres->update([
                    'ia02' => ['completed' => false, 'completed_at' => null],
                ]);
            }

            // Create rincian asesmen
            $rincianAsesmen = RincianAsesmen::firstOrCreate([
                'id_asesi' => $asesi->id_asesi,
            ], [
                'id_asesor' => $asesor->id_asesor,
                'id_event' => $event->id_event,
            ]);

            // Get skema and unit kompetensi
            $skema = Skema::find($asesi->id_skema);
            if (!$skema) continue;

            // Get daftar UK from skema
            $daftarIdUk = $skema->daftar_id_uk;
            if (is_string($daftarIdUk)) {
                $daftarIdUk = json_decode($daftarIdUk, true);
            }

            if (empty($daftarIdUk)) continue;

            // Get unit kompetensi with elemen
            $unitKompetensi = UK::with('elemen_uk')
                ->whereIn('id_uk', $daftarIdUk)
                ->take(2) 
                ->get();

            if ($unitKompetensi->isEmpty()) continue;

            $sampleEvaluations = [];
            foreach ($unitKompetensi as $uk) {
                $ukData = [
                    'id_uk' => $uk->id_uk, 
                    'kode_uk' => $uk->kode_uk,
                    'nama_uk' => $uk->nama_uk,
                    'elemen_kompetensi' => []
                ];

                foreach ($uk->elemen_uk->take(3) as $index => $elemen) { 
                    // Generate multiple questions 
                    $questions = $this->generateQuestionsForElement($elemen->nama_elemen);
                    $answers = $this->generateAnswersForElement($elemen->nama_elemen);
                    
                    $numQuestions = ($index == 0 && count($uk->elemen_uk) > 1) ? rand(2, 3) : 1;
                    
                    for ($q = 0; $q < $numQuestions; $q++) {
                        $selectedQuestion = $questions[array_rand($questions)];
                        $selectedAnswer = $answers[array_rand($answers)];
                        
                        $ukData['elemen_kompetensi'][] = [
                            'id_elemen' => $elemen->id_elemen_uk . ($q > 0 ? '_' . ($q + 1) : ''),
                            'nama_elemen' => $elemen->nama_elemen . ($q > 0 ? ' (Pertanyaan ' . ($q + 1) . ')' : ''),
                            'pertanyaan_lisan' => $selectedQuestion,
                            'jawaban_asesi' => $selectedAnswer,
                        ];
                    }
                }
                $sampleEvaluations[] = $ukData;
            }

            $dataEvaluasi = [
                'unit_kompetensi' => $sampleEvaluations,
                'hasil' => [
                    [
                        'catatan' => 'Data pertanyaan dan jawaban tersedia untuk evaluasi asesor.',
                        'tanggal_evaluasi' => now()->format('Y-m-d H:i:s'),
                        'durasi_evaluasi' => rand(30, 60) . ' menit'
                    ]
                ]
            ];

            // Create FRIA07 record
            Fria07::updateOrCreate([
                'id_asesi' => $asesi->id_asesi,
                'id_asesor' => $asesor->id_asesor,
                'id_skema' => $asesi->id_skema,
            ], [
                'id_fria07' => Str::uuid()->toString(),
                'id_event' => $event->id_event,
                'id_rincian_asesmen' => $rincianAsesmen->id_rincian_asesmen,
                'data_tambahan' => $dataEvaluasi,
            ]);

            // Update progress for ia02
            if (rand(0, 10) > 3) {
                ProgresAsesmen::where('id_asesi', $asesi->id_asesi)
                    ->update([
                        'ia02' => ['completed' => true, 'completed_at' => now()]
                    ]);
            }
        }

        $this->command->info('FRIA07 test data seeded successfully with ' . $asesiList->count() . ' records!');
    }

    private function generateQuestionsForElement($namaElemen)
    {
        $genericQuestions = [
            "Bagaimana Anda menerapkan {elemen} dalam praktik kerja sehari-hari?",
            "Jelaskan langkah-langkah yang Anda lakukan dalam {elemen}",
            "Apa yang menjadi fokus utama ketika melaksanakan {elemen}?",
            "Bagaimana cara Anda memastikan kualitas dalam {elemen}?",
            "Ceritakan pengalaman Anda dalam mengimplementasikan {elemen}",
            "Apa tantangan yang sering Anda hadapi dalam {elemen} dan bagaimana mengatasinya?",
            "Bagaimana Anda mengukur keberhasilan dalam {elemen}?",
            "Jelaskan prinsip-prinsip yang Anda gunakan dalam {elemen}"
        ];

        $processedQuestions = [];
        foreach ($genericQuestions as $question) {
            $processedQuestions[] = str_replace('{elemen}', strtolower($namaElemen), $question);
        }

        return $processedQuestions;
    }

    private function generateAnswersForElement($namaElemen)
    {
        $answers = [
            "Saya menerapkan {elemen} dengan melakukan analisis kebutuhan terlebih dahulu, kemudian merencanakan pendekatan yang sistematis, dan mengimplementasikan solusi yang sesuai dengan standar industri. Dalam prosesnya, saya selalu memperhatikan aspek kualitas dan efisiensi untuk memastikan hasil yang optimal.",
            
            "Dalam mengimplementasikan {elemen}, saya mengikuti prosedur yang telah ditetapkan dengan melakukan persiapan yang matang, koordinasi dengan tim terkait, dan melakukan evaluasi berkala untuk memastikan pencapaian target yang diinginkan.",
            
            "Saya mengidentifikasi kebutuhan untuk {elemen} melalui beberapa cara: 1) Melakukan observasi terhadap kondisi existing, 2) Menganalisis gap yang ada, 3) Melakukan konsultasi dengan stakeholder terkait, 4) Menyusun rencana implementasi yang detail dan terukur.",
            
            "Untuk {elemen}, saya menerapkan metodologi yang terstruktur dengan tahapan: perencanaan, implementasi, monitoring, dan evaluasi. Setiap tahapan dilakukan dengan dokumentasi yang baik dan melibatkan tim yang kompeten sesuai bidangnya.",
            
            "Dalam pelaksanaan {elemen}, saya memastikan untuk menggunakan tools dan teknologi yang tepat, mengikuti best practices yang berlaku di industri, dan selalu mengutamakan aspek safety dan compliance terhadap regulasi yang berlaku.",
            
            "Saya melakukan {elemen} dengan pendekatan yang holistik, mempertimbangkan aspek teknis, ekonomis, dan sosial. Proses dimulai dari assessment awal, perencanaan detail, eksekusi yang terkontrol, hingga evaluasi hasil untuk continuous improvement."
        ];

        $processedAnswers = [];
        foreach ($answers as $answer) {
            $processedAnswers[] = str_replace('{elemen}', strtolower($namaElemen), $answer);
        }

        return $processedAnswers;
    }
}
