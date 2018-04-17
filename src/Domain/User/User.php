<?php
namespace App\Domain\User;

interface User
{

    public function getId(): ?integer;

    public function getName(): ?string;

    public function getLastname(): ?string;

    public function getEmail(): ?string;

    public function getPassword(): ?string;
}
