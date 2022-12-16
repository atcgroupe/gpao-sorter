<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface FabricationInterface
{
    /**
     * @return JobInterface[]|null
     */
    public function getJobs(): Collection|null;
}
