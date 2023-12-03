<?php

namespace App\Service\Memory;

class Cell
{
    private bool $flip = false;
    private string $image;
    private bool $shouldBeCheck = false;
    private bool $paired = false;

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

    public function isShouldBeCheck(): bool
    {
        return $this->shouldBeCheck;
    }

    public function setShouldBeCheck(bool $shouldBeCheck): self
    {
        $this->shouldBeCheck = $shouldBeCheck;

        return $this;
    }

    public function isPaired(): bool
    {
        return $this->paired;
    }

    public function setPaired(bool $paired): self
    {
        $this->paired = $paired;

        return $this;
    }
}
