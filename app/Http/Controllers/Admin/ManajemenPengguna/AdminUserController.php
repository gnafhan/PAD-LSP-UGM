<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        return view('home.home-admin.tambah-admin');
    }

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
            'no_hp' => 'nullable|string|max:20',
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id atau @ugm.ac.id).',
            'email.unique' => 'Email sudah digunakan',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Buat user admin dengan password acak
            User::create([
                'email' => $request->email,
                'password' => bcrypt(Str::random(16)), // Random secure password
                'no_hp' => $request->no_hp,
                'level' => 'admin',
            ]);
            
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
                'regex:/^[a-zA-Z0-9._%+-]+@mail\.ugm\.ac\.id$/'
            ],
            'no_hp' => ['required', 'string', 'max:15'],
        ], [
            'email.regex' => 'Email harus menggunakan email resmi UGM (@mail.ugm.ac.id).',
            'email.required' => 'Email tidak boleh kosong',
            'no_hp.required' => 'Nomor HP tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            // Update data admin
            $admin->email = $request->email;
            $admin->no_hp = $request->no_hp;
            $admin->save();
            
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
     * Delete admin user.
     */
    public function destroy($id)
    {
        try {
            $admin = User::findOrFail($id);
            
            // Pastikan tidak menghapus diri sendiri
            if ($admin->id === auth()->id()) {
                return redirect()->route('admin.pengguna.index')
                    ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan');
            }
            
            $admin->delete();
            
            return redirect()->route('admin.pengguna.index')
                ->with('success', 'Admin berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error deleting admin: ' . $e->getMessage());
            
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Gagal menghapus admin: ' . $e->getMessage());
        }
    }
}