<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use App\Entity\Categories;

#[Route('/categories', name: 'categories_')]

class CategoriesController extends AbstractController
{
    
    #[Route('/{id}', name: 'liste')]
    #[ParamConverter('categorie', class: 'App\Entity\Categories')]

    public function details(Categories $category): Response
    {
        // On va chercher la liste des produits de la catégorie
        $produitDeLaliste = $category->getProducts();
        return $this->render('categories/list.html.twig',compact('category',
       'produitDeLaliste'));
        /*
        Syntax alternative
         return $this->render('categories/list.html.twig',[
            'category'=>$category
             'produitDeLaliste'=>$produitDeLaliste
        ]);
        */
    }
}
