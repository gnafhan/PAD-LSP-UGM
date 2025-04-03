@extends('home.home-admin.layouts.layout')

@section('title', 'Daftar Asesi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-8">
  <div class="container mx-auto">

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 shadow-sm border border-green-200">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 shadow-sm border border-red-200">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Instructions Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8 border-l-4 border-blue-500">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Petunjuk Penggunaan</h2>
        
        <div class="text-gray-700 space-y-4">
            <p>Halaman ini terdiri dari dua bagian utama:</p>
            
            <div class="ml-4 border-l-2 border-blue-200 pl-4">
                <h3 class="font-bold text-blue-800 mb-2">1. Daftar Calon Asesi (Tabel Atas)</h3>
                <ul class="list-disc ml-5 space-y-2">
                    <li>Tabel ini menampilkan daftar calon asesi yang telah mengajukan formulir APL-01</li>
                    <li>Admin perlu <span class="font-semibold">memeriksa formulir APL-01</span> dengan mengklik tombol "Detail Pengajuan"</li>
                    <li>Jika formulir sudah sesuai, klik tombol "Setujui" untuk menyetujui pengajuan</li>
                    <li>Setelah disetujui, asesi akan muncul pada tabel bagian bawah untuk di-assign ke asesor</li>
                </ul>
            </div>
            
            <div class="ml-4 border-l-2 border-green-200 pl-4">
                <h3 class="font-bold text-blue-800 mb-2">2. Assign Asesi ke Asesor (Tabel Bawah)</h3>
                <ul class="list-disc ml-5 space-y-2">
                    <li>Tabel ini menampilkan daftar asesi yang telah disetujui formulir APL-01 nya</li>
                    <li>Admin dapat memilih beberapa asesi <span class="font-semibold">sekaligus</span> dengan mencentang kotak di sebelah kiri</li>
                    <li>Pilih asesor yang sesuai dari dropdown yang tersedia</li>
                    <li>Tentukan periode dan tahun asesmen</li>
                    <li>Klik tombol "Assign" untuk menetapkan asesor pada asesi yang dipilih</li>
                </ul>
            </div>
            
            <p class="bg-yellow-50 p-3 rounded-md border border-yellow-200 text-yellow-800">
                <span class="font-bold">Catatan:</span> Gunakan filter skema sertifikasi untuk memudahkan pengelolaan data di kedua tabel.
            </p>
        </div>
    </div>

    <!-- Section 1: Persetujuan Formulir APL-01 -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b pb-3">Daftar Pengajuan Calon Asesi</h2>
        
        <!-- Filter Skema for Table 1 -->
        <div class="mb-6">
            <label for="filter-skema-1" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Skema:</label>
            <select id="filter-skema-1" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Skema</option>
                @foreach($skema as $s)
                    <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Table 1: Calon Asesi -->
        <div class="overflow-x-auto">
            <table id="calon-asesi-table" class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Nama Calon Asesi</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Tanggal Daftar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Skema</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Pengajuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @if($asesiPengajuan->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data pengajuan calon asesi yang tersedia</td>
                        </tr>
                    @else
                        @foreach($asesiPengajuan as $index => $asesi_pengajuan)
                            <tr class="hover:bg-gray-50 data-row" data-skema="{{ $asesi_pengajuan->id_skema }}">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ ($asesiPengajuan->currentPage() - 1) * $asesiPengajuan->perPage() + $index + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $asesi_pengajuan->nama_user }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($asesi_pengajuan->created_at)->format('d M Y, H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $asesi_pengajuan->nama_skema }}</td>
                                <td class="px-4 py-3 text-sm whitespace-nowrap">
                                    <a href="{{ route('admin.asesi.detail', $asesi_pengajuan->id_pengajuan) }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded text-xs sm:text-sm font-medium transition-colors w-full sm:w-auto text-center">
                                        Detail Pengajuan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-center">
            {{ $asesiPengajuan->links() }}
        </div>
    </div>

    <!-- Section 2: Assign Asesi ke Asesor -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 border-b pb-3">Assign Asesi ke Asesor</h2>

        <!-- Filter Skema for Table 2 -->
        <div class="mb-6">
            <label for="filter-skema-2" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Skema:</label>
            <select id="filter-skema-2" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Skema</option>
                @foreach($skema as $s)
                    <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
                @endforeach
            </select>
        </div>

        <form action="{{ route('assign.asesor') }}" method="POST">
            @csrf
            <!-- Table 2: Assign Asesi -->
            <div class="overflow-x-auto">
                <table id="assign-table" class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Nama Asesi</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">NIM</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600 tracking-wider">Skema</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @if($asesi->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-center text-gray-500">Tidak ada data asesi yang tersedia</td>
                            </tr>
                        @else
                            @foreach($asesi as $index => $data)
                                <tr class="hover:bg-gray-50 assign-row" data-skema="{{ $data->id_skema ?? '' }}">
                                    <td class="px-4 py-3 text-sm">
                                        @if($data && $data->id_asesi)
                                            <input type="checkbox" class="asesi-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="assign_asesi[]" value="{{ $data->id_asesi }}">
                                        @else
                                            <input type="checkbox" class="rounded border-gray-300 text-gray-400" disabled>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ ($asesi->currentPage() - 1) * $asesi->perPage() + $index + 1 }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $data->nama_asesi ?? 'Nama Asesi tidak tersedia' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $data->nim ?? 'NIM tidak tersedia' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $data->skema->nama_skema ?? 'Skema tidak tersedia' }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination for second table -->
            <div class="mt-4 flex justify-center">
                {{ $asesi->links() }}
            </div>

            <!-- Selection Controls -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <!-- Bidang Kompetensi Selection (NEW) -->
                <div>
                    <label for="bidang_kompetensi" class="block text-sm font-medium text-gray-700 mb-2">Filter Bidang Kompetensi:</label>
                    <select id="bidang_kompetensi" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Bidang Kompetensi</option>
                        @foreach($bidangKompetensi as $bidang)
                            <option value="{{ $bidang->id_bidang_kompetensi }}">{{ $bidang->nama_bidang }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Asesor Selection (MODIFIED) -->
                <div>
                    <label for="asesor" class="block text-sm font-medium text-gray-700 mb-2">Pilih Asesor:</label>
                    <select id="asesor" name="id_asesor" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Asesor</option>
                        @foreach($asesors as $asesor)
                            <option value="{{ $asesor->id_asesor }}">{{ $asesor->nama_asesor }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Periode Selection -->
                <div>
                    <label for="periode" class="block text-sm font-medium text-gray-700 mb-2">Periode:</label>
                    <select id="periode" name="periode" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Periode</option>
                        <option value="1">Periode 1</option>
                        <option value="2">Periode 2</option>
                        <option value="3">Periode 3</option>
                        <option value="4">Periode 4</option>
                    </select>
                </div>

                <!-- Tahun Selection -->
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun:</label>
                    <select id="tahun" name="tahun" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">Pilih Tahun</option>
                        <!-- JavaScript will populate this -->
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-md font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Assign Asesor
                </button>
            </div>
        </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Dependent dropdown untuk bidang kompetensi dan asesor
    const bidangKompetensiSelect = document.getElementById('bidang_kompetensi');
    const asesorSelect = document.getElementById('asesor');
    
    bidangKompetensiSelect.addEventListener('change', function() {
      const selectedBidangId = this.value;
      
      // Reset dropdown asesor
      asesorSelect.innerHTML = '<option value="">Pilih Asesor</option>';
      
      if (selectedBidangId) {
        // Tampilkan indikator loading
        asesorSelect.innerHTML = '<option value="">Loading...</option>';
        
        // Fetch asesor yang memiliki bidang kompetensi yang dipilih
        fetch(`/admin/get-asesor-by-bidang/${selectedBidangId}`)
          .then(response => response.json())
          .then(data => {
            // Reset opsi
            asesorSelect.innerHTML = '<option value="">Pilih Asesor</option>';
            
            // Tambahkan opsi baru
            if (data.length > 0) {
              data.forEach(asesor => {
                const option = document.createElement('option');
                option.value = asesor.id_asesor;
                option.textContent = asesor.nama_asesor;
                asesorSelect.appendChild(option);
              });
            } else {
              asesorSelect.innerHTML = '<option value="">Tidak ada asesor dengan bidang ini</option>';
            }
          })
          .catch(error => {
            console.error('Error fetching asesor data:', error);
            asesorSelect.innerHTML = '<option value="">Error loading data</option>';
          });
      } else {
        asesorSelect.innerHTML = '<option value="">Loading...</option>';

        // Jika tidak ada bidang yang dipilih, tampilkan semua asesor
        fetch('/admin/get-all-asesor')
          .then(response => response.json())
          .then(data => {
            asesorSelect.innerHTML = '<option value="">Pilih Asesor</option>';
            
            data.forEach(asesor => {
              const option = document.createElement('option');
              option.value = asesor.id_asesor;
              option.textContent = asesor.nama_asesor;
              asesorSelect.appendChild(option);
            });
          })
          .catch(error => {
            console.error('Error fetching all asesors:', error);
          });
      }
    });
    
    // Populate year dropdown with current year and future years
    const yearSelect = document.getElementById('tahun');
    const currentYear = new Date().getFullYear();
    
    for (let year = currentYear; year <= currentYear + 5; year++) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }

    // Select All checkbox functionality
    const selectAllCheckbox = document.getElementById('select-all');
    const asesiCheckboxes = document.querySelectorAll('.asesi-checkbox');

    selectAllCheckbox.addEventListener('change', function() {
        asesiCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // Filter functionality for first table
    const filterSkema1 = document.getElementById('filter-skema-1');
    const dataRows = document.querySelectorAll('#calon-asesi-table .data-row');

    filterSkema1.addEventListener('change', function() {
        const selectedSkema = this.value;
        
        dataRows.forEach(row => {
            if (!selectedSkema || row.getAttribute('data-skema') === selectedSkema) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality for second table
    const filterSkema2 = document.getElementById('filter-skema-2');
    const assignRows = document.querySelectorAll('#assign-table .assign-row');

    filterSkema2.addEventListener('change', function() {
        const selectedSkema = this.value;
        
        assignRows.forEach(row => {
            if (!selectedSkema || row.getAttribute('data-skema') === selectedSkema) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
  });
</script>
@endsection