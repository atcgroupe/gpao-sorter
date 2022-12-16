<?php

namespace App\Entity;

use App\Repository\CoveringRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoveringRepository::class)]
#[ORM\Table(name: 'COVERING')]
class Covering implements FabricationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'covering', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'id_prod', nullable: false)]
    private ?Prod $prod = null;

    #[ORM\OneToMany(mappedBy: 'covering', targetEntity: JobCovering::class)]
    private Collection $jobCoverings;

    public function __construct()
    {
        $this->jobCoverings = new ArrayCollection();
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
     * @return Collection<int, JobCovering>
     */
    public function getJobCoverings(): Collection
    {
        return $this->jobCoverings;
    }

    public function addJobCovering(JobCovering $jobCovering): self
    {
        if (!$this->jobCoverings->contains($jobCovering)) {
            $this->jobCoverings->add($jobCovering);
            $jobCovering->setCovering($this);
        }

        return $this;
    }

    public function removeJobCovering(JobCovering $jobCovering): self
    {
        if ($this->jobCoverings->removeElement($jobCovering)) {
            // set the owning side to null (unless already changed)
            if ($jobCovering->getCovering() === $this) {
                $jobCovering->setCovering(null);
            }
        }

        return $this;
    }

    /**
     * @return JobInterface[]|null
     */
    public function getJobs(): Collection|null
    {
        return $this->getJobCoverings()->isEmpty() ? null : $this->getJobCoverings();
    }
}
