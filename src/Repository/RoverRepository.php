<?php

namespace App\Repository;

use App\Entity\Rover;
use App\Entity\RoverCamera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rover>
 *
 * @method Rover|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rover|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rover[]    findAll()
 * @method Rover[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rover::class);
    }

    public function save(Rover $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Rover $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
