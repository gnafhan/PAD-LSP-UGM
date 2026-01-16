@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'Home - Rekomendasi Asesmen Sertifikasi Programmer')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-sm">
                <i class="fas fa-home text-blue-600"></i>
                <a href="{{ route('asesi.index') }}" class="breadcrumb-item">Home</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <a href="{{ route('asesi.index') }}" class="breadcrumb-item">Formulir IA.02</a>
                <i class="fas fa-chevron-right text-xs text-gray-400"></i>
                <span class="breadcrumb-item">Detail</span>
            </div>
        </nav>
        <div id="bgGradient"
             class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
        </div>

        <div class="relative z-10 pt-4 p-10 border border-border bg-white rounded-2xl">
            <div class="pt-6 pb-4 mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">FR.IA.02. Tugas Praktik Demonstrasi</h1>
            </div>
            
            @if(isset($ia02NotFound) && $ia02NotFound)
                <!-- Warning: IA02 Not Found -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 mb-8 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-yellow-800">Soal Belum Dibuat</h3>
                            <p class="mt-2 text-yellow-700">
                                Formulir IA.02 untuk asesmen Anda belum dibuat oleh Asesor. 
                                Silakan hubungi Asesor Anda atau tunggu hingga soal praktik demonstrasi tersedia.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($data)
                <!-- Certificate Info -->
                <div class="p-8 mb-8 ">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="font-semibold text-gray-700">Judul Sertifikasi:</span>
                                <span class="text-gray-900">{{ $data->judul_sertifikasi }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="font-semibold text-gray-700">Nomor Skema:</span>
                                <span class="text-gray-900">{{ $data->id_skema }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="font-semibold text-gray-700">Nama Peserta:</span>
                                <span class="text-gray-900">{{ $data->nama_peserta }}</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="font-semibold text-gray-700">Nama Asesor:</span>
                                <span class="text-gray-900">{{ $data->nama_asesor }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="font-semibold text-gray-700">TUK:</span>
                                <span class="text-gray-900">{{ $data->tuk }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b pb-2">
                                <span class="font-semibold text-gray-700">ID Asesi:</span>
                                <span class="text-gray-900">{{ $data->id_asesi }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5"></div>
                <!-- Unit Kompetensi -->
                <div class=" p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Unit Kompetensi (UK)</h2>

                    @if($uks && $uks->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($uks as $index => $uk)
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
                                                    <div class="bg-gray-100 rounded-md p-3">
                                                        <div class="flex items-start">
                                                <span
                                                    class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-800 rounded-full text-xs font-medium mr-3 mt-0.5">
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
                                            <p class="text-yellow-800 text-sm">Tidak ada elemen kompetensi untuk UK
                                                ini.</p>
                                        </div>
                                    @endif
                                </div>
                                @if($index < count($uks) - 1)
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
                <!-- Instruksi dan Skenario Tugas -->
                <div class="container mx-auto px-4 py-8">
                    <h2 class="text-2xl font-bold mb-6">Instruksi dan Skenario Tugas</h2>

                    @if(isset($data) && $data->instruksi_kerja)
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    Instruksi Kerja:
                                </h4>
                                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                    {!! $data->instruksi_kerja !!}
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Petunjuk Umum:
                                </h4>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Baca dan pelajari setiap instruksi kerja di atas dengan cermat sebelum melaksanakan praktik</li>
                                    <li>Klarifikasi kepada asesor apabila ada hal-hal yang belum jelas</li>
                                    <li>Laksanakan pekerjaan sesuai dengan urutan proses yang sudah ditetapkan</li>
                                    <li>Seluruh proses kerja mengacu kepada SOP yang dipersyaratkan</li>
                                </ol>
                            </div>
                        </div>
                    @else
                        <div class="space-y-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="font-semibold text-gray-600 mb-2">Instruksi Kerja Belum Tersedia</h4>
                                <p class="text-gray-500">Instruksi kerja untuk tugas praktik ini belum dibuat oleh asesor. Silakan hubungi asesor Anda untuk informasi lebih lanjut.</p>
                            </div>
                            
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Petunjuk Umum:
                                </h4>
                                <ol class="list-decimal list-inside space-y-1 text-gray-700">
                                    <li>Hubungi asesor untuk mendapatkan instruksi kerja yang detail</li>
                                    <li>Klarifikasi kepada asesor apabila ada hal-hal yang belum jelas</li>
                                    <li>Laksanakan pekerjaan sesuai dengan urutan proses yang sudah ditetapkan</li>
                                    <li>Seluruh proses kerja mengacu kepada SOP yang dipersyaratkan</li>
                                </ol>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mb-5"></div>
                <!-- Bagian Tandatangan -->
                <div class="mt-8 p-6 ">
                    <h3 class="text-lg font-semibold text-sidebar_font mb-6 text-center">Tandatangan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Kolom Asesi -->
                        <div class="text-center">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Tanggal:</p>
                                <p id="tanggalTtdAsesiIA02" class="text-sm font-medium">{{ $data->waktu_tanda_tangan_asesi ? date('d M Y', strtotime($data->waktu_tanda_tangan_asesi)) : 'Belum ditandatangani' }}</p>
                            </div>
                            <!-- Area Tanda Tangan -->
                            <img id="tandaTanganAsesiIA02"
                                 src="{{ $ttdAsesi ? asset('storage/'.$ttdAsesi) : '' }}"
                                 alt="Tanda Tangan Asesi"
                                 class="w-full h-24 object-contain{{ $ttdAsesi ? '' : ' hidden' }}">
                            <div id="tandaTanganAsesiIA02Placeholder"
                                 class="h-24 border border-dashed border-gray-300 rounded-lg mb-4 flex items-center justify-center bg-gray-50{{ $ttdAsesi ? ' hidden' : '' }}">
                                <p class="text-gray-400 text-sm">Belum ditandatangani</p>
                            </div>
                            <div class="mt-3 flex items-center justify-center">
                                <input id="is_asesi_signing_ia02" name="is_asesi_signing_ia02" type="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_asesi_signing_ia02" class="ms-2 text-sm font-medium text-gray-700">Saya setuju menandatangani formulir ini</label>
                            </div>
                            <div class="border-t border-gray-300 pt-2">
                                <p class="text-sm font-medium">Asesi</p>
                                <p class="text-sm text-gray-600">{{ $data->nama_peserta }}</p>
                            </div>
                        </div>
                        <!-- Kolom Asesor -->
                        <div class="text-center">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Tanggal:</p>
                                <p id="tanggalTtdAsesorIA02" class="text-sm font-medium">{{ $data->waktu_tanda_tangan_asesor ? date('d M Y', strtotime($data->waktu_tanda_tangan_asesor)) : 'Belum ditandatangani' }}</p>
                            </div>
                            <!-- Area Tanda Tangan -->
                            @if($ttdAsesor)
                            <img id="tandaTanganAsesorIA02" src="{{ asset('storage/'.$ttdAsesor) }}" alt="Tanda Tangan Asesor" class="w-full h-24 object-contain">
                            @else
                            <div id="tandaTanganAsesorIA02Placeholder"
                                class="h-24 border border-dashed border-gray-300 rounded-lg mb-4 flex items-center justify-center bg-gray-50">
                                <p class="text-gray-400 text-sm">Area Tanda Tangan</p>
                            </div>
                            @endif
                            <div class="border-t border-gray-300 pt-2">
                                <p class="text-sm font-medium">Asesor</p>
                                <p class="text-sm text-gray-600">{{ $data->nama_asesor }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Button Simpan dan Setujui -->
                <div class="flex justify-end gap-3 mt-6">
                    <button id="btnSetujuiIA02" type="button"
                            class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none">
                        Saya Setuju
                    </button>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btnSetujui = document.getElementById('btnSetujuiIA02');
                    const checkbox = document.getElementById('is_asesi_signing_ia02');
                    let isLocked = {{ $data->waktu_tanda_tangan_asesi ? 'true' : 'false' }};
                    // Disable button if already signed
                    if (isLocked) {
                        btnSetujui.disabled = true;
                        btnSetujui.textContent = 'Sudah Disetujui';
                        btnSetujui.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu');
                        btnSetujui.classList.add('bg-green-500', 'hover:bg-green-600');
                        checkbox.checked = true;
                        checkbox.disabled = true;
                    }
                    // Enable button only if checkbox checked and not locked
                    checkbox.addEventListener('change', function() {
                        if (checkbox.checked && !isLocked) {
                            btnSetujui.disabled = false;
                        } else {
                            btnSetujui.disabled = true;
                        }
                    });
                    // Initial state
                    if (!checkbox.checked) btnSetujui.disabled = true;
                    btnSetujui.addEventListener('click', function() {
                        if (isLocked) return;
                        if (!checkbox.checked) {
                            alert('Silakan setujui untuk menandatangani formulir');
                            return;
                        }
                        btnSetujui.disabled = true;
                        btnSetujui.textContent = 'Menyimpan...';
                        fetch(`/api/v1/asesmen/ia02/{{ $data->id }}/sign-asesi`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'API-KEY': '{{ config('services.api.key') }}',
                            },
                            body: JSON.stringify({ is_signing: true })
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.status === 'success') {
                                btnSetujui.textContent = 'Sudah Disetujui';
                                btnSetujui.classList.remove('bg-gradient-to-r', 'from-biru', 'to-ungu');
                                btnSetujui.classList.add('bg-gray-500', 'hover:bg-green-600');
                                checkbox.disabled = true;
                                isLocked = true;
                                // Optionally update signature image and date
                                if (result.data && result.data.waktu_tanda_tangan_asesi) {
                                    document.getElementById('tanggalTtdAsesiIA02').textContent = new Date(result.data.waktu_tanda_tangan_asesi).toLocaleDateString('id-ID');
                                }
                                if (result.data && result.data.ttd_asesi) {
                                    const img = document.getElementById('tandaTanganAsesiIA02');
                                    const placeholder = document.getElementById('tandaTanganAsesiIA02Placeholder');
                                    if (img) {
                                        // Build full URL for signature image
                                        img.src = '{{ asset("storage") }}/' + result.data.ttd_asesi;
                                        img.classList.remove('hidden');
                                    }
                                    if (placeholder) placeholder.classList.add('hidden');
                                }
                                alert('Berhasil menandatangani IA02!');
                            } else {
                                btnSetujui.disabled = false;
                                btnSetujui.textContent = 'Saya Setuju';
                                alert(result.message || 'Gagal menandatangani IA02');
                            }
                        })
                        .catch(err => {
                            btnSetujui.disabled = false;
                            btnSetujui.textContent = 'Saya Setuju';
                            alert('Terjadi kesalahan: ' + err.message);
                        });
                    });
                });
                </script>
            @else
                <p class="text-gray-500 text-center text-lg mt-8">Data FR.IA-02 tidak ditemukan.</p>
            @endif
        </div>
@endsection
