<?php

namespace App\Repositories;

use App\Models\Jugadora;

class JugadoraRepository implements BaseRepository
{


    public function getAll()
    {
        return Jugadora::with('equip')->get();
    }

    public function find($id)
    {
        return Jugadora::with('equip')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Jugadora::create($data);
    }

    public function update($id, array $data)
    {
        //dd($data);
        $jugadora = $this->find($id);
        $jugadora->update($data);
        return $jugadora;
    }

    public function delete($id)
    {
        return Jugadora::destroy($id);
    }
}
