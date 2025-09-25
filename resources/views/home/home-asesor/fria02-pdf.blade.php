<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.IA.02 - {{ $detailRincian->asesi->nama_asesi ?? 'Asesi' }}</title>
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
            <h1>FR.IA.02. FORMULIR TUGAS PRAKTIK DAN DEMONSTRASI</h1>
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
        <div class="section-title">Instruksi Kerja</div>
<div>
    {!! $formData->instruksi_kerja ?? '-' !!}
</div>
                </div>
@if($formData && $formData->prosesAssessments)
    @foreach($formData->prosesAssessments as $proses)
    <div class="unit-section">
        <div class="section-title">Proses {{ $proses->nomor_proses }}</div>
        <p><strong>Judul:</strong> {{ $proses->judul_proses }}</p>
        @if($proses->deskripsi_proses)
            <p>{!! $proses->deskripsi_proses !!}</p>
        @endif

        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:45%">Instruksi Kerja</th>
                    <th style="width:25%">Standar / Alat / Media</th>
                    <th style="width:25%">Output</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proses->instruksiKerjas as $instruksi)
                    <tr>
                        <td>{{ $instruksi->nomor_urut }}</td>
                        <td>{{ $instruksi->instruksi_kerja }}</td>
                        <td>{{ $instruksi->standar_alat_media ?? '-' }}</td>
                        <td>{{ $instruksi->output_yang_diharapkan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
                </div>
    @endforeach
@endif


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
