<?php

namespace App\Service\Memory;

use App\Service\Memory\Grid;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MemoryManager
{
    private SerializerInterface $serializer;
    private RequestStack $requestStack;

    public const MEMORY_GRID_KEY = 'memory_grid';

    //création de la constante et la valeur click_count pour stocker le nombre de clics
    public const CLICK_COUNT_KEY = 'click_count';

    public const IMAGES = [
        'apple',
        'beer',
        'bread',
        'cheese',
        'eggs',
        'melon_water',
        'pretzel',
        'strawberry'
    ];

    public function __construct(SerializerInterface $serializer, RequestStack $requestStack)
    {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    public function initializeMemoryParty(int $width, int $height): Grid
    {
        $grid = new Grid();
        $grid->setWidth($width);
        $grid->setHeight($height);

        $randomImages = $this->getRandomImages($width * $height);

        foreach ($randomImages as $image) {
            $cell = new Cell();
            $cell->setImage($image);
            $grid->addCell($cell);
        }

        return $grid;
    }

    /** 
     * @return string[]
     */
    public function getRandomImages(int $nbImages): array
    {
        // See how handle this
        if ($nbImages > 16) {
            return [];
        }

        $imagesName = array_slice(self::IMAGES, 0, $nbImages / 2);
        $imagesName = array_merge($imagesName, $imagesName);

        shuffle($imagesName);

        return $imagesName;
    }

    public function saveMemoryGrid(Grid $grid): void
    {
        $memoryPartyJson = $this->serializer->serialize($grid, 'json');
        $this->requestStack->getSession()->set(self::MEMORY_GRID_KEY, $memoryPartyJson);
    }

    public function getMemoryGrid(): Grid
    {
        $memoryGridJson = $this->requestStack->getSession()->get(self::MEMORY_GRID_KEY);
        $memoryGrid = $this->serializer->deserialize($memoryGridJson, Grid::class, 'json');

        return $memoryGrid;
    }
    // Les méthodes pour la gestion du compteur de clics

    //Initialisation du compteur de clics à zéro
    public function initializeClickCount(): void
    {
        $this->requestStack->getSession()->set(self::CLICK_COUNT_KEY, 0);
    }

    // Incrémentation du compteur de clics
    public function incrementClickCount(): void
    {
        $session = $this->requestStack->getSession();
        $clickCount = $session->get(self::CLICK_COUNT_KEY, 0);
        $session->set(self::CLICK_COUNT_KEY, ++$clickCount);
    }

    // Récupération du compteur de clics actuel de la session
    public function getClickCount(): int
    {
        return $this->requestStack->getSession()->get(self::CLICK_COUNT_KEY, 0);
    }

}
