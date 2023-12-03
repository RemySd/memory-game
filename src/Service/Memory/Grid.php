<?php

namespace App\Service\Memory;

class Grid
{
    /** 
     * @var array[]
     */
    private array $cells;

    public function getCells(): array
    {
        return $this->cells;
    }

    public function addCell(Cell $cell): self
    {
        $this->cells[] = $cell;

        return $this;
    }

    public function isOver(): bool
    {
        $countFlippedCell = 0;

        foreach ($this->cells as $cellLine) {
            foreach ($cellLine as $cell) {
                $countFlippedCell++;
            }
        }

        if ($countFlippedCell === count($this->cells)) {
            return true;
        }

        return false;
    }
}
