<?php

namespace App\Controller\Api;

use App\Entity\Client;
use App\Form\ClientType;
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

    protected function parseRequest($request, Client $client = null): array
    {
        $validator = new ClientValidator();
        $response = ['status' => 0];

        if (!$validator->validate()) {
            $response['errors'] = $validator->getErrors();
        } else {
            $client = $this->prepareClient($request, $client);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            $response['status'] = 1;
        }

        return $response;
    }

    protected function prepareClient($request, $client): Client
    {
        $client->setFirstname($request->request->firstname);
        $client->setLastname($request->request->lastname);
        $client->setNif($request->request->nif);
        $client->setAddress($request->request->address);
        $client->setPostcode($request->request->postcode);
        $client->setCity($request->request->city);
        $client->setState($request->request->state);
        $client->setCountry($request->request->country);
        $client->setEmail($request->request->email);

        $now = date('Y-m-d H:i:s');
        $client->setUpdated($now);
        if (!$client->getCreated) {
            $client->setCreated($now);
        }

        return $client;
    }
}
