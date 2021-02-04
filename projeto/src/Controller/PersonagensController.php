<?php

namespace App\Controller;

use App\Entity\Personagens;
use App\Form\PersonagensType;
use App\Repository\PersonagensRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\SWAPI\SwapiClient;

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
        //$swapi = new SwapiClient();
        //$pessoas = $swapi->getPeople(3);
        //var_dump($pessoas->results);
        return $this->render('personagens/index.html.twig', [
            'personagens' => $personagensRepository->findAll()
           // 'pessoas' => $pessoas->results
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
    * @Route("/busca", name="personagens_busca", methods={"GET", "POST"})
    */

    public function busca(Request $request): Response
    {
        $request->request->get('busca');

        $swapi = new SwapiClient();
        $nomes = $swapi->getAllPeoplesNames();
        
        $response = new Response(json_encode($nomes));
        $response->headers->set('Content-Type', 'text/json');

        return $response;
    }

    /**
    * @Route("/detalhesapi", name="personagens_detalhesapi", methods={"GET", "POST"})
    */
    public function detalhesapi(Request $request): Response
    {
        $nome = $request->request->get('nome');

        $swapi = new SwapiClient();
        $personagem = $swapi->getPeopleByName($nome);
        
        $repository = $this->getDoctrine()->getRepository(Personagens::class);
        $jasalvo = false;
        $personagem_salvo = $repository->findOneBy(['nome'=>$nome]);
        if($personagem_salvo){
            $jasalvo = true;
        }
        
        return $this->render('personagens/detalhesapi.html.twig', [
            'personagem' => $personagem,
            'jasalvo' => $jasalvo
        ]);

        return $response;
    }

    /**
     * @Route("/{id}", name="personagens_show", methods={"GET"})
     */
    public function show(Personagens $personagen): Response
    {
        return $this->render('personagens/show.html.twig', [
            'personagen' => $personagen,
            'personagem' => json_decode($personagen->getDetalhes())
        ]);
    }

     /**
     * @Route("/salva/{id}", name="personagens_salva", methods={"GET"})
     */
    public function salva(int $id): Response
    {
        
        $swapi = new SwapiClient();
        $personagem = $swapi->getPeopleByid($id);
        
        
        $repository = $this->getDoctrine()->getRepository(Personagens::class);

        $personagem_salvo = $repository->findOneBy(['nome'=>$personagem->name]);

        if(!$personagem_salvo){
            $personagem_local = new Personagens();
            $personagem_local->setNome($personagem->name);
            $personagem_local->setDetalhes(json_encode($personagem));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personagem_local);
            $entityManager->flush();    
        }

        

        return $this->redirect('/personagens/');
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
