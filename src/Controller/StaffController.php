<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Entity\Staff;
use App\Entity\User;
use App\Form\StaffType;
use App\Repository\StaffRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;


class StaffController extends AbstractController
{

    /**
     * @Route("/staff/list", name="staff_index", methods={"GET"})
     */
    public function index(StaffRepository $staffRepository): Response
    {
        return $this->render('staff/index.html.twig', [
            'staff' => $staffRepository->findAll(),
        ]);
    }
      /**
     * @Route("/getsta", name="staffget", methods={"GET"})
     */
    public function staffid(StaffRepository $staffRepository): Response
    {
        return $this->render('staff/getstaffid.html.twig', [
            'staff' => $staffRepository->findAll(),
        ]);
    }

    /**
     * @Route("staff/new", name="staff_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $staff = new Staff();
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $staff->setUser($this->getDoctrine()->getRepository(AppUser::class)->findOneBy([],['id'=>'desc']));
       
            $entityManager->persist($staff);
            $entityManager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('staff/new.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="staff_show", methods={"GET"})
     */
    public function show(Staff $staff): Response
    {
        return $this->render('staff/show.html.twig', [
            'staff' => $staff,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="staff_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Staff $staff): Response
    {
        $form = $this->createForm(StaffType::class, $staff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('staff_index');
        }

        return $this->render('staff/edit.html.twig', [
            'staff' => $staff,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="staff_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Staff $staff): Response
    {
        if ($this->isCsrfTokenValid('delete'.$staff->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($staff);
            $entityManager->flush();
        }

        return $this->redirectToRoute('staff_index');
    }


    /**
     * @Route("loginAction", name="action_login", methods={"POST"})
     */
    public function login(Request $request,StaffRepository $userRepository){
    
        $row= $userRepository->login($request->get('_username'),$request->get('password'));

        if($row->rowCount() >0){
           foreach($row as $r)

           switch($r['roles']){

            case '["ROLE_ADMIN"]' :
                return $this->redirectToRoute('adminmission_index');
            break;
            case '["ROLE_SUPERVISOR"]' :
                return $this->redirectToRoute('supervisormission_index');
            break;
            case '["ROLE_ACCOUNTANT"]' :
                return $this->redirectToRoute('accountantmission_index');
            break;
            case '["ROLE_DG"]' :
                return $this->redirectToRoute('dgmission_index');
            break;
            case '["ROLE_DAF"]' :
                return $this->redirectToRoute('dafmission_index');
            break;
            case '["ROLE_CSDM"]' :
                return $this->redirectToRoute('csdmmission_index');
            break;
            
            default:
            return $this->redirectToRoute('staffmission_index');
            

           }
            

        }

        else{
        return $this->redirectToRoute('user_login');
        return  new Response();

        }

        

    }

    /**
     * @Route("user/login", name="user_login", methods={"GET"})
     */
    public function userLogin(){
    
       return $this->render('security/login.html.twig');

        }
     
}
