<?php

class DefaultController extends AbstractController
{
    public function __construct(){
        parent::__construct();
    }

    public function home()
    {
        $categorieManager = new CategorieManager();
        $categories = $categorieManager->findAll();
       return $this->render("home.html.twig", ['categories'=> $categories]);
    }

    public function register(){
        return $this->render("formInscription.html.twig", []);
    }

    public function login(){
        return $this->render("formConnexion.html.twig", []);
    }
    
}
