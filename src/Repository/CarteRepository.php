<?php

namespace App\Repository;

use App\Entity\Carte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carte>
 *
 * @method Carte|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carte|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carte[]    findAll()
 * @method Carte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carte::class);
    }

    public function add(Carte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Carte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findCartesDeckNotInPositionCartesByUtilisateur($utilisateurId, $deckId)
    {
        // $qb = $this->createQueryBuilder('deck');
    
        // $qb->select('carte.id')
        //    ->innerJoin('deck.id', 'carte')
        //    ->where('deck.utilisateur_id = :utilisateur_id')
        //    ->setParameter('utilisateur_id', $utilisateurId)
        //    ->andWhere($qb->expr()->notIn(
        //        'carte.id',
        //        $this->createQueryBuilder('deck2')
        //             ->select('carte.id')
        //             ->innerJoin('carte', 'deck2')
        //             ->innerJoin('d2.positions', 'positionCarte')
        //             ->where('positionCarte.utilisateur_id = :utilisateur_id')
        //             ->getDQL()
        //     ));
    
        // return $qb->getQuery()->getResult();



        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $qb = $sub;
        $qb->select('car.id')
            ->from('App\Entity\Deck', 'd')
            ->innerJoin('d.cartes', 'car')
            ->innerJoin('App\Entity\PositionCarte', 'po', 'WITH', 'po.carte = car.id')
            ->where('po.utilisateur = :uId');


        $sub = $em->createQueryBuilder();
        $sub->select('cart.id')
            ->from('App\Entity\Deck', 'de')
            ->innerJoin('de.cartes', 'cart')
            ->where('de.utilisateur = :uId')
            ->andwhere('de.id = :dId ')
            ->andwhere($sub->expr()->notIn('cart.id', $qb->getDQL()))
            ->setParameter('uId', $utilisateurId)
            ->setParameter('dId', $deckId);

        $query = $sub->getQuery();
        return $query->getResult();


    }

//    /**
//     * @return Carte[] Returns an array of Carte objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Carte
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
