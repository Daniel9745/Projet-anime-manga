<?php


class AuthorManager extends AbstractManager{
    public function __construct()
    {
        parent::__construct();
    }
    public function findAuthor(int $id): ? Author{
        $query= $this->db->prepare('SELECT * FROM authors WHERE id = :id ');
        $parameters = [
            "id" =>$id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $author = new Author($result["name"]);
            $author->setID($result["id"]);

            return $author;
        }
        return null;
    }
}