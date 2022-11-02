<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Cliente;

interface ClienteRepositoryInterface
{
    public function getClient(string $id = null) : Collection;
    public function create(array $dados) : Cliente;
    public function update(string $id, array $dados) : Cliente;
    public function deletarCliente(string $id) : void;
    public function getPlaca(string $placa) : Collection;
}
