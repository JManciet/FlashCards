<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteDeckController extends AbstractController
{
    /**
     * @Route("/deck/note", name="app_note_deck")
     */
    public function index(): Response
    {
        return $this->render('note_deck/index.html.twig', [
            'controller_name' => 'NoteDeckController',
        ]);
    }


    /**
     * @Route("/note/new", name="note_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $note = new NoteDeck();
        $form = $this->createForm(NoteDeckType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_index');
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }
}
