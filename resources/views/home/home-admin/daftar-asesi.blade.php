@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Asesi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
  <div class="container mx-auto">

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 shadow-sm border border-green-200">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 shadow-sm border border-red-200">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Page Header -->
    <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Manajemen Asesi
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Terakhir diperbarui: {{ now()->format('d F Y') }}
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Overview Statistics Card -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Statistik Asesi</h2>
        <p class="text-gray-600 mb-4">
                Halaman ini mengelola proses penugasan asesi ke asesor dan event sertifikasi. 
                Admin dapat menyetujui formulir APL-01 yang diajukan, mengassign asesi yang sudah disetujui ke asesor yang sesuai,
                serta melacak histori penugasan. Penugasan asesi ke asesor yang tepat dan pada event yang sesuai merupakan 
                langkah penting dalam menjamin kualitas proses sertifikasi kompetensi.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending APL.01 -->
            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                        <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-blue-800">Asesi Pengajuan Menunggu Persetujuan APL.01</h4>
                        <p class="mt-1 text-xl font-semibold text-blue-900">{{ $asesiPengajuan->total() }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Asesi -->
            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                        <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-green-800">Total Asesi</h4>
                        <p class="mt-1 text-xl font-semibold text-green-900">{{ $totalAsesi }}</p>
                    </div>
                </div>
            </div>

            <!-- Unassigned Asesi -->
            <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-500 bg-opacity-10">
                        <svg class="h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-sm font-medium text-indigo-800">Asesi Belum Di-assign ke Asesor</h4>
                        <p class="mt-1 text-xl font-semibold text-indigo-900">{{ $asesi->total() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions Section (Accordion) -->
    <div class="bg-white rounded-lg shadow-md mb-8 overflow-hidden">
        <button id="accordion-button" class="w-full flex items-center justify-between px-6 py-4 bg-blue-50 hover:bg-blue-100 transition-colors focus:outline-none">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-blue-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-lg font-bold text-gray-800">Petunjuk Penggunaan</h2>
            </div>
            <svg id="accordion-icon" class="h-5 w-5 text-blue-600 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        
        <div id="accordion-content" class="border-t border-gray-200 px-6 py-4 hidden">
            <div class="text-gray-700 space-y-4">
                <p>Halaman ini terdiri dari dua bagian utama:</p>
                
                <div class="ml-4 border-l-2 border-blue-200 pl-4">
                    <h3 class="font-bold text-blue-800 mb-2">1. Daftar Calon Asesi (Tabel Atas)</h3>
                    <ul class="list-disc ml-5 space-y-2">
                        <li>Tabel ini menampilkan daftar calon asesi yang telah mengajukan formulir APL-01</li>
                        <li>Admin perlu <span class="font-semibold">memeriksa formulir APL-01</span> dengan mengklik tombol "Detail Pengajuan"</li>
                        <li>Jika formulir sudah sesuai, klik tombol "Setujui" untuk menyetujui pengajuan</li>
                        <li>Setelah disetujui, asesi akan muncul pada tabel bagian bawah untuk di-assign ke asesor</li>
                    </ul>
                </div>
                
                <div class="ml-4 border-l-2 border-green-200 pl-4">
                    <h3 class="font-bold text-blue-800 mb-2">2. Assign Asesi ke Asesor (Tabel Tengah)</h3>
                    <ul class="list-disc ml-5 space-y-2">
                        <li>Tabel ini menampilkan daftar asesi yang telah disetujui formulir APL-01 nya</li>
                        <li>Admin dapat memilih beberapa asesi <span class="font-semibold">sekaligus</span> dengan mencentang kotak di sebelah kiri</li>
                        <li>Pilih asesor yang sesuai dari dropdown yang tersedia</li>
                        <li>Pilih event untuk pelaksanaan asesmen</li>
                        <li>Klik tombol "Assign Asesor" untuk menetapkan asesor pada asesi yang dipilih</li>
                    </ul>
                </div>
                
                <div class="ml-4 border-l-2 border-yellow-200 pl-4">
                    <h3 class="font-bold text-blue-800 mb-2">3. Histori Assignment (Tabel Bawah)</h3>
                    <ul class="list-disc ml-5 space-y-2">
                        <li>Tabel ini menampilkan daftar asesi yang sudah di-assign ke asesor</li>
                        <li>Admin dapat melihat detail assignment termasuk event yang dipilih</li>
                        <li>Gunakan filter untuk mencari berdasarkan event</li>
                    </ul>
                </div>
                
                <p class="bg-yellow-50 p-3 rounded-md border border-yellow-200 text-yellow-800">
                    <span class="font-bold">Catatan:</span> Gunakan filter skema sertifikasi untuk memudahkan pengelolaan data di semua tabel.
                </p>
            </div>
        </div>
    </div>

    <!-- Section 1: Persetujuan Formulir APL-01 -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b pb-3">Daftar Pengajuan Calon Asesi</h2>
        
        <!-- Filter Skema for Table 1 -->
        <div class="mb-6">
            <label for="filter-skema-1" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Skema:</label>
            <select id="filter-skema-1" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Skema</option>
                @foreach($skema as $s)
                    <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Table 1: Calon Asesi -->
        <div class="overflow-x-auto">
            <table id="calon-asesi-table" class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Nama Calon Asesi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Tanggal Daftar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Skema</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Pengajuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if($asesiPengajuan->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data pengajuan calon asesi yang tersedia</td>
                        </tr>
                    @else
                        @foreach($asesiPengajuan as $index => $asesi_pengajuan)
                            <tr class="hover:bg-gray-50 data-row" data-skema="{{ $asesi_pengajuan->id_skema }}">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ ($asesiPengajuan->currentPage() - 1) * $asesiPengajuan->perPage() + $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $asesi_pengajuan->nama_user }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($asesi_pengajuan->created_at)->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $asesi_pengajuan->nama_skema }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <a href="{{ route('admin.asesi.detail', $asesi_pengajuan->id_pengajuan) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded text-xs sm:text-sm font-medium transition-colors w-full sm:w-auto text-center">
                                        Detail Pengajuan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center">
            {{ $asesiPengajuan->links() }}
        </div>
    </div>

    <!-- Section 2: Assign Asesi ke Asesor -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b pb-3">Assign Asesi ke Asesor</h2>

        <!-- Filter Skema for Table 2 -->
        <div class="mb-6">
            <label for="filter-skema-2" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Skema:</label>
            <select id="filter-skema-2" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Skema</option>
                @foreach($skema as $s)
                    <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
                @endforeach
            </select>
        </div>

        <form action="{{ route('assign.asesor') }}" method="POST">
            @csrf
            <!-- Table 2: Assign Asesi -->
            <div class="overflow-x-auto">
                <table id="assign-table" class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Nama Asesi</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">NIM</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Skema</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($asesi->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi yang tersedia</td>
                            </tr>
                        @else
                            @foreach($asesi as $index => $data)
                                <tr class="hover:bg-gray-50 assign-row" data-skema="{{ $data->id_skema ?? '' }}">
                                    <td class="px-4 py-3 text-sm">
                                        @if($data && $data->id_asesi)
                                            <input type="checkbox" class="asesi-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="assign_asesi[]" value="{{ $data->id_asesi }}">
                                        @else
                                            <input type="checkbox" class="rounded border-gray-300 text-gray-400" disabled>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ ($asesi->currentPage() - 1) * $asesi->perPage() + $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $data->nama_asesi ?? 'Nama Asesi tidak tersedia' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $data->nim ?? 'NIM tidak tersedia' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $data->skema->nama_skema ?? 'Skema tidak tersedia' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination for second table -->
            <div class="mt-4 flex justify-center">
                {{ $asesi->links() }}
            </div>

            <!-- Selection Controls -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!-- Bidang Kompetensi Selection -->
                <div>
                    <label for="bidang_kompetensi" class="block text-sm font-medium text-gray-700 mb-2">Filter Bidang Kompetensi:</label>
                    <select id="bidang_kompetensi" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Bidang Kompetensi</option>
                        @foreach($bidangKompetensi as $bidang)
                            <option value="{{ $bidang->id_bidang_kompetensi }}">{{ $bidang->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Asesor Selection -->
                <div>
                    <label for="asesor" class="block text-sm font-medium text-gray-700 mb-2">Pilih Asesor:</label>
                    <select id="asesor" name="id_asesor" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Asesor</option>
                        @foreach($asesors as $asesor)
                            <option value="{{ $asesor->id_asesor }}">{{ $asesor->nama_asesor }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Event Selection (Replaces Periode and Tahun) -->
                <div class="col-span-2">
                    <label for="id_event" class="block text-sm font-medium text-gray-700 mb-2">Event Asesmen:</label>
                    <select id="id_event" name="id_event" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Event</option>
                        @foreach($activeEvents as $event)
                            <option value="{{ $event->id_event }}">
                                {{ $event->nama_event }} (Periode {{ $event->periode_pelaksanaan }}/{{ $event->tahun_pelaksanaan }}) - {{ $event->tuk->nama_tuk ?? 'TUK tidak tersedia' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Event yang ditampilkan adalah event yang sedang aktif saat ini</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-md font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Assign Asesor
                </button>
            </div>
        </form>
    </div>

    <!-- Section 3: Histori Assignment -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b pb-3">Histori Assignment Asesi ke Asesor</h2>

        <!-- Filter Event for History Table -->
        <div class="mb-6">
            <label for="filter-event" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Event:</label>
            <select id="filter-event" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Event</option>
                @foreach($allEvents as $evt)
                    <option value="{{ $evt->id_event }}">{{ $evt->nama_event }} (P{{ $evt->periode_pelaksanaan }}/{{ $evt->tahun_pelaksanaan }})</option>
                @endforeach
            </select>
        </div>

        <!-- History Table -->
        <div class="overflow-x-auto">
            <table id="history-table" class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Nama Asesi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Skema</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Asesor</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Event</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Tanggal Assignment</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if($assignments->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data assignment yang tersedia</td>
                        </tr>
                    @else
                        @foreach($assignments as $index => $assignment)
                            <tr class="hover:bg-gray-50 history-row" data-event="{{ $assignment->id_event }}">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ ($assignments->currentPage() - 1) * $assignments->perPage() + $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $assignment->asesi->nama_asesi ?? 'Nama tidak tersedia' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $assignment->asesi->skema->nama_skema ?? 'Skema tidak tersedia' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $assignment->asesor->nama_asesor ?? 'Asesor tidak tersedia' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $assignment->event->nama_event ?? 'Event tidak tersedia' }}
                                    <span class="text-xs text-gray-500">(P{{ $assignment->event->periode_pelaksanaan ?? '-' }}/{{ $assignment->event->tahun_pelaksanaan ?? '-' }})</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($assignment->created_at)->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination for history table -->
        <div class="mt-4 flex justify-center">
            {{ $assignments->links() }}
        </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Dependent dropdown untuk bidang kompetensi dan asesor
    const bidangKompetensiSelect = document.getElementById('bidang_kompetensi');
    const asesorSelect = document.getElementById('asesor');
    
    bidangKompetensiSelect.addEventListener('change', function() {
      const selectedBidangId = this.value;
      
      // Reset dropdown asesor
      asesorSelect.innerHTML = '<option value="">Pilih Asesor</option>';
      
      if (selectedBidangId) {
        // Tampilkan indikator loading
        asesorSelect.innerHTML = '<option value="">Loading...</option>';
        
        // Fetch asesor yang memiliki bidang kompetensi yang dipilih
        fetch(`/admin/get-asesor-by-bidang/${selectedBidangId}`)
          .then(response => response.json())
          .then(data => {
            // Reset opsi
            asesorSelect.innerHTML = '<option value="">Pilih Asesor</option>';
            
            // Tambahkan opsi baru
            if (data.length > 0) {
              data.forEach(asesor => {
                const option = document.createElement('option');
                option.value = asesor.id_asesor;
                option.textContent = asesor.nama_asesor;
                asesorSelect.appendChild(option);
              });
            } else {
              asesorSelect.innerHTML = '<option value="">Tidak ada asesor dengan bidang ini</option>';
            }
          })
          .catch(error => {
            console.error('Error fetching asesor data:', error);
            asesorSelect.innerHTML = '<option value="">Error loading data</option>';
          });
      } else {
        asesorSelect.innerHTML = '<option value="">Loading...</option>';

        // Jika tidak ada bidang yang dipilih, tampilkan semua asesor
        fetch('/admin/get-all-asesor')
          .then(response => response.json())
          .then(data => {
            asesorSelect.innerHTML = '<option value="">Pilih Asesor</option>';
            
            data.forEach(asesor => {
              const option = document.createElement('option');
              option.value = asesor.id_asesor;
              option.textContent = asesor.nama_asesor;
              asesorSelect.appendChild(option);
            });
          })
          .catch(error => {
            console.error('Error fetching all asesors:', error);
          });
      }
    });
    

    // Filter functionality for first table
    const filterSkema1 = document.getElementById('filter-skema-1');
    const dataRows = document.querySelectorAll('#calon-asesi-table .data-row');

    filterSkema1.addEventListener('change', function() {
        const selectedSkema = this.value;
        
        dataRows.forEach(row => {
            if (!selectedSkema || row.getAttribute('data-skema') === selectedSkema) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality for second table
    const filterSkema2 = document.getElementById('filter-skema-2');
    const assignRows = document.querySelectorAll('#assign-table .assign-row');

    filterSkema2.addEventListener('change', function() {
        const selectedSkema = this.value;
        
        assignRows.forEach(row => {
            if (!selectedSkema || row.getAttribute('data-skema') === selectedSkema) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
  });

  // Update the existing form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const selectedAsesi = document.querySelectorAll('.asesi-checkbox:checked');
    const selectedEvent = document.getElementById('id_event').value;
    const selectedAsesor = document.getElementById('asesor').value;
    
    if (selectedAsesi.length === 0) {
        e.preventDefault();
        alert('Pilih minimal satu asesi untuk di-assign.');
    }
    
    if (!selectedEvent) {
        e.preventDefault();
        alert('Pilih event untuk assignment.');
    }
    
    if (!selectedAsesor) {
        e.preventDefault();
        alert('Pilih asesor untuk assignment.');
    }
});

// Add loading indicator when events are being fetched
document.addEventListener('DOMContentLoaded', function() {
    const eventSelect = document.getElementById('id_event');
    
    if (eventSelect && eventSelect.options.length <= 1) {
        const option = document.createElement('option');
        option.textContent = 'Tidak ada event aktif saat ini';
        option.disabled = true;
        eventSelect.appendChild(option);
    }
});

// Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    const accordionButton = document.getElementById('accordion-button');
    const accordionContent = document.getElementById('accordion-content');
    const accordionIcon = document.getElementById('accordion-icon');
    
    accordionButton.addEventListener('click', function() {
        // Toggle the content visibility
        accordionContent.classList.toggle('hidden');
        
        // Rotate the icon
        if (accordionContent.classList.contains('hidden')) {
            accordionIcon.classList.remove('rotate-180');
        } else {
            accordionIcon.classList.add('rotate-180');
        }
    });
    
    // Filter functionality for history table
    const filterEvent = document.getElementById('filter-event');
    const historyRows = document.querySelectorAll('#history-table .history-row');
    
    filterEvent.addEventListener('change', function() {
        const selectedEvent = this.value;
        
        historyRows.forEach(row => {
            if (!selectedEvent || row.getAttribute('data-event') === selectedEvent) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Select all checkbox functionality
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.asesi-checkbox');
    
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) {
                checkbox.checked = selectAll.checked;
            }
        });
    });
});
</script>
@endsection