<?php

namespace App\Repository;

use App\Entity\StationsResacar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StationsResacar|null find($id, $lockMode = null, $lockVersion = null)
 * @method StationsResacar|null findOneBy(array $criteria, array $orderBy = null)
 * @method StationsResacar[]    findAll()
 * @method StationsResacar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationsResacarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StationsResacar::class);
    }

    // /**
    //  * @return StationsResacar[] Returns an array of StationsResacar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StationsResacar
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
