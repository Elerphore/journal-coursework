<?php

namespace App\Repository;

use App\Entity\Branch;
use App\Entity\Group;
use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function add(Group $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Group $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Group[] Returns an array of Group objects
     */
    public function findByBranch(Branch $branch): array
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.specialty', 's')
            ->where('s.branch = :branch')
            ->setParameter('branch', $branch)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByInstructor(Role $roles): array
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.roles', 'r')
            ->where('r.id = :roles')
            ->setParameter('roles', $roles)
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

}
