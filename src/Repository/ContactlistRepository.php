<?php

namespace App\Repository;

use App\Entity\Contactlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contactlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contactlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contactlist[]    findAll()
 * @method Contactlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactlistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contactlist::class);
    }

    // /**
    //  * @return Contactlist[] Returns an array of Contactlist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findFriends($id)
    {
        return $this->createQueryBuilder('c')
            ->where('c.userTwo =:val')
            ->orWhere(
                'c.userOne = :val'
            )
            ->setParameter('val', $id)
            ->getQuery()
            ->getArrayResult();
    }
}
