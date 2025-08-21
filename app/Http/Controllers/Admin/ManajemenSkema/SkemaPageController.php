<?php

namespace App\Http\Controllers\Admin\ManajemenSkema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skema;
use App\Models\UK;
use App\Models\UKBidang;
use App\Models\BidangKompetensi;
use App\Models\Asesi;
use Illuminate\Support\Facades\Log;

class SkemaPageController extends Controller
{
    public function indexDataSkema(Request $request)
    {
        $query = Skema::query();
        
        // Add search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_skema', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_skema', 'LIKE', "%{$search}%");
        }

        $totalAsesi = Asesi::count();
        
        // Apply sorting (default by newest)
        $query->orderBy('created_at', 'desc');
        
        // Paginate results
        $skema = $query->paginate(5);
        
        return view('home.home-admin.skema', compact('skema', 'totalAsesi'));
    }
    

    public function editDataSkema($id)
    {
        $skema = Skema::findOrFail($id);
        $ukList = UK::all();
        $daftarBidangUK = UKBidang::all();
        $bidangKompetensis = BidangKompetensi::all();
        // Get unit kompetensi using the method instead of relationship
        $unitKompetensi = $skema->getUnitKompetensi();
        $unitKompetensiJson = json_encode($unitKompetensi);
        $daftarIdUkJson = $skema->daftar_id_uk; // Ambil data daftar_id_uk langsung dari skema

        return view('home.home-admin.edit-skema', [
            'skema' => $skema,
            'unitKompetensiJson' => $unitKompetensiJson,
            'daftarIdUkJson' => $daftarIdUkJson,
            'ukList' => $ukList,
            'daftarBidangUK' => $daftarBidangUK,
            'bidangKompetensis' => $bidangKompetensis,
        ]);
    }

    public function updateDataSkema(Request $request, $id)
    {
        try {
            $skema = Skema::findOrFail($id);

            $validatedData = $request->validate([
                'nama_skema' => 'required|string|max:100',
                'dokumen_skkni' => 'nullable|file|mimes:pdf',
                'id_bidang_kompetensi' => 'nullable|integer|exists:bidang_kompetensi,id_bidang_kompetensi',
            ]);

            $skema->nama_skema = $validatedData['nama_skema'];
            $skema->id_bidang_kompetensi = $request->input('id_bidang_kompetensi');

            if ($request->hasFile('dokumen_skkni')) {
                $fileName = 'skkni_' . str_replace(' ', '_', $validatedData['nama_skema']) . '.' . $request->file('dokumen_skkni')->getClientOriginalExtension();
                $filePath = $request->file('dokumen_skkni')->storeAs('public/skkni', $fileName);
                $skema->dokumen_skkni = 'skkni/' . $fileName;
            }

            $skema->daftar_id_uk = $request->input('daftar_id_uk');

            $skema->save();

            return redirect()->route('admin.skema.index')->with('success', 'Skema berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (\Illuminate\Http\Exceptions\PostTooLargeException $e) {
            Log::error('File Too Large Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ukuran file terlalu besar. Maksimal 2MB.')->withInput();

        } catch (\Exception $e) {
            Log::error('Error updating skema: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui skema.')->withInput();
        }
    }
    public function createDataSkema()
    {
        $daftarBidangUK = UKBidang::all();
        $ukList = UK::all();
        $bidangKompetensis = BidangKompetensi::all();
        return view('home.home-admin.tambah-skema', ['ukList' => $ukList, 'daftarBidangUK' => $daftarBidangUK, 'bidangKompetensis' => $bidangKompetensis]);
    }
    
    public function storeDataSkema(Request $request)
    {
        $idUKsInput = json_decode($request->daftar_id_uk, true);
        
        // Validate that at least one UK is selected
        if (empty($idUKsInput)) {
            return redirect()->back()
                ->withErrors(['daftar_id_uk' => 'Minimal 1 Unit Kompetensi harus dipilih.'])
                ->withInput();
        }
        
        $idUKs = [];

        foreach ($idUKsInput as $idUK) {
            // dd($kodeUK);
            $uk = UK::where('id_uk', $idUK)->first();

            if ($uk) {
                $idUKs[] = $uk->id_uk;
            } else {
                return redirect()->back()->withErrors(['kode_uk' => "Kode UK $idUK tidak ditemukan."]);
            }
        }

        $validatedData = $request->validate([
            'nomor_skema' => 'required|string|max:100',
            'nama_skema' => 'required|string|max:100',
            'dokumen_skkni' => 'required|file|mimes:pdf',
            'persyaratan_skema' => 'required|string',
            'id_bidang_kompetensi' => 'nullable|integer|exists:bidang_kompetensi,id_bidang_kompetensi',
        ]);

        $validatedData['daftar_id_uk'] = json_encode($idUKs);

        if ($request->hasFile('dokumen_skkni')) {
            $file = $request->file('dokumen_skkni');
            $fileName = 'skkni_' . str_replace(' ', '_', $validatedData['nama_skema']) . '.' . $file->getClientOriginalExtension();

            $validatedData['dokumen_skkni'] = $file->storeAs('skkni', $fileName, 'public');
        } else {
            Log::warning('No file uploaded.');
        }

        Skema::create($validatedData);
        return redirect()->route('admin.skema.index')->with('success', 'Skema berhasil ditambahkan');
    }

}