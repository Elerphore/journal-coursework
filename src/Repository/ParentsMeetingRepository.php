<?php

namespace App\Repository;

use App\Entity\ParentsMeeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParentsMeeting>
 *
 * @method ParentsMeeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentsMeeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentsMeeting[]    findAll()
 * @method ParentsMeeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentsMeetingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentsMeeting::class);
    }

    public function add(ParentsMeeting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParentsMeeting $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
