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
