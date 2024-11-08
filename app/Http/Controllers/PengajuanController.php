<?php

namespace App\Http\Controllers;
use App\Models\Skema;
use App\Models\UK;
use App\Models\Users;
use App\Models\AsesiPengajuan;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class PengajuanController extends Controller
{

    public function showDataSertifikasi()
    {
        $skemaList = Skema::all();

        return view('home.home-asesi.APL-01.data-sertifikasi', [
            'skemaList' => $skemaList,
        ]);
    }

    public function getNomorSkema(Request $request)
    {
        Log::info('Received nama_skema: ' . $request->input('nama_skema'));
        $namaSkema = $request->query('nama_skema');
        $skema = Skema::where('nama_skema', $namaSkema)->first();

        if ($skema) {
            return response()->json(['nomor_skema' => $skema->nomor_skema]);
        } else {
            return response()->json(['nomor_skema' => null]);
        }
    }

    public function showDaftarUK(Request $request)
    {
        $namaSkema = $request->query('nama_skema');
        $skema = Skema::where('nama_skema', $namaSkema)->first();

        if ($skema) {
            $daftarIdUk = json_decode($skema->daftar_id_uk, true);
            $ukList = UK::whereIn('id_uk', $daftarIdUk)->get();

            return response()->json(['ukList' => $ukList]);
        } else {
            return response()->json(['ukList' => []]);
        }
    }

    // public function saveDataPribadi(Request $request)
    // {
    //     session(['dataPribadi' => $request->all()]);
    //     return redirect()->route('sertifikasi');
    // }

    public function saveDataPribadi(Request $request)
    {
        $dataPribadi = $request->only([
            'nama_user', 'nik', 'nim', 'kota_domisili',
            'tempat_tanggal_lahir', 'jenis_kelamin',
            'kebangsaan', 'alamat_rumah', 'no_telp',
            'pendidikan_terakhir'
        ]);

        // Simpan data ke session
        session(['dataPribadi' => $dataPribadi]);

        return response()->json(['message' => 'Data pribadi berhasil disimpan.']);
    }


    // public function saveDataSertifikasi(Request $request)
    // {
    //     // dd($request->all());
    //     dd($request->all());
    //     session(['dataSertifikasi' => $request->all()]);
    //     return redirect()->route('bukti');
    // }

    // PengajuanController.php
    public function saveDataSertifikasi(Request $request)
    {
        try {
            // session(['dataSertifikasi' => $request->all()]);
            session()->put('dataSertifikasi', $request->all());
            return response()->json(['message' => 'Data berhasil disimpan'], 200);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }


    public function storePengajuan(Request $request)
    {
        // Log::info('Received request:', $request->all());
        // return response()->json(['message' => 'Data berhasil disimpan'], 200);
        // return redirect()->route('konfirmasi');

        try {
            // $dataPribadi = session('dataPribadi', []);
            // $dataSertifikasi = session('dataSertifikasi', []);

            $dataPribadi = session()->get('dataPribadi');
            $dataSertifikasi = session()->get('dataSertifikasi');

            if (empty($dataPribadi) || empty($dataSertifikasi)) {
                return redirect()->back()->with('errorSession', 'Data session dataPribadi atau dataSertifikasi tidak ditemukan.');
            }

            $data = array_merge($dataPribadi, $dataSertifikasi, $request->all());

            // $dataPribadi = array_merge($dataPribadi, $request->only(['nama_user', 'nik', 'nim', 'kota_domisili', 'tempat_tanggal_lahir', 'jenis_kelamin', 'kebangsaan', 'alamat_rumah', 'no_telp', 'pendidikan_terakhir']));
            // $dataSertifikasi = array_merge($dataSertifikasi, $request->only(['skema_sertifikasi', 'skemaDropdown', 'nomorSkemaInput', 'tujuan_asesmen']));


            $validatedData = $request->validate([
                // 'id_user' => 'required|string|max:20',
                // 'id_skema' => 'required|string|max:20',
                'nama_user' => 'required|string|max:150',
                'nik' => 'required|string|max:20',
                'nim' => 'required|string|max:20',
                'kota_domisili' => 'required|string|max:100',
                'tempat_tanggal_lahir' => 'required|string|max:200',
                'jenis_kelamin' => 'required|string|max:20',
                'kebangsaan' => 'required|string|max:20',
                'alamat_rumah' => 'required|string|max:200',
                'no_telp' => 'required|string|max:20',
                'pendidikan_terakhir' => 'required|string|max:100',
                'skema_sertifikasi' => 'required|string|max:10',
                'nama_skema' => 'required|string|max:100',
                'nomor_skema' => 'required|string|max:100',
                'tujuan_asesmen' => 'required|string|max:100',
                'email' => 'required|email',
                // 'file_persyaratan_dasar_pemohon' => 'required|array',
                // 'file_administratif' => 'required|array',
                'bukti_jenjang_siswa' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_transkrip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_pengalaman_kerja' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_magang' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_foto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $skema = Skema::where('nomor_skema', $data['nomor_skema'])->firstOrFail();
            // $skema = Skema::where($dataSertifikasi['nomor_skema'], $dataSertifikasi['nomorSkemaInput'])->first();
            // if (!$skema) {
            //     return response()->json(['message' => 'Skema tidak ditemukan.'], 404);
            // }


            // $buktiPemohonPaths = [];
            // foreach ($request->file() as $key => $file) {
            //     $buktiPemohonPaths[$key] = $file->store('uploads/bukti_pemohon');
            // }

            // Proses penyimpanan file dengan error handling per file
            $buktiPemohonPaths = [];
            foreach ($request->file() as $key => $file) {
                try {
                    $buktiPemohonPaths[$key] = $file->store('uploads/bukti_pemohon');
                } catch (\Exception $e) {
                    Log::error("Gagal menyimpan file {$key}: " . $e->getMessage());
                    return redirect()->back()->with('error', "Gagal menyimpan file {$key}. Harap periksa dan coba lagi.");
                }
            }

            // $buktiPemohonPaths = [
            //     'bukti_jenjang_siswa' => $request->file('bukti_jenjang_siswa') ? $request->file('bukti_jenjang_siswa')->store('uploads/bukti_pemohon/jenjang_siswa') : null,
            //     'bukti_transkrip' => $request->file('bukti_transkrip') ? $request->file('bukti_transkrip')->store('uploads/bukti_pemohon/transkrip') : null,
            //     'bukti_pengalaman_kerja' => $request->file('bukti_pengalaman_kerja') ? $request->file('bukti_pengalaman_kerja')->store('uploads/bukti_pemohon/pengalaman_kerja') : null,
            //     'bukti_magang' => $request->file('bukti_magang') ? $request->file('bukti_magang')->store('uploads/bukti_pemohon/magang') : null,
            //     'bukti_ktp' => $request->file('bukti_ktp') ? $request->file('bukti_ktp')->store('uploads/bukti_pemohon/ktp') : null,
            //     'bukti_foto' => $request->file('bukti_foto') ? $request->file('bukti_foto')->store('uploads/bukti_pemohon/foto') : null,
            // ];

            AsesiPengajuan::create(array_merge($validatedData, [
                'id_user' => $auth()->user()->id_user,
                'id_skema' => $skema->id_skema,
                'nama_user' => $dataPribadi['nama_user'],
                'nik' => $dataPribadi['nik'],
                'nim' => $dataPribadi['nim'],
                'kota_domisili' => $dataPribadi['kota_domisili'],
                'tempat_tanggal_lahir' => $dataPribadi['tempat_tanggal_lahir'],
                'jenis_kelamin' => $dataPribadi['jenis_kelamin'],
                'kebangsaan' => $dataPribadi['kebangsaan'],
                'alamat_rumah' => $dataPribadi['alamat_rumah'],
                'no_telp' => $dataPribadi['no_telp'],
                'pendidikan_terakhir' => $dataPribadi['pendidikan_terakhir'],
                'skema_sertifikasi' => $dataSertifikasi['skema_sertifikasi'],
                'nama_skema' => $dataSertifikasi['skemaDropdown'],
                'nomor_skema' => $dataSertifikasi['nomorSkemaInput'],
                'tujuan_asesmen' => $dataSertifikasi['tujuan_asesmen'],
                'sumber_anggaran' => null,
                'email' => auth()->user()->email,
                'file_persyaratan_dasar_pemohon' => json_encode($buktiPemohonPaths),
                'file_administratif' => json_encode($buktiPemohonPaths),
                'ttd_pemohon' => 'belum ada',
                'status_rekomendasi' => 'N/A',
            ]));

            // $asesiPengajuan = AsesiPengajuan::create([
            //     'id_user' => $auth()->user()->id_user,
            //     'id_skema' => $skema->id_skema,
            //     'nama_user' => $dataPribadi['nama_user'],
            //     'nik' => $dataPribadi['nik'],
            //     'nim' => $dataPribadi['nim'],
            //     'kota_domisili' => $dataPribadi['kota_domisili'],
            //     'tempat_tanggal_lahir' => $dataPribadi['tempat_tanggal_lahir'],
            //     'jenis_kelamin' => $dataPribadi['jenis_kelamin'],
            //     'kebangsaan' => $dataPribadi['kebangsaan'],
            //     'alamat_rumah' => $dataPribadi['alamat_rumah'],
            //     'no_telp' => $dataPribadi['no_telp'],
            //     'pendidikan_terakhir' => $dataPribadi['pendidikan_terakhir'],
            //     'skema_sertifikasi' => $dataSertifikasi['skema_sertifikasi'],
            //     'nama_skema' => $dataSertifikasi['skemaDropdown'],
            //     'nomor_skema' => $dataSertifikasi['nomorSkemaInput'],
            //     'tujuan_asesmen' => $dataSertifikasi['tujuan_asesmen'],
            //     'sumber_anggaran' => null,
            //     'email' => auth()->user()->email,
            //     'file_persyaratan_dasar_pemohon' => json_encode(array_values(array_filter([
            //         $buktiPemohonPaths['bukti_jenjang_siswa'],
            //         $buktiPemohonPaths['bukti_transkrip'],
            //         $buktiPemohonPaths['bukti_pengalaman_kerja'],
            //         $buktiPemohonPaths['bukti_magang']
            //     ]))),
            //     'file_administratif' => json_encode(array_values(array_filter([
            //         $buktiPemohonPaths['bukti_ktp'],
            //         $buktiPemohonPaths['bukti_foto']
            //     ]))),
            //     'ttd_pemohon' => 'belum ada',
            //     'status_rekomendasi' => 'N/A',
            // ]);

            session()->forget(['dataPribadi', 'dataSertifikasi']);
            // return redirect()->route('konfirmasi');
            return redirect()->route('konfirmasi')->with('success', 'Data berhasil disimpan.');

        }

        catch (\Exception $e) {
            Log::error('Error menyimpan pengajuan: '. $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }


        // $dataPribadi = $request->only([
        //     'nama_user', 'nik', 'nim', 'kota_domisili', 'tempat_tanggal_lahir',
        //     'jenis_kelamin', 'kebangsaan', 'alamat_rumah', 'no_telp', 'pendidikan_terakhir'
        // ]);

        // $dataSertifikasi = $request->only([
        //     'skema_sertifikasi', 'skemaDropdown', 'nomorSkemaInput', 'tujuan_asesmen'
        // ]);

        // $skema = Skema::where('nomor_skema', $dataSertifikasi['nomorSkemaInput'])->first();
        // if (!$skema) {
        //     return response()->json(['message' => 'Skema tidak ditemukan.'], 404);
        // }

        // $buktiPemohonPaths = [
        //     'bukti_jenjang_siswa' => $request->file('bukti_jenjang_siswa') ? $request->file('bukti_jenjang_siswa')->store('uploads/bukti_pemohon/jenjang_siswa') : null,
        //     'bukti_transkrip' => $request->file('bukti_transkrip') ? $request->file('bukti_transkrip')->store('uploads/bukti_pemohon/transkrip') : null,
        //     'bukti_pengalaman_kerja' => $request->file('bukti_pengalaman_kerja') ? $request->file('bukti_pengalaman_kerja')->store('uploads/bukti_pemohon/pengalaman_kerja') : null,
        //     'bukti_magang' => $request->file('bukti_magang') ? $request->file('bukti_magang')->store('uploads/bukti_pemohon/magang') : null,
        //     'bukti_ktp' => $request->file('bukti_ktp') ? $request->file('bukti_ktp')->store('uploads/bukti_pemohon/ktp') : null,
        //     'bukti_foto' => $request->file('bukti_foto') ? $request->file('bukti_foto')->store('uploads/bukti_pemohon/foto') : null,
        // ];

        // Session::put('data_pribadi', $dataPribadi);
        // Session::put('data_sertifikasi', $dataSertifikasi);


        // return redirect()->route('konfirmasi');
    }


}
