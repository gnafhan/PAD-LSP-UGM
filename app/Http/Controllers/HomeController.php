<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skema;

class HomeController extends Controller
{
    public function index()
    {
        $skemaData = Skema::with('unitKompetensi')->get();

        // Format data persyaratan_skema menjadi array
        foreach ($skemaData as $skema) {
            $skema->parsed_persyaratan = explode(',', $skema->persyaratan_skema);
        }

        return view('home.home-visitor.skema', ['skemaData' => $skemaData]);
    }
}
