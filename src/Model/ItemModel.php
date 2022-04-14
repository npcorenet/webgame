<?php

namespace App\Model;

class ItemModel
{

    private int $id;
    private string $title;
    private string $description;
    private string $iconUrl;
    private int $itemType;
    private int $statPoint;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }

    public function setIconUrl(string $iconUrl): void
    {
        $this->iconUrl = $iconUrl;
    }

    public function getItemType(): int
    {
        return $this->itemType;
    }

    public function setItemType(int $itemType): void
    {
        $this->itemType = $itemType;
    }

    public function getStatPoint(): int
    {
        return $this->statPoint;
    }

    public function setStatPoint(int $statPoint): void
    {
        $this->statPoint = $statPoint;
    }



}