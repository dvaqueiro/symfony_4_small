<?php
namespace App\Domain\Client;

interface Client
{

    public function getId() : ?integer;

    public function getFirstname(): ?string;

    public function getLastname(): ?string;

    public function getNif(): ?string;

    public function getAddress(): ?string;

    public function getPostcode(): ?string;

    public function getCity(): ?string;

    public function getState(): ?string;

    public function getCountry(): ?string;

    public function getEmail(): ?string;

    public function getCreated();

    public function getUpdated();
}
