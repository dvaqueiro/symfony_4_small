<?php

namespace App\Infrastructure\Client;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Domain\Client\ClientRepository;
use App\Domain\Client\Client;
use App\Infraestructure\Client\Client as DoctrineClient;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineClientRepository extends ServiceEntityRepository implements ClientRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findOneById($id): ?Client
    {
        return $this->findById($id);
    }

    public function findOneByEmail($emal): ?Client
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function getAll($orderBy = null, $limit = null, $offset = null) : array
    {
        return $this->findBy([], $orderBy, $limit, $offset);
    }

    public function getByParam($criteria, $orderBy = null, $limit = null, $offset = null) : array
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }

//    /**
//     * @return Client[] Returns an array of Client objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
