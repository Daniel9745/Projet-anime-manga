<?php


class CommentController extends AbstractController{

    private CommentsManager $com;
    private UserManager $um;
    private CategorieManager $cm;

    public function __construct()
    {
        parent::__construct();
        
        
    }


    public function checkComment()
    {
        $um = new UserManager();
        $cm = new CategorieManager();
        $com = new CommentsManager();
        
        if (isset($_POST["categorie"]) && isset($_POST["content"]) && isset($_SESSION["user"])){

            dump($_SESSION['user']);

            $userId = $_SESSION['user']->getId();

            $user = $um->findUserById($userId);

            dump($userId);
            
            
            $category = $_POST["categorie"];
            $categorie = $cm->findOne($category);
            
            $content = $_POST["content"];
            dump($content);
            
            $comment = new Comments($content, $user, $categorie);

            dump($comment);

            $commentaire = $com->createComment($comment);
            
        }

    }



}
