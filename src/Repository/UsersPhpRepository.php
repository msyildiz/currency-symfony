<?php

namespace App\Repository;

use App\Entity\UsersPhp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersPhp|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersPhp|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersPhp[]    findAll()
 * @method UsersPhp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersPhpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersPhp::class);
    }

//    /**
//     * @return UsersPhp[] Returns an array of UsersPhp objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UsersPhp
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
