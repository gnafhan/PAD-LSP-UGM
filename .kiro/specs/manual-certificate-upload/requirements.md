# Requirements Document

## Introduction

This document specifies the requirements for a manual certificate upload system where administrators upload certificates for asesi (participants) who have completed their assessment process. The system replaces the previous auto-generated certificate approach with a manual upload workflow. Asesi can then download their certificates from their dashboard once uploaded by admin.

## Glossary

- **Admin**: System administrator who manages users and uploads certificates
- **Asesi**: Assessment participant/candidate who undergoes certification process
- **Certificate**: PDF document issued to asesi upon successful completion of assessment
- **Kompeten**: Status indicating asesi has completed all assessments (100% progress)
- **file_sertifikat**: Database field in asesi table storing the certificate file path

## Requirements

### Requirement 1

**User Story:** As an admin, I want to upload certificates for asesi who have completed their assessment, so that I can issue certificates manually.

#### Acceptance Criteria

1. WHEN an admin views the pengguna page THEN the System SHALL display an upload certificate button for asesi with "Kompeten" status
2. WHEN an admin clicks the upload certificate button THEN the System SHALL display a modal with file upload input accepting PDF files
3. WHEN an admin uploads a valid PDF file THEN the System SHALL store the file and update the asesi's file_sertifikat field
4. WHEN an admin uploads an invalid file type THEN the System SHALL reject the upload and display an error message
5. WHEN a certificate is already uploaded for an asesi THEN the System SHALL display a "Ganti Sertifikat" button instead of "Upload Sertifikat"

### Requirement 2

**User Story:** As an admin, I want to view and manage uploaded certificates, so that I can verify and replace certificates if needed.

#### Acceptance Criteria

1. WHEN an admin views an asesi with an uploaded certificate THEN the System SHALL display a download/view link for the certificate
2. WHEN an admin clicks the replace certificate button THEN the System SHALL allow uploading a new certificate to replace the existing one
3. WHEN a new certificate replaces an existing one THEN the System SHALL delete the old file from storage

### Requirement 3

**User Story:** As an asesi, I want to see my assessment completion status on my dashboard, so that I know when my certification process is complete.

#### Acceptance Criteria

1. WHEN an asesi has 100% progress THEN the System SHALL display "Selesai" with a checkmark icon instead of "Sedang berlangsung" for Proses Asesmen
2. WHEN an asesi has 100% progress but no certificate uploaded THEN the System SHALL display "Menunggu Sertifikat" status
3. WHEN an asesi has 100% progress and certificate is uploaded THEN the System SHALL display "Sertifikat Diterbitkan" status with download link

### Requirement 4

**User Story:** As an asesi, I want to download my certificate from my dashboard, so that I can access my certification document.

#### Acceptance Criteria

1. WHEN an asesi has a certificate uploaded THEN the System SHALL display a download button on the dashboard
2. WHEN an asesi clicks the download button THEN the System SHALL serve the certificate PDF file for download
3. WHEN an asesi does not have a certificate uploaded THEN the System SHALL display "Sertifikat belum siap" message
4. WHEN an asesi is not kompeten (progress < 100%) THEN the System SHALL not display any certificate section

### Requirement 5

**User Story:** As an admin, I want the certificate download button on pengguna page to download the uploaded certificate, so that I can verify the certificate content.

#### Acceptance Criteria

1. WHEN an admin clicks the certificate download button for an asesi THEN the System SHALL download the uploaded certificate file
2. WHEN no certificate is uploaded for an asesi THEN the System SHALL disable or hide the download button
