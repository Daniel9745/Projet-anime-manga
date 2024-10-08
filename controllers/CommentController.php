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
     
            $userId = $_SESSION["user"]->getId(); 

            $user = $um->findUserById($_SESSION["user"]->getId());


            $category = $_POST["categorie"];
            $categorie = $cm->findOne($category);

            $content = $_POST["content"];

            
            $comment = new Comments($content, $user, $categorie);

            $commentaire = $com->createComment($comment);
            
        }

    }



}
