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
}
