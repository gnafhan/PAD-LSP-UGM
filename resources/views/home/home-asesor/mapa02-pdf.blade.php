<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.MAPA.02 - Peta Instrumen Asesmen</title>
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

        .catatan {
            margin-top: 20px;
            font-size: 10pt;
        }

        .catatan p {
            margin: 2px 0;
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

        .radio-cell {
            padding-top: 7px;
            text-align: center;
        }

        .radio-cell input {
            margin: 0;
        }

        @media print {
            body {
                font-size: 10pt;
                line-height: 1.3;
            }

            .no-print, button {
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

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
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
        <h1>FR.MAPA.02</h1>
        <h1>PETA INSTRUMEN ASESMEN</h1>
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

    <h2>Peta Instrumen Asesmen Hasil Pendekatan Asesmen & Perencanaan Asesmen</h2>
    <table>
        <thead>
        <tr>
            <th rowspan="2" style="width: 5%; text-align: center;">No</th>
            <th rowspan="2" style="width: 25%; text-align: center;">MUK</th>
            <th colspan="5" style="width: 70%; text-align: center;">Potensi Asesi**</th>
        </tr>
        <tr>
            <th style="width: 14%; text-align: center;">1</th>
            <th style="width: 14%; text-align: center;">2</th>
            <th style="width: 14%; text-align: center;">3</th>
            <th style="width: 14%; text-align: center;">4</th>
            <th style="width: 14%; text-align: center;">5</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center; margin-top: 3px;">1</td>
            <td>Ceklis Observasi Untuk Aktivitas di Tempat Kerja atau Tempat Kerja Simulasi</td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_observasi" value="1"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_observasi" value="2"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_observasi" value="3"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_observasi" value="4"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_observasi" value="5"></td>
        </tr>
        <tr>
            <td style="text-align: center;">2</td>
            <td>Tugas Praktik Demonstrasi</td>
            <td class="radio-cell"><input type="checkbox" name="muk_tugas_praktik_demonstrasi" value="1"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_tugas_praktik_demonstrasi" value="2"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_tugas_praktik_demonstrasi" value="3"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_tugas_praktik_demonstrasi" value="4"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_tugas_praktik_demonstrasi" value="5"></td>
        </tr>
        <tr>
            <td style="text-align: center;">3</td>
            <td>Pertanyaan Tertulis - Esai</td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_tertulis_esai" value="1"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_tertulis_esai" value="2"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_tertulis_esai" value="3"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_tertulis_esai" value="4"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_tertulis_esai" value="5"></td>
        </tr>
        <tr>
            <td style="text-align: center;">4</td>
            <td>Pertanyaan Lisan</td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_lisan" value="1"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_lisan" value="2"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_lisan" value="3"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_lisan" value="4"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_pertanyaan_lisan" value="5"></td>
        </tr>
        <tr>
            <td style="text-align: center;">5</td>
            <td>Ceklis Verifikasi Portfolio</td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_verifikasi_portfolio" value="1"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_verifikasi_portfolio" value="2"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_verifikasi_portfolio" value="3"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_verifikasi_portfolio" value="4"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_verifikasi_portfolio" value="5"></td>
        </tr>
        <tr>
            <td style="text-align: center;">6</td>
            <td>Ceklis Meninjau Materi Uji Kompetensi</td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_meninjau_materi_uji" value="1"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_meninjau_materi_uji" value="2"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_meninjau_materi_uji" value="3"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_meninjau_materi_uji" value="4"></td>
            <td class="radio-cell"><input type="checkbox" name="muk_ceklis_meninjau_materi_uji" value="5"></td>
        </tr>
        </tbody>
    </table>

    <div class="catatan">
        <p>*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: diisi berdasarkan hasil penentuan pendekatan asesmen dan perencanaan asesmen</p>
        <p>**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Keterangan:</p>
        <ol style="padding-left: 20px; margin-top: 5px;">
            <li>Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi.</li>
            <li>Hasil pelatihan dan / atau pendidikan, dimana kurikulum berbasis kompetensi.</li>
            <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi.</li>
            <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya berbasis kompetensi.</li>
            <li>Pelatihan / belajar mandiri atau otodidak.</li>
        </ol>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Tanda Tangan Asesi</p>
            <div class="signature-box">
                [Tanda tangan asesi akan ditampilkan di sini]
            </div>
            <p>Nama: Yeka</p>
            <p>Tanggal: 19 Agustus 2025</p>
        </div>
        <div class="signature">
            <p>Tanda Tangan Asesor</p>
            <div class="signature-box">
                [Tanda tangan asesor akan ditampilkan di sini]
            </div>
            <p>Nama: Budi Santoso</p>
            <p>Tanggal: 19 Agustus 2025</p>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        // Check if the page is loaded in a browser (not a print preview)
        if (window.matchMedia) {
            const mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    // Before print dialog appears
                    console.log('Printing...');
                } else {
                    // After print dialog closes
                    console.log('Finished printing.');
                }
            });
        }
        window.print();
    };
</script>
</body>
</html>
