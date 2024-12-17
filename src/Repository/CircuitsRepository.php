<?php

namespace App\Repository;

use App\Entity\Circuits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Circuits>
 */
class CircuitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Circuits::class);
    }

    public function SearchAndPaginateCircuits(?string $country, int $season, int $page, int $limit): Paginator
    {
        $query = $this->createQueryBuilder('c');

        if ($season !== 0) {
            $query
                ->join('App\Entity\Races', 'r', 'WITH', 'r.circuit = c')
                ->join('r.season', 's')
                ->where('s.year = :season')
                ->setParameter('season', $season)
            ;
        }

        if ($country !== null) {
            $query->andWhere('c.country = :country')->setParameter('country', $country);
        }


        $query
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->setHint(Paginator::HINT_ENABLE_DISTINCT, false);

        return new Paginator($query, false);
    }


    //    /**
    //     * @return Circuits[] Returns an array of Circuits objects
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

    //    public function findOneBySomeField($value): ?Circuits
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
