<?php

namespace App\Entity;

use App\Repository\NumeriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumeriqueRepository::class)]
#[ORM\Table(name: 'NUMERIQUE')]
class Numerique implements FabricationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'numeriques')]
    #[ORM\JoinColumn(name: 'id_prod', nullable: false)]
    private ?Prod $prod = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_machine', nullable: false)]
    private ?Machine $machine = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'id_machine_bis')]
    private ?Machine $machineBis = null;

    #[ORM\OneToMany(mappedBy: 'numerique', targetEntity: JobNumerique::class)]
    private Collection $jobNumeriques;

    public function __construct()
    {
        $this->jobNumeriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProd(): ?Prod
    {
        return $this->prod;
    }

    public function getMachine(): ?Machine
    {
        return $this->machine;
    }

    public function getMachineBis(): ?Machine
    {
        return $this->machineBis;
    }

    /**
     * @return Collection<int, JobNumerique>
     */
    public function getJobNumeriques(): Collection
    {
        return $this->jobNumeriques;
    }

    public function addJobNumerique(JobNumerique $jobNumerique): self
    {
        if (!$this->jobNumeriques->contains($jobNumerique)) {
            $this->jobNumeriques->add($jobNumerique);
            $jobNumerique->setNumerique($this);
        }

        return $this;
    }

    public function removeJobNumerique(JobNumerique $jobNumerique): self
    {
        if ($this->jobNumeriques->removeElement($jobNumerique)) {
            // set the owning side to null (unless already changed)
            if ($jobNumerique->getNumerique() === $this) {
                $jobNumerique->setNumerique(null);
            }
        }

        return $this;
    }

    /**
     * @return JobInterface[]|null
     */
    public function getJobs(): Collection|null
    {
        return $this->getJobNumeriques()->isEmpty() ? null : $this->getJobNumeriques();
    }
}
