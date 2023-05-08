<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UtilisateurUpdatePseudoType;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UtilisateurDeleteAccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/admin", name="app_user")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $utilisateurs = $doctrine->getRepository(Utilisateur::class)->findAllExceptAdmin();;

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
            'utilisateurs' => $utilisateurs
        ]);
    }



    /**
     * @Route("/utilisateur/supprimer/{id}", name="delete_user", methods={"GET"})
     */
    public function delete(EntityManagerInterface $manager, Utilisateur $utilisateur): Response 
    {

        if ($this->getUser() == $utilisateur )
        {
            // dd("dzdzdz");
            $session = $this->get('session');
            $session = new Session();
            $session->invalidate();

            $manager->remove($utilisateur);
            $manager->flush();

        }
        else if($this->isGranted('ROLE_ADMIN'))
        {
            $manager->remove($utilisateur);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a été supprimé avec succès !'
            );

            return $this->redirectToRoute('app_user');
        }

        return $this->redirectToRoute('app_login');
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


        $formUpdatePseudo = $this->createForm(UtilisateurUpdatePseudoType::class, $user);

        $formUpdatePseudo->handleRequest($request);
        // dd($user);
        if ($formUpdatePseudo->isSubmitted() && $formUpdatePseudo->isValid()) {

            // dd($formUpdatePseudo->get('password')->getData());
            if ($hasher->isPasswordValid($user, $formUpdatePseudo->get('password')->getData())) {
                // dd($user);
                // dd('aaa');
                // Mettre à jour le pseudo de l'utilisateur
                $user->setPseudo($formUpdatePseudo->get('pseudo')->getData());
    
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


        $formDeleteAccount = $this->createForm(UtilisateurDeleteAccountType::class, $user);

        $formDeleteAccount->handleRequest($request);
        // dd($user);
        if ($formDeleteAccount->isSubmitted() && $formDeleteAccount->isValid()) {

            // dd($formDeleteAccount->get('password')->getData());
            if ($hasher->isPasswordValid($user, $formDeleteAccount->get('password')->getData())) {
                // dd($user);
                $session = $this->get('session');
                $session = new Session();
                $session->invalidate();

                $manager->remove($user);
                $manager->flush();

                return $this->redirectToRoute('app_login');

                } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }


        return $this->render('utilisateur/my_profile.html.twig', [
            'user' => $user,
            'formUpdatePseudo' => $formUpdatePseudo->createView(),
            'formDeleteAccount' => $formDeleteAccount->createView(),
        ]);
    }
}
