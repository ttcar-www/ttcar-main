<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return mixed
     */
    public function findTenLast()
    {
        return $this->createQueryBuilder('j')
            ->orderBy('j.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return mixed
     */
    public function findAllByDate()
    {
        return $this->createQueryBuilder('j')
            ->orderBy('j.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
