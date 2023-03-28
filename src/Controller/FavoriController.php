<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\Favori;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriController extends AbstractController
{
    /**
     * @Route("/favori", name="app_favori")
     */
    public function index(): Response
    {
        return $this->render('favori/index.html.twig', [
            'controller_name' => 'FavoriController',
        ]);
    }



    /**
     * @Route("/ajouter_favori/{id}", name="ajouter_favori")
     */
    public function addFavori(Deck $deck, Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        // Vérifier si l'utilisateur a déjà ajouté la recette en tant que favori
        $favoriExist = $entityManager->getRepository(Favori::class)->findOneBy([
            'utilisateur' => $this->getUser(),
            'deck' => $deck
        ]);

        // Si l'utilisateur n'a pas encore ajouté la recette en tant que favori, la sauvegarder
        if(!$favoriExist) {
            $favori = new Favori();
            $favori->setUtilisateur($this->getUser());
            $favori->setDeck($deck);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favori);
            $entityManager->flush();
        }

        // return $this->redirect($request->headers->get('referer'));
        return new JsonResponse(['success' => true]);
    }
}
