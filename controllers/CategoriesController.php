<?php

class CategoriesController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function categorieById(int $categorieId)
    {
        $cm = new CategorieManager();

        $mm = new MangaManager();
        $mangas = $mm->mangaByCategories($categorieId);
        $category = $cm->findOne($categorieId);

        return $this->render('categorieManga.html.twig', ['category' => $category, 'mangas' => $mangas]);
    }

    
}
