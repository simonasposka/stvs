<?php

namespace App\DTOs\TeamUsersController;

use App\DTOs\AbstractDTO;

class UpdateRequestDTO extends AbstractDTO
{
    protected int $userId;

    public function __construct(
        int $userId,
    ) {
        $this->setUserId($userId);
    }

    private function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
