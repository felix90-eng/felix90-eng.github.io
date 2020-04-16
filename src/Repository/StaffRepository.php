<?php

namespace App\Repository;

use App\Entity\Staff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Staff|null find($id, $lockMode = null, $lockVersion = null)
 * @method Staff|null findOneBy(array $criteria, array $orderBy = null)
 * @method Staff[]    findAll()
 * @method Staff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Staff::class);
    }

    public function login($user,$pass)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM staffs s
            JOIN user u 
            ON (s.id= u.staff_id)
            WHERE
             s.user_name=:user and s.password=:pass
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user'=>$user,':pass'=>$pass]);

        //$no=$stmt->rowCount();

    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt;
}

    // /**
    //  * @return Staff[] Returns an array of Staff objects
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
    public function findOneBySomeField($value): ?Staff
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
