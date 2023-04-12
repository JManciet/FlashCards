<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\DeckType;
use Monolog\DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
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
         * @Route("/deck/nouveau", name="deck_create", methods={"GET","POST"})
         * @Route("/deck/editer/{id}/{isClone}", name="deck_edit")
         */
        public function create(Request $request, SluggerInterface $slugger, String $isClone = null,Deck $deck = null): Response
        {
            $user = $this->getUser();
            $cloneMode = false;


            if($deck && $deck->isVisibilite() && $deck->getUtilisateur() != $user){

                $this->addFlash(
                    'warning',
                    'Ce deck est privé !'
                );
    
                return $this->redirectToRoute('app_home');
            }

            if(!$deck){

                $deck = new Deck();
                $deck->setUtilisateur($user);

            }elseif($isClone){

                $cloneMode = true;

                $deck = clone $deck;
                $deck->setUtilisateur($user);

            }


            $form = $this->createForm(DeckType::class, $deck);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $now = new \DateTimeImmutable();
                $deck->setDateCreation($now);
                $entityManager->persist($deck);

                $cartes = $form->get('cartes');

                foreach ($cartes as $carte) {
                
                    $carte->getData()->setDeck($deck);

                    $imageQuestionFile = $carte->get("image_question")->getData();
                    $imageReponseFile = $carte->get("image_reponse")->getData();

                    $deleteImageQuestion = $carte->get("image_question_delete")->getData();
                    $deleteImageReponse = $carte->get("image_reponse_delete")->getData();
                    
                    

                    // supprimer l'ancienne image si elle existe
                    if (($deleteImageQuestion || $imageQuestionFile) && $carte->getData()->getImageQuestion() ) {
                        @unlink($this->getParameter('image_directory').'/'.$carte->getData()->getImageQuestion());
                    }

                    // supprimer l'ancienne image si elle existe
                    if (($deleteImageReponse || $imageReponseFile) && $carte->getData()->getImageReponse() ) {
                        @unlink($this->getParameter('image_directory').'/'.$carte->getData()->getImageReponse());
                    }
                

                    if(!$deleteImageQuestion && $imageQuestionFile){
                        $newFilenameImageQuestion = $this->registerImage($imageQuestionFile, $form, $slugger);
                        $carte->getData()->setImageQuestion($newFilenameImageQuestion);
                    }

                    if(!$deleteImageReponse && $imageReponseFile){
                        $newFilenameImageReponse = $this->registerImage($imageReponseFile, $form, $slugger);
                        $carte->getData()->setImageReponse($newFilenameImageReponse);
                    }

                    $entityManager->persist($carte->getData());
                }
    
                $entityManager->flush();
    
                return $this->redirectToRoute('deck_show', ['id' => $deck->getId()]);
            }
            return $this->render('deck/create.html.twig', [
                'deck' => $deck,
                'form' => $form->createView(),
                'editMode' => $deck->getId(),
                'cloneMode' => $cloneMode
            ]);
        }




        private function registerImage($imageFile, $form, $slugger)
        {
            

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {


                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {

                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents

                return $newFilename;

            }
        }



        /**
         * @Route("/deck/delette/{id}", name="delete_deck", methods={"GET"})
         */
        public function delete(EntityManagerInterface $manager, Deck $deck): Response 
        {
            if($this->getUser() == $deck->getUtilisateur() || $this->isGranted('ROLE_ADMIN')){
                $manager->remove($deck);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Le deck a été supprimé avec succès !'
                );
            }

            return $this->redirectToRoute('show_utilisateur', ['id' => $deck->getUtilisateur()->getId()]);
        }


        /**
         * @Route("/decks_orphelins/", name="show_decks_orphans")
         */
        public function showOrphansDecks(ManagerRegistry $doctrine): Response
        {
            $orphansDecks = $doctrine->getRepository(Deck::class)->findBy(array('utilisateur' => null));

            return $this->render('admin/decks_orphans.html.twig', [
                'orphansDecks' => $orphansDecks
            ]);
        }

    
        /**
         * @Route("/deck/{id}", name="deck_show", methods={"GET"})
         */
        public function show(Deck $deck): Response
        {


            if($deck->isVisibilite() && $deck->getUtilisateur() != $this->getUser()){

                $this->addFlash(
                    'warning',
                    'Ce deck est privé !'
                );
    
                return $this->redirectToRoute('app_home');
            }


            return $this->render('deck/show.html.twig', [
                'deck' => $deck,
            ]);
        }
    
}
