<?php

namespace App\Controller;

use App\Repository\TruyenRepository; // Add this use statement
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\TruyenType;
use App\Entity\Truyen;
use App\Entity\Chuong;


class DetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'details_show', methods: ['GET'])]
    public function detailsAction(ManagerRegistry $doctrine, $id): Response
    {
        $truyen = $doctrine->getRepository(Truyen::class)->find($id);

        if (!$truyen) {
            throw $this->createNotFoundException('Truyen not found');
        }

        $chuong = null;
        $chuong = $truyen->getChuongs();

        // Nhận chương đầu tiên, giả sử các chương được sắp xếp chính xác trong bộ sưu tập.
        if ($chuong->count() > 0) {
            $chuong = $chuong->first();
        }

        return $this->render('details/index.html.twig', [
            'truyen' => $truyen,
            'chuong' => $chuong,
        ]);
    }

}