<?php

namespace App\Entity;

use App\Repository\ProdRepository;
use App\Service\Prod\ProdStatistics;
use App\Service\Prod\ProdStatisticsCalculator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use http\Exception\InvalidArgumentException;

#[ORM\Entity(repositoryClass: ProdRepository::class)]
#[ORM\Table(name: 'PROD')]
class Prod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $theme = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_statut_etape', nullable: false)]
    private ?ProdStatutEtape $statutEtape = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $statut = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column(name: 'delai_pao', type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delaiPao = null;

    #[ORM\Column(name: 'delai_prod', type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $delaiProd = null;

    #[ORM\Column(name: 'date_pao', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paoSentDate = null;

    #[ORM\OneToMany(mappedBy: 'prod', targetEntity: Numerique::class)]
    private Collection $numeriques;

    #[ORM\OneToOne(mappedBy: 'prod', cascade: ['persist', 'remove'])]
    private ?SemiDecoupe $semiDecoupe = null;

    #[ORM\OneToOne(mappedBy: 'prod', cascade: ['persist', 'remove'])]
    private ?Covering $covering = null;

    #[ORM\OneToMany(mappedBy: 'prod', targetEntity: Finition::class)]
    private Collection $finitions;

    /**
     * @var ProdStatistics|null;
     */
    private ?ProdStatistics $statistics = null;

    public function __construct()
    {
        $this->numeriques = new ArrayCollection();
        $this->finitions = new ArrayCollection();
    }

    /**
     * @return void
     */
    private function setStatistics(): void
    {
        $this->statistics = ProdStatisticsCalculator::getStatistics($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function getStatutEtape(): ?ProdStatutEtape
    {
        return $this->statutEtape;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function getDisplayType(): string
    {
        return match ($this->getType()) {
            1 => 'PROD',
            2 => 'VOLUME',
            3 => 'REFAB',
            4 => 'PROTO',
            5 => 'PROD INTERNE',
            6 => 'MAQUETTE'
        };
    }

    public function getDelaiPao(): ?\DateTimeInterface
    {
        return $this->delaiPao;
    }

    public function getDelaiProd(): ?\DateTimeInterface
    {
        return $this->delaiProd;
    }

    public function getPaoSentDate(): ?\DateTimeInterface
    {
        return $this->paoSentDate;
    }

    /**
     * @return Collection<int, Numerique>
     */
    public function getNumeriques(): Collection
    {
        return $this->numeriques;
    }

    public function addNumerique(Numerique $numerique): self
    {
        if (!$this->numeriques->contains($numerique)) {
            $this->numeriques->add($numerique);
            $numerique->setProd($this);
        }

        return $this;
    }

    public function removeNumerique(Numerique $numerique): self
    {
        if ($this->numeriques->removeElement($numerique)) {
            // set the owning side to null (unless already changed)
            if ($numerique->getProd() === $this) {
                $numerique->setProd(null);
            }
        }

        return $this;
    }

    public function getSemiDecoupe(): ?SemiDecoupe
    {
        return $this->semiDecoupe;
    }

    public function setSemiDecoupe(SemiDecoupe $semiDecoupe): self
    {
        // set the owning side of the relation if necessary
        if ($semiDecoupe->getProd() !== $this) {
            $semiDecoupe->setProd($this);
        }

        $this->semiDecoupe = $semiDecoupe;

        return $this;
    }

    public function getCovering(): ?Covering
    {
        return $this->covering;
    }

    public function setCovering(Covering $covering): self
    {
        // set the owning side of the relation if necessary
        if ($covering->getProd() !== $this) {
            $covering->setProd($this);
        }

        $this->covering = $covering;

        return $this;
    }

    /**
     * @return Collection<int, Finition>
     */
    public function getFinitions(): Collection
    {
        return $this->finitions;
    }

    public function addFinition(Finition $finition): self
    {
        if (!$this->finitions->contains($finition)) {
            $this->finitions->add($finition);
            $finition->setProd($this);
        }

        return $this;
    }

    public function removeFinition(Finition $finition): self
    {
        if ($this->finitions->removeElement($finition)) {
            // set the owning side to null (unless already changed)
            if ($finition->getProd() === $this) {
                $finition->setProd(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getNumberCode(): string
    {
        $letters = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U',
            'V', 'W', 'X', 'Y', 'Z'
        ];
        $base = intval($this->getNumero() / 26);
        $rest = $this->getNumero() - $base;
        $code = str_repeat('Z', $base);

        return $code . $letters[$rest - 1];
    }

    /**
     * @param string $type PAO|PROD
     * @return string
     */
    public function getFormattedDate(string $type): string
    {
        $date = match ($type) {
            'PAO' => $this->getDelaiPao(),
            'PROD' => $this->getDelaiProd(),
            default => throw new InvalidArgumentException('Possibles values: PAO | PROD')
        };

        return $date->format('d/m');
    }

    /**
     * @return ProdStatistics
     */
    public function getStatistics(): ProdStatistics
    {
        if (null === $this->statistics) {
            $this->setStatistics();
        }

        return $this->statistics;
    }

    /**
     * @return bool
     */
    public function hasStatistics(): bool
    {
        return true;
    }
}
