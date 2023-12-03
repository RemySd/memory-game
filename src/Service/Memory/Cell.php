<?php

namespace App\Service\Memory;

class Cell
{
    private bool $flip = false;
    private string $image;
    // private Cell $similarCell;

    public function isFlip(): bool
    {
        return $this->flip;
    }

    public function setFlip(bool $flip): self
    {
        $this->flip = $flip;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
