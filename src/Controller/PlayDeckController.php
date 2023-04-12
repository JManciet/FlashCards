<?php

namespace App\Controller;

use DateTime;
use App\Entity\Deck;
use App\Entity\Carte;
use App\Entity\AccesDeck;
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
     * @Route("/play/deck/{id}", name="app_play_deck")
     */

    public function index(ManagerRegistry $doctrine ,Deck $deck): Response
    {


        if($deck->isVisibilite() && $deck->getUtilisateur() != $this->getUser()){

            $this->addFlash(
                'warning',
                'Ce deck est privé !'
            );

            return $this->redirectToRoute('app_home');
        }

        $accesDeck = $doctrine->getRepository(AccesDeck::class)->findOneBy(array('utilisateur' => $this->getUser(), 'deck' => $deck));
        
        $entityManager = $this->getDoctrine()->getManager();

        $now = new \DateTime();

        if(!$accesDeck){
            $accesDeck = new AccesDeck();
            $accesDeck->setUtilisateur($this->getUser())->setDeck($deck)->setDateDernierAcces($now);
            $entityManager->persist($accesDeck);
        }else{
            $accesDeck->setDateDernierAcces($now);
        }
        $entityManager->flush();
       



        // $positionCartesByUtilisateur = $doctrine->getRepository(PositionCarte::class)->findBy(array('utilisateur' => $utilisateur->getId()));
        $cartesDeckInPositionCarte = $doctrine->getRepository(Carte::class)->findCartesDeckInPositionCarte($this->getUser() ,$deck->getId());

        $cartesDeckNotInPositionCarte = $doctrine->getRepository(Carte::class)->findCartesDeckNotInPositionCarte($this->getUser() ,$deck->getId());
        
        // dd($cartesDeckInPositionCartesByUtilisateur);

        return $this->render('play_deck/index.html.twig', [
            'utilisateur' => $this->getUser(),
            'deck' => $deck,
            'cartesDeckInPositionCarte' => $cartesDeckInPositionCarte,
            'cartesDeckNotInPositionCarte' => $cartesDeckNotInPositionCarte,
        ]);

    }
}
