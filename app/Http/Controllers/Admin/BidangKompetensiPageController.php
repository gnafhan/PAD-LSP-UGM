<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BidangKompetensi;
use Illuminate\Http\Request;

class BidangKompetensiPageController extends Controller
{
    public function indexDataBidangKompetensi(Request $request)
    {
        $query = BidangKompetensi::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('nama_bidang', 'like', "%{$search}%");
        }

        $bidangList = $query->latest()->paginate(10);
        $totalBidang = BidangKompetensi::count();

        return view('home.home-admin.bidang-kompetensi', [
            'bidangList' => $bidangList,
            'totalBidang' => $totalBidang,
        ]);
    }

    public function createDataBidangKompetensi()
    {
        return view('home.home-admin.tambah-bidang-kompetensi');
    }

    public function storeDataBidangKompetensi(Request $request)
    {
        $validated = $request->validate([
            'nama_bidang' => 'required|string|max:60',
        ]);

        try {
            BidangKompetensi::create($validated);
            return redirect()->route('admin.bidang-kompetensi.index')->with('success', 'Bidang Kompetensi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan Bidang Kompetensi: ' . $e->getMessage())->withInput();
        }
    }

    public function editDataBidangKompetensi($id)
    {
        $bidang = BidangKompetensi::findOrFail($id);
        return view('home.home-admin.edit-bidang-kompetensi', [
            'bidang' => $bidang,
        ]);
    }

    public function updateDataBidangKompetensi(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_bidang' => 'required|string|max:60',
        ]);

        try {
            $bidang = BidangKompetensi::findOrFail($id);
            $bidang->update($validated);

            return redirect()->route('admin.bidang-kompetensi.index')->with('success', 'Bidang Kompetensi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui Bidang Kompetensi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroyDataBidangKompetensi($id)
    {
        try {
            $bidang = BidangKompetensi::findOrFail($id);
            $bidang->delete();
            return redirect()->route('admin.bidang-kompetensi.index')->with('success', 'Bidang Kompetensi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus Bidang Kompetensi: ' . $e->getMessage());
        }
    }
}
