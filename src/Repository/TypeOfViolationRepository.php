<?php

namespace App\Repository;

use App\Entity\TypeOfViolation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeOfViolation>
 *
 * @method TypeOfViolation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeOfViolation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeOfViolation[]    findAll()
 * @method TypeOfViolation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeOfViolationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeOfViolation::class);
    }

    public function add(TypeOfViolation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeOfViolation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
