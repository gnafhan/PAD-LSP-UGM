<!-- Navbar Starts -->
<nav class="fixed top-0 z-40 w-full bg-white shadow-sm">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
              <span class="sr-only">Open sidebar</span>
              <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                 <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
              </svg>
           </button>
        </div>
        <div class="flex items-center ms-3">
            <div id="avatarButton" class="flex justify-end items-center gap-4 cursor-pointer">
                <div class="font-medium text-right">
                    <div id="nama_asesor" class="text-blue-500 text-xl">$nama_asesor</div>
                    <div id="email_asesor" class="text-sm font-extralight text-blue-500">$email_asesor</div>
                </div>
                <svg class="w-12 h-12 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const apiKey = "{{ env('API_KEY') }}";

        // Get asesor ID dynamically from the authenticated user
        const asesorId = @json(Auth::user()->asesor->id_asesor ?? null);

        // Stop execution if no asesor ID is found
        if (!asesorId) {
            console.error('No asesor ID found for the authenticated user');
            document.getElementById('nama_asesor').textContent = 'User tidak teridentifikasi';
            document.getElementById('email_asesor').textContent = 'Silahkan login kembali';
            return;
        }

        // PERBAIKAN: Gunakan URL yang benar dengan string concatenation
        const apiUrl = "{{ url('/api/v1/asesor/dashboard') }}/" + asesorId;

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        // Make API request
        fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'API_KEY': apiKey,
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(result => {
            console.log('API Response:', result);

            if (result.success && result.data) {
                const data = result.data;

                // Update profile information
                document.getElementById('nama_asesor').textContent = data.nama_asesor || 'Nama tidak tersedia';
                document.getElementById('email_asesor').textContent = data.email_asesor || 'Email tidak tersedia';
            } else {
                console.error('API returned success=false or missing data:', result);
                document.getElementById('nama_asesor').textContent = 'Tidak dapat memuat data';
                document.getElementById('email_asesor').textContent = result.message || 'Format respons tidak sesuai';
            }
        })
        .catch(error => {
            console.error('Error fetching asesor dashboard data:', error);
            document.getElementById('nama_asesor').textContent = 'Error memuat data';
            document.getElementById('email_asesor').textContent = error.message;
        });
    });
</script>

<!-- Navbar Ends -->
