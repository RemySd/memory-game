<?php

namespace App\Controller;

use App\Service\Memory\Grid;
use App\Service\Memory\MemoryManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemoryController extends AbstractController
{
    #[Route('/', name: 'app_memory')]
    public function index(): Response
    {
        return $this->render('memory/index.html.twig');
    }

    #[Route('/game-initialization ', name: 'app_memory_initialization')]
    public function initialization(MemoryManager $memoryManager, Request $request, SerializerInterface $serializer): Response
    {
        $session = $request->getSession();
        $memoryParty = $memoryManager->initializeMemoryParty();
        $memoryPartyJson = $serializer->serialize($memoryParty, 'json');

        $session->set('memory_party', $memoryPartyJson);

        return $this->redirectToRoute('app_memory_play');
    }

    #[Route('/play', name: 'app_memory_play')]
    public function play(Request $request, SerializerInterface $serializer): Response
    {
        $session = $request->getSession();
        $memoryParty = $serializer->deserialize($session->get('memory_party'), Grid::class, 'json');

        dump($request->query);
        
        return $this->render('memory/play.html.twig', [
            'memoryGrid' => $memoryParty
        ]);
    }
}
