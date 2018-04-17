<?php

namespace App\Infrastructure\Client;

use Symfony\Component\HttpFoundation\Request;
use App\Domain\Client\ClientValidator;

trait ClientParser
{
    protected function parseRequest(Request $request, Client $client = null): array
    {
        $validator = new ClientValidator();
        $response = ['status' => 0];

        if (!$validator->validate($request->request->all())) {
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

    protected function prepareClient(Request $request, $client): Client
    {
        $client->setFirstname($request->request->get('firstname'));
        $client->setLastname($request->request->get('lastname'));
        $client->setNif($request->request->get('nif'));
        $client->setAddress($request->request->get('address'));
        $client->setPostcode($request->request->get('postcode'));
        $client->setCity($request->request->get('city'));
        $client->setState($request->request->get('state'));
        $client->setCountry($request->request->get('country'));
        $client->setEmail($request->request->get('email'));

        $now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $client->setUpdated($now);
        if (!$client->getCreated()) {
            $client->setCreated($now);
        }

        return $client;
    }
}
