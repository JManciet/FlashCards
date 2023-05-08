<?php

namespace App\Repository;

use App\Entity\Deck;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Deck>
 *
 * @method Deck|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deck|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deck[]    findAll()
 * @method Deck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deck::class);
    }

    public function add(Deck $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Deck $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findDecksByfilter(Request $request)
    {
        // Récupération des filtres de recherche à partir de la requête GET
        $query = $request->query->get('query');
        $titre = $request->query->get('titre');
        $description = $request->query->get('description');
        $pseudo = $request->query->get('pseudo');
        $categorieId = $request->query->get('categorie');

        // Construction d'un objet QueryBuilder pour effectuer la requête
        $queryBuilder = $this->createQueryBuilder('d')
            //j'ai joint également la table Utilisateur pour permettre la recherche sur le pseudo de l'utilisateur 
            //et ajouter une condition pour exclure les decks en mode privé.
            ->leftJoin('d.utilisateur', 'utilisateur')
            ->where('d.visibilite = 0'); // pour exclure les decks en mode privés

        // Quand aucune option de filtre n'est selectioné chercher dans tout les champs par défaut
        $searchAll = false;
        if(!$titre && !$description && !$pseudo){
            $searchAll = true;
        }
        
        // Préconstruction des conditions de la requête, qui incluent des comparaisons "LIKE", en fonction des filtres sélectionnés
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

        // Concaténation des conditions avec OR pour construire la clause WHERE de la requête
        $queryBuilder->andWhere(implode(' OR ', $conditions))
            ->setParameter('query', '%'.$query.'%');
    
        // Ajout de la condition pour la catégorie sélectionnée (si applicable)
        if ($categorieId) {
            $queryBuilder->andWhere('d.categorie = :categorieId')
            ->setParameter('categorieId', $categorieId);
        }

        // Exécution de la requête et retour des résultats
        return $queryBuilder->getQuery()->getResult();
    }




    // Find/search articles by title/content
    public function findArticlesByName(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.titre', ':query'),
                        $qb->expr()->like('p.description', ':query'),
                    ),
                    $qb->expr()->isNotNull('p.date_creation')
                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Deck[] Returns an array of Deck objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Deck
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
