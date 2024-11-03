<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AsesiController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        return view('home-asesi.home-asesi', compact('user'));
    }

    // Method untuk menyimpan data dari view data-pengajuan
    public function storeDataPengajuan(Request $request)
    {
        $request->validate([
            'id_skema' => 'required|string|max:10',
            'nama_skema' => 'required|string|max:100',
            'tgl_ujian' => 'nullable|date',
            'sumber_anggaran' => 'nullable|string|max:50',
        ]);

        session([
            'id_skema' => $request->id_skema,
            'nama_skema' => $request->nama_skema,
            'tgl_ujian' => $request->tgl_ujian,
            'sumber_anggaran' => $request->sumber_anggaran,
        ]);

        return redirect()->route('profile-peserta');
    }

    // Method untuk menyimpan data dari view profile-peserta
    public function storeProfilePeserta(Request $request)
    {

        $request->validate([
            'nik' => 'required|string|max:20',
            'nama_asesi' => 'required|string|max:60',
            'jenis_kelamin' => 'required|string|max:20',
            'tempat_tanggal_lahir' => 'required|string|max:200',
            'alamat_sesuai_ktp' => 'required|string|max:200',
            'kode_pos' => 'required|string|max:20',
            'email' => 'required|email|max:20',
            'nim' => 'required|integer',
            'no_telp' => 'required|string|max:20',
            'kewarganegaraan' => 'required|integer',
        ]);

        session($request->only([
            'nik', 'nama_asesi', 'jenis_kelamin', 'tempat_tanggal_lahir',
            'alamat_sesuai_ktp', 'kode_pos', 'email', 'nim', 'no_telp', 'kewarganegaraan',
        ]));

        return redirect()->route('dokumen-portofolio');
    }

    // Method untuk menyimpan data dari view dokumen-portofolio
    public function storeDokumenPortofolio(Request $request)
    {
        $request->validate([
            'dokumen' => 'nullable|array',
        ]);

        $data = session()->only([
            'id_skema', 'nama_skema', 'tgl_ujian', 'sumber_anggaran',
            'nik', 'nama_asesi', 'jenis_kelamin', 'tempat_tanggal_lahir',
            'alamat_sesuai_ktp', 'kode_pos', 'email', 'nim', 'no_telp', 'kewarganegaraan'
        ]);

        // Tambahkan data dokumen yang diupload
        $data['dokumen'] = json_encode($request->dokumen);

        // Simpan data ke tabel asesi_pengajuan
        AsesiPengajuan::create($data);

        // Hapus data session setelah disimpan
        session()->forget([
            'id_skema', 'nama_skema', 'tgl_ujian', 'sumber_anggaran',
            'nik', 'nama_asesi', 'jenis_kelamin', 'tempat_tanggal_lahir',
            'alamat_sesuai_ktp', 'kode_pos', 'email', 'nim', 'no_telp', 'kewarganegaraan'
        ]);


        return redirect()->route('success'); //blm bikin route
    }
}
