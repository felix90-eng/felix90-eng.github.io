<?php

namespace App\Controller;

use App\Entity\Allowance;
use App\Form\AllowanceType;
use App\Repository\AllowanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/allowance")
 */
class AllowanceController extends AbstractController
{
    /**
     * @Route("/", name="allowance_index", methods={"GET"})
     */
    public function index(AllowanceRepository $allowanceRepository): Response
    {
        return $this->render('allowance/index.html.twig', [
            'allowances' => $allowanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="allowance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $allowance = new Allowance();
        $form = $this->createForm(AllowanceType::class, $allowance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($allowance);
            $entityManager->flush();

            return $this->redirectToRoute('allowance_index');
        }

        return $this->render('allowance/new.html.twig', [
            'allowance' => $allowance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="allowance_show", methods={"GET"})
     */
    public function show(Allowance $allowance): Response
    {
        return $this->render('allowance/show.html.twig', [
            'allowance' => $allowance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="allowance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Allowance $allowance): Response
    {
        $form = $this->createForm(AllowanceType::class, $allowance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('allowance_index');
        }

        return $this->render('allowance/edit.html.twig', [
            'allowance' => $allowance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="allowance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Allowance $allowance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allowance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($allowance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('allowance_index');
    }
}
