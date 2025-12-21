{{--
    Sidebar Menu Item Component
    
    Renders a single menu item in the asesor sidebar.
    Supports dynamic visibility based on scheme configuration.
    
    @param array $item - Menu item configuration with route, label, icon
    @param string $assessmentType - The assessment type identifier
    
    Requirements: 6.1, 6.2, 6.3
--}}

@php
    $routeName = $item['route'] ?? '';
    $label = $item['label'] ?? '';
    $isMandatory = $item['is_mandatory'] ?? false;
    $isActive = $routeName && request()->routeIs($routeName);
@endphp

<li>
    <a href="{{ $routeName ? route($routeName) : '#' }}" 
       class="flex items-center p-2 rounded-lg group {{ $isActive ? 'bg-gradient-to-r from-biru to-ungu text-white hover:text-transparent hover:bg-clip-text' : 'text-sidebar_font hover:bg-btn_hover' }}"
       @if($isMandatory) title="Item wajib - selalu ditampilkan" @endif>
        
        {{-- Document Edit Icon (default for most assessment forms) --}}
        @if(in_array($item['icon'] ?? '', ['document-edit', '']))
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 {{ $isActive ? 'text-white group-hover:text-biru' : 'text-sidebar_font' }}"
            viewBox="0 0 15 15"
            fill="none">
            <path d="M10.7907 7.5L11.5257 6.765C11.7823 6.50833 12.109 6.36833 12.4648 6.33333V5.75L8.96484 2.25H3.13151C2.48401 2.25 1.96484 2.76917 1.96484 3.41667V11.5833C1.96484 11.8928 2.08776 12.1895 2.30655 12.4083C2.52534 12.6271 2.82209 12.75 3.13151 12.75H6.63151V11.6592L6.70734 11.5833H3.13151V3.41667H7.21484V7.5H10.7907ZM8.38151 3.125L11.5898 6.33333H8.38151V3.125ZM11.374 8.5675L12.564 9.7575L8.98818 13.3333H7.79818V12.1433L11.374 8.5675ZM13.544 8.7775L12.9723 9.34917L11.7823 8.15917L12.354 7.5875C12.4648 7.47083 12.6573 7.47083 12.774 7.5875L13.544 8.3575C13.6607 8.47417 13.6607 8.66667 13.544 8.7775Z"
                fill="currentColor"/>
        </svg>
        @endif
        
        {{-- Consultation Icon --}}
        @if(($item['icon'] ?? '') === 'consultation')
        <svg class="w-5 h-5 {{ $isActive ? 'text-white group-hover:text-biru' : 'text-sidebar_font' }}"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.9" d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z"/>
        </svg>
        @endif
        
        {{-- Impartiality Icon --}}
        @if(($item['icon'] ?? '') === 'impartiality')
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-6 h-6 {{ $isActive ? 'text-white group-hover:text-biru' : 'text-sidebar_font' }}"
            viewBox="0 0 15 15" fill="none">
            <path d="M11.5898 8.37492H8.96484V7.0178C8.9771 6.42005 9.15243 5.83702 9.47191 5.33167C9.79338 4.79167 9.90956 4.15394 9.79916 3.53527C9.68877 2.91659 9.35918 2.3584 8.87078 1.96292C8.51821 1.6755 8.09697 1.48468 7.64839 1.40919C7.19982 1.3337 6.73932 1.37613 6.3121 1.53232C5.88487 1.68851 5.50559 1.95309 5.21148 2.3001C4.91737 2.64711 4.71852 3.06462 4.63447 3.51167C4.51348 4.1399 4.6301 4.79068 4.96172 5.3378C5.27571 5.82638 5.44972 6.39171 5.46484 6.9723V8.37492H2.83984C2.60778 8.37492 2.38522 8.46711 2.22113 8.6312C2.05703 8.7953 1.96484 9.01786 1.96484 9.24992V10.9999C1.96519 11.2319 2.05749 11.4542 2.22151 11.6183C2.38553 11.7823 2.60789 11.8746 2.83984 11.8749V12.7499C2.84019 12.9819 2.93249 13.2042 3.09651 13.3683C3.26053 13.5323 3.48289 13.6246 3.71484 13.6249H10.7148C10.9468 13.6246 11.1692 13.5323 11.3332 13.3683C11.4972 13.2042 11.5895 12.9819 11.5898 12.7499V11.8749C11.8218 11.8746 12.0442 11.7823 12.2082 11.6183C12.3722 11.4542 12.4645 11.2319 12.4648 10.9999V9.24992C12.4648 9.01786 12.3727 8.7953 12.2086 8.6312C12.0445 8.46711 11.8219 8.37492 11.5898 8.37492ZM5.49547 3.66917C5.54233 3.41783 5.64369 3.17981 5.79242 2.97185C5.94116 2.76389 6.13366 2.59105 6.35637 2.46548C6.57909 2.33992 6.82661 2.26468 7.08153 2.24506C7.33645 2.22544 7.59257 2.26191 7.83188 2.35192C8.07118 2.44192 8.28786 2.58327 8.46667 2.76601C8.64548 2.94876 8.78207 3.16847 8.86684 3.40968C8.95161 3.65089 8.9825 3.90774 8.95733 4.16217C8.93216 4.41661 8.85154 4.66243 8.72116 4.88236C8.39635 5.41265 8.19078 6.00725 8.11872 6.62492H6.31359C6.24475 6.00781 6.03909 5.41384 5.71159 4.8863C5.49155 4.52126 5.41456 4.08765 5.49547 3.66917ZM8.08984 7.49992V8.37492H6.33984V7.49992H8.08984ZM10.7148 12.7499H3.71484V11.8749H10.7148V12.7499ZM2.83984 10.9999V9.24992H11.5898V10.9999H2.83984Z"
                fill="currentColor" stroke="currentColor" stroke-width="0.2"/>
        </svg>
        @endif
        
        {{-- Task Icon --}}
        @if(($item['icon'] ?? '') === 'task')
        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-5 h-5 {{ $isActive ? 'text-white group-hover:text-biru' : 'text-sidebar_font' }}"
            viewBox="0 0 15 15"
            fill="none">
            <path d="M2.5 3.5h10v8h-10v-8zm1 1v6h8v-6h-8zm2 1.5h4v.5h-4v-.5zm0 1.5h4v.5h-4v-.5zm0 1.5h2v.5h-2v-.5z"
                fill="currentColor"/>
        </svg>
        @endif
        
        {{-- Result Icon --}}
        @if(($item['icon'] ?? '') === 'result')
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $isActive ? 'text-white group-hover:text-biru' : 'text-sidebar_font' }}"
            viewBox="0 0 15 15" fill="none" aria-hidden="true">
            <path d="M1.96484 12.75L4.88151 9.83336M7.94926 11.5081C5.76526 11.0123 3.70259 8.94961 3.20676 6.76561C3.12801 6.42028 3.08893 6.24761 3.20268 5.96703C3.31584 5.68703 3.45526 5.59953 3.73293 5.42628C4.36059 5.03428 5.04076 4.90945 5.74601 4.97128C6.73593 5.05936 7.23118 5.10311 7.47851 4.9742C7.72526 4.84586 7.89268 4.54486 8.22868 3.94345L8.65334 3.18103C8.93334 2.67936 9.07334 2.42795 9.40293 2.30953C9.73251 2.19111 9.93084 2.26286 10.3275 2.40636C10.7834 2.57005 11.1974 2.83255 11.5398 3.17503C11.8823 3.51752 12.1448 3.93151 12.3085 4.38736C12.452 4.78403 12.5238 4.98236 12.4053 5.31194C12.2869 5.64094 12.0361 5.78095 11.5338 6.06153L10.7539 6.49611C10.1531 6.83095 9.85326 6.99894 9.72434 7.24803C9.59601 7.49769 9.64268 7.98186 9.73601 8.95019C9.80484 9.66186 9.68643 10.3467 9.28918 10.9825C9.11534 11.2602 9.02843 11.399 8.74784 11.5128C8.46784 11.6259 8.29518 11.5869 7.94926 11.5081Z"
                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"/>
        </svg>
        @endif
        
        <span class="ms-3">{{ $label }}</span>
        
        {{-- Mandatory indicator --}}
        @if($isMandatory)
        <span class="ms-auto text-xs text-green-500" title="Wajib">●</span>
        @endif
    </a>
</li>
