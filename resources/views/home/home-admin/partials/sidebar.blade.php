<aside class="hidden md:block bg-white border-r border-gray-100 min-h-screen transition-all duration-300 ease-in-out" x-data="{ collapsed: false }" :class="collapsed ? 'w-16' : 'w-64'">
    <div class="p-3 border-b border-gray-100 flex items-center justify-between">
        <span class="text-sm font-semibold text-gray-700 transition-opacity duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">Navigasi</span>
        <button type="button" @click="collapsed = !collapsed" :aria-expanded="!collapsed"
                class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors duration-200" :title="collapsed ? 'Expand' : 'Collapse'">
            <svg x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 rotate-90" x-transition:enter-end="opacity-100 rotate-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 rotate-0" x-transition:leave-end="opacity-0 -rotate-90" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h8.586l-3.293-3.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 11-1.414-1.414L12.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            <svg x-show="collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -rotate-90" x-transition:enter-end="opacity-100 rotate-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 rotate-0" x-transition:leave-end="opacity-0 rotate-90" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" style="display:none">
                <path fill-rule="evenodd" d="M17 10a1 1 0 01-1 1H7.414l3.293 3.293a1 1 0 11-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L7.414 9H16a1 1 0 011 1z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    <nav class="p-3 space-y-1">
        <a href="/admin/home-admin" class="admin-sidebar-link {{ request()->is('admin/home-admin') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Home">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 0H7m6 0v6m0 0H7m6 0h6" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Home</span>
        </a>
        <a href="{{ route('admin.event.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.event.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Event">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Event</span>
        </a>
        <a href="{{ route('admin.tuk.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.tuk.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="TUK">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4-9 4-9-4zm0 10l9 4 9-4M3 12l9 4 9-4" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">TUK</span>
        </a>





        <a href="{{ route('admin.skema.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.skema.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Skema">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Skema</span>
        </a>



        {{-- SOALLLL --}}
        <a href="{{ route('admin.soal.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.skema.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Skema">
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
        </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Manajemen Soal</span>
        </a>
        {{-- SOALLLLL --}}




        <a href="{{ route('admin.uk.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.uk.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Unit Kompetensi">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Unit Kompetensi</span>
        </a>
        <a href="{{ route('admin.bidang-kompetensi.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.bidang-kompetensi.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Bidang Kompetensi">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5-6l3 3-3 3M3 5h18M3 19h18" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Bidang Kompetensi</span>
        </a>
        <a href="/admin/pengguna" class="admin-sidebar-link {{ request()->is('admin/pengguna') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Pengguna">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 11a4 4 0 10-8 0 4 4 0 008 0zm6 0a4 4 0 10-8 0 4 4 0 008 0z" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Pengguna</span>
        </a>
        <a href="{{ route('admin.asesi.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.asesi.*') ? 'admin-sidebar-link-active' : '' }}" :class="collapsed ? 'justify-center' : ''" title="Assign Asesor">
            <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span class="ml-3 transition-all duration-300" x-show="!collapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-2" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-2">Assign Asesor</span>
        </a>
    </nav>
</aside>

<style>
.admin-sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.625rem 0.75rem;
    border-radius: 0.5rem;
    color: #374151;
    font-size: 0.95rem;
    transition: all 0.3s ease-in-out;
}
.admin-sidebar-link:hover { background-color: #f3f4f6; }
.admin-sidebar-link-active { background-color: #e5f0ff; color: #1d4ed8; font-weight: 600; }
</style>


