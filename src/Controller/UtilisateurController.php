<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="app_utilisateur")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $utilisateurs = $doctrine->getRepository(Utilisateur::class)->findAll();

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'utilisateurs' => $utilisateurs
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="show_utilisateur")
     */
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur
        ]);
    }

    /**
     * @Route("/mon_profil", name="my_profile_user")
     */
    public function profil(Request $request , EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

        $user = $this->getUser();

        if(!$user) return $this->redirectToRoute('app_login');


        $form = $this->createForm(UtilisateurType::class, $user);

        $form->handleRequest($request);
        // dd($user);
        if ($form->isSubmitted() && $form->isValid()) {

            // dd($form->get('password')->getData());
            if ($hasher->isPasswordValid($user, $form->get('password')->getData())) {
                // dd($user);
                // dd('aaa');
                // Mettre à jour le pseudo de l'utilisateur
                $user->setPseudo($form->get('pseudo')->getData());
    
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Le pseudo à bien été modifié.'
                );

                return $this->redirectToRoute('my_profile_user');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }


        return $this->render('utilisateur/my_profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
