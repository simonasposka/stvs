<?php

namespace App\DTOs;

abstract class AbstractDTO
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
