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
    </div>

    <!-- Tugas-tugas -->
    <div class="tugas-section">
        <div class="tugas-title">1. TUGAS OBSERVASI</div>
        <div class="tugas-content">
            {{ $tugasData['tugas_observasi'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">2. TUGAS PORTOFOLIO</div>
        <div class="tugas-content">
            {{ $tugasData['tugas_portofolio'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">3. TUGAS SIMULASI</div>
        <div class="tugas-content">
            {{ $tugasData['tugas_simulasi'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">4. TUGAS TANYA JAWAB</div>
        <div class="tugas-content">
            {{ $tugasData['tugas_tanya_jawab'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    <div class="tugas-section">
        <div class="tugas-title">5. TUGAS TERTULIS</div>
        <div class="tugas-content">
            {{ $tugasData['tugas_tertulis'] ?? 'Belum ada tugas yang diberikan.' }}
        </div>
    </div>

    @if(!empty($tugasData['tugas_lainnya']))
    <div class="tugas-section">
        <div class="tugas-title">6. TUGAS LAINNYA</div>
        <div class="tugas-content">
            {{ $tugasData['tugas_lainnya'] }}
        </div>
    </div>
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
