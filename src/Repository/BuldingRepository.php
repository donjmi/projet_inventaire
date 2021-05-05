<?php

namespace App\Repository;

use App\Entity\Bulding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bulding|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bulding|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bulding[]    findAll()
 * @method Bulding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuldingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bulding::class);
    }

    // /**
    //  * @return Bulding[] Returns an array of Bulding objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bulding
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
