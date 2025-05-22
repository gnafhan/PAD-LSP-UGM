@extends('home.home-asesor.layouts.layout')

@section('title', 'Kompetensi - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="relative z-10 flex items-center mb-4 ms-4">
        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none">
            <defs>
              <linearGradient id="icon-gradient" x1="0" y1="1" x2="0" y2="0">
                <stop offset="0%" stop-color="#3B82F6" /> <!-- biru -->
                <stop offset="100%" stop-color="#8B5CF6" /> <!-- ungu -->
              </linearGradient>
            </defs>
            <path stroke="url(#icon-gradient)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
              d="M14.7141 15h4.268c.4043 0 .732-.3838.732-.8571V3.85714c0-.47338-.3277-.85714-.732-.85714H6.71411c-.55228 0-1 .44772-1 1v4m10.99999 7v-3h3v3h-3Zm-3 6H6.71411c-.55228 0-1-.4477-1-1 0-1.6569 1.34315-3 3-3h2.99999c1.6569 0 3 1.3431 3 3 0 .5523-.4477 1-1 1Zm-1-9.5c0 1.3807-1.1193 2.5-2.5 2.5s-2.49999-1.1193-2.49999-2.5S8.8334 9 10.2141 9s2.5 1.1193 2.5 2.5Z" />
        </svg>
        <span class="ms-2 text-xl font-bold text-black">Kompetensi Teknis Asesor</span>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameKompetensiAsesor" class="relative z-10 p-8 border border-border bg-white rounded-2xl">
        <p class="mb-4 text-lg font-medium text-black">Kompetensi Teknis Asesor</p>
        <div class="grid grid-cols-7 divide-x-2 divide-dashed gap-6 justify-center px-4 mb-4 bg-white border border-border rounded-md">
            <div class="flex col-span-3 items-center p-3 gap-2 rounded-full bg-white">
                <img id="profilePicture" src="{{ asset('images/ronaldo.png') }}" alt="Profile Picture" class="w-40 h-40 rounded-full">
                <div class="flex-col gap-2 pe-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                        </svg>
                        <p class="font-medium text-black">Nama Pengguna</p>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                        </svg>
                        <p class="font-medium text-font_abu">MET 123456</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/>
                        </svg>
                        <p class="font-medium text-font_abu">Jumlah Skema: </p>
                        <span class="font-medium text-font_abu">5</span>
                    </div>
                </div>
            </div>
            <div class="flex col-span-2 items-center justify-center my-6 bg-white">
                <div class="px-2 font-medium text-black justify-items-center items-center">
                    <svg class="w-16 h-16 text-sidebar_font" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-normal text-center">Lihat Sertifikat BNSP Kompeten</p>
                </div>
            </div>
            <div class="flex col-span-2 items-center justify-center my-6 bg-white">
                <div class="px-2 font-medium text-black justify-items-center items-center">
                    <div class="bg-hijau_muda text-font_hijau p-2 rounded-md">
                        <p class="font-bold ">AKTIF</p>
                    </div>

                    <p class="font-normal text-center text-font_desc">Hingga</p>
                    <p class="font-semibold text-md text-center text-font_desc">32 Februari 2025</p>
                </div>
            </div>

        </div>
        <p class="mb-4 text-lg font-medium text-black">Daftar Skema yang Diikuti Asesor</p>
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table id="kompetensi-table" class="min-w-full bg-white overflow-hidden">
                <thead class="bg-bg_dashboard text-center">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(0)">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(1)">Lembaga Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(2)">Sertifikasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(3)">File Sertifikat</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(4)">Masa Berlaku</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600 tracking-wider cursor-pointer select-none" onclick="sortTable(5)">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-black text-center">
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">1</td>
                        <td class="px-4 py-3">Nafa Company</td>
                        <td class="px-4 py-3">Sertifikasi Frontend</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center h-full">
                                <svg class="w-6 h-6 text-biru" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414ZM2 10a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm9-3a1 1 0 1 0-2 0v2H7a1 1 0 0 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2V7Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </td>
                        <td class="px-4 py-3">12345</td>
                        <td class="px-4 py-3">aktif</td>
                    </tr>
                </tbody>



                {{-- <tbody class="divide-y divide-gray-200">
                    @if($skemaStats->isEmpty())
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data skema per periode yang tersedia</td>
                        </tr>
                    @else
                        @foreach($skemaStats as $index => $stat)
                        <tr class="hover:bg-gray-50 skema-row" data-periode="{{ $stat->periode }}" data-tahun="{{ $stat->tahun }}">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->nama_skema }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->periode }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->tahun }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $stat->jumlah_asesi }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody> --}}
            </table>
        </div>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[50%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>

@endsection
