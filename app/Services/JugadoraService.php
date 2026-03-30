<?php

namespace App\Services;

use App\Repositories\JugadoraRepository;

class JugadoraService
{
    public function __construct(private JugadoraRepository $repo) {}

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

    public function actualitzar($jugadora, array $data)
    {
        $id = is_object($jugadora) ? $jugadora->id : $jugadora;
        return $this->repo->update($id, $data);
    }

    public function eliminar($id)
    {
        return $this->repo->delete($id);
    }
}
