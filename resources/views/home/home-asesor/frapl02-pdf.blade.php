<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.APL.02 - Asesmen Mandiri</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 10mm 15mm 10mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
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
        }

        h1 {
            font-size: 14pt;
            margin: 5px 0;
            padding: 0;
            font-weight: bold;
        }

        h2 {
            font-size: 12pt;
            margin: 15px 0 8px;
            padding: 0;
            font-weight: bold;
            page-break-after: avoid;
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

        .table-title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            padding: 6px 0;
            background-color: #f5f5f5;
        }

        .info-section table td {
            padding: 3px 6px;
        }

        .no-print {
            margin-bottom: 15px;
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
        }

        .kompetensi-select-print {
            border: 1px solid #333;
            padding: 2px 4px;
            font-size: 9pt;
            background-color: #fff;
        }

        .radio-cell label, .checkbox-cell label {
            display: block;
            padding: 4px 6px;
        }

        .radio-cell label input, .checkbox-cell label input {
            margin-right: 5px;
        }

        @media print {
            body {
                font-size: 10pt;
                line-height: 1.3;
            }

            .no-print, button, .hidden, select, textarea, input[type="checkbox"] {
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

            th, td {
                font-size: 9pt;
                padding: 3px 4px;
                word-wrap: break-word;
                hyphens: auto;
            }

            p, label, span {
                font-size: 10pt;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            #inputMetodeUji {
                display: block !important;
                border: 1px solid #333 !important;
                padding: 3px !important;
                background-color: #fff !important;
                font-size: 10pt !important;
            }

            #rekomendasi {
                display: block !important;
                border: 1px solid #333 !important;
                padding: 3px !important;
                background-color: #fff !important;
                font-size: 10pt !important;
            }

            #tandaTanganAsesi, #tandaTanganAsesorExisting {
                display: block !important;
            }

            #asesiSignatureDisplay, #asesorExistingSignature {
                border: none !important;
                background-color: #fff !important;
            }
        }
    </style>
</head>
<body style="overscroll-behavior-x: auto;">
<div class="container">
    <div class="no-print" style="text-align: right; padding-top: 20px; padding-right: 20px;">
        <button onclick="window.print()" class="print-btn" style="background-color: #4a6fdc; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px;">Cetak Dokumen</button>
    </div>

    <div class="header">
        <h1>FR.APL.02</h1>
        <h1>FORMULIR ASESMEN MANDIRI</h1>
    </div>

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

    <h2>Daftar Unit Kompetensi</h2>
    <div class="unit-section">
        <table>
            <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 25%; text-align: center;">Kode Unit</th>
                <th style="width: 50%; text-align: center;">Judul Unit</th>
                <th style="width: 20%; text-align: center;">Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td>J.620100.009.02</td>
                <td>Melakukan coding sederhana</td>
                <td>
                    <div id="statusUnit_0">Kompeten</div>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td>J.620100.013.07</td>
                <td>Menulis kode dengan kaidah yang baik</td>
                <td>
                    <div id="statusUnit_1">Kompeten</div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <h2>Rekaman Asesmen Mandiri</h2>
    <div class="rekaman-section">
        <div class="unit-rekaman">
            <p>No 1. **Kode Unit:** J.620100.009.02</p>
            <p>**Judul Unit:** Melakukan coding sederhana</p>
            <table>
                <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 75%; text-align: center;">Elemen Kompetensi</th>
                    <th style="width: 20%; text-align: center;">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>Mengidentifikasi coding sederhana</td>
                    <td>Kompeten</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td>Mengidentifikasi basic coding</td>
                    <td>Kompeten</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="unit-rekaman">
            <p>No 2. **Kode Unit:** J.620100.013.07</p>
            <p>**Judul Unit:** Menulis kode dengan kaidah yang baik</p>
            <table>
                <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th style="width: 75%; text-align: center;">Elemen Kompetensi</th>
                    <th style="width: 20%; text-align: center;">Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="text-align: center;">1</td>
                    <td>Mengidentifikasi penulisan kode dengan kaidah yang baik</td>
                    <td>Kompeten</td>
                </tr>
                <tr>
                    <td style="text-align: center;">2</td>
                    <td>Mengidentifikasi kaidah</td>
                    <td>Kompeten</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="p-4 mb-6" style="border: 1px solid #333; padding: 10px; margin-top: 20px;">
        <p style="font-weight: bold;">Hasil Asesmen Mandiri:</p>
        <p><strong>Rekomendasi:</strong></p>
        <p id="rekomendasiText">[Tidak ada rekomendasi]</p>
        <p style="font-weight: bold; margin-top: 10px;">Hasil Kompetensi: </p>
        <p id="hasilKompetensiText">Kompeten</p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Tanda Tangan Asesi</p>
            <div class="signature-box">
                <img id="tandaTanganAsesi" src="" alt="Tanda Tangan Asesi" style="max-width: 100%; max-height: 100%;">
            </div>
            <p>Nama: Yeka</p>
            <p>Tanggal: 19 Agustus 2025</p>
        </div>
        <div class="signature">
            <p>Tanda Tangan Asesor</p>
            <div class="signature-box">
                <img id="tandaTanganAsesorExisting" src="http://127.0.0.1:8000/storage/tanda_tangan/asesor_signature_1.png" alt="Tanda Tangan Asesor" style="max-width: 100%; max-height: 100%;">
            </div>
            <p>Nama: Budi Santoso</p>
            <p>Tanggal: 19 Agustus 2025</p>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        // This script would normally fetch data and populate the fields.
        // For this print-ready version, we'll assume the data is already in place.
        // For demonstration, we'll set some dummy values.
        document.getElementById('metodeUjiPrint').innerText = "Observasi dan Wawancara";
        document.getElementById('rekomendasiText').innerText = "Direkomendasikan Lanjut ke Tahap Asesmen";
        document.getElementById('hasilKompetensiText').innerText = "Kompeten";

        // Set dummy signatures for display
        document.getElementById('tandaTanganAsesi').src = "https://via.placeholder.com/200x100.png?text=Tanda+Tangan+Asesi";

        // Trigger the print dialog
        window.print();
    };
</script>
</body>
</html>
