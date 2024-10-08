<?php


class CommentsManager extends AbstractManager{
   private Comments $com;
    private UserManager $um;
    public function __construct(){
        parent::__construct();

    }

    public function createComment(Comments $comments): Comments
    {
 
        $query = $this->db->prepare('INSERT INTO comments (id, content, user_id, categories_id, created_at) VALUES (NULL, :content, :user_id, :categories_id, :created_at)');
        $parameters = [
            "content" => $comments->getContent(),
            "user_id" => $comments->getUserId()->getId(),
            "categories_id" => $comments->getCategoriesId()->getId(),
            "created_at" => (new DateTime())->format('Y-m-d H:i:s')
        ];
        $query->execute($parameters);
        // $result = $query->fetch(PDO::FETCH_ASSOC);

        $comments->setId($this->db->lastInsertId());
        // dump($comments);
        return $comments;

    }

    public function findComments(int $id){
        $query = $this->db->prepare('SELECT comments.*, users.username, categories.name FROM comments
        JOIN users ON comments.user_id = users.id
        JOIN categories ON comments.categories_id = categories.id
        WHERE comments.id = :id');
        
        $parameters = [
            "id" => $id
        ];

        $query->execute($prameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result){
            $users = new User($result["username"], $result["email"], $result["password"], $result["role"]);
            $categorie = new Categories($result["name"]);
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $result["date_of_publication"]);
            $commentId = new Comments($result["content"], $users, $categorie, $date);
            $commentId->setId($result["id"]);
            return $commentId;
        }
        return null;
    }


    public function findAllComments(int $premierPageComment, int $parPageComment){

        $query = $this->db->prepare('SELECT comments.*, users.*, categories.name FROM comments
        JOIN users ON comments.user_id = users.id
        JOIN categories ON comments.categories_id = categories.id
        ORDER BY created_at DESC LIMIT :premierPageComment, :parPageComment');

        $query->bindValue(":premierPageComment", $premierPageComment, PDO::PARAM_INT);
        $query->bindValue(":parPageComment", $parPageComment, PDO::PARAM_INT);

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $commentaire = [];

        if($result){
            foreach($result as $item){

                // dump($item);
                $users = new User($item["username"], $item["email"], $item["password"], $item["role"]);
                // die;
                $categorie = new Categories($item["name"]);
                // $date = DateTime::createFromFormat('Y-m-d H:i:s', $item["date_of_publication"]);
                $comments = new Comments($item["content"], $users, $categorie);
                $comments->setId($item["id"]);
                $commentaire[] = $comments;
            }
        }
        return $commentaire;
    }


    public function countComment(){

        $query = $this->db->prepare("SELECT COUNT(*) AS nb_comment FROM comments
            LEFT JOIN users ON comments.user_id = users.id
            LEFT JOIN categories ON comments.categories_id = categories.id");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
    
            return (int) $result['nb_comment'];

            // dump($result["nb_comment"]);
       }
}