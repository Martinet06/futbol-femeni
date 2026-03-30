<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Model EQUIP
 */
class Equip extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['nom', 'estadi_id', 'titols', 'escut', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estadi()
    {
        return $this->belongsTo(Estadi::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function manager()
    {
        return $this->hasOne(User::class);
    }

    public function jugadores()
    {
        return $this->hasMany(Jugadora::class);
    }

    public function partitsLocal()
    {
        return $this->hasMany(Partit::class, 'equip_local_id');
    }

    public function partitsVisitant()
    {
        return $this->hasMany(Partit::class, 'equip_visitant_id');
    }


    public function edatMitjana()
    {
        $jugadores = $this->jugadores()->get();

        if ($jugadores->isEmpty()) {
            return null; // si no hi ha jugadores
        }

        $totalEdats = 0;
        $count = 0;

        foreach ($jugadores as $jugadora) {
            if ($jugadora->data_naixement) {
                $edat = Carbon::parse($jugadora->data_naixement)->age;
                $totalEdats += $edat;
                $count++;
            }
        }

        return $count > 0 ? round($totalEdats / $count, 1) : null;
    }


    public function ultimsPartits($limit = 5)
    {
        return Partit::where('equip_local_id', $this->id)
            ->orWhere('equip_visitant_id', $this->id)
            ->orderByDesc('data_partit')
            ->limit($limit)
            ->get();
    }
}
