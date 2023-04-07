<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Form\DeckType;
use Monolog\DateTimeImmutable;
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
         * @Route("/deck/editer/{id}", name="deck_edit")
         * @Route("/deck/cloner/{id}", name="deck_clone")
         */
        public function create(Request $request, SluggerInterface $slugger, Deck $deck = null): Response
        {
            $user = $this->getUser();


            if(!$deck){

                $deck = new Deck();
                $deck->setUtilisateur($user);

            }elseif($user != $deck->getUtilisateur()){

                $copiedMode = true;

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

                    // supprimer l'ancienne image si elle existe
                    if ($carte->getData()->getImageQuestion()) {
                        // $imageReponseFile = $carte->get("image_question")->getData();
                        // dd($imageReponseFile->getClientOriginalName());
                        unlink($this->getParameter('image_directory').'/'.$carte->getData()->getImageQuestion());
                    }

                    $newFilenameImageQuestion = $this->registerImage($imageQuestionFile, $form, $slugger);
                    $newFilenameImageReponse = $this->registerImage($imageReponseFile, $form, $slugger);
                    
                    $carte->getData()->setImageQuestion($newFilenameImageQuestion);
                    $carte->getData()->setImageReponse($newFilenameImageReponse);
                    
                    $entityManager->persist($carte->getData());
                }
    
                $entityManager->flush();
    
                return $this->redirectToRoute('deck_show', ['id' => $deck->getId()]);
            }
            return $this->render('deck/create.html.twig', [
                'deck' => $deck,
                'form' => $form->createView(),
                'editMode' => $deck->getId(),
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
         * @Route("/deck/{id}", name="deck_show", methods={"GET"})
         */
        public function show(Deck $deck): Response
        {
            return $this->render('deck/show.html.twig', [
                'deck' => $deck,
            ]);
        }
    
}
