@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Hasil Asesmen Sertifikasi Programmer')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-sm">
                <i class="fas fa-home text-blue-600"></i>
                <a href="{{ route('asesi.index') }}" class="breadcrumb-item">Home</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <a href="{{ route('asesi.fr.ia2') }}" class="breadcrumb-item">Formulir IA.02</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <span class="breadcrumb-item">Detail</span>
            </div>
        </nav>

    <div class="container mx-auto px-4 max-w-4xl">
        <div class="pt-6 pb-4 mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">FR.IA.02. Tugas Praktik Demonstrasi</h1>
        </div>

        <!-- Certificate Info -->
        <div class="glass-effect rounded-xl p-8 mb-8 hover-scale">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Skema Kompetensi:</span>
                        <span class="text-gray-900">{{ $data['nama_skema'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nomor Skema:</span>
                        <span class="text-gray-900">{{ $data['nomor_skema'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Peserta:</span>
                        <span class="text-gray-900">{{ $data['nama_peserta'] }}</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Asesor:</span>
                        <span class="text-gray-900">{{ $data['nama_asesor'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">TUK:</span>
                        <span class="text-gray-900">{{ $data['tuk'] }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Jadwal Pelaksanaan:</span>
                        <span class="text-gray-900">{{ $data['tanggal_asesi'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5"></div>
        <!-- Unit Kompetensi -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Unit Kompetensi (UK)</h2>

            @if($data['uk'] && $data['uk']->isNotEmpty())
                <div class="space-y-6">
                    @foreach($data['uk'] as $index => $uk)
                        <div class="p-4">
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">
                                        UK {{ $index + 1 }}: {{ $uk->nama_uk }}
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $uk->jenis_standar == 'Internasional' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $uk->jenis_standar }}
                                </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div class="flex">
                                        <span class="font-medium text-gray-600 w-20">ID UK:</span>
                                        <span class="text-gray-800">{{ $uk->id_uk }}</span>
                                    </div>
                                    <div class="flex">
                                        <span class="font-medium text-gray-600 w-20">Kode UK:</span>
                                        <span class="text-gray-800">{{ $uk->kode_uk }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Elemen UK -->
                            @if($uk->elemen_uk && $uk->elemen_uk->isNotEmpty())
                                <div class="mt-4">
                                    <h4 class="font-medium text-gray-700 mb-3">Elemen Kompetensi:</h4>
                                    <div class="space-y-2">
                                        @foreach($uk->elemen_uk as $elemenIndex => $elemen)
                                            <div class="bg-gray-50 rounded-md p-3">
                                                <div class="flex items-start">
                                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-800 rounded-full text-xs font-medium mr-3 mt-0.5">
                                                    {{ $elemenIndex + 1 }}
                                                </span>
                                                    <div class="flex-1">
                                                        <p class="text-gray-800 font-medium">{{ $elemen->nama_elemen }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            ID: {{ $elemen->id_elemen_uk }} |
                                                            Dibuat: {{ date('d/m/Y', strtotime($elemen->created_at)) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <p class="text-yellow-800 text-sm">Tidak ada elemen kompetensi untuk UK ini.</p>
                                </div>
                            @endif
                        </div>
                        @if($index < count($data['uk']) - 1)
                            <hr class="my-6 border-gray-200">
                        @endif
                    @endforeach
                </div>
            @else
                <div class="p-4 bg-gray-50 border border-gray-200 rounded-md">
                    <p class="text-gray-600">Tidak ada data Unit Kompetensi.</p>
                </div>
            @endif
        </div>
        <div class="mb-5"></div>
        <!-- Assessment Results -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Hasil Penilaian Sertifikasi</h2>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kemampuan Programming Kandidat:</label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="kinerja" value="kompeten" class="mr-2">
                        <span>Kompeten</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="kinerja" value="belum-kompeten" class="mr-2">
                        <span>Belum Kompeten</span>
                    </label>
                </div>
                <div class="mt-4">
                    <label for="feedback" class="block text-gray-700 font-semibold mb-2">Catatan Asesor:</label>
                    <textarea id="feedback" name="feedback" rows="3" class="text-gray-500 w-full p-2 border border-gray-300 rounded-md" placeholder="Berikan feedback mengenai kemampuan programming kandidat..."></textarea>
                </div>
            </div>
        </div>

        <!-- Signatures -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tanda Tangan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="text-center">
                    <div class="border-2 border-gray-300 rounded-lg p-4 mb-4 h-32 flex items-center justify-center bg-gray-50">
                        <span class="text-gray-500">Tanda Tangan Kandidat</span>
                    </div>
                    <div class="space-y-2">
                        <input type="date" class="w-full p-2 border border-gray-300 rounded-md" value="2025-07-16">
                        <div class="font-semibold">Kandidat Programmer</div>
                        <div class="text-lg font-bold">Ahmad Fauzi</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border-2 border-gray-300 rounded-lg p-4 mb-4 h-32 flex items-center justify-center bg-gray-50">
                        <span class="text-gray-500">Tanda Tangan Asesor</span>
                    </div>
                    <div class="space-y-2">
                        <input type="date" class="w-full p-2 border border-gray-300 rounded-md" value="2025-07-16">
                        <div class="font-semibold">Asesor Teknis</div>
                        <div class="text-lg font-bold">Dr. Sarah Developer</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-8">
            <button id="save-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg hover-scale">
                Simpan Hasil Sertifikasi
            </button>
            <button id="print-btn" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg hover-scale">
                Cetak Sertifikat
            </button>
        </div>
    </div>

    <script>
        // Data for programming skills
        const programmingSkills = [
        ];

        // Data for competency units
        const competencyUnits = [
            {
                title: "Unit Kompetensi No 1",
                code: "PRG.WEB.001",
                description: "Mengembangkan Frontend Web Application",
                elements: [
                    { no: 1, element: "Membuat struktur HTML yang semantik", sop: "Standar HTML5 & Accessibility" },
                    { no: 2, element: "Menerapkan styling CSS yang responsif", sop: "CSS3 & Mobile-First Design" },
                    { no: 3, element: "Mengimplementasikan JavaScript interaktif", sop: "ES6+ & DOM Manipulation" }
                ]
            },
            {
                title: "Unit Kompetensi No 2",
                code: "PRG.WEB.002",
                description: "Mengembangkan Backend Web Application",
                elements: [
                    { no: 1, element: "Membuat API RESTful", sop: "REST API Design Principles" },
                    { no: 2, element: "Mengelola database relasional", sop: "SQL & Database Normalization" },
                    { no: 3, element: "Mengimplementasikan autentikasi & autorisasi", sop: "Security & Authentication Standards" }
                ]
            },
            {
                title: "Unit Kompetensi No 3",
                code: "PRG.WEB.003",
                description: "Mengimplementasikan Framework Development",
                elements: [
                    { no: 1, element: "Menggunakan Laravel framework", sop: "Laravel Best Practices" },
                    { no: 2, element: "Mengintegrasikan dengan library eksternal", sop: "Package Management & Dependencies" },
                    { no: 3, element: "Melakukan testing dan debugging", sop: "Unit Testing & Code Quality" }
                ]
            },
            {
                title: "Unit Kompetensi No 4",
                code: "PRG.WEB.004",
                description: "Melakukan Deployment dan Maintenance",
                elements: [
                    { no: 1, element: "Melakukan deployment aplikasi", sop: "Deployment & Server Configuration" },
                    { no: 2, element: "Mengoptimalkan performa aplikasi", sop: "Performance Optimization Guidelines" },
                    { no: 3, element: "Melakukan maintenance dan monitoring", sop: "Monitoring & Logging Standards" }
                ]
            }
        ];

        // Populate programming skills table


        // Generate competency units
        function generateCompetencyUnits() {
            const container = $('#competency-units');

            competencyUnits.forEach((unit, index) => {
                const unitHtml = `
                    <div class="competency-card bg-white rounded-xl p-6 shadow-lg">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-800">${unit.title}</h3>
                            <p class="text-gray-600">Kode Unit: ${unit.code}</p>
                            <p class="text-gray-600">Judul: ${unit.description}</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="border border-gray-300 p-3 text-left">No</th>
                                        <th class="border border-gray-300 p-3 text-left">Elemen Kompetensi</th>
                                        <th class="border border-gray-300 p-3 text-left">Standar Penilaian</th>
                                        <th class="border border-gray-300 p-3 text-left">Status Kompetensi</th>
                                        <th class="border border-gray-300 p-3 text-left">Catatan Evaluasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${unit.elements.map(element => `
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 p-3">${element.no}</td>
                                            <td class="border border-gray-300 p-3">${element.element}</td>
                                            <td class="border border-gray-300 p-3">${element.sop}</td>
                                            <td class="border border-gray-300 p-3">
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Kompeten</span>
                                            </td>
                                            <td class="border border-gray-300 p-3">
                                                <span class="text-sm text-gray-600">Kemampuan coding excellent!</span>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
                container.append(unitHtml);
            });
        }

        // Update counts
        function updateCounts() {
            const kompeten = $('.competency-select[value="kompeten"]').length;
            const belumKompeten = $('.competency-select[value="belum-kompeten"]').length;
            const tidakKompeten = $('.competency-select[value="tidak-kompeten"]').length;
            const ulanganBaik = 0;

            $('#kompeten-count').text(kompeten);
            $('#belum-kompeten-count').text(belumKompeten);
            $('#tidak-kompeten-count').text(tidakKompeten);
            $('#ulangan-baik-count').text(ulanganBaik);
        }

        // Event handlers
        $(document).ready(function() {
            // generateCompetencyUnits();

            // Handle competency selection changes
            $(document).on('change', '.competency-select', function() {
                updateCounts();
            });

            // Save button
            $('#save-btn').click(function() {
                const formData = {
                    certificate: 'JWD2024070001',
                    participant: 'Ahmad Fauzi',
                    assessor: 'Dr. Sarah Developer',
                    performance: $('input[name="kinerja"]:checked').val(),
                    feedback: $('#feedback').val(),
                    competencies: []
                };

                $('.competency-select').each(function() {
                    if ($(this).val()) {
                        formData.competencies.push({
                            element: $(this).closest('tr').find('td:nth-child(2)').text(),
                            assessment: $(this).val()
                        });
                    }
                });

                console.log('Certification data:', formData);
                alert('Data sertifikasi programmer berhasil disimpan!');
            });

            // Print button
            $('#print-btn').click(function() {
                window.print();
            });
        });
    </script>
    </main>

@endsection
