<?php

namespace App\Entity;

use App\Repository\SemiDecoupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SemiDecoupeRepository::class)]
#[ORM\Table(name: 'SEMIDECOUPE')]
class SemiDecoupe implements FabricationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'semiDecoupe', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_prod', nullable: false)]
    private ?Prod $prod = null;

    #[ORM\OneToMany(mappedBy: 'semiDecoupe', targetEntity: JobSemiDecoupe::class)]
    private Collection $jobSemiDecoupes;

    public function __construct()
    {
        $this->jobSemiDecoupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProd(): ?Prod
    {
        return $this->prod;
    }

    /**
     * @return Collection<int, JobSemiDecoupe>
     */
    public function getJobSemiDecoupes(): Collection
    {
        return $this->jobSemiDecoupes;
    }

    public function addJobSemiDecoupe(JobSemiDecoupe $jobSemiDecoupe): self
    {
        if (!$this->jobSemiDecoupes->contains($jobSemiDecoupe)) {
            $this->jobSemiDecoupes->add($jobSemiDecoupe);
            $jobSemiDecoupe->setSemiDecoupe($this);
        }

        return $this;
    }

    public function removeJobSemiDecoupe(JobSemiDecoupe $jobSemiDecoupe): self
    {
        if ($this->jobSemiDecoupes->removeElement($jobSemiDecoupe)) {
            // set the owning side to null (unless already changed)
            if ($jobSemiDecoupe->getSemiDecoupe() === $this) {
                $jobSemiDecoupe->setSemiDecoupe(null);
            }
        }

        return $this;
    }

    /**
     * @return JobInterface[]|null
     */
    public function getJobs(): Collection|null
    {
        return $this->getJobSemiDecoupes()->isEmpty() ? null : $this->getJobSemiDecoupes();
    }
}
