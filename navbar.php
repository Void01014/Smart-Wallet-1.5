<div class="sticky top-0 bg-gray-900 text-gray-100 flex justify-between items-center p-4 md:hidden w-full z-50">
        <a href="#" class="block font-bold text-indigo-400">Smart Wallet</a>
        <button onclick="toggleSidebar()" class="focus:outline-none focus:bg-gray-700 p-2 rounded">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <nav id="sidebar" class="fixed bg-gray-900 text-gray-100 w-64 space-y-2 py-7 px-2 top-0 left-0 h-screen transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out z-50 flex flex-col">
        
        <a href="#" class="text-xl font-bold mb-8 px-4 text-indigo-400">Smart Wallet</a>

        <div class="flex-grow space-y-2">

            <a href="index.php" class="flex items-center p-2 rounded hover:bg-gray-800 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l-9 9m-9-9l9 9" />
                </svg>
                Dashboard
            </a>

            <a href="manager.php" class="flex items-center p-2 hover:bg-indigo-700 text-white font-semibold transition duration-150 ease-in-out mt-4 shadow-lg">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Quick Entry
            </a>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-800">
            <a href="logout.php" class="flex items-center p-2 rounded hover:bg-red-900/50 text-red-300 hover:text-red-100 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </a>
        </div>
    </nav>

    <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black opacity-50 z-40 md:hidden"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>