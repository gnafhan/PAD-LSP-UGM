<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.AK.07 - Formulir Penyesuaian yang Wajar dan Beralasan</title>
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
<body>
<div class="container">
    <div class="no-print">
        <button onclick="window.print();" class="print-btn">Cetak PDF</button>
    </div>

    <div class="header">
        <h1>FR.AK.07. FORMULIR PENYESUAIAN YANG WAJAR DAN BERALASAN</h1>
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

    <div class="panduan-section">
        <h2 class="section-title" style="text-align: center;">PANDUAN BAGI ASESOR</h2>
        <ul class="panduan-list">
            <li>Formulir ini digunakan pada saat pelaksanaan pra asesmen ada asesi yang mempunyai keterbatasan sesuai karakteristik yang dimilikinya sehinga diperlukan penyesuaian yang wajar dan beralasan dan atau ada penyesuaian rencana asesemen, jika tidak sesuai dengan acuan pembanding, potensi asesi dan konteks asesi.</li>
            <li>Formulir ini terdiri dari dua bagian yaitu bagian A, jika asesi mempunyai keterbatasan sesuai karakteristik yang dimilikinya dan agian B: penyesuaian rencana asesmen, jika tidak sesuai dengan acuan pembanding, potensi asesi dan konteks asesi.</li>
            <li>Coretalah pada tanda * yang tidak sesuai.</li>
            <li>Berilah tanda &checkmark; Ya atau Tidak pada tanda ** sesuai pilihan.</li>
            <li>Berilah tanda &checkmark; pada kotak '☐' pada kolom potensi asesi.</li>
            <li>Berilah tanda &checkmark; Ya atau Tidak pada tanda ** sesuai pilihan dan jika jawaban Ya selanjutanya pada kolom keterangan berilah tanda &checkmark; di kotak '☐' yang tersedia dan pilihannya boleh lebih dari satu pilihan disesuiakan kebutuhan.</li>
            <li>Formulir ini juga digunakan untuk bagian B, jika rekaman rencana asesmen tervalidasi tidak sesuai dengan acuan pembanding, potensi asesi dan konteks asesi.</li>
            <li>Berilah tanda &checkmark; Ya atau Tidak pada tanda** sesuai pilihan dan jika jawaban Ya selanjutanya pada kolom keterangan dengan***tuliskan penyesuaian yang diperlukan.</li>
        </ul>
    </div>
    <div class="section-title">Potensi Asesi</div>
    <table>
        @foreach($potensiAsesi as $potensi)
        <tr>
            <td width="25%">{{ $potensi['deskripsi'] }}</td>
            <td width="5%" style="text-align: center">☐</td>
        </tr>
        @endforeach
    </table>

{{--    @dd($seeder_a)--}}
    <div class="section-title">Bagian A. Penyesuaian sesuai karekteristik asesi</div>
    <table>
        <thead>
        <tr>
            <th rowspan="2" width="5%" style="text-align: center;">No</th>
            <th rowspan="2" width="35%">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi (karakteristik asesi)</th>
            <th colspan="2" width="10%" style="text-align: center;">Penyesuaian</th>
            <th rowspan="2" width="50%" style="text-align: center;">Keterangan</th>
        </tr>
        <tr>
            <th style="text-align: center;">Ya</th>
            <th style="text-align: center;">Tidak</th>
        </tr>
        </thead>
        <tbody>
        @php $rowspan_count = 0; @endphp
        @foreach ($seeder_a as $index => $item)
            @php
                $keterangan_list = json_decode($item->opsi_penyesuaian, true);
                $rowspan_count = count($keterangan_list);
            @endphp
            <tr>
                <td rowspan="{{ $rowspan_count }}" style="text-align: center;">{{ $index + 1 }}</td>
                <td rowspan="{{ $rowspan_count }}">{{ $item->deskripsi }}</td>
                <td rowspan="{{ $rowspan_count }}" style="text-align: center;">☐</td>
                <td rowspan="{{ $rowspan_count }}" style="text-align: center;">☐</td>
                <td>☐ {{ $keterangan_list[0] }}</td>
            </tr>
            @for ($i = 1; $i < $rowspan_count; $i++)
                <tr>
                    <td>☐ {{ $keterangan_list[$i] }}</td>
                </tr>
            @endfor
        @endforeach
        </tbody>
    </table>

    <div class="section-title">Bagian B. Penyesuaian sesuai karekteristik asesi</div>
    <table>
        <thead>
        <tr>
            <th width="5%" style="text-align: center;">No</th>
            <th width="40%" style="text-align: left;">Rekaman Rencana Asesmen</th>
            <th width="10%" style="text-align: center;">Ya</th>
            <th width="10%" style="text-align: center;">Tidak</th>
            <th width="35%" style="text-align: left;">Keputusan Penyesuaian</th>
        </tr>
        </thead>
        <tbody>
        @foreach($seeder_b as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->rekaman_rencana_asesmen }}</td>
                <td style="text-align: center;">☐</td>
                <td style="text-align: center;">☐</td>
                <td>&nbsp;</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="section-title">Hasil</div>
    <ul class="panduan-list">
        <li>A. Hasil Penyesuaian Sesuai Karakteristik Asesi
            <ol class="panduan-list" style="list-style-type: decimal;">
                <li>Acuan Pembanding Asesmen: ( tuliskan nama acuan pembanding)</li>
                <li>Metode Asesmen: ( tuliskan nama metode asesmen)</li>
                <li>Instrumen Asesmen: ( tuliskan nama formulir instrumen asesmen)</li>
            </ol>
        </li>
        <li>B. Hasil Penyesuaian Rencana Asesmen Sesuai Acuan Pembanding, Potensi Asesi dan Konteks Asesi
            <ol class="panduan-list" style="list-style-type: decimal;">
                <li>Acuan Pembanding Asesmen: ( tuliskan nama acuan pembanding)</li>
                <li>Metode Asesmen: ( tuliskan nama metode asesmen)</li>
                <li>Instrumen Asesmen: ( tuliskan nama formulir instrumen asesmen)</li>
            </ol>
        </li>
    </ul>

    <div class="footer">
        <div class="signature">
            <p>Tanda Tangan Asesi</p>
            <div class="signature-box">
                [Tanda tangan asesi akan ditampilkan di sini]
            </div>
            <p>Nama: Yeka</p>
            <p>Tanggal: 07-08-2025</p>
        </div>
        <div class="signature">
            <p>Tanda Tangan Asesor</p>
            <div class="signature-box">
                [Tanda tangan asesor akan ditampilkan di sini]
            </div>
            <p>Nama: Budi Santoso</p>
            <p>Tanggal: 07-08-2025</p>
        </div>
    </div>
</div>

<script>
    // Auto print
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>
