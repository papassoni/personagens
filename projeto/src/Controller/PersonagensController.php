<?php

namespace App\Controller;

use App\Entity\Personagens;
use App\Form\PersonagensType;
use App\Repository\PersonagensRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personagens")
 */
class PersonagensController extends AbstractController
{
    /**
     * @Route("/", name="personagens_index", methods={"GET"})
     */
    public function index(PersonagensRepository $personagensRepository): Response
    {
        return $this->render('personagens/index.html.twig', [
            'personagens' => $personagensRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="personagens_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personagen = new Personagens();
        $form = $this->createForm(PersonagensType::class, $personagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personagen);
            $entityManager->flush();

            return $this->redirectToRoute('personagens_index');
        }

        return $this->render('personagens/new.html.twig', [
            'personagen' => $personagen,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personagens_show", methods={"GET"})
     */
    public function show(Personagens $personagen): Response
    {
        return $this->render('personagens/show.html.twig', [
            'personagen' => $personagen,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personagens_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personagens $personagen): Response
    {
        $form = $this->createForm(PersonagensType::class, $personagen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personagens_index');
        }

        return $this->render('personagens/edit.html.twig', [
            'personagen' => $personagen,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personagens_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Personagens $personagen): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personagen->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personagen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personagens_index');
    }
}
