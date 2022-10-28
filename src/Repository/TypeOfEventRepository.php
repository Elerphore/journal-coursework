<?php

namespace App\Repository;

use App\Entity\TypeOfEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeOfEvent>
 *
 * @method TypeOfEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOfEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOfEvent[]    findAll()
 * @method TypeOfEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOfEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOfEvent::class);
    }

    public function add(TypeOfEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeOfEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
