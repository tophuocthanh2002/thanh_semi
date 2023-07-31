<?php

namespace App\Controller;

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
use App\Entity\Theloai;
use App\Entity\ten_the_loai;
use App\Form\TruyenType;




#[Route('/tacgia')]
class TacgiaController extends AbstractController
{
    #[Route('/', name: 'app_list')]
    public function listAction(ManagerRegistry $doctrine): Response
    {
        $truyen = $doctrine->getRepository(Truyen::class)->findAll();
        return $this->render('tacgia/index.html.twig', ['tacgias' => $truyen]);
    }

    #[Route('/details/{id}', name: 'tacgia_details', methods: ['GET'])]
    public function detailsAction(ManagerRegistry $doctrine, $id): Response
    {
         $truyen = $doctrine->getRepository(Truyen::class)->find($id);

        if (!$truyen) {
            throw $this->createNotFoundException('Truyen not found');
        }

        $tacgia = $truyen->getTacgia();
        $tacgiaName = $tacgia ? $tacgia->getTentacgia() : 'Unknown';

        return $this->render('tacgia/details.html.twig', [
            'truyen' => $truyen,
            'tacgiaName' => $tacgiaName,
        ]);
    }
    #[Route("/delete/{id}", name: 'tacgia_delete', methods: ["GET"])]
    public function deleteAction(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $truyen = $entityManager->getRepository(Truyen::class)->find($id);

        if (!$truyen) {
            $this->addFlash('error', 'Truyen not found');
            return $this->redirectToRoute('app_truyen');
        }

        $entityManager->remove($truyen);
        $entityManager->flush();

        $this->addFlash('success', 'Truyen deleted');
        return $this->redirectToRoute('app_list');
    }
        #[Route("/edit/{id}", name:"tacgia_edit", methods: ['GET', 'POST'])]
    public function editAction(ManagerRegistry $doctrine, $id, Request $request, SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();
        $truyen = $entityManager->getRepository(Truyen::class)->find($id);
        $form = $this->createForm(TruyenType::class, $truyen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($truyen);
            $em->flush();

            return $this->redirectToRoute('app_list', [
                'id' => $truyen->getId()
            ]);
        }

        return $this->render('tacgia/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route("/create", name: 'tacgia_create', methods: ['GET','POST'])]
    public function createAction(Request $request, SluggerInterface $slugger, ManagerRegistry $registry): Response
    {
        $truyen = new Truyen();

        $form = $this->createForm(TruyenType::class, $truyen);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $registry->getManager();

            // Handle the uploaded image file
            $imageFile = $form->get('hinhanh')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Use the SluggerInterface to generate a unique name for the file
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where images are stored
                try {
                    $imageFile->move(
                        $this->getParameter('product_iamage_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle an exception if something goes wrong during file upload
                    // ...
                }

                // Update the "hinhanh" property of the Truyen entity with the file name
                $truyen->setHinhanh($newFilename);
            }

            $entityManager->persist($truyen);
            $entityManager->flush();

            $this->addFlash('success', 'Truyen created');
            return $this->redirectToRoute('app_list');
        }

        return $this->render('tacgia/create.html.twig', [
            'form' => $form->createView(),
            'truyen' => $truyen, // Pass $truyen variable to the template
        ]);
    }
}
