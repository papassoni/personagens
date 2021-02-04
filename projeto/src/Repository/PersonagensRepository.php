<?php

namespace App\Repository;

use App\Entity\Personagens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personagens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personagens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personagens[]    findAll()
 * @method Personagens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonagensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personagens::class);
    }

    // /**
    //  * @return Personagens[] Returns an array of Personagens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Personagens
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
