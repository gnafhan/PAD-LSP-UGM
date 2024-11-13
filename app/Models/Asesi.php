
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesi extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = ['nama', 'tanggal', 'event', 'skema'];
}
