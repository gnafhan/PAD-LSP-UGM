@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Dashboard Asesi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Header -->


    <!-- Main Content -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
      <!-- Left Column: Detail Skema & Assessment Progress -->
      <div class="xl:col-span-8 space-y-8">
        <!-- Detail Skema Section -->
        <section class="bg-white rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
          <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Detail Skema Sertifikasi
            </h2>
          </div>

          <div class="p-6">
          @php
            $asesi = App\Models\Asesi::where('id_user', auth()->user()->id_user)->first();
            $skema = $asesi->skema ?? null;
            $rincianAsesmen = App\Models\RincianAsesmen::where('id_asesi', $asesi->id_asesi ?? null)->first();
            $event = $rincianAsesmen->event ?? null;
            $tuk = $event->tuk ?? null;
          @endphp

            @if($skema)
              <div class="bg-blue-50 rounded-lg p-5 mb-6 shadow-sm border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-800 mb-4 border-b border-blue-200 pb-2">Informasi Skema</h3>
                <div class="grid md:grid-cols-2 gap-4">
                  <div>
                    <div class="space-y-3">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Nomor Skema</p>
                        <p class="text-base font-medium text-gray-900">{{ $skema->nomor_skema }}</p>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-500">Nama Skema</p>
                        <p class="text-base font-medium text-gray-900">{{ $skema->nama_skema }}</p>
                      </div>
                    </div>
                  </div>

                  <div>
                    @if($event)
                    <div class="space-y-3">
                      <div>
                        <p class="text-sm font-medium text-gray-500">Event</p>
                        <p class="text-base font-medium text-gray-900">{{ $event->nama_event }}</p>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-500">Periode</p>
                        <p class="text-base font-medium text-gray-900">Periode {{ $event->periode_pelaksanaan }} - {{ $event->tahun_pelaksanaan }}</p>
                      </div>
                      <div>
                        <p class="text-sm font-medium text-gray-500">Tanggal</p>
                        <p class="text-base font-medium text-gray-900">{{ $event->tanggal_mulai_event->format('d M Y') }} - {{ $event->tanggal_berakhir_event->format('d M Y') }}</p>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>

                @if($tuk)
                <div class="mt-5 pt-4 border-t border-blue-200">
                  <h3 class="text-lg font-semibold text-blue-800 mb-3">Tempat Uji Kompetensi</h3>
                  <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-100">
                    <div class="flex items-start">
                      <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                      </div>
                      <div class="ml-3">
                        <h4 class="text-md font-medium text-gray-900">{{ $tuk->nama_tuk }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $tuk->alamat }}</p>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              </div>

              <!-- Unit Kompetensi Accordion -->
              <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                  <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                  </svg>
                  Unit Kompetensi
                </h3>

                <div class="space-y-4">
                  @foreach($skema->unitKompetensi as $index => $uk)
                  <div class="border border-gray-200 rounded-lg overflow-hidden transition-all hover:border-blue-300 hover:shadow-sm">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-4 flex justify-between items-center cursor-pointer"
                         onclick="toggleElemen('unit-{{ $uk->id_uk }}')" aria-expanded="false" aria-controls="unit-{{ $uk->id_uk }}">
                      <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 bg-blue-600 text-white rounded-full h-8 w-8 flex items-center justify-center font-semibold text-sm">
                          {{ $index + 1 }}
                        </div>
                        <div>
                          <p class="text-sm font-medium text-gray-900">{{ $uk->kode_uk }}</p>
                          <p class="text-sm text-gray-700">{{ $uk->nama_uk }}</p>
                        </div>
                      </div>
                      <svg class="h-5 w-5 text-gray-500 transform transition-transform duration-200" id="chevron-unit-{{ $uk->id_uk }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                      </svg>
                    </div>
                    <div class="px-5 py-4 bg-white hidden" id="unit-{{ $uk->id_uk }}">
                      <h4 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Elemen Kompetensi:
                      </h4>
                      <ul class="space-y-2 ml-4">
                        @forelse($uk->elemen_uk as $elemen)
                        <li class="text-sm text-gray-700 flex items-start">
                          <svg class="h-4 w-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                          </svg>
                          {{ $elemen->nama_elemen }}
                        </li>
                        @empty
                        <li class="text-sm text-gray-500 italic flex items-center">
                          <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                          Tidak ada elemen yang tersedia
                        </li>
                        @endforelse
                      </ul>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            @else
              <div class="flex flex-col items-center justify-center py-12 bg-gray-50 rounded-lg">
                <svg class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="mt-4 text-gray-600 text-center font-medium">Anda belum terdaftar dalam skema sertifikasi.</p>
                <p class="text-gray-500 text-center mt-2">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
              </div>
            @endif
          </div>
        </section>


        @if (Auth::user()->asesi->RincianAsesmen)
          <!-- Assessment Progress Section -->
          <section class="bg-white rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
              <h2 class="text-xl font-bold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Progres Asesmen
              </h2>
            </div>

            <div class="p-6">
              <!-- Loading Indicator -->
              <div id="progressLoading" class="text-center py-8">
                <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-indigo-500 transition ease-in-out duration-150">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Memuat progres asesmen...
                </div>
              </div>

              <!-- Error Message -->
              <div id="progressError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span id="progressErrorText">Terjadi kesalahan saat memuat data progres.</span>
              </div>

              <!-- Progress Content -->
              <div id="progressContent" class="hidden">
                <!-- Progress Steps Navigator -->
                <div id="progressSteps" class="mb-8 hidden sm:flex justify-between items-center">
                  <!-- Will be populated dynamically -->
                </div>

                <!-- Progress Summary Card -->
                <div id="progressSummary" class="mb-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-4 text-white">
                  <div class="flex items-center justify-between">
                    <div>
                      <h4 class="text-lg font-semibold">Progress Keseluruhan</h4>
                      <p class="text-indigo-100 text-sm">Total langkah yang telah diselesaikan</p>
                    </div>
                    <div class="text-right">
                      <div class="text-2xl font-bold" id="progressPercentage">0%</div>
                      <div class="text-sm text-indigo-100" id="progressStepsCount">0 dari 0 langkah</div>
                    </div>
                  </div>
                  <div class="mt-3">
                    <div class="bg-white bg-opacity-20 rounded-full h-2">
                      <div id="progressBar" class="bg-white rounded-full h-2 transition-all duration-300" style="width: 0%"></div>
                    </div>
                  </div>
                </div>

                <!-- Formulir Pendaftaran -->
                <div class="mb-8">
                  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 text-indigo-800 font-bold text-sm rounded-full h-6 w-6 flex items-center justify-center mr-2">1</div>
                    Formulir Pendaftaran
                  </h3>
                  <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                        <tr>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <!-- AK.01 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Formulir AK.01</div>
                                <div class="text-xs text-gray-500">Formulir Permohonan Sertifikasi</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-ak01" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-ak01">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('asesi.fr.ak1') }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>

                        <!-- APL.01 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Formulir APL.01</div>
                                <div class="text-xs text-gray-500">Permohonan Sertifikasi Kompetensi</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-apl01" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-apl01">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('asesi.apl1-detail', auth()->user()->id_user) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>

                        <!-- APL.02 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Formulir APL.02</div>
                                <div class="text-xs text-gray-500">Asesmen Mandiri</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-apl02" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-apl02">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('asesi.asesmen.mandiri') }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Formulir Prauji -->
                <div class="mb-8">
                  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 text-indigo-800 font-bold text-sm rounded-full h-6 w-6 flex items-center justify-center mr-2">2</div>
                    Formulir Prauji
                  </h3>
                  <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                        <tr>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Konsultasi Prauji -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Konsultasi Prauji</div>
                                <div class="text-xs text-gray-500">Diskusi dengan asesor sebelum asesmen</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-konsultasi_pra_uji" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-konsultasi_pra_uji">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('asesi.konsul-prauji') }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>

                        <!-- IA.01 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Formulir IA.01</div>
                                <div class="text-xs text-gray-500">Rencana & Instrumen Asesmen</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-ia01" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-ia01">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>

                        <!-- IA.02 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Formulir IA.02</div>
                                <div class="text-xs text-gray-500">Tugas Praktik & Observasi</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-ia02" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-ia02">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('asesi.fr.ia2') }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <!-- Pasca Uji -->
                <div>
                  <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 text-indigo-800 font-bold text-sm rounded-full h-6 w-6 flex items-center justify-center mr-2">3</div>
                    Pasca Uji
                  </h3>
                  <div class="overflow-x-auto bg-white rounded-lg border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                      <thead>
                        <tr>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                          <th class="px-5 py-3.5 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Umpan Balik -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Umpan Balik</div>
                                <div class="text-xs text-gray-500">Umpan balik dari peserta</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-umpan_balik" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-umpan_balik">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>

                        <!-- AK.04 -->
                        <tr class="hover:bg-gray-50 transition-colors">
                          <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                              <div class="flex-shrink-0 h-9 w-9 rounded-full bg-purple-100 flex items-center justify-center">
                                <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                              </div>
                              <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900">Formulir AK.04</div>
                                <div class="text-xs text-gray-500">Keputusan dan Umpan Balik Asesmen</div>
                              </div>
                            </div>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap">
                            <span id="status-ak04" class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                              <svg class="h-3 w-3 mr-1 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              </svg>
                              Memuat...
                            </span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span id="date-ak04">-</span>
                          </td>
                          <td class="px-5 py-4 whitespace-nowrap text-sm">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                              <span>Detail</span>
                              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                              </svg>
                            </a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
        @endif
      </div>

      <!-- Right Column: Detail Asesor -->
      <div class="xl:col-span-4">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden transition-all hover:shadow-md sticky top-8">
          <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
              Detail Asesor
            </h2>
          </div>

          <div class="p-6">
            @php
              $rincianAsesmen = App\Models\RincianAsesmen::where('id_asesi', App\Models\Asesi::where('id_user', auth()->user()->id_user)->first()->id_asesi ?? null)->first();
              $asesor = $rincianAsesmen->asesor ?? null;
            @endphp

            @if($asesor)
              <div class="flex flex-col items-center mb-6">
                <div class="h-24 w-24 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden mb-3 ring-4 ring-green-100">
                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 text-center">{{ $asesor->nama_asesor }}</h3>
                <p class="text-sm text-gray-600 bg-green-50 px-3 py-1 rounded-full mt-1">Asesor Kompetensi</p>
                <p class="text-xs text-gray-500 mt-2">No. Registrasi: {{ $asesor->kode_registrasi }}</p>
              </div>

              <div class="bg-gray-50 rounded-lg px-5 py-4 mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3 border-b border-gray-200 pb-2">Informasi Kontak</h4>
                <div class="space-y-4">
                  <div class="flex items-start">
                    <div class="flex-shrink-0 bg-white p-1.5 rounded-full shadow-sm">
                      <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <p class="text-xs text-gray-500">Email</p>
                      <p class="text-sm font-medium text-gray-900">{{ $asesor->email }}</p>
                    </div>
                  </div>

                  @if($asesor->no_hp)
                  <div class="flex items-start">
                    <div class="flex-shrink-0 bg-white p-1.5 rounded-full shadow-sm">
                      <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <p class="text-xs text-gray-500">Telepon</p>
                      <p class="text-sm font-medium text-gray-900">{{ $asesor->no_hp }}</p>
                    </div>
                  </div>
                  @endif

                  @if($asesor->institusi_asal)
                  <div class="flex items-start">
                    <div class="flex-shrink-0 bg-white p-1.5 rounded-full shadow-sm">
                      <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                      </svg>
                    </div>
                    <div class="ml-3">
                      <p class="text-xs text-gray-500">Institusi</p>
                      <p class="text-sm font-medium text-gray-900">{{ $asesor->institusi_asal }}</p>
                    </div>
                  </div>
                  @endif
                </div>
              </div>

              <div class="space-y-4">
                <a href="mailto:{{ $asesor->email }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                  <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  Hubungi via Email
                </a>

                @if($asesor->no_hp)
                <a href="tel:{{ $asesor->no_hp }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-green-600 rounded-lg shadow-sm text-sm font-medium text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                  <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  Hubungi via Telepon
                </a>
                @endif
              </div>
            @else
              <div class="flex flex-col items-center justify-center py-10 bg-gray-50 rounded-lg">
                <div class="bg-white p-3 rounded-full shadow-sm mb-4">
                  <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Asesor</h3>
                <p class="text-gray-500 text-center px-6">Belum ada asesor yang ditugaskan untuk proses sertifikasi Anda.</p>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const apiKey = "{{ env('API_KEY') }}";
    const asesiId = @json($asesi->id_asesi ?? null);

    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // API Headers
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiKey,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken || '',
        'X-Requested-With': 'XMLHttpRequest'
    };

    if (!asesiId) {
        showError('ID Asesi tidak ditemukan');
        return;
    }

    // Progress mapping for steps
    const progressSteps = [
        {
            id: 1,
            name: 'Pendaftaran',
            fields: ['ak01', 'apl01', 'apl02']
        },
        {
            id: 2,
            name: 'Prauji',
            fields: ['konsultasi_pra_uji', 'ia01', 'ia02']
        },
        {
            id: 3,
            name: 'Pasca Uji',
            fields: ['umpan_balik', 'ak04']
        }
    ];

    // Load progress data
    function loadProgressData() {
        const apiUrl = `{{ url('/api/v1/asesor/progressAsesi') }}/${asesiId}`;

        console.log('Loading progress from:', apiUrl);

        fetch(apiUrl, {
            method: 'GET',
            headers: apiHeaders
        })
        .then(response => {
            console.log('Progress Response Status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('Progress Result:', result);

            if (result.success && result.data) {
                updateProgressDisplay(result.data);
                hideLoading();
            } else {
                showError(result.message || 'Gagal memuat data progres');
            }
        })
        .catch(error => {
            console.error('Error loading progress:', error);
            showError('Error memuat data progres: ' + error.message);
        });
    }

    // Update progress display
    function updateProgressDisplay(data) {
        const progressAsesmen = data.progress_asesmen;
        const progressSummary = data.progress_summary;

        // Update summary
        document.getElementById('progressPercentage').textContent = progressSummary.progress_percentage + '%';
        document.getElementById('progressStepsCount').textContent =
            `${progressSummary.completed_steps} dari ${progressSummary.total_steps} langkah`;
        document.getElementById('progressBar').style.width = progressSummary.progress_percentage + '%';

        // Update progress steps navigator
        updateProgressSteps(progressAsesmen);

        // Update individual status for each document
        Object.keys(progressAsesmen).forEach(field => {
            const statusElement = document.getElementById(`status-${field}`);
            const dateElement = document.getElementById(`date-${field}`);

            if (statusElement) {
                const isCompleted = progressAsesmen[field].completed;
                const completedAt = progressAsesmen[field].completed_at;

                if (isCompleted) {
                    statusElement.innerHTML = `
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Selesai
                    `;
                    statusElement.className = 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                } else {
                    statusElement.innerHTML = `
                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Belum Selesai
                    `;
                    statusElement.className = 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800';
                }

                if (dateElement) {
                    dateElement.textContent = completedAt || '-';
                }
            }
        });
    }

    // Update progress steps navigator
    function updateProgressSteps(progressAsesmen) {
        const stepsContainer = document.getElementById('progressSteps');
        let stepsHtml = '';

        progressSteps.forEach((step, index) => {
            // Check if step is completed
            const stepCompleted = step.fields.every(field =>
                progressAsesmen[field] && progressAsesmen[field].completed
            );

            // Determine if step is active (current step or completed)
            let stepActive = false;
            for (let i = 0; i <= index; i++) {
                const prevStepCompleted = progressSteps[i].fields.every(field =>
                    progressAsesmen[field] && progressAsesmen[field].completed
                );
                if (!prevStepCompleted) {
                    stepActive = (i === index);
                    break;
                } else if (i === index) {
                    stepActive = true;
                }
            }

            const stepClass = stepCompleted || stepActive ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700';
            const textClass = stepCompleted || stepActive ? 'text-indigo-600' : 'text-gray-700';

            stepsHtml += `
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full ${stepClass} flex items-center justify-center">${step.id}</div>
                    <span class="font-medium ${textClass}">${step.name}</span>
                </div>
            `;

            // Add connector line
            if (index < progressSteps.length - 1) {
                const lineProgress = stepCompleted ? '100%' : (stepActive ? '50%' : '0%');
                stepsHtml += `
                    <div class="h-0.5 w-24 bg-gray-200 relative">
                        <div class="absolute inset-0 bg-indigo-600 transition-all duration-300" style="width: ${lineProgress}"></div>
                    </div>
                `;
            }
        });

        stepsContainer.innerHTML = stepsHtml;
    }

    // Utility functions
    function showError(message) {
        console.error('Error:', message);
        document.getElementById('progressErrorText').textContent = message;
        document.getElementById('progressError').classList.remove('hidden');
        document.getElementById('progressLoading').classList.add('hidden');
        document.getElementById('progressContent').classList.add('hidden');
    }

    function hideLoading() {
        document.getElementById('progressLoading').classList.add('hidden');
        document.getElementById('progressError').classList.add('hidden');
        document.getElementById('progressContent').classList.remove('hidden');
    }

    // Initialize
    console.log('Debug Info:', {
        asesiId: asesiId,
        csrfToken: csrfToken ? 'Present' : 'Missing',
        apiKey: apiKey ? 'Present' : 'Missing'
    });

    // Load data on page load
    loadProgressData();
});

function toggleElemen(id) {
    const element = document.getElementById(id);
    const chevron = document.getElementById('chevron-' + id);

    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        chevron.classList.add('rotate-180');
    } else {
        element.classList.add('hidden');
        chevron.classList.remove('rotate-180');
    }
}
  function toggleElemen(id) {
    const element = document.getElementById(id);
    const chevron = document.getElementById('chevron-' + id);

    if (element.classList.contains('hidden')) {
      element.classList.remove('hidden');
      chevron.classList.add('rotate-180');
    } else {
      element.classList.add('hidden');
      chevron.classList.remove('rotate-180');
    }
  }
</script>
@endsection
