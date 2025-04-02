<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Asesor;
use App\Models\BidangKompetensi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\KompetensiTeknis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenggunaPageController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data admin dari tabel users
        $adminQuery = User::where('level', 'admin');
        
        // Ambil data asesor dari tabel asesor
        $asesorQuery = Asesor::query();
        
        // Filter pencarian admin
        if ($request->has('search_admin')) {
            $search = $request->search_admin;
            
            $adminQuery->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('no_hp', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter pencarian asesor
        if ($request->has('search_asesor')) {
            $search = $request->search_asesor;
            
            $asesorQuery->where(function($q) use ($search) {
                $q->where('nama_asesor', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('no_hp', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter bidang kompetensi asesor
        if ($request->has('filter_bidang') && $request->filter_bidang != '') {
            // Kita perlu melakukan filter pada data JSON
            $filteredIds = [];
            $allAsesors = Asesor::all();
            
            foreach ($allAsesors as $asesor) {
                if (!empty($asesor->daftar_bidang_kompetensi)) {
                    $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
                    if (is_array($bidangIds) && in_array($request->filter_bidang, $bidangIds)) {
                        $filteredIds[] = $asesor->id_asesor;
                    }
                }
            }
            
            if (!empty($filteredIds)) {
                $asesorQuery->whereIn('id_asesor', $filteredIds);
            } else {
                // Jika tidak ada yang cocok, set query untuk tidak mengembalikan data
                $asesorQuery->whereRaw('1=0');
            }
        }
        
        // Mengambil data admin dan asesor
        $admins = $adminQuery->get();
        $asesors = $asesorQuery->get();
        
        // Get all bidang kompetensi for lookup
        $bidangKompetensiData = BidangKompetensi::all()->keyBy('id_bidang_kompetensi');
        
        // Add bidang kompetensi detail to each asesor
        foreach ($asesors as $asesor) {
            $bidangKompetensiList = [];
            
            if (!empty($asesor->daftar_bidang_kompetensi)) {
                $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
                
                foreach ($bidangIds as $idBidang) {
                    if (isset($bidangKompetensiData[$idBidang])) {
                        $bidangKompetensiList[] = [
                            'id' => $idBidang,
                            'nama_bidang' => $bidangKompetensiData[$idBidang]->nama_bidang
                        ];
                    }
                }
            }
            
            $asesor->bidang_kompetensi = $bidangKompetensiList;
        }
        
        // Hitung statistik
        $totalStats = [
            'total' => User::count() + Asesor::count(), // Total user (admin + asesor)
            'admin' => User::where('level', 'admin')->count(),
            'asesor' => Asesor::count(),
            'asesor_aktif' => Asesor::where('status_asesor', 'aktif')->count(),
        ];
        
        // Get all bidang kompetensi for the dropdown in modal
        $bidangKompetensi = BidangKompetensi::all();
        
        return view('home.home-admin.pengguna', compact('admins', 'asesors', 'totalStats', 'bidangKompetensi'));
    }

    /**
     * Menampilkan form untuk mengedit data asesor
     * 
     * @param string $id ID Asesor
     * @return \Illuminate\View\View
     */
    public function editAsesor($id)
    {
        $asesor = Asesor::findOrFail($id);
        
        // Konversi daftar bidang kompetensi dari JSON ke array
        if (!empty($asesor->daftar_bidang_kompetensi)) {
            $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
            
            // Ambil data lengkap bidang kompetensi dari ID
            $bidangKompetensiData = [];
            foreach ($bidangIds as $bidangId) {
                $bidang = BidangKompetensi::find($bidangId);
                if ($bidang) {
                    $bidangKompetensiData[] = [
                        'id' => $bidang->id_bidang_kompetensi,
                        'nama_bidang' => $bidang->nama_bidang
                    ];
                }
            }
            
            $asesor->bidang_kompetensi = $bidangKompetensiData;
        } else {
            $asesor->bidang_kompetensi = [];
        }
        
        // Ambil semua bidang kompetensi untuk dropdown
        $bidangKompetensi = BidangKompetensi::all();
        
        return view('home.home-admin.edit-asesor', compact('asesor', 'bidangKompetensi'));
    }

    public function updateAsesorStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_asesor' => 'required|string',
            'status_asesor' => 'required|in:Aktif,Tidak',
            'masa_berlaku' => 'required|date',
            'bidang_kompetensi' => 'nullable|string',
            'kode_registrasi' => 'nullable|string|max:100',
            'no_sertifikat' => 'nullable|string|max:100',
            'file_sertifikat_asesor' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'id_asesor.required' => 'ID Asesor tidak boleh kosong',
            'status_asesor.required' => 'Status asesor harus dipilih',
            'status_asesor.in' => 'Status asesor tidak valid',
            'masa_berlaku.required' => 'Tanggal masa berlaku harus diisi',
            'masa_berlaku.date' => 'Format tanggal masa berlaku tidak valid',
            'kode_registrasi.max' => 'Kode registrasi maksimal 100 karakter',
            'no_sertifikat.max' => 'Nomor sertifikat maksimal 100 karakter',
            'file_sertifikat_asesor.file' => 'File sertifikat tidak valid',
            'file_sertifikat_asesor.mimes' => 'File sertifikat harus berformat PDF, JPG, JPEG, atau PNG',
            'file_sertifikat_asesor.max' => 'Ukuran file sertifikat maksimal 2MB',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.pengguna.index')
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Cari asesor berdasarkan ID
            $asesor = Asesor::find($request->id_asesor);
            
            if (!$asesor) {
                return redirect()->route('admin.pengguna.index')
                    ->with('error', 'Asesor tidak ditemukan');
            }
            
            // Update bidang kompetensi
            $bidangKompetensiIds = [];
            if ($request->filled('bidang_kompetensi')) {
                $bidangKompetensiIds = json_decode($request->bidang_kompetensi, true);
            }
            
            // Upload file sertifikat jika ada
            $fileSertifikat = $asesor->file_sertifikat_asesor;
            if ($request->hasFile('file_sertifikat_asesor')) {
                // Hapus file lama jika ada
                if ($fileSertifikat && Storage::exists('public/sertifikat_asesor/' . $fileSertifikat)) {
                    Storage::delete('public/sertifikat_asesor/' . $fileSertifikat);
                }
                
                $file = $request->file('file_sertifikat_asesor');
                $fileName = 'asesor_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sertifikat_asesor', $fileName);
                $fileSertifikat = $fileName;
            }
            
            // Update data asesor
            $asesor->update([
                'status_asesor' => $request->status_asesor,
                'masa_berlaku' => $request->masa_berlaku,
                'daftar_bidang_kompetensi' => json_encode($bidangKompetensiIds),
                'kode_registrasi' => $request->kode_registrasi,
                'no_sertifikat' => $request->no_sertifikat,
                'file_sertifikat_asesor' => $fileSertifikat
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data asesor berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating asesor data: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal memperbarui data asesor: ' . $e->getMessage());
        }
    }

    
    /**
     * Ambil data sertifikat kompetensi teknis asesor
     */
    public function getSertifikat($id)
    {
        try {
            $asesor = Asesor::findOrFail($id);
            $sertifikat = KompetensiTeknis::where('id_asesor', $id)->get();
            
            return response()->json($sertifikat);
        } catch (\Exception $e) {
            Log::error('Error fetching sertifikat data: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
 * Menampilkan detail asesor
 */
    public function detail($id)
    {
        try {
            // Cari asesor berdasarkan ID
            $asesor = Asesor::findOrFail($id);
            
            // Get bidang kompetensi data
            $bidangKompetensiData = BidangKompetensi::all()->keyBy('id_bidang_kompetensi');
            
            // Parse bidang kompetensi
            $bidangKompetensiList = [];
            if (!empty($asesor->daftar_bidang_kompetensi)) {
                $bidangIds = json_decode($asesor->daftar_bidang_kompetensi, true);
                
                foreach ($bidangIds as $idBidang) {
                    if (isset($bidangKompetensiData[$idBidang])) {
                        $bidangKompetensiList[] = [
                            'id' => $idBidang,
                            'nama_bidang' => $bidangKompetensiData[$idBidang]->nama_bidang
                        ];
                    }
                }
            }
            
            $asesor->bidang_kompetensi = $bidangKompetensiList;
            
            // Get sertifikat kompetensi teknis
            $sertifikat = KompetensiTeknis::where('id_asesor', $id)->get();
            
            return view('home.home-admin.detail-asesor', compact('asesor', 'sertifikat'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal memuat detail asesor: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form kelola kompetensi teknis asesor
     */
    public function kompetensi($id)
    {
        try {
            // Cari asesor berdasarkan ID
            $asesor = Asesor::findOrFail($id);
            
            // Get sertifikat kompetensi teknis
            $sertifikat = KompetensiTeknis::where('id_asesor', $id)->get();
            
            return view('home.home-admin.kompetensi-asesor', compact('asesor', 'sertifikat'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal memuat data kompetensi asesor: ' . $e->getMessage());
        }
    }

    /**
     * Menyimpan sertifikat kompetensi teknis baru
     */
    public function storeSertifikat(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'lembaga_sertifikasi' => 'required|string|max:255',
            'skema_kompetensi' => 'required|string|max:255',
            'masa_berlaku' => 'required|date',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'lembaga_sertifikasi.required' => 'Lembaga sertifikasi tidak boleh kosong',
            'skema_kompetensi.required' => 'Skema kompetensi tidak boleh kosong',
            'masa_berlaku.required' => 'Masa berlaku tidak boleh kosong',
            'masa_berlaku.date' => 'Format tanggal masa berlaku tidak valid',
            'file_sertifikat.file' => 'File sertifikat tidak valid',
            'file_sertifikat.mimes' => 'File sertifikat harus berformat PDF, JPG, JPEG, atau PNG',
            'file_sertifikat.max' => 'Ukuran file sertifikat maksimal 2MB',
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.pengguna.kompetensi', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Cari asesor berdasarkan ID
            $asesor = Asesor::findOrFail($id);
            
            // Upload file sertifikat jika ada
            $fileSertifikat = null;
            if ($request->hasFile('file_sertifikat')) {
                $file = $request->file('file_sertifikat');
                $fileName = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/sertifikat', $fileName);
                $fileSertifikat = $fileName;
            }
            
            // Buat kompetensi teknis baru
            KompetensiTeknis::create([
                'id_asesor' => $asesor->id_asesor,
                'lembaga_sertifikasi' => $request->lembaga_sertifikasi,
                'skema_kompetensi' => $request->skema_kompetensi,
                'masa_berlaku' => $request->masa_berlaku,
                'file_sertifikat' => $fileSertifikat
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.kompetensi', $id)
                ->with('success', 'Sertifikat kompetensi teknis berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding sertifikat: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.kompetensi', $id)
                ->with('error', 'Gagal menambahkan sertifikat: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus sertifikat kompetensi teknis
     */
    public function deleteSertifikat($id, $sertifikatId)
    {
        try {
            DB::beginTransaction();
            
            // Cari sertifikat
            $sertifikat = KompetensiTeknis::findOrFail($sertifikatId);
            
            // Hapus file jika ada
            if ($sertifikat->file_sertifikat) {
                Storage::delete('public/sertifikat/' . $sertifikat->file_sertifikat);
            }
            
            // Hapus data sertifikat
            $sertifikat->delete();
            
            DB::commit();
            
            return redirect()->route('admin.pengguna.kompetensi', $id)
                ->with('success', 'Sertifikat kompetensi teknis berhasil dihapus');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting sertifikat: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.kompetensi', $id)
                ->with('error', 'Gagal menghapus sertifikat: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $bidangKompetensi = BidangKompetensi::all();
        return view('home.home-admin.tambah-pengguna', compact('bidangKompetensi'));
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $validator = Validator::make($request->all(), [
            'user_type' => 'required|in:admin,asesor',
            'email' => [
                'required',
                'email',
                'max:250',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@mail\.ugm\.ac\.id$/'
            ],
            'password' => 'required|min:6|confirmed',
        ], [
            'user_type.required' => 'Jenis pengguna harus dipilih',
            'user_type.in' => 'Jenis pengguna tidak valid',
            'email.required' => 'Email tidak boleh kosong',
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id).',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            if ($request->user_type == 'admin') {
                // Validasi khusus admin
                $validatorAdmin = Validator::make($request->all(), [
                    'no_hp' => 'nullable|string|max:20',
                ], [
                    'no_hp.max' => 'Nomor HP maksimal 20 karakter',
                ]);
                
                if ($validatorAdmin->fails()) {
                    return redirect()->back()
                        ->withErrors($validatorAdmin)
                        ->withInput();
                }
                
                // Buat user admin
                User::create([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'no_hp' => $request->no_hp,
                    'level' => 'admin',
                ]);
                
                $message = 'Admin berhasil ditambahkan';
            } else {
                // Validasi khusus asesor
                $validatorAsesor = Validator::make($request->all(), [
                    'nama_asesor' => 'required|string|max:255',
                    'no_hp_asesor' => 'nullable|string|max:20',
                    'no_ktp' => 'nullable|string|max:20',
                    'kode_registrasi' => 'nullable|string|max:100',
                    'no_sertifikat' => 'nullable|string|max:100',
                    'file_sertifikat_asesor' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                    'status_asesor' => 'required|in:Aktif,Tidak',
                    'masa_berlaku' => 'required|date',
                    'bidang_kompetensi' => 'nullable|string',
                ], [
                    'nama_asesor.required' => 'Nama asesor tidak boleh kosong',
                    'nama_asesor.max' => 'Nama asesor maksimal 255 karakter',
                    'no_hp_asesor.max' => 'Nomor HP maksimal 20 karakter',
                    'no_ktp.max' => 'Nomor KTP maksimal 20 karakter',
                    'kode_registrasi.max' => 'Kode registrasi maksimal 100 karakter',
                    'no_sertifikat.max' => 'Nomor sertifikat maksimal 100 karakter',
                    'file_sertifikat_asesor.file' => 'File sertifikat tidak valid',
                    'file_sertifikat_asesor.mimes' => 'File sertifikat harus berformat PDF, JPG, JPEG, atau PNG',
                    'file_sertifikat_asesor.max' => 'Ukuran file sertifikat maksimal 2MB',
                    'status_asesor.required' => 'Status asesor harus dipilih',
                    'status_asesor.in' => 'Status asesor tidak valid',
                    'masa_berlaku.required' => 'Tanggal masa berlaku wajib diisi',
                    'masa_berlaku.date' => 'Format tanggal masa berlaku tidak valid',
                ]);

                if ($validatorAsesor->fails()) {
                    return redirect()->back()
                        ->withErrors($validatorAsesor)
                        ->withInput();
                }

                // Proses bidang kompetensi
                $bidangKompetensiIds = [];
                if ($request->filled('bidang_kompetensi')) {
                    $bidangKompetensiIds = json_decode($request->bidang_kompetensi, true);
                }

                // Proses upload file sertifikat
                $fileSertifikat = null;
                if ($request->hasFile('file_sertifikat_asesor')) {
                    $file = $request->file('file_sertifikat_asesor');
                    $fileName = 'asesor_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/sertifikat_asesor', $fileName);
                    $fileSertifikat = $fileName;
                }

                // dd('woi'); // Debugging line, remove in production

                // Buat data asesor
                Asesor::create([
                    'nama_asesor' => $request->nama_asesor,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp_asesor,
                    'no_ktp' => $request->no_ktp,
                    'kode_registrasi' => $request->kode_registrasi,
                    'no_sertifikat' => $request->no_sertifikat,
                    'file_sertifikat_asesor' => $fileSertifikat,
                    'status_asesor' => $request->status_asesor,
                    'masa_berlaku' => $request->masa_berlaku,
                    'alamat' => '-', // Required field with default
                    'daftar_bidang_kompetensi' => json_encode($bidangKompetensiIds)
                ]);
                
                $message = 'Asesor berhasil ditambahkan';
            }
            
            DB::commit();
            return redirect()->route('admin.pengguna.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating user: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $bidangKompetensi = BidangKompetensi::all();
        return view('home.home-admin.edit-pengguna', compact('user', 'bidangKompetensi'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('admin.pengguna.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('admin.pengguna.index')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

        /**
     * Update admin user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        // Validasi data
        $rules = [
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users,email,' . $admin->id_user . ',id_user',
                'regex:/^[a-zA-Z0-9._%+-]+@mail\.ugm\.ac\.id$/'
            ],
            'no_hp' => ['required', 'string', 'max:15'],
        ];
        
        $messages = [
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id).',
            'email.required' => 'Email tidak boleh kosong',
            'no_hp.required' => 'Nomor HP tidak boleh kosong',

        ];

        $request->validate($rules, $messages);
        
        // Update data admin
        $admin->email = $request->email;
        $admin->no_hp = $request->no_hp;
        
        $admin->save();
        
        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Data admin berhasil diperbarui');
    }
    
    /**
     * Delete admin user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        // Pastikan tidak menghapus diri sendiri
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan');
        }
        
        $admin->delete();
        
        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}