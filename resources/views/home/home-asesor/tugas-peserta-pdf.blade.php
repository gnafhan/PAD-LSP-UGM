<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Peserta - {{ $detailRincian->asesi->nama_asesi ?? 'Peserta' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .info-section {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            margin-right: 10px;
        }
        .tugas-section {
            margin-bottom: 25px;
        }
        .tugas-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            padding: 8px;
            background-color: #e8f4fd;
            border-left: 4px solid #007cba;
        }
        .tugas-content {
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
            min-height: 60px;
        }
        .footer {
            margin-top: 50px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .signature {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            width: 200px;
            height: 80px;
            margin: 20px 0 10px 0;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="title">TUGAS PESERTA ASESMEN</div>
        <div>Lembaga Sertifikasi Profesi - Universitas Gadjah Mada</div>
    </div>

    <!-- Informasi Peserta -->
    <div class="info-section">
        <h3 style="margin-top: 0; margin-bottom: 15px; color: #333;">Informasi Peserta</h3>
        <div class="info-row">
            <span class="info-label">Nama Peserta:</span>
            <span>{{ $detailRincian->asesi->nama_asesi ?? 'Tidak tersedia' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Skema Sertifikasi:</span>
            <span>{{ $detailRincian->asesi->skema->nama_skema ?? 'Tidak tersedia' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kode Skema:</span>
            <span>{{ $detailRincian->asesi->skema->nomor_skema ?? 'Tidak tersedia' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">TUK:</span>
            <span>{{ $detailRincian->event->tuk->nama_tuk ?? 'Tidak tersedia' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Asesor:</span>
            <span>{{ $detailRincian->asesor->nama_asesor ?? 'Tidak tersedia' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span>{{ date('d F Y') }}</span>
        </div>
        @if(isset($tugasData['submitted_tasks']) && $tugasData['submitted_tasks']->count() > 0)
        <div class="info-row">
            <span class="info-label">Jumlah Tugas Dikumpulkan:</span>
            <span>{{ $tugasData['submitted_tasks']->count() }} tugas</span>
        </div>
        @endif
    </div>

    @if(isset($tugasData['submitted_tasks']) && $tugasData['submitted_tasks']->count() > 0)
    <!-- Tugas yang Dikumpulkan Peserta -->
    <div class="info-section" style="margin-bottom: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 15px; color: #333;">Tugas yang Dikumpulkan Peserta</h3>
        @foreach($tugasData['submitted_tasks'] as $index => $task)
        <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9;">
            <div style="font-weight: bold; margin-bottom: 8px; color: #333;">
                {{ $index + 1 }}. {{ $task->judul_tugas }}
            </div>
            <div style="margin-bottom: 8px;">
                <span style="font-weight: bold;">Jenis Evidence:</span>
                @if($task->jenis_evidence == '1') 
                    Teks Jawaban
                @elseif($task->jenis_evidence == '2') 
                    Link Eksternal  
                @else 
                    File Upload
                @endif
            </div>
            <div style="margin-bottom: 8px;">
                <span style="font-weight: bold;">Status:</span>
                <span style="text-transform: capitalize; 
                      @if($task->status == 'submitted') color: #d69e2e;
                      @elseif($task->status == 'reviewed') color: #3182ce;
                      @elseif($task->status == 'approved') color: #38a169;
                      @elseif($task->status == 'rejected') color: #e53e3e;
                      @else color: #718096; @endif">
                    {{ $task->status }}
                </span>
                @if($task->nilai)
                    | <span style="font-weight: bold;">Nilai:</span> {{ $task->nilai }}
                @endif
            </div>
            <div style="margin-bottom: 8px;">
                <span style="font-weight: bold;">Waktu Submit:</span>
                {{ $task->waktu_submit->format('d F Y H:i') }}
            </div>
            
            @if($task->jenis_evidence == '1' && $task->teks_jawaban)
            <div style="margin-top: 10px;">
                <span style="font-weight: bold;">Jawaban:</span>
                <div style="background-color: #fff; padding: 10px; border: 1px solid #e2e8f0; margin-top: 5px;">
                    {{ strip_tags($task->teks_jawaban) }}
                </div>
            </div>
            @elseif($task->jenis_evidence == '2' && $task->link_eksternal)
            <div style="margin-top: 10px;">
                <span style="font-weight: bold;">Link:</span>
                <div style="background-color: #fff; padding: 10px; border: 1px solid #e2e8f0; margin-top: 5px; word-break: break-all;">
                    {{ $task->link_eksternal }}
                </div>
            </div>
            @elseif($task->jenis_evidence == '3' && $task->file_name)
            <div style="margin-top: 10px;">
                <span style="font-weight: bold;">File:</span>
                <div style="background-color: #fff; padding: 10px; border: 1px solid #e2e8f0; margin-top: 5px;">
                    {{ $task->file_name }} ({{ number_format($task->file_size / 1024, 1) }} KB)
                </div>
            </div>
            @endif
            
            @if($task->catatan_asesor)
            <div style="margin-top: 10px;">
                <span style="font-weight: bold;">Catatan Asesor:</span>
                <div style="background-color: #fff3cd; padding: 10px; border: 1px solid #ffeaa7; margin-top: 5px;">
                    {{ $task->catatan_asesor }}
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Tugas Instruksi dari Asesor -->
    @if(isset($tugasData['form_data']) && !empty(array_filter($tugasData['form_data'])))
    <div style="page-break-before: always;">
        <h3 style="margin-top: 20px; margin-bottom: 20px; color: #333; border-bottom: 2px solid #333; padding-bottom: 10px;">
            Instruksi Tugas dari Asesor
        </h3>
    <div class="tugas-section">
        <div class="tugas-title">1. TUGAS OBSERVASI</div>
        <div class="tugas-content">
            {{ $tugasData['form_data']['tugas_observasi'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">2. TUGAS PORTOFOLIO</div>
        <div class="tugas-content">
            {{ $tugasData['form_data']['tugas_portofolio'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">3. TUGAS SIMULASI</div>
        <div class="tugas-content">
            {{ $tugasData['form_data']['tugas_simulasi'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">4. TUGAS TANYA JAWAB</div>
        <div class="tugas-content">
            {{ $tugasData['form_data']['tugas_tanya_jawab'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">5. TUGAS TERTULIS</div>
        <div class="tugas-content">
            {{ $tugasData['form_data']['tugas_tertulis'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    @if(!empty($tugasData['form_data']['tugas_lainnya']))
    <div class="tugas-section">
        <div class="tugas-title">6. TUGAS LAINNYA</div>
        <div class="tugas-content">
            {{ $tugasData['form_data']['tugas_lainnya'] }}
        </div>
    </div>
    @endif
    @endif

    <!-- Footer dengan tanda tangan -->
    <div class="footer">
        <div class="signature-section">
            <div class="signature">
                <div>Peserta</div>
                <div class="signature-line"></div>
                <div>{{ $detailRincian->asesi->nama_asesi ?? 'Nama Peserta' }}</div>
                <div>Tanggal: ________________</div>
            </div>
            
            <div class="signature">
                <div>Asesor</div>
                <div class="signature-line"></div>
                <div>{{ $detailRincian->asesor->nama_asesor ?? 'Nama Asesor' }}</div>
                <div>Tanggal: {{ date('d F Y') }}</div>
            </div>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: center; color: #666; font-size: 10px;">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Informasi LSP UGM</p>
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
