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
    ];

    public function rincianAsesmen(): BelongsTo
    {
        return $this->belongsTo(RincianAsesmen::class, 'id_rincian_asesmen', 'id_rincian_asesmen');
    }


    // set status kompeten atau tidak kompeten
    public function setStatus($status)
    {
        if($status == 'kompeten' || $status == true){
            $this->status = 'kompeten';
        } else if($status == 'tidak_kompeten' || $status == false){
            $this->status = 'tidak_kompeten';
        } else {
            throw new \Exception('Status tidak valid');
        }
        $this->save();
    }
}
