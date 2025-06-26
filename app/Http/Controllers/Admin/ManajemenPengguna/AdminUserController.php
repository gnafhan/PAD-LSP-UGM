<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TandaTanganAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'max:250',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(mail\.ugm\.ac\.id|ugm\.ac\.id)$/'
            ],
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'file_tanda_tangan' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id).',
            'email.unique' => 'Email sudah digunakan',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter',
            'file_tanda_tangan.required' => 'Tanda tangan admin wajib diunggah',
            'file_tanda_tangan.mimes' => 'Format tanda tangan harus jpeg, png, atau jpg',
            'file_tanda_tangan.max' => 'Ukuran file tanda tangan maksimal 2MB',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Buat user admin dengan password acak
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(Str::random(16)), // Random secure password
                'no_hp' => $request->no_hp,
                'level' => 'admin',
            ]);
            
            // Upload dan simpan tanda tangan
            if ($request->hasFile('file_tanda_tangan')) {
                $file = $request->file('file_tanda_tangan');
                $filePath = $file->store('tanda-tangan/admin', 'public');
                
                // Simpan data tanda tangan dengan timestamp
                TandaTanganAdmin::create([
                    'id_user' => $admin->id_user,
                    'file_tanda_tangan' => $filePath,
                    'valid_from' => now(),
                    'valid_until' => null, // Tanda tangan aktif sampai diperbarui
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Admin berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating admin: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan admin: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update admin user.
     */
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users,email,' . $admin->id_user . ',id_user',
                'regex:/^[a-zA-Z0-9._%+-]+@(mail\.ugm\.ac\.id|ugm\.ac\.id)$/'
            ],
            'name' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
            'file_tanda_tangan' => 'nullable|mimes:jpeg,png,jpg,pdf',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.unique' => 'Email sudah digunakan',
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id).',
            'email.required' => 'Email tidak boleh kosong',
            'no_hp.required' => 'Nomor HP tidak boleh kosong',
            'file_tanda_tangan.mimes' => 'Format tanda tangan harus jpeg, png, jpg, atau pdf',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Update data admin
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->no_hp = $request->no_hp;
            $admin->save();
            
            // Update tanda tangan jika ada file baru
            if ($request->hasFile('file_tanda_tangan')) {
                // Nonaktifkan tanda tangan yang aktif saat ini
                TandaTanganAdmin::where('id_user', $admin->id_user)
                    ->whereNull('valid_until')
                    ->update(['valid_until' => now()]);
                
                // Upload dan simpan tanda tangan baru
                $file = $request->file('file_tanda_tangan');
                $filePath = $file->store('tanda-tangan/admin', 'public');
                
                // Simpan data tanda tangan baru dengan timestamp
                TandaTanganAdmin::create([
                    'id_user' => $admin->id_user,
                    'file_tanda_tangan' => $filePath,
                    'valid_from' => now(),
                    'valid_until' => null, // Tanda tangan aktif sampai diperbarui
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Data admin berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating admin: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui admin: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Get current admin signature
     */
    public function getSignature($id)
    {
        try {
            $admin = User::findOrFail($id);
            $signature = $admin->tandaTanganAktif()->first();
            
            return response()->json([
                'success' => true,
                'data' => $signature ? [
                    'file_path' => asset('storage/' . $signature->file_tanda_tangan),
                    'valid_from' => $signature->valid_from->format('d M Y H:i'),
                ] : null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data tanda tangan: ' . $e->getMessage()
            ], 500);
        }
    }
}