<?php

namespace App\Controller;

use App\Service\Memory\Cell;
use App\Entity\MemoryGameHistory;
use App\Form\MemoryGameHistoryType;
use App\Repository\MemoryGameHistoryRepository;
use App\Service\Memory\MemoryManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemoryController extends AbstractController
{
    #[Route('/', name: 'app_memory')]
    public function index(MemoryGameHistoryRepository $memoryGameHistoryRepository): Response
    {
        $memoryHistories = $memoryGameHistoryRepository->findBy([], null, 10);

        return $this->render('memory/index.html.twig', ['memoryHistories' => $memoryHistories]);
    }

    #[Route('/game-initialization ', name: 'app_memory_initialization')]
    public function initialization(MemoryManager $memoryManager): Response
    {
        $memoryGrid = $memoryManager->initializeMemoryParty(2, 2);
        $memoryManager->saveMemoryGrid($memoryGrid);

        return $this->redirectToRoute('app_memory_play');
    }

    #[Route('/play', name: 'app_memory_play')]
    public function play(
        MemoryManager $memoryManager,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $memoryGrid = $memoryManager->getMemoryGrid();
        $cellPosition = $request->query->get('cell');

        if ($cellPosition != null) {

            /** 
             * @var Cell[]
             */
            $cellsToCheck = $memoryGrid->getCellToCheck();

            if (count($cellsToCheck) === 2) {
                $cell1 = array_shift($cellsToCheck);
                $cell2 = array_shift($cellsToCheck);

                if ($cell1->getImage() === $cell2->getImage()) {
                    $memoryGrid->cellToPairing($cell1, $cell2);
                } else {
                    $cell1->reset();
                    $cell2->reset();
                }
            }

            $currentCellClicked = $memoryGrid->getCellByPosition($cellPosition);
            $currentCellClicked->setFlip(true);
            $currentCellClicked->setShouldBeCheck(true);

            $memoryManager->saveMemoryGrid($memoryGrid);
        }

        $parameters = ['memoryGrid' => $memoryGrid];

        if ($memoryGrid->isOver()) {
            $memoryGameHistory = new MemoryGameHistory();

            $form = $this->createForm(MemoryGameHistoryType::class, $memoryGameHistory);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $memoryGameHistory->setCreatedAt((new \DateTimeImmutable('now')));
                $memoryGameHistory->setScore(100);

                $entityManager->persist($memoryGameHistory);
                $entityManager->flush();

                return $this->redirectToRoute('app_memory_initialization');
            }

            $parameters['form'] = $form;
            $parameters['hitCount'] = 5;
        }

        return $this->render('memory/play.html.twig', $parameters);
    }
}
