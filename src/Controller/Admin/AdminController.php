<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(ManagerRegistry $manager): Response
    {
        $users=$manager->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig', [
          'Users'=>$users
        ]);
    }

    #[Route('/admin/newuser', name: 'app_admin_newuser')] 
    public function adduser(Request $request, ManagerRegistry $manager){
        $user=new User;
        $formuser=$this->createForm(UserType::class, $user);
        $formuser->handleRequest($request);
        if($formuser->isSubmitted() && $formuser->isValid()){
            $entityManager=$manager->getManager();
            $user=$formuser->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/newuser.html.twig',[
            'formuser'=>$formuser->createView()
        ]);
       
    }

    #[Route('/admin/{id}/delete', name: 'app_admin_delete')] 
    public function removeuser(User $user, ManagerRegistry $manager){
        $entityManager=$manager->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/{id}/update', name: 'app_admin_update')] 
    public function updateuser(User $user, Request $request, ManagerRegistry $manager)
    {
        $formuser=$this->createForm(UserType::class, $user);
        $formuser->handleRequest($request);
        if($formuser->isSubmitted() && $formuser->isValid()){
            $entityManager=$manager->getManager();
            $user=$formuser->getData();

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
        }
        return $this->render('admin/newuser.html.twig',[
            'formuser'=>$formuser->createView()
        ]);
    }
}
