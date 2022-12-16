<?php

namespace App\Entity;

use App\Repository\ProdDataRepository;
use App\Service\Prod\ProdPointsCalculator;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdDataRepository::class)]
#[ORM\Table('PROD_DATA')]
class ProdData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_code_affaire', nullable: false)]
    private ?CodeAffaire $codeAffaire = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_prod', nullable: false)]
    private ?Prod $prod = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paoSentDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $priority = null;

    /**
     * @var int|null
     */
    public ?int $points;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeAffaire(): ?CodeAffaire
    {
        return $this->codeAffaire;
    }

    public function getProd(): ?Prod
    {
        return $this->prod;
    }

    public function getPaoSentDate(): ?\DateTimeInterface
    {
        return $this->paoSentDate;
    }

    public function setPaoSentDate(?\DateTimeInterface $paoSentDate): self
    {
        $this->paoSentDate = $paoSentDate;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormattedSentDate(): string
    {
        return $this->getPaoSentDate()->format('d/m');
    }

    /**
     * @return int|null
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }

    /**
     * @param int|null $points
     */
    public function setPoints(?int $points): void
    {
        $this->points = $points;
    }
}
