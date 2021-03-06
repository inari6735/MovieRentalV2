<?php

namespace App\Repository;

use App\Entity\Collection;
use App\Entity\Movies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Collection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collection[]    findAll()
 * @method Collection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collection::class);
    }

    // /**
    //  * @return Collection[] Returns an array of Collection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Collection
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getCollectionMoviesData(int $userId): ?Array
    {
        return $this->createQueryBuilder('c')
            ->select('m.title', 'm.description', 'm.imgUrl', 'c.dateStart', 'c.dateEnd')
            ->where('c.userId = :userId')
            ->leftJoin(Movies::class, 'm', 'WITH', 'm.id = c.movieId')
            ->setParameters(['userId' => $userId])
            ->getQuery()
            ->getResult();
    }
}
