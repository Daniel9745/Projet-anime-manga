<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class Router
{
    public function handleRequest(array $get) : void
    {

        if(!isset($get["route"]))
        {
            // $dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "anime")
        {
            echo"<h1>Je suis une page anime</h1>";
        }
        else if(isset($get["route"]) && $get["route"] === "manga")
        {
            echo "<h1>Je suis une page manga</h1>";
        }
        else if(isset($get["route"]) && $get["route"] === "inscription"){
            echo"<h1>Je suis une page inscription</h1>";
        }
        else if(isset($get["route"]) && $get["route"] === "connexion"){
            echo"<h1>Je suis une page connexion</h1>";
        }
    }
}