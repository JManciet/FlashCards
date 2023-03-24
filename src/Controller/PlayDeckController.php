<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\Carte;
use App\Entity\Utilisateur;
use App\Entity\PositionCarte;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PlayDeckController extends AbstractController
{
    /**
     * @Route("/play/deck/{idUtilisateur}/{idDeck}", name="app_play_deck")
     * @ParamConverter("utilisateur", options={"mapping": {"idUtilisateur": "id"}})
     * @ParamConverter("deck", options={"mapping": {"idDeck": "id"}})
     */

    public function index(ManagerRegistry $doctrine, Utilisateur $utilisateur ,Deck $deck): Response
    {

        $positionCartesByUtilisateur = $doctrine->getRepository(PositionCarte::class)->findBy(array('utilisateur' => $utilisateur->getId()));

        $cartesDeckNotInPositionCartesByUtilisateur = $doctrine->getRepository(Carte::class)->findCartesDeckNotInPositionCartesByUtilisateur($utilisateur->getId(),$deck->getId());
        
        // dd($cartesDeckNotInPositionCartesByUtilisateur);

        return $this->render('play_deck/index.html.twig', [
            'utilisateur' => $utilisateur,
            'deck' => $deck,
            'positionCartesByUtilisateur' => $positionCartesByUtilisateur,
            'cartesDeckNotInPositionCartesByUtilisateur' => $cartesDeckNotInPositionCartesByUtilisateur,
        ]);
    }
}