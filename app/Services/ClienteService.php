<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use App\Repositories\ClienteRepositoryInterface;
use App\Cliente;

class ClienteService
{
    private $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepositoryInterface)
    {
        $this->clienteRepository = $clienteRepositoryInterface;
    }
    
    public function getClient(string $id = null) : array
    {
        $response = array();
        $clientes = $this->clienteRepository->getClient($id);

        foreach ($clientes as $key => $value) {
            $response[] = [
                'id'           => Crypt::encryptString($value->id),
                'nome'         => $value->nome,
                'telefone'     => $value->telefone,
                'cpf'          => $value->cpf,
                'placa'        => $value->placa,
                'dataCadastro' => \Carbon\Carbon::parse($value->created_at)->format('Y-m-d h:i:s')
            ];
        }

        if($id !== null) return $response[0];

        return $response;
    }

    public function create(array $dados) : array
    {
        $dados = $this->trataParametrosData($dados);
        $cliente = $this->clienteRepository->create($dados);
        return $this->trataRetornoDadosCliete($cliente);
    }

    public function update(string $id, array $dados) : array
    {
        $dados = $this->trataParametrosData($dados);
        $cliente = $this->clienteRepository->update($id, $dados);
        return $this->trataRetornoDadosCliete($cliente);
    }

    public function delete(string $id) : void
    {
        $this->clienteRepository->deletarCliente($id);
    }

    public function getPlaca(string $placa) : array
    {
        $response = array();
        $placa = preg_replace('/[^A-Za-z0-9\-]/', '', $placa);
        $clientes = $this->clienteRepository->getPlaca($placa);
        
        foreach ($clientes as $key => $value) {
            $response[] = [
                'id'           => Crypt::encryptString($value->id),
                'nome'         => $value->nome,
                'telefone'     => $value->telefone,
                'cpf'          => $value->cpf,
                'placa'        => $value->placa,
                'dataCadastro' => \Carbon\Carbon::parse($value->created_at)->format('Y-m-d h:i:s')
            ];
        }

        return $response;
    }

    private function trataParametrosData(array $dados) : array
    {
        $dados['cpf'] = preg_replace('/[^A-Za-z0-9\-]/', '', $dados['cpf']);
        $dados['placa'] = preg_replace('/[^A-Za-z0-9\-]/', '', $dados['placa']);
        $dados['telefone'] = preg_replace('/[^A-Za-z0-9\-]/', '', $dados['telefone']);
        return $dados;
    }

    private function trataRetornoDadosCliete(Cliente $cliente) : array
    {
        return [
            'id'           => Crypt::encryptString($cliente->id),
            'nome'         => $cliente->nome,
            'telefone'     => $cliente->telefone,
            'cpf'          => $cliente->cpf,
            'placa'        => $cliente->placa,
            'dataCadastro' => \Carbon\Carbon::parse($cliente->created_at)->format('Y-m-d h:i:s')
        ];
    }
}
