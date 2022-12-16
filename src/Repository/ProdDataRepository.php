<?php

namespace App\Repository;

use App\Entity\ProdData;
use App\Entity\ProdStatutEtape;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProdData>
 *
 * @method ProdData|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProdData|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProdData[]    findAll()
 * @method ProdData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProdData::class);
    }

    public function save(ProdData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProdData $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ProdData[]
     */
    public function findByStatusAndType(ProdStatutEtape $step, int $status, array $prodTypes): array
    {
        return $this->createQueryBuilder('ProdData')
            ->innerJoin('ProdData.prod', 'Prod')
                ->addSelect('Prod')
            ->innerJoin('ProdData.codeAffaire', 'CodeAffaire')
                ->addSelect('CodeAffaire')
            ->leftJoin('Prod.numeriques', 'Numeriques')
                ->addSelect('Numeriques')
            ->leftJoin('Prod.semiDecoupe', 'SemiDecoupe')
                ->addSelect('SemiDecoupe')
            ->leftJoin('Prod.covering', 'Covering')
                ->addSelect('Covering')
            ->leftJoin('Prod.finitions', 'Finitions')
                ->addSelect('Finitions')
            ->innerJoin('CodeAffaire.client', 'Client')
                ->addSelect('Client')
            ->leftJoin('Numeriques.jobNumeriques', 'JobNumeriques')
                ->addSelect('JobNumeriques')
            ->leftJoin('Numeriques.machine', 'Machine')
                ->addSelect('Machine')
            ->leftJoin('SemiDecoupe.jobSemiDecoupes', 'JobSemiDecoupes')
                ->addSelect('JobSemiDecoupes')
            ->leftJoin('Covering.jobCoverings', 'JobCoverings')
                ->addSelect('JobCoverings')
            ->leftJoin('Finitions.jobFinitions', 'JobFinitions')
                ->addSelect('JobFinitions')
            ->leftJoin('Finitions.type', 'FinitionType')
                ->addSelect('FinitionType')
            ->andWhere('Covering is NULL')
            ->andWhere('Prod.statutEtape = :etape')
                ->setParameter('etape', $step)
            ->andWhere('Prod.statut = :statut')
                ->setParameter('statut', $status)
            ->andWhere('Prod.type IN (:types)')
                ->setParameter('types', $prodTypes)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return ProdData[]
     */
    public function findCoveringByStatusAndType(ProdStatutEtape $step, int $status, array $prodTypes): array
    {
        return $this->createQueryBuilder('ProdData')
            ->innerJoin('ProdData.prod', 'Prod')
                ->addSelect('Prod')
            ->innerJoin('ProdData.codeAffaire', 'CodeAffaire')
                ->addSelect('CodeAffaire')
            ->leftJoin('Prod.numeriques', 'Numeriques')
                ->addSelect('Numeriques')
            ->leftJoin('Prod.semiDecoupe', 'SemiDecoupe')
                ->addSelect('SemiDecoupe')
            ->innerJoin('Prod.covering', 'Covering')
                ->addSelect('Covering')
            ->leftJoin('Prod.finitions', 'Finitions')
                ->addSelect('Finitions')
            ->innerJoin('CodeAffaire.client', 'Client')
                ->addSelect('Client')
            ->leftJoin('Numeriques.jobNumeriques', 'JobNumeriques')
                ->addSelect('JobNumeriques')
            ->leftJoin('Numeriques.machine', 'Machine')
                ->addSelect('Machine')
            ->leftJoin('SemiDecoupe.jobSemiDecoupes', 'JobSemiDecoupes')
                ->addSelect('JobSemiDecoupes')
            ->leftJoin('Covering.jobCoverings', 'JobCoverings')
                ->addSelect('JobCoverings')
            ->leftJoin('Finitions.jobFinitions', 'JobFinitions')
                ->addSelect('JobFinitions')
            ->leftJoin('Finitions.type', 'FinitionType')
                ->addSelect('FinitionType')
            ->andWhere('Prod.statutEtape = :etape')
                ->setParameter('etape', $step)
            ->andWhere('Prod.statut = :statut')
                ->setParameter('statut', $status)
            ->andWhere('Prod.type IN (:types)')
                ->setParameter('types', $prodTypes)
            ->getQuery()
            ->getResult()
        ;
    }
}
