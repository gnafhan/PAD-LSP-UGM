@extends('home.home-admin.layouts.layout')

@section('title', 'Manajemen Tempat Uji Kompetensi (TUK) - Lembaga Sertifikasi Profesi UGM')

@section('styles')
<style>
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
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
    
    .tooltip {
        position: relative;
        display: inline-block;
    }
    
    .tooltip .tooltip-text {
        visibility: hidden;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        width: 220px;
        background-color: #4b5563;
        color: #fff;
        text-align: center;
        padding: 0.5rem;
        border-radius: 0.375rem;
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 0.75rem;
        pointer-events: none;
    }
    
    .tooltip:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
    
    .tooltip .tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #4b5563 transparent transparent transparent;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Alert Messages -->
        @if (session('success'))
        <div class="mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md" role="alert">
        <div class="flex">
          <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
          </div>
          <div class="ml-3">
              <p class="text-sm">{{ session('success') }}</p>
          </div>
          <div class="ml-auto pl-3">
              <div class="-mx-1.5 -my-1.5">
                  <button type="button" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                      <span class="sr-only">Dismiss</span>
                      <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                      </svg>
                  </button>
              </div>
          </div>
        </div>
        </div>
        @endif
        
        @if (session('error'))
        <div class="mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
        <div class="flex">
          <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
          </div>
          <div class="ml-3">
              <p class="text-sm">{{ session('error') }}</p>
          </div>
          <div class="ml-auto pl-3">
              <div class="-mx-1.5 -my-1.5">
                  <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                      <span class="sr-only">Dismiss</span>
                      <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                      </svg>
                  </button>
              </div>
          </div>
        </div>
        </div>
        @endif
        
        @if ($errors->any())
        <div class="mb-8 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md" role="alert">
        <div class="flex">
          <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
              </svg>
          </div>
          <div class="ml-3">
              <h3 class="text-sm font-medium">Ada beberapa kesalahan:</h3>
              <ul class="mt-1 list-disc list-inside text-sm">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          <div class="ml-auto pl-3">
              <div class="-mx-1.5 -my-1.5">
                  <button type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                      <span class="sr-only">Dismiss</span>
                      <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                      </svg>
                  </button>
              </div>
          </div>
        </div>
        </div>
        @endif
        
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Manajemen Tempat Uji Kompetensi (TUK)
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
                <div class="mt-5 flex md:mt-0 space-x-2">
                    <a href="{{ route('admin.tuk.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah TUK
                    </a>
                    <a href="javascript:void(0)" onclick="openModal('modalTambahPJ')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Penanggung Jawab
                    </a>
                </div>
            </div>
        </div>

        <!-- Overview Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 border-l-4 border-blue-500">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Informasi Tempat Uji Kompetensi</h3>
            <p class="text-gray-600 mb-4">
                Tempat Uji Kompetensi (TUK) adalah tempat yang digunakan untuk melaksanakan uji kompetensi dan asesmen kompetensi bagi para asesi.
                <span class="font-semibold text-blue-700">Perhatian!</span> Anda perlu menambahkan data Penanggung Jawab terlebih dahulu sebelum dapat menambahkan data TUK.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                            <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-blue-800">Total Tempat Uji Kompetensi</h4>
                            <p class="mt-1 text-xl font-semibold text-blue-900">{{ $totalTuk }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                            <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-green-800">Total Penanggung Jawab</h4>
                            <p class="mt-1 text-xl font-semibold text-green-900">{{ $totalPj }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penanggung Jawab Table -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Penanggung Jawab</h3>
                    
                    <div class="mt-4 md:mt-0">
                        <form method="GET" action="{{ route('admin.tuk.index') }}" class="flex rounded-md shadow-sm">
                        <!-- Menyimpan parameter pencarian TUK yang ada jika diperlukan -->
                        @if(request()->has('tuk_search'))
                            <input type="hidden" name="tuk_search" value="{{ request('tuk_search') }}">
                        @endif
                        
                        <!-- Menyimpan parameter pagination TUK jika diperlukan -->
                        @if(request()->has('tuk_page'))
                            <input type="hidden" name="tuk_page" value="{{ request('tuk_page') }}">
                        @endif
                        
                        <div class="relative w-full">
                            <input type="text" name="pj_search" value="{{ request('pj_search') }}" 
                                class="focus:ring-blue-500 focus:border-blue-500 block w-full rounded-l-md sm:text-sm border-gray-300 px-4 py-2"
                                placeholder="Cari Penanggung Jawab...">
                        </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>    
                                Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Penanggung Jawab</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($penanggungJawab as $index => $pj)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ($penanggungJawab->currentPage() - 1) * $penanggungJawab->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal">
                                    <div class="text-sm text-gray-900 font-medium">{{ $pj->nama_penanggung_jawab }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pj->status_penanggung_jawab == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pj->status_penanggung_jawab }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                    <a href="javascript:void(0)" onclick="editPJ('{{ $pj->id_penanggung_jawab }}', '{{ $pj->nama_penanggung_jawab }}', '{{ $pj->status_penanggung_jawab }}')" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-md text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Tidak ada data penanggung jawab</span>
                                        <a href="javascript:void(0)" onclick="openModal('modalTambahPJ')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                            Tambah Penanggung Jawab
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $penanggungJawab->firstItem() ?? 0 }} hingga {{ $penanggungJawab->lastItem() ?? 0 }} dari {{ $penanggungJawab->total() }} penanggung jawab
                    </div>
                    {{ $penanggungJawab->links() }}
                </div>
            </div>
        </div>

        <!-- TUK Table -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-lg">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Tempat Uji Kompetensi</h3>
                    
                    <div class="mt-4 md:mt-0">
                        <form method="GET" action="{{ route('admin.tuk.index') }}" class="flex rounded-md shadow-sm">
                            <!-- Menyimpan parameter pencarian PJ yang ada jika diperlukan -->
                            @if(request()->has('pj_search'))
                                <input type="hidden" name="pj_search" value="{{ request('pj_search') }}">
                            @endif
                            
                            <!-- Menyimpan parameter pagination PJ jika diperlukan -->
                            @if(request()->has('pj_page'))
                                <input type="hidden" name="pj_page" value="{{ request('pj_page') }}">
                            @endif
                            
                            <div class="relative w-full">
                                <input type="text" name="tuk_search" value="{{ request('tuk_search') }}" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full rounded-l-md sm:text-sm border-gray-300 px-4 py-2"
                                    placeholder="Cari TUK...">
                            </div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>    
                                Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode TUK</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama TUK</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penanggung Jawab</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tuk as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ($tuk->currentPage() - 1) * $tuk->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-md">{{ $item->kode_tuk }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-normal">
                                    <div class="text-sm text-gray-900 font-medium">{{ $item->nama_tuk }}</div>
                                    @if($item->no_lisensi_skkn)
                                        <div class="text-xs text-gray-500">No. Lisensi: {{ $item->no_lisensi_skkn }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 max-w-xs truncate">
                                    {{ $item->alamat }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($item->penanggungJawab)
                                        <div class="text-sm text-gray-900 font-medium">{{ $item->penanggungJawab->nama_penanggung_jawab }}</div>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="javascript:void(0)" onclick="editTUK('{{ $item->id_tuk }}', '{{ $item->kode_tuk }}', '{{ $item->nama_tuk }}', '{{ $item->alamat }}', '{{ $item->id_penanggung_jawab }}', '{{ $item->no_lisensi_skkn }}')" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-md text-white transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                                    <div class="flex flex-col items-center justify-center space-y-3">
                                        <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span>Tidak ada data TUK</span>
                                        <a href="{{ route('admin.tuk.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            Tambah TUK
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-white border-t border-gray-200 rounded-b-lg">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $tuk->firstItem() ?? 0 }} hingga {{ $tuk->lastItem() ?? 0 }} dari {{ $tuk->total() }} TUK
                    </div>
                    {{ $tuk->links() }}
                </div>
            </div>
        </div>

        <!-- Modal Tambah Penanggung Jawab -->
        <div id="modalTambahPJ" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-t-lg py-4 px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-white">Tambah Penanggung Jawab</h3>
                        <button type="button" class="text-white hover:text-gray-200" onclick="closeModal('modalTambahPJ')">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin.penanggung-jawab.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <!-- Nama Penanggung Jawab Field -->
                        <div>
                            <label for="nama_penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-1">Nama Penanggung Jawab <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_penanggung_jawab" id="nama_penanggung_jawab" 
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                placeholder="Contoh: John Doe" required>
                        </div>

                        <!-- Status Penanggung Jawab Field -->
                        <div>
                            <label for="status_penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status_penanggung_jawab" id="status_penanggung_jawab"
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                                <option value="" disabled selected>--- Pilih Status ---</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors" onclick="closeModal('modalTambahPJ')">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit Penanggung Jawab -->
        <div id="modalEditPJ" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg py-4 px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-white">Edit Penanggung Jawab</h3>
                        <button type="button" class="text-white hover:text-gray-200" onclick="closeModal('modalEditPJ')">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="formEditPJ" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_pj_id" name="id_penanggung_jawab">
                    <div class="space-y-4">
                        <!-- Nama Penanggung Jawab Field -->
                        <div>
                            <label for="edit_nama_penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-1">Nama Penanggung Jawab <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_penanggung_jawab" id="edit_nama_penanggung_jawab" 
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Contoh: John Doe" required value="{{ old('nama_penanggung_jawab') }}">
                        </div>

                        <!-- Status Penanggung Jawab Field -->
                        <div>
                            <label for="edit_status_penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status_penanggung_jawab" id="edit_status_penanggung_jawab"
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled>--- Pilih Status ---</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors" onclick="closeModal('modalEditPJ')">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                                Perbarui
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit TUK -->
        <div id="modalEditTUK" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-lg py-4 px-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-white">Edit Tempat Uji Kompetensi</h3>
                        <button type="button" class="text-white hover:text-gray-200" onclick="closeModal('modalEditTUK')">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="formEditTUK" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_tuk_id" name="id_tuk">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Kode TUK Field -->
                        <div>
                            <label for="edit_kode_tuk" class="block text-sm font-medium text-gray-700 mb-1">Kode TUK <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_tuk" id="edit_kode_tuk" 
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Contoh: TUK-001" required>
                        </div>

                        <!-- Nama TUK Field -->
                        <div>
                            <label for="edit_nama_tuk" class="block text-sm font-medium text-gray-700 mb-1">Nama TUK <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_tuk" id="edit_nama_tuk" 
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Contoh: TUK Laboratorium Komputer UGM" required>
                        </div>

                        <!-- Penanggung Jawab Field -->
                        <div>
                            <label for="edit_id_penanggung_jawab" class="block text-sm font-medium text-gray-700 mb-1">Penanggung Jawab <span class="text-red-500">*</span></label>
                            <select name="id_penanggung_jawab" id="edit_id_penanggung_jawab"
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled>--- Pilih Penanggung Jawab---</option>
                                @foreach ($penanggungJawab as $pj)
                                    @if ($pj->status_penanggung_jawab == 'Aktif')
                                        <option value="{{ $pj->id_penanggung_jawab }}">
                                            {{ $pj->nama_penanggung_jawab }} ({{ $pj->status_penanggung_jawab }})
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- No Lisensi Field -->
                        <div>
                            <label for="edit_no_lisensi_skkn" class="block text-sm font-medium text-gray-700 mb-1">Nomor Lisensi SKKNI</label>
                            <input type="text" name="no_lisensi_skkn" id="edit_no_lisensi_skkn" 
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Contoh: LSP-UGM/LIS/2023/001">
                        </div>

                        <!-- Alamat Field -->
                        <div class="md:col-span-2">
                            <label for="edit_alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="alamat" id="edit_alamat" rows="3"
                                class="w-full px-4 py-2.5 bg-gray-50 border rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Masukkan alamat lengkap TUK" required></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex justify-end space-x-3 mt-4">
                        <button type="button" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors" onclick="closeModal('modalEditTUK')">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                            Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- Script untuk modal -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById(modalId).classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('flex');
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    function editPJ(id, nama_penanggung_jawab, status) {
        document.getElementById('edit_pj_id').value = id;
        document.getElementById('edit_nama_penanggung_jawab').value = nama_penanggung_jawab;
        document.getElementById('edit_status_penanggung_jawab').value = status;
        document.getElementById('formEditPJ').action = `/admin/penanggung-jawab/${id}`;
        openModal('modalEditPJ');
    }
    
    function editTUK(id, kode, nama, alamat, pjId, noLisensi) {
        document.getElementById('edit_tuk_id').value = id;
        document.getElementById('edit_kode_tuk').value = kode;
        document.getElementById('edit_nama_tuk').value = nama;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_id_penanggung_jawab').value = pjId;
        document.getElementById('edit_no_lisensi_skkn').value = noLisensi || '';
        document.getElementById('formEditTUK').action = `/admin/tuk/${id}`;
        openModal('modalEditTUK');
    }
</script>
@endsection