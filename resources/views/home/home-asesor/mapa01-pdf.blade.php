<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.MAPA.01 - Merencanakan Aktifitas & Proses Asesmen</title>
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

        .radio-cell {
            padding: 0;
        }

        .radio-cell label {
            display: block;
            padding: 4px 6px;
        }

        .radio-cell label input {
            margin-right: 5px;
        }

        .checkbox-cell {
            padding: 0;
        }

        .checkbox-cell label {
            display: block;
            padding: 4px 6px;
        }

        .checkbox-cell label input {
            margin-right: 5px;
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
        <h1>FR.MAPA.01</h1>
        <h1>MERENCANAKAN AKTIFITAS DAN PROSES ASESMEN</h1>
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

    <h2>1. Pendekatan Asesmen</h2>
    <table>
        <thead>
        <tr>
            <th style="width: 5%; text-align: center;">No</th>
            <th style="width: 25%; text-align: center;">Pendekatan Asesmen</th>
            <th style="width: 70%; text-align: center;">Opsi</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center;">1</td>
            <td>Asesi</td>
            <td class="radio-cell">
                <label><input type="checkbox" name="pendekatan_asesmen_asesi" value="Hasil pelatihan dan/atau pendidikan..." checked> Hasil pelatihan dan/atau pendidikan, dimana kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</label>
                <label><input type="checkbox" name="pendekatan_asesmen_asesi" value="Pekerja Berpengalaman..."> Pekerja Berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi</label>
                <label><input type="checkbox" name="pendekatan_asesmen_asesi" value="Pelatihan non formal/mandiri"> Pelatihan non formal/mandiri</label>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">2</td>
            <td>Tujuan Asesmen</td>
            <td class="radio-cell">
                <label><input type="checkbox" name="tujuan_asesmen" value="Sertifikasi" checked> Sertifikasi</label>
                <label><input type="checkbox" name="tujuan_asesmen" value="Sertifikasi Ulang"> Sertifikasi Ulang</label>
                <label><input type="checkbox" name="tujuan_asesmen" value="Pengakuan Kompetensi Terkini (PKT)"> Pengakuan Kompetensi Terkini (PKT)</label>
                <label><input type="checkbox" name="tujuan_asesmen" value="Rekognisi Pembelajaran Lampau (RPL)"> Rekognisi Pembelajaran Lampau (RPL)</label>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">3</td>
            <td>Konteks Asesmen</td>
            <td class="radio-cell">
                <p style="margin-top: 10px; margin-left: 5px">Lingkungan:</p>
                <label style="display: inline-block; width: 45%;"><input type="checkbox" name="lingkungan" value="Tempat kerja nyata" checked> Tempat Kerja Nyata</label>
                <label style="display: inline-block; width: 45%;"><input type="checkbox" name="lingkungan" value="Tempat kerja simulasi"> Tempat Kerja Simulasi</label>
                <p style="margin-top: 10px;margin-left: 5px">Peluang untuk mengumpulkan bukti dalam sejumlah situasi:</p>
                <label style="display: inline-block; width: 45%;"><input type="checkbox" name="peluang_untuk_mengumpulkan_bukti" value="Tersedia" checked> Tersedia</label>
                <label style="display: inline-block; width: 45%;"><input type="checkbox" name="peluang_untuk_mengumpulkan_bukti" value="Terbatas"> Terbatas</label>
                <p style="margin-top: 10px;margin-left: 5px">Hubungan antara standar kompetensi:</p>
                <label><input type="checkbox" name="hubungan_antara_standar_kompetensi" value="Bukti untuk mendukung asesmen / RPL" checked> Bukti untuk mendukung asesmen / RPL</label>
                <label><input type="checkbox" name="hubungan_antara_standar_kompetensi" value="Aktivitas kerja di tempat kerja kandidat"> Aktivitas kerja di tempat kerja kandidat</label>
                <label><input type="checkbox" name="hubungan_antara_standar_kompetensi" value="Kegiatan pembelajaran"> Kegiatan pembelajaran</label>
                <p style="margin-top: 10px;margin-left: 5px">Siapa yang melakukan asesmen / RPL:</p>
                <label><input type="checkbox" name="pelaksana_asesmen" value="Oleh Lembaga Sertifikasi" checked> Lembaga Sertifikasi</label>
                <label><input type="checkbox" name="pelaksana_asesmen" value="Organisasi pelatihan"> Organisasi pelatihan</label>
                <label><input type="checkbox" name="pelaksana_asesmen" value="Asesor perusahaan"> Asesor perusahaan</label>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">4</td>
            <td>Orang yang relevan untuk di Konfirmasi</td>
            <td class="radio-cell">
                <label><input type="checkbox" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Manajer sertifikasi LSP" checked> Manajer sertifikasi LSP</label>
                <label><input type="checkbox" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Master Assessor / Master Trainer / Asesor Utama Kompetensi"> Master Assessor / Master Trainer / Asesor Utama Kompetensi</label>
                <label><input type="checkbox" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Manajer pelatihan Lembaga Training terakreditasi / Lembaga Training terdaftar"> Manajer pelatihan Lembaga Training terakreditasi / Lembaga Training terdaftar</label>
                <label><input type="checkbox" name="pihak_yang_relevan_untuk_dikonfirmasi" value="Lainnya : Manajemen sertifikasi LSP"> Lainnya : Manajemen sertifikasi LSP</label>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">5</td>
            <td>Tolak Ukur Asesmen</td>
            <td class="radio-cell">
                <label><input type="checkbox" name="tolak_ukur_asesmen" value="Standar Kompetensi Kerja Nasional Indonesia (SKKNI)" checked> Standar Kompetensi Kerja Nasional Indonesia (SKKNI)</label>
                <label><input type="checkbox" name="tolak_ukur_asesmen" value="Standar Khusus"> Standar Khusus</label>
                <label><input type="checkbox" name="tolak_ukur_asesmen" value="Standar Internasional"> Standar Internasional</label>
            </td>
        </tr>
        </tbody>
    </table>

    <h2>2. Rencana Asesmen</h2>
    <table>
        <thead>
        <tr>
            <th rowspan="2" style="text-align: center;">Unit Kompetensi</th>
            <th rowspan="2" style="text-align: center;">Elemen</th>
            <th rowspan="2" style="text-align: center;">Bukti-bukti</th>
            <th colspan="3" style="text-align: center;">Jenis Bukti</th>
            <th rowspan="2" style="text-align: center;">Metode Asesmen</th>
        </tr>
        <tr>
            <th style="text-align: center;">L</th>
            <th style="text-align: center;">TL</th>
            <th style="text-align: center;">T</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="7" style="text-align: center; color: #777;">Tidak ada data rencana asesmen</td>
        </tr>
        </tbody>
    </table>

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
