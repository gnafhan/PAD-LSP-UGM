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
                        <span class="ms-1 text-sm font-medium text-black" id="breadcrumbAsesiName">Nama Asesi</span>
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
                    <!-- Data akan dimuat oleh JavaScript -->
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="animate-spin h-8 w-8 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-lg font-medium">Memuat data asesi...</p>
                                <p class="text-sm">Mengambil daftar asesi dari server</p>
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
                        Pilih asesi untuk melihat data
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 pb-2 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nomor Sertifikasi
                        </span>
                        <p id="nomorSertifikasi" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Pilih asesi untuk melihat data
                        </p>
                    </div>
                </div>
                <div class="max-w-full space-y-1">
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Peserta Sertifikasi
                        </span>
                        <p id="namaPeserta" type="text" class="peer font-semibold text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Pilih asesi untuk melihat data
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            Nama Asesor
                        </span>
                        <p id="namaAsesor" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                            {{ Auth::user()->asesor->nama_asesor ?? 'Nama Asesor' }}
                        </p>
                    </div>
                    <div class="flex">
                        <span class="py-1 inline-flex items-center min-w-fit text-sidebar_font -mt-px -ms-px w-1/3">
                            TUK
                        </span>
                        <p id="tuk" type="text" class="peer text-sidebar_font py-2 block w-full bg-transparent border-t-transparent border-b-1 border-x-transparent border-border_input focus:border-t-transparent focus:border-x-transparent focus:border-biru focus:ring-0 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter name">
                        Pilih asesi untuk melihat data
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
                        <tbody id="kompetensiTableBody" class="divide-y divide-gray-200 text-black text-center items-center">
                            <!-- Data akan dimuat dari database -->
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-center text-gray-500">Memuat data kompetensi...</td>
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
                // Quill.js Rich Text Editor
                let quillEditor;
                const QUILL_DEBUG = true; // Set to false in production
                
                function quillLog(message, ...args) {
                    if (QUILL_DEBUG) {
                        console.log(`[Quill Debug] ${message}`, ...args);
                    }
                }
                
                document.addEventListener('DOMContentLoaded', function() {
                    quillLog('DOM loaded, initializing Quill.js...');
                    
                    // Check if Quill is available
                    if (typeof Quill === 'undefined') {
                        console.error('Quill.js is not loaded! Make sure to run npm run build');
                        return;
                    }
                    
                    // Verify CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error('CSRF token not found! Make sure to include @csrf in your form');
                        return;
                    }
                    quillLog('CSRF token found:', csrfToken.getAttribute('content').substring(0, 10) + '...');
                    
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
                    
                    // Initialize Quill with custom toolbar (tanpa tombol image)
                    try {
                        const modules = {
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
                                    ['link'],
                                    ['clean']
                                ]
                                // Hapus handlers: { image: imageHandler }
                            }
                        };
                        
                        quillEditor = new Quill('#instruksi-kerja-editor', {
                            theme: 'snow',
                            placeholder: 'Tulis instruksi kerja disini...',
                            modules: modules
                        });
                        
                        quillLog('✅ Quill.js initialized successfully!');
                    } catch (error) {
                        console.error('❌ Error initializing Quill:', error);
                        quillLog('❌ Error initializing Quill: ' + error.message);
                    }
                    
                    // Auto-save functionality
                    let saveTimeout;
                    quillEditor.on('text-change', function() {
                        clearTimeout(saveTimeout);
                        saveTimeout = setTimeout(() => {
                            quillLog('✅ Content auto-saved');
                            // You can add actual save logic here
                        }, 2000);
                    });
                    
                    // Save button functionality
                    document.getElementById('simpanInstruksiKerja').addEventListener('click', function() {
                        saveInstruksiKerja();
                    });
                });
                
                // Function to save final content and move images from temp to permanent
                async function saveInstruksiKerja() {
                    if (!quillEditor) {
                        alert('Editor belum siap!');
                        return;
                    }
                    
                    if (!currentAsesiId || !currentIA02Data) {
                        alert('Pilih asesi terlebih dahulu!');
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
                        Memproses gambar...
                    `;
                    
                    try {
                        // Get current HTML content
                        const htmlContent = quillEditor.root.innerHTML;
                        const deltaContent = JSON.stringify(quillEditor.getContents());
                        
                        console.log('Saving content for IA02 ID:', currentIA02Data.detail_ia02.id);
                        console.log('HTML Content:', htmlContent);
                        
                        // Send content with temporary images to backend
                        // Backend will process and move temp images to permanent storage
                        const response = await fetch('/save-content-with-images', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                ia02_id: currentIA02Data.detail_ia02.id,
                                content_type: 'instruksi_kerja',
                                html_content: htmlContent,
                                delta_content: deltaContent
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Update editor with permanent URLs if provided
                            if (data.updated_html_content) {
                                quillEditor.root.innerHTML = data.updated_html_content;
                                console.log('✅ Editor updated with permanent URLs');
                            }
                            
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
                            showMessage('Instruksi kerja berhasil disimpan', 'success', 3000);
                        } else {
                            throw new Error(data.message || 'Gagal menyimpan');
                        }
                    } catch (error) {
                        console.error('Save error:', error);
                        showNotificationModal('Error', `Gagal menyimpan: ${error.message}`, 'error');
                        
                        // Restore button
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
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
                        quillEditor.root.innerHTML = content || '';
                    }
                }

                // Load saved content from database
                async function loadSavedContent(ia02Id, contentType = 'instruksi_kerja') {
                    if (!ia02Id) {
                        console.log('No IA02 ID provided for loading content');
                        return;
                    }

                    try {
                        console.log('Loading saved content for IA02 ID:', ia02Id);
                        
                        const response = await fetch(`/load-content/${ia02Id}/${contentType}`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        const data = await response.json();
                        
                        if (data.success) {
                            if (data.content && data.content.trim() !== '') {
                                console.log('Loading saved content:', data.content);
                                loadEditorContent(data.content);
                                showMessage('Konten tersimpan berhasil dimuat', 'success', 3000);
                            } else {
                                console.log('No saved content found, using default template');
                                loadDefaultTemplate();
                            }
                        } else {
                            console.log('Failed to load content:', data.message);
                            loadDefaultTemplate();
                        }
                    } catch (error) {
                        console.error('Error loading saved content:', error);
                        loadDefaultTemplate();
                    }
                }

                // Load default template content
                function loadDefaultTemplate() {
                    const defaultContent = `
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
                    `;
                    loadEditorContent(defaultContent);
                }
            </script>


                <!-- Tabel Proses Assessment -->
                <div id="prosesAssessmentContainer" class="mt-8 space-y-6">
                    <!-- Process tables will be loaded dynamically -->
                    <div class="text-center text-gray-500 py-8">
                        <p>Memuat data proses assessment...</p>
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
                    <button id="simpanIA02" type="button" class="inline-flex justify-center rounded-md bg-gradient-to-r from-biru to-ungu text-white px-6 py-2 text-sm/6 font-medium hover:bg-biru_soft focus:outline-none">
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
// Global variables
let daftarAsesiData = [];
let selectedAsesiData = null;

document.addEventListener('DOMContentLoaded', function () {
    // API configuration - Menggunakan config helper Laravel untuk dynamic configuration
    const apiConfig = {
        url: @json(config('services.api.url')),
        key: @json(config('services.api.key')),
        asesorId: @json(Auth::user()->asesor->id_asesor ?? null),
        csrfToken: @json(csrf_token())
    };

    // Debug logging
    console.log('API Config:', apiConfig);
    
    // Fallback for asesorId if not available
    if (!apiConfig.asesorId) {
        console.warn('Asesor ID not found, using default test ID');
        apiConfig.asesorId = 'ASESOR202500001'; // Default test asesor ID
    }

    // Global variables
    let currentAsesiId = null;
    let currentIA02Data = null;
    let kompetensiData = [];
    let asesiProgressData = {}; // Store progress data for each asesi
    let isFormSigned = false; // Track if form is already signed by asesor

    // Function to show error message
    function showError(message) {
        showNotificationModal('Error', message, 'error');
    }

    // Validasi konfigurasi API
    if (!apiConfig.url) {
        showError('Konfigurasi API URL tidak ditemukan. Silakan hubungi administrator.');
        document.querySelector('#daftarAsesi tbody').innerHTML = `
            <tr>
                <td colspan="7" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak ditemukan</td>
            </tr>
        `;
        return;
    }

    if (!apiConfig.key) {
        showError('Konfigurasi API Key tidak ditemukan. Silakan hubungi administrator.');
        document.querySelector('#daftarAsesi tbody').innerHTML = `
            <tr>
                <td colspan="7" class="px-4 py-3 text-center text-gray-500">Konfigurasi API tidak ditemukan</td>
            </tr>
        `;
        return;
    }

    if (!apiConfig.asesorId) {
        showError('ID Asesor tidak ditemukan. Silakan login kembali.');
        document.querySelector('#daftarAsesi tbody').innerHTML = `
            <tr>
                <td colspan="7" class="px-4 py-3 text-center text-gray-500">User tidak teridentifikasi, silahkan login kembali</td>
            </tr>
        `;
        return;
    }

    // Build API URLs dynamically
    const asesisApiUrl = `${apiConfig.url}/asesor/asesis/${apiConfig.asesorId}`;
    const biodataApiUrl = `${apiConfig.url}/asesor/biodata/${apiConfig.asesorId}`;

    // API Headers configuration
    const apiHeaders = {
        'Content-Type': 'application/json',
        'API-KEY': apiConfig.key,
        'Accept': 'application/json',
        'X-CSRF-TOKEN': apiConfig.csrfToken,
        'X-Requested-With': 'XMLHttpRequest',
        'X-Asesor-ID': apiConfig.asesorId
    };

    // Modal functions
    function showNotificationModal(title, message, type = 'info') {
        // Create notification modal if not exists
        let modal = document.getElementById('notificationModal');
        if (!modal) {
            const modalHTML = `
                <div id="notificationModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div id="notificationIcon" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                                        <!-- Icon will be inserted dynamically -->
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="notificationTitle">Notification</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500" id="notificationMessage">Message goes here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" id="notificationCloseBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            modal = document.getElementById('notificationModal');
        }

        const titleElement = document.getElementById('notificationTitle');
        const messageElement = document.getElementById('notificationMessage');
        const iconElement = document.getElementById('notificationIcon');

        titleElement.textContent = title;
        messageElement.textContent = message;

        // Set icon based on type
        let iconHtml = '';
        let iconBgClass = '';

        switch(type) {
            case 'success':
                iconBgClass = 'bg-green-100';
                iconHtml = `<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>`;
                break;
            case 'error':
                iconBgClass = 'bg-red-100';
                iconHtml = `<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>`;
                break;
            case 'warning':
                iconBgClass = 'bg-yellow-100';
                iconHtml = `<svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>`;
                break;
            default:
                iconBgClass = 'bg-blue-100';
                iconHtml = `<svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>`;
        }

        iconElement.className = `mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10 ${iconBgClass}`;
        iconElement.innerHTML = iconHtml;

        modal.classList.remove('hidden');
    }

    function hideNotificationModal() {
        const modal = document.getElementById('notificationModal');
        if (modal) modal.classList.add('hidden');
    }

    // Setup modal close handlers
    document.addEventListener('click', function(e) {
        if (e.target && e.target.id === 'notificationCloseBtn') {
            hideNotificationModal();
        }
    });

    // Utility function to show messages
    function showMessage(message, type = 'info', duration = 5000) {
        console.log(`[${type.toUpperCase()}] ${message}`);
        // You can implement additional message display logic here if needed
    }

    // Load IA02 progress for each asesi
    async function loadIa02Progress(asesisData) {
        try {
            const asesisWithIa02Progress = await Promise.all(
                asesisData.map(async (asesi) => {
                    try {
                        // Call IA02 API to get progress status
                        const ia02ApiUrl = `${apiConfig.url}/asesmen/ia02/asesor/${asesi.id_asesi}`;
                        const ia02Response = await fetch(ia02ApiUrl, {
                            method: 'GET',
                            headers: apiHeaders
                        });

                        if (ia02Response.ok) {
                            const ia02Result = await ia02Response.json();
                            if (ia02Result.status === 'success' && ia02Result.data.record_exists) {
                                const detailIa02 = ia02Result.data.detail_ia02;

                                // Set IA02 progress based on signature status
                                asesi.ia02_asesor_signed = !!(detailIa02.waktu_tanda_tangan_asesor && detailIa02.ttd_asesor);
                                asesi.ia02_asesi_signed = !!(detailIa02.waktu_tanda_tangan_asesi && detailIa02.ttd_asesi);
                                asesi.ia02_completed = asesi.ia02_asesor_signed && asesi.ia02_asesi_signed;
                                asesi.ia02_created_at = detailIa02.waktu_tanda_tangan_asesor || null;

                                // Store IA02 data for potential use
                                asesi.ia02_data = ia02Result.data;
                            } else {
                                // IA02 not created yet
                                asesi.ia02_asesor_signed = false;
                                asesi.ia02_asesi_signed = false;
                                asesi.ia02_completed = false;
                                asesi.ia02_created_at = null;
                                asesi.ia02_data = null;
                            }
                        } else {
                            asesi.ia02_asesor_signed = false;
                            asesi.ia02_asesi_signed = false;
                            asesi.ia02_completed = false;
                            asesi.ia02_created_at = null;
                            asesi.ia02_data = null;
                        }
                    } catch (error) {
                        asesi.ia02_asesor_signed = false;
                        asesi.ia02_asesi_signed = false;
                        asesi.ia02_completed = false;
                        asesi.ia02_created_at = null;
                        asesi.ia02_data = null;
                    }
                    return asesi;
                })
            );

            return asesisWithIa02Progress;
        } catch (error) {
            return asesisData;
        }
    }

    // Load progress for each asesi (original function for other progress)
    async function loadAsesiProgress(asesisData) {
        try {
            const asesisWithProgress = await Promise.all(
                asesisData.map(async (asesi) => {
                    try {
                        const progressApiUrl = `${apiConfig.url}/asesor/progressAsesi/${asesi.id_asesi}`;
                        const progressResponse = await fetch(progressApiUrl, {
                            method: 'GET',
                            headers: apiHeaders
                        });

                        if (progressResponse.ok) {
                            const progressResult = await progressResponse.json();
                            if (progressResult.success && progressResult.data) {
                                asesi.progress_data = progressResult.data;
                                asesi.ak01_completed = progressResult.data.progress_asesmen?.ak01?.completed || false;
                                asesi.ak01_completed_at = progressResult.data.progress_asesmen?.ak01?.completed_at || null;
                                asesi.progress_percentage = progressResult.data.progress_summary?.progress_percentage || 0;
                                asesi.completed_steps = progressResult.data.progress_summary?.completed_steps || 0;
                                asesi.total_steps = progressResult.data.progress_summary?.total_steps || 0;
                            } else {
                                asesi.ak01_completed = false;
                                asesi.ak01_completed_at = null;
                                asesi.progress_percentage = 0;
                                asesi.completed_steps = 0;
                                asesi.total_steps = 0;
                            }
                        } else {
                            asesi.ak01_completed = false;
                            asesi.ak01_completed_at = null;
                            asesi.progress_percentage = 0;
                            asesi.completed_steps = 0;
                            asesi.total_steps = 0;
                        }
                    } catch (error) {
                        asesi.ak01_completed = false;
                        asesi.ak01_completed_at = null;
                        asesi.progress_percentage = 0;
                        asesi.completed_steps = 0;
                        asesi.total_steps = 0;
                    }
                    return asesi;
                })
            );

            return asesisWithProgress;
        } catch (error) {
            return asesisData;
        }
    }

    // Load data asesi
    async function loadAsesiData() {
        try {
            showMessage('Memuat data asesi...', 'loading', 0);

            const response = await fetch(asesisApiUrl, {
                method: 'GET',
                headers: apiHeaders
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success && result.data) {
                let asesisData = result.data.asesis;

                // Load both general progress and IA02 progress
                asesisData = await loadAsesiProgress(asesisData);
                asesisData = await loadIa02Progress(asesisData);

                // Store data globally for use by other functions
                daftarAsesiData = asesisData;

                const tableBody = document.querySelector('#daftarIA02 tbody');

                if (asesisData && asesisData.length > 0) {
                    let tableContent = '';

                    asesisData.forEach((asesi, index) => {
                        // Determine progress status - simplified to only 2 statuses
                        let statusIcon = '';
                        let tanggalInput = '-';

                        if (asesi.ia02_completed) {
                            // Both asesor and asesi have signed - completed (Green)
                            statusIcon = `<svg class="w-6 h-6 text-hijau" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                            </svg>`;
                            tanggalInput = asesi.ia02_created_at ? formatTanggalFromAPI(asesi.ia02_created_at) : '-';
                        } else {
                            // IA02 not completed yet - use general progress or show not completed (Red)
                            statusIcon = `<svg class="w-6 h-6 text-logout" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                            </svg>`;

                            // Use AK01 completion date if available, otherwise use IA02 creation date
                            if (asesi.ia02_created_at) {
                                tanggalInput = formatTanggalFromAPI(asesi.ia02_created_at);
                            } else if (asesi.ak01_completed_at) {
                                tanggalInput = formatTanggalFromAPI(asesi.ak01_completed_at);
                            }
                        }

                        const progressPercent = asesi.progress_percentage || 0;
                        const completedSteps = asesi.completed_steps || 0;
                        const totalSteps = asesi.total_steps || 0;

                        tableContent += `
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="showSummary('${asesi.id_asesi}', '${asesi.nama_asesi}', '${asesi.nama_skema}', ${progressPercent}, ${completedSteps}, ${totalSteps})" class="mr-2">
                                        <svg class="w-6 h-6 text-biru hover:text-ungu" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button onclick="loadIA02Detail('${asesi.id_asesi}')" class="">
                                        <svg class="w-6 h-6 text-ungu hover:text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_asesi}</td>
                                <td class="px-4 py-3 text-gray-700 text-left">${asesi.nama_skema}</td>
                                <td class="px-4 py-3 text-gray-700 text-left">${asesi.nomor_skema}</td>
                                <td class="flex px-4 py-3 justify-center items-center">
                                    ${statusIcon}
                                </td>
                            </tr>
                        `;
                    });

                    tableBody.innerHTML = tableContent;
                    showMessage('Data asesi berhasil dimuat', 'success', 3000);
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi</td>
                        </tr>
                    `;
                    showNotificationModal('Informasi', 'Tidak ada data asesi yang tersedia', 'warning');
                }

                // Implementasi pencarian
                const searchInput = document.getElementById('default-search');
                searchInput?.addEventListener('keyup', function() {
                    const searchValue = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#daftarIA02 tbody tr');

                    rows.forEach(row => {
                        const nama = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
                        const skema = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';
                        const kode = row.querySelector('td:nth-child(5)')?.textContent.toLowerCase() || '';

                        if (nama.includes(searchValue) || skema.includes(searchValue) || kode.includes(searchValue)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });

            } else {
                document.querySelector('#daftarIA02 tbody').innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Gagal memuat data: ${result.message || 'Terjadi kesalahan'}</td>
                    </tr>
                `;
                showNotificationModal('Error', `Gagal memuat data: ${result.message || 'Terjadi kesalahan'}`, 'error');
            }
        } catch (error) {
            document.querySelector('#daftarIA02 tbody').innerHTML = `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">Error memuat data: ${error.message || 'Terjadi kesalahan'}</td>
                </tr>
            `;
            showNotificationModal('Error', `Error memuat data: ${error.message}`, 'error');
        }
    }

    // Fungsi untuk memformat tanggal dari API
    function formatTanggalFromAPI(tanggalString) {
        if (!tanggalString) return '-';

        try {
            // Format dari API: "23-06-2025 17:20:39 WIB"
            // Split tanggal dan waktu
            const [tanggalPart, waktuPart, timezone] = tanggalString.split(' ');
            const [hari, bulan, tahun] = tanggalPart.split('-');
            const [jam, menit] = waktuPart.split(':');

            // Array nama bulan dalam bahasa Indonesia
            const namaBulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            // Konversi ke format yang diinginkan
            const bulanIndo = namaBulan[parseInt(bulan) - 1];

            // Return format: "23 Juni 2025, 17:20 WIB"
            return `${parseInt(hari)} ${bulanIndo} ${tahun}, ${jam}:${menit} ${timezone}`;
        } catch (error) {
            return tanggalString; // Return original jika gagal format
        }
    }

    // Show summary function
    window.showSummary = function(asesiId, namaAsesi, namaSkema, progressPercent, completedSteps, totalSteps) {
        currentAsesiId = asesiId;
        
        // Find the asesi data from loaded data
        const asesiData = daftarAsesiData.find(a => a.id_asesi == asesiId);
        if (asesiData) {
            selectedAsesiData = asesiData;
        }
        
        // Update breadcrumb
        const breadcrumbElement = document.getElementById('breadcrumbAsesiName');
        const breadcrumbContainer = document.getElementById('breadcrumbs');
        
        if (breadcrumbElement && breadcrumbContainer) {
            breadcrumbElement.textContent = namaAsesi;
            breadcrumbContainer.classList.remove('hidden');
        }

        // Update form data
        updateFormData(asesiId, namaAsesi, namaSkema);
        
        // Hide search and list sections
        const searchSection = document.getElementById('searchIA02');
        const listSection = document.getElementById('daftarIA02');
        const detailSection = document.getElementById('detailIA02');
        
        if (searchSection) searchSection.classList.add('hidden');
        if (listSection) listSection.classList.add('hidden');
        if (detailSection) detailSection.classList.remove('hidden');
        
        // Load IA02 data for this asesi
        loadIA02Data(asesiId);
        
        // Scroll to detail section
        if (detailSection) {
            detailSection.scrollIntoView({ behavior: 'smooth' });
        }
    };

    // Load detail IA02 function
    window.loadIA02Detail = function(asesiId) {
        // Find asesi data first
        const asesiData = daftarAsesiData.find(a => a.id_asesi == asesiId);
        if (asesiData) {
            showSummary(asesiId, asesiData.nama_asesi, asesiData.nama_skema, 0, 0, 0);
        } else {
            showNotificationModal('Error', 'Data asesi tidak ditemukan', 'error');
        }
    };

    // Update form data
    function updateFormData(asesiId, namaAsesi, namaSkema) {
        // Update form fields with asesi data
        const judulSertifikasi = document.getElementById('judulSertifikasi');
        const nomorSertifikasi = document.getElementById('nomorSertifikasi');
        const namaPeserta = document.getElementById('namaPeserta');
        const namaAsesor = document.getElementById('namaAsesor');
        const tuk = document.getElementById('tuk');

        if (judulSertifikasi) judulSertifikasi.textContent = namaSkema;
        if (nomorSertifikasi) nomorSertifikasi.textContent = '-'; // Will be filled from API
        if (namaPeserta) namaPeserta.textContent = namaAsesi;
        if (namaAsesor) namaAsesor.textContent = @json(Auth::user()->name) || '-';
        if (tuk) tuk.textContent = 'LSP Politeknik Negeri Malang'; // Default TUK
    }

    // Load IA02 data for specific asesi
    async function loadIA02Data(asesiId) {
        try {
            const ia02ApiUrl = `${apiConfig.url}/asesmen/ia02/asesor/${asesiId}`;
            console.log('Loading IA02 data for asesi:', asesiId);
            console.log('API URL:', ia02ApiUrl);
            console.log('API Headers:', apiHeaders);
            
            const response = await fetch(ia02ApiUrl, {
                method: 'GET',
                headers: apiHeaders
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.status === 'success' && result.data.record_exists) {
                const ia02Data = result.data;
                currentIA02Data = ia02Data;

                // Update form with IA02 data
                updateFormWithIA02Data(ia02Data.detail_ia02);
                
                // Load kompetensis table
                loadKompetensiTable(ia02Data.kompetensis);
                
                // Load instruksi kerja editor - now loads from database
                loadSavedContent(ia02Data.detail_ia02.id, 'instruksi_kerja');
                
                // Load proses assessment tables
                loadProsesAssessmentTables(ia02Data.proses_assessments);
                
                showMessage('Data IA02 berhasil dimuat', 'success', 3000);
            } else {
                showNotificationModal('Informasi', 'Data IA02 tidak ditemukan atau belum dibuat', 'warning');
            }

        } catch (error) {
            console.error('Error loading IA02 data:', error);
            showNotificationModal('Error', `Gagal memuat data IA02: ${error.message}`, 'error');
        }
    }

    // Update form with IA02 data
    function updateFormWithIA02Data(ia02Detail) {
        const judulSertifikasi = document.getElementById('judulSertifikasi');
        const nomorSertifikasi = document.getElementById('nomorSertifikasi');
        const namaPeserta = document.getElementById('namaPeserta');
        const namaAsesor = document.getElementById('namaAsesor');
        const tuk = document.getElementById('tuk');

        if (judulSertifikasi) judulSertifikasi.textContent = ia02Detail.judul_sertifikasi || 'Tidak tersedia';
        if (nomorSertifikasi) nomorSertifikasi.textContent = ia02Detail.nomor_sertifikasi || 'Tidak tersedia';
        if (namaPeserta) namaPeserta.textContent = ia02Detail.nama_peserta || 'Tidak tersedia';
        if (namaAsesor) namaAsesor.textContent = ia02Detail.nama_asesor || 'Tidak tersedia';
        if (tuk) tuk.textContent = ia02Detail.tuk || 'Tidak tersedia';
    }

    // Load kompetensi table
    function loadKompetensiTable(kompetensis) {
        const tableBody = document.getElementById('kompetensiTableBody');
        
        if (!tableBody) return;

        if (kompetensis && kompetensis.length > 0) {
            let tableContent = '';
            
            kompetensis.forEach((kompetensi, index) => {
                tableContent += `
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">${index + 1}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${kompetensi.kode_uk}</td>
                        <td class="px-4 py-3 text-gray-700 text-left">${kompetensi.deskripsi_kompetensi}</td>
                    </tr>
                `;
            });
            
            tableBody.innerHTML = tableContent;
        } else {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">Tidak ada data kompetensi</td>
                </tr>
            `;
        }
    }

    // Load instruksi kerja editor
    function loadInstruksiKerjaEditor(instruksiKerja) {
        if (typeof quillEditor !== 'undefined' && quillEditor && instruksiKerja) {
            quillEditor.root.innerHTML = instruksiKerja;
        }
    }

    // Load proses assessment tables
    function loadProsesAssessmentTables(prosesAssessments) {
        const container = document.getElementById('prosesAssessmentContainer');
        
        if (!container) return;

        // Debug: log the data received from backend
        console.log('prosesAssessments:', prosesAssessments);

        if (prosesAssessments && prosesAssessments.length > 0) {
            let containerContent = '';
            
            prosesAssessments.forEach((proses) => {
                let instruksiRows = '';
                
                if (proses.instruksi_kerjas && proses.instruksi_kerjas.length > 0) {
                    proses.instruksi_kerjas.forEach((instruksi) => {
                        instruksiRows += `
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700 text-center">${instruksi.nomor_urut}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">${instruksi.instruksi_kerja}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">${instruksi.standar_alat_media}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">${instruksi.output_yang_diharapkan}</td>
                            </tr>
                        `;
                    });
                } else {
                    instruksiRows = `
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-center text-gray-500">Tidak ada instruksi kerja</td>
                        </tr>
                    `;
                }

                containerContent += `
                    <div class="p-4 border-border_input rounded-lg bg-white">
                        <h3 class="text-lg font-semibold text-sidebar_font mb-4">Proses ${proses.nomor_proses}</h3>
                        <div class="mb-3">
                            <span class="text-sm font-medium text-sidebar_font">Judul: </span>
                            <span class="text-sm text-gray-700">${proses.judul_proses}</span>
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
                                    ${instruksiRows}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = containerContent;
        } else {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <p>Tidak ada data proses assessment</p>
                    <!-- Debug: If you see this, check the API response for proses_assessments field -->
                </div>
            `;
        }
    }

    // Back to list function
    window.kembaliKeList = function() {
        const detailSection = document.getElementById('detailIA02');
        const listSection = document.querySelector('#frameIA02 > div:first-child');
        const breadcrumbContainer = document.getElementById('breadcrumbs');
        
        if (detailSection && listSection) {
            detailSection.classList.add('hidden');
            listSection.style.display = 'block';
        }
        
        if (breadcrumbContainer) {
            breadcrumbContainer.classList.add('hidden');
        }
        
        currentAsesiId = null;
    };

    // Back button event listener
    const backButton = document.getElementById('kembaliKeList');
    if (backButton) {
        backButton.addEventListener('click', kembaliKeList);
    }

    // Save IA02 button event listener
    const saveIA02Button = document.getElementById('simpanIA02');
    if (saveIA02Button) {
        saveIA02Button.addEventListener('click', saveAndSignIA02);
    }

    // Save and sign IA02 function
    async function saveAndSignIA02() {
        if (!currentAsesiId) {
            showNotificationModal('Error', 'Tidak ada asesi yang dipilih', 'error');
            return;
        }

        const button = document.getElementById('simpanIA02');
        const originalText = button.innerHTML;

        try {
            // Show loading state
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menyimpan...
            `;

            // First, save the instruksi kerja content
            if (typeof quillEditor !== 'undefined' && quillEditor) {
                const instruksiKerjaContent = quillEditor.root.innerHTML;
                
                const updateResponse = await fetch(`${apiConfig.url}/asesmen/ia02/asesor/${currentAsesiId}/update`, {
                    method: 'POST',
                    headers: apiHeaders,
                    body: JSON.stringify({
                        instruksi_kerja: instruksiKerjaContent,
                        status: 'approved'
                    })
                });

                if (!updateResponse.ok) {
                    throw new Error(`HTTP error! status: ${updateResponse.status}`);
                }

                const updateResult = await updateResponse.json();
                if (updateResult.status !== 'success') {
                    throw new Error(updateResult.message || 'Gagal menyimpan data');
                }
            }

            // Then, sign the IA02
            const signResponse = await fetch(`${apiConfig.url}/asesmen/ia02/asesor/${currentAsesiId}/sign`, {
                method: 'POST',
                headers: apiHeaders,
                body: JSON.stringify({
                    signature_data: 'digital_signature_data' // You can implement actual signature here
                })
            });

            if (!signResponse.ok) {
                throw new Error(`HTTP error! status: ${signResponse.status}`);
            }

            const signResult = await signResponse.json();
            if (signResult.status !== 'success') {
                throw new Error(signResult.message || 'Gagal menandatangani IA02');
            }

            // Show success message
            button.innerHTML = `
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Tersimpan!
            `;
            button.classList.remove('from-biru', 'to-ungu');
            button.classList.add('bg-green-600');

            showNotificationModal('Sukses', 'IA02 berhasil disimpan dan ditandatangani!', 'success');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('from-biru', 'to-ungu');
                button.disabled = false;
            }, 2000);

        } catch (error) {
            console.error('Save/Sign error:', error);
            showNotificationModal('Error', `Gagal menyimpan: ${error.message}`, 'error');

            // Restore button
            button.innerHTML = originalText;
            button.disabled = false;
        }
    }

    // Load initial data
    loadAsesiData();
});

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

