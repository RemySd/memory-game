<?php

namespace App\Service\Memory;

use App\Service\Memory\Cell;

class Grid
{
    /** 
     * @var Cell[]
     */
    private array $cells;

    private int $width = 0;

    private int $height = 0;

    public function getCells(): array
    {
        return $this->cells;
    }

    public function setCells(array $cells): self
    {
        $this->cells = $cells;

        return $this;
    }

    public function addCell(Cell $cell): self
    {
        $this->cells[] = $cell;

        return $this;
    }

    public function getCellByPosition(int $position)
    {
        return $this->cells[$position];
    }

    public function isOver(): bool
    {
        $countFlippedCell = 0;

        foreach ($this->cells as $cell) {
            if ($cell->isFlip() || $cell->isShouldBeCheck()) {
                $countFlippedCell++;
            }
        }

        if ($countFlippedCell === count($this->cells)) {
            return true;
        }

        return false;
    }

    /** 
     * @var Cell[]
     */
    public function getCellToCheck(): array
    {
        $cellToChecks = [];

        foreach ($this->cells as $cell) {
            if ($cell->isShouldBeCheck()) {
                $cellToChecks[] = $cell;
            }
        }

        return $cellToChecks;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function cellToPairing(Cell $cell1, Cell $cell2): void
    {
        $cell1->setPaired(true);
        $cell2->setPaired(true);
        $cell1->setFlip(true);
        $cell2->setFlip(true);
        $cell1->setShouldBeCheck(false);
        $cell2->setShouldBeCheck(false);
    }
}
