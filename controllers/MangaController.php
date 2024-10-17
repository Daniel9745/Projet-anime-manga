<?php

class MangaController extends AbstractController{

    public function __construct()
    {
        parent::__construct();

    }

    public function ShowMangaById(string $mangaId)
    {
        $mm = new MangaManager();
        
        $mangas= $mm->findOne(intval($mangaId));
        
        return $this->render("manga.html.twig", ["mangas" => $mangas]);
    }
    
    public function ShowMangaList(){
        $mm = new MangaManager();
        $cm = new CategorieManager();
        $com = new CommentsManager();
    
        
        /****************************************Pagination Manga***********************/
     
        $currentPage = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $parPage = 9;
        $nb_manga = $mm->countManga();

        $pagesManga = ceil($nb_manga / $parPage);

        $premier = ($currentPage -1) * $parPage;

        /********************************* Pagination Commentaire*************************/
        if (isset($_GET["pageComment"]) && !empty($_GET["pageComment"])) {

            $currentPageComment = (int) strip_tags($_GET["pageComment"]);

        } else {
            $currentPageComment = 1;
        }
    
        if ($currentPageComment < 1) {
            
            $currentPageComment = 1;
        }
        $nb_comment = $com->countComment();
        $parPageComment = 4;
        $pagesComment = ceil($nb_comment / $parPageComment);
        $premierPageComment = ($currentPageComment * $parPageComment) - $parPageComment;
        if ($premierPageComment < 0) {
            $premierPageComment = 0;
        }
        /************************************fin*******************************************/

        $mangaList = $mm->findAll($premier, $parPage);
        $comments = $com->findAllComments($premierPageComment, $parPageComment);
        $categories = $cm->findAll();


        return $this->render("mangas.html.twig", ["mangaList" => $mangaList,"categories" => $categories,"comments" => $comments,"pagesManga" => $pagesManga,"pagesComment" => $pagesComment,"currentPage" => $currentPage,"currentPageComment" => $currentPageComment]);
    }
    
    public function mangaById(int $mangaId){
        $mm = new MangaManager();
 
        $manga= $mm->findOne($mangaId);

        return $this->render("mangaCategorieID.html.twig", ["manga" => $manga]);
    }




    public function searchManga()
    {
        if ($this->isAjaxRequest()) {
    
            ob_start();  // Démarrez le tampon de sortie dès le début
    
            $query = $_GET['search'] ?? '';
    
            $mm = new MangaManager();
            $search = $mm->searchMangaAjax($query);

            if ($search) {
                $dataValue = array_map(function($search) {
                    return [
                        'id' => $search->getId(),
                        'name' => htmlspecialchars($search->getName(), ENT_QUOTES, 'UTF-8'),
                        'volumeCover' => [
                            'url' => htmlspecialchars($search->getVolumeCover()->getUrl(), ENT_QUOTES, 'UTF-8'),
                            'alt' => htmlspecialchars($search->getVolumeCover()->getAlt(), ENT_QUOTES, 'UTF-8')
                        ]
                    ];
                }, $search);
    
                // header('Content-Type: application/json');
                echo json_encode($dataValue);
            } else {
                echo json_encode([]);  // JSON vide si aucun résultat
            }
    
            ob_end_flush(); // Vide le tampon de sortie et envoie les en-têtes
            exit;
        }
    }
    


}