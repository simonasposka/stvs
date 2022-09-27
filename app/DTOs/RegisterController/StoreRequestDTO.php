<?php

namespace App\DTOs\RegisterController;

use App\DTOs\AbstractDTO;

class StoreRequestDTO extends AbstractDTO
{
    protected $name;
    protected $email;
    protected $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);
    }

    private function setName(string $name): void
    {
        $this->name = $name;
    }

    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    private function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
