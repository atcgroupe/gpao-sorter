<?php

namespace App\Service\Prod;

class ProdStatistics
{
    private int|null $surface = null;
    private int|null $items = null;
    private int|null $quantity = null;
    private int|null $jobs = null;
    private array $fabrications = [];

    /**
     * @return int|null
     */
    public function getSurface(): ?int
    {
        return $this->surface;
    }

    /**
     * @return string|null
     */
    public function getDisplaySurface(): string|null
    {
        return $this->getSurface() . 'm2';
    }

    /**
     * @param int $surface
     * @return void
     */
    public function addSurface(int $surface): void
    {
        $this->surface += $surface;
    }

    /**
     * @return int|null
     */
    public function getItems(): ?int
    {
        return $this->items;
    }

    /**
     * @return string|null
     */
    public function getDisplayItems(): string|null
    {
        $copies = ($this->getItems() > 1) ? ' fichiers' : ' fichier';

        return $this->getItems() . $copies;
    }

    /**
     * @param int $items
     * @return void
     */
    public function addItems(int $items): void
    {
        $this->items += $items;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @return string|null
     */
    public function getDisplayQuantity(): string|null
    {
        return $this->getQuantity() . 'EX';
    }

    /**
     * @param int $quantity
     * @return void
     */
    public function addQuantity(int $quantity): void
    {
        $this->quantity += $quantity;
    }

    /**
     * @return int|null
     */
    public function getJobs(): ?int
    {
        return $this->jobs;
    }

    /**
     * @return string
     */
    public function getDisplayJobs(): string
    {
        $label = $this->getJobs() > 1 ? ' jobs' : ' job';
        return $this->getJobs() . $label;
    }

    /**
     * @param int $number
     * @return void
     */
    public function addJobs(int $number): void
    {
        $this->jobs += $number;
    }

    /**
     * @return array|null
     */
    public function getFabrications(): ?array
    {
        return empty($this->fabrications) ? null : $this->fabrications;
    }

    public function getDisplayFabrication(): string
    {
        $label = '';
        $i = 0;
        $count = count($this->getFabrications());
        foreach ($this->getFabrications() as $fabrication) {
            $i++;
            $comma = $i < $count ? ', ' : '';
            $label .= $fabrication . $comma;
        }

        return $label;
    }

    /**
     * @param string $fabrication
     * @return void
     */
    public function addFabrication(string $fabrication): void
    {
        $this->fabrications[] = strtoupper($fabrication);
    }
}
