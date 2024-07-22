<?php

class CategorieManager extends AbstractManager{

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array{

        $categories = [];

        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $items){
            $category = new Categories($items["name"]);
            $category->setId($items['id']);
            $categories[] = $category;
        }
        return $categories;
    }
}