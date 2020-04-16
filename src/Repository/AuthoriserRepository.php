<?php

namespace App\Repository;

use App\Entity\Authoriser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Authoriser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Authoriser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Authoriser[]    findAll()
 * @method Authoriser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthoriserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Authoriser::class);
    }

    // /**
    //  * @return Authoriser[] Returns an array of Authoriser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Authoriser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
