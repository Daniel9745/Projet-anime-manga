<?php


class PublisherManager extends AbstractManager{
    public function __construct()
    {
        parent::__construct();
    }

    
    public function findPublisher(int $id): ? Publisher{
        $query= $this->db->prepare('SELECT * FROM publisher WHERE id = :id ');
        $parameters = [
            "id" =>$id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $publisher = new Publisher($result["publisher"]);
            $publisher->setID($result["id"]);

            return $publisher;
        }
        return null;
    }
}