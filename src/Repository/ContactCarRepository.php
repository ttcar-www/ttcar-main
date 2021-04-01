<?php

namespace App\Repository;

use App\Entity\ContactCars;
use App\Entity\ContactContactCars;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactCars|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactCars|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactCars[]    findAll()
 * @method ContactCars[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactCarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactCars::class);
    }

    // /**
    //  * @return ContactCars[] Returns an array of ContactCars objects
    //  */
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
    public function findOneBySomeField($value): ?ContactCars
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
