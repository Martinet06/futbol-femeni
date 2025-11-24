<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partit extends Model
{
    use HasFactory;

    protected $table = 'partits';
    protected $fillable = [
        'equip_local_id',
        'equip_visitant_id',
        'data_partit',
        'gols_local',
        'gols_visitant',
    ];

    public function equipLocal()
    {
        return $this->belongsTo(Equip::class, 'equip_local_id');
    }

    public function equipVisitant()
    {
        return $this->belongsTo(Equip::class, 'equip_visitant_id');
    }
}
