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

    // nyobaa
    public function createDataSkema()
    {
        return view('home.home-admin.tambah-skema');
    }

    // Menambahkan method untuk menyimpan data skema baru
    public function storeDataSkema(Request $request)
    {
        $validatedData = $request->validate([
            'kode_skema' => 'required|string|max:255',
            'nama_skema' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'unit_kompetensi_id' => 'required|exists:unit_kompetensis,id',  // Asumsi ada relasi dengan unitKompetensi
        ]);

        Skema::create($validatedData);

        return redirect()->route('admin.skema.index')->with('success', 'Skema berhasil ditambahkan');
    }

    // Unit Kompetensi

    public function indexDataUnits()
    {
        // Ambil semua data unit kompetensi (UK) untuk ditampilkan di halaman daftar UK
        $units = Uk::all();
        return view('home.home-admin.unit-kompetensi', compact('units'));
    }

    public function createDataUnit()
    {
        // Menampilkan halaman form untuk menambah unit kompetensi baru
        return view('home.home-admin.tambah-uk');
    }

    public function storeDataUnit(Request $request)
    {
        // Validasi input dari form tambah unit kompetensi
        $validatedData = $request->validate([
            'kode_unit' => 'required|string|max:255|unique:uks,kode_unit',
            'nama_unit' => 'required|string|max:255',
        ]);

        // Menyimpan data unit kompetensi baru ke dalam database
        Uk::create($validatedData);

        return redirect()->route('admin.units.index')->with('success', 'Unit Kompetensi berhasil ditambahkan');
    }

    // Events
    public function create()
    {
        return view('home.home-admin.tambah-event');
    }

    public function store(Request $request)
    {
        // Validasi input form jika diperlukan
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'event_type' => 'required|string|max:255',
            'event_scheme' => 'required|array',
            'event_scheme.*' => 'string|max:255',
        ]);

        // Simpan data event ke database
        // $event = Event::create([
        //     'event_name' => $validated['event_name'],
        //     'start_date' => $validated['start_date'],
        //     'end_date' => $validated['end_date'],
        //     'event_type' => $validated['event_type'],
        // ]);

        // Simpan skema terkait jika ada
        // foreach ($validated['event_scheme'] as $scheme) {
        //     $event->schemes()->create(['scheme_name' => $scheme]); // Pastikan hubungan dengan tabel skema
        // }

        return redirect()->route('home.home-admin.event')->with('success', 'Event berhasil ditambahkan');
    }

}
