<?php

namespace App\Repository;

use App\Entity\Competences;
use App\Entity\CompetencesValides;
use App\Entity\Referenciel;
use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Competences|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competences|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competences[]    findAll()
 * @method Competences[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competences::class);
    }

    // /**
    //  * @return Competences[] Returns an array of Competences objects
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

    /*
    public function findOneBySomeField($value): ?Competences
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByComp()
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.niveau', 'p')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function ShowCompetencesRefP($id_p,$id_r)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.competencesValides','cv')
            ->innerJoin('cv.referenciel','r')
            ->innerJoin('r.promos','p')
            ->andWhere('r.id = :val')
            ->setParameter('val', $id_r)
            ->andWhere('p.id = :va')
            ->setParameter('va', $id_p)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getCbyGbyRef($id1,$id2)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.groupeCompetences', 'g')
            ->innerJoin('g.referenciel', 'r')
            ->andWhere('r.id= :va')
            ->setParameter('va', $id1)
            ->andWhere('g.id= :val')
            ->setParameter('val', $id2)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();


    }
}
