<?php

namespace App\Repository;

use App\Entity\Calendaractivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calendaractivity>
 *
 * @method Calendaractivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendaractivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendaractivity[]    findAll()
 * @method Calendaractivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendaractivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendaractivity::class);
    }

//    /**
//     * @return Calendaractivity[] Returns an array of Calendaractivity objects
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

//    public function findOneBySomeField($value): ?Calendaractivity
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
