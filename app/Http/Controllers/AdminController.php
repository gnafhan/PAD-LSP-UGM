<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Skema;
use App\Models\Uk;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function indexDataAsesor()
    {
        $asesors = Asesor::all();
        return view('home.home-admin.daftar-asesor', compact('asesors'));
    }

    public function storeDataAsesor(Request $request)
    {

        $validatedData = $request->validate([
            'kode_registrasi' => 'required|string|max:255',
            'nama_asesor' => 'required|string|max:255',
            'no_sertifikat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'status_asesor' => 'required|string|max:255',
            'foto_asesor' => 'nullable|string|max:100',
            'gelar_depan' => 'nullable|string|max:255',
            'gelar_belakang' => 'nullable|string|max:255',
            'no_ktp' => 'required|string|max:20',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'keahlian' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kebangsaan' => 'nullable|string|max:255',
            'no_lisensi' => 'nullable|string|max:255',
            'masa_berlaku' => 'nullable|date',
            'institusi_asal' => 'nullable|string|max:255',
            'no_telp_institusi_asal' => 'nullable|string|max:20',
            'fax_institusi_asal' => 'nullable|string|max:20',
            'email_institusi_asal' => 'nullable|email|max:255',
        ]);

        Asesor::create($validatedData);
        return redirect()->route('admin.asesor.index')->with('success', 'Asesor berhasil ditambahkan');
    }

    public function editDataAsesor($id)
    {
        $asesor = Asesor::findOrFail($id);
        return view('home.home-admin.edit-asesor', compact('asesor'));
    }

    public function updateDataAsesor(Request $request, $id)
    {
        $request->validate([
            'kode_registrasi' => 'required',
            'nama_asesor' => 'required',
            'no_sertifikat' => 'required',
            'email' => 'required|email'
        ]);

        $asesor = Asesor::findOrFail($id);
        $asesor->kode_registrasi = $request->kode_registrasi;
        $asesor->nama_asesor = $request->nama_asesor;
        $asesor->no_sertifikat = $request->no_sertifikat;
        $asesor->email = $request->email;
        $asesor->save();

        return redirect()->route('admin.asesor.index')->with('success', 'Data asesor berhasil diperbarui.');
    }


    public function destroyDataAsesor($id)
    {
        $asesor = Asesor::findOrFail($id);
        $asesor->delete();

        return redirect()->route('admin.asesor.index')->with('success', 'Data asesor berhasil dihapus.');
    }

    public function indexDataSkema()
    {
        // $skema = Skema::all();
        $skema = Skema::with('unitKompetensi')->get();
        return view('home.home-admin.skema', compact('skema'));
    }

    public function editDataSkema($id)
    {
        $skema = Skema::findOrFail($id);
        return view('home.home-admin.edit-skema', compact('skema'));
    }

}
