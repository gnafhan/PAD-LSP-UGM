<?php

namespace App\Http\Controllers;
use App\Models\Skema;
use App\Models\UK;
use App\Models\Users;
use App\Models\AsesiPengajuan;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


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

    public function saveDataPribadi(Request $request)
    {
        session(['dataPribadi' => $request->all()]);
        return redirect()->route('sertifikasi');
    }

    public function saveDataSertifikasi(Request $request)
    {
        session(['dataSertifikasi' => $request->all()]);
        return redirect()->route('bukti');
    }


    public function storePengajuan(Request $request)
    {
        // Menyimpan data pribadi
        $dataPribadi = $request->only([
            'nama_user', 'nik', 'nim', 'kota_domisili', 'tempat_tanggal_lahir',
            'jenis_kelamin', 'kebangsaan', 'alamat_rumah', 'no_telp', 'pendidikan_terakhir'
        ]);

        // Menyimpan data sertifikasi
        $dataSertifikasi = $request->only([
            'skema_sertifikasi', 'skemaDropdown', 'nomorSkemaInput', 'tujuan_asesmen'
        ]);

        $skema = Skema::where('nomor_skema', $dataSertifikasi['nomorSkemaInput'])->first();
        if (!$skema) {
            return response()->json(['message' => 'Skema tidak ditemukan.'], 404);
        }

        // Menyimpan bukti pemohon dengan menyimpan file di folder berbeda
        $buktiPemohonPaths = [
            'bukti_jenjang_siswa' => $request->file('bukti_jenjang_siswa') ? $request->file('bukti_jenjang_siswa')->store('uploads/bukti_pemohon/jenjang_siswa') : null,
            'bukti_transkrip' => $request->file('bukti_transkrip') ? $request->file('bukti_transkrip')->store('uploads/bukti_pemohon/transkrip') : null,
            'bukti_pengalaman_kerja' => $request->file('bukti_pengalaman_kerja') ? $request->file('bukti_pengalaman_kerja')->store('uploads/bukti_pemohon/pengalaman_kerja') : null,
            'bukti_magang' => $request->file('bukti_magang') ? $request->file('bukti_magang')->store('uploads/bukti_pemohon/magang') : null,
            'bukti_ktp' => $request->file('bukti_ktp') ? $request->file('bukti_ktp')->store('uploads/bukti_pemohon/ktp') : null,
            'bukti_foto' => $request->file('bukti_foto') ? $request->file('bukti_foto')->store('uploads/bukti_pemohon/foto') : null,
        ];

        Session::put('data_pribadi', $dataPribadi);
        Session::put('data_sertifikasi', $dataSertifikasi);

        // Memasukkan data pengajuan ke tabel 'asesi_pengajuan'
        $asesiPengajuan = AsesiPengajuan::create([
            'id_user' => $auth()->user()->id_user,
            'id_skema' => $dataSertifikasi['nomorSkemaInput'], // bisa sesuaikan sesuai logika
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
            'file_persyaratan_dasar_pemohon' => json_encode([
                $buktiPemohonPaths['bukti_jenjang_siswa'],
                $buktiPemohonPaths['bukti_transkrip'],
                $buktiPemohonPaths['bukti_pengalaman_kerja'],
                $buktiPemohonPaths['bukti_magang']
            ]),
            'file_administratif' => json_encode([
                $buktiPemohonPaths['bukti_ktp'],
                $buktiPemohonPaths['bukti_foto']
            ]),
            'ttd_pemohon' => null,
            'status_rekomendasi' => 'N/A',
        ]);

        return redirect()->route('konfirmasi');
    }

}
