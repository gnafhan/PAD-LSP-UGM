<?php

namespace App\Http\Controllers\Admin\ManajemenEvent;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Asesi;
use App\Models\Skema;
use App\Models\TUK;
use App\Models\Asesor;
use App\Models\RincianAsesmen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function indexDataEvent(Request $request)
    {
        $today = Carbon::now()->toDateString();
        
        // Query with search capabilities
        $eventQuery = Event::with('tuk');
        
        // Apply search if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $eventQuery->where(function($query) use ($search) {
                $query->where('nama_event', 'like', "%{$search}%")
                    ->orWhere('tipe_event', 'like', "%{$search}%")
                    ->orWhereHas('tuk', function($q) use ($search) {
                        $q->where('nama_tuk', 'like', "%{$search}%");
                    });
            });
        }
        
        // Paginate the results (10 per page)
        $event = $eventQuery->latest('tanggal_mulai_event')->paginate(10);
        
        // Calculate statistics
        $totalEvent = Event::count();
        $activeEvent = Event::where('tanggal_mulai_event', '<=', $today)
                           ->where('tanggal_berakhir_event', '>=', $today)
                           ->count();
        $completedEvent = Event::where('tanggal_berakhir_event', '<', $today)->count();

        return view('home.home-admin.event2', compact('event', 'totalEvent', 'activeEvent', 'completedEvent'));
    }

    public function createDataEvent()
    {
        $skemaList = Skema::all();
        $tukList = Tuk::all();
        
        return view('home.home-admin.tambah-event', [
            'skemaList' => $skemaList,
            'tukList' => $tukList
        ]);
    }
    
    public function storeDataEvent(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tipe_event' => 'required|string|max:100',
            'id_tuk' => 'required|exists:tuk,id_tuk',
            'tanggal_mulai_event' => 'required|date',
            'tanggal_berakhir_event' => 'required|date|after_or_equal:tanggal_mulai_event',
            'periode_pelaksanaan' => 'required|integer|min:1|max:4',
            'tahun_pelaksanaan' => 'required|integer|min:2000|max:2099',
        ]);
        
        DB::beginTransaction();
        try {
            // Create event
            $event = new Event();
            $event->nama_event = $request->nama_event;
            $event->tipe_event = $request->tipe_event;
            $event->id_tuk = $request->id_tuk;
            $event->tanggal_mulai_event = $request->tanggal_mulai_event;
            $event->tanggal_berakhir_event = $request->tanggal_berakhir_event;
            $event->periode_pelaksanaan = $request->periode_pelaksanaan;
            $event->tahun_pelaksanaan = $request->tahun_pelaksanaan;
            $event->save();
            
            DB::commit();
            return redirect()->route('admin.event.index')->with('success', 'Event berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan event: ' . $e->getMessage())->withInput();
        }
    }
    
    public function editDataEvent($id)
    {
        $event = Event::with('tuk')->findOrFail($id);
        $tukList = Tuk::all();
        $skemaList = Skema::all();
        
        return view('home.home-admin.edit-event', [
            'event' => $event,
            'tukList' => $tukList,
            'skemaList' => $skemaList
        ]);
    }
    
    public function updateDataEvent(Request $request, $id)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tipe_event' => 'required|string|max:100',
            'id_tuk' => 'required|exists:tuk,id_tuk',
            'tanggal_mulai_event' => 'required|date',
            'tanggal_berakhir_event' => 'required|date|after_or_equal:tanggal_mulai_event',
            'periode_pelaksanaan' => 'required|integer|min:1|max:4',
            'tahun_pelaksanaan' => 'required|integer|min:2000|max:2099',
        ]);
        
        DB::beginTransaction();
        try {
            // Update event
            $event = Event::findOrFail($id);
            $event->nama_event = $request->nama_event;
            $event->tipe_event = $request->tipe_event;
            $event->id_tuk = $request->id_tuk;
            $event->tanggal_mulai_event = $request->tanggal_mulai_event;
            $event->tanggal_berakhir_event = $request->tanggal_berakhir_event;
            $event->periode_pelaksanaan = $request->periode_pelaksanaan;
            $event->tahun_pelaksanaan = $request->tahun_pelaksanaan;
            $event->save();
            
            
            DB::commit();
            return redirect()->route('admin.event.index')->with('success', 'Event berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui event: ' . $e->getMessage())->withInput();
        }
    }
    
    
    public function detailEvent($id)
    {
        // Find the event
        $event = Event::findOrFail($id);
        
        // Get all rincian_asesmen for this event
        $rincianAsesmens = RincianAsesmen::where('id_event', $id)->get();
        
        // Get unique asesi IDs from rincian_asesmen
        $asesiIds = $rincianAsesmens->pluck('id_asesi')->unique();
        
        // Get unique asesor IDs from rincian_asesmen
        $asesorIds = $rincianAsesmens->pluck('id_asesor')->unique();
        
        // Get asesi data with their skema and asesor
        $asesis = Asesi::with(['skema', 'asesor'])
            ->whereIn('id_asesi', $asesiIds)
            ->get();
        
        // Count unique skemas from all asesis
        $uniqueSkemaIds = $asesis->pluck('id_skema')->unique();
        $uniqueSkemaCount = $uniqueSkemaIds->count();
        
        // Get skema statistics: ID, name, and count of asesi per skema
        $skemas = Skema::whereIn('id_skema', $uniqueSkemaIds)
            ->withCount(['asesi' => function($query) use ($asesiIds) {
                $query->whereIn('id_asesi', $asesiIds);
            }])
            ->get();
        
        // Replace this section in detailEvent() method
        $asesors = Asesor::whereIn('id_asesor', $asesorIds)
            ->with(['rincianAsesmen' => function($query) use ($asesiIds) {
                $query->whereIn('id_asesi', $asesiIds);
            }])
            ->get();

        // Add a computed property for counting asesi
        $asesors = $asesors->map(function($asesor) {
            $asesor->asesi_count = $asesor->rincianAsesmen->count();
            return $asesor;
        });
        
        // Counts for overview cards
        $asesiCount = $asesiIds->count();
        $asesorCount = $asesorIds->count();
        
        return view('home.home-admin.event-detail', compact(
            'event', 
            'skemas', 
            'asesis', 
            'asesors',
            'uniqueSkemaCount',
            'asesiCount', 
            'asesorCount'
        ));
    }
}