<?php

namespace App\Http\Controllers\Admin\ManajemenUnitKompetensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\UK;
use App\Models\UKBidang;
use App\Models\ElemenUK;
use Illuminate\Support\Facades\Validator;


class UnitKompetensiPageController extends Controller
{
    public function indexDataUk(Request $request)
    {
        $query = UK::with('elemen_uk', 'bidang');
        
        // Add search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_uk', 'LIKE', "%{$search}%")
                  ->orWhere('nama_uk', 'LIKE', "%{$search}%");
            });
        }
        
        // Apply sorting (default by newest)
        $query->orderBy('created_at', 'desc');

        $totalBidanguk = UKBidang::count();
        
        // Paginate results
        $uk = $query->paginate(5);
        
        return view('home.home-admin.unit-kompetensi', compact('uk', 'totalBidanguk'));
    }

    public function getUK(Request $request)
    {
        \Log::info("getUK called with id_bidang: " . $request->id_bidang); // Tambahkan log
    
        $uk = UK::with('elemen_uk')
            ->where('id_bidang', $request->id_bidang)
            ->get(['id_uk', 'kode_uk', 'nama_uk']);
    
        \Log::info("Returning UK data: " . count($uk) . " records"); // Tambahkan log
    
        return response()->json($uk);
    }


    public function createDataUk()
    {
        $daftarBidangUK = UKBidang::all();
        return view('home.home-admin.tambah-uk', compact('daftarBidangUK'));
    }

    /**
     * Menyimpan data Unit Kompetensi baru
     */
    public function storeDataUk(Request $request)
    {
        // Check if elemen_uk exists but is empty or contains only empty strings
        if (!$request->has('elemen_uk') || count(array_filter($request->elemen_uk)) == 0) {
            return redirect()->back()
                ->with('error', 'Minimal harus ada satu elemen unit kompetensi.')
                ->withInput();
        }
        
        $validator = Validator::make($request->all(), [
            'kode_uk' => 'required|string|max:100|unique:uk',
            'nama_uk' => 'required|string|max:100',
            'elemen_uk' => 'required|array|min:1',
            'elemen_uk.*' => 'required|string|max:255',
            'id_bidang' => 'required|string|max:20',
            'jenis_standar' => 'required|string|max:50'
        ], [
            'kode_uk.required' => 'Kode unit kompetensi wajib diisi.',
            'kode_uk.unique' => 'Kode unit kompetensi sudah digunakan.',
            'nama_uk.required' => 'Nama unit kompetensi wajib diisi.',
            'elemen_uk.required' => 'Minimal harus ada satu elemen unit kompetensi.',
            'elemen_uk.array' => 'Format data elemen unit kompetensi tidak valid.',
            'elemen_uk.min' => 'Minimal harus ada satu elemen unit kompetensi.',
            'elemen_uk.*.required' => 'Nama elemen tidak boleh kosong.',
            'id_bidang.required' => 'Bidang unit kompetensi wajib dipilih.',
            'jenis_standar.required' => 'Jenis standar wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Terdapat kesalahan pada data yang diinput.')
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();

        // Buat record UK terlebih dahulu
        $uk = UK::create([
            'kode_uk' => $validatedData['kode_uk'],
            'nama_uk' => $validatedData['nama_uk'],
            'id_bidang' => $validatedData['id_bidang'],
            'jenis_standar' => $validatedData['jenis_standar']
        ]);

        // Simpan setiap elemen UK
        foreach ($request->elemen_uk as $elemen) {
            ElemenUK::create([
                'id_uk' => $uk->id_uk,
                'nama_elemen' => $elemen
            ]);
        }

        return redirect()->route('admin.uk.index')->with('success', 'Unit Kompetensi berhasil ditambahkan');
    }

    /**
     * Mempersiapkan form edit Unit Kompetensi
     */
    public function editDataUk($id)
    {
        $daftarBidangUK = UKBidang::all();
        $uk = UK::with('elemen_uk', 'bidang')->findOrFail($id);
        return view('home.home-admin.edit-uk', compact('uk', 'daftarBidangUK'));
    }

    /**
     * Memperbarui data Unit Kompetensi
     */
    public function updateDataUk(Request $request, $id)
    {
        $uk = UK::findOrFail($id);

        $validatedData = $request->validate([
            'kode_uk' => 'required|string|max:100',
            'nama_uk' => 'required|string|max:100',
            'elemen_uk' => 'required|array',
            'elemen_uk.*' => 'required|string|max:255',
            'id_bidang' => 'nullable|string|max:20',
            'jenis_standar' => 'required|string|max:50'
        ]);

        // Update data UK
        $uk->update([
            'kode_uk' => $validatedData['kode_uk'],
            'nama_uk' => $validatedData['nama_uk'],
            'id_bidang' => $validatedData['id_bidang'],
            'jenis_standar' => $validatedData['jenis_standar']
        ]);

        // Hapus semua elemen UK lama
        ElemenUK::where('id_uk', $uk->id_uk)->delete();

        // Simpan elemen UK baru
        foreach ($request->elemen_uk as $elemen) {
            ElemenUK::create([
                'id_uk' => $uk->id_uk,
                'nama_elemen' => $elemen
            ]);
        }

        return redirect()->route('admin.uk.index')->with('success', 'Unit Kompetensi berhasil diperbarui');
    }
}