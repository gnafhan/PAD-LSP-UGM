<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\Event;;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\RincianAsesmen;



class AdminController extends Controller
{
    public function index()
    {
        // Basic dashboard stats
        $events = Event::all()->count();
        $asesi = Asesi::all()->count();
        $skema = Skema::all()->count();
        $asesor = Asesor::all()->count();

        // Get skema statistics per period-year
        $skemaStats = RincianAsesmen::getSkemaStats();

        // ASESI CHART DATA
        $asesiSkemaData = RincianAsesmen::getAsesiSkemaDistributionData();
        $asesiYearData = RincianAsesmen::getAsesiYearTrendData();
        $asesiPeriodData = RincianAsesmen::getAsesiPeriodTrendData();

        // SKEMA CHART DATA
        $skemaPopularityData = RincianAsesmen::getSkemaPopularityData();
        $skemaYearData = RincianAsesmen::getSkemaYearTrendData();
        $skemaPeriodData = RincianAsesmen::getSkemaPeriodTrendData();

        return view('home.home-admin.home', compact(
            'events',
            'asesi',
            'skema',
            'asesor',
            'skemaStats',
            'asesiSkemaData',
            'asesiYearData',
            'asesiPeriodData',
            'skemaPopularityData',
            'skemaYearData',
            'skemaPeriodData'
        ));
    }

}
