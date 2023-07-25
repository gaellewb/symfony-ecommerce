<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/produits', name: 'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }    
    
    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        // Accès accordé uniquement au rôle admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On crée un "nouveau produit"
        $product = new Products();

        // On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request); 
        
        // dump
        // dd($productForm);

        // On vérifie si le formulaire est soumis ET valide
        if($productForm->isSubmitted() && $productForm->isValid()){
            // On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);
            // dd($prix);

        // On stocke    
        $em->persist($product);
        $em->flush();

        // On redirige
        return $this->redirectToRoute('admin_products_index');
        }

        return $this->render('admin/products/add.html.twig',[
            'productForm' => $productForm->createView() 
        ]);
    }    
    
    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $em): Response
    {
        // On vériife si l'utilisateur peut éditer avec le Voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        // On divise le prix par 100
        $prix = $product->getPrice() / 100;
        $product->setPrice($prix);

        // On crée le formulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        // On traite la requête du formulaire
        $productForm->handleRequest($request); 

        // dump
        // dd($productForm);

        // On vérifie si le formulaire est soumis ET valide
        if($productForm->isSubmitted() && $productForm->isValid()){
            // On arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);
            // dd($prix);

        // On stocke    
        $em->persist($product);
        $em->flush();

        // On redirige
        return $this->redirectToRoute('admin_products_index');
        }

        return $this->render('admin/products/edit.html.twig',[
            'productForm' => $productForm->createView() 
        ]);
    }    
    
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        // On vériife si l'utilisateur peut supprimer avec le Voter
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);

        return $this->render('admin/products/index.html.twig');
    }
}