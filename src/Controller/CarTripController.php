<?php

namespace App\Controller;

use App\Entity\CarTrip;
use App\Form\CarTripType;
use App\Repository\CarTripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car/trip")
 */
class CarTripController extends AbstractController
{
    /**
     * @Route("/", name="car_trip_index", methods={"GET"})
     */
    public function index(CarTripRepository $carTripRepository): Response
    {
        return $this->render('car_trip/index.html.twig', [
            'car_trips' => $carTripRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="car_trip_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carTrip = new CarTrip();
        $form = $this->createForm(CarTripType::class, $carTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carTrip);
            $entityManager->flush();

            return $this->redirectToRoute('car_trip_index');
        }

        return $this->render('car_trip/new.html.twig', [
            'car_trip' => $carTrip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_trip_show", methods={"GET"})
     */
    public function show(CarTrip $carTrip): Response
    {
        return $this->render('car_trip/show.html.twig', [
            'car_trip' => $carTrip,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="car_trip_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CarTrip $carTrip): Response
    {
        $form = $this->createForm(CarTripType::class, $carTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_trip_index');
        }

        return $this->render('car_trip/edit.html.twig', [
            'car_trip' => $carTrip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_trip_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CarTrip $carTrip): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carTrip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carTrip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('car_trip_index');
    }
}
