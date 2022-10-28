<?php

namespace App\Repository;

use App\Entity\Healthgroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Healthgroup>
 *
 * @method Healthgroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Healthgroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Healthgroup[]    findAll()
 * @method Healthgroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HealthgroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Healthgroup::class);
    }

    public function add(Healthgroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Healthgroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
