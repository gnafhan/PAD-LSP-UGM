@component('mail::message')
# Pembaruan Informasi Event Sertifikasi

Yth. Peserta,

Informasi event sertifikasi Anda telah diperbarui. Silakan tinjau detail yang diperbarui di bawah ini:

**Event:** {{ $eventName }}

**Tanggal:** {{ $eventDates }}

**Skema Sertifikasi yang Diperbarui:** {{ $skemaName }}

@component('mail::panel')
**Penting:** Penugasan skema sertifikasi Anda telah diubah. Harap tinjau detail skema baru dengan seksama.
@endcomponent

Jika Anda belum menyelesaikan pendaftaran, silakan login menggunakan akun Google Anda:

@component('mail::button', ['url' => $loginUrl])
Login dengan Google
@endcomponent

**Apa Artinya Ini:**
- Event Anda tetap sama
- Skema sertifikasi Anda telah diperbarui sesuai yang ditampilkan di atas
- Anda mungkin perlu meninjau persyaratan kompetensi yang berbeda
- Harap selesaikan pendaftaran Anda dengan informasi yang diperbarui

Jika Anda telah menyelesaikan pendaftaran, sistem telah diperbarui dengan penugasan skema sertifikasi baru Anda.

Jika Anda memiliki pertanyaan tentang perubahan ini, silakan hubungi administrator.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
