<?php

namespace App\Repository;

use App\Entity\Covoiturage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Covoiturage>
 *
 * @method Covoiturage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Covoiturage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Covoiturage[]    findAll()
 * @method Covoiturage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CovoiturageRepository extends ServiceEntityRepository
{


    private $covoiturageRepository;


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Covoiturage::class);
    }


    public function save(Covoiturage $covoiturage, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($covoiturage);

        if ($flush) {
            $em->flush();
        }
    }

    public function remove(Covoiturage $covoiturage, $flush = false)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($covoiturage);

        if ($flush) {
            $entityManager->flush();
        }
    }

//    /**
//     * @return Covoiturage[] Returns an array of Covoiturage objects
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

//    public function findOneBySomeField($value): ?Covoiturage
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}