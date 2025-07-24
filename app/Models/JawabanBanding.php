<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanBanding extends Model
{
    use HasFactory;

    protected $table = 'jawaban_banding';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_pertanyaan_banding',
        'id_rincian_asesmen',
        'jawaban',
    ];

    public function jawab_true_false($id_pertanyaan_banding, $jawaban, $id_rincian_asesmen){
        $pertanyaan = PertanyaanBanding::find($id_pertanyaan_banding);
        if($pertanyaan->jenis_pertanyaan == 'true_false'){
            $this->jawaban = $jawaban;
        } else{
            throw new \Exception('Jenis pertanyaan tidak valid');
        }
        $this->id_pertanyaan_banding = $id_pertanyaan_banding;
        $this->id_rincian_asesmen = $id_rincian_asesmen;
        $this->save();
    }

    public function jawab_text($id_pertanyaan_banding, $jawaban, $id_rincian_asesmen){
        $pertanyaan = PertanyaanBanding::find($id_pertanyaan_banding);
        if($pertanyaan->jenis_pertanyaan == 'text'){
            $this->jawaban = $jawaban;
        } else{
            throw new \Exception('Jenis pertanyaan tidak valid');
        }
        $this->id_pertanyaan_banding = $id_pertanyaan_banding;
        $this->id_rincian_asesmen = $id_rincian_asesmen;
        $this->save();
    }

    public function pertanyaan_banding(): BelongsTo
    {
        return $this->belongsTo(PertanyaanBanding::class, 'id_pertanyaan_banding', 'id');
    }

    public function rincian_asesmen(): BelongsTo
    {
        return $this->belongsTo(RincianAsesmen::class, 'id_rincian_asesmen', 'id_rincian_asesmen');
    }
}
