<?php

namespace App\Repository;

use App\Entity\StudentViolation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentViolation>
 *
 * @method StudentViolation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentViolation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentViolation[]    findAll()
 * @method StudentViolation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentViolationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentViolation::class);
    }

    public function add(StudentViolation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StudentViolation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
