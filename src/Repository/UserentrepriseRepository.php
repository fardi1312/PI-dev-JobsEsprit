<?php

namespace App\Repository;

use App\Entity\Userentreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Userentreprise>
 *
 * @method Userentreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Userentreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Userentreprise[]    findAll()
 * @method Userentreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserentrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Userentreprise::class);
    }

//    /**
//     * @return Userentreprise[] Returns an array of Userentreprise objects
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

//    public function findOneBySomeField($value): ?Userentreprise
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
