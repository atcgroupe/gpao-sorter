<?php

namespace App\Repository;

use App\Entity\SemiDecoupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SemiDecoupe>
 *
 * @method SemiDecoupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method SemiDecoupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method SemiDecoupe[]    findAll()
 * @method SemiDecoupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SemiDecoupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SemiDecoupe::class);
    }

    public function save(SemiDecoupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SemiDecoupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SemiDecoupe[] Returns an array of SemiDecoupe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SemiDecoupe
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
