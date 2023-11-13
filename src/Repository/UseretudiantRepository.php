<?php

namespace App\Repository;

use App\Entity\Useretudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Useretudiant>
 *
 * @method Useretudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Useretudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Useretudiant[]    findAll()
 * @method Useretudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UseretudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Useretudiant::class);
    }

//    /**
//     * @return Useretudiant[] Returns an array of Useretudiant objects
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

//    public function findOneBySomeField($value): ?Useretudiant
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
