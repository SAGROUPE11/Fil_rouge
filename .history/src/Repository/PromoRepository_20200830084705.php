<?php

namespace App\Repository;

use App\Entity\Promo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**xœxœ
 * @method Promo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promo[]    findAll()
 * @method Promo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promo::class);
    }

    // /**
    //  * @return Promo[] Returns an array of Promo objects
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
        ;w
    }
    */

    /*
    public function findOneBySomeField($value): ?Promo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findByPromo()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.referenciel','r')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByPromotion()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.referentiel','r')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findGroupePrincipal()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.formateur','f')
            ->innerJoin('f.groupe','g')
            ->andWhere('g.type= :val')
            ->setParameter('val', 'principal')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
   
    public function ApprenantEnAttente()
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.groupe','g')
            ->innerJoin('g.apprenant','a')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
   
     
    public function findOneByIdOk($id): ?Promo
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.groupe','g')
            ->innerJoin('g.formateurs','f')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findFormateurPromo($id): ?Promo
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.formateur','f')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
