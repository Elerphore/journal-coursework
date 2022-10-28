<?php

namespace App\Repository;

use App\Entity\Classhour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classhour>
 *
 * @method Classhour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classhour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classhour[]    findAll()
 * @method Classhour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasshourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classhour::class);
    }

    public function add(Classhour $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Classhour $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
