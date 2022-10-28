<?php

namespace App\Repository;

use App\Entity\ParentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParentType>
 *
 * @method ParentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentType[]    findAll()
 * @method ParentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentType::class);
    }

    public function add(ParentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
