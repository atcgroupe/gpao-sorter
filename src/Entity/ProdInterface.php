<?php

namespace App\Entity;

interface ProdInterface
{
    public function getSurface(): int|null;
    public function getItems(): int;
    public function getQuantity(): int;
}
