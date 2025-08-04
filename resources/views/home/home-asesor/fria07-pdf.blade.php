<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.IA.07 - {{ $detailRincian->asesi->nama_asesi ?? 'Asesi' }}</title>
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
        
        .question-answer-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        .question-text {
            font-weight: bold;
            margin-bottom: 5px;
            background-color: #f9f9f9;
            padding: 5px;
            border-left: 3px solid #333;
        }
        
        .answer-text {
            margin-bottom: 10px;
            padding: 5px;
            border: 1px solid #ddd;
            background-color: #fafafa;
        }
        
        .assessment-result {
            text-align: center;
            font-weight: bold;
            padding: 3px;
            border: 1px solid #333;
        }
        
        .kompeten {
            background-color: #d4edda;
            color: #155724;
        }
        
        .belum-kompeten {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <button onclick="window.print();" class="print-btn">Cetak PDF</button>
        </div>

        <div class="header">
            <h1>FR.IA.07. FORMULIR PERTANYAAN LISAN</h1>
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
                <tr>
                    <td>Nama Asesor</td>
                    <td>: {{ $detailRincian->asesor->nama_asesor ?? '-' }}</td>
                </tr>
                <tr>
                    <td>TUK</td>
                    <td>: {{ $detailRincian->event->tuk->nama_tuk ?? '-' }}</td>
                </tr>
                @php
                    $tanggal_ttd = '';
                    if ($formData && $formData->waktu_tanda_tangan_asesor) {
                        $tanggal_ttd = \Carbon\Carbon::parse($formData->waktu_tanda_tangan_asesor)->format('d F Y');
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
            @php
                $unitKompetensi = $detailRincian->asesi->skema->unitKompetensiLoaded ?? collect();
                $formDataTambahan = $formData ? $formData->data_tambahan : [];
            @endphp
            
            @if($unitKompetensi && $unitKompetensi->count() > 0)
                @foreach($unitKompetensi as $index => $unit)
                    <div class="section-title">Unit Kompetensi {{ $index + 1 }}: {{ $unit->kode_uk }} - {{ $unit->nama_uk }}</div>
                    
                    @if($unit->elemen_uk && $unit->elemen_uk->count() > 0)
                        @foreach($unit->elemen_uk as $i => $elemen)
                            @php
                                $pertanyaan = '';
                                $jawaban = '';
                                $penilaian = '';
                                
                                // Get data from form data
                                if (isset($formDataTambahan['unit_kompetensi'])) {
                                    foreach ($formDataTambahan['unit_kompetensi'] as $ukData) {
                                        if (($ukData['id_uk'] == $unit->id_uk || $ukData['kode_uk'] == $unit->kode_uk) && isset($ukData['elemen_kompetensi'])) {
                                            foreach ($ukData['elemen_kompetensi'] as $elemenData) {
                                                if ($elemenData['id_elemen'] == $elemen->id_elemen_uk) {
                                                    $pertanyaan = $elemenData['pertanyaan_lisan'] ?? '';
                                                    $jawaban = $elemenData['jawaban_asesi'] ?? '';
                                                    $penilaian = $elemenData['penilaian'] ?? '';
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                            @endphp
                            
                            <div class="question-answer-section">
                                <table style="margin-bottom: 10px;">
                                    <tr>
                                        <th width="15%">Elemen {{ $i + 1 }}</th>
                                        <td>{{ $elemen->nama_elemen }}</td>
                                    </tr>
                                </table>
                                
                                @if($pertanyaan)
                                    <div class="question-text">
                                        <strong>Pertanyaan:</strong><br>
                                        {{ $pertanyaan }}
                                    </div>
                                @endif
                                
                                @if($jawaban)
                                    <div class="answer-text">
                                        <strong>Jawaban Asesi:</strong><br>
                                        {{ $jawaban }}
                                    </div>
                                @endif
                                
                                @if($penilaian)
                                    <div class="assessment-result {{ $penilaian === 'kompeten' ? 'kompeten' : 'belum-kompeten' }}">
                                        Penilaian: {{ $penilaian === 'kompeten' ? 'KOMPETEN' : 'BELUM KOMPETEN' }}
                                    </div>
                                @endif
                                
                                @if(!$pertanyaan && !$jawaban && !$penilaian)
                                    <div style="text-align: center; color: #666; font-style: italic; padding: 10px;">
                                        Belum ada data pertanyaan dan jawaban
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p style="text-align: center; color: #666;">Tidak ada elemen kompetensi</p>
                    @endif
                @endforeach
            @else
                <div class="section-title">Unit Kompetensi</div>
                <p style="text-align: center; color: #666;">Tidak ada unit kompetensi yang tersedia</p>
            @endif
        </div>

        <div class="results-section">
            <div class="section-title">Hasil</div>
            <table>
                <thead>
                    <tr>
                        <th width="35%">Kinerja</th>
                        <th width="15%">Kompeten</th>
                        <th width="20%">Tidak Kompeten</th>
                        <th width="30%">Umpan Balik</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Kinerja Asesi adalah</td>
                        @php
                            $kinerjaValue = '';
                            $umpanBalik = '';
                            if (isset($formDataTambahan['hasil'])) {
                                foreach ($formDataTambahan['hasil'] as $hasil) {
                                    if ($hasil['name'] === 'kinerja_asesi') {
                                        $kinerjaValue = $hasil['value'];
                                        $umpanBalik = $hasil['umpan_balik'] ?? '';
                                        break;
                                    }
                                }
                            }
                        @endphp
                        <td style="text-align: center">
                            @if($kinerjaValue === 'kompeten')
                                ✓
                            @endif
                        </td>
                        <td style="text-align: center">
                            @if($kinerjaValue === 'tidak_kompeten')
                                ✓
                            @endif
                        </td>
                        <td>{{ $umpanBalik }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <div class="signature">
                @php
                    $tanggalAsesi = '';
                    if ($formData && $formData->waktu_tanda_tangan_asesi) {
                        $tanggalAsesi = \Carbon\Carbon::parse($formData->waktu_tanda_tangan_asesi)->format('d F Y');
                    }
                @endphp
                <p>Tanggal: {{ $tanggalAsesi ?: $tanggal_ttd }}</p>
                <div class="signature-line"></div>
                <p>{{ $detailRincian->asesi->nama_asesi ?? 'Nama Asesi' }}</p>
                <p>Asesi</p>
            </div>
            <div class="signature">
                <p>Tanggal: {{ $tanggal_ttd }}</p>
                <div class="signature-line"></div>
                <p>{{ $detailRincian->asesor->nama_asesor ?? 'Nama Asesor' }}</p>
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
