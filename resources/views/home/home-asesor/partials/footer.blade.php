<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Link Font Awesome -->
</head>
<body>
    <!-- Konten lainnya dari website kamu -->

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 shadow-medium">
        <!-- Main Footer Content -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                
                <!-- Company Information (Left) -->
                <div class="lg:col-span-4">
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-12 w-auto">
                        <div>
                            <h3 class="font-bricolage text-xl font-semibold text-gray-900 tracking-tight">LSP UGM</h3>
                            <p class="text-sm text-gray-600 font-inter">Lembaga Sertifikasi Profesi</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 font-inter text-sm leading-relaxed mb-6">
                        Lembaga Sertifikasi Profesi Universitas Gadjah Mada memberikan sertifikasi berkualitas tinggi yang diakui BNSP untuk mahasiswa aktif, mengukuhkan kompetensi dan membuka peluang karir.
                    </p>
                    
                    <!-- Contact Information -->
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-sky-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <p class="text-gray-600 font-inter text-sm">
                                Bulaksumur, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281
                            </p>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-sky-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:lsp@ugm.ac.id" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                lsp@ugm.ac.id
                            </a>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-sky-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:+62274588688" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                +62 (274) 588688
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Links (Middle) -->
                <div class="lg:col-span-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Menu Asesor -->
                        <div>
                            <h4 class="font-bricolage text-lg font-semibold text-gray-900 mb-4 tracking-tight">Menu Asesor</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('home-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        Beranda
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('biodata-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        Biodata
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('kompetensi-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        Kompetensi
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('hasil-asesmen-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        Hasil Asesmen
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Formulir & Dokumen -->
                        <div>
                            <h4 class="font-bricolage text-lg font-semibold text-gray-900 mb-4 tracking-tight">Formulir & Dokumen</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('frapl02-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        FR-APL-02
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('frak01-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        FR-AK-01
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('konsul-prauji-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        Konsultasi Pra Uji
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('ketidakberpihakan-asesor') }}" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                                        Pernyataan Ketidakberpihakan
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Newsletter & Social Media (Right) -->
                <div class="lg:col-span-3">
                    <!-- Newsletter Signup -->
                    <div class="mb-8">
                        <h4 class="font-bricolage text-lg font-semibold text-gray-900 mb-4 tracking-tight">Newsletter</h4>
                        <p class="text-gray-600 font-inter text-sm mb-4">
                            Dapatkan informasi terbaru tentang sertifikasi dan peluang karir.
                        </p>
                        <form id="newsletter-form" class="space-y-3" x-data="{ email: '' }">
                            <div>
                                <label for="newsletter-email" class="sr-only">Email address</label>
                                <input 
                                    type="email" 
                                    id="newsletter-email" 
                                    x-model="email"
                                    placeholder="Masukkan email Anda" 
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg font-inter text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent transition-all duration-200"
                                    required
                                >
                            </div>
                            <button 
                                type="submit" 
                                class="w-full bg-sky-500 hover:bg-sky-600 text-white font-inter font-semibold text-sm tracking-wide px-4 py-3 rounded-lg transition-all duration-300 ease-out hover:shadow-medium focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"
                            >
                                Berlangganan
                            </button>
                        </form>
                    </div>
                    
                    <!-- Social Media -->
                    <div>
                        <h4 class="font-bricolage text-lg font-semibold text-gray-900 mb-4 tracking-tight">Ikuti Kami</h4>
                        <div class="flex space-x-4">
                            <a href="https://www.instagram.com/ugm.yogyakarta" target="_blank" rel="noopener noreferrer" 
                               class="footer-social-link group">
                                <svg class="footer-social-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                            
                            <a href="https://m.youtube.com/@UGM.Yogyakarta" target="_blank" rel="noopener noreferrer" 
                               class="footer-social-link group">
                                <svg class="footer-social-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            
                            <a href="https://www.facebook.com/UGMYogyakarta/" target="_blank" rel="noopener noreferrer" 
                               class="footer-social-link group">
                                <svg class="footer-social-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            <a href="https://twitter.com/UGMYogyakarta/" target="_blank" rel="noopener noreferrer" 
                               class="footer-social-link group">
                                <svg class="footer-social-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                            
                            <a href="https://id.linkedin.com/school/universitas-gadjah-mada-ugm-/" target="_blank" rel="noopener noreferrer" 
                               class="footer-social-link group">
                                <svg class="footer-social-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            
                            <a href="https://www.tiktok.com/@ugm.id/" target="_blank" rel="noopener noreferrer" 
                               class="footer-social-link group">
                                <svg class="footer-social-icon" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar with Copyright and Legal Links -->
        <div class="border-t border-gray-100 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <!-- Copyright -->
                    <div class="text-center md:text-left">
                        <p class="text-gray-600 font-inter text-sm">
                            © {{ date('Y') }} Lembaga Sertifikasi Profesi UGM. All rights reserved.
                        </p>
                    </div>
                    
                    <!-- Legal Links -->
                    <div class="flex flex-wrap justify-center md:justify-end space-x-6">
                        <a href="#" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                            Privacy Policy
                        </a>
                        <a href="#" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                            Terms of Service
                        </a>
                        <a href="#" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                            Cookie Policy
                        </a>
                        <a href="#" class="text-gray-600 font-inter text-sm hover:text-sky-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 rounded">
                            Accessibility
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
