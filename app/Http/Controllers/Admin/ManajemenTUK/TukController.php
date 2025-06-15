<?php

namespace App\Http\Controllers\Admin\ManajemenTUK;

use App\Http\Controllers\Controller;
use App\Models\TUK;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TukController extends Controller
{
    /**
     * Display the TUK management page
     */
    public function index(Request $request)
    {
        // Get search query
        // Query dasar untuk TUK
        $tukQuery = TUK::query();
        
        // Query dasar untuk Penanggung Jawab
        $pjQuery = PenanggungJawab::query();
        
        // Terapkan filter untuk TUK saja
        if ($request->has('tuk_search') && !empty($request->tuk_search)) {
            $search = $request->tuk_search;
            $tukQuery->where(function($query) use ($search) {
                $query->where('nama_tuk', 'like', "%{$search}%")
                    ->orWhere('kode_tuk', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        
        // Terapkan filter untuk Penanggung Jawab saja
        if ($request->has('pj_search') && !empty($request->pj_search)) {
            $search = $request->pj_search;
            $pjQuery->where(function($query) use ($search) {
                $query->where('nama_penanggung_jawab', 'like', "%{$search}%");
            });
        }
        
        // Ambil data dengan filter masing-masing
        $tuk = $tukQuery->paginate(10, ['*'], 'tuk_page');
        $penanggungJawab = $pjQuery->paginate(10, ['*'], 'pj_page');
            
        // Get statistics
        $totalTuk = TUK::count();
        $totalPj = PenanggungJawab::count();
        
        return view('home.home-admin.tuk.index', compact(
            'totalTuk', 
            'totalPj', 
            'tuk',
            'penanggungJawab'
        ));
    }

    /**
     * Show the form for creating a new TUK
     */
    public function create()
    {
        // Check if there are any penanggung jawab available
        $penanggungJawab = PenanggungJawab::where('status_penanggung_jawab', 'Aktif')->get();
        
        if ($penanggungJawab->isEmpty()) {
            return redirect()->route('admin.tuk.index')
                ->with('error', 'Anda perlu menambahkan Penanggung Jawab terlebih dahulu sebelum membuat TUK.');
        }
        
        return view('home.home-admin.tuk.create', compact('penanggungJawab'));
    }

    /**
     * Store a newly created TUK
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_tuk' => 'required|string|max:20|unique:tuk',
            'nama_tuk' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_penanggung_jawab' => 'required|exists:penanggung_jawab,id_penanggung_jawab',
            'no_lisensi_skkn' => 'nullable|string|max:100',
        ], [
            'kode_tuk.required' => 'Kode TUK tidak boleh kosong',
            'kode_tuk.unique' => 'Kode TUK sudah digunakan',
            'nama_tuk.required' => 'Nama TUK tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'id_penanggung_jawab.required' => 'Penanggung Jawab harus dipilih',
            'id_penanggung_jawab.exists' => 'Penanggung Jawab yang dipilih tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            TUK::create([
                'kode_tuk' => $request->kode_tuk,
                'nama_tuk' => $request->nama_tuk,
                'alamat' => $request->alamat,
                'id_penanggung_jawab' => $request->id_penanggung_jawab,
                'no_lisensi_skkn' => $request->no_lisensi_skkn,
            ]);
            
            DB::commit();
            return redirect()->route('admin.tuk.index')
                ->with('success', 'TUK berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating TUK: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan TUK: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the TUK
     */
    public function edit($id)
    {
        $tuk = TUK::findOrFail($id);
        $penanggungJawab = PenanggungJawab::where('status_penanggung_jawab', 'Aktif')->get();
        
        return view('home.home-admin.tuk.edit', compact('tuk', 'penanggungJawab'));
    }

    /**
     * Update the TUK
     */
    public function update(Request $request, $id)
    {
        $tuk = TUK::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'kode_tuk' => 'required|string|max:20|unique:tuk,kode_tuk,'.$id.',id_tuk',
            'nama_tuk' => 'required|string|max:255',
            'alamat' => 'required|string',
            'id_penanggung_jawab' => 'required|exists:penanggung_jawab,id_penanggung_jawab',
            'no_lisensi_skkn' => 'nullable|string|max:100',
        ], [
            'kode_tuk.required' => 'Kode TUK tidak boleh kosong',
            'kode_tuk.unique' => 'Kode TUK sudah digunakan',
            'nama_tuk.required' => 'Nama TUK tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'id_penanggung_jawab.required' => 'Penanggung Jawab harus dipilih',
            'id_penanggung_jawab.exists' => 'Penanggung Jawab yang dipilih tidak valid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            $tuk->update([
                'kode_tuk' => $request->kode_tuk,
                'nama_tuk' => $request->nama_tuk,
                'alamat' => $request->alamat,
                'id_penanggung_jawab' => $request->id_penanggung_jawab,
                'no_lisensi_skkn' => $request->no_lisensi_skkn,
            ]);
            
            DB::commit();
            return redirect()->route('admin.tuk.index')
                ->with('success', 'TUK berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating TUK: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui TUK: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show Penanggung Jawab edit form
     */
    public function editPj($id)
    {
        $pj = PenanggungJawab::findOrFail($id);
        return view('home.home-admin.tuk.edit-pj', compact('pj'));
    }

    /**
     * Update Penanggung Jawab
     */
    public function updatePj(Request $request, $id)
    {
        $pj = PenanggungJawab::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nama_pananggung_jawab' => 'required|string|max:255',
            'status_penanggung_jawab' => 'required|in:Aktif,Tidak Aktif',
        ], [
            'nama_pananggung_jawab.required' => 'Nama Penanggung Jawab tidak boleh kosong',
            'status_penanggung_jawab.required' => 'Status Penanggung Jawab harus dipilih',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            $pj->update([
                'nama_pananggung_jawab' => $request->nama_pananggung_jawab,
                'status_penanggung_jawab' => $request->status_penanggung_jawab,
            ]);
            
            DB::commit();
            return redirect()->route('admin.tuk.index')
                ->with('success', 'Penanggung Jawab berhasil diperbarui');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Penanggung Jawab: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui Penanggung Jawab: ' . $e->getMessage())
                ->withInput();
        }
    }
}