<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-medium" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo Section (Left) -->
            <div class="flex-shrink-0">
                <a href="{{ route('home-asesi') }}" data-no-transition class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">
                    <div class="hidden sm:block">
                        <span class="font-bricolage text-lg font-semibold text-gray-900">LSP UGM</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links (Center) -->
            <div class="hidden md:flex items-center justify-center flex-1 px-8">
                <div class="flex items-center space-x-1">
                    <a href="{{ route('home-asesi') }}" data-no-transition
                       class="nav-link {{ (request()->routeIs('home-asesi') || request()->is('asesi/home')) ? 'nav-link-active' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('asesi.index') }}" data-no-transition
                       class="nav-link {{ request()->routeIs('asesi.index') ? 'nav-link-active' : '' }}">
                        Alur Asesi
                    </a>
                </div>
            </div>

            <!-- User Profile Section (Right) -->
            <div class="flex items-center space-x-4">
                <!-- Desktop User Profile -->
                <div class="hidden sm:flex items-center space-x-3">
                    <!-- User Info -->
                    <div class="text-right">
                        <div class="text-sm font-inter font-semibold text-gray-900">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="text-xs text-gray-500 font-inter">
                            {{ Auth::user()->asesi->nama_asesi ?? 'Asesi' }} (Asesi)
                        </div>
                    </div>
                    <!-- User Avatar -->
                    <div class="relative">
                        <button type="button" 
                                @click="userMenuOpen = !userMenuOpen"
                                class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                            @if(Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="w-8 h-8 rounded-full bg-sky-500 flex items-center justify-center text-white font-inter font-semibold text-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <!-- User Dropdown Menu -->
                        <div x-show="userMenuOpen"
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-large border border-gray-100 py-2 z-50"
                             style="display: none;">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <div class="text-sm font-inter font-semibold text-gray-900">
                                    {{ Auth::user()->name }} (Asesi)
                                </div>
                                <div class="text-xs text-gray-500 font-inter">
                                    {{ Str::limit(Auth::user()->email, 20, '...') }}
                                </div>
                            </div>
                            <form method="POST" action="{{ route('asesi.logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-inter transition-colors duration-200">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

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
                <!-- Mobile User Info -->
                <div class="px-3 py-3 border-b border-gray-100">
                    <div class="flex items-center space-x-3">
                        @if(Auth::user()->profile_photo_url)
                            <img src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                        @else
                            <div class="w-10 h-10 rounded-full bg-sky-500 flex items-center justify-center text-white font-inter font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="text-sm font-inter font-semibold text-gray-900">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs text-gray-500 font-inter">
                                {{ Auth::user()->asesi->nama_asesi ?? 'Asesi' }} (Asesi)
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile Navigation Links -->
                <a href="{{ route('home-asesi') }}" data-no-transition
                   class="mobile-nav-link {{ (request()->routeIs('home-asesi') || request()->is('asesi/home')) ? 'mobile-nav-link-active' : '' }}"
                   @click="mobileMenuOpen = false">
                    Beranda
                </a>
                <a href="{{ route('asesi.index') }}" data-no-transition
                   class="mobile-nav-link {{ request()->routeIs('asesi.index') ? 'mobile-nav-link-active' : '' }}"
                   @click="mobileMenuOpen = false">
                    Alur Asesi
                </a>
                
                <!-- Mobile Logout -->
                <div class="pt-4 border-t border-gray-100">
                    <form method="POST" action="{{ route('asesi.logout') }}">
                        @csrf
                        <button type="submit" 
                                class="mobile-nav-link bg-red-500 text-white hover:bg-red-600 w-full text-left"
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

<!-- Spacer to prevent content from hiding under fixed navbar -->
<div class="h-16"></div>
