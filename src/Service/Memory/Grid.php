<?php

namespace App\Service\Memory;

use App\Service\Memory\Cell;

class Grid
{
    /** 
     * @var Cell[]
     */
    private array $cells = [];

    private ?Cell $previousCell = null;

    private bool $tryToPairing = false;
    
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

    public function getCellByPosition(int $position): ?Cell
    {
        return $this->cells[$position];
    }

    public function isOver(): bool
    {
        $countPairedCell = 0;

        foreach ($this->cells as $cell) {

            if ($cell->isPaired()) {
                $countPairedCell++;
            }
        }

        if ($countPairedCell === count($this->cells)) {
            return true;
        }

        return false;
    }

    public function getPreviousCell(): ?Cell
    {
        return $this->previousCell;
    }

    public function setPreviousCell(?Cell $previousCell): self
    {
        $this->previousCell = $previousCell;

        return $this;
    }

    public function isTryToPairing(): bool
    {
        return $this->tryToPairing;
    }

    public function setTryToPairing(bool $tryTopairing): self
    {
        $this->tryToPairing = $tryTopairing;

        return $this;
    }

    public function getCellsToHide(): array
    {
        $cellToHide = [];

        foreach ($this->cells as $cell) {
            if ($cell->isHideOnNextLoad()) {
                $cellToHide[] = $cell;
            }
        }

        return $cellToHide;
    }

    public function hideCellsToHide(): void
    {
        foreach ($this->cells as $cell) {
            if ($cell->isHideOnNextLoad()) {
                $cell->setHideOnNextLoad(false);
                $cell->setFlip(false);
            }
        }
    }
}
