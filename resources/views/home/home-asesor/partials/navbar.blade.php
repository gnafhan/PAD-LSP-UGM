<header class="bg-blue-300 p-3 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="w-16 h-16 ml-4">

        <!-- Navbar Links -->
        <div id="navbar" class="flex space-x-4">
            <a href="/home-asesor" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Home
            </a>
            <a href="/asesor1" class="text-white font-semibold hover:bg-blue-400 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Asesor
            </a>
            <a href="/logout" class="text-white font-semibold hover:bg-red-500 hover:text-gray-100 rounded-md px-3 py-2 transition duration-300">
                Logout
            </a>
        </div>
    </div>
</header>


<script>
    // JavaScript untuk toggle navbar pada layar kecil
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
