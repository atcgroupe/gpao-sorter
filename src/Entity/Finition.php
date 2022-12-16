<?php

namespace App\Entity;

use App\Repository\FinitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FinitionRepository::class)]
#[ORM\Table('FINITION')]
class Finition implements FabricationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'finitions')]
    #[ORM\JoinColumn(name: 'id_prod', nullable: false)]
    private ?Prod $prod = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_finition_type', nullable: false)]
    private ?FinitionType $type = null;

    #[ORM\OneToMany(mappedBy: 'finition', targetEntity: JobFinition::class)]
    private Collection $jobFinitions;

    public function __construct()
    {
        $this->jobFinitions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProd(): ?Prod
    {
        return $this->prod;
    }

    public function getType(): ?FinitionType
    {
        return $this->type;
    }

    /**
     * @return Collection<int, JobFinition>
     */
    public function getJobFinitions(): Collection
    {
        return $this->jobFinitions;
    }

    public function addJobFinition(JobFinition $jobFinition): self
    {
        if (!$this->jobFinitions->contains($jobFinition)) {
            $this->jobFinitions->add($jobFinition);
            $jobFinition->setFinition($this);
        }

        return $this;
    }

    public function removeJobFinition(JobFinition $jobFinition): self
    {
        if ($this->jobFinitions->removeElement($jobFinition)) {
            // set the owning side to null (unless already changed)
            if ($jobFinition->getFinition() === $this) {
                $jobFinition->setFinition(null);
            }
        }

        return $this;
    }

    /**
     * @return JobInterface[]|null
     */
    public function getJobs(): Collection|null
    {
        return $this->getJobFinitions()->isEmpty() ? null : $this->getJobFinitions();
    }
}
