<?php

class DefaultController extends AbstractController
{
    public function __construct(){
        parent::__construct();
    }

    public function home(): void
    {
        $isUserLoggedIn = isset($_SESSION['user']);


        $this->render('front/home.html.twig', ['isUserLoggedIn' => $isUserLoggedIn]);  // modif de deco
    }

    public function notFound() : void
    {
        $this->render('front/error404.html.twig', []);
    }
}
