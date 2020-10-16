<?php

namespace App\Repository;

use App\Entity\HopitalService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HopitalService|null find($id, $lockMode = null, $lockVersion = null)
 * @method HopitalService|null findOneBy(array $criteria, array $orderBy = null)
 * @method HopitalService[]    findAll()
 * @method HopitalService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HopitalServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HopitalService::class);
    }

    // /**
    //  * @return HopitalService[] Returns an array of HopitalService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HopitalService
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
