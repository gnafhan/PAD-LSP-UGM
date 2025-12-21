# Requirements Document

## Introduction

Sistem sertifikasi LSP UGM memiliki berbagai jenis instrumen asesmen (IA) dengan template dan struktur konten yang berbeda-beda. Fitur ini akan menyediakan manajemen konten asesmen yang sesuai dengan template masing-masing jenis IA per skema. Admin dan Asesor dapat mengelola konten spesifik seperti soal pilihan ganda untuk IA05, instruksi kerja untuk IA02, pertanyaan lisan untuk IA07, dan konfigurasi MAPA sesuai dengan struktur template yang sudah ada.

## Glossary

- **Skema**: Program sertifikasi kompetensi dengan unit kompetensi tertentu
- **IA (Instrumen Asesmen)**: Formulir/dokumen yang digunakan dalam proses asesmen
- **IA01**: Observasi Aktivitas di Tempat Kerja - checklist kompetensi per elemen UK
- **IA02**: Tugas Praktik dan Demonstrasi - instruksi kerja dengan rich text
- **IA05**: Pertanyaan Tertulis Pilihan Ganda - soal multiple choice dengan opsi jawaban
- **IA07**: Pertanyaan Lisan - pertanyaan per elemen UK dengan penilaian kompeten/tidak kompeten
- **IA11**: Ceklis Verifikasi Portofolio - checklist verifikasi dokumen portofolio
- **MAPA01**: Merencanakan Aktivitas dan Proses Asesmen - form pendekatan asesmen dengan radio buttons
- **MAPA02**: Peta Instrumen Asesmen - checklist MUK dengan rating potensi asesi
- **UK (Unit Kompetensi)**: Standar kompetensi yang harus dicapai
- **Elemen UK**: Bagian dari unit kompetensi yang lebih spesifik
- **Admin**: Superadmin yang dapat mengatur seluruh sistem
- **Asesor**: Penguji yang menilai asesi

## Requirements

### Requirement 1

**User Story:** As an Admin, I want to manage multiple choice questions (soal pilihan ganda) for IA05 per scheme, so that each scheme has its own unique assessment questions.

#### Acceptance Criteria

1. WHEN an Admin accesses the IA05 content management page for a scheme THEN the System SHALL display a list of existing multiple choice questions for that scheme
2. WHEN an Admin creates a new question THEN the System SHALL require question text, minimum 2 answer options, and marking of correct answer
3. WHEN an Admin edits a question THEN the System SHALL update the question while maintaining the scheme association
4. WHEN an Admin deletes a question THEN the System SHALL remove the question from the scheme after confirmation
5. WHEN an Admin reorders questions THEN the System SHALL update the display order for the scheme

### Requirement 2

**User Story:** As an Admin, I want to manage work instructions (instruksi kerja) for IA02 per scheme, so that each scheme has customized practical task instructions.

#### Acceptance Criteria

1. WHEN an Admin accesses the IA02 content management page for a scheme THEN the System SHALL display the current work instruction content with rich text formatting
2. WHEN an Admin edits the work instruction THEN the System SHALL save the rich text content with formatting preserved
3. WHEN an Admin uses the template loader THEN the System SHALL populate the editor with default template content
4. WHEN the work instruction is saved THEN the System SHALL associate the content with the specific scheme

### Requirement 3

**User Story:** As an Admin, I want to manage oral questions (pertanyaan lisan) for IA07 per scheme, so that assessors have scheme-specific questions for oral assessment.

#### Acceptance Criteria

1. WHEN an Admin accesses the IA07 content management page for a scheme THEN the System SHALL display oral questions organized by unit kompetensi and elemen
2. WHEN an Admin creates a new oral question THEN the System SHALL require question text and association with specific elemen UK
3. WHEN an Admin edits an oral question THEN the System SHALL update the question while maintaining the elemen UK association
4. WHEN an Admin deletes an oral question THEN the System SHALL remove the question after confirmation

### Requirement 4

**User Story:** As an Admin, I want to configure MAPA01 default options per scheme, so that the assessment planning form has scheme-appropriate options.

#### Acceptance Criteria

1. WHEN an Admin accesses the MAPA01 configuration page for a scheme THEN the System SHALL display configurable options for pendekatan asesmen
2. WHEN an Admin modifies the default selections THEN the System SHALL save the configuration for the scheme
3. WHEN an Asesor opens MAPA01 for an asesi THEN the System SHALL pre-populate with scheme-specific default options

### Requirement 5

**User Story:** As an Admin, I want to configure MAPA02 MUK checklist per scheme, so that the assessment instrument mapping is scheme-specific.

#### Acceptance Criteria

1. WHEN an Admin accesses the MAPA02 configuration page for a scheme THEN the System SHALL display the MUK checklist items
2. WHEN an Admin enables or disables MUK items THEN the System SHALL save the configuration for the scheme
3. WHEN an Admin sets default potensi asesi values THEN the System SHALL save the defaults for the scheme

### Requirement 6

**User Story:** As an Admin, I want to manage portfolio verification checklist for IA11 per scheme, so that each scheme has appropriate portfolio requirements.

#### Acceptance Criteria

1. WHEN an Admin accesses the IA11 content management page for a scheme THEN the System SHALL display the portfolio checklist items
2. WHEN an Admin adds a new checklist item THEN the System SHALL create the item with description and verification criteria
3. WHEN an Admin edits a checklist item THEN the System SHALL update the item while maintaining scheme association
4. WHEN an Admin deletes a checklist item THEN the System SHALL remove the item after confirmation

### Requirement 7

**User Story:** As an Admin, I want a unified content management dashboard per scheme, so that I can easily navigate between different IA content types.

#### Acceptance Criteria

1. WHEN an Admin selects a scheme THEN the System SHALL display a dashboard with tabs for each IA content type
2. WHEN an Admin switches between tabs THEN the System SHALL load the appropriate content management interface
3. WHEN content is modified in any tab THEN the System SHALL indicate unsaved changes before navigation

### Requirement 8

**User Story:** As an Asesor, I want to view and use scheme-specific content during assessment, so that I assess using the correct materials for each scheme.

#### Acceptance Criteria

1. WHEN an Asesor opens IA05 for an asesi THEN the System SHALL load questions specific to the asesi's scheme
2. WHEN an Asesor opens IA02 for an asesi THEN the System SHALL load work instructions specific to the asesi's scheme
3. WHEN an Asesor opens IA07 for an asesi THEN the System SHALL load oral questions specific to the asesi's scheme
4. IF scheme-specific content does not exist THEN the System SHALL display a message indicating content needs to be configured

### Requirement 9

**User Story:** As an Admin, I want to copy content from one scheme to another, so that I can quickly set up similar schemes.

#### Acceptance Criteria

1. WHEN an Admin initiates content copy THEN the System SHALL display a list of source schemes with content
2. WHEN an Admin selects source and target schemes THEN the System SHALL copy all content types to the target scheme
3. WHEN content already exists in target scheme THEN the System SHALL prompt for confirmation before overwriting
4. WHEN copy is complete THEN the System SHALL display a summary of copied content

