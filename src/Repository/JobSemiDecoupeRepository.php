<?php

namespace App\Repository;

use App\Entity\JobSemiDecoupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobSemiDecoupe>
 *
 * @method JobSemiDecoupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobSemiDecoupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobSemiDecoupe[]    findAll()
 * @method JobSemiDecoupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobSemiDecoupeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobSemiDecoupe::class);
    }

    public function save(JobSemiDecoupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobSemiDecoupe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return JobSemiDecoupe[] Returns an array of JobSemiDecoupe objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?JobSemiDecoupe
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
