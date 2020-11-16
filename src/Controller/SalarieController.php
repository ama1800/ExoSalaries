<?php

namespace App\Controller;

use App\Entity\Salarie;
use App\Form\SalarieType;
use App\Repository\SalarieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salarie")
 */
class SalarieController extends AbstractController
{
    /**
     * @Route("/", name="salarie_index", methods={"GET"})
     */
    public function index(SalarieRepository $salarieRepository): Response
    {
        $salaries=$salarieRepository->findAll();
        return $this->render('salarie/index.html.twig', [
            'salaries' => $salaries,
        ]);
    }

    /**
     * @Route("/new", name="salarie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $salarie = new Salarie();
        $form = $this->createForm(SalarieType::class, $salarie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salarie);
            $entityManager->flush();

            return $this->redirectToRoute('salarie_index');
        }

        return $this->render('salarie/new.html.twig', [
            'salarie' => $salarie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salarie_show", methods={"GET"})
     */
    public function show(Salarie $salarie): Response
    {
        return $this->render('salarie/show.html.twig', [
            'salarie' => $salarie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="salarie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Salarie $salarie): Response
    {
        $form = $this->createForm(SalarieType::class, $salarie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('salarie_index');
        }

        return $this->render('salarie/edit.html.twig', [
            'salarie' => $salarie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="salarie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Salarie $salarie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salarie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($salarie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('salarie_index');
    }
}
