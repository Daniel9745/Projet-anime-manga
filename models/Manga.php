<?php

class Manga
{
    private ?int $id;

    public function __construct(private string $name, private Synopsis $synopsis_id, private Author $author_id, private string $publisher, private Media $volume_cover, private ? string $comments_id, private int $page_count, private DateTime $date_of_publication)
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

    public function getPublisher(): string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getVolumeCover(): Media
    {
        return $this->volume_cover;
    }

    public function setVolumeCover(Media $volume_cover): void
    {
        $this->volume_cover = $volume_cover;
    }

    public function getCommentsId(): ?string
    {
        return $this->comments_id;
    }

    public function setCommentsId(?string $comments_id): void
    {
        $this->comments_id = $comments_id;
    }

    public function getPageCount(): int
    {
        return $this->page_count;
    }

    public function setPageCount(int $page_count): void
    {
        $this->page_count = $page_count;
    }

    public function getDateOfPublication(): DateTime
    {
        return $this->date_of_publication;
    }

    public function setDateOfPublication(DateTime $date_of_publication): void
    {
        $this->date_of_publication = $date_of_publication;
    }
}
