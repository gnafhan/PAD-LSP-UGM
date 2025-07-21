<!DOCTYPE html>
<html>
<head>
    <title>Debug Quill Image Upload</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .debug-panel { 
            background: #f8f9fa; 
            border: 1px solid #dee2e6; 
            border-radius: 8px; 
            padding: 20px; 
            margin-bottom: 20px; 
        }
        .debug-output { 
            height: 200px; 
            overflow-y: auto; 
            background: white; 
            border: 1px solid #ccc; 
            padding: 10px; 
            font-family: monospace; 
            font-size: 12px; 
        }
        .quill-container { 
            background: white; 
            border: 1px solid #dee2e6; 
            border-radius: 8px; 
            padding: 20px; 
        }
        #editor { height: 300px; }
        .status { 
            padding: 10px; 
            margin: 10px 0; 
            border-radius: 4px; 
        }
        .status.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .status.info { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .test-section { margin: 20px 0; }
        .btn { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 8px 16px; 
            border-radius: 4px; 
            cursor: pointer; 
            margin: 5px; 
        }
        .btn:hover { background: #0056b3; }
        .btn.success { background: #28a745; }
        .btn.success:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Debug Quill.js Image Upload</h1>
        
        <!-- System Check -->
        <div class="debug-panel">
            <h3>🔧 System Check</h3>
            <div id="system-check">
                <div class="status info">Checking system...</div>
            </div>
            <button class="btn" onclick="runSystemCheck()">🔄 Run System Check</button>
        </div>
        
        <!-- Debug Output -->
        <div class="debug-panel">
            <h3>📋 Debug Log</h3>
            <div class="debug-output" id="debug-output"></div>
            <button class="btn" onclick="clearLog()">🗑️ Clear Log</button>
            <button class="btn" onclick="testUpload()">🧪 Test Upload Endpoint</button>
        </div>
        
        <!-- Quill Editor -->
        <div class="quill-container">
            <h3>📝 Quill.js Editor</h3>
            <div id="editor"></div>
        </div>
        
        <!-- Manual Test -->
        <div class="test-section">
            <h3>🎯 Manual Test</h3>
            <input type="file" id="manual-file" accept="image/*">
            <button class="btn" onclick="manualUpload()">📤 Manual Upload Test</button>
        </div>
    </div>

    <script>
        let quill;
        let debugCount = 0;
        
        // Debug logging function
        function debugLog(message, type = 'info') {
            debugCount++;
            const output = document.getElementById('debug-output');
            const timestamp = new Date().toLocaleTimeString();
            const color = type === 'error' ? 'red' : type === 'success' ? 'green' : type === 'warn' ? 'orange' : 'blue';
            
            output.innerHTML += `<div style="color: ${color}; margin: 2px 0;">
                [${debugCount.toString().padStart(3, '0')}] ${timestamp}: ${message}
            </div>`;
            output.scrollTop = output.scrollHeight;
            
            console.log(`[${debugCount}] ${message}`);
        }
        
        function clearLog() {
            document.getElementById('debug-output').innerHTML = '';
            debugCount = 0;
        }
        
        // System check function
        async function runSystemCheck() {
            const checkDiv = document.getElementById('system-check');
            checkDiv.innerHTML = '';
            
            const checks = [
                { name: 'Quill.js Library', test: () => typeof Quill !== 'undefined' },
                { name: 'CSRF Token', test: () => !!document.querySelector('meta[name="csrf-token"]') },
                { name: 'Upload Endpoint', test: async () => {
                    try {
                        const response = await fetch('/upload-temp-image', { method: 'HEAD' });
                        return response.status !== 404;
                    } catch { return false; }
                }},
                { name: 'Storage Access', test: async () => {
                    try {
                        const response = await fetch('/storage/temp/.gitignore');
                        return response.status !== 404;
                    } catch { return false; }
                }}
            ];
            
            for (const check of checks) {
                const result = await check.test();
                const status = result ? 'success' : 'error';
                const icon = result ? '✅' : '❌';
                checkDiv.innerHTML += `<div class="status ${status}">${icon} ${check.name}: ${result ? 'OK' : 'FAILED'}</div>`;
            }
        }
        
        // Upload function with detailed debugging
        async function uploadToTemporary(file, isManual = false) {
            debugLog(`📤 Starting upload: ${file.name} (${file.size} bytes)`);
            
            if (!file) {
                throw new Error('No file provided');
            }
            
            // Validate file
            const maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                throw new Error(`File too large: ${(file.size / 1024 / 1024).toFixed(2)}MB > 5MB`);
            }
            
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                throw new Error(`Invalid file type: ${file.type}`);
            }
            
            debugLog(`✅ File validation passed`, 'success');
            
            const formData = new FormData();
            formData.append('image', file);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                throw new Error('CSRF token not found');
            }
            
            debugLog(`🔑 CSRF token: ${csrfToken.substring(0, 10)}...`);
            
            try {
                debugLog(`📡 Sending request to /upload-temp-image...`);
                
                const response = await fetch('/upload-temp-image', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                debugLog(`📡 Response status: ${response.status} ${response.statusText}`);

                if (!response.ok) {
                    const errorText = await response.text();
                    debugLog(`❌ Server error response: ${errorText}`, 'error');
                    throw new Error(`HTTP ${response.status}: ${errorText}`);
                }

                const data = await response.json();
                debugLog(`📦 Server response: ${JSON.stringify(data, null, 2)}`);
                
                if (data.success && data.temp_url) {
                    debugLog(`✅ Upload successful: ${data.temp_url}`, 'success');
                    
                    // Test if image URL is accessible
                    debugLog(`🔍 Testing image accessibility...`);
                    const imgTest = new Image();
                    
                    return new Promise((resolve, reject) => {
                        imgTest.onload = () => {
                            debugLog(`✅ Image accessible and loaded successfully`, 'success');
                            resolve(data.temp_url);
                        };
                        
                        imgTest.onerror = () => {
                            debugLog(`❌ Image URL not accessible: ${data.temp_url}`, 'error');
                            reject(new Error('Uploaded image is not accessible'));
                        };
                        
                        imgTest.src = data.temp_url;
                        
                        // Timeout after 10 seconds
                        setTimeout(() => {
                            debugLog(`⏰ Image load timeout`, 'warn');
                            reject(new Error('Image load timeout'));
                        }, 10000);
                    });
                } else {
                    throw new Error(data.message || 'Upload failed - no URL returned');
                }
            } catch (error) {
                debugLog(`🔥 Upload error: ${error.message}`, 'error');
                throw error;
            }
        }
        
        // Improved image handler for Quill
        function imageHandler() {
            debugLog('📷 Quill image button clicked');
            
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.click();

            input.onchange = async () => {
                const file = input.files[0];
                if (!file) {
                    debugLog('❌ No file selected', 'warn');
                    return;
                }
                
                debugLog(`📁 File selected: ${file.name}`);
                
                try {
                    // Get current selection
                    let range = quill.getSelection();
                    if (!range) {
                        debugLog('🎯 No selection, setting cursor to end');
                        quill.setSelection(quill.getLength(), 0);
                        range = quill.getSelection();
                    }
                    
                    debugLog(`📍 Cursor position: ${range.index}`);
                    
                    // Show loading indicator
                    const loadingText = '⏳ Uploading image...';
                    quill.insertText(range.index, loadingText, 'user');
                    debugLog(`📝 Loading text inserted`);
                    
                    // Upload file
                    const tempUrl = await uploadToTemporary(file);
                    
                    // Remove loading text
                    debugLog(`🗑️ Removing loading text...`);
                    quill.deleteText(range.index, loadingText.length);
                    
                    // Wait a bit for DOM to stabilize
                    await new Promise(resolve => setTimeout(resolve, 100));
                    
                    // Insert image
                    debugLog(`🖼️ Inserting image at position ${range.index}...`);
                    quill.insertEmbed(range.index, 'image', tempUrl);
                    
                    // Wait for image to be inserted
                    await new Promise(resolve => setTimeout(resolve, 100));
                    
                    // Find and mark the inserted image
                    const images = quill.container.querySelectorAll('img');
                    const insertedImage = Array.from(images).find(img => img.src === tempUrl);
                    
                    if (insertedImage) {
                        insertedImage.setAttribute('data-temp-image', 'true');
                        insertedImage.setAttribute('data-temp-url', tempUrl);
                        debugLog(`✅ Image marked as temporary`, 'success');
                        
                        // Add load handlers
                        insertedImage.onload = () => debugLog(`✅ Image rendered in editor`, 'success');
                        insertedImage.onerror = () => debugLog(`❌ Image failed to render in editor`, 'error');
                    } else {
                        debugLog(`⚠️ Could not find inserted image in DOM`, 'warn');
                    }
                    
                    // Move cursor after image
                    quill.setSelection(range.index + 1, 0);
                    debugLog(`✅ Image insertion completed successfully`, 'success');
                    
                } catch (error) {
                    debugLog(`❌ Image insertion failed: ${error.message}`, 'error');
                    
                    // Try to clean up loading text if it exists
                    try {
                        const currentText = quill.getText();
                        if (currentText.includes('⏳ Uploading image...')) {
                            const loadingIndex = currentText.indexOf('⏳ Uploading image...');
                            quill.deleteText(loadingIndex, '⏳ Uploading image...'.length);
                        }
                    } catch (cleanupError) {
                        debugLog(`⚠️ Cleanup failed: ${cleanupError.message}`, 'warn');
                    }
                    
                    alert(`Failed to upload image: ${error.message}`);
                }
            };
        }
        
        // Manual upload test
        async function manualUpload() {
            const fileInput = document.getElementById('manual-file');
            const file = fileInput.files[0];
            
            if (!file) {
                alert('Please select a file first');
                return;
            }
            
            try {
                const url = await uploadToTemporary(file, true);
                debugLog(`✅ Manual upload test successful: ${url}`, 'success');
                alert(`Upload successful! URL: ${url}`);
            } catch (error) {
                debugLog(`❌ Manual upload test failed: ${error.message}`, 'error');
                alert(`Upload failed: ${error.message}`);
            }
        }
        
        // Test upload endpoint directly
        async function testUpload() {
            debugLog('🧪 Testing upload endpoint availability...');
            
            try {
                const response = await fetch('/upload-temp-image', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                
                debugLog(`📡 Endpoint response: ${response.status} ${response.statusText}`);
                
                const text = await response.text();
                debugLog(`📦 Response body: ${text}`);
                
            } catch (error) {
                debugLog(`❌ Endpoint test failed: ${error.message}`, 'error');
            }
        }
        
        // Initialize everything
        document.addEventListener('DOMContentLoaded', function() {
            debugLog('🚀 Initializing Quill Debug Tool...');
            
            // Run system check automatically
            runSystemCheck();
            
            // Initialize Quill
            try {
                quill = new Quill('#editor', {
                    theme: 'snow',
                    placeholder: 'Type here and use the image button to test upload...',
                    modules: {
                        toolbar: {
                            container: [
                                [{ 'font': [] }],
                                [{ 'size': ['small', false, 'large', 'huge'] }],
                                ['bold', 'italic', 'underline'],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                ['link', 'image'],
                                ['clean']
                            ],
                            handlers: {
                                image: imageHandler
                            }
                        }
                    }
                });
                
                debugLog('✅ Quill.js initialized successfully', 'success');
                
                // Add some test content
                quill.setText('Click the image button above to test image upload!\n\n');
                
            } catch (error) {
                debugLog(`❌ Quill initialization failed: ${error.message}`, 'error');
            }
        });
    </script>
</body>
</html>
