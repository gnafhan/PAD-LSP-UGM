<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo Section (Left) -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
                    <div class="hidden sm:block">
                        <span class="text-lg font-semibold text-gray-900">LSP UGM</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (Center) -->
            <div class="hidden md:flex items-center justify-center flex-1 px-8">
                <div class="flex items-center space-x-1">
                    <a href="{{ route('home') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('user.persetujuan.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors {{ request()->routeIs('user.persetujuan.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Daftar Sertifikasi
                    </a>
                </div>
            </div>

            <!-- User Profile Section (Right) -->
            <div class="flex items-center space-x-4">
                <!-- Desktop Logout Button -->
                <form method="POST" action="/user/logout" class="hidden md:block" id="logout-form-desktop">
                    @csrf
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold text-sm rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>

                <!-- Mobile Menu Button -->
                <button type="button" 
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        :aria-expanded="mobileMenuOpen"
                        aria-controls="mobile-menu">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger Icon -->
                    <svg class="w-6 h-6" 
                         x-show="!mobileMenuOpen"
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <!-- Close Icon -->
                    <svg class="w-6 h-6" 
                         x-show="mobileMenuOpen"
                         x-cloak
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden" 
             id="mobile-menu"
             x-show="mobileMenuOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-100 shadow-lg">
                <a href="{{ route('home') }}" 
                   class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}"
                   @click="mobileMenuOpen = false">
                    Beranda
                </a>
                <a href="{{ route('user.persetujuan.index') }}" 
                   class="block px-3 py-2 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ request()->routeIs('user.persetujuan.*') ? 'text-blue-600 bg-blue-50' : '' }}"
                   @click="mobileMenuOpen = false">
                    Daftar Sertifikasi
                </a>
                <div class="pt-2 border-t border-gray-100">
                    <form method="POST" action="/user/logout" id="logout-form-mobile">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center px-3 py-2 rounded-lg text-base font-medium text-white bg-red-500 hover:bg-red-600 transition-colors"
                                @click="mobileMenuOpen = false">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    [x-cloak] { display: none !important; }
</style>

<!-- Spacer to prevent content from hiding under fixed navbar -->
<div class="h-16"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get fresh CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        
        if (csrfToken) {
            const token = csrfToken.getAttribute('content');
            
            // Update all CSRF input fields in logout forms
            const logoutForms = document.querySelectorAll('#logout-form-desktop, #logout-form-mobile');
            logoutForms.forEach(form => {
                const csrfInput = form.querySelector('input[name="_token"]');
                if (csrfInput) {
                    csrfInput.value = token;
                }
                
                // Add submit handler to prevent double submission
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
                    }
                });
            });
        }
        
        // Handle logout errors gracefully
        window.addEventListener('pageshow', function(event) {
            // Re-enable buttons if user navigates back
            const logoutForms = document.querySelectorAll('#logout-form-desktop, #logout-form-mobile');
            logoutForms.forEach(form => {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && submitBtn.disabled) {
                    submitBtn.disabled = false;
                    // Restore original button content
                    const isDesktop = form.id === 'logout-form-desktop';
                    submitBtn.innerHTML = `
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    `;
                }
            });
        });
    });
</script>

