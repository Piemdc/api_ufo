<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function findByCreatorID($id)
    {
        return $this->createQueryBuilder('e')
            ->Where('e.creator_id = :id')
            ->setParameter('id', $id)
            ->orderBy('e.date', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }


    public function findByID($id)
    {
        return $this->createQueryBuilder('e')
            ->Where('e.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
}
