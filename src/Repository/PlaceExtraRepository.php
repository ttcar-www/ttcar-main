<?php

namespace App\Repository;

use App\Entity\PlaceExtra;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlaceExtra|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlaceExtra|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlaceExtra[]    findAll()
 * @method PlaceExtra[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceExtraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlaceExtra::class);
    }

    // /**
    //  * @return PlaceExtra[] Returns an array of PlaceExtra objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlaceExtra
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
