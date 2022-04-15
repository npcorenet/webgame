<?php declare(strict_types=1);

namespace App\Model;

class AccountTypeModel
{

    public const ADMIN_ID = 1;
    public const MODERATOR_ID = 2;
    public const USER_ID = 3;

    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

}