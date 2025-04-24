@extends('home.home-admin.layouts.layout')

@section('title', 'Detail Event - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    .badge {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-blue {
        background-color: rgba(59, 130, 246, 0.1);
        color: rgba(29, 78, 216, 1);
    }
    
    .badge-green {
        background-color: rgba(16, 185, 129, 0.1);
        color: rgba(6, 95, 70, 1);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Detail Event: {{ $event->nama_event ?? 'Event '.$event->id_event }}
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-xl text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            {{ $event->tanggal_mulai_event->format('d M Y') }} - {{ $event->tanggal_berakhir_event->format('d M Y') }}
                        </div>
                        
                        <div class="mt-2 flex items-center text-xl text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $event->tuk->nama_tuk ?? 'TUK Belum Ditentukan' }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex md:mt-0">
                    <a href="{{ route('admin.event.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                    
                    <a href="{{ route('admin.event.edit', $event->id_event) }}" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Event
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            @php
                $today = \Carbon\Carbon::now();
                $status = '';
                $statusClass = '';
                
                if ($today->lt($event->tanggal_mulai_event)) {
                    $status = 'Akan Datang';
                    $statusClass = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                } elseif ($today->gt($event->tanggal_berakhir_event)) {
                    $status = 'Selesai';
                    $statusClass = 'bg-gray-100 text-gray-800 border-gray-200';
                } else {
                    $status = 'Aktif';
                    $statusClass = 'bg-green-100 text-green-800 border-green-200';
                }
            @endphp
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }} border">
                <span class="w-2 h-2 mr-2 rounded-full {{ str_replace('bg-', 'bg-', str_replace('100', '500', $statusClass)) }}"></span>
                Status: {{ $status }}
            </span>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Skema Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 bg-blue-50">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                            <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-blue-800">Jumlah Skema</h4>
                            <p class="mt-1 text-xl font-semibold text-blue-900">{{ $uniqueSkemaCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <p class="text-sm text-gray-600">
                        Jumlah skema sertifikasi yang terlibat dalam event ini.
                    </p>
                </div>
            </div>
            
            <!-- Total Asesi Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 bg-green-50">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-green-800">Jumlah Asesi</h4>
                            <p class="mt-1 text-xl font-semibold text-green-900">{{ $asesiCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <p class="text-sm text-gray-600">
                        Jumlah asesi yang mengikuti sertifikasi dalam event ini.
                    </p>
                </div>
            </div>
            
            <!-- Total Asesor Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-5 border-b border-gray-200 bg-purple-50">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                            <svg class="h-6 w-6 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-purple-800">Jumlah Asesor</h4>
                            <p class="mt-1 text-xl font-semibold text-purple-900">{{ $asesorCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <p class="text-sm text-gray-600">
                        Jumlah asesor yang terlibat dalam proses sertifikasi event ini.
                    </p>
                </div>
            </div>
        </div>

        <!-- Event Detail Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Event</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Nama Event</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $event->nama_event ?? 'Event '.$event->id_event }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">ID Event</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $event->id_event }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tipe Event</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $event->tipe_event }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <dl class="grid grid-cols-1 gap-4">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $event->tanggal_mulai_event->format('d F Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Berakhir</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $event->tanggal_berakhir_event->format('d F Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">TUK (Tempat Uji Kompetensi)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $event->tuk->nama_tuk ?? 'TUK tidak ditemukan' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Tabs for Tables -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex">
                    <button data-tab-target="skema" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                        Skema Sertifikasi
                    </button>
                    <button data-tab-target="asesi" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Asesi
                    </button>
                    <button data-tab-target="asesor" class="w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Asesor
                    </button>
                </nav>
            </div>
            
            <!-- Skema Table -->
            <div data-tab-content="skema" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Skema</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Asesi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($skemas as $index => $skema)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $skema->nama_skema }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $skema->asesi_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada skema yang terdaftar di event ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Asesi Table -->
            <div data-tab-content="asesi" class="overflow-x-auto hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Asesi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skema</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asesor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($asesis as $index => $asesi)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asesi->nama_asesi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asesi->skema->nama_skema ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asesi->asesor->nama_asesor ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada asesi yang terdaftar di event ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Asesor Table -->
            <div data-tab-content="asesor" class="overflow-x-auto hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Asesor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Asesi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($asesors as $index => $asesor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asesor->nama_asesor }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asesor->asesi_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada asesor yang terlibat di event ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all tab buttons and content sections
        const tabButtons = document.querySelectorAll('[data-tab-target]');
        const tabContents = document.querySelectorAll('[data-tab-content]');
        
        // Set default active tab (skema)
        setActiveTab('skema');
        
        // Add click event listeners to tab buttons
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tabName = button.getAttribute('data-tab-target');
                setActiveTab(tabName);
            });
        });
        
        // Function to set active tab
        function setActiveTab(tabName) {
            // Update button styles
            tabButtons.forEach(button => {
                const buttonTabName = button.getAttribute('data-tab-target');
                if (buttonTabName === tabName) {
                    button.classList.add('border-blue-500', 'text-blue-600');
                    button.classList.remove('border-transparent', 'text-gray-500');
                } else {
                    button.classList.remove('border-blue-500', 'text-blue-600');
                    button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                }
            });
            
            // Show/hide appropriate content
            tabContents.forEach(content => {
                const contentTabName = content.getAttribute('data-tab-content');
                if (contentTabName === tabName) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        }
    });
</script>
@endsection
@endsection