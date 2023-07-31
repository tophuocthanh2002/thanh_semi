<?php

namespace App\Controller;

use App\Form\TruyenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Truyen;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Tacgia;
use App\Entity\Chuong;
use App\Form\ChuongType;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/chuong')]
class ChuongController extends AbstractController
{
    #[Route('/', name: 'chuong_list')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $chuongs = $doctrine->getRepository(Chuong::class)->findAll(); // Fetch Chuong entities
        return $this->render('chuong/index.html.twig', ['chuong' => $chuongs]);
    }
    #[Route('/details/{id}', name: 'chuong_details', methods: ['GET'])]
    public function detailsAction(ManagerRegistry $doctrine, $id): Response
    {
        $chuong = $doctrine->getRepository(Chuong::class)->find($id); // Fetch Chuong entity

        if (!$chuong) {
            throw $this->createNotFoundException('Chuong not found');
        }

        $tenchuong = $chuong->getTenchuong();
        $noidung = $chuong->getNoidung();

        return $this->render('chuong/details.html.twig', [
            'chuong' => $chuong,
            'tenchuong' => $tenchuong,
            'noidung' => $noidung,
        ]);
    }
    #[Route("/delete/{id}", name: 'chuong_delete', methods: ["GET"])]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $chuong = $entityManager->getRepository(Chuong::class)->find($id);

        if (!$chuong) {
            $this->addFlash('error', 'chuong not found');
            return $this->redirectToRoute('chuong_list');
        }

        $entityManager->remove($chuong);
        $entityManager->flush();

        $this->addFlash('success', 'chuong deleted');
        return $this->redirectToRoute('chuong_list');
    }
    #Route("/chuong/create", name="chuong_create", methods: {"GET", "POST"})
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function createAction(Request $request, SluggerInterface $slugger): Response
    {
        $chuong = new Chuong();
        $form = $this->createForm(ChuongType::class, $chuong);

        if ($this->saveChanges($form, $request, $chuong)) {
            $this->addFlash(
                'notice',
                'Chuong Added'
            );

            return $this->redirectToRoute('chuong_list'); //  thay thế 'chuong_list' bằng lộ trình thích hợp cho danh sách các thực thể "Chuong" .
        }

        return $this->render('chuong/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function saveChanges($form, $request, $chuong)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($chuong);
            $this->entityManager->flush(); // Sử dụng EntityManagerInterface được chèn

            return true;
        }

        return false;
    }
    #[Route("/edit/{id}", name:"chuong_edit", methods: ['GET', 'POST'])]
    public function editAction(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $chuong = $entityManager->getRepository(Chuong::class)->find($id);

        if (!$chuong) {
            throw $this->createNotFoundException('Chuong not found');
        }

        $form = $this->createForm(ChuongType::class, $chuong);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('chuong_list');
        }

        return $this->render('chuong/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
