<?php

namespace App\Repository;

use App\Entity\Drivers;
use App\Entity\EntrantsDrivers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntrantsDrivers>
 */
class EntrantsDriversRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntrantsDrivers::class);
    }


    public function getDriversEntrants(Drivers $driverId): ?EntrantsDrivers
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.drivers = :driverId')
            ->setParameter('driverId', $driverId)
            ->getQuery()
            ->getOneOrNullResult();
    }







//    public function getDriversEntrants(Drivers $driverId, int $page, int $limit): Paginator
//    {
//
//        $query = $this->createQueryBuilder('d')
//            ->andWhere('d.drivers = :driverId')
//            ->setParameter('driverId', $driverId)
//            ->setFirstResult(($page - 1) * $limit)
//            ->setMaxResults($limit)
//            ->getQuery()
//            ->setHint(Paginator::HINT_ENABLE_DISTINCT, false);
//
//        return new Paginator($query, false);
//    }


    //    /**
    //     * @return DriverTeams[] Returns an array of DriverTeams objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DriverTeams
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
