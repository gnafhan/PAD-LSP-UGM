<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Peserta Massal</h3>
    <form action="{{ route('admin.events.participants.bulk', $event->id_event) }}" method="POST" id="bulkParticipantForm">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="bulk_skema" class="block text-sm font-medium text-gray-700 mb-1">Skema Sertifikasi</label>
                <select name="id_skema" id="bulk_skema" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Pilih Skema</option>
                    @foreach($skemas as $skema)
                        <option value="{{ $skema->id_skema }}">{{ $skema->nama_skema }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="bulk_email_input" class="block text-sm font-medium text-gray-700 mb-1">
                    Email Peserta
                    <span class="text-xs text-gray-500">(Pisahkan dengan koma atau spasi)</span>
                </label>
                <input 
                    type="text" 
                    id="bulk_email_input" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="email1@ugm.ac.id, email2@ugm.ac.id"
                    autocomplete="off"
                >
                <p class="mt-1 text-xs text-gray-500">Ketik email dan tekan koma, spasi, atau Enter untuk menambahkan</p>
            </div>
            
            <!-- Email Badges Container -->
            <div id="email_badges_container" class="min-h-[60px] p-3 border border-gray-300 rounded-md bg-gray-50">
                <div id="email_badges" class="flex flex-wrap gap-2">
                    <span class="text-sm text-gray-400 italic" id="empty_message">Belum ada email yang ditambahkan</span>
                </div>
            </div>
            
            <!-- Hidden input to store emails -->
            <input type="hidden" name="emails" id="bulk_emails_hidden" required>
            
            <div class="flex items-center justify-between pt-2">
                <span class="text-sm text-gray-600">
                    Total: <span id="email_count" class="font-semibold text-blue-600">0</span> email
                </span>
                <div class="flex space-x-2">
                    <button 
                        type="button" 
                        onclick="clearAllEmails()" 
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none"
                    >
                        <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Semua
                    </button>
                    <button 
                        type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none"
                    >
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Semua Peserta
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Store emails in a Set to prevent duplicates
    let emailSet = new Set();
    
    // Get DOM elements
    const emailInput = document.getElementById('bulk_email_input');
    const emailBadgesContainer = document.getElementById('email_badges');
    const emailCountSpan = document.getElementById('email_count');
    const hiddenEmailsInput = document.getElementById('bulk_emails_hidden');
    const emptyMessage = document.getElementById('empty_message');
    const bulkForm = document.getElementById('bulkParticipantForm');
    
    // Email validation regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Add email to the set and update UI
    function addEmail(email) {
        email = email.trim().toLowerCase();
        
        // Validate email format
        if (!email) return;
        
        if (!emailRegex.test(email)) {
            showToast('Format email tidak valid: ' + email, 'error');
            return;
        }
        
        // Check for duplicates
        if (emailSet.has(email)) {
            showToast('Email sudah ditambahkan: ' + email, 'warning');
            return;
        }
        
        // Add to set
        emailSet.add(email);
        
        // Create badge
        createEmailBadge(email);
        
        // Update count and hidden input
        updateEmailData();
        
        // Clear input
        emailInput.value = '';
    }
    
    // Create email badge element
    function createEmailBadge(email) {
        // Hide empty message
        if (emptyMessage) {
            emptyMessage.style.display = 'none';
        }
        
        const badge = document.createElement('div');
        badge.className = 'email-badge animate-fade-in';
        badge.innerHTML = `
            <span>${email}</span>
            <button type="button" onclick="removeEmail('${email}')" class="focus:outline-none">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        
        emailBadgesContainer.appendChild(badge);
    }
    
    // Remove email from set and update UI
    function removeEmail(email) {
        emailSet.delete(email);
        updateEmailData();
        renderBadges();
    }
    
    // Clear all emails
    function clearAllEmails() {
        if (emailSet.size === 0) return;
        
        if (confirm('Hapus semua email yang telah ditambahkan?')) {
            emailSet.clear();
            updateEmailData();
            renderBadges();
        }
    }
    
    // Re-render all badges
    function renderBadges() {
        emailBadgesContainer.innerHTML = '';
        
        if (emailSet.size === 0) {
            emailBadgesContainer.innerHTML = '<span class="text-sm text-gray-400 italic" id="empty_message">Belum ada email yang ditambahkan</span>';
        } else {
            emailSet.forEach(email => {
                createEmailBadge(email);
            });
        }
    }
    
    // Update email count and hidden input
    function updateEmailData() {
        emailCountSpan.textContent = emailSet.size;
        hiddenEmailsInput.value = Array.from(emailSet).join(',');
    }
    
    // Show toast notification
    function showToast(message, type = 'info') {
        // Simple alert for now - can be replaced with a proper toast library
        const colors = {
            'error': 'red',
            'warning': 'yellow',
            'info': 'blue',
            'success': 'green'
        };
        
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 bg-${colors[type]}-100 border-l-4 border-${colors[type]}-500 text-${colors[type]}-700 p-4 rounded shadow-lg z-50 animate-fade-in`;
        toast.innerHTML = `
            <div class="flex items-center">
                <span class="text-sm">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-${colors[type]}-500 hover:text-${colors[type]}-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
    
    // Handle input events
    emailInput.addEventListener('keydown', function(e) {
        const value = this.value.trim();
        
        // Handle Enter, comma, or space
        if (e.key === 'Enter' || e.key === ',' || e.key === ' ') {
            e.preventDefault();
            if (value) {
                addEmail(value);
            }
        }
    });
    
    // Handle paste event
    emailInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        
        // Split by common delimiters
        const emails = pastedText.split(/[\s,;]+/);
        
        emails.forEach(email => {
            if (email.trim()) {
                addEmail(email);
            }
        });
    });
    
    // Handle blur event (when user clicks away)
    emailInput.addEventListener('blur', function() {
        const value = this.value.trim();
        if (value) {
            addEmail(value);
        }
    });
    
    // Form validation before submit
    bulkForm.addEventListener('submit', function(e) {
        if (emailSet.size === 0) {
            e.preventDefault();
            showToast('Tambahkan minimal satu email', 'error');
            return false;
        }
        
        const skemaSelect = document.getElementById('bulk_skema');
        if (!skemaSelect.value) {
            e.preventDefault();
            showToast('Pilih skema sertifikasi', 'error');
            return false;
        }
        
        return true;
    });
</script>
