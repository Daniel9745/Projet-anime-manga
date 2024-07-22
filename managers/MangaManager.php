<?php

class MangaManager extends AbstractManager{

    public function __construct()
    {
        // parent::__construct();
    }

    public function findAll(){
        $query = $this->db->prepare("SELECT manga.*, media.* FROM manga 
        JOIN media ON media.id = manga.volume_cover");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $mangaList = [];

        foreach($result as $item){

            $media = new Media($item["name"], $item["url"], $item["alt"]);
            $manga = new Manga($item["name"], $item["synpsis_id"], $item["author_id"], $item["publisher"], $item["volume_cover"], $item["comments_id"], $item["page_count"], $item["date_of_publication"]);
            $manga->setId($item["id"]);
            $mangalist[] = $manga;
        }
        return $mangaList;
    }
}