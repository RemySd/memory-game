<?php

namespace App\Controller;

use App\Service\Memory\Cell;
use App\Entity\MemoryGameHistory;
use App\Form\MemoryGameHistoryType;
use App\Service\Memory\MemoryManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MemoryGameHistoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemoryController extends AbstractController
{
    #[Route('/', name: 'app_memory')]
    public function index(MemoryGameHistoryRepository $memoryGameHistoryRepository): Response
    {
        $memoryHistories = $memoryGameHistoryRepository->findBy([], ['id' => 'DESC'], 10);

        return $this->render('memory/index.html.twig', ['memoryHistories' => $memoryHistories]);
    }

    #[Route('/edit-locale/{locale}', name: 'app_memory_edit_locale')]
    public function editLocale(string $locale, Request $request): Response
    {
        $request->getSession()->set('_locale', $locale);
        $route = $request->headers->get('referer', 'app_memory');

        return $this->redirect($route);
    }

    #[Route('/game-initialization ', name: 'app_memory_initialization')]
    public function initialization(MemoryManager $memoryManager): Response
    {
        $gridSize = $this->getGridSize();

        $memoryGrid = $memoryManager->initializeMemoryParty($gridSize['width'], $gridSize['height']);
        $memoryGrid->resetClickCount();
        $memoryManager->saveMemoryGrid($memoryGrid);

        return $this->redirectToRoute('app_memory_play');
    }

    public function getGridSize(): array
    {
        return [
            'width' => $this->getParameter('app.grid.width'),
            'height' => $this->getParameter('app.grid.height')
        ];
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

            $memoryGrid->incrementClickCount();
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
                $memoryGameHistory->setWidth($memoryGrid->getWidth());
                $memoryGameHistory->setHeight($memoryGrid->getHeight());

                $entityManager->persist($memoryGameHistory);
                $entityManager->flush();

                $memoryManager->saveMemoryGrid($memoryGrid);
                return $this->redirectToRoute('app_memory_initialization');
            }

            $parameters['form'] = $form;
        }

        return $this->render('memory/play.html.twig', $parameters);
    }
}
