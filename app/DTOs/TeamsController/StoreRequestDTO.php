<?php

namespace App\DTOs\TeamsController;

use App\DTOs\AbstractDTO;

class StoreRequestDTO extends AbstractDTO
{
    protected string $title;
    protected string $description;

    public function __construct(
        string $title,
        string $description
    ) {
        $this->setTitle($title);
        $this->setDescription($description);
    }

    private function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
