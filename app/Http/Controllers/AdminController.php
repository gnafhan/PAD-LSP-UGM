<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\AsesiPengajuan;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\UK;
use App\Models\TUK;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $events = Event::all()->count();
        $asesi = Asesi::all()->count();
        $skema = Skema::all()->count();
        $asesor = Asesor::all()->count();
        return view('home.home-admin.home', compact('events', 'asesi', 'skema', 'asesor'));
    }

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
        $validatedData['foto_asesor'] = $validatedData['foto_asesor'] ?? 'budi.jpg';

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
        $ukList = UK::all();
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
        $ukList = UK::all();
        return view('home.home-admin.tambah-skema', ['ukList' => $ukList,]);
    }

    public function storeDataSkema(Request $request)
    {

        $kodeUKs = json_decode($request->daftar_id_uk, true);
        $idUKs = [];

        foreach ($kodeUKs as $kodeUK) {
            // Temukan id_uk berdasarkan kode_uk
            $uk = UK::where('kode_uk', $kodeUK)->first();

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
        $uk = UK::all();
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
            'elemen_uk' => 'required|string',
            'id_bidang' => 'nullable|string|max:20',
            'jenis_standar' => 'required|string|max:50'
        ]);

        UK::create($validatedData);
        return redirect()->route('admin.uk.index')->with('success', 'Unit Kompetensi berhasil ditambahkan');
    }

    public function editDataUk($id)
    {
        $uk = UK::findOrFail($id);
        return view('home.home-admin.edit-uk', compact('uk'));
    }

    public function updateDataUk(Request $request, $id)
    {
        $uk = UK::findOrFail($id);

        $validatedData = $request->validate([
            'kode_uk' => 'required|string|max:100',
            'nama_uk' => 'required|string|max:100',
            'elemen_uk' => 'required|string',
            'id_bidang' => 'nullable|string|max:20',
            'jenis_standar' => 'required|string|max:50'
        ]);

        $uk->update($validatedData);
        return redirect()->route('admin.uk.index')->with('success', 'Unit Kompetensi berhasil diperbarui');
    }

    public function destroyDataUk($id)
    {
        $uk = UK::findOrFail($id);
        $uk->delete();

        return redirect()->route('admin.uk.index')->with('success', 'Data unit kompetensi berhasil dihapus.');
    }

    public function indexDataEvent()
    {
        $event = Event::with('skemas')->get();
        $today = Carbon::now()->toDateString();

        // Ambil data asesi yang memiliki id_asesor dan event aktif
        $asesis = Asesi::with(['skema.events', 'asesor'])
            ->whereNotNull('id_asesor') // Hanya yang memiliki id_asesor
            ->whereHas('skema.events', function ($query) use ($today) {
                $query->whereDate('tanggal_mulai_event', '<=', $today)
                    ->whereDate('tanggal_berakhir_event', '>=', $today);
            })
            ->get();

        return view('home.home-admin.event2', compact('event', 'asesis'));
    }

    public function editDataEvent($id)
    {
        $event = Event::with('skemas')->findOrFail($id); // Load relasi skemas dari tabel pivot
        $skemaList = Skema::all(); // Daftar semua skema

        return view('home.home-admin.edit-event', [
            'event' => $event,
            'skemaList' => $skemaList,
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

        $event->update($validatedData);

        // Update tabel pivot
        $skemaIds = array_filter(explode(',', $request->input('daftar_id_skema', '')));
        $event->skemas()->sync($skemaIds);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui');
    }

    public function createDataEvent()
    {
        $skemaList = Skema::all();
        return view('home.home-admin.tambah-event', ['skemaList' => $skemaList,]);
    }

    public function storeDataEvent(Request $request)
    {
        try {

            if ($request->has('daftar_id_skema')) {
                $request->merge([
                    'daftar_id_skema' => json_decode($request->input('daftar_id_skema'), true)
                ]);
            }

            $validatedData = $request->validate([
                'nama_event' => 'required|string|max:100',
                'tanggal_mulai_event' => 'required|date',
                'tanggal_berakhir_event' => 'required|date|after_or_equal:tanggal_mulai_event',
                'tuk' => 'required|string|max:100',
                'tipe_event' => 'required|string|max:50',
                'daftar_id_skema' => 'required|array|min:1',
            ]);

            // Simpan event
            $event = Event::create([
                'nama_event' => $validatedData['nama_event'],
                'tanggal_mulai_event' => $validatedData['tanggal_mulai_event'],
                'tanggal_berakhir_event' => $validatedData['tanggal_berakhir_event'],
                'tuk' => $validatedData['tuk'],
                'tipe_event' => $validatedData['tipe_event'],
            ]);

            // Ambil ID skema dari nomor skema
            $nomorSkemas = $request->input('daftar_id_skema');
            $idSkemas = Skema::whereIn('nomor_skema', $nomorSkemas)->pluck('id_skema');

            // Hubungkan event dengan skema
            $event->skemas()->attach($idSkemas);

            return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat menambahkan event: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    public function destroyDataEvent($id)
    {
        $Event = Event::findOrFail($id);
        $Event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Data event berhasil dihapus.');
    }

    public function indexDataAsesi()
    {
        $asesiPengajuan = AsesiPengajuan::where('status_rekomendasi', 'N/A')->get();
        $asesi = Asesi::where('id_asesor', null)->get();
        $asesors = Asesor::all();
        return view('home.home-admin.daftar-asesi', compact('asesiPengajuan', 'asesi', 'asesors'));
    }

    public function detailDataAsesi($id)
    {
        $asesiPengajuan = AsesiPengajuan::findOrFail($id);
        $id_user = $asesiPengajuan->id_user;

        $buktiKelengkapan = [
            'ijazah' => asset('storage/uploads/bukti_pemohon/jenjang_siswa/bukti_jenjang_siswa_' . $id_user . '.pdf'),
            'rapor' => asset('storage/uploads/bukti_pemohon/transkrip/bukti_transkrip_' . $id_user . '.pdf'),
            'pengalaman_kerja' => asset('storage/uploads/bukti_pemohon/pengalaman_kerja/bukti_pengalaman_kerja_' . $id_user . '.pdf'),
            'magang' => asset('storage/uploads/bukti_pemohon/magang/bukti_magang_' . $id_user . '.pdf'),
            'ktp' => asset('storage/uploads/bukti_pemohon/ktp/bukti_ktp_' . $id_user . '.pdf'),
            'foto' => asset('storage/uploads/bukti_pemohon/foto/bukti_foto_' . $id_user . '.pdf')
        ];

        return view('home.home-admin.detail-pengajuan', compact('asesiPengajuan', 'buktiKelengkapan'));
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
            'status_pekerjaan' => $asesiPengajuan->status_pekerjaan,
            'nama_perusahaan' => $asesiPengajuan->nama_perusahaan,
            'jabatan' => $asesiPengajuan->jabatan,
            'alamat_perusahaan' => $asesiPengajuan->alamat_perusahaan,
            'no_telp_perusahaan' => $asesiPengajuan->no_telp_perusahaan,
        ]);

        $asesiPengajuan->update(['status_rekomendasi' => 'Diterima']);

        return redirect()->route('admin.asesi.index')->with('success', 'Pengajuan asesi telah disetujui');
    }


    public function assignAsesor(Request $request)
    {
        $request->validate([
            'id_asesor' => 'required|exists:asesor,id_asesor',
            'assign_asesi' => 'required|array|min:1',
            'assign_asesi.*' => 'exists:asesi,id_asesi',
        ]);

        $asesorId = $request->input('id_asesor');
        $asesiIds = $request->input('assign_asesi');

        // Update ID Asesor pada data asesi yang dipilih
        Asesi::whereIn('id_asesi', $asesiIds)->update(['id_asesor' => $asesorId]);

        return redirect()->back()->with('success-assign', 'Asesi berhasil diassign ke asesor.');
    }




}
