<?php

namespace App\Entity;

use App\Repository\JobSemiDecoupeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobSemiDecoupeRepository::class)]
#[ORM\Table('JOB_SEMIDECOUPE')]
class JobSemiDecoupe implements JobInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobSemiDecoupes')]
    #[ORM\JoinColumn(name: 'id_dossier', nullable: false)]
    private ?SemiDecoupe $semiDecoupe = null;

    #[ORM\Column(nullable: true)]
    private ?int $largeur = null;

    #[ORM\Column(nullable: true)]
    private ?int $hauteur = null;

    #[ORM\Column(name: 'nb_modeles')]
    private ?int $nbModeles = null;

    #[ORM\Column(name: 'qte_par_modele')]
    private ?int $qteParModele = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSemiDecoupe(): ?SemiDecoupe
    {
        return $this->semiDecoupe;
    }

    public function getLargeur(): ?int
    {
        return $this->largeur;
    }

    public function getHauteur(): ?int
    {
        return $this->hauteur;
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
        return ($this->getLargeur() && $this->getHauteur())
            ? $this->getLargeur() / 1000 * $this->getHauteur() / 1000 * $this->getQuantity()
            : null;
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
