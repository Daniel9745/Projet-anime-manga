<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */

class Uploader {

    private array $extensions = ["jpeg","jpg","png", "pdf"];
    private string $uploadFolder = "cover";
    private RandomStringGenerator $gen;

    public function __construct()
    {
        $this->gen = new RandomStringGenerator();
    }

    /**
     * @param array $files your $_FILES superglobal
     * @param string $uploadField the name of of the type="file" input
     *
     */
    public function upload(array $files, string $uploadField, string $description) : ?Media
    {   
        
        if(isset($files[$uploadField]) && isset($_POST['description']) && isset($_POST['name'])){
            try {
                $file_name = $files[$uploadField]['name'];
                $file_tmp =$files[$uploadField]['tmp_name'];
                $description = $_POST['description'];
                $name = $_POST['name'];

                $tabFileName = explode('.',$file_name);
                $file_ext=strtolower(end($tabFileName));

                $newFileName = $this->gen->generate(8);

                if(in_array($file_ext, $this->extensions) === false){
                    throw new Exception("Bad file extension. Please upload a JPG, PDF or PNG file.");
                }
                else
                {
                    $url = $this->uploadFolder."/".$newFileName.".".$file_ext;
                    move_uploaded_file($file_tmp, $url);
                    return new Media($name, $url, $description);
                }
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                return null;
            }

        }

        return null;
    }


    public function getUploadedImages(): array
    {
        $images = [];
        if ($handle = opendir($this->uploadFolder)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $images[] = $this->uploadFolder . "/" . $entry;
                }
            }
            closedir($handle);
        }
        return $images;
    }
}

