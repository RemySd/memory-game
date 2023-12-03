<?php

namespace App\Controller;

use App\Service\Memory\MemoryManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemoryController extends AbstractController
{
    #[Route('/play', name: 'app_memory')]
    public function index(MemoryManager $memoryManager): Response
    {
        return $this->render('memory/index.html.twig', [
            'memoryGrid' => $memoryManager->initializeMemoryParty()
        ]);
    }

    // public function startGame(Request $request)
    // {
    //     
    // }
}
