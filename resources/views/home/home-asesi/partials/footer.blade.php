<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Link Font Awesome -->
    {{-- <link rel="stylesheet" href="path/to/your/custom-styles.css"> <!-- Link file CSS custom, jika ada --> --}}
</head>
<body>
    <!-- Konten lainnya dari website kamu -->

    <!-- Footer -->
    <footer class="bg-blue-300 py-6">
    <div class="container mx-auto flex flex-col items-center text-center space-y-4">



        <!-- Logo Section -->
        <div class="flex justify-center items-center space-x-4">
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-20 h-30"> <!-- Mengatur ukuran gambar lebih kecil -->
            <div class="text-white">
                <h2 class="text-xl font-semibold">Lembaga Sertifikasi Profesi</h2>
                <h2 class="text-lg">Universitas Gadjah Mada</h2>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="text-white space-y-2 text-lg">
            <p>Bulaksumur, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</p>
            <p>E: info@ugm.ac.id | P: +62(274)588688 | F: +62(274)565223 | WA: +628112869988</p>
        </div>

        <!-- Social Media Links -->
        <div class="flex space-x-4 text-white">
            <a href="https://www.instagram.com/ugm.yogyakarta" target="_blank" class="hover:text-gray-400">
                <i class="fab fa-instagram text-2xl"></i>
            </a>
            <a href="https://m.youtube.com/@UGM.Yogyakarta" target="_blank" class="hover:text-gray-400">
                <i class="fab fa-youtube text-2xl"></i>
            </a>
            <a href="https://www.facebook.com/UGMYogyakarta/" target="_blank" class="hover:text-gray-400">
                <i class="fab fa-facebook text-2xl"></i>
            </a>
            <a href="https://twitter.com/UGMYogyakarta/" target="_blank" class="hover:text-gray-400">
                <i class="fab fa-twitter text-2xl"></i>
            </a>
            <a href="https://id.linkedin.com/school/universitas-gadjah-mada-ugm-/" target="_blank" class="hover:text-gray-400">
                <i class="fab fa-linkedin text-2xl"></i>
            </a>
            <a href="https://www.tiktok.com/@ugm.id/" target="_blank" class="hover:text-gray-400">
                <i class="fab fa-tiktok text-2xl"></i>
            </a>
        </div>
    </div>
</footer>

</body>
</html>
