<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reward;
use App\Enum\RewardStatusEnum;
use App\Enum\SeasonStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reward>
 *
 * @method Reward|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reward|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reward[]    findAll()
 * @method Reward[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RewardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reward::class);
    }

    public function findUnclaimedRewardsFromClosedSeasons()
    {
        return $this->createQueryBuilder('r')
            ->join('r.season', 's')
            ->andWhere('r.status = :reward_unclaimed')
            ->andWhere('s.status = :season_finished')
            ->setParameters([
                'reward_unclaimed' => RewardStatusEnum::UNCLAIMED,
                'season_finished' => SeasonStatusEnum::FINISHED,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
