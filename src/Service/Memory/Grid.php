<?php

namespace App\Service\Memory;

use App\Service\Memory\Cell;

class Grid
{
    /** 
     * @var Cell[]
     */
    private array $cells;

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

        foreach ($this->cells as $cellLine) {
            $countFlippedCell++;
        }

        if ($countFlippedCell === count($this->cells)) {
            return true;
        }

        return false;
    }

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
}
