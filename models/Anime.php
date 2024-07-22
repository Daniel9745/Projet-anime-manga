<?php

class Anime{
    private ?int $id;

    public function __construct(private string $name, private Synopsis $synopsis_id, private Author $author_id, private string $studio_d_animation, private Comments $comment, private Categories $categories_id, private Media $poster)
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

    public function getSynopsisId(): Synopsis
    {
        return $this->synopsis_id;
    }

    public function setSynopsisId(Synopsis $synopsis_id): void
    {
        $this->synopsis_id = $synopsis_id;
    }

    public function getAuthorId(): Author
    {
        return $this->author_id;
    }

    public function setAuthorId(Author $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getStudioDAnimation(): string
    {
        return $this->studio_d_animation;
    }

    public function setStudioDAnimation(string $studio_d_animation): void
    {
        $this->studio_d_animation = $studio_d_animation;
    }

    public function getComment(): Comments
    {
        return $this->comment;
    }

    public function setComment(Comments $comment): void
    {
        $this->comment = $comment;
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
}