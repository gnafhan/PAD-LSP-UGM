<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceptance Letter - {{ $nama_asesi }}</title>
    <style>
        @page {
            margin: 2.5cm 2.5cm 2.5cm 3cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .header p {
            font-size: 10pt;
            margin: 2px 0;
        }
        
        .title {
            text-align: center;
            margin: 30px 0;
        }
        
        .title h3 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0;
        }
        
        .nomor-surat {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 30px;
        }
        
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        
        .data-table {
            margin: 20px 0 20px 40px;
        }
        
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        .data-table td:first-child {
            width: 180px;
        }
        
        .data-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }
        
        .status-kompeten {
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .signature {
            margin-top: 50px;
            text-align: right;
            margin-right: 50px;
        }
        
        .signature-space {
            margin: 60px 0 10px 0;
        }
        
        .signature-name {
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            font-size: 10pt;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LEMBAGA SERTIFIKASI PROFESI</h1>
        <h1>UNIVERSITAS GADJAH MADA</h1>
        <p>Jl. Teknika Utara, Pogung, Mlati, Sleman, Yogyakarta 55281</p>
        <p>Telp: (0274) 563515 | Email: lsp@ugm.ac.id</p>
    </div>
    
    <div class="title">
        <h3>SURAT PENERIMAAN KOMPETENSI</h3>
        <h3>(ACCEPTANCE LETTER)</h3>
    </div>
    
    <div class="nomor-surat">
        Nomor: {{ $nomor_surat }}
    </div>
    
    <div class="content">
        <p>Dengan ini menyatakan bahwa:</p>
        
        <div class="data-table">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $nama_asesi }}</strong></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>{{ $nim }}</td>
                </tr>
                <tr>
                    <td>Tempat/Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $tempat_tanggal_lahir }}</td>
                </tr>
            </table>
        </div>
        
        <p>Telah mengikuti dan menyelesaikan proses asesmen kompetensi pada:</p>
        
        <div class="data-table">
            <table>
                <tr>
                    <td>Skema Sertifikasi</td>
                    <td>:</td>
                    <td><strong>{{ $nama_skema }}</strong></td>
                </tr>
                <tr>
                    <td>Kode Skema</td>
                    <td>:</td>
                    <td>{{ $nomor_skema }}</td>
                </tr>
                <tr>
                    <td>Tanggal Asesmen</td>
                    <td>:</td>
                    <td>{{ $tanggal_asesmen }}</td>
                </tr>
            </table>
        </div>
        
        <p>
            Dan dinyatakan <span class="status-kompeten">KOMPETEN</span> berdasarkan hasil asesmen yang telah dilakukan 
            sesuai dengan standar kompetensi yang ditetapkan oleh Lembaga Sertifikasi Profesi 
            Universitas Gadjah Mada.
        </p>
        
        <p>
            Yang bersangkutan berhak menerima Sertifikat Kompetensi dari Lembaga Sertifikasi Profesi 
            Universitas Gadjah Mada sebagai bukti telah memenuhi persyaratan kompetensi yang telah ditetapkan.
        </p>
    </div>
    
    <div class="signature">
        <p>Yogyakarta, {{ $tanggal_surat }}</p>
        <p>Kepala LSP UGM,</p>
        <div class="signature-space"></div>
        <p class="signature-name">_______________________</p>
        <p>NIP. _______________________</p>
    </div>
    
    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh sistem LSP UGM pada {{ $tanggal_surat }}</p>
    </div>
</body>
</html>
