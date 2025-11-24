<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model EQUIP
 */
class Jugadora extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $table = 'jugadores';
    protected $fillable = ['nom', 'equip_id', 'data_naixement', 'dorsal', 'foto'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equip()
    {
        return $this->belongsTo(Equip::class);
    }
}
