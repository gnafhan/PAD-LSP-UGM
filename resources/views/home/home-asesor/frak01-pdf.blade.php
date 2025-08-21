<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.AK.01 - Formulir Persetujuan Asesmen & Kerahasiaan</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 10mm 15mm 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 11pt;
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }

        h1 {
            font-size: 14pt;
            margin: 5px 0;
            padding: 0;
            font-weight: bold;
        }

        h2 {
            font-size: 13pt;
            margin: 3px 0;
            padding: 0;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            page-break-inside: auto;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 4px 6px;
            text-align: left;
            font-size: 10pt;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .section-title {
            font-weight: bold;
            margin: 15px 0 8px;
            font-size: 12pt;
            page-break-after: avoid;
        }

        .info-section table td {
            padding: 3px 6px;
        }

        .panduan-list {
            margin-left: 15px;
            padding-left: 0;
            font-size: 10pt;
        }

        .panduan-list li {
            margin-bottom: 5px;
        }

        .checklist-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .checklist-item input[type="checkbox"] {
            margin-right: 5px;
        }

        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .signature {
            width: 45%;
            text-align: center;
            font-size: 10pt;
        }

        .signature-box {
            height: 100px;
            border: 1px solid #333;
            margin-top: 10px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9pt;
            color: #666;
            text-align: center;
            padding: 5px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin: 35px 0 8px;
            height: 1px;
        }

        .print-btn {
            background-color: #4a6fdc;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
            margin-bottom: 15px;
        }

        .print-btn:hover {
            background-color: #3a5dba;
        }

        .no-print {
            margin-bottom: 15px;
        }

        @media print {
            body {
                font-size: 10pt;
                line-height: 1.3;
            }

            .no-print {
                display: none !important;
            }

            button {
                display: none !important;
            }

            .container {
                padding: 0;
                margin: 0;
            }

            h1 {
                font-size: 13pt;
            }

            h2 {
                font-size: 12pt;
            }

            .section-title {
                font-size: 11pt;
            }

            th, td {
                font-size: 9pt;
                padding: 3px 4px;
                word-wrap: break-word;
                hyphens: auto;
            }

            .signature {
                font-size: 9pt;
            }

            .signature-line {
                margin: 25px 0 6px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .unit-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body style="overscroll-behavior-x: auto;">
<div class="container">
    <div class="no-print">
        <button onclick="window.print();" class="print-btn">Cetak PDF</button>
    </div>

    <div class="header">
        <h1>FR.AK.01. PERSETUJUAN ASESMEN & KERAHASIAAN</h1>
    </div>

    <p style="font-size: 10pt; margin-bottom: 10px;">Persetujuan ini untuk menjamin bahwa peserta sertifikasi/asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen.</p>

    <div class="info-section">
        <table>
            <tr>
                <td width="25%">Judul Sertifikasi</td>
                <td>: {{ $generalInfo['judul_skema'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nomor Sertifikasi</td>
                <td>: {{ $generalInfo['kode_skema'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Peserta Sertifikasi</td>
                <td>: {{ $generalInfo['nama_asesi'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Asesor</td>
                <td>: {{ $generalInfo['nama_asesor'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>TUK</td>
                <td>: {{ $generalInfo['nama_tuk'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $generalInfo['pelaksanaan_asesmen_disepakati_mulai'] ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Hasil yang Dikumpulkan</div>
    <div style="border: 1px solid #333; padding: 10px; margin-bottom: 15px;">
        <div style="display: flex; flex-wrap: wrap;">
            <div class="checklist-item" style="width: 33.3%;">
                <input type="checkbox" checked>
                <label>Hasil Observasi Langsung</label>
            </div>
            <div class="checklist-item" style="width: 33.3%;">
                <input type="checkbox">
                <label>Hasil Tes Tertulis</label>
            </div>
            <div class="checklist-item" style="width: 33.3%;">
                <input type="checkbox">
                <label>Hasil Tes Lisan</label>
            </div>
            <div class="checklist-item" style="width: 33.3%;">
                <input type="checkbox">
                <label>Hasil Portofolio</label>
            </div>
            <div class="checklist-item" style="width: 33.3%;">
                <input type="checkbox">
                <label>Hasil Tes Praktik</label>
            </div>
            <div class="checklist-item" style="width: 33.3%;">
                <input type="checkbox">
                <label>Hasil Wawancara</label>
            </div>
        </div>
    </div>

    <div class="section-title">Pernyataan Asesi</div>
    <p style="margin-bottom: 15px;">Bahwa saya telah mendapatkan penjelasan terkait hak dan prosedur banding asesmen dari asesor. Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>

    <div class="section-title">Pernyataan Asesor</div>
    <p style="margin-bottom: 15px;">Menyatakan tidak akan membukakan hasil pekerjaan yang saya peroleh karena penugasan saya sebagai asesor dalam asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai asesor yang ditugaskan oleh LSP.</p>

    <div class="footer">
        <div class="signature">
            <p>Tanda Tangan Asesi</p>
            <div class="signature-box">
                [Tanda tangan asesi akan ditampilkan di sini]
            </div>
            <p>Nama: Yeka</p>
            <p>Tanggal: 18-08-2025</p>
        </div>
        <div class="signature">
            <p>Tanda Tangan Asesor</p>
            <div class="signature-box">
                [Tanda tangan asesor akan ditampilkan di sini]
            </div>
            <p>Nama: Budi Santoso</p>
            <p>Tanggal: 18-08-2025</p>
        </div>
    </div>
</div>
</body>
</html>
