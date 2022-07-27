<?php

namespace App\Controller\Admin;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(Request $request ,ManagerRegistry $manager): Response
    {
        $categories=$manager->getRepository(Category::class)->findAll();
       // $entityManager = $manager->getManager();
       /*$category = new Category();
       $form=$this->createForm(CategoryType::class,$category);
        //$category->setNom('Fruits');
        
        //$entityManager->persist( $category);
        //$entityManager->flush();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager=$manager->getManager();
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('app_welcome');
        }*/



        return $this->render('admin/category/index.html.twig', [
            'categories'=>$categories,
            //'form'=>$form->createView()
        ]);
    
    }

    #[Route('/admin/category/new', name: 'app_admin_category_new')]
    public function new(Request $request ,ManagerRegistry $manager ): Response
    {
        $category = new Category();
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager=$manager->getManager();
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_category');
        }   
        return $this->render('admin/category/new.html.twig',[
            'form'=>$form->createView()
        ]);
    } 

    #[Route('/admin/category/{id}/delete', name: 'app_admin_category_delete')]
    public function delete(Category $category, ManagerRegistry $manager){
        $entityManager=$manager->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_category'); 
        
    }
    #[Route('/admin/category/{id}/edit', name: 'app_admin_category_edit')]
    public function edit(Request $request ,ManagerRegistry $manager, Category $category ): Response
    {
        
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager=$manager->getManager();
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin_category');
        }   
        return $this->render('admin/category/new.html.twig',[
            'form'=>$form->createView()
        ]);
    } 
}
