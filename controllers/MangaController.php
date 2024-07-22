<?php

class MangaController extends AbstractController{
    public function __construct()
    {
        parent::__construct();
    }

    public function ShowMangaById(){
        return $this->render("manga.html.twig", []);
    }

    public function ShowMangaList(){

        $mangaMangager = new MangaManager();
        $mangas = $mangaMangager->findAll();
        return $this->render("mangas.html.twig", ['manga' => $mangas]);
    }
}