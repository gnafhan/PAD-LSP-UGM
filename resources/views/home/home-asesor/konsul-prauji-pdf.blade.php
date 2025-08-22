<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KONSULTASI PRA UJI - {{ $detailRincian->asesi->nama_asesi ?? 'Asesi' }}</title>
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
        
        .logo {
            max-width: 100px;
            margin-bottom: 8px;
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
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 35px 0 8px;
            height: 1px;
        }
        
        .info-section table td {
            padding: 3px 6px;
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
        
        .result-box {
            padding: 3px;
            border: 1px solid #333;
            display: inline-block;
            margin: 3px;
            min-width: 60px;
            text-align: center;
            font-size: 9pt;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <button onclick="window.print();" class="print-btn">Cetak PDF</button>
        </div>

        <div class="header">
            <h1>FORMULIR KONSULTASI PRA UJI</h1>
        </div>

        <div class="info-section">
            <table>
                <tr>
                    <td width="25%">Skema Sertifikasi</td>
                    <td>: {{ $detailRincian->asesi->skema->nama_skema ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nomor Skema</td>
                    <td>: {{ $detailRincian->asesi->skema->nomor_skema ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama Peserta</td>
                    <td>: {{ $detailRincian->asesi->nama_asesi ?? '-' }}</td>
                </tr>
                @php
                    $nama_asesor = '';
                    if ($formData && isset($formData->data_tambahan['nama_asesor'])) {
                        $nama_asesor = $formData->data_tambahan['nama_asesor'];
                    }
                @endphp
                <tr>
                    <td>Nama Asesor</td>
                    <td>: {{ $nama_asesor }}</td>
                </tr>
                @php
                    $tanggal_ttd = '';
                    if ($formData && isset($formData->data_tambahan['tanggal_ttd'])) {
                        $tanggal_ttd = $formData->data_tambahan['tanggal_ttd'];
                    } else {
                        $tanggal_ttd = date('d F Y');
                    }
                @endphp
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $tanggal_ttd }}</td>
                </tr>
            </table>
        </div>

<div class="unit-section">
    <h2 class="section-title">Checklist Pertanyaan Konsultasi Pra Asesmen</h2>
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th>Pertanyaan</th>
                <th style="width:20%">Jawaban Asesor</th>
            </tr>
        </thead>
        <tbody>
            @php
                $checklistItems = [
                    ['id' => 'point_1', 'text' => 'Pembukaan : Salam, menyampaikan tujuan pertemuan hari ini.<ul class="list-disc pl-5"><li>Memperkenalkan diri</li><li>Menanyakan nama dan asal peserta</li><li>Percakapan sederhana (Informal)</li><li>Menjelaskan maksud dilaksanakannya konsultasi pra asesmen</li></ul>'],
                    ['id' => 'point_2', 'text' => 'Proses asesmen dilaksanakan berdasarkan bukti atau evidence.'],
                    ['id' => 'point_3', 'text' => 'Kualifikasi Asesor, SKM (Skema Sertifikasi) yang akan diassesmenkan, Lembaga Sertifikasi Profesi Okupasi Pemandu Museum, Kementerian Pendidikan dan Kebudayaan.'],
                    ['id' => 'point_4', 'text' => 'Unit Kompetensi yang akan diujikan seperti tertera pada halaman depan.'],
                    ['id' => 'point_5', 'text' => 'Aturan bukti (valid, asli, terkini, dan memadai) yang perlu dikumpulkan oleh peserta.'],
                    ['id' => 'point_6', 'text' => 'Proses asesmen mencakup : <ul class="list-disc pl-5"><li>Mengumpulkan bukti (portofolio dan asesmen dari bank soal, simulasi/demonstrasi/praktek), bila memerlukan klarifikasi, asesor melakukan wawancara dan observasi langsung.</li></ul>'],
                    ['id' => 'point_7', 'text' => 'Sumber daya asesmen yang akan digunakan termasuk : Pertanyaan lisan, tes tertulis, simulasi tugas, dan praktek.'],
                    ['id' => 'point_8', 'text' => 'Formulir yang digunakan adalah : <ul class="list-disc pl-5"><li>APL-01 : Formulir Permohonan Sertifikasi Kompetensi</li><li>APL-02 : Formulir Asesmen Mandiri</li><li>FR.AK-01 : Formulir Persetujuan Asesmen dan Kerahasiaan</li><li>FR.MAPA-01 : Merencanakan Aktifitas & Proses Asesmen</li><li>FR.MAPA-02 : Formulir Peta Instrumen Asesmen Hasil Pendekatan Asesmen & Perencanaan Asesmen</li><li>FR.IA-01 : Formulir Ceklis Observasi (langsung/tidak langsung)</li><li>FR.IA-04 : Pertanyaan Untuk Mendukung Observasi</li><li>FR.IA-05 : Formulir Pertanyaan Tertulis</li><li>FR.IA-07 : Formulir Penilaian Praktek Simulasi</li><li>FR.AK-02 : Formulir Banding Asesmen</li><li>FR.AK-03 : Formulir Umpan Balik dari Asesi</li><li>FR.AK-04 : Keputusan & Umpan Balik Asesmen</li></ul>'],
                    ['id' => 'point_9', 'text' => 'Perencanaan Asesmen dan Kegiatan Pengembangan.']
                ];
            @endphp

            @foreach ($checklistItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{!! $item['text'] !!}</td>
                    <td>
                        {{ $formData->jawaban_checklist[$item['id']]['jawaban_asesor'] ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


        <div class="footer">
            <div class="signature">
                <p>Tanggal: {{ $tanggal_ttd }}</p>
                <div class="signature-line"></div>
                <p>{{ $detailRincian->asesi->nama_asesi ?? 'Nama Asesi' }}</p>
                <p>Asesi</p>
            </div>
            <div class="signature">
                <p>Tanggal: {{ $tanggal_ttd }}</p>
                <div class="signature-line"></div>
                <p>{{ $nama_asesor }}</p>
                <p>Asesor</p>
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
