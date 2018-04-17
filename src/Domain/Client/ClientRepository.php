<?php
namespace App\Domain\Client;

use Client;

interface ClientRepository
{
    public function findOneById($id): ?Client;

    public function findOneByEmail($emal): ?Client;

    public function getAll($orderBy = null, $limit = null, $offset = null) : array;

    public function getByParam($criteria, $orderBy = null, $limit = null, $offset = null) : array;
}
