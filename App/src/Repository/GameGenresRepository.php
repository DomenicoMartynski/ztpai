<?php

namespace App\Repository;

use App\Entity\GameGenres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameGenres>
 *
 * @method GameGenres|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameGenres|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameGenres[]    findAll()
 * @method GameGenres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameGenresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameGenres::class);
    }

    //    /**
    //     * @return GameGenres[] Returns an array of GameGenres objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GameGenres
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
