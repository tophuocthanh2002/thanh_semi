<?php

namespace App\Controller;

use App\Repository\ChuongRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TruyenRepository;
use App\Entity\Truyen;
use App\Form\TruyenType;
use App\Form\ChuongType;
use App\Entity\Chuong;

class DoctruyenController extends AbstractController
{
    #[Route('/doctruyen', name: 'app_doctruyen', methods: ['GET'])]
    public function indexAction(ManagerRegistry $doctrine): Response
    {
        $truyens = $doctrine->getRepository(Truyen::class)->findAll();

        return $this->render('doctruyen/index.html.twig', [
            'truyen' => $truyens,
        ]);
    }

    #[Route('/doctruyen/{id}', name: 'app_doctruyen', methods: ['GET'])]
    public function viewChuong(ManagerRegistry $doctrine, $id): Response
    {
        $truyen = $doctrine->getRepository(Truyen::class)->find($id);

        if (!$truyen) {
            throw $this->createNotFoundException('Truyen not found');
        }

        return $this->render('doctruyen/doctruyen.html.twig', [
            'truyen' => $truyen,
        ]);
    }

}
