<?php

class Anime{
    private ?int $id;

    public function __construct(private string $name, private string $synopsis, private Categories $categories_id, private int $poster)
    {
        
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
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

    public function getSynopsis(): string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    public function getCategoriesId(): Categories
    {
        return $this->categories_id;
    }

    public function setCategoriesId(Categories $categories_id): void
    {
        $this->categories_id = $categories_id;
    }

    public function getPoster(): int
    {
        return $this->poster;
    }

    public function setPoster(int $poster): void
    {
        $this->poster = $poster;
    }
}