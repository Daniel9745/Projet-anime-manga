<?php
    class MangaCategories{
        
        public function __construct(private int $categories_id, private int $manga_id)
    {
    }
    public function getCategoriesId(): int
    {
        return $this->categories_id;
    }

    // Setter pour $categories_id
    public function setCategoriesId(int $categories_id): void
    {
        $this->categories_id = $categories_id;
    }

    // Getter pour $manga_id
    public function getMangaId(): int
    {
        return $this->manga_id;
    }

    // Setter pour $manga_id
    public function setMangaId(int $manga_id): void
    {
        $this->manga_id = $manga_id;
    }
    public function __toString(): string {
        return "Category ID: " . $this->categories_id . ", Manga ID: " . $this->manga_id;
    }

    }
?>