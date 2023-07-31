<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LichsuController extends AbstractController
{
    #[Route('/lichsu', name: 'app_lichsu')]
    public function index(): Response
    {
        return $this->render('lichsu/index.html.twig', [
            'controller_name' => 'LichsuController',
        ]);
    }
}
