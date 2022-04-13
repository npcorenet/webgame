<?php

namespace App\Model;

use DateTime;

class AccountModel
{

    private int $id;
    private string $email;
    private string $username;
    private string $password;
    private DateTime $registered;
    private int $type;
    private int $coins;

    private int $diamonds;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRegistered(): DateTime
    {
        return $this->registered;
    }

    public function setRegistered(DateTime $registered): void
    {
        $this->registered = $registered;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): void
    {
        $this->coins = $coins;
    }

    public function getDiamonds(): int
    {
        return $this->diamonds;
    }

    public function setDiamonds(int $diamonds): void
    {
        $this->diamonds = $diamonds;
    }

}