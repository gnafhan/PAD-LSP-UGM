<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FR.AK.01 Persetujuan Asesmen dan Kerahasiaan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-md shadow-md">
        <h1 class="text-2xl font-bold text-center mb-6">FR.AK.01 Persetujuan Asesmen dan Kerahasiaan</h1>
        
        <!-- Deskripsi Persetujuan -->
        <p class="mb-6 text-gray-700">
            Persetujuan asesmen ini untuk menjamin bahwa asesi telah diberi arahan secara rinci tentang perencanaan dan proses asesmen.
        </p>

        <!-- Informasi Skema Sertifikasi -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Skema Sertifikasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Judul:</label>
                    <input type="text" value="KKNI Level II - Junior Programmer" class="w-full p-2 border rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">Nomor:</label>
                    <input type="text" value="JP-123456" class="w-full p-2 border rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">TUK:</label>
                    <input type="text" value="Tempat Kerja" class="w-full p-2 border rounded-md">
                </div>
            </div>
        </div>

        <!-- Nama Asesor dan Asesi -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nama Asesor:</label>
                    <input type="text" value="Muhammad Abdul Karim" class="w-full p-2 border rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">Nama Asesi:</label>
                    <input type="text" value="Belda Putri Pramono" class="w-full p-2 border rounded-md">
                </div>
            </div>
        </div>

        <!-- Bukti yang Akan Dikumpulkan -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bukti yang akan dikumpulkan</h2>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="checkbox" id="verifikasi-portofolio" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked>
                    <label for="verifikasi-portofolio" class="ml-2 text-gray-700">TL: Verifikasi Portofolio</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="observasi-langsung" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked>
                    <label for="observasi-langsung" class="ml-2 text-gray-700">L: Observasi Langsung</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="tes-tulis" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="tes-tulis" class="ml-2 text-gray-700">T: Hasil Tes Tulis</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="tes-lisan" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="tes-lisan" class="ml-2 text-gray-700">T: Hasil Tes Lisan</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="wawancara" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="wawancara" class="ml-2 text-gray-700">T: Hasil Wawancara</label>
                </div>
            </div>
        </div>

        <!-- Pelaksanaan Asesmen -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Pelaksanaan Asesmen</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Hari/Tanggal:</label>
                    <input type="text" value="Senin, 20 Oktober 2024" class="w-full p-2 border rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">Waktu:</label>
                    <input type="text" value="10:00 WIB" class="w-full p-2 border rounded-md">
                </div>
                <div>
                    <label class="block text-gray-700">TUK:</label>
                    <input type="text" value="Tempat Kerja" class="w-full p-2 border rounded-md">
                </div>
            </div>
        </div>

        <!-- Pernyataan Persetujuan -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Pernyataan Persetujuan</h2>
            <p class="text-gray-700 mb-4">
                <strong>Asesi:</strong> Bahwa saya sudah mendapatkan penjelasan Hak dan Prosedur Banding oleh asesor.
            </p>
            <p class="text-gray-700">
                <strong>Asesor:</strong> Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai asesor dalam pekerjaan asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai asesor yang ditugaskan oleh LSP.
            </p>
            <p class="text-gray-700 mt-4">
                <strong>Asesi:</strong> Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.
            </p>
        </div>

        <!-- Tanda Tangan -->
        <div class="flex justify-between mt-8">
            <!-- Tanda Tangan Asesi -->
            <div>
                <h3 class="text-sm font-bold">Asesi</h3>
                <p class="mt-2">Nama: Belda Putri Pramono</p>
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" id="approve-asesi" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="approve-asesi" class="text-sm">Saya menyetujui persetujuan asesmen</label>
                </div>
                <p class="mt-2">TTD: <img src="signature.png" alt="Signature" class="h-6 inline"></p>
                <p>Tgl: 20-10-2024</p>
            </div>

            <!-- Tanda Tangan Asesor -->
            <div>
                <h3 class="text-sm font-bold">Asesor</h3>
                <p class="mt-2">Nama: Muhammad Abdul Karim</p>
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" id="approve-asesor" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked disabled>
                    <label for="approve-asesor" class="text-sm">TTD Asesor</label>
                </div>
                <p class="mt-2">TTD: <img src="admin-signature.png" alt="Admin Signature" class="h-6 inline"></p>
                <p>Tgl: 20-10-2024</p>
            </div>
        </div>
    </div>
</body>
</html>
