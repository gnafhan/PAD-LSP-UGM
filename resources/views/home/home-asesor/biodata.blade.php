@extends('home.home-asesor.layouts.layout')

@section('title', 'Biodata - Asesor')

@section('content')
<div id="backFrame" class="pt-[88px] pb-80 px-4 md:px-16 bg-bg_dashboard sm:ml-64">
    <div id="judulPage" class="flex items-center mb-4 ms-4">
        <svg class="w-8 h-8 text-biru_tua" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
        </svg>
        <span class="ms-2 text-xl font-bold text-black">Biodata Asesor</span>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[0%] translate-y-[5%] rounded-full bg-gradient-to-br from-biru to-ungu opacity-20 blur-[80px]">
    </div>
    <div id="frameBiodatasesor" class="relative z-10 p-8 border border-border bg-white rounded-2xl">
        <p class="text-lg font-medium text-black">Biodata Pribadi</p>
        <form>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-4">
                <div class="sm:col-span-2">
                    <label for="full-name" class="block text-sm/6 font-medium text-sidebar_font">Nama Lengkap</label>
                    <div class="mt-2">
                        <input type="text" name="full-name" id="full-name" autocomplete="given-name" placeholder="Isikan Nama Lengkap Anda"  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-black outline-1  outline-border_input placeholder:text-placeholder_input focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="nationality" class="block text-sm/6 font-medium text-sidebar_font">Kebangsaan</label>
                    <div class="mt-2">
                        <select id="nationality" name="nationality" autocomplete="nationality" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option>Indonesian</option>
                            <option>Canadian</option>
                            <option>Mexican</option>
                            <option>Chinese</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nik" class="block text-sm/6 font-medium text-sidebar_font">NIK</label>
                    <div class="mt-2">
                        <input type="number" name="nik" id="nik" autocomplete="nik" placeholder="Isikan NIK Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="alamat" class="block text-sm/6 font-medium text-sidebar_font">Alamat</label>
                    <div class="mt-2">
                    <input type="text" name="alamat" id="alamat" autocomplete="alamat" placeholder="Isikan Alamat Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="nik" class="block text-sm/6 font-medium text-sidebar_font">Tempat Lahir</label>
                    <div class="mt-2">
                        <input type="text" name="tempat_lahir" id="tempat_lahir" autocomplete="tempat_lahir" placeholder="Isikan NIK Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="kota" class="block text-sm/6 font-medium text-sidebar_font">Kabupaten/Kota</label>
                    <div class="mt-2">
                        <select id="kota" name="kota" autocomplete="kota" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option>Yogyakarta</option>
                            <option>Jakarta</option>
                            <option>Solo</option>
                            <option>Bekasi</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="tanggal_lahir" class="block text-sm/6 font-medium text-sidebar_font">Tanggal Lahir</label>
                    <div class="mt-2">
                    <input type="text" name="tanggal_lahir" id="tanggal_lahir" autocomplete="tanggal_lahir" placeholder="Isikan Tanggal Lahir Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="kota" class="block text-sm/6 font-medium text-sidebar_font">Provinsi</label>
                    <div class="mt-2">
                        <select id="provinsi" name="provinsi" autocomplete="provinsi" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option>Daerah Istimewa Yogyakarta</option>
                            <option>DKI Jakarta</option>
                            <option>Jawa Tengah</option>
                            <option>Jawa Timur</option>
                            <option>Jawa Barat</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="kelamin" class="block text-sm/6 font-medium text-sidebar_font">Jenis Kelamin</label>
                    <div class="mt-2">
                        <select id="kelamin" name="kelamin" autocomplete="kelamin" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option>Pria</option>
                            <option>Wanita</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="kode_pos" class="block text-sm/6 font-medium text-sidebar_font">Kode Pos</label>
                    <div class="mt-2">
                        <input type="number" name="kode_pos" id="kode_pos" autocomplete="kode_pos" placeholder="Isikan Kode Pos" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="no_wa" class="block text-sm/6 font-medium text-sidebar_font">No WhatsApp/Telp</label>
                    <div class="mt-2">
                        <input type="number" name="no_wa" id="no_wa" autocomplete="tanggal_lahir" placeholder="Isikan Nomor Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="no_met" class="block text-sm/6 font-medium text-sidebar_font">Nomor MET</label>
                    <div class="mt-2">
                        <input type="number" name="no_met" id="no_met" autocomplete="no_met" placeholder="Isikan Nomor MET Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm/6 font-medium text-sidebar_font">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" placeholder="Isikan Email Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="no_sertif" class="block text-sm/6 font-medium text-sidebar_font">Nomor Sertifikasi</label>
                    <div class="mt-2">
                        <input type="number" name="no_sertif" id="no_sertif" autocomplete="no_sertif" placeholder="Isikan Nomor Sertifikat Anda" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-biru sm:text-sm/6">
                    </div>
                </div>

                {{-- upload gambar --}}
                <div class="mt-6 sm:col-span-2">
                    <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Foto Formal</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                    <div class="text-center">
                        <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                        </svg>
                        <div class="mt-4 flex text-sm/6 text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-biru focus-within:ring-2 focus-within:ring-biru focus-within:ring-offset-2 focus-within:outline-hidden hover:text-biru">
                            <span>Upload a file</span>
                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    </div>
                    </div>
                </div>

                <div class="mt-6 sm:col-span-2">
                    <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Upload Tanda Tangan PNG</label>
                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                    <div class="text-center">
                        <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                        </svg>
                        <div class="mt-4 flex text-sm/6 text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-biru focus-within:ring-2 focus-within:ring-biru focus-within:ring-offset-2 focus-within:outline-hidden hover:text-biru">
                            <span>Upload a file</span>
                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm/6 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mt-6">Simpan</button>
            </div>
        </form>
    </div>
    <div id="bgGradient"
        class="absolute top-0 right-0 z-0 h-[500px] w-[500px] -translate-x-[180%] translate-y-[80%] rounded-full bg-biru opacity-10 blur-[80px]">
    </div>
</div>
@endsection
