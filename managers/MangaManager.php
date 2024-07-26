<?php

class MangaManager extends AbstractManager{

    public function __construct()
    {
        parent::__construct();
    }
    public function findOne(int $id){
        $am = new AuthorManager();
        $query=$this->db->prepare('SELECT * FROM manga WHERE id = :id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $media = new Media($result["name"], $result["url"], $result["alt"]);
            $synopsis = new Synopsis($result["content"]);
            $author = $am->findAuthor($result["author_id"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $result["date_of_publication"]);

            $mangaId = new Manga($result["name"], $synopsis, $author, $result["publisher"], $media, $result["comments_id"], $result["page_count"], $date);
            $mangaId->setId($result["id"]);
            return $mangaId;
        }
        return null;
    }

    public function findAll(): array{

        $am = new AuthorManager();
        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt FROM manga
        JOIN media ON media.id = manga.volume_cover
        JOIN synopsis ON manga.synopsis_id =synopsis.id;");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $mangaList = [];

        foreach($result as $item){

            $media = new Media($item["name"], $item["url"], $item["alt"]);
            $synopsis = new Synopsis($item["content"]);
            $author = $am->findAuthor($item["author_id"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $item["date_of_publication"]);

            $manga = new Manga($item["name"], $synopsis, $author, $item["publisher"], $media, $item["comments_id"], $item["page_count"], $date);
            $manga->setId($item["id"]);
            $mangaList[] = $manga;
        }
        dump($mangaList);
        return $mangaList;
    }
}