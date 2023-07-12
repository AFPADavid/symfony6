<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Products;
use App\Form\ProductsFormType;

#[Route('/admin/produits', name:'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(): Response {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name:'add')]
    public function add(Request $request, EntityManagerInterface $emInterface): Response {
        
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On créer un nouveau produit
        $product = new Products();

        // On créer le formulaire
        $formProduct = $this->createForm(ProductsFormType::class, $product);

        //On traite la requête du formulaire
        $formProduct->handleRequest($request);

       // On vérifie si le formulaire est soumis est valide
       if($formProduct->isSubmitted() && $formProduct->isValid()){
            // On calcule le prix en centime
            $prix = $product->getPrice()*100;
            $product->setPrice($prix);

            // on enregisqtre en BDD
            $emInterface->persist($product);
            $emInterface->flush();

            // On redirige
            return $this->redirectToRoute('admin_products_index');
       }
        
        return $this->render('admin/products/add.html.twig',
        [
            'formProduct' => $formProduct->createView()
        ]);

        // Autre écriture possiblez du return
        // return $this->renderForm('admin/products/add.html.twig',compact('formProduct'));
        // Le compact revient à écrire ['formProduct'=>$formProduct]


    }

    #[Route('/edition/{id}', name:'edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $emInterface): Response {
        // on vérifie si l'utilisateur peut éditer avec le VOTER
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        // On calcule le prix en centime
        $prix = $product->getPrice()/100;
        $product->setPrice($prix);

         // On créer le formulaire
         $formProduct = $this->createForm(ProductsFormType::class, $product);

         //On traite la requête du formulaire
         $formProduct->handleRequest($request);
 
        // On vérifie si le formulaire est soumis est valide
        if($formProduct->isSubmitted() && $formProduct->isValid()){
 
             // on enregisqtre en BDD
             $emInterface->persist($product);
             $emInterface->flush();
 
             // On redirige
             return $this->redirectToRoute('admin_products_index');
        }
         
         return $this->render('admin/products/edit.html.twig',
         [
             'formProduct' => $formProduct->createView()
         ]);
 
         // Autre écriture possiblez du return
         // return $this->renderForm('admin/products/add.html.twig',compact('formProduct'));
         // Le compact revient à écrire ['formProduct'=>$formProduct]


        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/suppression/{id}', name:'delete')]
    public function delete(Products $product): Response {
        // on vérifie si l'utilisateur peut supprimer avec le VOTER
        $this->denyAccessUnlessGranted('PRODUCT_DELTE', $product);
        return $this->render('admin/products/index.html.twig');
    }
}