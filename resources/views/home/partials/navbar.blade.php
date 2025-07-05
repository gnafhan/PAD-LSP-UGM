<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-medium" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo Section (Left) -->
            <div class="flex-shrink-0">
                <a href="{{ route('home-visitor') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
                    <div class="hidden sm:block">
                        <span class="font-bricolage text-lg font-semibold text-gray-900">LSP UGM</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (Center) -->
            <div class="hidden md:flex items-center justify-center flex-1 px-8">
                <div class="flex items-center space-x-1">
                    <a href="{{ route('home-visitor') }}" 
                       class="nav-link {{ request()->routeIs('home-visitor') ? 'nav-link-active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('panduan') }}" 
                       class="nav-link {{ request()->routeIs('panduan') ? 'nav-link-active' : '' }}">
                        Panduan
                    </a>
                    <a href="{{ route('skema') }}" 
                       class="nav-link {{ request()->routeIs('skema') ? 'nav-link-active' : '' }}">
                        Skema Sertifikasi
                    </a>
                </div>
            </div>

            <!-- User Profile Section (Right) -->
            <div class="flex items-center space-x-4">
                <!-- Desktop Login Button -->
                <a href="{{ route('login') }}" 
                   class="hidden sm:inline-flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white font-inter font-semibold text-sm tracking-wide rounded-lg transition-all duration-300 ease-out hover:shadow-medium focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Login
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" 
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-all duration-200"
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
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-100 rounded-b-lg shadow-large">
                <a href="{{ route('home-visitor') }}" 
                   class="mobile-nav-link {{ request()->routeIs('home-visitor') ? 'mobile-nav-link-active' : '' }}"
                   @click="mobileMenuOpen = false">
                    Beranda
                </a>
                <a href="{{ route('panduan') }}" 
                   class="mobile-nav-link {{ request()->routeIs('panduan') ? 'mobile-nav-link-active' : '' }}"
                   @click="mobileMenuOpen = false">
                    Panduan
                </a>
                <a href="{{ route('skema') }}" 
                   class="mobile-nav-link {{ request()->routeIs('skema') ? 'mobile-nav-link-active' : '' }}"
                   @click="mobileMenuOpen = false">
                    Skema Sertifikasi
                </a>
                <div class="pt-4 border-t border-gray-100">
                    <a href="{{ route('login') }}" 
                       class="mobile-nav-link bg-sky-500 text-white hover:bg-sky-600"
                       @click="mobileMenuOpen = false">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Login
                    </a>
                </div>
            </div>
            </div>
        </div>
    </nav>

<!-- Spacer to prevent content from hiding under fixed navbar -->
<div class="h-16"></div>

