<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[Route('/truyen')]
class YourBundleNameCreateUserCommand extends Command
{
    #[Route('/index', name: 'your_index')]
    public function indexAction(): Response
    {
        // Assuming you have fetched the 'truyen' data from the database
        $truyen = $this->getDoctrine()->getRepository(Truyen::class)->findAll();

        return $this->render('index.html.twig', [
            'truyen' => $truyen,
        ]);
    }
}
