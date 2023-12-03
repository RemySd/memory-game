<?php

namespace App\Service\Memory;

use App\Service\Memory\Grid;

class MemoryManager
{
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

    public function initializeMemoryParty(): Grid
    {
        $grid = new Grid();
        $randomImages = $this->getRandomImages();

        foreach ($randomImages as $image) {
            $image = array_shift($randomImages);
            $cell = new Cell();
            $cell->setImage($image);
            $grid->addCell($cell);
        }

        return $grid;
    }

    /** 
     * @return string[]
     */
    public function getRandomImages(): array
    {
        $imagesName = array_merge(self::IMAGES, self::IMAGES);
        shuffle($imagesName);

        return $imagesName;
    }
}
