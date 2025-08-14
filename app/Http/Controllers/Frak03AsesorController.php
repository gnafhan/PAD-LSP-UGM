<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Frak03AsesorController extends Controller
{

    /**
     * Show the FR.AK.03 detail form for a specific asesi.
     *
     * @param  string  $id The ID of the asesi.
     * @return \Illuminate\View\View
     */
    public function showDetail($id)
    {
        return view('home.home-asesor.frak03-asesor-detail', ['asesiId' => $id]);
    }
}