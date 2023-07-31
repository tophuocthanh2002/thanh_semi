<?php

namespace App\Controller;

use App\Entity\Truyen;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\Form\isValid;
use App\Form\TruyenType;
use App\Repository\TruyenRepository;



class TruyenController extends AbstractController
{
    #[Route('/truyen', name: 'app_truyen', methods: ['GET'])]
    public function index(TruyenRepository $truyenRepository): Response
    {
        $truyen = $truyenRepository->findAll();

        return $this->render('truyen/index.html.twig', [
            'truyen' => $truyen,
        ]);
    }
#Route("/truyen/{id}/chuong/{chuong}", name="app_chitiettruyen")

    public function chitiettruyen($id, $chuong)
    {
        // Xử lý logic để lấy thông tin nội dung của chương dựa vào $id và $chuong
        // Ví dụ:
        $noidung = $this->getChuongContent($id, $chuong);

        return $this->render('truyen/chitiet.html.twig', [
            'noidung' => $noidung,
        ]);
    }

}


