<?php

use LDAP\Result;

class AnimeManager extends AbstractManager{

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array{
        
        $query= $this->db->prepare("SELECT categories.*, anime.* FROM categories
        JOIN anime_categories ON anime_categories.categories_id = categories.id
        JOIN anime ON anime_categories.anime_id = anime.id");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $animeList = [];

        foreach($result as $item){

            $media = new Media($item["name"], $item["url"], $item["alt"]);
            $anime = new anime($item["name"], $item["synopsis"], $item["author_id"], $item["studio_d_animation"], $item["comment"], $item["categories_id"], $item[$media]);
            $anime->setId($item["id"]);
            $animeList[] = $anime;
        }
        return $animeList;
    }
}
