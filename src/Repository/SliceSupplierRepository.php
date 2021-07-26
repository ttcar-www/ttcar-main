<?php

namespace App\Repository;

use App\Entity\SliceSupplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SliceSupplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method SliceSupplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method SliceSupplier[]    findAll()
 * @method SliceSupplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SliceSupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SliceSupplier::class);
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
