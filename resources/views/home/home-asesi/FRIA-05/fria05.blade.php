@extends('home.home-asesi.layouts.layout-asesi')

@section('title', 'FR.IA.05 - Pertanyaan Tertulis Pilihan Ganda')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home-asesi') }}" class="text-gray-500 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2">FR.IA.05 - Ujian Pilihan Ganda</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">FR.IA.05 - Pertanyaan Tertulis Pilihan Ganda</h1>
            <p class="mt-2 text-gray-600">Jawab semua pertanyaan dengan memilih jawaban yang paling tepat.</p>
        </div>

        <!-- Loading Indicator -->
        <div id="loadingIndicator" class="flex justify-center items-center py-12">
            <div class="text-center">
                <svg class="animate-spin h-10 w-10 text-blue-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-gray-600">Memuat soal ujian...</p>
            </div>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 hidden" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span id="errorText">Terjadi kesalahan.</span>
            </div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 hidden" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span id="successText">Berhasil!</span>
            </div>
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="hidden">
            <!-- Info Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Ujian
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600" id="totalQuestions">0</p>
                            <p class="text-sm text-gray-600">Total Soal</p>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <p class="text-2xl font-bold text-green-600" id="answeredCount">0</p>
                            <p class="text-sm text-gray-600">Terjawab</p>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <p class="text-2xl font-bold text-yellow-600" id="unansweredCount">0</p>
                            <p class="text-sm text-gray-600">Belum Dijawab</p>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <p class="text-2xl font-bold text-purple-600" id="skemaName">-</p>
                            <p class="text-sm text-gray-600">Skema</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Navigation -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700">Navigasi Soal</h3>
                </div>
                <div class="p-4">
                    <div id="questionNav" class="flex flex-wrap gap-2">
                        <!-- Question navigation buttons will be rendered here -->
                    </div>
                    <div class="mt-3 flex items-center gap-4 text-xs text-gray-500">
                        <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span> Terjawab</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-gray-300 rounded-full mr-1"></span> Belum Dijawab</span>
                        <span class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span> Soal Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Question Card -->
            <div id="questionCard" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-white font-semibold" id="questionTitle">Soal 1</h3>
                    <span id="savedIndicator" class="text-xs text-indigo-200 hidden">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Tersimpan
                    </span>
                </div>
                <div class="p-6">
                    <p id="questionText" class="text-gray-800 text-lg mb-6"></p>
                    
                    <div id="optionsContainer" class="space-y-3">
                        <!-- Options will be rendered here -->
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center mb-6">
                <button id="prevBtn" onclick="navigateQuestion(-1)" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Sebelumnya
                </button>
                
                <span id="questionCounter" class="text-gray-600 font-medium">1 / 10</span>
                
                <button id="nextBtn" onclick="navigateQuestion(1)" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                    Selanjutnya
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Submit Section -->
            <div id="submitSection" class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Kumpulkan Jawaban</h3>
                            <p class="text-sm text-gray-600">Pastikan semua soal sudah dijawab sebelum mengumpulkan.</p>
                        </div>
                        <button id="submitBtn" onclick="submitExam()" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Kumpulkan Jawaban
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result Section (shown after submit) -->
        <div id="resultSection" class="hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-8 text-center">
                    <svg class="w-16 h-16 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-white mb-2">Ujian Selesai!</h2>
                    <p class="text-green-100">Jawaban Anda telah berhasil dikumpulkan</p>
                </div>
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="inline-block p-6 bg-blue-50 rounded-xl">
                            <p class="text-sm text-gray-600 mb-2">Status Penilaian</p>
                            <p class="text-2xl font-bold text-blue-600">Menunggu Penilaian Asesor</p>
                        </div>
                    </div>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <span class="font-medium">Informasi:</span> Hasil ujian Anda akan dinilai oleh asesor. Status final (Kompeten/Tidak Kompeten) akan ditentukan oleh asesor berdasarkan penilaian menyeluruh.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('home-asesi') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Already Completed Section -->
        <div id="completedSection" class="hidden">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8 text-center">
                    <svg class="w-16 h-16 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-white mb-2">Ujian Sudah Dikerjakan</h2>
                    <p class="text-blue-100">Anda sudah menyelesaikan ujian pilihan ganda ini</p>
                </div>
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div id="finalDecisionContainer" class="inline-block p-6 rounded-xl">
                            <p class="text-sm text-gray-600 mb-2">Status Penilaian</p>
                            <p id="finalDecisionText" class="text-2xl font-bold">Menunggu Penilaian Asesor</p>
                        </div>
                    </div>

                    <div id="catatanAsesorContainer" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-2">Catatan Asesor:</p>
                        <p id="catatanAsesorText" class="text-sm text-gray-600"></p>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ route('home-asesi') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Questions Warning -->
        <div id="noQuestionsSection" class="hidden">
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-8 text-center">
                <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-yellow-800 mb-2">Belum Ada Soal</h3>
                <p class="text-yellow-700 mb-4">Soal ujian pilihan ganda belum dikonfigurasi untuk skema ini. Silakan hubungi admin.</p>
                <a href="{{ route('home-asesi') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>


