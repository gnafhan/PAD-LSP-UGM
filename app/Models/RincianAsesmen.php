<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class RincianAsesmen extends Model
{
    use HasFactory;

    protected $table = 'rincian_asesmen';
    protected $primaryKey = 'id_rincian_asesmen';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'id_event',
        'banding_date',
    ];

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
    
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
    
    public function jawaban_banding(): HasMany
    {
        return $this->hasMany(JawabanBanding::class, 'id_rincian_asesmen', 'id_rincian_asesmen');
    }

    public function fria07()
    {
        return $this->hasOne(Fria07::class, 'id_rincian_asesmen', 'id_rincian_asesmen');
    }

    /**
     * Get skema statistics grouped by periode and tahun
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function getSkemaStats()
    {
        return DB::table('rincian_asesmen as ra')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->join('skema as s', 'a.id_skema', '=', 's.id_skema')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->select(
                's.id_skema',
                's.nama_skema',
                'e.periode_pelaksanaan as periode',
                'e.tahun_pelaksanaan as tahun',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('s.id_skema', 's.nama_skema', 'e.periode_pelaksanaan', 'e.tahun_pelaksanaan')
            ->orderBy('e.tahun_pelaksanaan', 'desc')
            ->orderBy('e.periode_pelaksanaan', 'desc')
            ->orderBy('s.nama_skema')
            ->get();
    }
    
    /**
     * Get data for skema distribution chart
     * 
     * @return array
     */
    public static function getSkemaChartData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->join('skema as s', 'a.id_skema', '=', 's.id_skema')
            ->select(
                's.nama_skema',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('s.nama_skema')
            ->orderBy('jumlah_asesi', 'desc')
            ->limit(10)
            ->get();
            
        $labels = $data->pluck('nama_skema')->toArray();
        $values = $data->pluck('jumlah_asesi')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $values
        ];
    }
    
    /**
     * Get data for trend chart
     * 
     * @return array
     */
    public static function getTrendChartData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->select(
                DB::raw("CONCAT('P', e.periode_pelaksanaan, ' ', e.tahun_pelaksanaan) as periode_tahun"),
                DB::raw('COUNT(ra.id_asesi) as jumlah_asesi')
            )
            ->groupBy('e.tahun_pelaksanaan', 'e.periode_pelaksanaan', 'periode_tahun')
            ->orderBy('e.tahun_pelaksanaan')
            ->orderBy('e.periode_pelaksanaan')
            ->limit(10)
            ->get();
            
        $labels = $data->pluck('periode_tahun')->toArray();
        $values = $data->pluck('jumlah_asesi')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $values
        ];
    }
    
    /**
     * Get data for year chart
     * 
     * @return array
     */
    public static function getYearChartData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->select(
                'e.tahun_pelaksanaan as tahun',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('e.tahun_pelaksanaan')
            ->orderBy('e.tahun_pelaksanaan', 'asc')
            ->get();
            
        $labels = $data->pluck('tahun')->toArray();
        $values = $data->pluck('jumlah_asesi')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $values
        ];
    }

    /**
     * Get data for period chart
     * 
     * @return array
     */
    public static function getPeriodChartData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->select(
                'e.periode_pelaksanaan as periode',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('e.periode_pelaksanaan')
            ->orderBy('e.periode_pelaksanaan', 'asc')
            ->get();
            
        // Format the period labels (e.g., "Periode 1")
        $labels = $data->map(function($item) {
            return "Periode " . $item->periode;
        })->toArray();
        
        $values = $data->pluck('jumlah_asesi')->toArray();
        
        return [
            'labels' => $labels,
            'data' => $values
        ];
    }
    
    /**
     * Get data for Asesi distribution by Skema (Chart 1)
     */
    public static function getAsesiSkemaDistributionData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->join('skema as s', 'a.id_skema', '=', 's.id_skema')
            ->select('s.nama_skema', DB::raw('COUNT(a.id_asesi) as jumlah_asesi'))
            ->groupBy('s.nama_skema')
            ->orderBy('jumlah_asesi', 'desc')
            ->limit(10)
            ->get();
            
        return [
            'labels' => $data->pluck('nama_skema')->toArray(),
            'data' => $data->pluck('jumlah_asesi')->toArray()
        ];
    }

    /**
     * Get data for Asesi trend by year (Chart 2)
     */
    public static function getAsesiYearTrendData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->select('e.tahun_pelaksanaan as tahun', DB::raw('COUNT(ra.id_asesi) as jumlah_asesi'))
            ->groupBy('e.tahun_pelaksanaan')
            ->orderBy('e.tahun_pelaksanaan')
            ->get();
            
        return [
            'labels' => $data->pluck('tahun')->toArray(),
            'data' => $data->pluck('jumlah_asesi')->toArray()
        ];
    }

    /**
     * Get data for Asesi trend by period (Chart 3)
     */
    public static function getAsesiPeriodTrendData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->select('e.periode_pelaksanaan as periode', DB::raw('COUNT(ra.id_asesi) as jumlah_asesi'))
            ->groupBy('e.periode_pelaksanaan')
            ->orderBy('e.periode_pelaksanaan')
            ->get();
            
        // Format period labels
        $labels = $data->map(function($item) {
            return "Periode {$item->periode}";
        })->toArray();
        
        return [
            'labels' => $labels,
            'data' => $data->pluck('jumlah_asesi')->toArray()
        ];
    }

    /**
     * Get data for Skema popularity (Chart 4)
     */
    public static function getSkemaPopularityData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->join('skema as s', 'a.id_skema', '=', 's.id_skema')
            ->select('s.nama_skema', DB::raw('COUNT(a.id_asesi) as jumlah_asesi'))
            ->groupBy('s.nama_skema')
            ->orderBy('jumlah_asesi', 'desc')
            ->limit(5)
            ->get();
            
        return [
            'labels' => $data->pluck('nama_skema')->toArray(),
            'data' => $data->pluck('jumlah_asesi')->toArray()
        ];
    }

    /**
     * Get data for Skema trend by year (Chart 5)
     */
    public static function getSkemaYearTrendData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->select('e.tahun_pelaksanaan as tahun', DB::raw('COUNT(DISTINCT a.id_skema) as jumlah_skema'))
            ->groupBy('e.tahun_pelaksanaan')
            ->orderBy('e.tahun_pelaksanaan')
            ->get();
            
        return [
            'labels' => $data->pluck('tahun')->toArray(),
            'data' => $data->pluck('jumlah_skema')->toArray()
        ];
    }

    /**
     * Get data for Skema trend by period (Chart 6)
     */
    public static function getSkemaPeriodTrendData()
    {
        $data = DB::table('rincian_asesmen as ra')
            ->join('event as e', 'ra.id_event', '=', 'e.id_event')
            ->join('asesi as a', 'ra.id_asesi', '=', 'a.id_asesi')
            ->select('e.periode_pelaksanaan as periode', DB::raw('COUNT(DISTINCT a.id_skema) as jumlah_skema'))
            ->groupBy('e.periode_pelaksanaan')
            ->orderBy('e.periode_pelaksanaan')
            ->get();
            
        // Format period labels
        $labels = $data->map(function($item) {
            return "Periode {$item->periode}";
        })->toArray();
        
        return [
            'labels' => $labels,
            'data' => $data->pluck('jumlah_skema')->toArray()
        ];
    }
}