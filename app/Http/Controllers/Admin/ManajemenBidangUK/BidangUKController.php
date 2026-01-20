<?php

namespace App\Http\Controllers\Admin\ManajemenBidangUK;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UKBidang;
use App\Models\UK;
use Illuminate\Support\Facades\Validator;

class BidangUKController extends Controller
{
    /**
     * Display a listing of bidang UK
     */
    public function index(Request $request)
    {
        $query = UKBidang::query();
        
        // Add search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_bidang', 'LIKE', "%{$search}%");
        }
        
        // Apply sorting (default by newest)
        $query->orderBy('created_at', 'desc');
        
        // Paginate results
        $bidangUK = $query->paginate(10);
        
        // Count total UK for each bidang
        foreach ($bidangUK as $bidang) {
            $bidang->total_uk = UK::where('id_bidang', $bidang->id_bidang)->count();
        }
        
        return view('home.home-admin.bidang-uk.index', compact('bidangUK'));
    }

    /**
     * Show the form for creating a new bidang UK
     */
    public function create()
    {
        return view('home.home-admin.bidang-uk.create');
    }

    /**
     * Store a newly created bidang UK
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_bidang' => 'required|string|max:255|unique:uk_bidang,nama_bidang',
        ], [
            'nama_bidang.required' => 'Nama bidang wajib diisi.',
            'nama_bidang.unique' => 'Nama bidang sudah digunakan.',
            'nama_bidang.max' => 'Nama bidang maksimal 255 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        UKBidang::create([
            'nama_bidang' => $request->nama_bidang,
        ]);

        return redirect()->route('admin.bidang-uk.index')
            ->with('success', 'Bidang Unit Kompetensi berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified bidang UK
     */
    public function edit($id)
    {
        $bidangUK = UKBidang::findOrFail($id);
        $totalUK = UK::where('id_bidang', $id)->count();
        
        return view('home.home-admin.bidang-uk.edit', compact('bidangUK', 'totalUK'));
    }

    /**
     * Update the specified bidang UK
     */
    public function update(Request $request, $id)
    {
        $bidangUK = UKBidang::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_bidang' => 'required|string|max:255|unique:uk_bidang,nama_bidang,' . $id . ',id_bidang',
        ], [
            'nama_bidang.required' => 'Nama bidang wajib diisi.',
            'nama_bidang.unique' => 'Nama bidang sudah digunakan.',
            'nama_bidang.max' => 'Nama bidang maksimal 255 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $bidangUK->update([
            'nama_bidang' => $request->nama_bidang,
        ]);

        return redirect()->route('admin.bidang-uk.index')
            ->with('success', 'Bidang Unit Kompetensi berhasil diperbarui');
    }

    /**
     * Remove the specified bidang UK
     */
    public function destroy($id)
    {
        $bidangUK = UKBidang::findOrFail($id);
        
        // Check if there are any UK associated with this bidang
        $ukCount = UK::where('id_bidang', $id)->count();
        
        if ($ukCount > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus bidang ini karena masih memiliki ' . $ukCount . ' Unit Kompetensi terkait.');
        }

        $bidangUK->delete();

        return redirect()->route('admin.bidang-uk.index')
            ->with('success', 'Bidang Unit Kompetensi berhasil dihapus');
    }
}
