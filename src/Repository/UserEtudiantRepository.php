<?php

namespace App\Repository;

use App\Entity\UserEtudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEtudiant>
 *
 * @method UserEtudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEtudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEtudiant[]    findAll()
 * @method UserEtudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEtudiant::class);
    }

//    /**
//     * @return UserEtudiant[] Returns an array of UserEtudiant objects
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

//    public function findOneBySomeField($value): ?UserEtudiant
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
