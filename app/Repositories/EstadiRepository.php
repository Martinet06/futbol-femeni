<?php

namespace App\Repositories;

use App\Models\Estadi;

class EstadiRepository implements BaseRepository
{
    public function getAll()
    {
        return Estadi::all();
    }

    public function find($id)
    {
        return Estadi::find($id);
    }

    public function create(array $data)
    {
        return Estadi::create($data);
    }

    public function update($id, array $data)
    {
        $estadi = Estadi::find($id);
        if ($estadi) {
            $estadi->update($data);
            return $estadi;
        }
        return null;
    }

    public function delete($id)
    {
        $estadi = Estadi::find($id);
        if ($estadi) {
            $estadi->delete();
            return true;
        }
        return false;
    }
}
