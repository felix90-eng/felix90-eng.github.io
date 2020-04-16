<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    // /**
    //  * @return Vehicle[] Returns an array of Vehicle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    
    
public function customUpdate($cname,$tname,$pno,$telno,$tstyle,$id)
{
    $entityManager = $this->getEntityManager();

    $conn = $this->getEntityManager()->getConnection();

   $query ="SELECT * FROM tbl_vehicles v JOIN car_trip c ON(v.destination_id =c.id) WHERE v.id ={$id}";
   $stmt = $conn->prepare($query);
     $stmt->execute();
     //$result =$stmt->fetch()

   $amount ='';
   $totalAmount ='';
   while ($row =$stmt->fetch()) {
       # code...
    $amount =$row['amountprice'];
    $totalAmount = (float)$amount * (float)$row['tripdays'];
   }
    

    $sql = "
        UPDATE tbl_vehicles SET tripamount='$amount',totalamount ='$totalAmount',companyname=:cname,transportername=:tname,platno =:pno,ttelephone=:telno,transporterstyle=:tstyle
        ,status ='assigned' WHERE id =:id
        ";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':cname'=>$cname,':tname'=>$tname,':pno'=>$pno,':telno'=>$telno,':tstyle'=>$tstyle,':id'=>$id]);
    //echo $sql;

    // returns an array of arrays (i.e. a raw data set)
    return $stmt;
}

public function transportCost()
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT v.id,v.arrivaltime,c.trip,v.totalamount FROM tbl_vehicles v
            JOIN car_trip c ON(v.destination_id=c.id)
            JOIN staffs s ON(v.staff_id=s.id)
            WHERE v.status ='assigned'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
}
public function transportTotalCost()
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT  SUM(v.totalamount) AS total FROM tbl_vehicles v
            JOIN car_trip c ON(v.destination_id=c.id)
            JOIN staffs s ON(v.staff_id=s.id)
            WHERE v.status ='assigned'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();
}
}
