<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\DeckType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeckController extends AbstractController
{
    /**
     * @Route("/deck", name="app_deck")
     */
    public function index(): Response
    {
        return $this->render('deck/index.html.twig', [
            'controller_name' => 'DeckController',
        ]);
    }


        /**
         * @Route("/deck/create", name="deck_create", methods={"GET","POST"})
         */
        public function create(Request $request): Response
        {
            $user = $this->getUser();
    
            $deck = new Deck();
            $deck->setUtilisateur($user);
    
            $form = $this->createForm(DeckType::class, $deck);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($deck);
    
                foreach ($deck->getCartes() as $carte) {
                    $carte->setDeck($deck);
                    $entityManager->persist($carte);
                }
    
                $entityManager->flush();
    
                return $this->redirectToRoute('deck_show', ['id' => $deck->getId()]);
            }
    
            return $this->render('deck/create.html.twig', [
                'deck' => $deck,
                'form' => $form->createView(),
            ]);
        }
    
        /**
         * @Route("/deck/{id}", name="deck_show", methods={"GET"})
         */
        public function show(Deck $deck): Response
        {
            return $this->render('deck/show.html.twig', [
                'deck' => $deck,
            ]);
        }
    
}
