<?php

namespace App\Repository;

use App\Entity\ConfirmCovoiturage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConfirmCovoiturage>
 *
 * @method ConfirmCovoiturage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfirmCovoiturage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfirmCovoiturage[]    findAll()
 * @method ConfirmCovoiturage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfirmCovoiturageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfirmCovoiturage::class);
    }



    public function findCitySuggestionsArrivalCount()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.lieuArrivee, COUNT(c.id) as suggestionCount')
            ->groupBy('c.lieuArrivee');

        $results = $qb->getQuery()->getResult();

        $citySuggestions = [];
        foreach ($results as $result) {
            $citySuggestions[$result['lieuArrivee']] = $result['suggestionCount'];
        }

        return $citySuggestions;
    }

    public function findCitySuggestionsDepartureCount()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.lieuDepart, COUNT(c.id) as suggestionCount')
            ->groupBy('c.lieuDepart');

        $results = $qb->getQuery()->getResult();

        $citySuggestions = [];
        foreach ($results as $result) {
            $citySuggestions[$result['lieuDepart']] = $result['suggestionCount'];
        }

        return $citySuggestions;
    }


//    /**
//     * @return ConfirmCovoiturage[] Returns an array of ConfirmCovoiturage objects
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

//    public function findOneBySomeField($value): ?ConfirmCovoiturage
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
