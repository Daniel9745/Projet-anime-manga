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

        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt, othermanga.* FROM manga
            JOIN media ON media.id = manga.volume_cover
            JOIN synopsis ON manga.synopsis_id = synopsis.id
            JOIN othermanga ON othermanga.othermanga_id = manga.otherManga
            WHERE manga.id = :id");
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
            $othermanga = new OtherManga($result["manga_name"]);

            $mangaId = new Manga($result["name"], $synopsis, $author, $publisher, $media, $result["page_count"], $othermanga, $date);
            $mangaId->setId($result["id"]);
            return $mangaId;
        }
        return null;
    }

    // public function findAll(int $premier, int $parPage): array
    // {
    //     $am = new AuthorManager();
    //     $pm = new PublisherManager();
        
    //     // Modifier le JOIN en LEFT JOIN pour inclure tous les mangas
    //     $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt, othermanga.*
    //         FROM manga
    //         JOIN media ON media.id = manga.volume_cover
    //         JOIN synopsis ON manga.synopsis_id = synopsis.id
    //         JOIN othermanga ON othermanga.othermanga_id = manga.othermanga
    //         ORDER BY date_of_publication DESC LIMIT :premier, :parPage");
    
    //     $query->bindValue(":premier", $premier, PDO::PARAM_INT);
    //     $query->bindValue(":parPage", $parPage, PDO::PARAM_INT);
    
    //     $query->execute();
    //     $result = $query->fetchAll(PDO::FETCH_ASSOC);
    //     $mangaList = [];
        
    //     foreach ($result as $item) {
    //         $media = new Media($item["name"], $item["url"], $item["alt"]);
    //         $synopsis = new Synopsis($item["content"]);
    //         $author = $am->findAuthor($item["author_id"]);
    //         $publisher = $pm->findPublisher($item["publisher"]);
    //         $date = DateTime::createFromFormat('Y-m-d H:i:s', $item["date_of_publication"]);
            
    //         // Vérifier si 'manga_name' existe dans $item avant d'instancier OtherManga
    //         $othermanga = new OtherManga($item["manga_name"]);
    
    //         $manga = new Manga($item["name"], $synopsis, $author, $publisher, $media, $item["page_count"], $othermanga, $date);
    //         $manga->setId($item["id"]);
    //         $mangaList[] = $manga;
    //     }
    
    //     return $mangaList;
    // }


    public function findAll(): array
    {
        $am = new AuthorManager();
        $pm = new PublisherManager();
        
        // Modifier le JOIN en LEFT JOIN pour inclure tous les mangas
        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt, othermanga.*
            FROM manga
            JOIN media ON media.id = manga.volume_cover
            JOIN synopsis ON manga.synopsis_id = synopsis.id
            JOIN othermanga ON othermanga.othermanga_id = manga.othermanga
            ORDER BY date_of_publication DESC");
    

    
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $mangaList = [];
        
        foreach ($result as $item) {
            $media = new Media($item["name"], $item["url"], $item["alt"]);
            $synopsis = new Synopsis($item["content"]);
            $author = $am->findAuthor($item["author_id"]);
            $publisher = $pm->findPublisher($item["publisher"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $item["date_of_publication"]);
            
            // Vérifier si 'manga_name' existe dans $item avant d'instancier OtherManga
            $othermanga = new OtherManga($item["manga_name"]);
    
            $manga = new Manga($item["name"], $synopsis, $author, $publisher, $media, $item["page_count"], $othermanga, $date);
            $manga->setId($item["id"]);
            $mangaList[] = $manga;
        }
    
        return $mangaList;
    }
    public function mangaByCategories(int $categorieId): array
    {
        $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt, othermanga.* FROM manga
            JOIN mangacategories ON manga.id = mangacategories.manga_id
            JOIN media ON media.id = manga.volume_cover
            JOIN synopsis ON manga.synopsis_id = synopsis.id
            JOIN othermanga ON othermanga.othermanga_id = manga.otherManga
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
            $othermanga = new OtherManga($result["manga_name"]);

            $manga = new Manga($result["name"], $synopsis, $author, $publisher, $media, $result["page_count"], $othermanga, $date);
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
           JOIN othermanga ON othermanga.othermanga_id = manga.otherManga
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
           $othermanga = new OtherManga($item["manga_name"]);

           $manga = new Manga($item["name"], $synopsis, $author, $publisher, $media, $item["page_count"], $othermanga, $date);
           $manga->setId($result["id"]);
           return $manga;
        // dump($manga);
       }

       return null;
   }


   public function countManga()
   {

    $query = $this->db->prepare("SELECT COUNT(*) AS nb_manga FROM manga");
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return (int) $result['nb_manga'];
   }


   public function searchMangaAjax(string $search): array
   {
       $am = new AuthorManager();
       $pm = new PublisherManager();
   
       // Préparation de la requête SQL
       $query = $this->db->prepare("SELECT manga.*, synopsis.content, media.name, media.url, media.alt, othermanga.* FROM manga
           JOIN media ON media.id = manga.volume_cover
           JOIN synopsis ON manga.synopsis_id = synopsis.id 
           JOIN othermanga ON othermanga.othermanga_id = manga.otherManga
           WHERE manga.name LIKE :search
       ");
   
       $parameters = [
           'search' => $search . '%'
       ];
       
       // Exécution de la requête
       $query->execute($parameters);
       $result = $query->fetchAll(PDO::FETCH_ASSOC);
   
       $mangaPage = [];
   
       foreach ($result as $item) {
           // Récupération des objets associés
           $media = new Media($item["name"], $item["url"], $item["alt"]);
           $synopsis = new Synopsis($item["content"]);
           $author = $am->findAuthor($item["author_id"]);
           $publisher = $pm->findPublisher($item["publisher"]);
           $date = DateTime::createFromFormat('Y-m-d H:i:s', $item["date_of_publication"]);
           $othermanga = new OtherManga($item["manga_name"]);

           $mangaSearch = new Manga($item["name"], $synopsis, $author, $publisher, $media, $item["page_count"], $othermanga, $date);
           
           $mangaSearch->setId($item["id"]);
           $mangaPage[] = $mangaSearch;
       }
   
       return $mangaPage;
   }

    
}