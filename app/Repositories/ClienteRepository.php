<?php

namespace App\Repositories;

use App\Repositories\ClienteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Cliente;

class ClienteRepository implements ClienteRepositoryInterface
{
    private $model;

    public function __construct(Cliente $Cliente)
    {
        $this->model = $Cliente;
    }

    public function getClient(string $id = null) : Collection
    {
        if($id)
            return $this->model->where('id', $id)->get();
        
        return $this->model->all();
    }

    public function create(array $dados) : Cliente
    {
        $this->validarCadastroCliente($dados);
        
        $this->model->nome = $dados['nome'];
        $this->model->telefone = $dados['telefone'];
        $this->model->cpf = $dados['cpf'];
        $this->model->placa = $dados['placa'];
        $this->model->save();

        return $this->model;
    }

    public function update(string $id, array $dados) : Cliente
    {
        $this->validarUpdateCliente($dados);
        $cliente = $this->model->find($id);
        
        if(null === $cliente) {
            throw new \Exception("Cliente não existe", 401);
        }

        $cliente->nome = $dados['nome'];
        $cliente->telefone = $dados['telefone'];
        $cliente->cpf = $dados['cpf'];
        $cliente->placa = $dados['placa'];
        $cliente->save();
        
        return $cliente;
    }

    public function deletarCliente(string $id) : void
    {
        $cliente = $this->model->find($id);
        $cliente->delete();
    }

    public function getPlaca(string $placa) : Collection
    {
        return $this->model->whereRaw("placa like '%$placa'")->get();
    }

    private function validarCadastroCliente(array $dados) : void
    {
        $verificacao = $this->model->where('cpf', $dados['cpf'])->get();

        if($verificacao->count()) {
            foreach ($verificacao as $key => $value) {
                if($value->placa == $dados['placa'])
                    throw new \Exception("O cliente já possui um veículo cadastrado com a placa {$dados['placa']}", 401);
            }
        }
    }

    private function validarUpdateCliente(array $dados) : void
    {
        $placasClientes = [];
        $verificacao = $this->model->where('placa', $dados['placa'])->get();

        foreach ($verificacao as $key => $value) {
            $placasClientes[$value->cpf][] = $dados['placa'];
        }
        
        if(count($placasClientes) > 0 && !isset($placasClientes[$dados['cpf']])) {
            throw new \Exception("A placa {$dados['placa']} não pode ser utilizada novamente", 401);
        }
    }
}
