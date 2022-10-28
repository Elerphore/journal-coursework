<?php

namespace App\Repository;

use App\Entity\StudentParent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentParent>
 *
 * @method StudentParent|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentParent|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentParent[]    findAll()
 * @method StudentParent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentParentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentParent::class);
    }

    public function add(StudentParent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StudentParent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
