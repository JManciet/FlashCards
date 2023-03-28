<?php

namespace App\Controller;

use App\Entity\Carte;
use App\Entity\PositionCarte;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PositionCarteController extends AbstractController
{
    /**
     * @Route("/position/carte", name="app_position_carte")
     */
    public function index(): Response
    {
        return $this->render('position_carte/index.html.twig', [
            'controller_name' => 'PositionCarteController',
        ]);
    }


    /**
     * @Route("/ajouter_position_carte/{idCarte}/{position}", name="ajouter_position_carte")
     * @ParamConverter("carte", options={"mapping": {"idCarte": "id"}})
     */
    public function addPositionCarte(Carte $carte, $position, Request $request)
    {

        // dd("je suis là");
        $entityManager = $this->getDoctrine()->getManager();

        // Vérifier si l'utilisateur a déjà ajouté la recette en tant que positionCarte
        $positionCarteExist = $entityManager->getRepository(PositionCarte::class)->findOneBy([
            'utilisateur' => $this->getUser(),
            'carte' => $carte,
            'position' => $position,
        ]);

        // Si l'utilisateur n'a pas encore ajouté la recette en tant que positionCarte, la sauvegarder
        if(!$positionCarteExist) {
            $positionCarte = new PositionCarte();
            $positionCarte->setUtilisateur($this->getUser());
            $positionCarte->setCarte($carte);
            $positionCarte->setPosition($position);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($positionCarte);
            $entityManager->flush();
        }

        // return $this->redirect($request->headers->get('referer'));
        return new JsonResponse(['success' => true]);
    }
}
