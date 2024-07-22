<?php

class UploadController extends AbstractController
{

    public function upload()
    {
        if (isset($_POST["formName"]) && isset($_POST['description'])) {

            $description = $_POST['description'];

            $uploader = new Uploader();

            $media = $uploader->upload($_FILES, "image", $description);

            var_dump($media);

            $manager = new MediaManager();
            
            $manager->uploadOne($media);
        }
        else{
            return $this->render("upload.html.twig", []);
        }
    }
}
