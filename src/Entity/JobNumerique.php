<?php

namespace App\Entity;

use App\Repository\JobNumeriqueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobNumeriqueRepository::class)]
#[ORM\Table(name: 'JOB_NUMERIQUE')]
class JobNumerique implements JobInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobNumeriques')]
    #[ORM\JoinColumn(name: 'id_dossier', nullable: false)]
    private ?Numerique $numerique = null;

    #[ORM\Column(nullable: true)]
    private ?int $largeur = null;

    #[ORM\Column(nullable: true)]
    private ?int $hauteur = null;

    #[ORM\Column(name: 'nb_modeles')]
    private ?int $nbModeles = null;

    #[ORM\Column(name: 'qte_par_modele')]
    private ?int $qteParModele = null;

    #[ORM\Column(name: 'recto_verso', type: Types::SMALLINT)]
    private ?int $rectoVerso = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerique(): ?Numerique
    {
        return $this->numerique;
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

    public function getRectoVerso(): ?int
    {
        return $this->rectoVerso;
    }

    public function getSurface(): int|null
    {
        $rectoVerso = $this->getRectoVerso() === 1 ? 1 : 2;
        return ($this->getLargeur() && $this->getHauteur())
            ? round(($this->getLargeur() / 1000) * ($this->getHauteur() / 1000) * $this->getQuantity() * $rectoVerso)
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
