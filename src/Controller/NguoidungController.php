<?php

namespace App\Controller;

use App\Entity\Nguoidung;
use App\Form\NguoidungType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/nguoidung')]
class NguoidungController extends AbstractController
{
    #[Route('/', name: 'nguoidung_list')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $nguoidung = $doctrine->getRepository(Nguoidung::class)->findAll();
        return $this->render('nguoidung/index.html.twig', ['nguoidung' => $nguoidung]);
    }
    #[Route('/details/{id}', name: 'nguoidung_details', methods: ['GET'])]
    public function detailsAction(ManagerRegistry $doctrine, $id)
    {
        $nguoidung = $doctrine
            ->getRepository(Nguoidung::class)
            ->find($id);

        if (!$nguoidung) {
            throw $this->createNotFoundException('Nguoidung not found');
        }

        return $this->render('nguoidung/details.html.twig', [
            'nguoidung' => $nguoidung,
        ]);
    }
    #[Route("/delete/{id}", name: 'nguoidung_delete', methods: ["GET"])]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $nguoidung = $entityManager->getRepository(Nguoidung::class)->find($id);

        if (!$nguoidung) {
            $this->addFlash('error', 'Nguoidung not found');
            return $this->redirectToRoute('nguoidung_list');
        }

        $entityManager->remove($nguoidung);
        $entityManager->flush();

        $this->addFlash('success', 'Truyen deleted');
        return $this->redirectToRoute('nguoidung_list');
    }
    #[Route('/create', name: 'nguoidung_create', methods: ['GET', 'POST'])]
    public function createAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nguoidung = new Nguoidung();
        $form = $this->createForm(NguoidungType::class, $nguoidung);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nguoidung);
            $entityManager->flush();

            $this->addFlash('notice', 'Nguoidung Added');

            return $this->redirectToRoute('nguoidung_list');
        }

        return $this->render('nguoidung/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route("/edit/{id}", name:"nguoidung_edit", methods: ['GET', 'POST'])]
    public function editAction(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $nguoidung = $entityManager->getRepository(Nguoidung::class)->find($id);

        if (!$nguoidung) {
            throw $this->createNotFoundException('nguoidung not found');
        }

        $form = $this->createForm(NguoidungType::class, $nguoidung);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('nguoidung_list');
        }

        return $this->render('nguoidung/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
