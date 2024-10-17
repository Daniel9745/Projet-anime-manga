<?php

class OtherManga
{
    private ?int $id;

    public function __construct(private string $manga_name)
    {
    }
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getMangaName(): string {
        return $this->manga_name;
    }

    public function setMangaName(string $manga_name): void {
        $this->manga_name = $manga_name;
    }
}