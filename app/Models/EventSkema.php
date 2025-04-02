<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSkema extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_skema';

    /**
     * The primary key for the model.
     * This model uses a composite primary key.
     *
     * @var array
     */
    protected $primaryKey = ['id_event', 'id_skema'];

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_event',
        'id_skema',
    ];

    /**
     * Get the event that this record belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }

    /**
     * Get the skema that this record belongs to.
     */
    public function skema()
    {
        return $this->belongsTo(Skema::class, 'id_skema', 'id_skema');
    }

    /**
     * Set the keys for a save update query.
     * Required for composite primary keys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('id_event', $this->attributes['id_event'])
                    ->where('id_skema', $this->attributes['id_skema']);
    }
}