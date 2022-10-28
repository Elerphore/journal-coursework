<?php

namespace App\Repository;

use App\Entity\HostelSchedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HostelSchedule>
 *
 * @method HostelSchedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method HostelSchedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method HostelSchedule[]    findAll()
 * @method HostelSchedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HostelScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HostelSchedule::class);
    }

    public function add(HostelSchedule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HostelSchedule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
