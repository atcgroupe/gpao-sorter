<?php

namespace App\Entity;

use App\Repository\JobCoveringRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobCoveringRepository::class)]
#[ORM\Table('JOB_COVERING')]
class JobCovering implements JobInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobCoverings')]
    #[ORM\JoinColumn(name: 'id_covering', nullable: false)]
    private ?Covering $covering = null;

    #[ORM\Column(name: 'nb_modeles')]
    private ?int $nbModeles = null;

    #[ORM\Column(name: 'qte_par_modele')]
    private ?int $qteParModele = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCovering(): ?Covering
    {
        return $this->covering;
    }

    public function getNbModeles(): ?int
    {
        return $this->nbModeles;
    }

    public function getQteParModele(): ?int
    {
        return $this->qteParModele;
    }

    public function getSurface(): int|null
    {
        return null;
    }

    public function getItems(): int
    {
        return $this->getNbModeles();
    }

    public function getQuantity(): int
    {
        return $this->getNbModeles() * $this->getQteParModele();
    }
}
