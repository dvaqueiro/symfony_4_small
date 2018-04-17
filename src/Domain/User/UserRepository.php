<?php
namespace App\Domain\User;

interface UserRepository
{
    public function findOneById($id): ?User;

    public function findOneByEmail($emal): ?User;
}
