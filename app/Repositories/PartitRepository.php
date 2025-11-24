<?php

namespace App\Repositories;

use App\Models\Partit;

class PartitRepository implements BaseRepository
{
    public function getAll()
    {
        return Partit::with(['equipLocal', 'equipVisitant'])->get();
    }

    public function find($id)
    {
        return Partit::with(['equipLocal', 'equipVisitant'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Partit::create($data);
    }

    public function update($id, array $data)
    {
        $partit = $this->find($id);
        $partit->update($data);
        return $partit;
    }

    public function delete($id)
    {
        return Partit::destroy($id);
    }
}
