<header class="bg-blue-300 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center ">
            <!-- Logo -->
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-20 h-30 ml-10">

            <!-- Mobile Menu Button -->
            <button id="menu-button" class="block lg:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <!-- Navbar Links -->
            <nav id="navbar" class="hidden lg:flex space-x-4 font-ugm">
                <a href="/home" class="text-white font-semibold hover:text-gray-200">Home</a>
                <a href="/panduan" class="text-white font-semibold hover:text-gray-200">Panduan</a>
                <a href="/profile" class="text-white font-semibold hover:text-gray-200">Profil</a>
                <a href="/apl1/b1" class="text-white font-semibold hover:text-gray-200">Daftar Skema</a>
                <a href="/masuk" class="text-white font-semibold hover:text-gray-200">Masuk/Daftar</a>
            </nav>
        </div>
    </header>

    <script>
        // JavaScript to toggle the navbar on small screens
        const menuButton = document.getElementById('menu-button');
        const navbar = document.getElementById('navbar');

        menuButton.addEventListener('click', () => {
            navbar.classList.toggle('hidden');
        });
    </script>
