<?php

namespace App\Repository;

use App\Entity\GroupeCompetences;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GroupeCompetences|null find($id, $lockMode = null, $lockVersion = null)
 * @method GroupeCompetences|null findOneBy(array $criteria, array $orderBy = null)
 * @method GroupeCompetences[]    findAll()
 * @method GroupeCompetences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupeCompetencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeCompetences::class);
    }

    // /**
    //  * @return GroupeCompetences[] Returns an array of GroupeCompetences objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GroupeCompetences
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findBygrpCompetence()
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.competences', 'p')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByGrpComp()
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.competences', 'c')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
/*
    public function ShowCompetencesRefP($id_p,$id_r)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('cv.referenciel','r')
            ->andWhere('r.id = :val')
            ->setParameter('val', $id_r)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }*/

    public function findGRCComp()
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.referenciel', 'c')
            ->orderBy('g.id', 'ASC')
            ->getQuery()
            ->getResult();

    }
}
