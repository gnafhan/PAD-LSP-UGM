@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Hasil Asesmen FR.IA-02')

@section('content')

    <div class="container  mx-auto px-4 max-w-4xl">
        <div class="pt-6 pb-4 mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">FR.AK.07.CEKLIS PENYESUAIAN YANG WAJAR dan BERALASAN</h1>
        </div>
        <!-- Certificate Info -->
        <div class="glass-effect rounded-xl p-8 mb-8 hover-scale">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Judul Sertifikat:</span>
                        <span class="text-gray-900">Pemandu Museum</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nomor Sertifikat:</span>
                        <span class="text-gray-900">SKIM16022000232719</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Peserta:</span>
                        <span class="text-gray-900">Muhammad Rifal</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Nama Asesor:</span>
                        <span class="text-gray-900">Nafa Popcorn</span>
                    </div>
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">TUK:</span>
                        <span class="text-gray-900">Sewaktu Jatya Tourism Training Center</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Guidelines -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Panduan Bagi Asesor</h2>
            <div class="space-y-3 text-gray-700">

                <div class="flex items-start space-x-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                    <p>Lengkapi nama unit, elemen kompetensi, dan kriteria unjuk kerja (KUK) sebelum memulai proses asesmen.</p>
                </div>

                <div class="flex items-start space-x-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                    <p>Berikan tanda pada kolom yang sesuai di lembar kerja untuk setiap KUK.</p>
                </div>

                <div class="flex items-start space-x-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                    <p>Beri tanda centang (√) pada kolom <strong>'K' (Kompeten)</strong> jika asesi berhasil mendemonstrasikan KUK, atau pada kolom <strong>'BK' (Belum Kompeten)</strong> jika sebaliknya.</p>
                </div>

                <div class="flex items-start space-x-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                    <p>Tuliskan <strong>'Asesmen Lanjut'</strong> jika bukti yang terkumpul belum cukup untuk membuat keputusan, sehingga asesmen perlu dilanjutkan dengan metode lain.</p>
                </div>

                <div class="flex items-start space-x-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></span>
                    <p>Setelah semua KUK dinilai, berikan rekomendasi akhir <strong>'Kompeten' (K)</strong> atau <strong>'Belum Kompeten' (BK)</strong> untuk keseluruhan Unit Kompetensi tersebut.</p>
                </div>

            </div>
        </div>

        <!-- Competency Activities -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Kelompok Pekerjaan Kegiatan Rekreasi</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="border border-gray-300 p-3 text-left font-semibold">No</th>
                        <th class="border border-gray-300 p-3 text-left font-semibold">Kode Kegiatan</th>
                        <th class="border border-gray-300 p-3 text-left font-semibold">Kegiatan</th>
                    </tr>
                    </thead>
                    <tbody id="activities-table">
                    <!-- Activities will be populated by JavaScript -->
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
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Hasil Penilaian</h2>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Kinerja Asesi adalah:</label>
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
                    <label for="feedback" class="block text-gray-700 font-semibold mb-2">Umpan Balik:</label>
                    <textarea id="feedback" name="feedback" rows="3" class=" text-gray-500 w-full p-2 border border-gray-300 rounded-md" placeholder="Lainnya..."></textarea>
                </div>
            </div>
        </div>

        <!-- Signatures -->
        <div class="bg-white rounded-xl p-8 mb-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tanda tangan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="text-center">
                    <div class="border-2 border-gray-300 rounded-lg p-4 mb-4 h-32 flex items-center justify-center bg-gray-50">
                        <span class="text-gray-500">Tanda Tangan Asesi</span>
                    </div>
                    <div class="space-y-2">
                        <input type="date" class="w-full p-2 border border-gray-300 rounded-md" value="2025-03-15">
                        <div class="font-semibold">Asesi</div>
                        <div class="text-lg font-bold">Muhammad Rifal</div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="border-2 border-gray-300 rounded-lg p-4 mb-4 h-32 flex items-center justify-center bg-gray-50">
                        <span class="text-gray-500">Tanda Tangan Asesor</span>
                    </div>
                    <div class="space-y-2">
                        <input type="date" class="w-full p-2 border border-gray-300 rounded-md" value="2025-03-15">
                        <div class="font-semibold">Asesor</div>
                        <div class="text-lg font-bold">Nafa Popcorn</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4 mb-8">
            <button id="save-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg hover-scale">
                Simpan dan Selesai
            </button>
            <button id="print-btn" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors shadow-lg hover-scale">
                Cetak Sertifikat
            </button>
        </div>
    </div>

    <script>
        // Data for activities
        const activities = [
            { no: 1, code: "R.930PW000.011.2", activity: "Mengidentifikasi situasi konflik" },
            { no: 2, code: "R.930PW000.011.2", activity: "Mengikuti Prosedur Kesehatan, Keselamatan dan Keamanan di Tempat Kerja" },
            { no: 3, code: "R.930PW000.011.2", activity: "Melakukan Pekerjaan Dalam Lingkungan Sosial yang Berbeda" },
            { no: 4, code: "R.930PW000.011.2", activity: "Melakukan Komunikasi Melalui Telepon" },
            { no: 5, code: "R.930PW000.011.2", activity: "Melakukan Prosedur Administratif" },
            { no: 6, code: "R.930PW000.011.2", activity: "Mencari Data di Komputer" },
            { no: 7, code: "R.930PW000.011.2", activity: "Mengembangkan dan Memelihara Pengetahuan Pariwisata" },
            { no: 8, code: "R.930PW000.011.2", activity: "Mengimplementasikan Dasar-dasar Kepemimpinan Museum" },
            { no: 9, code: "R.930PW000.011.2", activity: "Mengembangkan Pengetahuan Tentang Koleksi dan Tata Pameran Museum" },
            { no: 10, code: "R.930PW000.011.2", activity: "Menyajikan Informasi tentang Koleksi dan Tata Pameran Museum" },
            { no: 11, code: "R.930PW000.011.2", activity: "Melakukan Kegiatan Interpretatif" },
            { no: 12, code: "R.930PW000.011.2", activity: "Memandu Rombongan Pengunjung" }
        ];

        // Data for competency units
        const competencyUnits = [
            {
                title: "Unit Kompetensi No 1",
                code: "R.930PW000.011.2",
                description: "Mengimplementasikan Dasar-dasar Kepemimpinan Museum",
                elements: [
                    { no: 1, element: "Menerapkan Prinsip 'Edutainment'", sop: "SOP Menerapkan Prosedur" },
                    { no: 2, element: "Menerapkan Pengetahuan tentang Museum", sop: "SOP Menerapkan Prosedur" },
                    { no: 3, element: "Mengembangkan Pengetahuan", sop: "SOP Menerapkan Prosedur" }
                ]
            },
            {
                title: "Unit Kompetensi No 2",
                code: "R.930PW000.011.2",
                description: "Mengimplementasikan Dasar-dasar Kepemimpinan Museum",
                elements: [
                    { no: 1, element: "Menerapkan Prinsip 'Edutainment'", sop: "SOP Menerapkan Prosedur" },
                    { no: 2, element: "Menerapkan Pengetahuan tentang Museum", sop: "SOP Menerapkan Prosedur" },
                    { no: 3, element: "Mengembangkan Pengetahuan", sop: "SOP Menerapkan Prosedur" }
                ]
            },
            {
                title: "Unit Kompetensi No 3",
                code: "R.930PW000.011.2",
                description: "Mengimplementasikan Dasar-dasar Kepemimpinan Museum",
                elements: [
                    { no: 1, element: "Menerapkan Prinsip 'Edutainment'", sop: "SOP Menerapkan Prosedur" },
                    { no: 2, element: "Menerapkan Pengetahuan tentang Museum", sop: "SOP Menerapkan Prosedur" },
                    { no: 3, element: "Mengembangkan Pengetahuan", sop: "SOP Menerapkan Prosedur" }
                ]
            },
            {
                title: "Unit Kompetensi No 4",
                code: "R.930PW000.011.2",
                description: "Mengimplementasikan Dasar-dasar Kepemimpinan Museum",
                elements: [
                    { no: 1, element: "Menerapkan Prinsip 'Edutainment'", sop: "SOP Menerapkan Prosedur" },
                    { no: 2, element: "Menerapkan Pengetahuan tentang Museum", sop: "SOP Menerapkan Prosedur" },
                    { no: 3, element: "Mengembangkan Pengetahuan", sop: "SOP Menerapkan Prosedur" }
                ]
            }
        ];

        // Populate activities table
        function populateActivitiesTable() {
            const tableBody = $('#activities-table');
            activities.forEach(activity => {
                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 p-3">${activity.no}</td>
                        <td class="border border-gray-300 p-3">${activity.code}</td>
                        <td class="border border-gray-300 p-3">${activity.activity}</td>
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
                                        <th class="border border-gray-300 p-3 text-left">Elemen</th>
                                        <th class="border border-gray-300 p-3 text-left">Benchmark</th>
                                        <th class="border border-gray-300 p-3 text-left">Kompetensi</th>
                                        <th class="border border-gray-300 p-3 text-left">Penilaian Lanjut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${unit.elements.map(element => `
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 p-3">${element.no}</td>
                                            <td class="border border-gray-300 p-3">${element.element}</td>
                                            <td class="border border-gray-300 p-3">${element.sop}</td>
                                            <td class="border border-gray-300 p-3">
                                                Kompeten
                                            </td>
                                            <td class="border border-gray-300 p-3">
                                                Ah keren lu Broh!
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
            const ulanganBaik = 0; // This would be calculated based on your specific logic

            $('#kompeten-count').text(kompeten);
            $('#belum-kompeten-count').text(belumKompeten);
            $('#tidak-kompeten-count').text(tidakKompeten);
            $('#ulangan-baik-count').text(ulanganBaik);
        }

        // Event handlers
        $(document).ready(function() {
            populateActivitiesTable();
            generateCompetencyUnits();

            // Handle competency selection changes
            $(document).on('change', '.competency-select', function() {
                updateCounts();
            });

            // Save button
            $('#save-btn').click(function() {
                const formData = {
                    certificate: 'SKIM16022000232719',
                    participant: 'Muhammad Rifal',
                    assessor: 'Nafa Popcorn',
                    performance: $('input[name="kinerja"]:checked').val(),
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

                console.log('Form data:', formData);
                alert('Data berhasil disimpan!');
            });

            // Print button
            $('#print-btn').click(function() {
                window.print();
            });
        });
    </script>

@endsection
