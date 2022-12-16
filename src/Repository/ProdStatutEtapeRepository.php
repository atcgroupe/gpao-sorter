<?php

namespace App\Repository;

use App\Entity\ProdStatutEtape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProdStatutEtape>
 *
 * @method ProdStatutEtape|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProdStatutEtape|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProdStatutEtape[]    findAll()
 * @method ProdStatutEtape[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdStatutEtapeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProdStatutEtape::class);
    }

    public function save(ProdStatutEtape $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProdStatutEtape $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProdStatutEtape[] Returns an array of ProdStatutEtape objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProdStatutEtape
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
