<header class="bg-blue-300 p-3 shadow-lg">
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
        <nav id="navbar" class="hidden lg:flex space-x-6 font-semibold">
            <a href="/home-asesi" class="text-white hover:text-gray-200 transition duration-200">Home</a>
            <a href="/assesi" class="text-white hover:text-gray-200 transition duration-200">Assesi</a>
            <a href="/logout" class="text-white hover:text-gray-200 transition duration-200">Logout</a>
        </nav>
    </div>
</header>

<script>
    // JavaScript untuk toggle navbar pada layar kecil
    const menuButton = document.getElementById('menu-button');
    const navbar = document.getElementById('navbar');

    menuButton.addEventListener('click', () => {
        navbar.classList.toggle('hidden');
    });
</script>
