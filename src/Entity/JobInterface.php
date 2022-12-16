<?php

namespace App\Entity;

interface JobInterface
{
    public function getSurface(): int|null;
    public function getItems(): int;
    public function getQuantity(): int;
}
