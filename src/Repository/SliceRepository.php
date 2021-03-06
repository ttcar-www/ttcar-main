<?php

namespace App\Repository;

use App\Entity\Slice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Slice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slice[]    findAll()
 * @method Slice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slice::class);
    }

    /*
    public function findOneBySomeField($value): ?Slice
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
