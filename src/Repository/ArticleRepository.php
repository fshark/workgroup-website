<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param int $page
     * @param int $limit
     * @return Article[] Returns an array of Article objects
     */
    public function findList(int $page = 1, int $limit = 8): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.hidden = 0')
            ->andWhere('a.date < CURRENT_TIMESTAMP()')
            ->orderBy('a.date', 'DESC')
            ->setMaxResults($limit)
            ->setFirstResult(($page - 1) * $limit)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param int $id
     * @return Article
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneById(int $id): Article
    {
        return $this->createQueryBuilder('a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult()
        ;
    }

    /**
     * @return Article|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findLatest(): ?Article
    {
        $now = new \DateTime();
        return $this->createQueryBuilder('a')
            ->where('a.date > \''.$now->modify('-2 days')->format('Y-m-d').'\'')
            ->andWhere('a.date < CURRENT_TIMESTAMP()')
            ->setMaxResults(1)
            ->orderBy('a.date')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
