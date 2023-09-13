<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserScore>
 *
 * @method UserScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserScore[]    findAll()
 * @method UserScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPointsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserScore::class);
    }

    //    /**
    //     * @return UserPoints[] Returns an array of UserPoints objects
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

    //    public function findOneBySomeField($value): ?UserPoints
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
