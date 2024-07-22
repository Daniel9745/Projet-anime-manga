<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Router
{
    private DefaultController $dc;
    private AnimeController $ac;
    private MangaController $mc;
    private UploadController $uc;

    public function handleRequest(array $get) : void
    {
        $this->dc = new DefaultController();
        $this->ac = new AnimeController();
        $this->mc = new MangaController();
        $this->uc = new UploadController();

        

        if(!isset($get["route"]))
        {
            $this->dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "anime")
        {
            $this->ac->ShowAnime();
        }
        else if(isset($get["route"]) && $get["route"] === "anime_id")
        {
            $this->ac->ShowAnimeById();
        }
        else if(isset($get["route"]) && $get["route"] === "manga")
        {
            $this->mc->ShowMangaList();
        }
        else if(isset($get["route"]) && $get["route"] === "manga_id")
        {
            $this->mc->ShowMangaById();
        }
        else if(isset($get["route"]) && $get["route"] === "inscription"){
            $this->dc->register();
        }
        else if(isset($get["route"]) && $get["route"] === "connexion"){
            $this->dc->login();
        }
        else if(isset($get["route"]) && $get["route"] === "upload"){
            $this->uc->upload();
        }

    }
}