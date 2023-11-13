<?php

namespace App\Repository;

use App\Entity\UserEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEntreprise>
 *
 * @method UserEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntreprise[]    findAll()
 * @method UserEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntreprise::class);
    }

//    /**
//     * @return UserEntreprise[] Returns an array of UserEntreprise objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserEntreprise
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
