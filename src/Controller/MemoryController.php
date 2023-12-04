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

        /** 
         * @var Grid
         */
        $memoryParty = $serializer->deserialize($session->get('memory_party'), Grid::class, 'json');

        $cellPosition = $request->query->get('cell');

        if ($cellPosition != null) {

            $cellsToCheck = $memoryParty->getCellToCheck();

            if (count($cellsToCheck) === 2) {
                if ($cellsToCheck[0]->getImage() === $cellsToCheck[1]->getImage()) {
                    $cellsToCheck[0]->setPaired(true);
                    $cellsToCheck[1]->isPaired(true);
                    $cellsToCheck[0]->setShouldBeCheck(false);
                    $cellsToCheck[1]->setShouldBeCheck(false);
                } else {
                    $cellsToCheck[0]->setShouldBeCheck(false);
                    $cellsToCheck[1]->setShouldBeCheck(false);
                    $cellsToCheck[0]->setFlip(false);
                    $cellsToCheck[1]->setFlip(false);
                }
            }

            $currentCellClicked = $memoryParty->getCellByPosition($cellPosition);
            $currentCellClicked->setFlip(true);
            $currentCellClicked->setShouldBeCheck(true);

            $memoryPartyJson = $serializer->serialize($memoryParty, 'json');
            $session->set('memory_party', $memoryPartyJson);
        }

        if ($memoryParty !== null && $memoryParty->isOver()) {
            return $this->redirectToRoute('app_memory_done');
        }

        return $this->render('memory/play.html.twig', [
            'memoryGrid' => $memoryParty
        ]);
    }

    #[Route('/play/done ', name: 'app_memory_done')]
    public function done(): Response
    {
        return $this->render('memory/done.html.twig');
    }
}
