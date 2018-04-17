<?php
namespace App\Domain\User;

use App\Domain\User\User;

interface UserRepository
{
    public function findOneById($id): ?User;

    public function findOneByEmail($emal): ?User;
}
