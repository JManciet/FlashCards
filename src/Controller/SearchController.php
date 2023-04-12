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
    public function search(Request $request, CategorieRepository $repository, PaginatorInterface $paginator)
{

    $categories = $repository->findAll();

    $query = $request->query->get('query');
    $titre = $request->query->get('titre');
    $description = $request->query->get('description');
    $pseudo = $request->query->get('pseudo');
    $categorieId = $request->query->get('categorie');

    $repository = $this->getDoctrine()->getRepository(Deck::class);

    $queryBuilder = $repository->createQueryBuilder('d')
        ->leftJoin('d.utilisateur', 'utilisateur')
        ->where('d.visibilite = 0');

    $searchAll = false;

    if(!$titre && !$description && !$pseudo){
        $searchAll = true;
    }
    
    $conditions = [];

    if ($titre || $searchAll) {
        $conditions[] = 'd.titre LIKE :query';
    }

    if ($description || $searchAll) {
        $conditions[] = 'd.description LIKE :query';
    }

    if ($pseudo || $searchAll) {
        $conditions[] = 'utilisateur.pseudo LIKE :query';
    }

    $queryBuilder->andWhere(implode(' OR ', $conditions))
        ->setParameter('query', '%'.$query.'%');


    if ($categorieId) {
        $qb->andWhere('d.categorie = :categorie')
           ->setParameter('categorie', $categoryId);
    }


    $decks = $queryBuilder->getQuery()->getResult();

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
