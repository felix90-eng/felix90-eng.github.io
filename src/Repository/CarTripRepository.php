<?php

namespace App\Repository;

use App\Entity\CarTrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CarTrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarTrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarTrip[]    findAll()
 * @method CarTrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarTripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarTrip::class);
    }

    // /**
    //  * @return CarTrip[] Returns an array of CarTrip objects
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
    public function findOneBySomeField($value): ?CarTrip
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
