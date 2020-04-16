<?php
namespace App\Controller;
use App\Entity\AppUser;
use App\Entity\Authoriser;
use App\Entity\Department;
use App\Entity\Position;
use App\Entity\Staff;
use App\Form\AppUserType;
use App\Repository\AppUserRepository;
use App\Repository\AuthoriserRepository;
use App\Repository\DepartmentRepository;
use App\Repository\PositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class AppUserController extends AbstractController
{

    /**
     * @Route("/", name="root_index", methods={"GET"})
     */
    public function homePage(): Response
    {
        return $this->redirectToRoute('security_loginform');
            
    }
    /**
     * @Route("/dashboard", name="dashboard_index", methods={"GET"})
     */
    public function dashboard(): Response
    {
        return $this->render('dashboard/index.html.twig');
            
    }

    /**
     * @Route("/app/user/", name="app_user_index", methods={"GET"})
     */
    public function index(AppUserRepository $appUserRepository,AuthoriserRepository $authoriserRepository): Response
    {
        return $this->render('app_user/index.html.twig', [
            'app_users' => $appUserRepository->findAll(),'auths'=>$authoriserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/app/user/new", name="app_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $appUser = new AppUser();
        $form = $this->createForm(AppUserType::class, $appUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $appUser->setRole($this->getDoctrine()->getManager()->getRepository(Authoriser::class)->find('0'));
            $entityManager->persist($appUser);
            $entityManager->flush();

            return $this->redirectToRoute('staff_new');
        }

        return $this->render('app_user/new.html.twig', [
            'app_user' => $appUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/app/user/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(AppUser $appUser): Response
    {
        return $this->render('app_user/show.html.twig', [
            'app_user' => $appUser,
        ]);
    }

    /**
     * @Route("/app/user/{id}/edit", name="app_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AppUser $appUser): Response
    {
        $form = $this->createForm(AppUserType::class, $appUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('app_user/edit.html.twig', [
            'app_user' => $appUser,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/app/user/custom/{id}/edit", name="custom_edit", methods={"GET","POST"})
     */
    public function customedit(Request $request, AppUserRepository $appUserRepository,AppUser $appUser): Response
    {


        $user= $appUserRepository->customUpdate($request->get('role'),$request->get('id'));
        return $this->redirectToRoute('app_user_index');
    }

    /**
     * @Route("/app/user/{id}", name="app_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AppUser $appUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index');
    }

    
    /**
 * @Route("/app/usersecurity",name="security_loginform",methods ={"GET","POST"})
 */
public function loginForm( Request $request,AppUserRepository $user){


   return $this->render('app_user/login.html.twig');
}
/**
 * @Route("/app/userlogin",name="security_login",methods ={"GET","POST"})
 */
public function login( Request $request,SessionInterface $session,AppUserRepository $appUserRepository){
  //$user= $appUserRepository->login($request->get('email'),$request->get('secretword'));
   //echo $request->get('_password').'hhhhhhhhh';
 
  $user = $this->getDoctrine()->getManager()->getRepository(AppUser::class)
   ->findOneBy(array('email' => $request->get('email'),'password' => $request->get('secretword')));
/// End Retrieve user

// Check if the user exists !
if(!$user){

    return $this->redirectToRoute('security_loginform');
}

else{

$role = $this->getDoctrine()->getManager()->getRepository(Authoriser::class)
   ->findOneBy(array('id' => $user->getRole()));
   //set variables session
  $session->set('validUser',$role->getRole());
  $session->set('userId',$user->getId());

  $staff= $this->getDoctrine()->getManager()->getRepository(Staff::class)
                     ->findOneBy(array('user' => $user->getId()));
    if($staff){
        $session->set('staffId',$staff->getId());
        $session->set('staffFName',$staff->getFirstName());
        $session->set('staffLName',$staff->getLastName());
 

    }
        //get the staff position and departmment
        $p=$appUserRepository->positionIdByName($staff->getDesignation());
        
         foreach ($p as $value) {
             # code...
              $session->set('postid',$value['id']);
            $session->set('postname',$staff->getDesignation());
         }
         $p=$appUserRepository->departmentIdByName($staff->getDepartment());
        
         foreach ($p as $value) {
             # code...
              $session->set('deptid',$value['id']);
            $session->set('deptname',$staff->getDepartment());
         }
 

        return $this->redirectToRoute('dashboard_index');
}

//echo $_SESSION['validUser'];
return new Response();

}

/**
* @Route("/security/logout",name="security_logout")
*/
public function logout(SessionInterface $session){

    $session->clear();
    return $this->redirectToRoute('security_loginform');
}

}
