<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElemenUK extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'elemen_uk';

    /**
     * Primary key tabel.
     *
     * @var string
     */
    protected $primaryKey = 'id_elemen_uk';

    /**
     * Atribut yang dapat diisi (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'id_uk',
        'nama_elemen',
    ];

    /**
     * Relasi ke model UnitKompetensi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unitKompetensi()
    {
        return $this->belongsTo(UK::class, 'id_uk', 'id_uk');
    }

}