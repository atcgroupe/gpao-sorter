<?php

namespace App\Controller;

use App\Repository\ProdDataRepository;
use App\Repository\ProdStatutEtapeRepository;
use App\Service\Prod\ProdDataSorter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    private const TYPE_PROD = 'prod';
    private const TYPE_COV = 'cov';
    private const TYPE_MAK = 'mak';

    #[Route('/{type}', name: 'home')]
    public function home(
        ProdDataSorter $dataSorter,
        ProdDataRepository $prodDataRepository,
        ProdStatutEtapeRepository $stepRepository,
        string $type = self::TYPE_PROD
    ): Response {
        $types = match ($type) {
            self::TYPE_PROD => [1, 2, 3],
            self::TYPE_MAK => [6],
            self::TYPE_COV => [1, 2, 3, 6],
            default => throw new \InvalidArgumentException(
                sprintf(
                    'Accepted values: %s | %s | %s',
                    self::TYPE_PROD,
                    self::TYPE_COV,
                    self::TYPE_MAK
                )
            )
        };
        $step = $stepRepository->find(5);

        $prodData = ($type === self::TYPE_COV)
            ? $prodDataRepository->findCoveringByStatusAndType($step, 1, $types)
            : $prodDataRepository->findByStatusAndType($step, 1, $types);
        $sortedData = $dataSorter->getSortedItems($prodData);

        return $this->render('home/home.html.twig', ['Data' => $sortedData, 'type' => $type]);
    }
}
