<?php

namespace App\Repository;

use App\Entity\Production;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Production|null find($id, $lockMode = null, $lockVersion = null)
 * @method Production|null findOneBy(array $criteria, array $orderBy = null)
 * @method Production[]    findAll()
 * @method Production[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Production::class);
    }

    /**
     * @return Production[] Returns an array of Production objects
     */
    public function findList()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.is_visible = 1')
            ->orderBy('p.year', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAny(int $count = 4, int $except = null): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.id', 'pl.title', 'i.filename')
            ->join('p.main_image', 'i')
            ->join('p.play', 'pl')
            ->andWhere('p.is_visible = 1');

        if (null !== $except) {
            $query = $query->andWhere('p.id != ' . $except);
        }

        $result = $query
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        shuffle($result);

        return array_slice($result, 0, $count);
    }
}
