@extends('home.home-admin.layouts.layout')

@section('title', 'Bidang Kompetensi - Lembaga Sertifikasi Profesi UGM')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow" role="alert">
            <p class="text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow" role="alert">
            <p class="text-sm">{{ session('error') }}</p>
        </div>
        @endif

        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Manajemen Bidang Kompetensi</h2>
                <p class="mt-1 text-sm text-gray-500">Total Bidang: <span class="font-medium">{{ $totalBidang }}</span></p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <form method="GET" action="{{ route('admin.bidang-kompetensi.index') }}" class="flex rounded-md shadow-sm">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama bidang..." class="focus:ring-blue-500 focus:border-blue-500 block w-full rounded-l-md sm:text-sm border-gray-300 px-4 py-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-r-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">Cari</button>
                </form>
                <a href="{{ route('admin.bidang-kompetensi.create') }}" class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">Tambah</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bidang</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($bidangList as $index => $bidang)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ($bidangList->currentPage() - 1) * $bidangList->perPage() + $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-normal text-sm text-gray-900 font-medium">{{ $bidang->nama_bidang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.bidang-kompetensi.edit', $bidang->id_bidang_kompetensi) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-md text-white">Edit</a>
                                    <form action="{{ route('admin.bidang-kompetensi.delete', $bidang->id_bidang_kompetensi) }}" method="POST" onsubmit="return confirm('Hapus bidang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 rounded-md text-white">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-500 italic">Tidak ada data Bidang Kompetensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-white border-t border-gray-200 rounded-b-lg">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                        Menampilkan {{ $bidangList->firstItem() ?? 0 }} hingga {{ $bidangList->lastItem() ?? 0 }} dari {{ $bidangList->total() }} Bidang
                    </div>
                    <div class="pagination-container">
                        {{ $bidangList->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


