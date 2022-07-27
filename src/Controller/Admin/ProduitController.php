<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Form\ProduitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    #[Route('/produit', name: 'app_produit')]
    public function index(ManagerRegistry $manager): Response
    {
        $protuits=$manager->getRepository(Produit::class)->findAll();
       
       
        
        return $this->render('produit/index.html.twig', [
            'produits' =>$protuits ,
        ]);
    }
    #[Route('/produit/new', name: 'app_produit_new')]
    public function addproduct(Request $request, ManagerRegistry $manager): Response
    {
        $produit=new Produit;
        $formproduit=$this->createForm(ProduitType::class, $produit);
        $formproduit->handleRequest($request);

        if($formproduit->isSubmitted() && $formproduit->isValid()){
            $entityManager=$manager->getManager();
            $produit = $formproduit->getData();
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_produit');
        }   
        return $this->render('produit/new.html.twig',[
            'formproduit'=>$formproduit->createView()
        ]);
        
       
        
       
    }
    
    #[Route('/produit/{id}/delete', name: 'app_produit_delete')]
    public function delete(Produit $produit, ManagerRegistry $manager){
        $entityManager=$manager->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();
        return $this->redirectToRoute('app_produit');
    }
    #[Route('/produit/{id}/edit', name: 'app_produit_edit')]
    public function update(Produit $produit, ManagerRegistry $manager,Request $request){

        $form=$this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$manager->getManager();
            $produit=$form->getData();

            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('app_produit');
        }
        return $this->render('produit/new.html.twig',[
            'formproduit'=>$form->createView()
        ]);
        
    }
}
