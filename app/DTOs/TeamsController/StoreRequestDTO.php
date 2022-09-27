<?php

namespace App\DTOs\TeamsController;

use App\DTOs\AbstractDTO;

class StoreRequestDTO extends AbstractDTO
{
    protected int $userId;
    protected string $title;
    protected string $description;

    public function __construct(
        int $userId,
        string $title,
        string $description
    ) {
        $this->setUserId($userId);
        $this->setTitle($title);
        $this->setDescription($description);
    }

    private function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    private function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUserId(): int
    {
        return $this->userId;
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
