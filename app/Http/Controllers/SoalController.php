<?php

namespace App\Http\Controllers;

use App\Models\Skema;
use App\Models\Soal;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Soal::with('skema');

        // Filter by skema
        if ($request->filled('skema')) {
            $query->where('id_skema', $request->skema);
        }

        // Sorting (default: by created_at desc)
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $soal = $query->orderBy($sortField, $sortOrder)->get(); 

        $skema = Skema::all();

        return view('home.home-admin.soal', compact('soal', 'skema', 'sortField', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skema = Skema::all();
        return view('home.home-admin.create-soal', compact('skema'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_skema' => 'required',
            'pertanyaan' => 'required',
            'jawaban_a' => 'required',
            'jawaban_b' => 'required',
            'jawaban_benar' => 'required',
        ]);

        Soal::create($request->all());

        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $kode_soal)
    {
        $soal = Soal::with('skema')->findOrFail($kode_soal);
        return view('home.home-admin.detail-soal', compact('soal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kode_soal)
    {
        $soal = Soal::findOrFail($kode_soal);
        $skema = Skema::all();
        return view('home.home-admin.edit-soal', compact('soal', 'skema'));
    }

    /**
     * Update the specified resource in storage.
     */

    // Update soal
    public function update(Request $request, string $kode_soal)
    {
        $request->validate([
            'id_skema' => 'required',
            'pertanyaan' => 'required',
            'jawaban_a' => 'required',
            'jawaban_b' => 'required',
            'jawaban_benar' => 'required',
        ]);

        $soal = Soal::findOrFail($kode_soal);
        $soal->update($request->all());

        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil diperbarui!');
    }

    // Hapus soal
    public function destroy(string $kode_soal)
    {
        $soal = Soal::findOrFail($kode_soal);
        $soal->delete();

        return redirect()->route('admin.soal.index')->with('success', 'Soal berhasil dihapus!');
    }
}
