<?php

namespace App\Service\Prod;
use App\Entity\Prod;

class ProdPointsCalculator
{
    /**
     * Nombre de points attribués à un dossier au départ du jour
     *
     * @var int
     */
    private int $prodTimeBase = 5000;

    /**
     * Nombre de points supprimés par jour
     *
     * @var int
     */
    private int $prodTimeDecrement = 50;

    /**
     * Facteur de ralentissement de la décrémentation.
     * 0 : Aucun, 2 : Maxi
     *
     * @var int
     */
    private int $prodTimeDecrementFactor = 2;

    /**
     * Nombre de points ajoutés par jour depuis la date de lancement
     *
     * @var int
     */
    private int $sentIncrement = 10;

    /**
     * Nombre de points ajoutés par m2 de production
     *
     * @var int
     */
    private int $surfacePoints = 2;

    /**
     * Nombre de points ajoutés par job
     *
     * @var int
     */
    private int $jobPoints = 10;

    /**
     * Nombre de points ajoutés par exemplaire de prod.
     *
     * @var int
     */
    private int $quantityPoints = 1;

    public function getPoints(Prod $prod): int
    {
        $points = $this->getProdTimePoints($prod->getDelaiProd());
        $points += $this->getSentDatePoints($prod->getPaoSentDate());
        $points += $this->getSurfacePoints($prod->getStatistics()->getSurface());
        $points += $this->getJobsPoints($prod->getStatistics()->getJobs());
        $points += $this->getQuantityPoints($prod->getStatistics()->getQuantity());

        return $points;
    }

    private function getProdTimePoints(?\DateTimeInterface $prodTime): int
    {
        if (!$prodTime) {
            return 0;
        }

        $prodDaysDiff = $this->getProdDaysDiff($prodTime);

        $decrement = $this->prodTimeDecrement;
        for ($i = 2; $i <= $prodDaysDiff; $i++) {
            $decrement += $this->prodTimeDecrement - intval(
                $this->prodTimeDecrement / ($i * $this->prodTimeDecrementFactor)
            );
        }

        return $this->prodTimeBase - $decrement;
    }

    private function getSentDatePoints(\DateTimeInterface $paoSentDate): int
    {
        return $this->sentIncrement * $this->getPaoSentDaysDiff($paoSentDate);
    }

    private function getSurfacePoints(?int $surface): int
    {
        return $surface ? $surface * $this->surfacePoints : 0;
    }

    private function getJobsPoints(?int $jobCount): int
    {
        return $jobCount ? $jobCount * $this->jobPoints : 0;
    }

    private function getQuantityPoints(?int $quantity): int
    {
        return  $quantity ? $quantity * $this->quantityPoints : 0;
    }

    private function getProdDaysDiff(\DateTimeInterface $prodTime): int
    {
        return $this->getWeekdayDifference(new \DateTime('NOW'), $prodTime);
    }

    private function getPaoSentDaysDiff(\DateTimeInterface $sentTime): int
    {
        return $this->getWeekdayDifference($sentTime, new \DateTime('NOW'));
    }

    private function getWeekdayDifference(\DateTimeInterface $startDate, \DateTimeInterface $endDate): int
    {
        $isWeekday = function (\DateTimeInterface $date) {
            return $date->format('N') < 6;
        };

        $days = $isWeekday($endDate) ? 1 : 0;

        while($startDate->diff($endDate)->days > 0) {
            $days += $isWeekday($startDate) ? 1 : 0;
            $startDate = $startDate->add(new \DateInterval("P1D"));
        }

        return $days;
    }
}

