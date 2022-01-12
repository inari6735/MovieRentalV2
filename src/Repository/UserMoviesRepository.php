<?php

namespace App\Repository;

use App\Entity\UserMovies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserMovies|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMovies|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMovies[]    findAll()
 * @method UserMovies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMoviesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserMovies::class);
    }

    // /**
    //  * @return UserMovies[] Returns an array of UserMovies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMovies
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
