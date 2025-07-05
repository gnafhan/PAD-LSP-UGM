<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

class HomeController extends Controller
{
    //Method untuk menampilkan data di home admin
    public function index(Request $request)
    {
        $query = Skema::with('unitKompetensi');
        
        // Add search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_skema', 'LIKE', "%{$search}%")
                  ->orWhere('nama_skema', 'LIKE', "%{$search}%")
                  ->orWhere('persyaratan_skema', 'LIKE', "%{$search}%");
            });
        }
        
        $skemaData = $query->get();
        
        // Process each skema to add parsed_persyaratan as a dynamic property
        foreach ($skemaData as $skema) {
            $skema->setAttribute('parsed_persyaratan', 
                array_filter(array_map('trim', explode(',', $skema->persyaratan_skema ?? '')))
            );
        }
        
        return view('home.home-visitor.skema', [
            'skemaData' => $skemaData,
            'searchQuery' => $request->search ?? ''
        ]);
    }
}
