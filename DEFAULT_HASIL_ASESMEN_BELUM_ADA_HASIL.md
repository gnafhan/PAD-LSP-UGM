# Default Hasil Asesmen: Belum Ada Hasil

## Overview
Default value untuk status hasil asesmen sekarang adalah `'belum_ada_hasil'` bukan `'kompeten'`.

## Changes Made

### 1. Migration (`database/migrations/2025_07_18_160743_create_hasil_asesmen_table.php`)
- **Updated**: Enum values dari `['kompeten', 'tidak_kompeten']` menjadi `['kompeten', 'tidak_kompeten', 'belum_ada_hasil']`
- **Added**: Default value `'belum_ada_hasil'`

### 2. New Migration (`database/migrations/2025_12_22_075414_update_hasil_asesmen_add_belum_ada_hasil_status.php`)
- **Purpose**: Update existing table to add 'belum_ada_hasil' option and set as default
- **Action**: 
  - Modify enum column to include 'belum_ada_hasil'
  - Set default value to 'belum_ada_hasil'
  - Update existing NULL values to 'belum_ada_hasil'

### 3. Model (`app/Models/HasilAsesmen.php`)
- **Added**: `protected $attributes` with default status = 'belum_ada_hasil'
- **Updated**: `setStatus()` method to support 'belum_ada_hasil'

### 4. Controller (`app/Http/Controllers/Asesor/HasilAsesmenController.php`)
- **Already supports**: 'belum_ada_hasil' in validation and logic
- **Create method**: Default status is 'belum_ada_hasil'
- **Store/Update**: Supports all three statuses

## Status Options

1. **belum_ada_hasil** (DEFAULT)
   - Warna: Abu-abu
   - Icon: Clock
   - Meaning: Asesor belum menentukan hasil asesmen

2. **kompeten**
   - Warna: Hijau
   - Icon: Checkmark
   - Meaning: Asesi dinyatakan kompeten
   - Effect: Admin dapat upload sertifikat

3. **tidak_kompeten**
   - Warna: Merah
   - Icon: X
   - Meaning: Asesi dinyatakan tidak kompeten
   - Effect: Tidak dapat upload sertifikat

## Migration Instructions

Untuk menjalankan migration di production:

```bash
php artisan migrate
```

Migration akan:
1. Menambahkan 'belum_ada_hasil' ke enum status
2. Set default value ke 'belum_ada_hasil'
3. Update semua record dengan status NULL menjadi 'belum_ada_hasil'

## Rollback

Jika perlu rollback:

```bash
php artisan migrate:rollback
```

Akan mengembalikan enum ke `['kompeten', 'tidak_kompeten']` tanpa default value.
