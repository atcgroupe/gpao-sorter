<?php

namespace App\Service\Prod;
use App\Entity\ProdData;

class ProdDataSorter
{
    public function __construct(
        private readonly ProdPointsCalculator $calculator
    ) {}

    /**
     * @param ProdData[] $prodDataList
     * @return array
     */
    public function getSortedItems(array $prodDataList): array
    {
        $this->setProdPoints($prodDataList);

        usort($prodDataList, function (ProdData $first, ProdData $second) {
            if ($first->getPoints() === $second->getPoints()) {
                return 0;
            }

            return $first->getPoints() < $second->getPoints() ? 1 : -1;
        });

        return $prodDataList;
    }

    /**
     * @param ProdData[] $prodDataList
     * @return void
     */
    private function setProdPoints(array $prodDataList): void
    {
        foreach ($prodDataList as $prodData) {
            $prodData->setPoints($this->calculator->getPoints($prodData->getProd()));
        }
    }
}
