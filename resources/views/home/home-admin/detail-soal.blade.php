@extends('home.home-admin.layouts.layout')

@section('title', 'Detail Soal - LSP UGM')

@section('styles')
<style>
    /* Styling untuk menampilkan konten dari rich text editor */
    .formatted-content ul {
        list-style-type: disc;
        padding-left: 20px;
    }
    .formatted-content ol {
        list-style-type: decimal;
        padding-left: 20px;
    }
    .formatted-content p {
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">

        <div class="mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900">Detail Soal Sertifikasi</h2>
                    <p class="mt-1 text-sm text-gray-500">Menampilkan rincian lengkap untuk soal yang dipilih.</p>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                    <a href="{{ route('admin.soal.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.soal.edit', $soal->kode_soal) }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                          <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.soal.destroy', $soal->kode_soal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b">
                <h3 class="text-lg font-medium text-gray-900">
                    Skema: <span class="font-semibold text-blue-700">{{ $soal->skema->nama_skema ?? 'Tidak ada skema' }}</span>
                </h3>
            </div>
            
            <div class="px-6 py-8">
                <dl class="space-y-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Pertanyaan</dt>
                        <dd class="mt-2 text-gray-900 formatted-content">
                            {{-- Menggunakan {!! !!} untuk render HTML dari rich text editor --}}
                            {!! $soal->pertanyaan !!}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Opsi Jawaban</dt>
                        <dd class="mt-2 space-y-3">
                            @php
                                $options = [
                                    'a' => $soal->jawaban_a,
                                    'b' => $soal->jawaban_b,
                                    'c' => $soal->jawaban_c,
                                    'd' => $soal->jawaban_d,
                                ];
                            @endphp

                            @foreach ($options as $key => $value)
                                @if (!empty($value))
                                    <div class="flex items-center p-3 rounded-md border
                                        {{ $soal->jawaban_benar == $key ? 'bg-green-50 border-green-400' : 'bg-gray-50 border-gray-200' }}">
                                        <div class="font-bold text-gray-800 mr-4 uppercase">{{ $key }}.</div>
                                        <div class="flex-grow text-gray-800">{{ $value }}</div>
                                        @if ($soal->jawaban_benar == $key)
                                            <span class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="-ml-0.5 mr-1.5 h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Jawaban Benar
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </dd>
                    </div>

                    <div class="border-t border-gray-200 pt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $soal->created_at->format('d F Y, H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $soal->updated_at->format('d F Y, H:i') }}</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

    </div>
</div>
@endsection