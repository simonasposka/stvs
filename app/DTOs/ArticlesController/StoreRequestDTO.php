<?php

namespace App\DTOs\ArticlesController;

use App\DTOs\AbstractDTO;

class StoreRequestDTO extends AbstractDTO
{
    protected int $teamId;
    protected int $userId;
    protected string $title;
    protected string $text;

    public function __construct(
        int $teamId,
        int $userId,
        string $title,
        string $text
    ) {
        $this->setTeamId($teamId);
        $this->setUserId($userId);
        $this->setTitle($title);
        $this->setText($text);
    }

    private function setTeamId(int $teamId): void
    {
        $this->teamId = $teamId;
    }

    private function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    private function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getTeamId(): int
    {
        return $this->teamId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
