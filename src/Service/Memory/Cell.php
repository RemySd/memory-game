<?php

namespace App\Service\Memory;

class Cell
{
    private bool $flip = false;
    private string $image;
    private bool $paired = false;
    private bool $hideOnNextLoad = false;

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

    public function isPaired(): bool
    {
        return $this->paired;
    }

    public function setPaired(bool $paired): self
    {
        $this->paired = $paired;

        return $this;
    }

    public function isHideOnNextLoad(): bool
    {
        return $this->hideOnNextLoad;
    }

    public function setHideOnNextLoad(bool $hideOnNextLoad): self
    {
        $this->hideOnNextLoad = $hideOnNextLoad;

        return $this;
    }
}