<script>
// API Configuration
const apiConfig = {
    url: @json(config('services.api.url')),
    key: @json(config('services.api.key')),
    asesiId: @json(Auth::user()->asesi->id_asesi ?? null),
    csrfToken: @json(csrf_token())
};

const headers = {
    'Content-Type': 'application/json',
    'API-KEY': apiConfig.key,
    'Accept': 'application/json',
    'X-CSRF-TOKEN': apiConfig.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

// State
let questions = [];
let answers = {}; // { kode_soal: 'A' }
let currentQuestionIndex = 0;
let isSubmitted = false;
let examData = null;

// DOM Elements
const loadingIndicator = document.getElementById('loadingIndicator');
const errorMessage = document.getElementById('errorMessage');
const successMessage = document.getElementById('successMessage');
const mainContent = document.getElementById('mainContent');
const resultSection = document.getElementById('resultSection');
const completedSection = document.getElementById('completedSection');
const noQuestionsSection = document.getElementById('noQuestionsSection');

// Initialize
document.addEventListener('DOMContentLoaded', loadExamData);

async function loadExamData() {
    if (!apiConfig.asesiId) {
        showError('ID Asesi tidak ditemukan. Silakan login kembali.');
        return;
    }

    try {
        const response = await fetch(`${apiConfig.url}/asesmen/fria05/${apiConfig.asesiId}`, {
            method: 'GET',
            headers: headers
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success' && result.data) {
            examData = result.data;
            processExamData(result.data);
        } else {
            throw new Error(result.message || 'Gagal memuat data');
        }
    } catch (error) {
        showError('Gagal memuat data: ' + error.message);
    }
}

function processExamData(data) {
    hideLoading();

    // Check if no questions
    if (!data.has_questions || !data.list_soal || data.list_soal.length === 0) {
        noQuestionsSection.classList.remove('hidden');
        return;
    }

    questions = data.list_soal;

    // Load existing answers if any
    if (data.fria05 && data.fria05.list_jawaban) {
        data.fria05.list_jawaban.forEach(jawaban => {
            answers[jawaban.kode_soal] = jawaban.jawaban;
        });
    }

    // Check if already submitted (asesi has signed)
    if (data.fria05 && data.fria05.waktu_tanda_tangan_asesi) {
        isSubmitted = true;
        showCompletedSection(data);
        return;
    }

    // Show exam interface
    mainContent.classList.remove('hidden');
    
    // Update info
    document.getElementById('totalQuestions').textContent = questions.length;
    document.getElementById('skemaName').textContent = data.general_info?.judul_skema || '-';
    
    // Render navigation and first question
    renderQuestionNav();
    renderQuestion(0);
    updateStats();
}

function renderQuestionNav() {
    const nav = document.getElementById('questionNav');
    nav.innerHTML = '';

    questions.forEach((q, index) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = getNavButtonClass(index);
        btn.textContent = index + 1;
        btn.onclick = () => goToQuestion(index);
        btn.id = `nav-btn-${index}`;
        nav.appendChild(btn);
    });
}

function getNavButtonClass(index) {
    const base = 'w-10 h-10 rounded-lg font-medium text-sm transition-all ';
    const isAnswered = answers[questions[index].kode_soal];
    const isCurrent = index === currentQuestionIndex;

    if (isCurrent) {
        return base + 'bg-blue-500 text-white ring-2 ring-blue-300';
    } else if (isAnswered) {
        return base + 'bg-green-500 text-white hover:bg-green-600';
    } else {
        return base + 'bg-gray-200 text-gray-700 hover:bg-gray-300';
    }
}

function updateNavButtons() {
    questions.forEach((q, index) => {
        const btn = document.getElementById(`nav-btn-${index}`);
        if (btn) {
            btn.className = getNavButtonClass(index);
        }
    });
}

function renderQuestion(index) {
    const question = questions[index];
    currentQuestionIndex = index;

    // Update title
    document.getElementById('questionTitle').textContent = `Soal ${index + 1}`;
    document.getElementById('questionText').textContent = question.pertanyaan;
    document.getElementById('questionCounter').textContent = `${index + 1} / ${questions.length}`;

    // Render options
    const optionsContainer = document.getElementById('optionsContainer');
    optionsContainer.innerHTML = '';

    const options = [
        { key: 'A', value: question.jawaban_a },
        { key: 'B', value: question.jawaban_b },
        { key: 'C', value: question.jawaban_c },
        { key: 'D', value: question.jawaban_d },
    ];

    // Add option E if exists
    if (question.jawaban_e) {
        options.push({ key: 'E', value: question.jawaban_e });
    }

    options.forEach(opt => {
        if (!opt.value) return;

        const isSelected = answers[question.kode_soal] === opt.key;
        const optionDiv = document.createElement('label');
        optionDiv.className = `flex items-start p-4 rounded-lg border-2 cursor-pointer transition-all ${
            isSelected 
                ? 'border-blue-500 bg-blue-50' 
                : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'
        }`;
        optionDiv.innerHTML = `
            <input type="radio" name="answer" value="${opt.key}" 
                   class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                   ${isSelected ? 'checked' : ''}
                   onchange="selectAnswer('${question.kode_soal}', '${opt.key}')">
            <span class="ml-3">
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full ${
                    isSelected ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'
                } font-medium text-sm mr-2">${opt.key}</span>
                <span class="text-gray-800">${opt.value}</span>
            </span>
        `;
        optionsContainer.appendChild(optionDiv);
    });

    // Update navigation buttons state
    document.getElementById('prevBtn').disabled = index === 0;
    document.getElementById('nextBtn').disabled = index === questions.length - 1;

    // Update nav buttons
    updateNavButtons();

    // Hide saved indicator
    document.getElementById('savedIndicator').classList.add('hidden');
}

function selectAnswer(kodeSoal, answer) {
    answers[kodeSoal] = answer;
    
    // Re-render current question to update styling
    renderQuestion(currentQuestionIndex);
    
    // Update stats
    updateStats();

    // Auto-save
    saveAnswer(kodeSoal, answer);
}

async function saveAnswer(kodeSoal, answer) {
    // Show saving indicator
    const savedIndicator = document.getElementById('savedIndicator');
    savedIndicator.innerHTML = `
        <svg class="w-4 h-4 inline mr-1 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Menyimpan...
    `;
    savedIndicator.classList.remove('hidden');

    try {
        // Prepare all answers
        const listJawaban = Object.entries(answers).map(([kode, jawaban]) => ({
            kode_soal: kode,
            jawaban: jawaban
        }));

        const response = await fetch(`${apiConfig.url}/asesmen/fria05/asesi/save`, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify({
                id_asesi: apiConfig.asesiId,
                list_jawaban: listJawaban,
                is_signing: false
            })
        });

        const result = await response.json();

        if (result.status === 'success') {
            savedIndicator.innerHTML = `
                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Tersimpan
            `;
            setTimeout(() => savedIndicator.classList.add('hidden'), 2000);
        }
    } catch (error) {
        console.error('Error saving answer:', error);
        savedIndicator.innerHTML = `
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Gagal menyimpan
        `;
    }
}

