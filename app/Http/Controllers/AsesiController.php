<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\AsesiPengajuan;

class AsesiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('home.home-asesi.home-asesi', compact('user'));
    }



}
