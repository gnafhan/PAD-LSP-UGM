<?php
// filepath: app/Http/Controllers/PengajuanController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsesiPengajuan;
use App\Models\Skema;
use App\Models\UK;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    /**
     * Show the persetujuan TTD form
     */
    public function indexPersetujuan()
    {
        // Jika user sudah memiliki pengajuan, redirect ke konfirmasi
        $idUser = auth()->user()->id_user;
        $asesiPengajuan = AsesiPengajuan::where('id_user', $idUser)
                            ->whereIn('status', [
                                AsesiPengajuan::STATUS_DRAFT,
                                AsesiPengajuan::STATUS_NEEDS_REVISION,
                                AsesiPengajuan::STATUS_REJECTED,
                                AsesiPengajuan::STATUS_SUBMITTED,
                                AsesiPengajuan::STATUS_REVISED_BY_ASESI
                            ])
                            ->first();

        if ($asesiPengajuan) {
            // If status is approved, redirect to home-asesi
            if ($asesiPengajuan->status == AsesiPengajuan::STATUS_APPROVED) {
                return redirect()->route('home.asesi');
            }

            // Otherwise redirect to confirmation page
            return redirect()->route('user.apl1.konfirmasi')
                ->with('info', 'Anda sudah memiliki pengajuan sertifikasi.');
        }

        // Get current user
        $user = Auth::user();
        $data = $user->name ?? $user->email ?? 'User';

        return view('home.home-visitor.persetujuan', [
            'data' => $data,
        ]);
    }

    /**
     * Save persetujuan TTD data
     */
    public function saveDataPersetujuan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ], [
            'signature.required' => 'Anda harus mengupload tanda tangan digital',
            'signature.mimes' => 'Format tanda tangan harus berupa PNG, JPG, atau JPEG',
            'signature.max' => 'Ukuran file maksimal 2MB'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Get current user's ID
            $user = auth()->user();
            $userId = $user->id_user;

            // Create filename pattern for existing signature
            $filePattern = 'ttd_' . $userId . '.*';

            // Check if user already has a signature in storage
            $existingFiles = Storage::disk('public')->files('signatures');
            foreach ($existingFiles as $file) {
                // Check if file matches pattern for this user's signature
                if (preg_match('/signatures\/ttd_' . $userId . '\.[a-z]+$/i', $file)) {
                    // Delete old signature file
                    Storage::disk('public')->delete($file);
                    Log::info('Deleted existing signature: ' . $file);
                }
            }

            // Store new signature
            if ($request->hasFile('signature') && $request->file('signature')->isValid()) {
                // Create filename for new signature
                $fileName = 'ttd_' . $userId . '.' . $request->file('signature')->getClientOriginalExtension();

                // Store file in public/storage/signatures
                $ttd_pemohon = $request->file('signature')->storeAs('signatures', $fileName, 'public');

                // Store in session
                session()->put('dataPersetujuan', ['ttd_pemohon' => $ttd_pemohon]);

                Log::info('New signature saved: ' . $ttd_pemohon);

                return response()->json([
                    'success' => true,
                    'message' => 'Tanda tangan berhasil disimpan'
                ]);
            }

            return response()->json([
                'errors' => ['signature' => ['Gagal mengupload tanda tangan']]
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error saving signature: ' . $e->getMessage());

            return response()->json([
                'errors' => ['system' => ['Terjadi kesalahan sistem: ' . $e->getMessage()]]
            ], 500);
        }
    }


    /**
     * Show the data pribadi form
     */
    public function showDataPribadi()
    {
        // Get draft first for revision check
        $draft = $this->getDraft();

        // If user is in revision mode, allow access regardless of previous steps
        if ($draft && $draft->status == AsesiPengajuan::STATUS_NEEDS_REVISION) {
            $revisionMessage = null;
            $isRevision = true;

            if ($draft->needsRevisionForStep(AsesiPengajuan::STEP_DATA_PRIBADI)) {
                $revisionMessage = "Pengajuan Anda memerlukan revisi pada data pribadi: {$draft->revision_notes}";
            }

            return view('home.home-visitor.APL-01.data-pribadi', [
                'pengajuan' => $draft,
                'revisionMessage' => $revisionMessage,
                'isRevision' => $isRevision
            ]);
        }

        // For non-revision, check proper flow
        if (!session()->has('dataPersetujuan')) {
            return redirect()->route('user.persetujuan.index')
                ->with('error', 'Anda harus melakukan persetujuan dan upload tanda tangan terlebih dahulu');
        }

        // If draft exists and not in revision, use it
        if ($draft) {
            return view('home.home-visitor.APL-01.data-pribadi', [
                'pengajuan' => $draft,
                'revisionMessage' => null,
                'isRevision' => false
            ]);
        }

        // If no draft, use session data if any
        $dataPribadi = session('dataPribadi', []);

        return view('home.home-visitor.APL-01.data-pribadi', [
            'pengajuan' => (object)$dataPribadi,
            'revisionMessage' => null,
            'isRevision' => false
        ]);
    }



    /**
     * Save data pribadi
     */
    public function saveDataPribadi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required',
            'nik' => 'required|digits:16',
            'tempat_tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'kebangsaan' => 'required',
            'alamat_rumah' => 'required',
            'kota_domisili' => 'required',
            'no_telp' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_pekerjaan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Ambil data yang sudah divalidasi
        $dataPribadi = $request->only([
            'nama_user', 'nik', 'nim', 'tempat_tanggal_lahir', 'jenis_kelamin',
            'kebangsaan', 'alamat_rumah', 'kota_domisili', 'no_telp',
            'pendidikan_terakhir', 'status_pekerjaan'
        ]);

        // Tambahkan data pekerjaan jika bekerja
        if ($request->status_pekerjaan == 'Bekerja') {
            $dataPribadi = array_merge($dataPribadi, $request->only([
                'nama_perusahaan', 'jabatan', 'alamat_perusahaan', 'no_telp_perusahaan'
            ]));
        }

        // Cek apakah user sudah memiliki pengajuan (untuk revisi)
        $draft = $this->getDraft();

        // Jika sudah ada pengajuan, update langsung ke database
        if ($draft) {
            foreach ($dataPribadi as $key => $value) {
                $draft->{$key} = $value;
            }

            // Update step completion
            $draft->updateStepCompleted(AsesiPengajuan::STEP_DATA_PRIBADI);
            $draft->save();
        } else {
            // Simpan ke session untuk digunakan nanti
            session()->put('dataPribadi', $dataPribadi);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the data sertifikasi form
     */
    public function showDataSertifikasi()
    {
        // Cek jika user sudah memiliki pengajuan (untuk revisi)
        $draft = $this->getDraft();

        // Jika dalam mode revisi, tampilkan langsung form tanpa pengecekan lain
        if ($draft && $draft->status == AsesiPengajuan::STATUS_NEEDS_REVISION) {
            $skemaList = Skema::all();
            $revisionMessage = null;
            $isRevision = true;

            if ($draft->needsRevisionForStep(AsesiPengajuan::STEP_DATA_SERTIFIKASI)) {
                $revisionMessage = "Pengajuan Anda memerlukan revisi pada data sertifikasi: {$draft->revision_notes}";
            }

            return view('home.home-visitor.APL-01.data-sertifikasi', [
                'pengajuan' => $draft, // Menggunakan 'pengajuan' untuk konsistensi
                'skemaList' => $skemaList,
                'revisionMessage' => $revisionMessage,
                'isRevision' => $isRevision
            ]);
        }

        // Untuk non-revisi, lakukan pengecekan normal
        if (!session()->has('dataPersetujuan')) {
            return redirect()->route('user.persetujuan.index')
                ->with('error', 'Anda harus melakukan persetujuan dan upload tanda tangan terlebih dahulu');
        }

        // Untuk draft normal yang sudah ada
        if ($draft) {
            $skemaList = Skema::all();
            return view('home.home-visitor.APL-01.data-sertifikasi', [
                'pengajuan' => $draft, // Menggunakan 'pengajuan' untuk konsistensi
                'skemaList' => $skemaList
            ]);
        }

        // Jika belum ada draft tapi belum ada data pribadi, redirect ke data pribadi
        if (!session()->has('dataPribadi')) {
            return redirect()->route('user.apl1.pribadi')
                ->with('error', 'Anda harus mengisi data pribadi terlebih dahulu');
        }

        // Jika tidak ada draft tapi ada data pribadi di session, lanjutkan
        $dataSertifikasi = session('dataSertifikasi', []);

        // Get data Skema yang mempunyai informasi lengkap
        $skemaList = Skema::where('has_complete_info', 1)->get();

        return view('home.home-visitor.APL-01.data-sertifikasi', [
            'pengajuan' => (object)$dataSertifikasi,
            'skemaList' => $skemaList,
            'revisionMessage' => null
        ]);
    }

    /**
     * Get nomor skema based on nama skema
     */
    public function getNomorSkema(Request $request)
    {
        $idSkema = $request->input('id_skema');
        $skema = Skema::where('id_skema', $idSkema)->first();

        if ($skema) {
            return response()->json([
                'nomor_skema' => $skema->nomor_skema,
                'dokumen_skkni' => $skema->dokumen_skkni,
                'tujuan_asesmen' => 'sertifikasi' // Default value
            ]);
        }

        return response()->json([
            'nomor_skema' => '',
            'dokumen_skkni' => null,
            'tujuan_asesmen' => ''
        ]);
    }

    /**
     * Get daftar unit kompetensi based on nama skema
     */
    public function showDaftarUK(Request $request)
    {
        $idSkema = $request->input('id_skema');
        $skema = Skema::where('id_skema', $idSkema)->first();

        if ($skema) {
            // Gunakan method getUnitKompetensi() yang sudah didefinisikan di model Skema
            $ukList = $skema->getUnitKompetensi();

            // Handle jika ukList null atau kosong
            if (!$ukList || $ukList->isEmpty()) {
                return response()->json(['ukList' => []]);
            }

            // Transform data jika diperlukan untuk format response yang lebih baik
            $transformedList = $ukList->map(function($uk) {
                return [
                    'id_uk' => $uk->id_uk,
                    'kode_uk' => $uk->kode_uk,
                    'nama_uk' => $uk->nama_uk,
                    'jenis_standar' => $uk->jenis_standar
                ];
            });

            return response()->json(['ukList' => $transformedList]);
        }

        return response()->json(['ukList' => []], 404);
    }

    /**
     * Save data sertifikasi
     */
    public function saveDataSertifikasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'skema_sertifikasi' => 'required',
            'skemaDropdown' => 'required',
            'nomorSkemaInput' => 'required',
            'tujuan_asesmen' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find id skema
        $skema = Skema::where('id_skema', $request->skemaDropdown)->first();
        if (!$skema) {
            return response()->json(['errors' => ['skemaDropdown' => ['Skema tidak valid']]], 422);
        }

        // Data sertifikasi yang akan disimpan
        $dataSertifikasi = [
            'skema_sertifikasi' => $request->skema_sertifikasi,
            'nama_skema' => $skema->nama_skema,
            'nomor_skema' => $request->nomorSkemaInput,
            'tujuan_asesmen' => $request->tujuan_asesmen,
            'id_skema' => $skema->id_skema
        ];

        // Cek apakah user sudah memiliki pengajuan (untuk revisi)
        $draft = $this->getDraft();

        // Jika sudah ada pengajuan, update langsung ke database
        if ($draft) {
            foreach ($dataSertifikasi as $key => $value) {
                $draft->{$key} = $value;
            }

            // Update step completion
            $draft->updateStepCompleted(AsesiPengajuan::STEP_DATA_SERTIFIKASI);
            $draft->save();
        } else {
            // Simpan ke session untuk digunakan nanti
            session()->put('dataSertifikasi', $dataSertifikasi);
        }

        return response()->json(['success' => true]);
    }

        /**
     * Show the bukti kelengkapan form
     */
    public function showBuktiKelengkapan()
    {
        // Cek jika user sudah memiliki pengajuan (untuk revisi)
        $draft = $this->getDraft();

        // Jika sudah ada draft, gunakan data tersebut
        if ($draft) {
            $revisionMessage = null;
            if ($draft->status == AsesiPengajuan::STATUS_NEEDS_REVISION &&
                $draft->needsRevisionForStep(AsesiPengajuan::STEP_BUKTI_KELENGKAPAN)) {
                $revisionMessage = "Pengajuan Anda memerlukan revisi pada bukti kelengkapan: {$draft->revision_notes}";
            }

            return view('home.home-visitor.APL-01.bukti-pemohon', [
                'pengajuan' => $draft,
                'revisionMessage' => $revisionMessage
            ]);
        }

        // Cek jika user belum mengisi data-data sebelumnya
        if (!session()->has('dataPersetujuan')) {
            return redirect()->route('user.persetujuan.index')
                ->with('error', 'Anda harus melakukan persetujuan dan upload tanda tangan terlebih dahulu');
        }

        if (!session()->has('dataPribadi')) {
            return redirect()->route('user.apl1.pribadi')
                ->with('error', 'Anda harus mengisi data pribadi terlebih dahulu');
        }

        if (!session()->has('dataSertifikasi')) {
            return redirect()->route('user.apl1.sertifikasi')
                ->with('error', 'Anda harus mengisi data sertifikasi terlebih dahulu');
        }

        // Buat draft baru dari session data (ini adalah saat pertama kali draft dibuat)
        $draft = $this->createDraftFromSession();

        return view('home.home-visitor.APL-01.bukti-pemohon', [
            'pengajuan' => $draft,
            'revisionMessage' => null
        ]);
    }

    /**
     * Save bukti kelengkapan
     */
    public function saveBuktiKelengkapan(Request $request)
    {
        // Get existing draft first
        $pengajuan = $this->getDraft();

        if (!$pengajuan) {
            return redirect()->route('user.apl1.sertifikasi')
                ->with('error', 'Data pengajuan tidak ditemukan. Silakan lengkapi data sertifikasi terlebih dahulu.');
        }

        // Check if KTP file already exists
        $fileKelengkapan = $pengajuan->file_kelengkapan_pemohon ?? [];
        $ktpExists = isset($fileKelengkapan['bukti_ktp']);

        // Dynamic validation rules based on existing files
        $rules = [
            'bukti_ktp' => $ktpExists ? 'nullable|file|mimes:pdf' : 'required|file|mimes:pdf',
            'bukti_foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'bukti_jenjang_siswa' => 'nullable|file|mimes:pdf',
            'bukti_transkrip' => 'nullable|file|mimes:pdf',
            'bukti_pengalaman_kerja' => 'nullable|file|mimes:pdf',
            'bukti_magang' => 'nullable|file|mimes:pdf',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process each file upload
        $fileFields = [
            'bukti_ktp', 'bukti_foto', 'bukti_jenjang_siswa',
            'bukti_transkrip', 'bukti_pengalaman_kerja', 'bukti_magang'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                // Delete old file if exists
                if (isset($fileKelengkapan[$field])) {
                    $oldPath = str_replace('storage/', 'public/', $fileKelengkapan[$field]);
                    if (Storage::exists($oldPath)) {
                        Storage::delete($oldPath);
                    }
                }

                // Save new file
                $path = $request->file($field)->store('public/bukti-kelengkapan');
                $fileKelengkapan[$field] = str_replace('public/', 'storage/', $path);
            }
        }

        // Update pengajuan
        $pengajuan->file_kelengkapan_pemohon = $fileKelengkapan;

        // Update step completion
        $pengajuan->updateStepCompleted(AsesiPengajuan::STEP_BUKTI_KELENGKAPAN);
        $pengajuan->save();

        return redirect()->route('user.apl1.konfirmasi')
            ->with('success', 'Bukti kelengkapan berhasil diunggah');
    }

    /**
     * Show the konfirmasi form
     */
    public function showKonfirmasi()
    {
        $idUser = auth()->user()->id_user;



        // Cek apakah ada pengajuan dengan status apapun
        $pengajuan = AsesiPengajuan::where('id_user', $idUser)
                        ->whereIn('status', [
                            AsesiPengajuan::STATUS_DRAFT,
                            AsesiPengajuan::STATUS_NEEDS_REVISION,
                            AsesiPengajuan::STATUS_SUBMITTED,
                            AsesiPengajuan::STATUS_APPROVED,
                            AsesiPengajuan::STATUS_REJECTED,
                            AsesiPengajuan::STATUS_REVISED_BY_ASESI
                        ])
                        ->first();

        if (!$pengajuan) {
            return redirect()->route('user.persetujuan.index')
                ->with('error', 'Data pengajuan tidak ditemukan. Silakan mulai dari awal.');
        }

        // Khusus untuk draft & needs_revision, cek tahapan
        if (in_array($pengajuan->status, [AsesiPengajuan::STATUS_DRAFT, AsesiPengajuan::STATUS_NEEDS_REVISION])) {
            if ($pengajuan->steps_completed < AsesiPengajuan::STEP_BUKTI_KELENGKAPAN) {
                return redirect()->route('user.apl1.bukti')
                    ->with('error', 'Anda harus melengkapi bukti kelengkapan terlebih dahulu');
            }
        }

        return view('home.home-visitor.APL-01.konfirmasi', [
            'asesiPengajuan' => $pengajuan
        ]);
    }

    /**
     * Submit final application
     */
    public function submitPengajuan(Request $request)
    {
        $pengajuan = AsesiPengajuan::where('id_user', Auth::id())
                        ->whereIn('status', [
                            AsesiPengajuan::STATUS_DRAFT,
                            AsesiPengajuan::STATUS_NEEDS_REVISION
                        ])
                        ->first();

        if (!$pengajuan) {
            return redirect()->back()
                ->with('error', 'Pengajuan tidak ditemukan');
        }

        // Validate final submission
        if ($pengajuan->steps_completed < AsesiPengajuan::STEP_BUKTI_KELENGKAPAN) {
            return redirect()->back()
                ->with('error', 'Anda harus melengkapi semua tahapan terlebih dahulu');
        }

        // Check if this is a revision submission
        $isRevision = $pengajuan->status === AsesiPengajuan::STATUS_NEEDS_REVISION;

        if ($isRevision) {
            // For revision, mark as revised but keep in the same category
            $pengajuan->status = 'revised_by_asesi'; // Tambahkan status baru ini di model AsesiPengajuan
            $successMessage = 'Revisi permohonan sertifikasi Anda telah berhasil diajukan dan sedang menunggu persetujuan';
        } else {
            // For new submission
            $pengajuan->status = AsesiPengajuan::STATUS_SUBMITTED;
            $successMessage = 'Permohonan sertifikasi Anda telah berhasil diajukan dan sedang menunggu persetujuan';
        }

        $pengajuan->steps_completed = AsesiPengajuan::STEP_KONFIRMASI;
        $pengajuan->submitted_at = now();

        // Clear revision notes if this was a revision
        if ($pengajuan->revision_steps) {
            $pengajuan->revision_steps = null;
            $pengajuan->revision_notes = null;
        }

        $pengajuan->save();

        return redirect()->route('home')
            ->with('success', $successMessage);
    }

    /**
     * Helper: Get existing draft if exists
     */
    private function getDraft()
    {
        $idUser = auth()->user()->id_user;
        return AsesiPengajuan::where('id_user', $idUser)
                    ->whereIn('status', [
                        AsesiPengajuan::STATUS_DRAFT,
                        AsesiPengajuan::STATUS_NEEDS_REVISION
                    ])
                    ->first();
    }

    /**
     * Helper: Create new draft from session data
     * Hanya dipanggil pada tahap bukti-pemohon
     */
    private function createDraftFromSession()
    {
        $idUser = auth()->user()->id_user;

        // Create new draft
        $draft = new AsesiPengajuan();
        $draft->id_user = $idUser;
        $draft->status = AsesiPengajuan::STATUS_DRAFT;
        $draft->status_rekomendasi = 'N/A';
        $draft->steps_completed = 0;
        $draft->email = auth()->user()->email;

        // Add data from all sessions
        // 1. Data Persetujuan (tanda tangan)
        if (session()->has('dataPersetujuan')) {
            $dataPersetujuan = session('dataPersetujuan');
            $draft->ttd_pemohon = $dataPersetujuan['ttd_pemohon'] ?? null;
        }

        // 2. Data Pribadi
        if (session()->has('dataPribadi')) {
            $dataPribadi = session('dataPribadi');
            foreach ($dataPribadi as $key => $value) {
                $draft->{$key} = $value;
            }
            $draft->steps_completed = AsesiPengajuan::STEP_DATA_PRIBADI;
        }

        // 3. Data Sertifikasi
        if (session()->has('dataSertifikasi')) {
            $dataSertifikasi = session('dataSertifikasi');
            foreach ($dataSertifikasi as $key => $value) {
                $draft->{$key} = $value;
            }
            $draft->steps_completed = AsesiPengajuan::STEP_DATA_SERTIFIKASI;
        }

        $draft->save();

        // Clear session data after saving to database
        session()->forget(['dataPribadi', 'dataPersetujuan', 'dataSertifikasi']);

        return $draft;
    }

    /**
     * Restart application process after rejection
     */
    public function restartPengajuan()
    {
        $idUser = auth()->user()->id_user;
        $pengajuan = AsesiPengajuan::where('id_user', $idUser)
                        ->where('status', AsesiPengajuan::STATUS_REJECTED)
                        ->first();

        if ($pengajuan) {
            // Hapus file yang terkait
            if ($pengajuan->file_kelengkapan_pemohon) {
                foreach ($pengajuan->file_kelengkapan_pemohon as $path) {
                    if (Storage::exists(str_replace('storage/', 'public/', $path))) {
                        Storage::delete(str_replace('storage/', 'public/', $path));
                    }
                }
            }

            // Hapus pengajuan
            $pengajuan->delete();

            // Hapus session terkait
            session()->forget(['dataPribadi', 'dataPersetujuan', 'dataSertifikasi']);

            return redirect()->route('user.persetujuan.index')
                ->with('success', 'Pengajuan lama telah dihapus. Silakan mulai proses baru.');
        }

        return redirect()->route('home')
            ->with('error', 'Pengajuan tidak ditemukan.');
    }
}
