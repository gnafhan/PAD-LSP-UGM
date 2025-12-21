<aside id="logo-sidebar" class="fixed top-0 left-0 z-50 w-64 h-full bg-white shadow-md" style="transform: translateX(0) !important;" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white">
        <a href="/home-asesor" class="flex justify-end px-2 pb-3">
            <img src="{{ asset('images/logo.png') }}" alt="LSP UGM Logo" class="h-12 me-3">
        </a>
        
        @include('home.home-asesor.partials.scheme-selector')
        
        @php
            use App\Models\Asesor;
            use App\Services\SidebarService;
            use Illuminate\Support\Facades\Auth;
            
            $menuSections = [];
            
            try {
                $user = Auth::user();
                $asesor = $user ? Asesor::where('id_user', $user->id_user)->first() : null;
                $selectedSkemaId = session('selected_skema_id');
                
                $sidebarService = app(SidebarService::class);
                
                $menuSections = $selectedSkemaId 
                    ? $sidebarService->getMenuItemsForScheme($selectedSkemaId)
                    : $sidebarService->getAllMenuItems();
            } catch (\Exception $e) {
                \Log::error('Sidebar error: ' . $e->getMessage());
            }
        @endphp
        
        <ul class="font-medium">
            <li class="py-2">
                <span class="text-sidebar_font font-normal text-sm">Home</span>
                <li>
                    <a href="{{ route('home-asesor') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('home-asesor') ? 'bg-gradient-to-r from-biru to-ungu text-white' : 'text-biru bg-biru_soft hover:bg-btn_hover'}}">
                        <svg class="w-5 h-5 {{ request()->routeIs('home-asesor') ? 'text-white' : 'text-biru' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('biodata-asesor') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('biodata-asesor') ? 'bg-gradient-to-r from-biru to-ungu text-white' : 'text-sidebar_font hover:bg-btn_hover'}}">
                        <svg class="w-6 h-6 {{ request()->routeIs('biodata-asesor') ? 'text-white' : 'text-sidebar_font' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="1.5" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Biodata</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kompetensi-asesor') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('kompetensi-asesor') ? 'bg-gradient-to-r from-biru to-ungu text-white' : 'text-sidebar_font hover:bg-btn_hover'}}">
                        <svg class="w-5 h-5 {{ request()->routeIs('kompetensi-asesor') ? 'text-white' : 'text-sidebar_font' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="ms-3">Kompetensi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('daftar-asesi') }}" class="flex items-center p-2 rounded-lg group {{ request()->routeIs('daftar-asesi') ? 'bg-gradient-to-r from-biru to-ungu text-white' : 'text-sidebar_font hover:bg-btn_hover'}}">
                        <svg class="w-5 h-5 {{ request()->routeIs('daftar-asesi') ? 'text-white' : 'text-sidebar_font' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="1.8" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="ms-3">Daftar Asesi</span>
                    </a>
                </li>
            </li>
            
            @if(isset($menuSections['pelaksanaan_asesmen']))
            <li class="py-2">
                <span class="text-sidebar_font font-normal text-sm">{{ $menuSections['pelaksanaan_asesmen']['title'] }}</span>
                @foreach($menuSections['pelaksanaan_asesmen']['items'] as $assessmentType => $item)
                    @include('home.home-asesor.partials.sidebar-menu-item', ['item' => $item, 'assessmentType' => $assessmentType])
                @endforeach
            </li>
            @endif
            
            @if(isset($menuSections['perangkat_asesmen']))
            <li class="py-2">
                <span class="text-sidebar_font font-normal text-sm">{{ $menuSections['perangkat_asesmen']['title'] }}</span>
                @foreach($menuSections['perangkat_asesmen']['items'] as $assessmentType => $item)
                    @include('home.home-asesor.partials.sidebar-menu-item', ['item' => $item, 'assessmentType' => $assessmentType])
                @endforeach
            </li>
            @endif
            
            @if(isset($menuSections['keputusan_asesmen']))
            <li class="py-2">
                <span class="text-sidebar_font font-normal text-sm">{{ $menuSections['keputusan_asesmen']['title'] }}</span>
                @foreach($menuSections['keputusan_asesmen']['items'] as $assessmentType => $item)
                    @include('home.home-asesor.partials.sidebar-menu-item', ['item' => $item, 'assessmentType' => $assessmentType])
                @endforeach
            </li>
            @endif
            
            <li class="py-2">
                <span class="text-sidebar_font font-normal text-sm">Logout</span>
                <li>
                    <a href="{{ route('login') }}" class="relative overflow-hidden group flex items-center p-2 rounded-lg text-sidebar_font font-medium text-sm hover:text-white">
                        <span class="absolute inset-0 z-0 bg-gradient-to-r from-logout to-ungu opacity-30 group-hover:opacity-100 transition-opacity"></span>
                        <span class="relative z-10 flex items-center space-x-3">
                            <svg class="w-5 h-5 text-current group-hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" fill="none">
                                <path d="M13.5141 7.49995L9.31406 3.99995V6.09995H4.41406V8.89995H9.31406V11L13.5141 7.49995ZM2.31406 2.59995H7.91406V1.19995H2.31406C1.54406 1.19995 0.914062 1.82995 0.914062 2.59995V12.4C0.914062 13.17 1.54406 13.8 2.31406 13.8H7.91406V12.4H2.31406V2.59995Z" fill="currentColor" />
                            </svg>
                            <span>Logout</span>
                        </span>
                    </a>
                </li>
            </li>
        </ul>
    </div>
</aside>
