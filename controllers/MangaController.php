<?php

class MangaController extends AbstractController{

    public function __construct()
    {
        parent::__construct();

    }

    public function ShowMangaById(string $mangaId){
        $mm = new MangaManager();
        
        $mangas= $mm->findOne(intval($mangaId));
        
        return $this->render("manga.html.twig", ["mangas" => $mangas]);
    }
    
    public function ShowMangaList(){
        $mm = new MangaManager();
        $cm = new CategorieManager();
        $com = new CommentsManager();

        // $comments = $com->findallComments();

        // print_r($comments);

        // die;


        $com = new CommentsManager();

        $comments = $com->findAllComments();
        // dump($comments);

        $categories = $cm ->findAll();
        
        $mangaList= $mm->findAll();

        
        return $this->render("mangas.html.twig", ["mangaList" => $mangaList, "categories" => $categories, "comments" => $comments]);
        
    }
    
    public function mangaById(int $mangaId){
        $mm = new MangaManager();
 
        $manga= $mm->findOne($mangaId);

        // dump($manga);
        // die;
        return $this->render("mangaCategorieID.html.twig", ["manga" => $manga]);
    }
}