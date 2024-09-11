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
        
        $mangaList= $mm->findAll();
        return $this->render("mangas.html.twig", ["mangaList" => $mangaList]);
        
    }
}