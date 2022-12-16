<?php

namespace App\Entity;

use App\Repository\ProdStatutEtapeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdStatutEtapeRepository::class)]
#[ORM\Table(name: 'PROD_STATUT_ETAPE')]
class ProdStatutEtape
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }
}
