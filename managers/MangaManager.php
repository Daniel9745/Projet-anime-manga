<?php

class MangaManager extends AbstractManager
{
    private CategorieManager $cm;

    public function __construct()
    {
        parent::__construct();
        $this->cm = new CategorieManager();
    }

    
    public function findOne(int $id)
    {
        $pm = new PublisherManager();
        $am = new AuthorManager();

        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt FROM manga
            JOIN media ON media.id = manga.volume_cover
            JOIN synopsis ON manga.synopsis_id = synopsis.id WHERE manga.id = :id");
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $media = new Media($result["name"], $result["url"], $result["alt"]);
            $synopsis = new Synopsis($result["content"]);
            $author = $am->findAuthor($result["author_id"]);
            $publisher = $pm->findPublisher($result["publisher"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $result["date_of_publication"]);

            $mangaId = new Manga($result["name"], $synopsis, $author, $publisher, $media, $result["comments_id"], $result["page_count"], $date);
            $mangaId->setId($result["id"]);
            return $mangaId;
        }
        return null;
    }

    public function findAll(): array
    {

        $am = new AuthorManager();
        $pm = new PublisherManager();

        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt FROM manga
            JOIN media ON media.id = manga.volume_cover
        JOIN synopsis ON manga.synopsis_id =synopsis.id;");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $mangaList = [];

        foreach ($result as $item) {

            $media = new Media($item["name"], $item["url"], $item["alt"]);
            $synopsis = new Synopsis($item["content"]);
            $author = $am->findAuthor($item["author_id"]);
            $publisher = $pm->findPublisher($item["publisher"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $item["date_of_publication"]);

            $manga = new Manga($item["name"], $synopsis, $author, $publisher, $media, $item["comments_id"], $item["page_count"], $date);
            $manga->setId($item["id"]);
            $mangaList[] = $manga;
        }

        return $mangaList;
    }

    public function mangaByCategories(int $categorieId): array
    {
        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt FROM manga
            JOIN mangacategories ON manga.id = mangacategories.manga_id
            JOIN media ON media.id = manga.volume_cover
            JOIN synopsis ON manga.synopsis_id = synopsis.id
            WHERE mangacategories.categories_id = :categorieId");

        $parameters = [
            'categorieId' => $categorieId
        ];

        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $mangas = [];
        $am = new AuthorManager();
        $pm = new PublisherManager();

        foreach ($results as $result) {
            $media = new Media($result["name"], $result["url"], $result["alt"]);
            $synopsis = new Synopsis($result["content"]);
            $author = $am->findAuthor($result["author_id"]);
            $publisher = $pm->findPublisher($result["publisher"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $result["date_of_publication"]);

            $manga = new Manga($result["name"], $synopsis, $author, $publisher, $media, $result["comments_id"], $result["page_count"], $date);
            $manga->setId($result["id"]);

            $mangas[] = $manga;
        }
        // var_dump($results);

        return $mangas;
    }

   public function mangaId(int $mangaId)
   {
       $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.* FROM manga
           JOIN mangacategories ON manga.id = mangacategories.manga_id
           JOIN media ON media.id = manga.volume_cover
           JOIN synopsis ON manga.synopsis_id = synopsis.id
           WHERE manga.id = :mangaId");

       $parameters = [
           'mangaId' => $mangaId
       ];

       $query->execute($parameters);
       $result = $query->fetchAll(PDO::FETCH_ASSOC);

       $mangacate = [];
       $am = new AuthorManager();
       $pm = new PublisherManager();
       if ($result) {
           $media = new Media($result["name"], $result["url"], $result["alt"]);
           $synopsis = new Synopsis($result["content"]);
           $publisher = $pm->findPublisher($result["publisher"]);
           $author = $am->findAuthor($result["author_id"]);
           $date = DateTime::createFromFormat('Y-m-d H:i:s', $result["date_of_publication"]);

           $manga = new Manga($result["name"], $synopsis, $author, $publisher, $media, $result["comments_id"], $result["page_count"], $date);
           $manga->setId($result["id"]);
           return $manga;
        // dump($manga);
       }

       return null;
   }

}
