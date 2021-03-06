<?php

namespace App\Repository;

use App\Entity\Besoin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Besoin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Besoin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Besoin[]    findAll()
 * @method Besoin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BesoinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Besoin::class);
    }

    // /**
    //  * @return Besoin[] Returns an array of Besoin objects
    //  */

    public function findByEvent($id)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.evenement_id = :val')
            ->setParameter('val', $id)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Besoin
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
