@extends('home.home-admin.layouts.layout')

@section('title', 'Event Management - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100">
  <div class="container mx-auto p-4">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-md shadow-md">
        <h1 class="text-2xl font-bold text-center mb-6">FR.APL.01 Permohonan Sertifikasi Kompetensi</h1>

        <!-- Bagian 1: Rincian Data Pemohon Sertifikasi -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bagian 1: Rincian Data Pemohon Sertifikasi</h2>

            <!-- Data Pribadi -->
            <h3 class="text-lg font-semibold mb-2">a. Data Pribadi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nama Lengkap</label>
                    <input type="text" value="{{ $asesiPengajuan->nama_user }}" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">No. KTP/NIK/Paspor</label>
                    <input type="text" value="{{ $asesiPengajuan->nik }}" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Tempat / Tgl. Lahir</label>
                    <input type="text" value="{{ $asesiPengajuan->tempat_tanggal_lahir }}" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Jenis Kelamin</label>
                    <input type="text" value="{{ $asesiPengajuan->jenis_kelamin }}" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Kebangsaan</label>
                    <input type="text" value="{{ $asesiPengajuan->kebangsaan }}" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Alamat Rumah</label>
                    <input type="text" value="{{ $asesiPengajuan->alamat_rumah }}" class="w-full p-2 border rounded-md" />
                </div>
                {{-- <div>
                    <label class="block text-gray-700">Kode Pos</label>
                    <input type="text" value="{{  }}" class="w-full p-2 border rounded-md" />
                </div> --}}
                <div>
                    <label class="block text-gray-700">No. Telepon / E-mail</label>
                    <input type="text" value="{{ $asesiPengajuan->no_telp }}" class="w-full p-2 border rounded-md" />
                </div>
                {{-- <div>
                    <label class="block text-gray-700">Kualifikasi Pendidikan</label>
                    <input type="text" value="S1 Teknik Informatika" class="w-full p-2 border rounded-md" />
                </div> --}}
            </div>

            <!-- Data Pekerjaan Sekarang -->
            <h3 class="text-lg font-semibold mt-6 mb-2">b. Data Pekerjaan Sekarang</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Nama Institusi / Perusahaan</label>
                    <input type="text" value="PT Teknologi Indonesia" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Jabatan</label>
                    <input type="text" value="Software Developer" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Alamat Kantor</label>
                    <input type="text" value="Jl. Sudirman No. 10, Jakarta" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">Kode Pos</label>
                    <input type="text" value="10220" class="w-full p-2 border rounded-md" />
                </div>
                <div>
                    <label class="block text-gray-700">No. Telp/Fax/E-mail</label>
                    <input type="text" value="02112345678 / info@teknologi.com" class="w-full p-2 border rounded-md" />
                </div>
            </div>
        </div>

        <!-- Bagian 2: Data Sertifikasi -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bagian 2: Data Sertifikasi</h2>
            <div class="mb-4">
                <label class="block text-gray-700">Skema Sertifikasi</label>
                <input type="text" value="{{ $asesiPengajuan->nama_skema }}" class="w-full p-2 border rounded-md" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Nomor</label>
                <input type="text" value="{{ $asesiPengajuan->nomor_skema }}" class="w-full p-2 border rounded-md" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Tujuan Asesmen</label>
                <input type="text" value="{{ $asesiPengajuan->tujuan_asesmen }}" class="w-full p-2 border rounded-md" />
            </div>
            {{-- <div class="mb-4">
                <label class="block text-gray-700">Daftar Unit Kompetensi</label>
                <textarea class="w-full p-2 border rounded-md" rows="4">1. JP001 - Menerapkan Dasar Pemrograman
2. JP002 - Mengembangkan Aplikasi Sederhana
3. JP003 - Menguji Aplikasi</textarea>
            </div> --}}
        </div>

        <!-- Bagian 3: Bukti Kelengkapan Pemohon -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bagian 3.1: Bukti Kelengkapan Pemohon</h2>
            <table class="w-full mb-4 bg-gray-100 rounded-md">
                <thead>
                    <tr>
                        <th class="p-2 border">No.</th>
                        <th class="p-2 border">Bukti Persyaratan Dasar</th>
                        <th class="p-2 border">Ada</th>
                        <th class="p-2 border">Tidak Ada</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border text-center">1</td>
                        <td class="p-2 border">Ijazah SMK/SMA sederajat</td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center">2</td>
                        <td class="p-2 border">Rapor semester 1 - 5</td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center">3</td>
                        <td class="p-2 border">Surat Pengalaman Kerja</td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center">3</td>
                        <td class="p-2 border">Surat Keterangan PKL/Magang</td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Bagian 3.2: Bukti Administratif</h2>
            <table class="w-full mb-4 bg-gray-100 rounded-md">
                <thead>
                    <tr>
                        <th class="p-2 border">No.</th>
                        <th class="p-2 border">Bukti Administratif</th>
                        <th class="p-2 border">Ada</th>
                        <th class="p-2 border">Tidak Ada</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border text-center">1</td>
                        <td class="p-2 border">KTP</td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                    </tr>
                    <tr>
                        <td class="p-2 border text-center">2</td>
                        <td class="p-2 border">Foto 3x4</td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                        <td class="p-2 border text-center"><input type="checkbox" /></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-between mt-8">
            <!-- Pemohon -->
            <div>
                <h3 class="text-sm font-bold">Pemohon **)</h3>
                <p class="mt-2">{{ $asesiPengajuan->nama_user }}</p>
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" id="approve-pemohon" class="h-4 w-4 text-blue-600 border-gray-300 rounded" checked disabled>
                    <label for="approve-pemohon" class="text-sm">Dengan ini saya menyetujui permohonan</label>
                </div>
                <p class="mt-2">TTD: <img src="{{ asset('images/signature.jpg') }}" alt="Signature" class="h-6 inline"></p>
                <p>Tgl: 20-10-2024</p>
            </div>

            <!-- Admin LSP -->
            <div>
                <h3 class="text-sm font-bold">Admin LSP ***)</h3>
                <p class="mt-2">Nama: Muhammad Abdul Karim</p>
                <div class="flex items-center space-x-2 mt-2">
                    <input type="checkbox" id="approve-admin" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="approve-admin" class="text-sm">TTD Admin</label>
                </div>
                <p class="mt-2">TTD: <img src="{{ asset('images/admin-signature.jpg') }}" alt="Admin Signature" class="h-6 inline"></p>
                <p>Tgl: 20-10-2024</p>
            </div>
        </div>
        <div class="flex justify-end mt-6">
                <button class="bg-green-500 text-white px-4 py-2 rounded-md">Submit</button>
        </div>
    </div>
  </div>
</div>
@endsection
