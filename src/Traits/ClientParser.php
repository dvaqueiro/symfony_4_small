<?php

namespace App\Traits;

trait ClientParser
{
    protected function parseRequest(Request $request, Client $client = null): array
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
