<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Season;
use App\Enum\SeasonStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Season>
 *
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    /**
     * @return Season[]
     */
    public function findActivableSeasons(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.status = :status')
            ->andWhere('s.dateStart <= :date')
            ->setParameters([
                'status' => SeasonStatusEnum::CREATED,
                'date' => new \DateTime(),
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFinishedSeasons()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.status = :status')
            ->andWhere('s.dateEnd <= :date')
            ->setParameters([
                'status' => SeasonStatusEnum::ACTIVE,
                'date' => new \DateTime(),
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
