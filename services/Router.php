<?php

class Router
{
    private DefaultController $dc;
    private AuthController $ac;
    private AdminController $adc;
    private AnimeController $anc;
    private MangaController $mc;
    private UploadController $upc;
    private UserController $uc;

    public function __construct()
    {
        $this->dc = new DefaultController();
        $this->ac = new AuthController();
        $this->anc = new AnimeController();
        $this->mc = new MangaController();
        $this->upc = new UploadController();
        $this->adc = new AdminController();
        $this->uc = new UserController();
        
    }
    public function handleRequest(array $get) : void
    {

        if(!isset($get["route"]))
        {
            $this->dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "inscription"){
            $this->ac->register();
        }
        else if (isset($get["route"]) && $get["route"] === "check-inscription") 
        {
            $this->ac->checkRegister();
        } 
        else if(isset($get["route"]) && $get["route"] === "connexion"){
            $this->ac->login();
        }
        else if (isset($get["route"]) && $get["route"] === "check-connexion") 
        {
            $this->ac->checkLogin();
        }
        else if (isset($get["route"]) && $get["route"] === "deconnexion") 
        {
            $this->ac->logout();
        } 
        else if(isset($get["route"]) && $get["route"] === "upload"){
            $this->upc->upload();
        }
        else if (isset($get["route"]) && $get["route"] === "admin") 
        {

            $this->adc->homePage();
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-connexion") 
        {
            $this->adc->login();
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-check-connexion") 
        {
            $this->adc->checkLogin();
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-create-user") 
        {

            $this->uc->create();
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-check-create-user") 
        {

            $this->uc->checkCreate();
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-edit-user" && isset($_GET["user_id"])) 
        {

            $this->uc->edit(intval($_GET["user_id"]));
        } 
        else if (isset($get["route"]) && $get["route"] == "admin-chek-edit-user" && isset($_GET["user_id"])) 
        {

            $this->uc->checkEdit(intval($_GET["user_id"]));
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-delete-user" && isset($_GET["user_id"])) 
        {

            $this->uc->delete(intval($_GET["user_id"]));
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-list-users") 
        {

            $this->uc->list();
        } 
        else if (isset($get["route"]) && $get["route"] === "admin-show-user" && isset($_GET["user_id"])) 
        {

            $this->uc->show(intval($_GET["user_id"]));
        }
        else if(isset($get["route"]) && $get["route"] === "anime")
        {
            $this->anc->ShowAnime();
        }
        else if(isset($get["route"]) && $get["route"] === "anime_id")
        {
            $this->anc->ShowAnimeById();
        }
        else if(isset($get["route"]) && $get["route"] === "manga")
        {
            $this->mc->ShowMangaList();
        }
        else if (isset($get["route"]) && $get["route"] === "manga_id" && isset($get["id"])) 
        {
            $this->mc->ShowMangaById($get["id"]);
        }else
        {
            // le code si c'est aucun des cas précédents ( === page 404)
            $this->dc->notFound();
        }

        
    }
    
    // private function checkAdminAccess(): void
    // {
    //     if(isset($_SESSION['user']) 
    //         && isset($_SESSION['role']) && $_SESSION['role'] === "ADMIN")
    //         {
    //             // c'est bon
    //             $this->adc->homePage();
    //         }
    //         else
    //         {
    //                  // c'est pas bon : redirection avec un header('Location:')
    //                  $this->redirect("admin-connexion");
    //         }
    // }
    
    // protected function redirect(? string $route) : void 
    // {
    //     if($route !== null)
    //     {
    //         header("Location: index.php?route=$route");
    //     }
    //     else
    //     {
    //         header("Location: index.php");
    //     }
    //     exit();
    // } 
}