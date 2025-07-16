@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - FR.IA-02')

@section('content')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-sm">
                <i class="fas fa-home text-blue-600"></i>
                <span class="breadcrumb-item">Home</span>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <span class="breadcrumb-item">Formulir IA.02</span>
            </div>
        </nav>

        <!-- Form Section -->
        <div class="floating-card bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-purple-600">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clipboard-list text-white text-lg"></i>
                    <h2 class="text-xl font-bold text-white">FR.IA.02. Tugas Praktik Demonstrasi</h2>
                </div>
            </div>

            <!-- Table Container -->
            <div class="table-container">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="table-header border-b-2">
                        <tr>
                            <th class="px-6 py-4 text-left text-l font-medium text-gray-800 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <span>No.</span>
                                    <span>Kode Skema</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-l font-medium text-gray-800 uppercase tracking-wider">
                                Skema Sertifikasi
                            </th>
                            <th class="px-6 py-4 text-left text-l font-medium text-gray-800 uppercase tracking-wider">
                                Tujuan Asesi
                            </th>
                            <th class="px-6 py-4 text-left text-l font-medium text-gray-800 uppercase tracking-wider">
                                Jadwal Pelaksanaan
                            </th>
                            <th class="px-6 py-4 text-left text-l font-medium text-gray-800 uppercase tracking-wider">
                                Nama Asesor
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="data-table">
                            <tr class="hover-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">1</div>
                                            <div class="text-xs text-gray-500">{{ $data['nomor_skema'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $data['nama_skema'] }}</div>
                                    <div class="text-xs text-gray-500">Skema Sertifikasi</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="status-badge ${statusClass}">{{ $data['tujuan_asesi'] }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $data['tanggal_asesi'] }}</div>
                                    <div class="text-xs text-gray-500">Jadwal Pelaksanaan</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $data['nama_asesor'] }}</div>
                                    <div class="text-xs text-gray-500">Asesor</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center text-sm text-gray-600">
                <p>Copyright © 2025 PT. Kirana Adhirajasa Indonesia untuk
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Jana Dharma Indonesia</a>.
                    All rights reserved.
                </p>
                <p class="mt-2">
                    <span class="font-medium">Version</span> 3.1.7
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Sample data for the table
        const tableData = [
            {
                no: 1,
                kodeSkema: "SKM/1602/00014/3/2024/36",
                skemaSertifikasi: "Melaksanakan Konsultasi Perencanaan Destinasi Pariwisata",
                tujuanAsesi: "Sertifikasi",
                jadwalPelaksanaan: "25 Oktober 2024 16:00:00",
                namaAsesor: "MINTA HARSANA"
            },
            {
                no: 2,
                kodeSkema: "SKM/1602/00009/2/2019/17",
                skemaSertifikasi: "Travel Consultant",
                tujuanAsesi: "Sertifikasi Ulang",
                jadwalPelaksanaan: "12 November 2022 13:20:00",
                namaAsesor: "JOKO KUNTORO"
            },
            {
                no: 3,
                kodeSkema: "SKM/1602/00010/3/2022/19",
                skemaSertifikasi: "Pelayanan Pelanggan",
                tujuanAsesi: "Sertifikasi",
                jadwalPelaksanaan: "22 Oktober 2022 14:11:00",
                namaAsesor: "Carlos Iban"
            },
            {
                no: 4,
                kodeSkema: "SKM/1602/00018/2/2022/31",
                skemaSertifikasi: "Pemandu Museum",
                tujuanAsesi: "Sertifikasi",
                jadwalPelaksanaan: "22 Oktober 2022 14:14:00",
                namaAsesor: "Carlos Iban"
            },
            {
                no: 5,
                kodeSkema: "SKM/1602/00018/3/2022/32",
                skemaSertifikasi: "Kepemanduan Outbound",
                tujuanAsesi: "Sertifikasi",
                jadwalPelaksanaan: "22 Oktober 2022 14:13:00",
                namaAsesor: "Carlos Iban"
            },
            {
                no: 6,
                kodeSkema: "SKM/1602/00018/3/2022/33",
                skemaSertifikasi: "Kepemanduan Ekowisata",
                tujuanAsesi: "Sertifikasi",
                jadwalPelaksanaan: "22 Oktober 2022 14:13:00",
                namaAsesor: "Carlos Iban"
            },
            {
                no: 7,
                kodeSkema: "SKM/1602/00019/3/2022/29",
                skemaSertifikasi: "Pendampingan dan Penghubung VVIP-VIP",
                tujuanAsesi: "Sertifikasi",
                jadwalPelaksanaan: "22 Oktober 2022 14:12:00",
                namaAsesor: "Carlos Iban"
            }
        ];

        // Function to populate table
        // function populateTable() {
        //     const tableBody = $('#data-table');
        //     tableBody.empty();
        //
        //     tableData.forEach((item, index) => {
        //         const statusClass = item.tujuanAsesi === 'Sertifikasi' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
        //
        //         const row = `
        //
        //         `;
        //         tableBody.append(row);
        //     });
        // }

        // Initialize
        $(document).ready(function() {
            populateTable();

            // Profile dropdown toggle
            $('#profile-toggle').click(function(e) {
                e.stopPropagation();
                $('#profile-dropdown').toggleClass('active');
            });

            // Close dropdown when clicking outside
            $(document).click(function() {
                $('#profile-dropdown').removeClass('active');
            });

            // Prevent dropdown from closing when clicking inside
            $('#profile-dropdown').click(function(e) {
                e.stopPropagation();
            });

            // Mobile menu toggle
            $('#menu-toggle').click(function() {
                // Add mobile menu functionality here
                console.log('Mobile menu toggled');
            });

            // Search functionality
            $('input[placeholder="Cari sertifikasi..."]').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('#data-table tr').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(searchTerm));
                });
            });

            // Add click handlers for action buttons
            $(document).on('click', '.action-btn', function() {
                const action = $(this).text().trim();
                const row = $(this).closest('tr');
                const skema = row.find('td:nth-child(2)').text().trim();

                alert(`${action} - ${skema}`);
            });
        });
    </script>

@endsection
