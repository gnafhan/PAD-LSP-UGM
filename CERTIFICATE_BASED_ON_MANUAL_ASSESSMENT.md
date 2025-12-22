# Certificate Upload Based on Manual Assessment Results

## Overview
Sistem upload sertifikat sekarang berdasarkan hasil asesmen manual yang diset oleh asesor, bukan berdasarkan progress otomatis.

## Changes Made

### 1. Admin Pengguna Page (`resources/views/home/home-admin/pengguna.blade.php`)
- **Removed**: Status column (Kompeten/Masih Proses/Belum Mulai) yang berdasarkan progress
- **Removed**: Status filter dropdown
- **Updated**: Certificate upload button logic dari `$asesi->status_kompetensi == 'Kompeten'` menjadi `$asesi->hasil_asesmen && $asesi->hasil_asesmen->status === 'kompeten'`

### 2. Controller (`app/Http/Controllers/Admin/ManajemenPengguna/PenggunaPageController.php`)
- **Removed**: Status calculation logic berdasarkan progress
- **Removed**: Status filter logic
- **Kept**: Hasil asesmen relation loading

### 3. Certificate Service (`app/Services/CertificateService.php`)
- **Updated**: `isEligibleForCertificate()` method
  - **Before**: Check if progress = 100%
  - **After**: Check if hasil asesmen status = 'kompeten'

### 4. Asesi Controller (`app/Http/Controllers/AsesiController.php`)
- **Updated**: `index()` method
  - **Before**: Certificate status based on `$progressPercentage >= 100`
  - **After**: Certificate status based on `$isEligibleForCertificate` (which checks hasil asesmen)
- **Added**: Load `rincianAsesmen.hasilAsesmen` relation

### 5. Asesi Home Page (`resources/views/home/home-asesi/home-asesi.blade.php`)
- **Added**: Hasil Asesmen section showing manual assessment result (Kompeten/Tidak Kompeten/Belum Ada Hasil)
- **Updated**: Certificate status logic now based on manual assessment result
- **Display**: Shows color-coded badge based on assessment result

## Certificate Upload Logic

### Admin dapat upload sertifikat jika:
1. Asesi memiliki hasil asesmen (`hasil_asesmen` exists)
2. Status hasil asesmen = `'kompeten'`

### Button yang ditampilkan:
- **Upload Sertifikat**: Jika kompeten dan belum ada file sertifikat
- **Download**: Jika kompeten dan sudah ada file sertifikat
- **Ganti**: Jika kompeten dan sudah ada file sertifikat (untuk replace)

## Asesi Home Page Display

### Certificate Status:
- **issued**: Sertifikat sudah diupload → Show download button
- **waiting**: Kompeten tapi sertifikat belum diupload → Show waiting message
- **not_eligible**: Belum kompeten atau belum ada hasil → Show "Menunggu hasil asesmen"

### Hasil Asesmen Badge:
- **Kompeten**: Green badge with checkmark icon
- **Tidak Kompeten**: Red badge with X icon
- **Belum Ada Hasil**: Gray badge with clock icon

## Flow
1. Asesor set hasil asesmen di `/asesor/hasilasesmen` → pilih "Kompeten"
2. Asesi lihat hasil di `/asesi/home` → badge "Kompeten" muncul
3. Admin bisa upload sertifikat di `/admin/pengguna` → tombol "Upload Sertifikat" muncul
4. Asesi bisa download sertifikat di `/asesi/home` (jika sudah diupload)

## Database
- Hasil asesmen disimpan di tabel `hasil_asesmen`
- Field `status`: 'kompeten', 'tidak_kompeten', atau 'belum_ada_hasil'
- Relasi: `hasil_asesmen` → `rincian_asesmen` → `asesi`
