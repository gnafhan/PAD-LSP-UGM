<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kompetensi - {{ $nama_asesi }}</title>
    <style>
        /* Note: Poppins font loaded via Google Fonts when network is available */
        /* Fallback to DejaVu Sans for PDF generation */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: 'DejaVu Sans', 'Poppins', sans-serif;
            background: #ffffff;
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
        }

        .certificate-container {
            width: 100%;
            height: 100%;
            padding: 15mm;
            position: relative;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        /* Border Design */
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 3px solid #1e40af;
            border-radius: 8px;
        }

        .border-inner {
            position: absolute;
            top: 12mm;
            left: 12mm;
            right: 12mm;
            bottom: 12mm;
            border: 1px solid #3b82f6;
            border-radius: 6px;
        }

        /* Corner Decorations */
        .corner {
            position: absolute;
            width: 30mm;
            height: 30mm;
            border: 2px solid #1e40af;
        }

        .corner-tl {
            top: 15mm;
            left: 15mm;
            border-right: none;
            border-bottom: none;
            border-top-left-radius: 10px;
        }

        .corner-tr {
            top: 15mm;
            right: 15mm;
            border-left: none;
            border-bottom: none;
            border-top-right-radius: 10px;
        }

        .corner-bl {
            bottom: 15mm;
            left: 15mm;
            border-right: none;
            border-top: none;
            border-bottom-left-radius: 10px;
        }

        .corner-br {
            bottom: 15mm;
            right: 15mm;
            border-left: none;
            border-top: none;
            border-bottom-right-radius: 10px;
        }

        /* Content Area */
        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 20mm 25mm;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Header Section */
        .header {
            margin-bottom: 8mm;
        }

        .logo-placeholder {
            width: 25mm;
            height: 25mm;
            margin: 0 auto 5mm;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 10pt;
        }

        .institution-name {
            font-size: 14pt;
            font-weight: 700;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2mm;
        }

        .institution-subtitle {
            font-size: 10pt;
            color: #475569;
            font-weight: 400;
        }

        /* Certificate Title */
        .certificate-title {
            margin: 8mm 0;
        }

        .title-main {
            font-size: 28pt;
            font-weight: 800;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 3mm;
        }

        .title-sub {
            font-size: 12pt;
            color: #64748b;
            font-weight: 400;
        }

        /* Main Content */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .intro-text {
            font-size: 11pt;
            color: #475569;
            margin-bottom: 5mm;
        }

        .recipient-name {
            font-size: 24pt;
            font-weight: 700;
            color: #0f172a;
            margin: 5mm 0;
            padding: 3mm 0;
            border-bottom: 2px solid #3b82f6;
            display: inline-block;
        }

        .competency-status {
            margin: 8mm 0;
        }

        .status-badge {
            display: inline-block;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            font-size: 18pt;
            font-weight: 700;
            padding: 4mm 15mm;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 3px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .scheme-info {
            margin: 6mm 0;
        }

        .scheme-label {
            font-size: 10pt;
            color: #64748b;
            margin-bottom: 2mm;
        }

        .scheme-name {
            font-size: 14pt;
            font-weight: 600;
            color: #1e40af;
        }

        .scheme-number {
            font-size: 10pt;
            color: #475569;
            margin-top: 1mm;
        }

        /* Footer Section */
        .footer {
            margin-top: auto;
        }

        .date-location {
            font-size: 10pt;
            color: #475569;
            margin-bottom: 8mm;
        }

        .signature-section {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            margin-top: 5mm;
        }

        .signature-box {
            text-align: center;
            width: 60mm;
        }

        .signature-line {
            border-top: 1px solid #1e40af;
            margin-top: 15mm;
            padding-top: 2mm;
        }

        .signature-title {
            font-size: 9pt;
            color: #475569;
            margin-bottom: 1mm;
        }

        .signature-name {
            font-size: 10pt;
            font-weight: 600;
            color: #0f172a;
        }

        /* Certificate Number */
        .certificate-number {
            position: absolute;
            bottom: 18mm;
            left: 20mm;
            font-size: 8pt;
            color: #94a3b8;
        }

        .asesi-id {
            position: absolute;
            bottom: 18mm;
            right: 20mm;
            font-size: 8pt;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Border Decorations -->
        <div class="border-outer"></div>
        <div class="border-inner"></div>
        <div class="corner corner-tl"></div>
        <div class="corner corner-tr"></div>
        <div class="corner corner-bl"></div>
        <div class="corner corner-br"></div>

        <!-- Content -->
        <div class="content">
            <!-- Header -->
            <div class="header">
                <div class="logo-placeholder">LSP<br>UGM</div>
                <div class="institution-name">Lembaga Sertifikasi Profesi</div>
                <div class="institution-subtitle">Universitas Gadjah Mada</div>
            </div>

            <!-- Certificate Title -->
            <div class="certificate-title">
                <div class="title-main">Sertifikat</div>
                <div class="title-sub">Kompetensi Profesi</div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="intro-text">Dengan ini menyatakan bahwa:</div>
                
                <div class="recipient-name">{{ $nama_asesi }}</div>
                
                <div class="competency-status">
                    <span class="status-badge">{{ $status }}</span>
                </div>

                <div class="scheme-info">
                    <div class="scheme-label">Pada Skema Sertifikasi:</div>
                    <div class="scheme-name">{{ $nama_skema }}</div>
                    <div class="scheme-number">No. {{ $nomor_skema }}</div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="date-location">
                    Yogyakarta, {{ $tanggal }}
                </div>

                <div class="signature-section">
                    <div class="signature-box">
                        <div class="signature-title">Ketua LSP UGM</div>
                        <div class="signature-line">
                            <div class="signature-name">_______________________</div>
                        </div>
                    </div>

                    <div class="signature-box">
                        <div class="signature-title">Asesor</div>
                        <div class="signature-line">
                            <div class="signature-name">_______________________</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificate Number -->
        <div class="certificate-number">No: {{ $nomor_sertifikat }}</div>
        <div class="asesi-id">ID: {{ $id_asesi }}</div>
    </div>
</body>
</html>
