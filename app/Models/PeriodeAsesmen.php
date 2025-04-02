<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class PeriodeAsesmen extends Model
{
    use HasFactory;

    protected $table = 'periode_asesmen';
    protected $primaryKey = 'id_periode_asesmen';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_asesi',
        'id_asesor',
        'periode',
        'tahun',
    ];

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class, 'id_asesi', 'id_asesi');
    }
    
    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class, 'id_asesor', 'id_asesor');
    }
    
    /**
     * Get skema statistics grouped by periode and tahun
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function getSkemaStats()
    {
        return DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
            ->join('skema as s', 'a.id_skema', '=', 's.id_skema')
            ->select(
                's.id_skema',
                's.nama_skema',
                'pa.periode',
                'pa.tahun',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('s.id_skema', 's.nama_skema', 'pa.periode', 'pa.tahun')
            ->orderBy('pa.tahun', 'desc')
            ->orderBy('pa.periode', 'desc')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
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
        $data = DB::table('periode_asesmen as pa')
            ->select(
                DB::raw("CONCAT('P', periode, ' ', tahun) as periode_tahun"),
                DB::raw('COUNT(id_asesi) as jumlah_asesi')
            )
            ->groupBy('tahun', 'periode', 'periode_tahun')
            ->orderBy('tahun')
            ->orderBy('periode')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
            ->select(
                'pa.tahun',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('pa.tahun')
            ->orderBy('pa.tahun', 'asc')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
            ->select(
                'pa.periode',
                DB::raw('COUNT(a.id_asesi) as jumlah_asesi')
            )
            ->groupBy('pa.periode')
            ->orderBy('pa.periode', 'asc')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
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
        $data = DB::table('periode_asesmen')
            ->select('tahun', DB::raw('COUNT(id_asesi) as jumlah_asesi'))
            ->groupBy('tahun')
            ->orderBy('tahun')
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
        $data = DB::table('periode_asesmen')
            ->select('periode', DB::raw('COUNT(id_asesi) as jumlah_asesi'))
            ->groupBy('periode')
            ->orderBy('periode')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
            ->select('pa.tahun', DB::raw('COUNT(DISTINCT a.id_skema) as jumlah_skema'))
            ->groupBy('pa.tahun')
            ->orderBy('pa.tahun')
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
        $data = DB::table('periode_asesmen as pa')
            ->join('asesi as a', 'pa.id_asesi', '=', 'a.id_asesi')
            ->select('pa.periode', DB::raw('COUNT(DISTINCT a.id_skema) as jumlah_skema'))
            ->groupBy('pa.periode')
            ->orderBy('pa.periode')
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