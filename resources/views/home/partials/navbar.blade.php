<style>
    #navbar {
        background-color: #93C5FD;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    }
</style>
<header id='navbar' class="w-full">
    <nav id="navbar" class="fixed z-20 top-0 inset-x-4 bg-biru mt-4 rounded-full shadow-lg">
        <div class="flex flex-wrap items-center justify-between mx-auto py-4 px-16">
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-12 me-3">
        </a>
        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
            <button data-collapse-toggle="navbar-cta" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-cta" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                <li>
                <a href="#" class="text-center block py-2 px-3 md:p-0 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:dark:text-blue-500" aria-current="page">Beranda</a>
                </li>
                <li>
                <a href="/panduan" class="text-center block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">Panduan</a>
                </li>
                <li>
                <a href="{{ route('skema') }}" class="text-center block py-2 px-3 md:p-0 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700">Sertifikasi</a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
</header>


{{-- Header visitor awal --}}
{{-- <header class="bg-blue-300 fixed top-0 z-50 py-3 px-16 mt-4 mx-4 shadow-lg bg-white/30 backdrop-blur-lg rounded-full">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-16 h-16 ml-4">

        <!-- Mobile Menu Button -->
        <button id="menu-button" class="block lg:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Navbar Links -->
        <nav id="navbar" class="hidden lg:flex space-x-4">
            <a href="/" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Home
            </a>
            <a href="/profile" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Profil
            </a>
            <a href="/panduan" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Panduan
            </a>
            <a href="{{ route('skema') }}" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Sertifikasi
            </a>
            <a href="/login" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Login
            </a>
        </nav>
    </div>

    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="lg:hidden bg-blue-300 mt-3 space-y-2 p-4 hidden">
        <a href="/" class="block text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
            Home
        </a>
        <a href="/profile" class="block text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
            Profil
        </a>
        <a href="/panduan" class="block text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
            Panduan
        </a>
        <a href="/skema" class="block text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
            Sertifikasi
        </a>
        <a href="/register" class="block text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
            Daftar
        </a>
        <a href="/login" class="block text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
            Login
        </a>
    </nav>
</header>

<script>
    // JavaScript untuk toggle navbar pada layar kecil
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
 --}}
