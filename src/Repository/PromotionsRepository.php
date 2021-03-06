<?php

namespace App\Repository;

use App\Entity\Promotions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promotions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotions[]    findAll()
 * @method Promotions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Promotions[]    findAllByDate(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotions::class);
    }

    // /**
    //  * @return Promotions[] Returns an array of Promotions objects
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
    public function findOneBySomeField($value): ?Promotions
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Promotions[]
     */
    public function findByDate(string $datej): array
    {

        $qb = $this->createQueryBuilder('p')
        ->where('p.end_date > :datej')
        ->setParameter('datej', $datej);

        $query = $qb->getQuery();
        /*SELECT * FROM App\Entity\Promotions p WHERE p.end_date > NOW*/
        return $query->execute();

    }
}
