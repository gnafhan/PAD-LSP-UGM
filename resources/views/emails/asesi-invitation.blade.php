@component('mail::message')
# Undangan Event Sertifikasi

Yth. Peserta,

Anda telah diundang untuk mengikuti event sertifikasi berikut:

**Event:** {{ $eventName }}

**Tanggal:** {{ $eventDates }}

**Skema Sertifikasi:** {{ $skemaName }}

Untuk memulai proses pendaftaran, silakan login menggunakan akun Google Anda dengan mengklik tombol di bawah ini:

@component('mail::button', ['url' => $loginUrl])
Login dengan Google
@endcomponent

**Instruksi Penting:**
- Anda harus menggunakan alamat email yang menerima undangan ini untuk login
- Setelah login, Anda akan dipandu melalui proses pendaftaran
- Event dan skema sertifikasi Anda telah ditentukan sebelumnya
- Harap selesaikan pendaftaran Anda sebelum tanggal event

Jika Anda memiliki pertanyaan atau tidak mengharapkan menerima undangan ini, silakan hubungi administrator.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
