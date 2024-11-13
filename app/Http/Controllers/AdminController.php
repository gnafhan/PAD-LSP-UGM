<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Skema;
use App\Models\Uk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $skema = Skema::with('unitKompetensi')->findOrFail($id);
        $ukList = Uk::all();
        // Kirim data unit kompetensi dalam format JSON
        $unitKompetensiJson = json_encode($skema->unitKompetensi);
        $daftarIdUkJson = $skema->daftar_id_uk; // Ambil data daftar_id_uk langsung dari skema

        return view('home.home-admin.edit-skema', [
            'skema' => $skema,
            'unitKompetensiJson' => $unitKompetensiJson,
            'daftarIdUkJson' => $daftarIdUkJson,
            'ukList' => $ukList
        ]);
    }

    public function updateDataSkema(Request $request, $id)
    {
        $skema = Skema::findOrFail($id);

        $validatedData = $request->validate([
            'nama_skema' => 'required|string|max:100',
            'dokumen_skkni' => 'required|string|max:2048',
        ]);

        $validatedData['daftar_id_uk'] = $request->input('daftar_id_uk');

        $skema->update($validatedData);

        return redirect()->route('admin.skema.index')->with('success', 'Skema berhasil diperbarui');
    }

    public function createDataSkema()
    {
        $ukList = Uk::all();
        return view('home.home-admin.tambah-skema', ['ukList' => $ukList,]);
    }

    public function storeDataSkema(Request $request)
    {

        $kodeUKs = json_decode($request->daftar_id_uk, true);
        $idUKs = [];

        foreach ($kodeUKs as $kodeUK) {
            // Temukan id_uk berdasarkan kode_uk
            $uk = Uk::where('kode_uk', $kodeUK)->first();

            if ($uk) {
                $idUKs[] = $uk->id_uk; // Masukkan id_uk yang ditemukan ke dalam array
            } else {
                return redirect()->back()->withErrors(['kode_uk' => "Kode UK $kodeUK tidak ditemukan."]);
            }
        }

        $validatedData = $request->validate([
            'nomor_skema' => 'required|string|max:100',
            'nama_skema' => 'required|string|max:100',
            'dokumen_skkni' => 'required|file|mimes:pdf|max:2048',
            'persyaratan_skema' => 'required|string',
        ]);


        $validatedData['daftar_id_uk'] = json_encode($idUKs);

        if ($request->hasFile('dokumen_skkni')) {
            Log::info('File uploaded:', ['file' => $request->file('dokumen_skkni')]);
            $validatedData['dokumen_skkni'] = $request->file('dokumen_skkni')->store('skkni', 'public');
        } else {
            Log::warning('No file uploaded.');
        }

        Skema::create($validatedData);

        return redirect()->route('admin.skema.index')->with('success', 'Skema berhasil ditambahkan');
    }

    public function destroyDataSkema($id)
    {
        $Skema = Skema::findOrFail($id);
        $Skema->delete();

        return redirect()->route('admin.skema.index')->with('success', 'Data skema berhasil dihapus.');
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
