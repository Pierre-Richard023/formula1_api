<?php

namespace App\Repository;

use App\Entity\Races;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Races>
 */
class RacesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Races::class);
    }

    public function findRacesAndPaginate(?string $country, int $circuit, int $minLaps, int $maxLaps, int $page, int $limit): Paginator
    {

        $query = $this->createQueryBuilder('s')
            ->innerJoin('s.circuit', 'c');


        if ($country) {
            $query->andWhere('c.country = :country')
                ->setParameter('country', $country);
        }
        if ($circuit !== -1) {
            $query->andWhere('c.id = :circuit')
                ->setParameter('circuit', $circuit);;
        }

        if ($minLaps !== -1) {
            $query->andWhere('s.laps > :minLaps')
                ->setParameter('minLaps', $minLaps);;
        }

        if ($maxLaps !== -1) {
            $query->andWhere('s.laps < :maxLaps')
                ->setParameter('maxLaps', $maxLaps);;
        }


        $query
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->setHint(Paginator::HINT_ENABLE_DISTINCT, false);


        return new Paginator($query, false);
    }

    //    /**
    //     * @return Meetings[] Returns an array of Meetings objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Meetings
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
