<?php

namespace App\Repository;

use App\Entity\LivrablesAttenduApprenant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrablesAttenduApprenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrablesAttenduApprenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrablesAttenduApprenant[]    findAll()
 * @method LivrablesAttenduApprenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrablesAttenduApprenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrablesAttenduApprenant::class);
    }

    // /**
    //  * @return LivrablesAttenduApprenant[] Returns an array of LivrablesAttenduApprenant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LivrablesAttenduApprenant
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
