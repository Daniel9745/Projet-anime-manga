<?php

class DefaultController extends AbstractController
{
    public function __construct(){
        parent::__construct();
    }

    public function home(): void
    {
        $isUserLoggedIn = isset($_SESSION['user']);
        $sessionRole = null;
        
        if(isset($_SESSION['role']) && $_SESSION['role'] = 'ADMIN'){

            $sessionRole = $_SESSION['role'] ;
        }

        $this->render('front/home.html.twig', ['isUserLoggedIn' => $isUserLoggedIn, 'sessionRole' => $sessionRole]); 
    }

    public function notFound() : void
    {
        $this->render('front/error404.html.twig', []);
    }
}
