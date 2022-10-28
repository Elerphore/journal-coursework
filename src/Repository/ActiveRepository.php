<?php

namespace App\Repository;

use App\Entity\Active;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Active>
 *
 * @method Active|null find($id, $lockMode = null, $lockVersion = null)
 * @method Active|null findOneBy(array $criteria, array $orderBy = null)
 * @method Active[]    findAll()
 * @method Active[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Active::class);
    }

    public function add(Active $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Active $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
