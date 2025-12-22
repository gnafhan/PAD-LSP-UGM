# Fitur Hasil Asesmen Manual

## Deskripsi
Fitur ini memungkinkan asesor untuk mengatur status hasil asesmen secara manual (Kompeten, Tidak Kompeten, atau Belum Ada Hasil), dan asesi dapat melihat hasil asesmen mereka.

## Fitur yang Ditambahkan

### 1. Untuk Asesor (http://localhost:8000/asesor/hasilasesmen)

#### Halaman Daftar Hasil Asesmen
- **Route**: `/asesor/hasilasesmen`
- **Method**: GET
- **Controller**: `HasilAsesmenController@index`
- **Fitur**:
  - Menampilkan daftar semua asesi yang ditangani oleh asesor
  - Menampilkan status hasil asesmen (Kompeten, Tidak Kompeten, Belum Ada Hasil)
  - Fitur pencarian berdasarkan nama asesi, skema, atau TUK
  - Tombol "Edit" untuk mengubah status hasil asesmen

#### Halaman Edit Hasil Asesmen
- **Route**: `/asesor/hasilasesmen/{id}/edit`
- **Method**: GET
- **Controller**: `HasilAsesmenController@edit`
- **Fitur**:
  - Menampilkan informasi lengkap asesi
  - Form untuk mengubah status hasil asesmen
  - Pilihan status: Kompeten, Tidak Kompeten, Belum Ada Hasil

#### Update Hasil Asesmen
- **Route**: `/asesor/hasilasesmen/{id}`
- **Method**: PUT
- **Controller**: `HasilAsesmenController@update`
- **Fitur**:
  - Menyimpan perubahan status hasil asesmen
  - Otomatis mengatur tanggal selesai jika status Kompeten atau Tidak Kompeten
  - Mengupdate progress asesmen (field `hasil_asesmen`)

### 2. Untuk Asesi (http://localhost:8000/asesi)

#### Halaman Hasil Asesmen
- **Route**: `/asesi/hasil-asesmen`
- **Method**: GET
- **Controller**: `AsesiController@hasilAsesmen`
- **Fitur**:
  - Menampilkan informasi peserta (nama, nomor peserta, skema)
  - Menampilkan status hasil asesmen dengan visual yang jelas:
    - **Kompeten**: Icon centang hijau, pesan selamat
    - **Tidak Kompeten**: Icon silang merah, informasi banding
    - **Belum Ada Hasil**: Icon jam, pesan menunggu penilaian
  - Menampilkan tanggal selesai asesmen (jika ada)
  - Informasi tambahan sesuai status
  - Tombol kembali ke dashboard

#### Link di Dashboard Asesi
- Tombol "Lihat Detail" ditambahkan di tabel hasil asesmen pada dashboard asesi
- Mengarah ke halaman detail hasil asesmen

## File yang Dimodifikasi/Ditambahkan

### Controllers
1. **app/Http/Controllers/Asesor/HasilAsesmenController.php**
   - Menambahkan method `edit()` dan `update()`

2. **app/Http/Controllers/AsesiController.php**
   - Menambahkan method `hasilAsesmen()`

### Models
1. **app/Models/RincianAsesmen.php**
   - Menambahkan relasi `hasilAsesmen()`

### Views
1. **resources/views/home/home-asesor/hasil-asesmen.blade.php**
   - Menambahkan kolom "Aksi" dengan tombol "Edit"
   - Mengubah status "-" menjadi "BELUM ADA HASIL"

2. **resources/views/home/home-asesor/edit-hasil-asesmen.blade.php** (Baru)
   - Halaman edit hasil asesmen untuk asesor

3. **resources/views/home/home-asesi/hasil-asesmen.blade.php** (Baru)
   - Halaman hasil asesmen untuk asesi

4. **resources/views/home/home-asesi/assesi.blade.php**
   - Menambahkan tombol "Lihat Detail" di tabel hasil asesmen

### Routes
1. **routes/web.php**
   - Menambahkan route untuk asesor:
     - `GET /asesor/hasilasesmen/{id}/edit` → `asesor.hasil-asesmen.edit`
     - `PUT /asesor/hasilasesmen/{id}` → `asesor.hasil-asesmen.update`
   - Menambahkan route untuk asesi:
     - `GET /asesi/hasil-asesmen` → `asesi.hasil-asesmen`

## Cara Penggunaan

### Untuk Asesor:
1. Login sebagai asesor
2. Buka menu "Hasil Asesmen" atau akses `/asesor/hasilasesmen`
3. Cari asesi yang ingin diubah statusnya (gunakan fitur pencarian jika perlu)
4. Klik tombol "Edit" pada baris asesi yang dipilih
5. Pilih status hasil asesmen:
   - **Kompeten**: Asesi lulus asesmen
   - **Tidak Kompeten**: Asesi tidak lulus asesmen
   - **Belum Ada Hasil**: Status default, belum ada keputusan
6. Klik "Simpan Perubahan"
7. Sistem akan otomatis:
   - Menyimpan status baru
   - Mengatur tanggal selesai (jika Kompeten/Tidak Kompeten)
   - Mengupdate progress asesmen

### Untuk Asesi:
1. Login sebagai asesi
2. Buka dashboard asesi
3. Scroll ke bagian "Hasil Asesmen"
4. Klik tombol "Lihat Detail"
5. Lihat status hasil asesmen Anda:
   - **Kompeten**: Selamat! Anda dinyatakan kompeten
   - **Tidak Kompeten**: Informasi tentang banding tersedia
   - **Belum Ada Hasil**: Hasil masih dalam proses penilaian

## Status Hasil Asesmen

### 1. Kompeten
- Asesi dinyatakan lulus asesmen
- Tanggal selesai dicatat
- Progress asesmen diupdate
- Asesi dapat melihat informasi tentang sertifikat

### 2. Tidak Kompeten
- Asesi dinyatakan tidak lulus asesmen
- Tanggal selesai dicatat
- Progress asesmen diupdate
- Asesi dapat melihat informasi tentang banding

### 3. Belum Ada Hasil
- Status default
- Belum ada keputusan dari asesor
- Tanggal selesai tidak dicatat
- Progress asesmen tidak diupdate

## Validasi
- Asesor hanya dapat mengedit hasil asesmen untuk asesi yang ditanganinya
- Status harus dipilih dari pilihan yang tersedia
- Sistem otomatis mengatur tanggal selesai berdasarkan status

## Keamanan
- Middleware `role:asesor` memastikan hanya asesor yang dapat mengakses halaman edit
- Middleware `role:asesi` memastikan hanya asesi yang dapat melihat hasil asesmen mereka
- Validasi di controller memastikan asesor hanya dapat mengedit data asesi yang ditanganinya
- Validasi di controller memastikan asesi hanya dapat melihat hasil asesmen mereka sendiri
