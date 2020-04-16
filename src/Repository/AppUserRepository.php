<?php

namespace App\Repository;

use App\Entity\AppUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AppUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppUser[]    findAll()
 * @method AppUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppUser::class);
    }

    // /**
    //  * @return AppUser[] Returns an array of AppUser objects
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
    public function findOneBySomeField($value): ?AppUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    
public function customUpdate($colValue,$id)
{
    $entityManager = $this->getEntityManager();

    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        UPDATE tbl_appusers SET role_id ='$colValue' WHERE id =$id
        ";

      
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //echo $sql;

    // returns an array of arrays (i.e. a raw data set)
    return $stmt;
}

public function login($email,$pass)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "
            SELECT * FROM tbl_appusers 
            WHERE email ='$email' AND password='$pass'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();

}


public function positionIdByName($post)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "
            SELECT id FROM positions
            WHERE position ='$post'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

}
public function departmentIdByName($dept)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "
            SELECT id FROM departments
            WHERE department ='$dept'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

}
}
