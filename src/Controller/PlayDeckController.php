<?php

namespace App\Controller;

use App\Entity\Deck;
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

        $cartes = $doctrine->getRepository(PositionCarte::class)->findBy(array('id' => $utilisateur->getId()));

        return $this->render('play_deck/index.html.twig', [
            'cartes' => $cartes,
            'utilisateur' => $utilisateur,
            'deck' => $deck,
        ]);
    }
}
