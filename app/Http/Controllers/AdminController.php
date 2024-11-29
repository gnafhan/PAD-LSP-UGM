<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\AsesiPengajuan;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\Uk;
use App\Models\Tuk;
use App\Models\Event;
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


    public function indexDataUk()
    {
        $uk = Uk::all();
        return view('home.home-admin.unit-kompetensi', compact('uk'));
    }

    public function createDataUk()
    {
        return view('home.home-admin.tambah-uk');
    }

    public function storeDataUk(Request $request)
    {
        $validatedData = $request->validate([
            'kode_uk' => 'required|string|max:100|unique:uk',
            'nama_uk' => 'required|string|max:100',
            'id_bidang' => 'nullable|string|max:20',
            'jenis_standar' => 'required|string|max:50'
        ]);

        Uk::create($validatedData);
        return redirect()->route('admin.uk.index')->with('success', 'Unit Kompetensi berhasil ditambahkan');
    }

    public function editDataUk($id)
    {
        $uk = Uk::findOrFail($id);
        return view('home.home-admin.edit-uk', compact('uk'));
    }

    public function updateDataUk(Request $request, $id)
    {
        $uk = Uk::findOrFail($id);

        $validatedData = $request->validate([
            'kode_uk' => 'required|string|max:100',
            'nama_uk' => 'required|string|max:100',
            'id_bidang' => 'nullable|string|max:20',
            'jenis_standar' => 'required|string|max:50'
        ]);

        $uk->update($validatedData);
        return redirect()->route('admin.uk.index')->with('success', 'Unit Kompetensi berhasil diperbarui');
    }

    public function destroyDataUk($id)
    {
        $uk = Uk::findOrFail($id);
        $uk->delete();

        return redirect()->route('admin.uk.index')->with('success', 'Data unit kompetensi berhasil dihapus.');
    }

    public function indexDataEvent()
    {
        $event = Event::with('skema')->get();
        return view('home.home-admin.event2', compact('event'));
    }

    public function editDataEvent($id)
    {
        $event = Event::with('skema')->findOrFail($id);
        $skemaList = Skema::all();
        // Kirim data skema dalam format JSON
        $skemaJson = json_encode($event->skema);
        $daftarIdSkemaJson = $event->daftar_id_skema; // Ambil data daftar_id_skema langsung dari skema

        return view('home.home-admin.edit-event', [
            'event' => $event,
            'skemaJson' => $skemaJson,
            'daftarIdSkemaJson' => $daftarIdSkemaJson,
            'skemaList' => $skemaList
        ]);
    }

    public function updateDataEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validatedData = $request->validate([
            'nama_event' => 'required|string|max:100',
            'tanggal_mulai_event' => 'required|date',
            'tanggal_berakhir_event' => 'required|date',
            'tuk' => 'required|string|max:100',
            'tipe_event' => 'required|string|max:50',
        ]);

        $validatedData['daftar_id_skema'] = $request->input('daftar_id_skema');

        $event->update($validatedData);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui');
    }

    public function createDataEvent()
    {
        $skemaList = Skema::all();
        return view('home.home-admin.tambah-event', ['skemaList' => $skemaList,]);
    }

    public function storeDataEvent(Request $request)
    {

        $nomorSkemas = json_decode($request->daftar_id_skema, true);
        $idSkemas = [];

        foreach ($nomorSkemas as $nomorSkema) {
            // Temukan id_skema berdasarkan nomor_skema
            $skema = Skema::where('nomor_skema', $nomorSkema)->first();

            if ($skema) {
                $idSkemas[] = $skema->id_skema; // Masukkan id_skema yang ditemukan ke dalam array
            } else {
                return redirect()->back()->withErrors(['nomor_skema' => "Nomor Skema $nomorSkema tidak ditemukan."]);
            }
        }

        $validatedData = $request->validate([
            'nama_event' => 'required|string|max:100',
            'tanggal_mulai_event' => 'required|date',
            'tanggal_berakhir_event' => 'required|date',
            'tuk' => 'required|string|max:100',
            'tipe_event' => 'required|string|max:50',
        ]);

        $validatedData['daftar_id_skema'] = json_encode($idSkemas);

        Event::create($validatedData);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan');
    }

    public function destroyDataEvent($id)
    {
        $Event = Event::findOrFail($id);
        $Event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Data event berhasil dihapus.');
    }

    public function indexDataAsesi()
    {
        $asesiPengajuan = AsesiPengajuan::all();
        return view('home.home-admin.daftar-asesi', compact('asesiPengajuan'));
    }

    public function detailDataAsesi($id)
    {
        $asesiPengajuan = AsesiPengajuan::findOrFail($id);
        return view('home.home-admin.detail-pengajuan', compact('asesiPengajuan'));
    }

    public function approveAsesi($id_pengajuan)
    {
        $asesiPengajuan = AsesiPengajuan::find($id_pengajuan);

        if(!$asesiPengajuan) {
            return redirect()->back()->with('error', 'Data asesi pengajuan tidak ditemukan');
        }

        //Memindahkan data ke tabel Asesi
        Asesi::create([
            'nama_asesi' => $asesiPengajuan->nama_user,
            'tempat_tanggal_lahir' => $asesiPengajuan->tempat_tanggal_lahir,
            'jenis_kelamin' => $asesiPengajuan->jenis_kelamin,
            'kebangsaan' => $asesiPengajuan->kebangsaan,
            'alamat_rumah' => $asesiPengajuan->alamat_rumah,
            'kota_domisili' => $asesiPengajuan->kota_domisili,
            'no_telp' => $asesiPengajuan->no_telp,
            'email' => $asesiPengajuan->email,
            'nim' => $asesiPengajuan->nim,
            'id_user' => $asesiPengajuan->id_user,
            'id_skema' => $asesiPengajuan->id_skema,
            'file_kelengkapan_pemohon' => $asesiPengajuan->file_kelengkapan_pemohon,
            'ttd_pemohon' => $asesiPengajuan->ttd_pemohon,
        ]);

        $asesiPengajuan->update(['status_rekomendasi' => 'Diterima']);

        return redirect()->route('admin.asesi.index')->with('success', 'Pengajuan asesi telah disetujui');
    }





}
