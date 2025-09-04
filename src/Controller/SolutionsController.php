<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SolutionsController extends AbstractController
{
    #[Route('/solution', name: 'app_solution')]
    public function index(): Response
    {
        return $this->render('solutions/index.html.twig', [
            'controller_name' => 'SolutionsController',
        ]);
    }
}
