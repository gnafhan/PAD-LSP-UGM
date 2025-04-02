<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use App\Models\AsesiPengajuan;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\UK;
use App\Models\ElemenUK;
use App\Models\TUK;
use App\Models\Event;
use App\Models\UKBidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PeriodeAsesmen;



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
        $skemaStats = PeriodeAsesmen::getSkemaStats();
        
        // ASESI CHART DATA
        $asesiSkemaData = PeriodeAsesmen::getAsesiSkemaDistributionData();
        $asesiYearData = PeriodeAsesmen::getAsesiYearTrendData();
        $asesiPeriodData = PeriodeAsesmen::getAsesiPeriodTrendData();
        
        // SKEMA CHART DATA
        $skemaPopularityData = PeriodeAsesmen::getSkemaPopularityData();
        $skemaYearData = PeriodeAsesmen::getSkemaYearTrendData();
        $skemaPeriodData = PeriodeAsesmen::getSkemaPeriodTrendData();
        
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


    public function indexDataEvent()
    {
        $event = Event::with('skemas')->get();
        $today = Carbon::now()->toDateString();

        // Ambil data asesi yang memiliki id_asesor dan event aktif
        $asesis = Asesi::with(['skema.events', 'asesor'])
            ->whereNotNull('id_asesor') // Hanya yang memiliki id_asesor
            ->whereHas('skema.events', function ($query) use ($today) {
                $query->whereDate('tanggal_mulai_event', '<=', $today)
                    ->whereDate('tanggal_berakhir_event', '>=', $today);
            })
            ->get();

        return view('home.home-admin.event2', compact('event', 'asesis'));
    }

    public function editDataEvent($id)
    {
        $event = Event::with('skemas')->findOrFail($id); // Load relasi skemas dari tabel pivot
        $skemaList = Skema::all();

        return view('home.home-admin.edit-event', [
            'event' => $event,
            'skemaList' => $skemaList,
        ]);
    }

    public function updateDataEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validatedData = $request->validate([
            'nama_event' => 'required|string|max:100',
            'tanggal_mulai_event' => 'required|date',
            'tanggal_berakhir_event' => 'required|date',
            'tuk' => 'required|string|max:100',
            'tipe_event' => 'required|string|max:50',
        ]);

        $event->update($validatedData);

        // Update tabel pivot
        $skemaIds = array_filter(explode(',', $request->input('daftar_id_skema', '')));
        $event->skemas()->sync($skemaIds);

        return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui');
    }

    public function createDataEvent()
    {
        $skemaList = Skema::all();
        return view('home.home-admin.tambah-event', ['skemaList' => $skemaList,]);
    }

    public function storeDataEvent(Request $request)
    {
        try {

            if ($request->has('daftar_id_skema')) {
                $request->merge([
                    'daftar_id_skema' => json_decode($request->input('daftar_id_skema'), true)
                ]);
            }

            $validatedData = $request->validate([
                'nama_event' => 'required|string|max:100',
                'tanggal_mulai_event' => 'required|date',
                'tanggal_berakhir_event' => 'required|date|after_or_equal:tanggal_mulai_event',
                'tuk' => 'required|string|max:100',
                'tipe_event' => 'required|string|max:50',
                'daftar_id_skema' => 'required|array|min:1',
            ]);

            $event = Event::create([
                'nama_event' => $validatedData['nama_event'],
                'tanggal_mulai_event' => $validatedData['tanggal_mulai_event'],
                'tanggal_berakhir_event' => $validatedData['tanggal_berakhir_event'],
                'tuk' => $validatedData['tuk'],
                'tipe_event' => $validatedData['tipe_event'],
            ]);

            // Ambil ID skema dari nomor skema
            $nomorSkemas = $request->input('daftar_id_skema');
            $idSkemas = Skema::whereIn('nomor_skema', $nomorSkemas)->pluck('id_skema');

            // Hubungkan event dengan skema
            $event->skemas()->attach($idSkemas);

            return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error saat menambahkan event: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e,
            ]);

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.']);
        }
    }

    public function destroyDataEvent($id)
    {
        $Event = Event::findOrFail($id);
        $Event->delete();

        return redirect()->route('admin.event.index')->with('success', 'Data event berhasil dihapus.');
    }


}
