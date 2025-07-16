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
                        <span class="font-semibold text-gray-700">Judul Sertifikat:</span>
                        <span class="text-gray-900">Junior Web Developer</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nomor Sertifikat:</span>
                        <span class="text-gray-900">JWD2024070001</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Peserta:</span>
                        <span class="text-gray-900">Ahmad Fauzi</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Asesor:</span>
                        <span class="text-gray-900">Dr. Sarah Developer</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">TUK:</span>
                        <span class="text-gray-900">Pusat Sertifikasi Programmer Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programming Competencies -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kompetensi Programming yang Diujikan</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="border border-gray-300 p-3 text-left font-semibold">No</th>
                        <th class="border border-gray-300 p-3 text-left font-semibold">Kode Kompetensi</th>
                        <th class="border border-gray-300 p-3 text-left font-semibold">Skill Programming</th>
                    </tr>
                    </thead>
                    <tbody id="programming-skills-table">
                    <!-- Programming skills will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Competency Units -->
        <div class="space-y-6 mb-8">
            <div id="competency-units">
                <!-- Competency units will be populated by JavaScript -->
            </div>
        </div>

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
            { no: 1, code: "PRG.001", skill: "HTML & CSS Fundamentals" },
            { no: 2, code: "PRG.002", skill: "JavaScript Programming" },
            { no: 3, code: "PRG.003", skill: "Responsive Web Design" },
            { no: 4, code: "PRG.004", skill: "Database Management (SQL)" },
            { no: 5, code: "PRG.005", skill: "Version Control (Git)" },
            { no: 6, code: "PRG.006", skill: "Framework Usage (Laravel/React)" },
            { no: 7, code: "PRG.007", skill: "API Development & Integration" },
            { no: 8, code: "PRG.008", skill: "Code Testing & Debugging" },
            { no: 9, code: "PRG.009", skill: "Security Best Practices" },
            { no: 10, code: "PRG.010", skill: "Performance Optimization" },
            { no: 11, code: "PRG.011", skill: "Documentation & Code Review" },
            { no: 12, code: "PRG.012", skill: "Deployment & DevOps Basics" }
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
        function populateProgrammingSkillsTable() {
            const tableBody = $('#programming-skills-table');
            programmingSkills.forEach(skill => {
                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-3">${skill.no}</td>
                        <td class="border border-gray-300 p-3">${skill.code}</td>
                        <td class="border border-gray-300 p-3">${skill.skill}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }

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
            populateProgrammingSkillsTable();
            generateCompetencyUnits();

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
