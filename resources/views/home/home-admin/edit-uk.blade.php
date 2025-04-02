@extends('home.home-admin.layouts.layout')

@section('title', 'Edit Unit Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Unit Kompetensi</h2>

        <form action="{{ route('admin.uk.update', $uk->id_uk) }}" method="POST" class="bg-white p-6 rounded-md shadow-md">
            @csrf
            @method('PUT')


            <div class="mb-4">
                <label for="kode_uk" class="block text-gray-700">Kode UK</label>
                <input type="text" name="kode_uk" id="kode_uk" value="{{ $uk->kode_uk }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="nama_uk" class="block text-gray-700">Nama UK</label>
                <input type="text" name="nama_uk" id="nama_uk" value="{{ $uk->nama_uk }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Daftar Elemen Unit Kompetensi</label>
                <div id="elemen-container">
                    @if($uk->count_elemen_uk() > 0)
                        @foreach($uk->elemen_uk as $index => $elemen)
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" name="elemen_uk[]" value="{{ $elemen->nama_elemen }}" class="w-full p-2 border rounded-md" placeholder="Masukkan elemen UK">
                            <button type="button" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 hapus-elemen {{ $uk->count_elemen_uk() <= 1 ? 'hidden' : '' }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" name="elemen_uk[]" class="w-full p-2 border rounded-md" placeholder="Masukkan elemen UK">
                            <button type="button" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 hapus-elemen hidden">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    @endif
                </div>
                <button type="button" id="tambah-elemen-btn" class="mt-2 bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">
                    Tambah Elemen
                </button>
            </div>

            <div class="mb-4">
                <label for="id_bidang" class="block font-medium text-gray-700">Bidang Unit Kompetensi</label>
                <select name="id_bidang" class="w-full border-2 border-gray-500 rounded p-2" required>
                    @if ($uk->id_bidang != null)
                        <option value="{{ $uk->id_bidang }}" selected>{{ $uk->bidang->nama_bidang }}</option>
                    @else
                        <option value="" selected disabled>Pilih Bidang Unit Kompetensi</option>
                    @endif
                    @foreach ($daftarBidangUK as $bidangUK)
                        @if (!$uk->id_bidang || $bidangUK->id_bidang != $uk->id_bidang)
                            <option value="{{ $bidangUK->id_bidang }}">{{ $bidangUK->nama_bidang }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="jenis_standar" class="block text-gray-700">No Sertifikat</label>
                <input type="text" name="jenis_standar" id="jenis_standar" value="{{ $uk->jenis_standar }}" class="w-full px-4 py-2 border rounded-md" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Update</button>
            </div>

        </form>
    </div>
</div>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tombol untuk menambah elemen UK
        const tambahElemenBtn = document.getElementById('tambah-elemen-btn');
        const elemenContainer = document.getElementById('elemen-container');
        
        // Tambahkan elemen baru
        tambahElemenBtn.addEventListener('click', function() {
            const newElemen = document.createElement('div');
            newElemen.className = 'flex items-center gap-2 mb-2';
            newElemen.innerHTML = `
                <input type="text" name="elemen_uk[]" class="w-full p-2 border rounded-md" placeholder="Masukkan elemen UK">
                <button type="button" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 hapus-elemen">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;
            elemenContainer.appendChild(newElemen);
            
            // Tampilkan tombol hapus pada semua elemen
            const deleteButtons = elemenContainer.querySelectorAll('.hapus-elemen');
            deleteButtons.forEach(btn => {
                btn.classList.remove('hidden');
            });
        });
        
        // Event delegation untuk tombol hapus
        elemenContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('hapus-elemen') || e.target.closest('.hapus-elemen')) {
                const elemenItem = e.target.closest('.flex');
                
                // Jangan hapus jika hanya ada satu elemen tersisa
                const totalElems = elemenContainer.querySelectorAll('.flex').length;
                if (totalElems > 1) {
                    elemenItem.remove();
                    
                    // Sembunyikan tombol hapus jika hanya tersisa satu elemen
                    if (totalElems - 1 === 1) {
                        const remainingDeleteBtn = elemenContainer.querySelector('.hapus-elemen');
                        if (remainingDeleteBtn) {
                            remainingDeleteBtn.classList.add('hidden');
                        }
                    }
                } else {
                    alert('Minimal harus ada satu elemen UK');
                }
            }
        });
    });
</script>
@endsection
@endsection
