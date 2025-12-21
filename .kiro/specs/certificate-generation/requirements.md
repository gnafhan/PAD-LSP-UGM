# Requirements Document

## Introduction

Fitur ini memungkinkan asesi yang telah menyelesaikan seluruh proses asesmen (progress 100%) untuk mengunduh sertifikat kompetensi dalam format PDF. Sertifikat berisi informasi nama asesi, tanggal penerbitan, nama skema sertifikasi, tanda tangan, dan status "KOMPETEN". Template sertifikat menggunakan font Poppins dengan desain yang rapi dan profesional.

## Glossary

- **Asesi**: Peserta yang mengikuti proses sertifikasi kompetensi
- **Skema**: Program sertifikasi kompetensi yang diikuti oleh asesi
- **Progress**: Persentase penyelesaian seluruh tahapan asesmen
- **Sertifikat**: Dokumen resmi yang menyatakan bahwa asesi telah dinyatakan kompeten
- **PDF**: Format dokumen portabel yang digunakan untuk sertifikat
- **LSP UGM**: Lembaga Sertifikasi Profesi Universitas Gadjah Mada

## Requirements

### Requirement 1

**User Story:** As an asesi, I want to see a certificate download button when my assessment progress reaches 100%, so that I can obtain my competency certificate.

#### Acceptance Criteria

1. WHEN an asesi's assessment progress reaches 100% THEN the System SHALL display a certificate download button on the asesi home page
2. WHILE an asesi's assessment progress is below 100% THEN the System SHALL hide the certificate download button
3. WHEN the certificate download button is displayed THEN the System SHALL show a visual indicator that the asesi has completed all assessments

### Requirement 2

**User Story:** As an asesi, I want to download my certificate as a PDF file, so that I can save and print it for official use.

#### Acceptance Criteria

1. WHEN an asesi clicks the certificate download button THEN the System SHALL generate a PDF file containing the certificate
2. WHEN the PDF is generated THEN the System SHALL include the asesi's full name on the certificate
3. WHEN the PDF is generated THEN the System SHALL include the certificate issuance date in Indonesian format (e.g., "21 Desember 2025")
4. WHEN the PDF is generated THEN the System SHALL include the skema name that the asesi completed
5. WHEN the PDF is generated THEN the System SHALL include a signature placeholder area
6. WHEN the PDF is generated THEN the System SHALL display the text "KOMPETEN" prominently on the certificate

### Requirement 3

**User Story:** As an asesi, I want my certificate to have a professional and clean design, so that it looks official and presentable.

#### Acceptance Criteria

1. WHEN the certificate PDF is rendered THEN the System SHALL use the Poppins font family for all text elements
2. WHEN the certificate PDF is rendered THEN the System SHALL maintain consistent spacing and alignment throughout the document
3. WHEN the certificate PDF is rendered THEN the System SHALL include the LSP UGM logo or header
4. WHEN the certificate PDF is rendered THEN the System SHALL use a landscape orientation with A4 paper size

### Requirement 4

**User Story:** As a system administrator, I want the certificate generation to validate asesi eligibility, so that only qualified asesi can obtain certificates.

#### Acceptance Criteria

1. WHEN a certificate generation request is received THEN the System SHALL verify that the asesi's progress is exactly 100%
2. IF an unauthorized user attempts to generate a certificate for another asesi THEN the System SHALL reject the request and return an error
3. WHEN certificate generation fails due to missing data THEN the System SHALL display an appropriate error message to the asesi
