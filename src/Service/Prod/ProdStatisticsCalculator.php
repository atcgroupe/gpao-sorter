<?php

namespace App\Service\Prod;

use App\Entity\FabricationInterface;
use App\Entity\Prod;

class ProdStatisticsCalculator
{
    public static function getStatistics(Prod $prod): ProdStatistics
    {
        $stats = new ProdStatistics();

        if (!$prod->getNumeriques()->isEmpty()) {
            foreach ($prod->getNumeriques() as $fabrication) {
                $stats->addFabrication($fabrication->getMachine()->getLibelle());
                self::addStats($fabrication, $stats);
            }
        }

        if (!$prod->getFinitions()->isEmpty()) {
            foreach ($prod->getFinitions() as $fabrication) {
                $stats->addFabrication($fabrication->getType()->getLibelle());
                self::addStats($fabrication, $stats);
            }
        }

        if ($prod->getSemiDecoupe()) {
            $stats->addFabrication('SEMI-DECOUPE');
            self::addStats($prod->getSemiDecoupe(), $stats);
        }

        if ($prod->getCovering()) {
            $stats->addFabrication('COVERING');
            self::addStats($prod->getCovering(), $stats);
        }

        return $stats;
    }

    private static function addStats(FabricationInterface $fabrication, ProdStatistics $statistics): void
    {
        if (null === $fabrication->getJobs()) {
            return;
        }

        foreach ($fabrication->getJobs() as $job) {
            $statistics->addItems($job->getItems());
            $statistics->addQuantity($job->getQuantity());
            if (null !== $job->getSurface()) {
                $statistics->addSurface($job->getSurface());
            }
        }

        $statistics->addJobs(count($fabrication->getJobs()));
    }
}
