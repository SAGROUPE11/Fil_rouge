<?php

namespace App\Repository;

use App\Entity\LivrablePartiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LivrablePartiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method LivrablePartiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method LivrablePartiel[]    findAll()
 * @method LivrablePartiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivrablePartielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivrablePartiel::class);
    }

    // /**
    //  * @return LivrablePartiel[] Returns an array of LivrablePartiel objects
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
    public function findOneBySomeField($value): ?LivrablePartiel
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*public function ShowCommentaire($id_livr)
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.apprenantLivrablePartielle','alp')
            ->innerJoin('alp.filDeDiscution','fd')
            ->innerJoin('fd.commentaires','c')
            ->andWhere('l.id = :val')
            ->setParameter('val', $id_livr)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }*/
}
