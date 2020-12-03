<?php

namespace App\Repository;

use App\Entity\Contributor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contributor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contributor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contributor[]    findAll()
 * @method Contributor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contributor::class);
    }

    /**
     * @param $memberId
     * @return Contributor[] Returns an array of Contributor objects
     */
    public function findActorByMemberId($memberId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.production', 'p')
            ->andWhere('c.member = :member_id')
            ->andWhere('c.role = 1')
            ->setParameter('member_id', $memberId)
            ->orderBy('p.year', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $memberId
     * @return Contributor[] Returns an array of Contributor objects
     */
    public function findContributionsByMemberId($memberId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.production', 'p')
            ->andWhere('c.member = :member_id')
            ->andWhere('c.role != 1')
            ->setParameter('member_id', $memberId)
            ->orderBy('p.year', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param Contributor[]
     * @return array
     */
    public function findActorsByProduction($productionId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.member', 'm')
            ->andWhere('c.production = :production_id')
            ->andWhere('c.role = 1')
            ->setParameter('production_id', $productionId)
            ->orderBy('m.lastname', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param Contributor[]
     * @return array
     */
    public function findContributorsByProduction($productionId): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.role', 'r')
            ->andWhere('c.production = :production_id')
            ->andWhere('c.role != 1')
            ->setParameter('production_id', $productionId)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
