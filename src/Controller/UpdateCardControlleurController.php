<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\Carte;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UpdateCardControlleurController extends AbstractController
{
    /**
     * @Route("/recharge-partie/{deckId}/{dataTab}", name="recharge_partie")
     * @ParamConverter("deck", options={"mapping": {"deckId": "id"}})
     */
    public function index(ManagerRegistry $doctrine, Deck $deck, string $dataTab): Response
    {

        $cartesDeckNotInPositionCarte = $doctrine->getRepository(Carte::class)->findCartesDeckNotInPositionCarte($this->getUser() ,$deck->getId());
        


        return $this->render('play_deck\un_morceau.html.twig', [
            'dataTab' => $dataTab,
            'cartesDeckNotInPositionCarte' => $cartesDeckNotInPositionCarte,
        ]);
    }
}
