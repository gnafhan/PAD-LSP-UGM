@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Soal - LSP UGM')

@section('styles')
    {{-- Di sini bisa ditambahkan style khusus jika perlu --}}
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">

        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold leading-7 text-gray-900">Edit Soal Sertifikasi</h2>
                    <p class="mt-1 text-sm text-gray-500">Ubah detail soal pada form di bawah ini.</p>
                </div>
                <a href="{{ route('admin.soal.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <form action="{{ route('admin.soal.update', $soal->kode_soal) }}" method="POST">
            @csrf
            @method('PUT') {{-- Metode HTTP untuk update --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-8">
                    <div class="space-y-6">

                        <div>
                            <label for="id_skema" class="block text-sm font-medium text-gray-700 mb-1">
                                Skema Sertifikasi <span class="text-red-600">*</span>
                            </label>
                            <select id="id_skema" name="id_skema"
                                    class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('id_skema') border-red-500 @enderror">
                                <option value="" disabled>Pilih Skema Sertifikasi</option>
                                @foreach ($skema as $s)
                                    <option value="{{ $s->id_skema }}" {{ old('id_skema', $soal->id_skema) == $s->id_skema ? 'selected' : '' }}>
                                        {{ $s->nama_skema }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_skema')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pertanyaan-editor" class="block text-sm font-medium text-gray-700 mb-1">
                                Teks Pertanyaan <span class="text-red-600">*</span>
                            </label>
                            <textarea id="pertanyaan-editor" name="pertanyaan" rows="8"
                                      class="block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('pertanyaan') border-red-500 @enderror">{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>
                            @error('pertanyaan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900">Opsi Jawaban</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="jawaban_a" class="block text-sm font-medium text-gray-700">
                                        Opsi A <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="jawaban_a" id="jawaban_a" value="{{ old('jawaban_a', $soal->jawaban_a) }}"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('jawaban_a') border-red-500 @enderror">
                                    @error('jawaban_a')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="jawaban_b" class="block text-sm font-medium text-gray-700">
                                        Opsi B <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" name="jawaban_b" id="jawaban_b" value="{{ old('jawaban_b', $soal->jawaban_b) }}"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('jawaban_b') border-red-500 @enderror">
                                    @error('jawaban_b')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="jawaban_c" class="block text-sm font-medium text-gray-700">Opsi C</label>
                                    <input type="text" name="jawaban_c" id="jawaban_c" value="{{ old('jawaban_c', $soal->jawaban_c) }}"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="jawaban_d" class="block text-sm font-medium text-gray-700">Opsi D</label>
                                    <input type="text" name="jawaban_d" id="jawaban_d" value="{{ old('jawaban_d', $soal->jawaban_d) }}"
                                           class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="jawaban_benar" class="block text-sm font-medium text-gray-700 mb-1">
                                Kunci Jawaban <span class="text-red-600">*</span>
                            </label>
                            <select id="jawaban_benar" name="jawaban_benar"
                                    class="block w-full max-w-xs pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('jawaban_benar') border-red-500 @enderror">
                                <option value="" disabled>Pilih Jawaban Benar</option>
                                <option value="a" {{ old('jawaban_benar', $soal->jawaban_benar) == 'a' ? 'selected' : '' }}>Opsi A</option>
                                <option value="b" {{ old('jawaban_benar', $soal->jawaban_benar) == 'b' ? 'selected' : '' }}>Opsi B</option>
                                <option value="c" {{ old('jawaban_benar', $soal->jawaban_benar) == 'c' ? 'selected' : '' }}>Opsi C</option>
                                <option value="d" {{ old('jawaban_benar', $soal->jawaban_benar) == 'd' ? 'selected' : '' }}>Opsi D</option>
                            </select>
                            @error('jawaban_benar')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end items-center space-x-4">
                    <a href="{{ route('admin.soal.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
{{-- CDN untuk Rich Text Editor TinyMCE (tetap sama) --}}
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    // Inisialisasi TinyMCE (tetap sama)
    tinymce.init({
        selector: 'textarea#pertanyaan-editor',
        plugins: 'lists link autolink',
        toolbar: 'undo redo | bold italic | bullist numlist | link',
        menubar: false,
        height: 300,
    });
</script>
@endpush