// Function untuk sort tabel (jika diperlukan)
function sortTable(columnIndex) {
    // Implementasi sorting jika diperlukan
    console.log('Sorting column:', columnIndex);
}

// Show notification modal
function showNotificationModal(title, message, type = 'info') {
    // Create modal HTML
    const modalHTML = `
        <div id="notificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full ${type === 'success' ? 'bg-green-100' : type === 'error' ? 'bg-red-100' : type === 'warning' ? 'bg-yellow-100' : 'bg-blue-100'} mb-4">
                        ${type === 'success' ? 
                            '<svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                            type === 'error' ?
                            '<svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' :
                            type === 'warning' ?
                            '<svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732  4c-.77-.833-2.694-.833-3.464 0L3.34 16c-.77 1.333.192 2.5 1.732 2.5z"></path></svg>' :
                            '<svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                        }
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-2">${title}</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">${message}</p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="closeNotificationModal" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Remove existing modal if any
    const existingModal = document.getElementById('notificationModal');
    if (existingModal) {
        existingModal.remove();
    }

    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Add close event listener
    const closeButton = document.getElementById('closeNotificationModal');
    const modal = document.getElementById('notificationModal');
    
    if (closeButton && modal) {
        closeButton.addEventListener('click', function() {
            modal.remove();
        });

        // Close on background click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
    }
}

// Format date function
function formatDate(dateString) {
    if (!dateString) return 'Tidak tersedia';
    
    const date = new Date(dateString);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    return date.toLocaleDateString('id-ID', options);
}

// Format currency function (jika diperlukan)
function formatCurrency(amount) {
    if (!amount) return 'Rp 0';
    
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

// Loading indicator functions
function showLoadingIndicator(element, text = 'Memuat...') {
    if (element) {
        element.innerHTML = `
            <div class="flex items-center justify-center py-4">
                <svg class="animate-spin w-5 h-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600">${text}</span>
            </div>
        `;
    }
}

function hideLoadingIndicator(element, content = '') {
    if (element) {
        element.innerHTML = content;
    }
}
</script>

@endsection

