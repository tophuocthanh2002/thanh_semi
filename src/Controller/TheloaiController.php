<?php

namespace App\Controller;

use App\Entity\Tacgia;
use App\Entity\Theloai;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TheloaiController extends AbstractController
{
    #[Route('/theloai', name: 'app_theloai')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $theloaiRepo = $doctrine->getRepository(Theloai::class);
        $theloai = $theloaiRepo->findAll(); // Fetch Theloai entities

        return $this->render('theloai/index.html.twig', [
            'theloai' => $theloai,
        ]);
    }

    #[Route('/chitiet/{name}', name: 'theloai_chitiet', methods: ['GET', 'POST'])]
    public function chitietAction(Request $request, ManagerRegistry $doctrine, $name): Response
    {
        $repository = $doctrine->getRepository(Theloai::class);

        // Remove the entity identifier prefix from the name.
        $name = substr($name, strlen('theloai_'));

        // Debug information
        dump($name); // To check the value of $name

        // Find the entity by name
        $entityObject = $repository->findOneBy(['ten_the_loai' => $name]);

        // Debug information
        dump($entityObject); // To check the result of find() method

        if (!$entityObject) {
            throw $this->createNotFoundException('Entity not found: Theloai with name ' . $name);
        }

        return $this->render('theloai/chitiet.html.twig', [
            'entityObject' => $entityObject,
            'entityType' => 'theloai',
        ]);
    }
}
