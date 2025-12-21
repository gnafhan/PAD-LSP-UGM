{{-- 
    Scheme Context Selector Component
    
    Displays a dropdown to select the active scheme for the asesor.
    The selected scheme is stored in session and used to filter sidebar menu items.
    
    Requirements: 6.1, 6.4
--}}

@php
    use App\Models\Asesor;
    use App\Models\Skema;
    use Illuminate\Support\Facades\Auth;
    
    $assignedSchemes = collect();
    $selectedSkemaId = null;
    $selectedSkema = null;
    
    try {
        $user = Auth::user();
        $asesor = $user ? Asesor::where('id_user', $user->id_user)->first() : null;
        $assignedSchemes = $asesor ? $asesor->getAssignedSkemas() : collect();
        $selectedSkemaId = session('selected_skema_id');
        $selectedSkema = $selectedSkemaId ? Skema::find($selectedSkemaId) : null;
        
        // If no scheme is selected but asesor has assigned schemes, auto-select the first one
        if (!$selectedSkema && $assignedSchemes->isNotEmpty()) {
            $selectedSkema = $assignedSchemes->first();
            session(['selected_skema_id' => $selectedSkema->id_skema]);
            $selectedSkemaId = $selectedSkema->id_skema;
        }
    } catch (\Exception $e) {
        \Log::error('Scheme selector error: ' . $e->getMessage());
        // Fallback to empty - selector will show "no schemes assigned"
    }
@endphp

@if($assignedSchemes->isNotEmpty())
<div class="px-3 py-3 border-b border-gray-200">
    <label for="scheme-selector" class="block text-xs font-medium text-gray-500 mb-1">Pilih Skema</label>
    <div class="relative">
        <select 
            id="scheme-selector" 
            name="scheme_selector"
            class="block w-full px-3 py-2 text-sm bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-biru focus:border-biru appearance-none cursor-pointer"
            onchange="updateSchemeContext(this.value)"
        >
            @if(!$selectedSkema)
                <option value="" selected disabled>-- Pilih Skema --</option>
            @endif
            @foreach($assignedSchemes as $skema)
                <option 
                    value="{{ $skema->id_skema }}" 
                    {{ $selectedSkemaId === $skema->id_skema ? 'selected' : '' }}
                >
                    {{ $skema->nama_skema }}
                </option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </div>
    @if($selectedSkema)
        <p class="mt-1 text-xs text-gray-400 truncate" title="{{ $selectedSkema->nomor_skema ?? '' }}">
            {{ $selectedSkema->nomor_skema ?? 'No. Skema tidak tersedia' }}
        </p>
    @endif
</div>

<script>
    function updateSchemeContext(schemeId) {
        if (!schemeId) return;
        
        // Show loading state
        const selector = document.getElementById('scheme-selector');
        selector.disabled = true;
        
        fetch('{{ route("asesor.scheme-context.set") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id_skema: schemeId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to update sidebar with new scheme context
                window.location.reload();
            } else {
                alert('Gagal mengubah skema: ' + (data.error || 'Unknown error'));
                selector.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error updating scheme context:', error);
            alert('Terjadi kesalahan saat mengubah skema');
            selector.disabled = false;
        });
    }
</script>
@else
<div class="px-3 py-3 border-b border-gray-200">
    <p class="text-xs text-gray-500 italic">Tidak ada skema yang di-assign</p>
</div>
@endif
