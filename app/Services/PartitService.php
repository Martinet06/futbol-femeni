<?php

namespace App\Services;

use App\Repositories\PartitRepository;

class PartitService
{
    public function __construct(private PartitRepository $repo) {}

    public function llistar()
    {
        return $this->repo->getAll();
    }

    public function trobar($id)
    {
        return $this->repo->find($id);
    }

    public function guardar(array $data)
    {
        return $this->repo->create($data);
    }

    public function actualitzar($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function eliminar($id)
    {
        return $this->repo->delete($id);
    }

    // NOU: Mètode per calcular la classificació
    public function classificacio()
    {
        $partits = $this->repo->getAll();
        $equips = \App\Models\Equip::all();

        $stats = [];

        foreach ($equips as $equip) {
            $partitsEquip = $partits->filter(function ($partit) use ($equip) {
                return ($partit->equip_local_id === $equip->id || $partit->equip_visitant_id === $equip->id)
                    && $partit->gols_local !== null
                    && $partit->gols_visitant !== null;
            });

            $golsFavor = 0;
            $golsContra = 0;
            $punts = 0;
            $guanyats = 0;
            $empatats = 0;
            $perduts = 0;

            foreach ($partitsEquip as $partit) {
                if ($partit->equip_local_id === $equip->id) {
                    $golsFavor += $partit->gols_local;
                    $golsContra += $partit->gols_visitant;

                    if ($partit->gols_local > $partit->gols_visitant) {
                        $punts += 3;
                        $guanyats++;
                    } elseif ($partit->gols_local === $partit->gols_visitant) {
                        $punts += 1;
                        $empatats++;
                    } else {
                        $perduts++;
                    }
                } else {
                    $golsFavor += $partit->gols_visitant;
                    $golsContra += $partit->gols_local;

                    if ($partit->gols_visitant > $partit->gols_local) {
                        $punts += 3;
                        $guanyats++;
                    } elseif ($partit->gols_visitant === $partit->gols_local) {
                        $punts += 1;
                        $empatats++;
                    } else {
                        $perduts++;
                    }
                }
            }

            $stats[] = [
                'id' => $equip->id,
                'nom' => $equip->nom,
                'partits_jugats' => $partitsEquip->count(),
                'partits_guanyats' => $guanyats,
                'partits_empatats' => $empatats,
                'partits_perduts' => $perduts,
                'gols_favor' => $golsFavor,
                'gols_contra' => $golsContra,
                'diferencia' => $golsFavor - $golsContra,
                'punts' => $punts,
            ];
        }

        // Ordenar per punts i després per diferència de gols
        usort($stats, function ($a, $b) {
            if ($b['punts'] !== $a['punts']) {
                return $b['punts'] - $a['punts'];
            }
            return $b['diferencia'] - $a['diferencia'];
        });

        return collect($stats);
    }
}
