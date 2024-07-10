<?php

class Anime{
    private ?int $id;

    public function __construct(private string $name, private string $synopsis_id, private Categories $categories_id, private media $poster, private string $studio, private string $comments)
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

    public function getSynopsisId(): string
    {
        return $this->synopsis_id;
    }

    public function setSynopsisId(string $synopsis_id): void
    {
        $this->synopsis_id = $synopsis_id;
    }

    public function getCategoriesId(): Categories
    {
        return $this->categories_id;
    }

    public function setCategoriesId(Categories $categories_id): void
    {
        $this->categories_id = $categories_id;
    }

    public function getPoster(): Media
    {
        return $this->poster;
    }

    public function setPoster(Media $poster): void
    {
        $this->poster = $poster;
    }

    public function getStudioId(): string
    {
        return $this->studio;
    }

    public function setStudioId(string $studio): void
    {
        $this->studio = $studio;
    }

    public function getComments(): string
    {
        return $this->comments;
    }

    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }
}