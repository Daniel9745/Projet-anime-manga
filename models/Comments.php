<?php

class Comments{
    private ?int $id;

    public function __construct(private string $content, private User $user_id, private Categories $categories_id)
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getUserId(): User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getCategoriesId(): Categories
    {
        return $this->categories_id;
    }

    public function setCategoriesId(Categories $categories_id): void
    {
        $this->categories_id = $categories_id;
    }
}