@extends('home.home-asesor.layouts.layout')

@section('title', 'FR.IA.02 - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mx-4 pb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 15 15" fill="url(#icon-gradient)">
            <defs>
                <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                    <stop offset="0%" stop-color="#3B82F6" /> <!-- Biru -->
                    <stop offset="100%" stop-color="#8B5CF6" /> <!-- Ungu -->
                </linearGradient>
            </defs>
            <path
                d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
            />
        </svg>
        <p class="ms-2 text-xl font-bold text-black">IA.02</p>
    </div>
    <div id="breadcrumbs" class="hidden pb-4 px-6">
        <!-- Breadcrumb -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('home-asesor') }}" class="inline-flex items-center text-sm font-medium text-black hover:text-sidebar_font">
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <a href="{{ route('fria02-asesor') }}" class="ms-1 text-sm font-medium text-black hover:text-sidebar_font">
                            FR.IA.02
                        </a>
                    </div>
                </li>
                <!-- Memanggil data nama asesi -->
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                        </svg>
                        <span class="ms-1 text-sm font-medium text-black">Muhammad Rifai</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameIA02" class="relative z-10 pt-4 p-8 border border-border bg-white rounded-2xl">
        <p id="titlePage" class="mb-4 text-lg font-medium text-black">Formulir IA.02 Tugas Praktik dan Demonstrasi</p>
        <!-- Search Form -->
        <form id="searchIA02" class="max-w-md mb-4 rounded-xl">
            <div class="relative">
            <input type="search" id="default-search" class="block w-full p-2 text-sm border rounded-lg bg-white text-abu border-abu focus:ring-biru focus:border-biru" placeholder="Cari Skema Sertifikasi" required />
                <button type="submit" class="absolute inset-y-0 end-2 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-biru" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </button>
            </div>
        </form>
        <div class="overflow-x-auto shadow-sm rounded-lg">
            <table id="daftarIA02" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Aksi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Nama Peserta</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">Skema Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Kode Skema</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">1</td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="showSummary()" class="">
                                <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button onclick="showDocument()" class="">
                                <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-left">Muhammad Rifai</td>
                        <td class="px-4 py-3 text-gray-700 text-left">Sertifikasi Frontend</td>
                        <td class="px-4 py-3 text-gray-700 text-left">SK1234567890</td>
                        <td class="px-4 py-0">
                            <div class="flex px-4 py-3 justify-center items-center">
                                <svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="detailIA02" class="hidden p-4 text-black">

            <!-- Input Formulir APL.02 -->
            <div id="FRIA02" class="pt-0 p-4 space-y-6">
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -ms-px w-1/3">
                            Judul Sertifikasi
                        </span>
                        <p id="judulSertifikasi" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Sertifikasi Frontend
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        SKM/1602/00023/2/19
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Muhammad Rifai
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            Nafa Popcorn
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Satu Web
                        </p>
                    </div>
                </div>
            </div>


            <!-- Tabel 1 AK01 -->
            <div class="p-4">
                <p id="judulTabelIA01" class="text-sidebar_font font-semibold pb-2">Kelompok Pekerjaan Kegiatan Rekreasi</p>

                <div class="overflow-x-auto shadow-md rounded-lg mb-4">
                    <table id="pelaksanaanAsesmen" class="min-w-full bg-white overflow-hidden">
                        <thead class="bg-bg_dashboard text-center">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Menangani Situasi Konfik</th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-black text-center items-center">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="flex px-4 py-3 justify-center">Mengidentifikasi situasi konflik?</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="flex px-4 py-3 justify-center">Mengidentifikasi situasi konflik?</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="flex px-4 py-3 justify-center">Mengidentifikasi situasi konflik?</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="flex px-4 py-3 justify-center">Mengidentifikasi situasi konflik?</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">1</td>
                                <td class="px-4 py-3 text-gray-700 text-left">R.93KPW00.011.2</td>
                                <td class="flex px-4 py-3 justify-center">Mengidentifikasi situasi konflik?</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rich Text Editor Quill.js untuk Instruksi Kerja -->
            <div class="p-4">
                <p id="judulTabelAPL02" class="text-sidebar_font font-semibold pb-4 text-center">Instruksi Kerja</p>

                <!-- Quill.js Editor Area -->
                <div class="border-border_input rounded-lg bg-white">
                    <div id="instruksi-kerja-editor" style="min-height: 400px;">
                        <p><em>Tulis disini:</em></p>
                        <p><strong>Skenario</strong></p>
                        <p>Narasikan tugas yang harus dikerjakan oleh Asesi.</p>
                        <p><strong>A. Studi Kasus</strong></p>
                        <p>Anda sebagai seorang Pemandu Museum/Edukator mendapat tugas untuk melakukan pemanduan di museum dengan peserta 10 orang pengunjung, dengan latar belakang yang berbeda. Bagaimana strategi anda sebagai Pemandu Museum dalam mengelola kunjungan, terkait dengan pemanduan museum!</p>
                        <p><strong>B. Instruksi Kerja dan demonstrasikan unjuk kerja di bawah ini :</strong></p>
                        <ol>
                            <li>Grooming / Penampilan kerja dari edukator.</li>
                            <li>Salam pembuka (Greeting dalam Bahasa Inggris).</li>
                            <li>Briefing / panduan awal pengunjung (Informasikan Prosedur Protokol kesehatan dan pembagian tugas antar edukator).</li>
                        </ol>
                        <p>a. Informasikan waktu kunjungan di museum dan peraturan selama kunjungan.</p>
                        <p>b. Informasikan kepada pungunjung aksesibilitas dari setiap museum dlatas, baik dalam hal sarana prasarananya, etika di museum tersebut. (baik etika secara umum maupun etika secara lokal di museum tersebut).</p>
                        <ol start="4">
                            <li>Siapkan perangkat pemanduan/sarana dan prasarana.</li>
                            <li>Memberi informasi yang atraktif dan edutainment.</li>
                            <li>Closing pemanduan.</li>
                        </ol>
                    </div>
                </div>
                
                <!-- Button Simpan -->
                <div class="flex justify-end mt-4">
                    <button id="simpanInstruksiKerja" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none">
                        Simpan Instruksi Kerja
                    </button>
                </div>
            </div>

            <script>
                // Quill.js Rich Text Editor with Image Upload
                let quillEditor;
                
                document.addEventListener('DOMContentLoaded', function() {
                    console.log('DOM loaded, initializing Quill.js...');
                    
                    // Check if Quill is available
                    if (typeof Quill === 'undefined') {
                        console.error('Quill.js is not loaded! Make sure to run npm run build');
                        return;
                    }
                    
                    // Register custom fonts dengan nama yang lebih jelas
                    const Font = Quill.import('formats/font');
                    Font.whitelist = [
                        'arial', 'georgia', 'times-new-roman', 'helvetica', 'verdana', 
                        'comic-sans', 'impact', 'courier', 'tahoma', 'trebuchet', 
                        'calibri', 'cambria', 'segoe-ui'
                    ];
                    Quill.register(Font, true);
                    
                    // Register custom size options dengan ukuran yang lebih praktis
                    const Size = Quill.import('formats/size');
                    Size.whitelist = ['10px', '12px', '14px', '16px', '18px', '20px', '24px', '28px', '32px'];
                    Quill.register(Size, true);
                    
                    // Custom image handler for upload
                    function imageHandler() {
                        console.log('Image handler triggered');
                        const input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');
                        input.click();

                        input.onchange = () => {
                            const file = input.files[0];
                            console.log('File selected:', file);
                            
                            if (file) {
                                // Validate file size (max 2MB)
                                if (file.size > 2 * 1024 * 1024) {
                                    alert('File size too large! Maximum 2MB allowed.');
                                    return;
                                }
                                
                                // Validate file type
                                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                                if (!allowedTypes.includes(file.type)) {
                                    alert('Invalid file type! Only JPEG, PNG, JPG, and GIF are allowed.');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('upload', file);

                                // Show loading indicator
                                let range = quillEditor.getSelection();
                                if (!range) {
                                    // If no selection, insert at end
                                    const length = quillEditor.getLength();
                                    quillEditor.setSelection(length - 1, 0);
                                    range = quillEditor.getSelection();
                                }
                                
                                const loadingText = 'Uploading image...';
                                quillEditor.insertText(range.index, loadingText, 'user');
                                console.log('Starting upload...');

                                // Upload to server
                                fetch('/upload-image', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => {
                                    console.log('Response status:', response.status);
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! status: ${response.status}`);
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Upload response:', data);
                                    
                                    // Remove loading text
                                    quillEditor.deleteText(range.index, loadingText.length);
                                    
                                    if (data.uploaded && data.url) {
                                        // Insert image at the same position
                                        console.log('Inserting image at index:', range.index);
                                        console.log('Image URL:', data.url);
                                        
                                        quillEditor.insertEmbed(range.index, 'image', data.url);
                                        
                                        // Move cursor after image
                                        quillEditor.setSelection(range.index + 1, 0);
                                        console.log('✅ Image uploaded and inserted successfully!');
                                    } else {
                                        const errorMsg = data.error?.message || 'Upload failed';
                                        console.error('Upload failed:', errorMsg);
                                        alert('Upload failed: ' + errorMsg);
                                    }
                                })
                                .catch(error => {
                                    console.error('Upload error:', error);
                                    
                                    // Remove loading text
                                    quillEditor.deleteText(range.index, loadingText.length);
                                    alert('Upload failed: ' + error.message);
                                });
                            }
                        };
                    }
                    
                    // Initialize Quill with custom toolbar and handlers
                    quillEditor = new Quill('#instruksi-kerja-editor', {
                        theme: 'snow',
                        placeholder: 'Tulis instruksi kerja disini...',
                        modules: {
                            toolbar: {
                                container: [
                                    [{ 'font': [] }],
                                    [{ 'size': ['small', false, 'large', 'huge'] }],
                                    [{ 'header': [1, 2, 3, false] }],
                                    ['bold', 'italic', 'underline', 'strike'],
                                    [{ 'color': [] }, { 'background': [] }],
                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                                    [{ 'direction': 'rtl' }],
                                    [{ 'align': [] }],
                                    ['code-block'],
                                    ['image', 'link',],
                                    ['clean']
                                ],
                                handlers: {
                                    image: imageHandler
                                }
                            }
                        }
                    });
                    
                    console.log('✅ Quill.js initialized successfully!');
                    
                    // Auto-save functionality
                    let saveTimeout;
                    quillEditor.on('text-change', function() {
                        clearTimeout(saveTimeout);
                        saveTimeout = setTimeout(() => {
                            console.log('✅ Content auto-saved');
                            // You can add actual save logic here
                        }, 2000);
                    });
                    
                    // Save button functionality (disabled until database ready)
                    document.getElementById('simpanInstruksiKerja').addEventListener('click', function() {
                        alert('💾 Fitur simpan akan aktif setelah database siap!\n\n📋 Saat ini yang bisa digunakan:\n✅ Upload gambar temporary\n✅ Format text (bold, italic, dll)\n✅ Pilih font & ukuran\n✅ Warna text & background\n✅ List & alignment');
                        // saveInstruksiKerja(); // Will be enabled when database is ready
                    });
                });
                
                // Function to save final content with permanent images
                function saveInstruksiKerja() {
                    if (!quillEditor) {
                        alert('Editor belum siap!');
                        return;
                    }
                    
                    const button = document.getElementById('simpanInstruksiKerja');
                    const originalText = button.innerHTML;
                    
                    // Show loading state
                    button.disabled = true;
                    button.innerHTML = `
                        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    `;
                    
                    const content = quillEditor.root.innerHTML;
                    console.log('Saving content:', content);
                    
                    fetch('/save-instruksi-kerja', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            content: content
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update editor with permanent URLs
                            quillEditor.root.innerHTML = data.content;
                            
                            // Show success message
                            button.innerHTML = `
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Tersimpan!
                            `;
                            button.classList.remove('from-biru', 'to-ungu');
                            button.classList.add('bg-green-600');
                            
                            setTimeout(() => {
                                button.innerHTML = originalText;
                                button.classList.remove('bg-green-600');
                                button.classList.add('from-biru', 'to-ungu');
                                button.disabled = false;
                            }, 2000);
                            
                            console.log('✅ Instruksi kerja berhasil disimpan!');
                        } else {
                            throw new Error(data.message || 'Gagal menyimpan');
                        }
                    })
                    .catch(error => {
                        console.error('Save error:', error);
                        alert('Gagal menyimpan: ' + error.message);
                        
                        // Restore button
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
                }
                
                // Helper functions for content management
                function saveEditorContent() {
                    if (quillEditor) {
                        const content = quillEditor.root.innerHTML;
                        console.log('Editor content:', content);
                        return content;
                    }
                    return '';
                }
                
                function loadEditorContent(content) {
                    if (quillEditor) {
                        quillEditor.root.innerHTML = content;
                    }
                }
            </script>


                <!-- Tabel Proses Assessment -->
                <div class="mt-8 space-y-6">
                    <!-- Proses 1 -->
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses 1</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">Mengimplementasikan Dasar-dasar Kepemanduan Museum</span>
                        </div>
                        
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Instruksi Kerja</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Standar / Alat / Media</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Output</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black">
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">1</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Prinsip "Edutainment"</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">2</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Pengetahuan tentang Museum</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">3</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Mengembangkan Pengetahuan</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Proses 2 -->
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses 2</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">Mengimplementasikan Dasar-dasar Kepemanduan Museum</span>
                        </div>
                        
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Instruksi Kerja</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Standar / Alat / Media</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Output</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black">
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">1</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Prinsip "Edutainment"</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">2</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Pengetahuan tentang Museum</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">3</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Mengembangkan Pengetahuan</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Proses 3 -->
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses 3</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">Mengimplementasikan Dasar-dasar Kepemanduan Museum</span>
                        </div>
                        
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Instruksi Kerja</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Standar / Alat / Media</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Output</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black">
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">1</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Prinsip "Edutainment"</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">2</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Pengetahuan tentang Museum</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">3</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Mengembangkan Pengetahuan</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Proses 4 -->
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses 4</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">Mengimplementasikan Dasar-dasar Kepemanduan Museum</span>
                        </div>
                        
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Instruksi Kerja</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Standar / Alat / Media</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Output</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black">
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">1</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Prinsip "Edutainment"</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">2</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Pengetahuan tentang Museum</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">3</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Mengembangkan Pengetahuan</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Proses 5 -->
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses 5</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">Mengimplementasikan Dasar-dasar Kepemanduan Museum</span>
                        </div>
                        
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Instruksi Kerja</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Standar / Alat / Media</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Output</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black">
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">1</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Prinsip "Edutainment"</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">2</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Pengetahuan tentang Museum</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">3</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Mengembangkan Pengetahuan</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Proses 6 -->
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses 6</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">Mengimplementasikan Dasar-dasar Kepemanduan Museum</span>
                        </div>
                        
                        <div class="overflow-x-auto shadow-md rounded-lg">
                            <table class="min-w-full bg-white overflow-hidden">
                                <thead class="bg-bg_dashboard text-center">
                                    <tr>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">No</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Instruksi Kerja</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Standar / Alat / Media</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider">Output</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-black">
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">1</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Prinsip "Edutainment"</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">2</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Meneraptkan Pengetahuan tentang Museum</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center">3</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Mengembangkan Pengetahuan</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Bagian Tandatangan -->
                <div class="mt-8 p-6 border-border_input rounded-lg bg-white">
                    <h3 class="text-lg font-semibold text-sidebar_font mb-6 text-center">Tandatangan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Kolom Asesi -->
                        <div class="text-center">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Tanggal:</p>
                                <p class="text-sm font-medium">15 Maret 2023</p>
                            </div>
                            
                            <!-- Area Tanda Tangan -->
                            <div class="h-24 border border-dashed border-gray-300 rounded-lg mb-4 flex items-center justify-center bg-gray-50">
                                <p class="text-gray-400 text-sm">Area Tanda Tangan</p>
                            </div>
                            
                            <div class="border-t border-gray-300 pt-2">
                                <p class="text-sm font-medium">Asesi</p>
                                <p class="text-sm text-gray-600">Muhammad Rifai</p>
                            </div>
                        </div>

                        <!-- Kolom Asesor -->
                        <div class="text-center">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Tanggal:</p>
                                <p class="text-sm font-medium">15 Maret 2023</p>
                            </div>
                            
                            <!-- Area Tanda Tangan -->
                            <div class="h-24 border border-dashed border-gray-300 rounded-lg mb-4 flex items-center justify-center bg-gray-50">
                                <p class="text-gray-400 text-sm">Area Tanda Tangan</p>
                            </div>
                            
                            <div class="border-t border-gray-300 pt-2">
                                <p class="text-sm font-medium">Asesor</p>
                                <p class="text-sm text-gray-600">Nafa Popcorn</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Simpan dan Cetak -->
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none">
                        Simpan Dan Setujui
                    </button>
                </div>
            </div>

            

        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

<script>
function showSummary() {
    // Sembunyikan elemen pencarian utama
    document.getElementById('searchIA02').classList.add('hidden');

    // Sembunyikan elemen daftar asesi
    document.getElementById('daftarIA02').classList.add('hidden');

    // Tampilkan bagian breadcrumbs
    document.getElementById('breadcrumbs').classList.remove('hidden');

    // Tampilkan bagian detail asesi
    document.getElementById('detailIA02').classList.remove('hidden');

    // Optional: scroll ke bagian detail
    document.getElementById('detailIA02').scrollIntoView({ behavior: 'smooth' });
}

// Quill.js Helper Functions
function saveEditorContent() {
    // Get content from Quill.js
    if (typeof quillEditor !== 'undefined' && quillEditor) {
        const content = quillEditor.root.innerHTML;
        console.log('Editor content:', content);
        return content;
    }
    return '';
}

function loadEditorContent(content) {
    // Load content into Quill.js
    if (typeof quillEditor !== 'undefined' && quillEditor) {
        quillEditor.root.innerHTML = content;
    }
}
</script>

@endsection
