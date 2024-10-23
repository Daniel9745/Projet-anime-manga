<?php
require "vendor/autoload.php";
session_start();


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();

$router->handleRequest($_GET);

if(isset($_SESSION['role']) && $_SESSION['role'] = 'ADMIN'){
    $sessionRole = $_SESSION['role'] ;
}


if(isset($_POST["formName"]) && isset($_POST['description']))
{
    $description = $_POST['description'];
    $uploader = new Uploader();
    $media = $uploader->upload($_FILES, "image", $description);
    var_dump($media);
}


