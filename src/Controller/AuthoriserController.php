<?php

namespace App\Controller;

use App\Entity\Authoriser;
use App\Form\AuthoriserType;
use App\Repository\AuthoriserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/authoriser")
 */
class AuthoriserController extends AbstractController
{
    /**
     * @Route("/", name="authoriser_index", methods={"GET"})
     */
    public function index(AuthoriserRepository $authoriserRepository): Response
    {
        return $this->render('authoriser/index.html.twig', [
            'authorisers' => $authoriserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="authoriser_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $authoriser = new Authoriser();
        $form = $this->createForm(AuthoriserType::class, $authoriser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($authoriser);
            $entityManager->flush();

            return $this->redirectToRoute('authoriser_index');
        }

        return $this->render('authoriser/new.html.twig', [
            'authoriser' => $authoriser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="authoriser_show", methods={"GET"})
     */
    public function show(Authoriser $authoriser): Response
    {
        return $this->render('authoriser/show.html.twig', [
            'authoriser' => $authoriser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="authoriser_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Authoriser $authoriser): Response
    {
        $form = $this->createForm(AuthoriserType::class, $authoriser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('authoriser_index');
        }

        return $this->render('authoriser/edit.html.twig', [
            'authoriser' => $authoriser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="authoriser_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Authoriser $authoriser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$authoriser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($authoriser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('authoriser_index');
    }
}
