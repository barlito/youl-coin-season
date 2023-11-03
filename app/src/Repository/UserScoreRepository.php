<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Leaderboard;
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
class UserScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserScore::class);
    }

    public function updateRank(Leaderboard $leaderboard): void
    {
        $sql = '
            WITH rank_mapping AS (
                SELECT id, RANK() OVER (ORDER BY CAST(us.score AS INT) DESC) AS rank
                FROM user_score AS us
                WHERE us.leaderboard_id = :leaderboard_id
            )
            
            UPDATE user_score AS us
            SET rank = rm.rank
            FROM rank_mapping AS rm
            WHERE us.id = rm.id AND us.leaderboard_id = :leaderboard_id;
        ';

        $this->getEntityManager()->getConnection()->executeStatement($sql, [
            'leaderboard_id' => $leaderboard->getId(),
        ]);

        // Clear the entity manager to avoid any side effect like get user scores with old rank
        $this->getEntityManager()->clear();
    }

    public function findByLeaderboard(Leaderboard $leaderboard)
    {
        return $this->createQueryBuilder('us')
            ->andWhere('us.leaderboard = :leaderboard')
            ->setParameter('leaderboard', $leaderboard)
            ->orderBy('us.rank', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
