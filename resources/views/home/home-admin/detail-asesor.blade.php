@extends('home.home-admin.layouts.layout')

@section('title', 'Detail Asesor - Lembaga Sertifikasi Profesi UGM')

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
    
    .badge-purple {
        background-color: rgba(139, 92, 246, 0.1);
        color: rgba(91, 33, 182, 1);
    }
    
    .badge-red {
        background-color: rgba(239, 68, 68, 0.1);
        color: rgba(185, 28, 28, 1);
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
                        Detail Asesor
                    </h2>
                    <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="mt-2 flex items-center text-sm text-gray-500">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            {{ $asesor->nama_asesor }}
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex md:mt-0">
                    <a href="{{ route('admin.pengguna.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Informasi Dasar -->
        <div class="bg-white shadow overflow-hidden rounded-lg divide-y divide-gray-200 mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Informasi Asesor
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Detail informasi dasar asesor.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Nama Lengkap
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->nama_asesor }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Email
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->email }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Kode Registrasi
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->kode_registrasi ?: '-' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            No. HP
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->no_hp ?: '-' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            No. Sertifikat BNSP Asesor Kompetensi
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->no_sertifikat ?: '-' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            No. KTP
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $asesor->no_ktp ?: '-' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Sertifikat BNSP Asesor Kompetensi
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($asesor->file_sertifikat_asesor)
                                <a href="{{ asset('storage/sertifikat_asesor/' . $asesor->file_sertifikat_asesor) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                    Lihat File
                                </a>
                            @else
                                <span class="text-gray-500 italic">Tidak ada file</span>
                            @endif
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Masa Berlaku
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($asesor->masa_berlaku)
                            {{ \Carbon\Carbon::parse($asesor->masa_berlaku)->format('d F Y') }}
                            @else
                            -
                            @endif
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">
                            Status
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($asesor->status_asesor == 'Aktif')
                                <span class="badge badge-green">Aktif</span>
                            @else
                                <span class="badge badge-red">Tidak Aktif</span>
                            @endif
                        </dd>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bidang Kompetensi -->
        <div class="bg-white shadow overflow-hidden rounded-lg divide-y divide-gray-200 mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Bidang Kompetensi
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Daftar bidang kompetensi yang dimiliki asesor.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if(count($asesor->bidang_kompetensi) > 0)
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($asesor->bidang_kompetensi as $bidang)
                            <li class="flex items-center">
                                <span class="mr-2 text-purple-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="text-sm text-gray-800">{{ $bidang['nama_bidang'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-gray-500 italic">
                        Tidak ada bidang kompetensi.
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sertifikat Kompetensi Teknis -->
        <div class="bg-white shadow overflow-hidden rounded-lg divide-y divide-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Sertifikat Kompetensi Teknis
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Daftar sertifikat kompetensi teknis yang dimiliki asesor.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                @if(count($sertifikat) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lembaga Sertifikasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Skema Kompetensi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masa Berlaku</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sertifikat as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->lembaga_sertifikasi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->skema_kompetensi }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->masa_berlaku)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($item->file_sertifikat)
                                                <a href="{{ asset('storage/sertifikat/' . $item->file_sertifikat) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                    Lihat File
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-gray-500 italic">
                        Tidak ada data sertifikat kompetensi teknis.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection