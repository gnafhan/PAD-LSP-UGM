@extends('home.home-admin.layouts.layout')

@section('title', 'Home - Lembaga Sertifikasi Profesi UGM')

@section('content')
<!-- Header Tetap Melekat dengan Navbar -->
<header class="flex justify-between items-center bg-white p-4 shadow-md">
    <h1 class="text-2xl font-bold text-gray-700">Dashboard Admin</h1>
</header>

<!-- Main Content -->
<div class="min-h-screen bg-gray-100 p-6">
    <div class="container mx-auto">
        <!-- Info Cards Section -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1 Total Events -->
            <a href="{{ route('admin.event.index') }}" class="transform hover:scale-105 transition duration-300">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-b-4 border-blue-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Events</h2>
                                <p class="text-3xl font-bold text-blue-500">{{ $events }}</p>
                                <p class="text-gray-500 mt-1 text-sm">Active events available</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 2 Total Skema -->
            <a href="{{ route('admin.skema.index') }}" class="transform hover:scale-105 transition duration-300">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-b-4 border-green-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Skema</h2>
                                <p class="text-3xl font-bold text-green-500">{{ $skema }}</p>
                                <p class="text-gray-500 mt-1 text-sm">Available certification schemes</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 3 Total Asesi -->
            <a href="{{ route('admin.asesi.index') }}" class="transform hover:scale-105 transition duration-300">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-b-4 border-orange-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Asesi</h2>
                                <p class="text-3xl font-bold text-orange-500">{{ $asesi }}</p>
                                <p class="text-gray-500 mt-1 text-sm">Registered candidates</p>
                            </div>
                            <div class="bg-orange-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Card 4 Total Asesor -->
            <a href="{{ route('admin.pengguna.index') }}" class="transform hover:scale-105 transition duration-300">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-b-4 border-red-500">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Total Asesor</h2>
                                <p class="text-3xl font-bold text-red-500">{{ $asesor }}</p>
                                <p class="text-gray-500 mt-1 text-sm">Registered assessors</p>
                            </div>
                            <div class="bg-red-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </section>

        <!-- Skema Per Periode Section -->
        <section class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">Daftar Skema Sertifikasi Per Periode</h2>

            <!-- Filter Controls -->
            <div class="flex flex-wrap gap-4 mb-6">
                <div class="w-full md:w-1/3">
                    <label for="filter-periode" class="block text-sm font-medium text-gray-700 mb-2">Periode:</label>
                    <select id="filter-periode" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Periode</option>
                        <option value="1">Periode 1</option>
                        <option value="2">Periode 2</option>
                        <option value="3">Periode 3</option>
                        <option value="4">Periode 4</option>
                    </select>
                </div>

                <div class="w-full md:w-1/3">
                    <label for="filter-tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun:</label>
                    <select id="filter-tahun" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Tahun</option>
                        <!-- JavaScript will populate this -->
                    </select>
                </div>

                <div class="w-full md:w-1/3 flex items-end">
                    <button id="apply-filter" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Terapkan Filter
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table id="skema-periode-table" class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">
                            <div class="flex items-center">
                                No
                                {{-- <span class="sort-icon ml-1">↕</span> --}}
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">
                            <div class="flex items-center">
                                Nama Skema
                                {{-- <span class="sort-icon ml-1">↕</span> --}}
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">
                            <div class="flex items-center">
                                Periode
                                {{-- <span class="sort-icon ml-1">↕</span> --}}
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">
                            <div class="flex items-center">
                                Tahun
                                {{-- <span class="sort-icon ml-1">↕</span> --}}
                            </div>
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">
                            <div class="flex items-center">
                                Jumlah Asesi
                                {{-- <span class="sort-icon ml-1">↕</span> --}}
                            </div>
                        </th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($skemaStats->isEmpty())
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data skema per periode yang tersedia</td>
                            </tr>
                        @else
                            @foreach($skemaStats as $index => $stat)
                            <tr class="hover:bg-gray-50 skema-row" data-periode="{{ $stat->periode }}" data-tahun="{{ $stat->tahun }}">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->nama_skema }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->periode }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->tahun }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->jumlah_asesi }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Asesi Statistics Section - First Row -->
        <section class="mb-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Statistik Asesi</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Chart 1: Distribution of Asesi per Skema -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Distribusi Asesi per Skema</h3>
                    <div class="h-64">
                        <canvas id="skemaChart"></canvas>
                    </div>
                </div>

                <!-- Chart 2: Trend of Asesi by Year -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Trend Asesi per Tahun</h3>
                    <div class="h-64">
                        <canvas id="asesiYearChart"></canvas>
                    </div>
                </div>

                <!-- Chart 3: Trend of Asesi by Period -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Trend Asesi per Periode</h3>
                    <div class="h-64">
                        <canvas id="asesiPeriodChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skema Statistics Section - Second Row -->
        <section>
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Statistik Skema</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Chart 4: Skema Popularity (based on enrollment) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Popularitas Skema</h3>
                    <div class="h-64">
                        <canvas id="skemaPopularityChart"></canvas>
                    </div>
                </div>

                <!-- Chart 5: Trend of Skema by Year -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Trend Skema per Tahun</h3>
                    <div class="h-64">
                        <canvas id="skemaYearChart"></canvas>
                    </div>
                </div>

                <!-- Chart 6: Trend of Skema by Period -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Trend Skema per Periode</h3>
                    <div class="h-64">
                        <canvas id="skemaPeriodChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Populate year dropdown with current year and future years
    // Populate year dropdown with years from current to 5 years ahead
    const yearSelect = document.getElementById('filter-tahun');
    const currentYear = new Date().getFullYear();
    const years = [];

    // Create array of years
    for (let year = currentYear; year <= currentYear + 5; year++) {
        years.push(year);
    }

    // Sort years ascending and populate dropdown
    years.sort((a, b) => a - b);
    years.forEach(year => {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    });

    // Filter functionality for skema table
    const filterPeriode = document.getElementById('filter-periode');
    const filterTahun = document.getElementById('filter-tahun');
    const applyFilterBtn = document.getElementById('apply-filter');
    const skemaRows = document.querySelectorAll('.skema-row');

    applyFilterBtn.addEventListener('click', function() {
        const selectedPeriode = filterPeriode.value;
        const selectedTahun = filterTahun.value;

        skemaRows.forEach(row => {
            const periode = row.getAttribute('data-periode');
            const tahun = row.getAttribute('data-tahun');

            const periodeMatch = !selectedPeriode || periode === selectedPeriode;
            const tahunMatch = !selectedTahun || tahun === selectedTahun;

            if (periodeMatch && tahunMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

     // Prepare data for charts
     const asesiSkemaData = @json($asesiSkemaData);
    const asesiYearData = @json($asesiYearData);
    const asesiPeriodData = @json($asesiPeriodData);
    const skemaPopularityData = @json($skemaPopularityData);
    const skemaYearData = @json($skemaYearData);
    const skemaPeriodData = @json($skemaPeriodData);

    // Chart color palettes
    const colors = {
        primary: ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#14B8A6', '#F43F5E', '#6366F1', '#84CC16'],
        secondary: ['#1E40AF', '#047857', '#B45309', '#B91C1C', '#6D28D9', '#BE185D', '#0F766E', '#BE123C', '#4338CA', '#4D7C0F']
    };
    // ASESI CHARTS

    // 1. Distribution of Asesi per Skema (Doughnut chart)
    const skemaCtx = document.getElementById('skemaChart').getContext('2d');
    new Chart(skemaCtx, {
        type: 'doughnut',
        data: {
            labels: asesiSkemaData.labels,
            datasets: [{
                data: asesiSkemaData.data,
                backgroundColor: colors.primary
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });

    // 2. Trend of Asesi by Year (LINE chart - CHANGED FROM BAR)
    const asesiYearCtx = document.getElementById('asesiYearChart').getContext('2d');
    new Chart(asesiYearCtx, {
        type: 'line',
        data: {
            labels: asesiYearData.labels,
            datasets: [{
                label: 'Jumlah Asesi',
                data: asesiYearData.data,
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.2,
                pointBackgroundColor: '#4F46E5'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tahun',
                        font: { weight: 'bold' }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Asesi',
                        font: { weight: 'bold' }
                    },
                    ticks: { precision: 0 }
                }
            },
            plugins: { legend: { display: false } }
        }
    });

    // 3. Trend of Asesi by Period (Bar chart)
    const asesiPeriodCtx = document.getElementById('asesiPeriodChart').getContext('2d');
    new Chart(asesiPeriodCtx, {
        type: 'bar',
        data: {
            labels: asesiPeriodData.labels,
            datasets: [{
                label: 'Jumlah Asesi',
                data: asesiPeriodData.data,
                backgroundColor: colors.primary.slice(0, 4)
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Periode',
                        font: { weight: 'bold' }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Asesi',
                        font: { weight: 'bold' }
                    },
                    ticks: { precision: 0 }
                }
            },
            plugins: { legend: { display: false } }
        }
    });

    // SKEMA CHARTS

    // 4. Skema Popularity (Horizontal Bar chart - LIMITED TO TOP 5)
    const skemaPopularityCtx = document.getElementById('skemaPopularityChart').getContext('2d');
    new Chart(skemaPopularityCtx, {
        type: 'bar',
        data: {
            labels: skemaPopularityData.labels.slice(0, 5),
            datasets: [{
                label: 'Jumlah Asesi Terdaftar',
                data: skemaPopularityData.data.slice(0, 5),
                backgroundColor: colors.secondary.slice(0, 5)
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Asesi',
                        font: { weight: 'bold' }
                    },
                    ticks: { precision: 0 }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Nama Skema',
                        font: { weight: 'bold' }
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: function(tooltipItem) {
                            return tooltipItem[0].label;
                        },
                        label: function(context) {
                            return 'Asesi Terdaftar: ' + context.parsed.x;
                        }
                    }
                },
                title: {
                    display: true,
                    text: '5 Skema Terpopuler',
                    font: { size: 14 }
                }
            }
        }
    });

    // 5. Trend of Skema by Year (Line chart)
    const skemaYearCtx = document.getElementById('skemaYearChart').getContext('2d');
    new Chart(skemaYearCtx, {
        type: 'line',
        data: {
            labels: skemaYearData.labels,
            datasets: [{
                label: 'Jumlah Skema',
                data: skemaYearData.data,
                borderColor: '#4F46E5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.2,
                pointBackgroundColor: '#4F46E5'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tahun',
                        font: { weight: 'bold' }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Skema',
                        font: { weight: 'bold' }
                    },
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // 6. Trend of Skema by Period (BAR chart - CHANGED FROM POLAR AREA)
    const skemaPeriodCtx = document.getElementById('skemaPeriodChart').getContext('2d');
    new Chart(skemaPeriodCtx, {
        type: 'bar',
        data: {
            labels: skemaPeriodData.labels,
            datasets: [{
                label: 'Jumlah Skema',
                data: skemaPeriodData.data,
                backgroundColor: [
                    'rgba(79, 70, 229, 0.7)',
                    'rgba(16, 185, 129, 0.7)',
                    'rgba(245, 158, 11, 0.7)',
                    'rgba(239, 68, 68, 0.7)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Periode',
                        font: { weight: 'bold' }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Skema',
                        font: { weight: 'bold' }
                    },
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // For sorting the table
    let currentSort = {
        column: -1,
        asc: true
    };

    function sortTable(columnIndex) {
        const table = document.getElementById('skema-periode-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr:not([colspan])'));
        const headers = table.querySelectorAll('th');

        // Reset all sort icons
        headers.forEach(header => {
            const icon = header.querySelector('.sort-icon');
            icon.textContent = '↕';
        });

        // Update sort direction
        if (currentSort.column === columnIndex) {
            currentSort.asc = !currentSort.asc;
        } else {
            currentSort.column = columnIndex;
            currentSort.asc = true;
        }

        // Update clicked header's sort icon
        const clickedHeader = headers[columnIndex];
        const icon = clickedHeader.querySelector('.sort-icon');
        icon.textContent = currentSort.asc ? '↑' : '↓';

        // Sort the rows
        const sortedRows = rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();

            // Handle numeric columns (No, Periode, Tahun, Jumlah Asesi)
            if (columnIndex === 0 || columnIndex === 2 || columnIndex === 3 || columnIndex === 4) {
                return currentSort.asc
                    ? parseInt(aValue) - parseInt(bValue)
                    : parseInt(bValue) - parseInt(aValue);
            }

            // Handle text columns (Nama Skema)
            return currentSort.asc
                ? aValue.localeCompare(bValue)
                : bValue.localeCompare(aValue);
        });

        // Clear and append sorted rows
        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }

        sortedRows.forEach(row => tbody.appendChild(row));
    }
});
</script>
@endsection
