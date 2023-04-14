<?php

namespace App\Controller;

use App\Entity\Deck;
use App\Entity\Categorie;
use App\Repository\DeckRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }


    // public function searchBar(DeckRepository $repo)
    // {

    //     $decks = $repo->findAll();
    //     $nbrTotalDecks = count($decks);

    //     $form = $this->createFormBuilder()
    //         ->setAction($this->generateUrl('handleSearch'))
    //         ->add('query', TextType::class, [
    //             'label' => false,
    //             'attr' => [
    //                 'class' => 'form-control',
    //                 'placeholder' => $nbrTotalDecks
    //             ]
    //         ])
    //         ->add('query', SubmitType::class, [
    //             'attr' => [
    //                 'class' => 'btn btn-primary'
    //             ]
    //         ])
    //         ->getForm();

    //     return $this->render('search/searchBar.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }

    // /**
    //  * @Route("/handleSearch", name="handleSearch")
    //  * @param Request $request
    //  */
    // public function handleSearch(Request $request, DeckRepository $repo)
    // {
    //     $query = $request->request->get('form')['query'];
    //     if($query) {
    //         $decks = $repo->findArticlesByName($query);
    //     }
    //     return $this->render('search/index.html.twig', [
    //         'decks' => $decks
    //     ]);
    // }



    /**
     * @Route("/recherche", name="search")
     */
    public function search(Request $request, PaginatorInterface $paginator)
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        $deckRepository = $this->getDoctrine()->getRepository(Deck::class);

        $decks = $deckRepository->findDecksByFilter($request);

        $pagination = $paginator->paginate(
            $decks, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('search/results.html.twig', [
            'decks' => $decks,
            'categories' => $categories,
            'pagination' => $pagination
        ]);
    }

    
}
