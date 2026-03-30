<?php

namespace App\Services;

use App\Repositories\EstadiRepository;

class EstadiService
{
    public function __construct(private EstadiRepository $repo) {}

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

    public function actualitzar($estadi, array $data)
    {
        return $this->repo->update($estadi->id, $data);
    }

    public function eliminar($id)
    {
        return $this->repo->delete($id);
    }
}
