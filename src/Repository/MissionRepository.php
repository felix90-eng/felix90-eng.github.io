<?php

namespace App\Repository;

use App\Entity\Mission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Smission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Smission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Smission[]    findAll()
 * @method Smission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    // /**
    //  * @return Smission[] Returns an array of Smission objects
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


    public function findOneByAllowance($position,$location)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM tbl_allowances a
            JOIN positions p ON(a.level_id=p.level_id)
            JOIN levels l ON(p.level_id=l.id)
            JOIN locations lo ON(a.zone_id=lo.zone_id)
            WHERE p.position =:position AND lo.location=:location
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([':position' => $position,':location' => $location]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
}

public function getExpenses()
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

            $sql = '
            SELECT e.allowance,SUM(e.allowance) AS expense,e.created_at,s.first_name,s.last_name FROM tbl_expenses e
            JOIN tbl_missions m ON(e.mission_id=m.id)
            JOIN staffs s ON(m.staff_id=s.id)
            WHERE e.status ="authorized"
            ';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
}
public function getExpensesFilter($from,$to)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

             $sql = "
            SELECT e.allowance,SUM(e.allowance) AS expense,e.created_at,s.first_name,s.last_name FROM tbl_expenses e
            JOIN tbl_missions m ON(e.mission_id=m.id)
            JOIN staffs s ON(m.staff_id=s.id)
            WHERE e.status ='authorized' AND e.created_at BETWEEN '$from' AND '$to'
            ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
}
public function missionAllowanceUpdate($expense,$id)
{
    $entityManager = $this->getEntityManager();

    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        UPDATE tbl_missions SET tallowance =:allowance WHERE id =:id
        ';
    $stmt = $conn->prepare($sql);
    $stmt->execute([":allowance"=>$expense,":id"=>$id]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt;
}
public function findHosted()
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM tbl_allowances a
            WHERE a.d1_num_day >0 OR a.d2_num_day >0 OR a.d3_num_day >0 OR a.d4_num_day >0
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

}

public function findStaffDepartment($userid)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT * FROM staffs s
            WHERE s.user_id ='$userid'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

}

public function findMissionsByUser($id)
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT m.id,m.leaved_at,m.returned_at,m.d1_id_num_day,m.d2_id_num_day ,m.d3_id_num_day ,m.d4_id_num_day,
            m.num_days,m.mis_category,m.mis_purpose,m.tallowance,m.mean_trans,l.location ,m.mstatus,s.first_name,s.last_name
            FROM tbl_missions m
            JOIN staffs s ON (m.staff_id=s.id)
            JOIN locations l ON (m.destination1_id =l.id OR m.destination2_id =l.id OR m.destination3_id =l.id OR m.destination4_id =l.id)
            WHERE m.staff_id ='$id'
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        echo $sql;
        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();

}

public function missionApproval($column,$colValue,$id,$staff=null)
{
    $entityManager = $this->getEntityManager();

    $conn = $this->getEntityManager()->getConnection();


      if($staff!=null){
        $sql = "
        UPDATE tbl_expenses SET status ='authorized' WHERE staff_id =$staff
        ";
      }
      $sql = "
      UPDATE tbl_missions SET $column ='$colValue' WHERE id =$id
      ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //echo $sql;

    // returns an array of arrays (i.e. a raw data set)
    return $stmt;
}

public function currentStaffIn()
{

    $currDate = date('Y-m-d');
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
    SELECT DISTINCT m.id,m.leaved_at,m.returned_at,m.d1_id_num_day,m.d2_id_num_day ,m.d3_id_num_day ,m.d4_id_num_day,
    m.num_days,m.mis_purpose,m.destination1_id ,m.mstatus,s.first_name,s.last_name ,m.tallowance
    FROM tbl_missions m
    LEFT JOIN staffs s ON(m.staff_id=s.id)
     WHERE  m.decision_from_dg='approved' AND m.mstatus='Pending' AND m.returned_at >$currDate
        ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    //echo $sql;

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();

}

public function getBySupervisor()
    {
        $entityManager = $this->getEntityManager();

        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT DISTINCT m.id,m.leaved_at,m.returned_at,m.d1_id_num_day,m.d2_id_num_day ,m.d3_id_num_day ,m.d4_id_num_day,
            m.num_days,m.mis_purpose,m.destination1_id ,m.mstatus,sup.name, m.id,COUNT(m.staff_id) AS noOfStaff ,SUM(tallowance) AS total
            FROM tbl_missions m
            LEFT JOIN staffs s ON(m.staff_id=s.id)
            LEFT JOIN tbl_supervisors sup ON(m.supervisor_id=sup.id)
             WHERE  m.verified_by_accountant='verified' AND m.mstatus='Pending'
            GROUP BY name
            ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
}

}
