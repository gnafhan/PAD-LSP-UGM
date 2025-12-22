<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilAsesmen extends Model
{
    use HasFactory;

    protected $table = 'hasil_asesmen';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_rincian_asesmen',
        'status',
        'tanggal_selesai',
    ];

    protected $attributes = [
        'status' => 'belum_ada_hasil',
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
    ];

    public function rincianAsesmen(): BelongsTo
    {
        return $this->belongsTo(RincianAsesmen::class, 'id_rincian_asesmen', 'id_rincian_asesmen');
    }


    // set status kompeten atau tidak kompeten atau belum ada hasil
    public function setStatus($status)
    {
        if($status == 'kompeten' || $status == true){
            $this->status = 'kompeten';
        } else if($status == 'tidak_kompeten' || $status == false){
            $this->status = 'tidak_kompeten';
        } else if($status == 'belum_ada_hasil'){
            $this->status = 'belum_ada_hasil';
        } else {
            throw new \Exception('Status tidak valid');
        }
        $this->save();
    }
}
