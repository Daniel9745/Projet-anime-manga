<?php

class AnimeController extends AbstractController{

    public function ShowAnime(){
        
        return $this->render("animes.html.twig", []);
    }

    public function ShowAnimeById(){
        return $this->render("anime.html.twig", []);
    }
}