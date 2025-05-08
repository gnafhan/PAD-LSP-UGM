<?php

namespace App\Http\Controllers\Admin\ManajemenTUK;

use App\Http\Controllers\Controller;
use App\Models\PenanggungJawab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class PenanggungJawabController extends Controller
{
    /**
     * Show create form for a new Penanggung Jawab
     */
    public function create()
    {
        return view('home.home-admin.tuk.create-pj');
    }

    /**
     * Store a newly created Penanggung Jawab
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penanggung_jawab' => 'required|string|max:255',
            'status_penanggung_jawab' => 'required|in:Aktif,Tidak',
        ], [
            'nama_penanggung_jawab.required' => 'Nama Penanggung Jawab tidak boleh kosong',
            'status_penanggung_jawab.required' => 'Status Penanggung Jawab harus dipilih',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        
        try {
            DB::beginTransaction();
            
            PenanggungJawab::create([
                'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
                'status_penanggung_jawab' => $request->status_penanggung_jawab,
            ]);
            
            DB::commit();
            return redirect()->route('admin.tuk.index')
                ->with('success', 'Penanggung Jawab berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Penanggung Jawab: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan Penanggung Jawab: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show Penanggung Jawab edit form
     */
    public function edit($id)
    {
        $pj = PenanggungJawab::findOrFail($id);
        return view('home.home-admin.tuk.edit-pj', compact('pj'));
    }

    /**
     * Update Penanggung Jawab
     */
    public function update(Request $request, $id)
    {
        $pj = PenanggungJawab::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nama_penanggung_jawab' => 'required|string|max:255',
            'status_penanggung_jawab' => 'required|in:Aktif,Tidak',
        ], [
            'nama_penanggung_jawab.required' => 'Nama Penanggung Jawab tidak boleh kosong',
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
                'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
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