function navigateQuestion(direction) {
    const newIndex = currentQuestionIndex + direction;
    if (newIndex >= 0 && newIndex < questions.length) {
        goToQuestion(newIndex);
    }
}

function goToQuestion(index) {
    renderQuestion(index);
}

function updateStats() {
    const answered = Object.keys(answers).length;
    const total = questions.length;
    const unanswered = total - answered;

    document.getElementById('answeredCount').textContent = answered;
    document.getElementById('unansweredCount').textContent = unanswered;
}

async function submitExam() {
    const answered = Object.keys(answers).length;
    const total = questions.length;

    if (answered < total) {
        const confirm = window.confirm(`Anda baru menjawab ${answered} dari ${total} soal. Yakin ingin mengumpulkan?`);
        if (!confirm) return;
    } else {
        const confirm = window.confirm('Yakin ingin mengumpulkan jawaban? Anda tidak dapat mengubah jawaban setelah dikumpulkan.');
        if (!confirm) return;
    }

    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Mengumpulkan...
    `;

    try {
        const listJawaban = Object.entries(answers).map(([kode, jawaban]) => ({
            kode_soal: kode,
            jawaban: jawaban
        }));

        const response = await fetch(`${apiConfig.url}/asesmen/fria05/asesi/save`, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify({
                id_asesi: apiConfig.asesiId,
                list_jawaban: listJawaban,
                is_signing: true // This marks the exam as submitted
            })
        });

        const result = await response.json();

        if (result.status === 'success') {
            isSubmitted = true;
            calculateAndShowResult();
        } else {
            throw new Error(result.message || 'Gagal mengumpulkan jawaban');
        }
    } catch (error) {
        showError('Gagal mengumpulkan jawaban: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.innerHTML = `
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Kumpulkan Jawaban
        `;
    }
}

function calculateAndShowResult() {
    // Hide main content, show result
    mainContent.classList.add('hidden');
    resultSection.classList.remove('hidden');
}

function showCompletedSection(data) {
    // Show completed section
    completedSection.classList.remove('hidden');

    // Check if asesor has made final decision
    if (data.fria05 && data.fria05.final_decision) {
        const finalDecisionContainer = document.getElementById('finalDecisionContainer');
        const finalDecisionText = document.getElementById('finalDecisionText');
        
        if (data.fria05.final_decision === 'Kompeten') {
            finalDecisionContainer.className = 'inline-block p-6 bg-green-50 rounded-xl';
            finalDecisionText.className = 'text-2xl font-bold text-green-600';
            finalDecisionText.textContent = 'KOMPETEN';
        } else {
            finalDecisionContainer.className = 'inline-block p-6 bg-red-50 rounded-xl';
            finalDecisionText.className = 'text-2xl font-bold text-red-600';
            finalDecisionText.textContent = 'TIDAK KOMPETEN';
        }

        // Show catatan asesor if exists
        if (data.fria05.catatan_asesor) {
            document.getElementById('catatanAsesorContainer').classList.remove('hidden');
            document.getElementById('catatanAsesorText').textContent = data.fria05.catatan_asesor;
        }
    } else {
        // Asesor belum menilai
        const finalDecisionContainer = document.getElementById('finalDecisionContainer');
        const finalDecisionText = document.getElementById('finalDecisionText');
        
        finalDecisionContainer.className = 'inline-block p-6 bg-yellow-50 rounded-xl';
        finalDecisionText.className = 'text-2xl font-bold text-yellow-600';
        finalDecisionText.textContent = 'Menunggu Penilaian Asesor';
    }
}

function showError(message) {
    loadingIndicator.classList.add('hidden');
    errorMessage.classList.remove('hidden');
    document.getElementById('errorText').textContent = message;
}

function showSuccess(message) {
    successMessage.classList.remove('hidden');
    document.getElementById('successText').textContent = message;
    setTimeout(() => successMessage.classList.add('hidden'), 3000);
}

function hideLoading() {
    loadingIndicator.classList.add('hidden');
}
</script>
@endsection
