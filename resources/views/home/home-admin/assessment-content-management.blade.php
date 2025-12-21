{{--
    DEPRECATED VIEW
    
    This view has been deprecated in favor of the new scheme-specific content management system.
    The new system provides per-template IA content management with dedicated tabs for:
    - IA05 (Multiple Choice Questions)
    - IA02 (Work Instructions)
    - IA07 (Oral Questions)
    - MAPA01 (Assessment Planning Config)
    - MAPA02 (Assessment Instrument Config)
    - IA11 (Portfolio Checklist)
    
    Users accessing this page will be automatically redirected to the new scheme content dashboard.
    
    New route: admin.skema.content.index
    New view: home.home-admin.scheme-content-dashboard
    
    @deprecated Since assessment-content-per-template feature implementation
    @see resources/views/home/home-admin/scheme-content-dashboard.blade.php
--}}

@extends('home.home-admin.layouts.layout')

@section('title', 'Redirecting... - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Deprecation Notice -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg shadow-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800">
                            Halaman Ini Telah Dipindahkan
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                Sistem manajemen konten asesmen telah diperbarui dengan fitur baru yang lebih lengkap.
                                Anda akan dialihkan ke halaman baru dalam beberapa detik.
                            </p>
                        </div>
                        <div class="mt-4">
                            <div class="flex space-x-4">
                                @if(isset($skema))
                                    <a href="{{ route('admin.skema.content.index', $skema->id_skema) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Buka Halaman Baru Sekarang
                                    </a>
                                @endif
                                <a href="{{ route('admin.skema.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-yellow-300 text-sm font-medium rounded-md text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Kembali ke Daftar Skema
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New Features Info -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Fitur Baru Manajemen Konten per Template IA</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>IA05:</strong> Kelola soal pilihan ganda dengan urutan tampil yang dapat diatur</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>IA02:</strong> Editor instruksi kerja dengan rich text formatting</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>IA07:</strong> Pertanyaan lisan terorganisir per Unit Kompetensi dan Elemen</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>MAPA01 & MAPA02:</strong> Konfigurasi default untuk perencanaan asesmen</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>IA11:</strong> Checklist verifikasi portofolio dengan kriteria yang dapat dikustomisasi</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span><strong>Copy Content:</strong> Salin konten dari skema lain dengan mudah</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-redirect to new page after 3 seconds if skema is available
    @if(isset($skema))
    setTimeout(function() {
        window.location.href = "{{ route('admin.skema.content.index', $skema->id_skema) }}";
    }, 3000);
    @else
    // If no skema, redirect to skema list
    setTimeout(function() {
        window.location.href = "{{ route('admin.skema.index') }}";
    }, 3000);
    @endif
</script>
@endsection
