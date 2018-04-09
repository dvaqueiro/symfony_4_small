<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Validator\ClientValidator;

class ClientController extends Controller
{
    public function index(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();
        //TODO: Eliminar los índices en el array de clientes
        return $this->json(['status' => 1, 'clients' => $clients]);
    }

    public function show(Request $request, ClientRepository $clientRepository, $id): Response
    {
        $client = $clientRepository->findById($id);
        return $this->json(['status' => 1, 'clients' => $client]);
    }

    public function add(Request $request): Response
    {
        $client = new Client();
        $response = $this->parseRequest($request, $client);
        return $this->json($response);
    }

    public function edit(Request $request, Client $client): Response
    {
        $response = $this->parseRequest($request, $client);
        return $this->json($response);
    }

    public function delete(Request $request, Client $client): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();
        $response = ['status' => 1];
        return $this->json($response);
    }

    use \App\Traits\ClientParser;
}
