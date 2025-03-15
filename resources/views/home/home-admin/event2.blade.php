@extends('home.home-admin.layouts.layout')

@section('title', 'Event Management - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-100 p-4">
    <div class="container mx-auto p-4">
        <div class="mb-8">
            <!-- Tombol Tambah Event -->
             <div class="mb-4">
            <a href="{{ route('admin.event.create') }}" class="bg-green-500 text-white p-2 rounded hover:bg-green-600 mb-5">
                Tambah Event
            </a>
            </div>

            <!-- Form Event -->
            {{-- <div id="eventModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
                <div class="bg-white rounded-md p-6 w-full max-w-lg mx-4">
                    <h2 class="text-xl font-bold mb-4">Tambah Event</h2>
                    <form>
                        <div class="mb-4">
                            <label for="event-name" class="block text-gray-700">Nama Event:</label>
                            <input type="text" id="event-name" class="w-full p-2 border rounded-md" placeholder="EVENT-098-1238">
                        </div>
                        <div class="mb-4">
                            <label for="start-date" class="block text-gray-700">Tanggal Mulai Event:</label>
                            <input type="date" id="start-date" class="w-full p-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="end-date" class="block text-gray-700">Tanggal Berakhir Event:</label>
                            <input type="date" id="end-date" class="w-full p-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="event-type" class="block text-gray-700">Tipe Event:</label>
                            <input type="text" id="event-type" class="w-full p-2 border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="event-scheme" class="block text-gray-700">Nama Skema:</label>
                            <div id="schemes-list">
                                <input type="text" class="w-full p-2 border rounded-md mb-2" placeholder="SKM-XXXX">
                            </div>
                            <button type="button" class="bg-blue-500 text-white p-2 rounded">Tambah Skema</button>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" id="closeModalBtn" class="bg-red-500 text-white p-2 rounded mr-2">Batal</button>
                            <button type="submit" class="bg-green-500 text-white p-2 rounded">Simpan Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <!-- Daftar Event -->
        <h2 class="text-xl font-bold mb-4">Daftar Event</h2>
        <div class="overflow-x-auto mb-8">
            <table class="w-full bg-white rounded-md shadow-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">Tanggal Mulai Event</th>
                        <th class="p-2">Tanggal Berakhir Event</th>
                        <th class="p-2">TUK</th>
                        <th class="p-2">Tipe Event</th>
                        <th class="p-2">Skema</th>
                        <th class="p-2">Asesor</th>
                        <th class="p-2">Aksi</th>
                        <th class="p-2">Edit</th>
                        <th class="p-2">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event as $item)
                        <tr>
                            <td class="p-2 text-center">{{ $item->tanggal_mulai_event }}</td>
                            <td class="p-2 text-center">{{ $item->tanggal_berakhir_event }}</td>
                            <td class="p-2">{{ $item->tuk }}</td>
                            <td class="p-2">{{ $item->tipe_event }}</td>
                            <td class="p-2">
                                @foreach ($item->skemas as $skema)
                                    {{ $skema->nomor_skema }}: {{ $skema->nama_skema }}<br>
                                @endforeach
                            </td>
                            <td class="p-2">
                                <a href="/admin/asesor/" class="bg-yellow-500 hover:bg-yellow-600 text-white p-1 rounded">Asesor</a>
                            </td>
                            <td class="p-2">
                                <a href="/btn-asesi" class="bg-gray-500 hover:bg-gray-600 text-white p-1 rounded">Asesi</a>
                            </td>
                            <td class="p-2">
                                <a href="{{ route('admin.event.edit', $item->id_event) }}" class="bg-blue-500 text-white p-1 rounded">Edit</a>
                            </td>
                            <td class="p-2">
                                <form action="{{ route('admin.event.delete', $item->id_event) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-1 rounded">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Event Aktif -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-2">Event Aktif</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">Tanggal</th>
                            <th class="border px-4 py-2">Nama Event</th>
                            <th class="border px-4 py-2">Nama Skema</th>
                            <th class="border px-4 py-2">Nama Asesi</th>
                            <th class="border px-4 py-2">Nama Asesor</th>
                            <th class="border px-4 py-2">Keterangan</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asesis as $asesi)
                            @foreach ($asesi->skema->events as $event)
                                <tr>
                                    <td>{{ $event->tanggal_mulai_event }} - {{ $event->tanggal_berakhir_event }}</td>
                                    <td>{{ $event->nama_event }}</td>
                                    <td>{{ $asesi->skema->nama_skema }}</td>
                                    <td>{{ $asesi->nama_asesi }}</td>
                                    <td>{{ $asesi->asesor->nama_asesor }}</td>
                                    <td class="border px-4 py-2">Jadwal Anda dengan Asesor belum ditentukan. <br> Nama Asesor : {{ $asesi->asesor->nama_asesor }}. Email : {{ $asesi->asesor->email }}</td>
                                    <td class="border px-4 py-2">
                                        <button onclick="toggleActions('aksi2')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Pilih</button>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-2 text-center">Tidak ada event aktif.</td>
                            </tr>
                        @endforelse
                        <tr id="aksi2" class="hidden">
                            <td colspan="6" class="border px-4 py-2">
                                <a href="/dp" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">FR.APL-01</a>
                                <a href="/home-admin" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition my-2">Kirim Pesan</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Event Tutup -->
        <div>
            <h2 class="text-lg font-semibold mb-2">Event Tutup</h2>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">Tanggal</th>
                            <th class="border px-4 py-2">Jenis Event</th>
                            <th class="border px-4 py-2">Nama Skema</th>
                            <th class="border px-4 py-2">Nama Asesi</th>
                            <th class="border px-4 py-2">Keterangan</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">2024-05-15</td>
                            <td class="border px-4 py-2">Data Scientist</td>
                            <td class="border px-4 py-2">Data Scientist Certification</td>
                            <td class="border px-4 py-2">Dr. Assessor B</td>
                            <td class="border px-4 py-2">Jadwal Anda dengan Asesor pada 13 November 2024 dengan komunikasi melalui email. Nama Asesor : Wandi Prakoso. Email : wandi123@gmail.com</td>
                            <td class="border px-4 py-2">
                                <button onclick="toggleActions('aksi3')" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Pilih</button>
                            </td>
                        </tr>
                        <!-- Baris untuk tombol pilih aksi -->
                        <tr id="aksi3" class="hidden">
                            <td colspan="6" class="border px-4 py-2">
                                <a href="/persetujuan" class="bg-red-400 text-white px-2 py-1 rounded transition my-2">FR.APL-01</a>
                                <a href="/home-admin" class="bg-red-400 text-white px-2 py-1 rounded transition my-2">Kirim Pesan</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleActions(id) {
        document.getElementById(id).classList.toggle("hidden");
    }
</script>
@endsection
