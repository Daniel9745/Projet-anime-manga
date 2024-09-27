<?php

class CategorieManager extends AbstractManager
{

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {

        $categories = [];

        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $items) {
            $category = new Categories($items["name"]);
            $category->setId($items['id']);
            $categories[] = $category;
        }
        return $categories;
    }



    public function findOne(int $id)
    {
        $query = $this->db->prepare("SELECT * FROM categories WHERE id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $categorie = new Categories($result["name"]);
            $categorie->setId($result['id']);
            return $categorie;
            // dump($categorie);
        }
        return null;
    }

    
    public function findByCategories(int $categorieId): array
    {
        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.* FROM manga
            JOIN mangacategories ON manga.id = mangacategories.manga_id
            JOIN media ON media.id = manga.volume_cover
            JOIN synopsis ON manga.synopsis_id = synopsis.id
        WHERE mangacategories.categories_id = :categorieId");
        $parameters = [
            'categorieId' => $categorieId
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
