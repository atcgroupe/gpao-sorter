<?php

namespace App\Entity;

use App\Repository\CodeAffaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodeAffaireRepository::class)]
#[ORM\Table(name: 'CODE_AFFAIRE')]
class CodeAffaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $theme = null;

    #[ORM\Column(name: 'libelle_recherche', length: 12)]
    private ?string $libelleRecherche = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_client', nullable: false)]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function getLibelleRecherche(): ?string
    {
        return $this->libelleRecherche;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }
}
