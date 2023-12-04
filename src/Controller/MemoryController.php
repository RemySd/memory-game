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
        $memoryParty = $serializer->deserialize($session->get('memory_party', null), Grid::class, 'json');

        $memoryParty->hideCellsToHide();

        $cellPosition = $request->query->get('cell');

        $currentCellClicked = null;

        if ($cellPosition !== null) {
            $currentCellClicked = $memoryParty->getCellByPosition($cellPosition);
            $currentCellClicked->setFlip(true);
        }

        $previousCell = $memoryParty->getPreviousCell();

        if ($previousCell !== null && $previousCell->isPaired() === false && count($memoryParty->getCellsToHide()) === 0) {
            if ($previousCell->getImage() === $currentCellClicked->getImage()) {
                $currentCellClicked->setPaired(true);
                $currentCellClicked->setFlip(true);
                $previousCell->setPaired(true);
            } else {
                $currentCellClicked->setHideOnNextLoad(true);
                $previousCell->setHideOnNextLoad(true);
            }
        }

        $memoryParty->setPreviousCell($currentCellClicked);

        $memoryPartyJson = $serializer->serialize($memoryParty, 'json');
        $session->set('memory_party', $memoryPartyJson);

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
