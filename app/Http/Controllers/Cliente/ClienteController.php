<?php

namespace App\Http\Controllers\Cliente;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ClienteService;

use App\Http\Form\Cliente\CreateClienteFormRequest;
use App\Http\Form\Cliente\UpdateClienteFormRequest;

class ClienteController extends \App\Http\Controllers\Controller
{
    private $service;

    public function __construct(ClienteService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index() : Response
    {
        $response = ['error' => false, 'response' => [], 'message' => ''];
        $code = 200;

        try {
            $response['response'] = $this->service->getClient();
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() > 1 ? $e->getCode() : 500;
        }

        return response($response, $code);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create() : Response
    {
        $response = ['error' => false, 'response' => [], 'message' => 'Clietne cadastrado com sucesso!'];
        $code = 200;

        try {
            $formRequest = app(CreateClienteFormRequest::class);
            $response['response'] = $this->service->create($formRequest->all());
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() > 1 ? $e->getCode() : 500;
        }

        return response($response, $code);
    }
    
    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) : Response
    {
        $response = ['error' => false, 'response' => [], 'message' => ''];
        $code = 200;

        try {
            $idDescriptografado = Crypt::decryptString($id);
            $response['response'] = $this->service->getClient($idDescriptografado);
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() > 1 ? $e->getCode() : 500;
        }

        return response($response, $code);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id) : Response
    {
        $response = ['error' => false, 'response' => [], 'message' => 'Clietne atualizado com sucesso!'];
        $code = 200;

        try {
            $formRequest = app(UpdateClienteFormRequest::class);
            $dados = $formRequest->all();
            $response['response'] = $this->service->update(Crypt::decryptString($id), $dados);
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() > 1 ? $e->getCode() : 500;
        }

        return response($response, $code);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : Response
    {
        $response = ['error' => false, 'response' => [], 'message' => 'Clietne deletado com sucesso!'];
        $code = 200;

        try {
            $this->service->delete(Crypt::decryptString($id));
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() > 1 ? $e->getCode() : 500;
        }

        return response($response, $code);
    }

    /**
     * @param  string  $placa
     * @return \Illuminate\Http\Response
     */
    public function getPlaca($placa)
    {
        $response = ['error' => false, 'response' => [], 'message' => ''];
        $code = 200;

        try {
            $response['response'] = $this->service->getPlaca($placa);
        } catch (\Exception $e) {
            $response['error'] = true;
            $response['message'] = $e->getMessage();
            $code = $e->getCode() > 1 ? $e->getCode() : 500;
        }

        return response($response, $code);
    }
}

