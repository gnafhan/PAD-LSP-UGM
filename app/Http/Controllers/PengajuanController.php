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
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function indexPersetujuan() {
        $data = @auth()->user()->email;
        return view('home.home-visitor.persetujuan', compact('data'));
    }


    public function saveDataPersetujuan(Request $request)
    {
        try {
            // Pertama, lakukan pengecekan apakah file ada atau tidak
            if (!$request->hasFile('signature')) {
                // Jika tidak ada file, kirim pesan error "Tanda tangan wajib diisi."
                return response()->json(['errors' => ['signature' => ['Tanda tangan wajib diisi.']]], 422);
            }

            // Jika ada file, lanjutkan validasi tipe file dan ukuran
            $validatedData = $request->validate([
                'signature' => 'file|mimes:jpg,jpeg,png|max:2048',
            ], [
                'signature.file' => 'Tanda tangan harus berupa file jpg, jpeg, atau png.',
                'signature.mimes' => 'Tanda tangan harus berupa file jpg, jpeg, atau png.',
                'signature.max' => 'Ukuran file tanda tangan tidak boleh lebih dari 2048.',
            ]);

            // Simpan file yang diunggah di direktori 'public/signatures'
            $signatureFile = $request->file('signature');
            $ttd_pemohon = $signatureFile->store('signatures');

            session()->put('dataPersetujuan', ['ttd_pemohon' => $ttd_pemohon]);

            return response()->json(['message' => 'Data berhasil disimpan'], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika terjadi kesalahan validasi, kirim respons JSON dengan status 422
            return response()->json(['errors' => $e->errors()], 422);

        } catch (\Exception $e) {
            Log::error('Error menyimpan tanda tangan: '. $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }


    public function saveDataPribadi(Request $request)
    {
        $request->validate([
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
            'status_pekerjaan' => 'required|string|max:20',
            'nama_perusahaan' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'alamat_perusahaan' => 'required|string',
            'no_telp_perusahaan' => 'required|string|max:20',
        ], [
            'nama_user.required' => 'Nama lengkap wajib diisi.',
            'nama_user.string' => 'Nama lengkap harus berupa teks.',
            'nama_user.max' => 'Nama lengkap tidak boleh lebih dari 150 karakter.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.string' => 'NIK harus berupa teks.',
            'nik.max' => 'NIK tidak boleh lebih dari 20 karakter.',

            'nim.required' => 'NIM wajib diisi.',
            'nim.string' => 'NIM harus berupa teks.',
            'nim.max' => 'NIM tidak boleh lebih dari 20 karakter.',

            'kota_domisili.required' => 'Kota domisili wajib diisi.',
            'kota_domisili.string' => 'Kota domisili harus berupa teks.',
            'kota_domisili.max' => 'Kota domisili tidak boleh lebih dari 100 karakter.',

            'tempat_tanggal_lahir.required' => 'Tempat dan tanggal lahir wajib diisi.',
            'tempat_tanggal_lahir.string' => 'Tempat dan tanggal lahir harus berupa teks.',
            'tempat_tanggal_lahir.max' => 'Tempat dan tanggal lahir tidak boleh lebih dari 200 karakter.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.string' => 'Jenis kelamin harus berupa teks.',
            'jenis_kelamin.max' => 'Jenis kelamin tidak boleh lebih dari 20 karakter.',

            'kebangsaan.required' => 'Kebangsaan wajib diisi.',
            'kebangsaan.string' => 'Kebangsaan harus berupa teks.',
            'kebangsaan.max' => 'Kebangsaan tidak boleh lebih dari 20 karakter.',

            'alamat_rumah.required' => 'Alamat rumah wajib diisi.',
            'alamat_rumah.string' => 'Alamat rumah harus berupa teks.',
            'alamat_rumah.max' => 'Alamat rumah tidak boleh lebih dari 200 karakter.',

            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.string' => 'Nomor telepon harus berupa teks.',
            'no_telp.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',

            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib diisi.',
            'pendidikan_terakhir.string' => 'Pendidikan terakhir harus berupa teks.',
            'pendidikan_terakhir.max' => 'Pendidikan terakhir tidak boleh lebih dari 100 karakter.',

            'status_pekerjaan.required' => 'Status pekerjaan wajib diisi.',
            'status_pekerjaan.string' => 'Status pekerjaan harus berupa teks.',
            'status_pekerjaan.max' => 'Status pekerjaan tidak boleh lebih dari 20 karakter.',

            'nama_perusahaan.required' => 'Nama perusahaan wajib diisi.',
            'nama_perusahaan.string' => 'Nama perusahaan harus berupa teks.',
            'nama_perusahaan.max' => 'Nama perusahaan tidak boleh lebih dari 100 karakter.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string' => 'Jabatan harus berupa teks.',
            'jabatan.max' => 'Jabatan tidak boleh lebih dari 100 karakter.',

            'alamat_perusahaan.required' => 'Alamat perusahaan wajib diisi.',
            'alamat_perusahaan.string' => 'Alamat perusahaan harus berupa teks.',

            'no_telp_perusahaan.required' => 'Nomor telepon perusahaan wajib diisi.',
            'no_telp_perusahaan.string' => 'Nomor telepon perusahaan harus berupa teks.',
            'no_telp_perusahaan.max' => 'Nomor telepon perusahaan tidak boleh lebih dari 20 karakter.',
        ]);

        try {
            session()->put('dataPribadi', $request->all());
            return response()->json(['message' => 'Data berhasil disimpan'], 200);

        } catch (\Exception $e) {
            Log::error('Error menyimpan data pribadi: '. $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }

    public function showDataSertifikasi()
    {
        $skemaList = Skema::all();
        return view('home.home-visitor.APL-01.data-sertifikasi', ['skemaList' => $skemaList]);
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


    public function saveDataSertifikasi(Request $request)
    {
        $request->validate([
            'skema_sertifikasi' => 'required|string|max:10',
            'skemaDropdown' => 'required|string|max:100',
            'nomorSkemaInput' => 'required|string|max:100',
            'tujuan_asesmen' => 'required|string|max:100',
        ], [
            'skema_sertifikasi.required' => 'Skema sertifikasi wajib diisi.',
            'skema_sertifikasi.string' => 'Skema sertifikasi harus berupa teks.',
            'skema_sertifikasi.max' => 'Skema sertifikasi tidak boleh lebih dari 10 karakter.',

            'skemaDropdown.required' => 'Nama skema wajib diisi.',
            'skemaDropdown.string' => 'Nama skema harus berupa teks.',
            'skemaDropdown.max' => 'Nama skema tidak boleh lebih dari 100 karakter.',

            'nomorSkemaInput.required' => 'Nomor skema wajib diisi.',
            'nomorSkemaInput.string' => 'Nomor skema harus berupa teks.',
            'nomorSkemaInput.max' => 'Nomor skema tidak boleh lebih dari 100 karakter.',

            'tujuan_asesmen.required' => 'Tujuan asesmen wajib diisi.',
            'tujuan_asesmen.string' => 'Tujuan asesmen harus berupa teks.',
            'tujuan_asesmen.max' => 'Tujuan asesmen tidak boleh lebih dari 100 karakter.',
        ]);

        try {
            session()->put('dataSertifikasi', $request->all());
            return response()->json(['message' => 'Data berhasil disimpan'], 200);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data'], 500);
        }
    }


    public function storePengajuan(Request $request)
    {
        // dd(session()->all());

        $user = auth()->user();
        // dd(auth()->user());

        try {

            $dataPersetujuan = session()->get('dataPersetujuan');
            $dataPribadi = session()->get('dataPribadi');
            $dataSertifikasi = session()->get('dataSertifikasi');

            // dd($dataPribadi, $dataSertifikasi);

            // if ( empty($dataPersetujuan) && empty($dataPribadi) && empty($dataSertifikasi)) {
            //     return redirect()->back()->with('errorSession', 'Data session dataPersetujuan dan dataPribadi dan dataSertifikasi tidak ditemukan.');
            // } elseif (empty($dataPribadi)) {
            //     return redirect()->back()->with('errorSession', 'Data session dataPribadi tidak ditemukan.');
            // } elseif (empty($dataSertifikasi)) {
            //     return redirect()->back()->with('errorSession', 'Data session dataSertifikasi tidak ditemukan.');
            // } elseif (empty($dataPersetujuan)) {
            //     return redirect()->back()->with('errorSession', 'Data session dataPersetujuan tidak ditemukan.');
            // }


            $data = array_merge($dataPersetujuan, $dataPribadi, $dataSertifikasi, $request->all());

            // dd($data);

            $validatedData = $request->validate([
                'bukti_jenjang_siswa' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_transkrip' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_pengalaman_kerja' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_magang' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'bukti_foto' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ], [
                'bukti_jenjang_siswa.required' => 'Bukti jenjang siswa wajib diisi.',
                'bukti_jenjang_siswa.file' => 'Bukti jenjang siswa harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_jenjang_siswa.mimes' => 'Bukti jenjang siswa harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_jenjang_siswa.max' => 'Ukuran file bukti jenjang siswa tidak boleh lebih dari 2048.',

                'bukti_transkrip.required' => 'Bukti transkrip nilai wajib diisi.',
                'bukti_transkrip.file' => 'Bukti transkrip nilai harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_transkrip.mimes' => 'Bukti transkrip nilai harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_transkrip.max' => 'Ukuran file bukti transkrip nilai tidak boleh lebih dari 2048.',

                'bukti_pengalaman_kerja.required' => 'Bukti surat pengalaman kerja wajib diisi.',
                'bukti_pengalaman_kerja.file' => 'Bukti transkrip nilai harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_pengalaman_kerja.mimes' => 'Bukti transkrip nilai harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_pengalaman_kerja.max' => 'Ukuran file bukti pengalaman kerja tidak boleh lebih dari 2048.',

                'bukti_magang.required' => 'Bukti surat PKL/Magang wajib diisi.',
                'bukti_magang.file' => 'Bukti magang harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_magang.mimes' => 'Bukti magang harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_magang.max' => 'Ukuran file bukti surat PKL/Magang tidak boleh lebih dari 2048.',

                'bukti_ktp.required' => 'Bukti KTP wajib diisi.',
                'bukti_ktp.file' => 'Bukti KTP harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_ktp.mimes' => 'Bukti KTP harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_ktp.max' => 'Ukuran file bukti KTP tidak boleh lebih dari 2048.',

                'bukti_foto.required' => 'Bukti foto 3x4 wajib diisi.',
                'bukti_foto.file' => 'Bukti foto 3x4 harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_foto.mimes' => 'Bukti foto 3x4 harus berupa file pdf, jpg, jpeg, atau png.',
                'bukti_foto.max' => 'Ukuran file bukti foto 3x4 tidak boleh lebih dari 2048.',
            ]);

            // dd($validatedData);

            $skema = Skema::where('nomor_skema', $data['nomorSkemaInput'])->firstOrFail();

            // dd($skema);

            $buktiPemohonPaths = [
                'bukti_jenjang_siswa' => $request->file('bukti_jenjang_siswa') ? $request->file('bukti_jenjang_siswa')->store('uploads/bukti_pemohon/jenjang_siswa') : null,
                'bukti_transkrip' => $request->file('bukti_transkrip') ? $request->file('bukti_transkrip')->store('uploads/bukti_pemohon/transkrip') : null,
                'bukti_pengalaman_kerja' => $request->file('bukti_pengalaman_kerja') ? $request->file('bukti_pengalaman_kerja')->store('uploads/bukti_pemohon/pengalaman_kerja') : null,
                'bukti_magang' => $request->file('bukti_magang') ? $request->file('bukti_magang')->store('uploads/bukti_pemohon/magang') : null,
                'bukti_ktp' => $request->file('bukti_ktp') ? $request->file('bukti_ktp')->store('uploads/bukti_pemohon/ktp') : null,
                'bukti_foto' => $request->file('bukti_foto') ? $request->file('bukti_foto')->store('uploads/bukti_pemohon/foto') : null,
            ];

            // dd($buktiPemohonPaths);

            AsesiPengajuan::create(array_merge($validatedData, [
                'id_user' => $user->id_user,
                'id_skema' => $skema->id_skema,
                'nama_user' => $data['nama_user'],
                'nik' => $data['nik'],
                'nim' => $data['nim'],
                'kota_domisili' => $data['kota_domisili'],
                'tempat_tanggal_lahir' => $data['tempat_tanggal_lahir'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'kebangsaan' => $data['kebangsaan'],
                'alamat_rumah' => $data['alamat_rumah'],
                'no_telp' => $data['no_telp'],
                'pendidikan_terakhir' => $data['pendidikan_terakhir'],
                'skema_sertifikasi' => $data['skema_sertifikasi'],
                'nama_skema' => $data['skemaDropdown'],
                'nomor_skema' => $data['nomorSkemaInput'],
                'tujuan_asesmen' => $data['tujuan_asesmen'],
                'sumber_anggaran' => null,
                'email' => $user->email,
                'file_kelengkapan_pemohon' => json_encode(array_values(array_filter([
                    $buktiPemohonPaths['bukti_jenjang_siswa'],
                    $buktiPemohonPaths['bukti_transkrip'],
                    $buktiPemohonPaths['bukti_pengalaman_kerja'],
                    $buktiPemohonPaths['bukti_magang'],
                    $buktiPemohonPaths['bukti_ktp'],
                    $buktiPemohonPaths['bukti_foto']
                ]))),
                'ttd_pemohon' => $data['ttd_pemohon'],
                'status_rekomendasi' => 'N/A',
                'status_pekerjaan' => $data['status_pekerjaan'],
                'nama_perusahaan' => $data['nama_perusahaan'],
                'jabatan' => $data['jabatan'],
                'alamat_perusahaan' => $data['alamat_perusahaan'],
                'no_telp_perusahaan' => $data['no_telp_perusahaan'],
            ]));

            return redirect()->route('konfirmasi')->with('success', 'Data berhasil disimpan.');

        }

        catch (\Exception $e) {
            Log::error('Error menyimpan pengajuan: '. $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }


}
