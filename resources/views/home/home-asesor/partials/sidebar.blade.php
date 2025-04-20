<aside id="logo-sidebar" class="fixed top-0 left-0 z-50 w-64 h-screen transition-transform -translate-x-full bg-white shadow-md sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white">
        <a href="/home-asesor" class="flex justify-end px-2 pb-3">
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-12 me-3">
        </a>
        <ul class="font-medium">
            <li class="space-y-2 ">
                <span class="mb-2 text-sidebar_font font-normal text-sm">Home</span>
                <li>
                    <a href="{{ route('home-asesor') }}" class="{{ request()->routeIs('home-asesor') ? 'bg-ungu text-white' : 'text-sidebar_font' }} flex items-center p-2 text-sidebar_font rounded-lg hover:bg-btn_hover hover:text-sidebar_font group">
                        <svg class="w-5 h-5 {{ request()->routeIs('home-asesor') ? 'text-white' : 'text-sidebar_font' }} group-hover:text-sidebar_font hover" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
               </li>
               <li>
                    <a href="{{ route('biodata-asesor') }}" class="{{ request()->routeIs('biodata-asesor') ? 'bg-ungu text-white' : 'text-sidebar_font' }} flex items-center p-2 text-sidebar_font rounded-lg hover:bg-btn_hover hover:text-sidebar_font group">
                        <svg class="w-5 h-5 {{ request()->routeIs('biodata-asesor') ? 'text-white' : 'text-sidebar_font' }} group-hover:text-sidebar_font hover" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                        </svg>
                        <span class="ms-3">Biodata</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kompetensi-asesor') }}" class="{{ request()->routeIs('kompetensi-asesor') ? 'bg-ungu text-white' : 'text-sidebar_font' }} flex items-center p-2 text-sidebar_font rounded-lg hover:bg-btn_hover hover:text-sidebar_font group">
                        <svg class="w-5 h-5 {{ request()->routeIs('kompetensi-asesor') ? 'text-white' : 'text-sidebar_font' }} group-hover:text-sidebar_font hover" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z"/>
                        </svg>
                        <span class="ms-3">Kompetensi</span>
                    </a>
                </li>
            </li>

            {{-- <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                        <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">E-commerce</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <ul id="dropdown-example" class="hidden py-2 space-y-2">
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 ">Products</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Billing</a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Invoice</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                        <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Sign In</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                        <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                        <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Sign Up</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>



{{-- <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-50 w-80 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-white" aria-label="Sidebar">
    <div class="h-full overflow-y-auto bg-white">
        <div class="flex flex-row basis-1/4 sticky top-0 z-50 bg-white">
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="basis-128 w-14 h-15 m-4 justify-start">
            <button data-drawer-toggle="sidebar-multi-level-sidebar" type="button"
                class="p-3 ms-3 text-sm text-black rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-biru">
                <span class="sr-only">Toggle sidebar</span>
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
        </div>

        <ul class="space-y-2 font-medium m-4">
            <ul>
                <span class="mb-4">Home</span>
                <li>
                    <a href="#" class="flex items-center p-2 text-sidebar_font rounded-lg hover:bg-btn_hover group">
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                 </li>
                 <li>
                    <a href="#" class="flex items-center p-2 text-gray-500 rounded-lg hover:text-blue-400 hover:bg-blue-100 group">
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Informasi</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-500 rounded-lg hover:text-blue-400 hover:bg-blue-100 group">
                        <svg class="w-6 h-6 text-gray-500 group-hover:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Kompetensi Teknis</span>
                    </a>
                </li>
            </ul>
            <ul>
                <span class="mb-4">Data</span>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                           <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                        </svg>
                        <span class="flex-1 ms-3 me-1 text-left rtl:text-right whitespace-nowrap">Pelaksanaan Asesmen</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                  </button>
                  <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li>
                           <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Konsultasi Prauji</a>
                        </li>
                        <li>
                           <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Formulir AK.01</a>
                        </li>
                        <li>
                           <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Formulir APL.01</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Formulir APL.02</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Formulir MAPA.01</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Formulir MAPA.02</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Ketidakberpihakan</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center w-full p-2 text-black transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Formulir AK.07</a>
                        </li>
                  </ul>
                    <a href="#" class="flex items-center p-2 text-black rounded-lg hover:bg-gray-100 group">
                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Perangkat Asesmen</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-black rounded-lg hover:bg-gray-100 group">
                        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Keputusan</span>
                    </a>
                </li>
            </ul>
            <ul>
                <span class="mb-4">Auth</span>
                <li>
                    <a href="#" class="flex items-center p-2 text-black rounded-lg hover:bg-red-200">
                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Logout</span>
                    </a>
                </li>
            </ul>
        </ul>
    </div>
</aside> --}}
