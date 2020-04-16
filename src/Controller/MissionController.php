<?php

namespace App\Controller;
use App\Entity\Department;
use App\Entity\Expense;
use App\Entity\Mission;
use App\Form\MissionType;
use App\Entity\Staff;
use App\Entity\Location;
use App\Entity\Position;
use App\Entity\Supervisor;
use App\Repository\AuthenticationRepository;
use App\Repository\DepartmentRepository;
use App\Repository\LocationRepository;
use App\Repository\MissionRepository;
use App\Repository\PositionRepository;
use App\Repository\StaffRepository;
use App\Repository\SupervisorRepository;
use App\Repository\VehicleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class MissionController extends AbstractController
{

    /**
     * @Route("/missions", name="mission_index", methods={"GET"})
     */
    public function index(MissionRepository $missionRepository,SessionInterface $session): Response
    {


        switch($session->get('validUser')){
           case 'ADMIN':
               # code...
               return $this->render('mission/index.html.twig', ['missions' => $missionRepository->findAll(),]);

               break;
               case 'SUPERVISOR':
                   # code...

                    $dpart= $missionRepository->findStaffDepartment($session->get('userId'));
                    $did ='';
                    foreach($dpart as $d){
                    $did= $d['department_id'];
                    }

                    // echo $did.'kkkkkkkkk';

                            return $this->render('mission/index.html.twig', [
                                'missions' => $missionRepository->findBy(['department'=>$did,'lineSupervisorChecked'=>'pending','mstatus'=>'Pending']),
                            ]);

                   break;
                   case 'ACCOUNTANT':
                       # code...

                       return $this->render('mission/index.html.twig', [
                        'missions' => $missionRepository->findBy(['lineSupervisorChecked'=>'accepted','verifiedByAccountant'=>'pending','mstatus'=>'Pending']),
                    ]);
                 break;
                 case 'DG':
                     # code...
                     $loc =$missionRepository->findBy(['verifiedByAccountant'=>'verified','mstatus'=>'Pending']);
                         //variables initialization
                     $loc1 ='';
                     $loc2 ='';
                     $loc3 ='';
                     $loc4 ='';
                     foreach ($loc as $key => $value) {
                         # code...
                         $loc1 =$value->getDestination1().' ' .$value->getD1IdNumDay();
                         $loc2 =$value->getDestination2().' ' .$value->getD2IdNumDay();
                         $loc3 =$value->getDestination3().' ' .$value->getD3IdNumDay();
                         $loc4 =$value->getDestination4().' ' .$value->getD4IdNumDay();

                     }
                     $locaArr =[$loc1,$loc2,$loc3,$loc4];
                     return $this->render('mission/index.html.twig', [
                        'missions' => $missionRepository->findBy(['verifiedByAccountant'=>'verified','mstatus'=>'Pending']),
                        'options' => $missionRepository->getBySupervisor(),'location'=>$locaArr,
                    ]);
                     break;
                     case 'DAF':
                         # code...
                         return $this->render('mission/index.html.twig', [
                            'missions' => $missionRepository->findBy(['decisionFromDG'=>'approved']),
                        ]);
                         break;
                         case 'CSDM':
                             # code...

                             return $this->render('mission/index.html.twig', [
                                'missions' => $missionRepository->findBy(['approvalOfCSDM'=>'csdm_decision']),
                            ]);
                             break;
                             case 'USER':
                                 # code...
                                 return $this->render('mission/index.html.twig', [
                                    'missions' => $missionRepository->findBy(['mstatus'=>'approved'],['id'=>'desc']),
                                ]);
                                 break;


        }

          //echo $session->get('validUser');


        return new Response();

        }

          /**
     * @Route("/missions/{id}", name="mission_approval", methods={"GET"})
     */
    public function approval(MissionRepository $missionRepository, SessionInterface $session,$id): Response
    {
        switch($session->get('validUser')){
            case 'ADMIN':
                # code...

                return $this->render('mission/index.html.twig', [
                    'missions' => $missionRepository->findAll(),
                ]);

                break;

                case 'SUPERVISOR':
                    # code...
                    $missionRepository->missionApproval('line_supervisor_checked','accepted',$id);
                    return $this->redirectToRoute('mission_index');

                    break;

                    case 'ACCOUNTANT':
                        # code...
                        $missionRepository->missionApproval('verified_by_accountant','verified',$id);

                        $numday=$missionRepository->findOneBy(['id'=>$id]);

                        if($numday->getNumDays() < 3){
                            $missionRepository->missionApproval('approval_of_csdm','csdm_decision',$id);
                            $missionRepository->missionApproval('actiontaken_by','CSDM',$id);

                        }
                        else{
                          $missionRepository->missionApproval('actiontaken_by','DG');

                        }

                        return $this->redirectToRoute('mission_index');
                        break;
                        case 'DG':
                            # code...
                            $staffid=$missionRepository->findOneBy(['id'=>$id]);

                            $missionRepository->missionApproval('decision_from_dg','approved',$id,$staffid->getStaff());
                            $missionRepository->missionApproval('mstatus','approved',$id);
                            $missionRepository->missionApproval('payment_prepared_by_accountant','Yes',$id);

                            return $this->redirectToRoute('mission_index');
                            break;

                            case 'DAF':
                                # code...
                                $missionRepository->missionApproval('approval_of_df','Authorised_payment',$id);

                                   return $this->redirectToRoute('mission_index');
                                break;

                                case 'CSDM':
                                    # code...

                                    $staffid=$missionRepository->findOneBy(['id'=>$id]);

                                    $missionRepository->missionApproval('approval_of_csdm','comfirmed',$id,$staffid->getStaff());
                                    $missionRepository->missionApproval('mstatus','approved',$id);
                                      $missionRepository->missionApproval('decision_from_dg','notrequired',$id);

                                    return $this->redirectToRoute('mission_index');
                                    break;

                                    default:
        }

        return new Response();

        }
             /**
     * @Route("/missions/reject/{id}", name="mission_reject", methods={"GET"})
     */
    public function reject(MissionRepository $missionRepository,SessionInterface $session,$id): Response
    {
        switch($session->get('validUser')){
             case 'ADMIN':
                 # code...
                 return $this->render('mission/index.html.twig', [
                    'missions' => $missionRepository->findAll(),
                ]);
                 break;

                 case 'SUPERVISOR':
                     # code...
                     $missionRepository->missionApproval('line_supervisor_checked','rejected',$id);

                     $staffid= $missionRepository->findUserRole();
                     $userid= '';
                     $did ='';
                       foreach ($staffid as $id){

                          $userid= $id['id'];
                       }

                       $dpart= $missionRepository->findStaffDepartment($userid);

                       foreach($dpart as $d){
                        $did= $d['department_id'];
                       }

                 return $this->redirectToRoute('dashboard');

                     break;

                     case 'ACCOUNTANT':
                         # code...
                         $missionRepository->missionApproval('verified_by_accountant','canceled',$id);

                           return $this->redirectToRoute('dashboard');
                         break;

                         case 'DG':
                             # code...
                             $staffid=$missionRepository->findOneBy(['id'=>$id]);

                             $missionRepository->missionApproval('decision_from_dg','rejected',$id,$staffid->getStaff());
                             $missionRepository->missionApproval('mstatus','rejected by DG',$id);
                             $missionRepository->missionApproval('payment_prepared_by_accountant','No',$id);

                             return $this->redirectToRoute('mission_index');
                             break;
        }

        return new Response();

        }

     /**
     * @Route("reports/expenses", name="expenses_index", methods={"GET"})
     */
    public function expenses(Request $request,MissionRepository $missionRepository): Response
    {

        return $this->render('report/expenses.html.twig', [
            'missions' => $missionRepository->getExpenses(),
        ]);
    }
    /**
     * @Route("reports/expensesFilter", name="expensesfilter_index", methods={"POST"})
     */
public function expensesFilter(Request $request,MissionRepository $missionRepository): Response
    {
        if($request->isXmlHttpRequest()){
        $missions =$missionRepository->getExpensesFilter($request->get('fromdate'),$request->get('todate'));

        $output = '';
        $totalExp ='';
        foreach ($missions as $value) {
            $totalExp =$value['expense'];
        }

        $output .='<div id="totalExp"><p><b><i>'.'From '.$request->get('fromdate').
        ' up to '.$request->get('todate').'</i></b>:The overall total amount spent on missions are equivalent to
        <strong>'.$totalExp.'frw</strong></p></div>';
        $output .='
        <div class ="col-sm-12"> <p style ="background-color:greenyellow;color:darkblack"> Below are details of expenses :</p> </div>
        ';

        $output .='<table class="table">
        <thead>
            <tr>
                 <th> FullName</th>
                <th>Allowance</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($missions as $value) {
            # code...
          $output .='<tr>';
          $output .='<td>'. $value['first_name'].' '. $value['last_name'].'</td>';
         $output .='<td>'.$value['allowance'].'</td>';
          $output .='<td>'.$value['created_at'].'</td>';

          $output .='</tr>';

        }
        $output .='</tbody></table>';

    }

       return new Response($output) ;

    }
     /**
     * @Route("mission/report/staff-currently-in-mission", name="report_index", methods={"GET"})
     */
    public function staffInMission(MissionRepository $missionRepository): Response
    {
        $loc =$missionRepository->findBy(['mstatus'=>'approved']);
                         //variables initialization
                     $loc1 ='';
                     $loc2 ='';
                     $loc3 ='';
                     $loc4 ='';
                     foreach ($loc as $key => $value) {
                         # code...
                         $loc1 =$value->getDestination1().' ' .$value->getD1IdNumDay();
                         $loc2 =$value->getDestination2().' ' .$value->getD2IdNumDay();
                         $loc3 =$value->getDestination3().' ' .$value->getD3IdNumDay();
                         $loc4 =$value->getDestination4().' ' .$value->getD4IdNumDay();

                     }
                     $locaArr =[$loc1,$loc2,$loc3,$loc4];
        return $this->render('report/currentmissions.html.twig', [
            'options' => $missionRepository->currentStaffIn(),'location'=>$locaArr,
        ]);
    }
     /**
     * @Route("mission/report/all-missions-applied", name="all_index", methods={"GET"})
     */
    public function allMissionsApplied(MissionRepository $missionRepository): Response
    {

        return $this->render('report/allmissions.html.twig', [
            'missions' => $missionRepository->findBy([],['id'=>'desc']),
        ]);
    }
    /**
     * @Route("/reports/transport", name="transport_index", methods={"GET"})
     */
    public function transportationCostReport(VehicleRepository $vehicleRepository): Response
    {
        return $this->render('report/transport.html.twig', [
            'missions' => $vehicleRepository->transportCost(),'totals'=>$vehicleRepository->transportTotalCost(),
        ]);
    }

    /**
     * @Route("mission/new", name="mission_new", methods={"GET"})
     */
    public function new(LocationRepository $locationRepository,StaffRepository $staffRepository,PositionRepository $positionRepository,DepartmentRepository $departmentRepository,SupervisorRepository $supervisorRepository){


        return $this->render('mission/new.html.twig',['locations'=>$locationRepository->findAll(),'staff'=>$staffRepository->findAll(),'position'=>$positionRepository->findAll(),'department'=>$departmentRepository->findAll(),'supervisor'=>$supervisorRepository->findAll(),]);
    }
    /**
     * @Route("mission/save", name="mission_save", methods={"POST"})
     */
    public function save(Request $request,SessionInterface $session,MissionRepository $missionRepository,StaffRepository $staffRepository): Response
    {
        $mission = new Mission();

        $mission->setStaff($this->getDoctrine()->getRepository(Staff::class)->findOneBy(['id'=>$request->get('staff')]));
        $mission->setPosition($this->getDoctrine()->getRepository(Position::class)->findOneBy(['id'=>$request->get('position')]));
        $mission->setDepartment($this->getDoctrine()->getRepository(Department::class)->findOneBy(['id'=>$request->get('department')]));
        $mission->setMisPurpose($request->get('mis_purpose'));
        $mission->setMisCategory($request->get('mis_category'));
        $mission->setLeavedAt(\DateTime::createFromFormat('Y-m-d',$request->get('leavedAt')));
        $mission->setReturnedAt(\DateTime::createFromFormat('Y-m-d',$request->get('returnedAt')));
        $mission->setNumDays($request->get('numDays'));
        $mission->setDestination1($this->getDoctrine()->getRepository(Location::class)->findOneBy(['id'=>$request->get('destination1')]));
       $mission->setD1IdNumDay($request->get('d1IdNumDay'));
        $mission->setDestination2($this->getDoctrine()->getRepository(Location::class)->findOneBy(['id'=>$request->get('destination2')]));
         $mission->setD2IdNumDay($request->get('d2IdNumDay'));
        $mission->setDestination3($this->getDoctrine()->getRepository(Location::class)->findOneBy(['id'=>$request->get('destination3')]));
       $mission->setD3IdNumDay($request->get('d3IdNumDay'));
        $mission->setDestination4($this->getDoctrine()->getRepository(Location::class)->findOneBy(['id'=>$request->get('destination4')]));
         $mission->setD4IdNumDay($request->get('d4IdNumDay'));
        $mission->setMeanTrans($request->get('mean_trans'));
        $mission->setSupervisor($this->getDoctrine()->getRepository(Supervisor::class)->findOneBy(['id'=>$request->get('supervisor')]));
      $mission->setMstatus("Pending");
      $mission->setLineSupervisorChecked("pending");
      $mission->setVerifiedByAccountant("pending");
      $mission->setDecisionFromDG("pending");
      $mission->setApprovalOfDF("pending");
      $mission->setApprovalOfCSDM("pending");

      // check if the staff is still being in mission
      $checkField =$missionRepository->findOneBy(['staff'=>$request->get('staff'),'mstatus'=>'approved']);

      if($checkField){
        if($checkField->getReturnedAt() > $request->get('leavedAt')){

            $session->set('saveValid','Sorry! . You are allowed by asking mission before terminating the provision');
              return $this->redirectToRoute('mission_new');

          }
      }

      else

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();

            //return $this->redirectToRoute('mission_index');

        //return $this->render('mission/new.html.twig');

        $misid= $missionRepository->findOneBy([],['id'=>'desc']);

          $staffid= $misid->getStaff();
         echo $totalDays=$misid->getNumDays();

         echo $h1=$misid->getDestination1();
         echo $h2=$misid->getDestination2();
         echo $h3=$misid->getDestination3();
         echo $h4 =$misid->getDestination4();

         echo $night1=$misid->getD1IdNumDay();
         echo $night2=$misid->getD2IdNumDay();
         echo $night3=$misid->getD3IdNumDay();
         echo $night4=$misid->getD4IdNumDay();



         $position=$staffRepository->findOneBy(['id'=>$staffid]);

         echo $position->getDesignation();
         $pos=$position->getDesignation();

         $locNight1 ="";
         $locNight2 ="";
         $locNight3 ="";
         $locNight4 ="";

         $locDay ="";
         $expense="";

         if(empty($h2) && empty($h3)&& empty($h4)){

         $level=$missionRepository->findOneByAllowance($pos,$h1);
         //print_r($level);
         //echo $level->getLevel();
         foreach($level as $l){

         $locNight1=$l['allowance_per_night'];
         $locDay=$l['allowance_per_day'];
         }
         echo $locNight1;
         $expense=($locDay*$totalDays)+($locNight1*$night1);

         }
         elseif(empty($h3) && empty($h4)){

            $allowance1=$missionRepository->findOneByAllowance($pos,$h1);

            //echo $level->getLevel();
            foreach( $allowance1 as $l){
                $locNight1=$l['allowance_per_night'];
                $locDay=$l['allowance_per_day'];

            }

            $allowance2=$missionRepository->findOneByAllowance($pos,$h2);

            //echo $level->getLevel();
            foreach($allowance2 as $l){
             $locNight2=$l['allowance_per_night'];
                $locDay=$l['allowance_per_day'];

            }


           $expense=($locDay*$totalDays)+($locNight1*$night1)+($locNight2*$night2);

            }
            elseif(empty($h4)&& !empty($h3) && !empty($h2) && !empty($h1)){

                $allowance1=$missionRepository->findOneByAllowance($pos,$h1);

                //echo $level->getLevel();
                foreach( $allowance1 as $l){
                     $locNight1=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }

                $allowance2=$missionRepository->findOneByAllowance($pos,$h2);

                //echo $level->getLevel();
                foreach($allowance2 as $l){
                 $locNight2=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                $allowance3=$missionRepository->findOneByAllowance($pos,$h3);

                //echo $level->getLevel();
                foreach($allowance3 as $l){
                 $locNight3=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }

                $expense=($locDay*$totalDays)+($locNight1*$night1)+($locNight2*$night2)+($locNight3*$night3);

                }
                else{
                    $allowance1=$missionRepository->findOneByAllowance($pos,$h1);

                //echo $level->getLevel();
                foreach( $allowance1 as $l){
                     $locNight1=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }

                $allowance2=$missionRepository->findOneByAllowance($pos,$h2);

                //echo $level->getLevel();
                foreach($allowance2 as $l){
                 $locNight2=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                $allowance3=$missionRepository->findOneByAllowance($pos,$h3);

                //echo $level->getLevel();
                foreach($allowance3 as $l){
                 $locNight3=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                $allowance4=$missionRepository->findOneByAllowance($pos,$h4);

                //echo $level->getLevel();
                foreach($allowance4 as $l){
                 $locNight4=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                    $expense=($locDay*$totalDays)+($locNight1*$night1)+($locNight2*$night2)+($locNight3*$night3)+($locNight4*$night4);



                }

         echo $expense;

         //save the total allowance in expenses table into database
         $exp= new Expense();
         $exp->setMission($mission);
         $exp->setStaff($staffid);
         $exp->setAllowance($expense);
         $exp->setCreatedAt(\DateTime::createFromFormat("Y-m-d",date('Y-m-d')));

         $entityManager->persist($exp);
         $entityManager->flush();

         $missionRepository->missionAllowanceUpdate($expense,$mission->getId());

         return $this->redirectToRoute('mission_index');
    }

    /**
 * @Route("/misslast",name="lastid",methods={"GET"})
 */
public function getLastRecords(MissionRepository $missionRepository,StaffRepository $staffRepository,PositionRepository $positionRepository){

    $misid= $missionRepository->findOneBy([],['id'=>'desc']);

         $staffid= $misid->getStaff();
         echo $totalDays=$misid->getNumDays();

         echo $h1=$misid->getLoc1Hosted();
         echo $h2=$misid->getLoc2Hosted();
         echo $h3=$misid->getLoc3Hosted();
         echo $h4 =$misid->getLoc4Hosted();

         echo $night1=$misid->getD1IdNumDay();
         echo $night2=$misid->getD2IdNumDay();
         echo $night3=$misid->getD3IdNumDay();
         echo $night4=$misid->getD4IdNumDay();



         $position=$staffRepository->findOneBy(['id'=>$staffid]);

         echo $position->getDesignation();
         $pos=$position->getDesignation();

         $locNight1 ="";
         $locNight2 ="";
         $locNight3 ="";
         $locNight4 ="";

         $locDay ="";
         $expense="";

         if(empty($h2) && empty($h3)&& empty($h4)){

         $level=$missionRepository->findOneByAllowance($pos,$misid->getLoc1Hosted());

         //echo $level->getLevel();
         foreach($level as $l)

         $locNight1=$l['allowance_per_night'];
         $locDay=$l['allowance_per_day'];

         $expense=($locDay*$totalDays)+($locNight1*$night1);

         }
         elseif(empty($h3) && empty($h4)){

            $allowance1=$missionRepository->findOneByAllowance($pos,$h1);

            //echo $level->getLevel();
            foreach( $allowance1 as $l){
                $locNight1=$l['allowance_per_night'];
                $locDay=$l['allowance_per_day'];

            }

            $allowance2=$missionRepository->findOneByAllowance($pos,$h2);

            //echo $level->getLevel();
            foreach($allowance2 as $l){
             $locNight2=$l['allowance_per_night'];
                $locDay=$l['allowance_per_day'];

            }


           $expense=($locDay*$totalDays)+($locNight1*$night1)+($locNight2*$night2);

            }
            elseif(empty($h4)&& !empty($h3) && !empty($h2) && !empty($h1)){

                $allowance1=$missionRepository->findOneByAllowance($pos,$h1);

                //echo $level->getLevel();
                foreach( $allowance1 as $l){
                     $locNight1=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }

                $allowance2=$missionRepository->findOneByAllowance($pos,$h2);

                //echo $level->getLevel();
                foreach($allowance2 as $l){
                 $locNight2=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                $allowance3=$missionRepository->findOneByAllowance($pos,$h3);

                //echo $level->getLevel();
                foreach($allowance3 as $l){
                 $locNight3=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }

                $expense=($locDay*$totalDays)+($locNight1*$night1)+($locNight2*$night2)+($locNight3*$night3);

                }
                else{
                    $allowance1=$missionRepository->findOneByAllowance($pos,$h1);

                //echo $level->getLevel();
                foreach( $allowance1 as $l){
                     $locNight1=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }

                $allowance2=$missionRepository->findOneByAllowance($pos,$h2);

                //echo $level->getLevel();
                foreach($allowance2 as $l){
                 $locNight2=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                $allowance3=$missionRepository->findOneByAllowance($pos,$h3);

                //echo $level->getLevel();
                foreach($allowance3 as $l){
                 $locNight3=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                $allowance4=$missionRepository->findOneByAllowance($pos,$h4);

                //echo $level->getLevel();
                foreach($allowance4 as $l){
                 $locNight4=$l['allowance_per_night'];
                    $locDay=$l['allowance_per_day'];

                }
                    $expense=($locDay*$totalDays)+($locNight1*$night1)+($locNight2*$night2)+($locNight3*$night3)+($locNight4*$night4);



                }

         echo $expense;

         //echo $misid->getStaff();


    return new Response();

}

    /**
     * @Route("/missions/get/{id}", name="mission_show", methods={"GET"})
     */
    public function show(Mission $mission): Response
    {$pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html =$this->renderView('mission/show.html.twig', [
            'mission' => $mission,
        ]);

        $dompdf->loadHtml($html);

       // set layout page
        $dompdf->setPaper('A4', 'portrait');
        //render the page
        $dompdf->render();

        //generate pdf in browser
        $dompdf->stream("mission.pdf", [
            "Attachment" => false
        ]);
    }
   /**
     * @Route("/missions/expense/report", name="expense_report", methods={"GET"})
     */
    public function showExpensesPDF(MissionRepository $missionRepository){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html =$this->renderView('report/expenses.html.twig', [
            'missions' => $missionRepository->getExpenses(),
        ]);

        $dompdf->loadHtml($html);

       // set layout page
        $dompdf->setPaper('A4', 'portrait');
        //render the page
        $dompdf->render();

        //generate pdf in browser
        $dompdf->stream("expenses-report.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mission_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mission $mission): Response
    {
        $form = $this->createForm(MissionType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mission_index');
        }

        return $this->render('mission/edit.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/missions/staff/{id}/myMissions", name="my_mission", methods={"GET"})
     */
    public function myMissions(MissionRepository $missionRepository,SessionInterface $session,$id): Response
    {
        if($session->get('staffLName') =='Serubibi'){
            return $this->render('mission/mymissions.html.twig', [
                'missions' => $missionRepository->findBy(['staff'=>$id],['id'=>'desc']),
            ]);
        }
        return $this->render('mission/mymissions.html.twig', [
            'missions' => $missionRepository->findBy(['staff'=>$id,'mstatus'=>'approved'],['id'=>'desc']),
        ]);

    }

    /**
     * @Route("/{id}", name="mission_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mission $mission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mission_index');
    }


}
