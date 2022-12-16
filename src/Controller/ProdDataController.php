<?php

namespace App\Controller;

use App\Repository\ProdDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProdDataController extends AbstractController
{
    #[Route('/api/prod-data/{id}')]
    public function findOne(int $id, ProdDataRepository $repository): JsonResponse
    {
        //$prodData =
    }
}
