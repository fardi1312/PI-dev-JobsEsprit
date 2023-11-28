<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

//    /**
//     * @return Offre[] Returns an array of Offre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offre
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function findNewestThree(): array
{
    return $this->createQueryBuilder('o')
        ->where('o.dateInscription >= :currentDate')
        ->setParameter('currentDate', new \DateTime())
        ->orderBy('o.dateInscription', 'ASC') // Ordre ascendant pour obtenir les plus proches en premier
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();
}

public function getPercentageByCompanyPerMonth()
{
    $date = new \DateTime();
    $year = $date->format('Y');

    $qb = $this->createQueryBuilder('o');

    $qb->select([
        'e.nomEntreprise as company',
        'COUNT(o) as offerCount',
        'SUBSTRING(o.dateInscription, 6, 2) as month',
        'SUBSTRING(o.dateInscription, 1, 4) as year'
    ])
        ->join('o.entrepriseid', 'e')
        ->where('SUBSTRING(o.dateInscription, 1, 4) = :currentYear')
        ->groupBy('company', 'year', 'month')  // Group by both company, year, and month
        ->orderBy('company')
        ->addOrderBy('year')
        ->addOrderBy('month')
        ->setParameter('currentYear', $year);

    $results = $qb->getQuery()->getResult();

    $percentages = [];
    foreach ($results as $result) {
        $company = $result['company'];
        $year = $result['year'];
        $month = $result['month'];
        $offerCount = $result['offerCount'];

        if (!isset($percentages[$company])) {
            $percentages[$company] = [];
        }

        if (!isset($percentages[$company][$year])) {
            $percentages[$company][$year] = [];
        }

        $percentages[$company][$year][$month] = $offerCount;
    }

    return $percentages;
}
public function searchByTitre($titre)
{
    return $this->createQueryBuilder('o')
        ->andWhere('o.titre LIKE :titre')
        ->setParameter('titre', '%' . $titre . '%')
        ->getQuery()
        ->getResult();
}


public function getMonthlyOfferCounts()
{
    $date = new \DateTime();
    $year = $date->format('Y');

    $queryBuilder = $this->createQueryBuilder('o')
        ->select([
            'COUNT(o.id) as offerCount',
            "SUBSTRING(o.dateInscription, 6, 2) as month",
        ])
        ->where("SUBSTRING(o.dateInscription, 1, 4) = :currentYear")
        ->groupBy('month')
        ->orderBy('month')
        ->setParameter('currentYear', $year);

    return $queryBuilder->getQuery()->getResult();
}









}
